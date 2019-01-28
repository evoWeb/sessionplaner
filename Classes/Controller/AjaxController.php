<?php
namespace Evoweb\Sessionplaner\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2019 Sebastian Fischer <typo3@evoweb.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Evoweb\Sessionplaner\Domain\Model\Day;
use Evoweb\Sessionplaner\Domain\Model\Room;
use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Model\Slot;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
     * @var ResponseInterface
     */
    protected $response;

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

        $this->objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $this->configurationManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class
        );
    }

    protected function initializeAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->parameter = $request->getParsedBody()['tx_sessionplaner'];
        $this->response = $response;

        if (!($this->backendUser->isAdmin() || $this->backendUser->modAccess($this->moduleConfiguration, 0))) {
            $this->errorAction();
            return false;
        }

        $configuration = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
        if (empty($configuration['persistence']['storagePid'])) {
            $currentPid['persistence']['storagePid'] = $request->getParsedBody()['id'];
            $this->configurationManager->setConfiguration(array_merge($configuration, $currentPid));
        }
        return true;
    }


    protected function render()
    {
        $this->response->getBody()->write(
            json_encode(
                [
                    'status' => $this->status,
                    'message' => $this->message,
                    'data' => $this->data
                ]
            )
        );
    }


    protected function errorAction()
    {
        $this->status = 'error';
        $this->message = 'No access granted';
    }


    protected function initializeCreateSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class
        );
    }

    public function createSessionAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->initializeAction($request, $response);
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
        $this->render();
        return $response;
    }


    protected function initializeUpdateSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class
        );
        $this->dayRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\DayRepository::class
        );
        $this->roomRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\RoomRepository::class
        );
        $this->slotRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SlotRepository::class
        );
    }

    public function updateSessionAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->initializeAction($request, $response);
        $this->initializeUpdateSessionAction();

        /** @var Session $session */
        $session = $this->sessionRepository->findByUid((int) $this->parameter['session']['uid']);
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
        $this->render();
        return $response;
    }


    protected function initializeDeleteSessionAction()
    {
        $this->sessionRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class
        );
    }

    public function deleteSessionAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->initializeAction($request, $response);
        $this->initializeDeleteSessionAction();

        /** @var Session $session */
        $session = $this->sessionRepository->findByUid((int) $this->parameter['session']['uid']);
        if ($session instanceof Session) {
            $this->sessionRepository->remove($session);

            $this->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' deleted';
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }
        $this->render();
        return $response;
    }


    protected function getSessionFromRequest()
    {
        return $this->objectManager
            ->get(\TYPO3\CMS\Extbase\Property\PropertyMapper::class)
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
        $persistenceManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class
        );
        $persistenceManager->persistAll();
    }
}
