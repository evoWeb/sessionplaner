<?php
namespace Evoweb\Sessionplaner\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Sebastian Fische <typo3@evoweb.de>
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
     * @var array
     */
    protected $actions = [
        '/ajax/evoweb/sessionplaner/create' => 'createSession',
        '/ajax/evoweb/sessionplaner/update' => 'updateSession',
        '/ajax/evoweb/sessionplaner/delete' => 'deleteSession',
    ];

    /**
     * @var string
     */
    protected $actionMethodName;

    /**
     * @var boolean
     */
    protected $isProcessed = false;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $repository;

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
    protected $data;

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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->initializeAction($request, $response);
        $this->callActionMethod();
        $this->render();

        return $this->response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return void
     */
    protected function initializeAction($request, $response)
    {
        $this->parameter = $request->getParsedBody()['tx_sessionplaner'];
        $routePath = $request->getAttribute('routePath');

        if (!($this->backendUser->isAdmin()
            || $this->backendUser->modAccess($this->moduleConfiguration, 0))
            || !isset($this->actions[$routePath])) {
            $this->actionMethodName = 'errorAction';
        } else {
            $this->actionMethodName = $this->actions[$routePath] . 'Action';
        }

        $this->response = $response;
        $this->response->withHeader('Content-Type', 'application/json; charset=utf-8');

        $configuration = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
        if (empty($configuration['persistence']['storagePid'])) {
            $currentPid['persistence']['storagePid'] = $_REQUEST['id'];
            $this->configurationManager->setConfiguration(array_merge($configuration, $currentPid));
        }
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InfiniteLoopException
     *
     * @return void
     */
    protected function callActionMethod()
    {
        $dispatchLoopCount = 0;
        while ($this->isProcessed === false) {
            if ($dispatchLoopCount++ > 99) {
                throw new \TYPO3\CMS\Extbase\Mvc\Exception\InfiniteLoopException(
                    'Could not ultimately dispatch the request after ' . $dispatchLoopCount .
                    ' iterations. Most probably, a @ignorevalidation or @dontvalidate (old propertymapper) annotation
                    is missing on re-displaying a form with validation errors.',
                    1217839467
                );
            }
            $this->isProcessed = true;

            $actionInitializationMethodName = 'initialize' . ucfirst($this->actionMethodName);
            if (method_exists($this, $actionInitializationMethodName)) {
                call_user_func([$this, $actionInitializationMethodName]);
            }

            call_user_func([$this, $this->actionMethodName]);
        }
    }

    /***
     * @return void
     */
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


    /**
     * @return void
     */
    protected function errorAction()
    {
        $this->status = 'error';
        $this->message = 'No access granted';
    }


    /**
     * @return void
     */
    protected function initializeCreateSessionAction()
    {
        $this->repository = $this->objectManager->get(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class);
    }

    /**
     * @return void
     */
    protected function createSessionAction()
    {
        $session = $this->getSessionFromRequest();
        if ($session instanceof Session) {
            $this->repository->add($session);

            $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class)->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' saved';
            $this->data = ['uid' => $session->getUid()];
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }
    }


    /**
     * @return void
     */
    protected function initializeUpdateSessionAction()
    {
        $this->repository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class
        );
        $this->roomRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\RoomRepository::class
        );
        $this->slotRepository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SlotRepository::class
        );
    }

    /**
     * @return void
     */
    protected function updateSessionAction()
    {
        /** @var Session $session */
        $session = $this->repository->findByUid((int) $this->parameter['session']['uid']);
        $this->updateSessionFromRequest($session);
        if ($session instanceof Session) {
            $this->repository->update($session);

            $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class)->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' updated';
            $this->data = ['uid' => $session->getUid()];
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }
    }


    /**
     * @return void
     */
    protected function initializeDeleteSessionAction()
    {
        $this->repository = $this->objectManager->get(
            \Evoweb\Sessionplaner\Domain\Repository\SessionRepository::class
        );
    }

    /**
     * @return void
     */
    protected function deleteSessionAction()
    {
        /** @var Session $session */
        $session = $this->repository->findByUid((int) $this->parameter['session']['uid']);
        if ($session instanceof Session) {
            $this->repository->remove($session);

            /** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
            $persistenceManager = $this->objectManager->get(
                \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class
            );
            $persistenceManager->persistAll();

            $this->message = 'Session ' . $session->getTopic() . ' deleted';
        } else {
            $this->status = 'error';
            $this->message = 'Request did not contain valid data';
        }
    }


    /**
     * @return Session
     */
    protected function getSessionFromRequest()
    {
        return $this->objectManager
            ->get(\TYPO3\CMS\Extbase\Property\PropertyMapper::class)
            ->convert(
                $this->parameter['session'],
                Session::class
            );
    }

    /**
     * @param Session $session
     */
    protected function updateSessionFromRequest($session)
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

                case $field == 'day':
                    // do nothing
                    break;

                default:
                    $session->{'set' . GeneralUtility::underscoredToUpperCamelCase($field)}($value);
            }
        }
    }
}
