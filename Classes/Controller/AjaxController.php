<?php

declare(strict_types=1);

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
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

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
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var array
     */
    protected $parameter = [];

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
     * @var SessionRepository
     */
    protected $sessionRepository;

    /**
     * @var DayRepository
     */
    protected $dayRepository;

    /**
     * @var RoomRepository
     */
    protected $roomRepository;

    /**
     * @var SlotRepository
     */
    protected $slotRepository;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    public function __construct(
        ConfigurationManager $configurationManager,
        SessionRepository $sessionRepository,
        DayRepository $dayRepository,
        RoomRepository $roomRepository,
        SlotRepository $slotRepository,
        PersistenceManager $persistenceManager
    ) {
        $this->backendUser = $GLOBALS['BE_USER'];
        $this->moduleConfiguration = $GLOBALS['TBE_MODULES']['_configuration']['web_SessionplanerTxSessionplanerM1'];

        $this->configurationManager = $configurationManager;
        $this->sessionRepository = $sessionRepository;
        $this->dayRepository = $dayRepository;
        $this->roomRepository = $roomRepository;
        $this->slotRepository = $slotRepository;
        $this->persistenceManager = $persistenceManager;
    }

    protected function initializeAction(ServerRequestInterface $request)
    {
        $this->parameter = $request->getParsedBody()['tx_sessionplaner'];

        if (!($this->backendUser->isAdmin() || $this->backendUser->modAccess($this->moduleConfiguration))) {
            $this->errorAction();
            return false;
        }

        $configuration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
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
                'data' => $this->data,
            ]
        );
    }

    protected function errorAction()
    {
        $this->status = 'error';
        $this->message = 'No access granted';
    }

    public function createSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);

        $session = $this->getSessionFromRequest($request);
        $validationResults = $this->validateSession($session);
        if (!$validationResults->hasErrors()) {
            $this->sessionRepository->add($session);
            $this->persistAll();
            $this->message = 'Session ' . $session->getTopic() . ' saved';
            $this->data = $session->toArray();
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    public function updateSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);

        $session = $this->sessionRepository->findAnyByUid((int)$this->parameter['session']['uid']);
        $this->updateSessionFromRequest($session);

        $validationResults = $this->validateSession($session);
        if (!$validationResults->hasErrors()) {
            $this->sessionRepository->update($session);
            $this->persistAll();
            $this->message = 'Session ' . $session->getTopic() . ' updated';
            $this->data = $session->toArray();
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    public function deleteSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeAction($request);

        $session = $this->sessionRepository->findAnyByUid((int)$this->parameter['session']['uid']);
        $validationResults = $this->validateSession($session);
        if (!$validationResults->hasErrors()) {
            $this->sessionRepository->remove($session);
            $this->persistAll();
            $this->message = 'Session ' . $session->getTopic() . ' deleted';
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }

        return $this->render();
    }

    protected function getSessionFromRequest(ServerRequestInterface $request)
    {
        /** @var PropertyMapper $propertyMapper */
        $propertyMapper = GeneralUtility::makeInstance(PropertyMapper::class);
        $session = $propertyMapper
            ->convert(
                $this->parameter['session'],
                Session::class
            );
        $session->setPid(intval($request->getParsedBody()['id']));
        return $session;
    }

    protected function updateSessionFromRequest(Session $session)
    {
        $sessionData = $this->parameter['session'];
        unset($sessionData['uid']);

        foreach ($sessionData as $field => $value) {
            switch ($field) {
                case 'room':
                    /** @var Room $room */
                    $room = $this->roomRepository->findByUid((int) $value);
                    $session->setRoom($room);
                    break;
                case 'slot':
                    /** @var Slot $slot */
                    $slot = $this->slotRepository->findByUid((int) $value);
                    $session->setSlot($slot);
                    break;
                case 'day':
                    /** @var Day $day */
                    $day = $this->dayRepository->findByUid((int) $value);
                    $session->setDay($day);
                    break;
                default:
                    $session->{'set' . GeneralUtility::underscoredToUpperCamelCase($field)}($value);
            }
        }
    }

    protected function validateSession(Session $session)
    {
        /** @var ValidatorResolver $validationResolver */
        $validationResolver = GeneralUtility::makeInstance(ValidatorResolver::class);
        $validator = $validationResolver->getBaseValidatorConjunction(Session::class);
        return $validator->validate($session);
    }

    protected function persistAll()
    {
        $this->persistenceManager->persistAll();
    }
}
