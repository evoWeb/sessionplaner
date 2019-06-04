<?php

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Model\Day;
use Evoweb\Sessionplaner\Domain\Model\Room;
use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Model\Slot;
use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\RoomRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Evoweb\Sessionplaner\Domain\Repository\SlotRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Property\PropertyMapper;

class AjaxController
{
    /**
     * @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected $backendUser;

    /**
     * @var array
     */
    protected $moduleConfiguration;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var array
     */
    protected $parameter = [];

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $sessionRepository;

    /**
     * @var string
     */
    protected $status = 'success';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\DayRepository
     */
    protected $dayRepository;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\RoomRepository
     */
    protected $roomRepository;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SlotRepository
     */
    protected $slotRepository;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->backendUser = $GLOBALS['BE_USER'];
        $this->moduleConfiguration = $GLOBALS['TBE_MODULES']['_configuration']['web_SessionplanerTxSessionplanerM1'];
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationManager = $this->objectManager->get(ConfigurationManager::class);
    }

    protected function initializeAction(ServerRequestInterface $request)
    {
        $this->parameter = $request->getParsedBody()['tx_sessionplaner'];

        if (!($this->backendUser->isAdmin() || $this->backendUser->modAccess($this->moduleConfiguration, 0))) {
            $this->errorAction();
            return false;
        }

        $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        if (empty($configuration['persistence']['storagePid'])) {
            $currentPid['persistence']['storagePid'] = $request->getParsedBody()['id'];
            $this->configurationManager->setConfiguration(array_merge($configuration, $currentPid));
        }
        return true;
    }

    protected function render(): ResponseInterface
    {
        return new \TYPO3\CMS\Core\Http\JsonResponse(
            [
                'status' => $this->status,
                'message' => $this->message,
                'data' => $this->data
            ]
        );
    }

    protected function errorAction()
    {
        $this->status = 'error';
        $this->message = 'No access granted';
    }

    protected function initializeCreateSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(SessionRepository::class);
    }

    public function createSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);
        $this->initializeCreateSessionAction();

        $session = $this->getSessionFromRequest();
        if ($session instanceof Session) {
            $this->sessionRepository->add($session);

            $this->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' saved';
            $this->data = ['uid' => $session->getUid()];
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    protected function initializeUpdateSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(SessionRepository::class);
        $this->dayRepository = $this->objectManager->get(DayRepository::class);
        $this->roomRepository = $this->objectManager->get(RoomRepository::class);
        $this->slotRepository = $this->objectManager->get(SlotRepository::class);
    }

    public function updateSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);
        $this->initializeUpdateSessionAction();

        /** @var Session $session */
        $session = $this->sessionRepository->findByUid((int)$this->parameter['session']['uid']);
        $this->updateSessionFromRequest($session);
        if ($session instanceof Session) {
            $this->sessionRepository->update($session);

            $this->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' updated';
            $this->data = ['uid' => $session->getUid()];
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    protected function initializeDeleteSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(SessionRepository::class);
    }

    public function deleteSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);
        $this->initializeDeleteSessionAction();

        /** @var Session $session */
        $session = $this->sessionRepository->findByUid((int)$this->parameter['session']['uid']);
        if ($session instanceof Session) {
            $this->sessionRepository->remove($session);

            $this->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' deleted';
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    protected function getSessionFromRequest()
    {
        return $this->objectManager
            ->get(PropertyMapper::class)
            ->convert(
                $this->parameter['session'],
                Session::class
            );
    }

    protected function updateSessionFromRequest(Session $session)
    {
        $sessionData = $this->parameter['session'];
        unset($sessionData['uid']);

        foreach ($sessionData as $field => $value) {
            switch (true) {
                // the following lines are needed to move the session back to stash
                case $field == 'room' && $value == 0:
                    $session->setRoom(0);
                    break;

                case $field == 'room':
                    // get room model and set
                    /** @var Room $room */
                    $room = $this->roomRepository->findByUid($value);
                    $session->setRoom($room);
                    break;

                case $field == 'slot' && $value == 0:
                    $session->setSlot(0);
                    break;

                case $field == 'slot':
                    // get slot model and set
                    /** @var Slot $slot */
                    $slot = $this->slotRepository->findByUid($value);
                    $session->setSlot($slot);
                    break;

                case $field == 'day' && $value == 0:
                    $session->setDay(0);
                    break;

                case $field == 'day':
                    // get day model and set
                    /** @var Day $day */
                    $day = $this->dayRepository->findByUid($value);
                    $session->setDay($day);
                    break;

                default:
                    $session->{'set' . GeneralUtility::underscoredToUpperCamelCase($field)}($value);
            }
        }
    }

    protected function persistAll()
    {
        /** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
    }
}
