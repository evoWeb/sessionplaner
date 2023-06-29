<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
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
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

final class AjaxController
{
    protected BackendUserAuthentication $backendUser;
    protected ConfigurationManager $configurationManager;
    protected SessionRepository $sessionRepository;
    protected DayRepository $dayRepository;
    protected RoomRepository $roomRepository;
    protected SlotRepository $slotRepository;
    protected PersistenceManager $persistenceManager;

    public function __construct(
        ConfigurationManager $configurationManager,
        SessionRepository $sessionRepository,
        DayRepository $dayRepository,
        RoomRepository $roomRepository,
        SlotRepository $slotRepository,
        PersistenceManager $persistenceManager
    ) {
        $this->backendUser = $GLOBALS['BE_USER'];
        $this->configurationManager = $configurationManager;
        $this->sessionRepository = $sessionRepository;
        $this->dayRepository = $dayRepository;
        $this->roomRepository = $roomRepository;
        $this->slotRepository = $slotRepository;
        $this->persistenceManager = $persistenceManager;
    }

    public function updateSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        if(!$this->hasAccess()) {
            return $this->renderResponse([
                'status' => 'error',
                'message' => 'No access granted'
            ]);
        }

        $data = $this->getParameter($request)['session'] ?? [];
        $session = $this->sessionRepository->findAnyByUid((int)$data['uid']);
        if ($session === null) {
            return $this->renderResponse([
                'status' => 'error',
                'message' => 'Session not found'
            ]);
        }

        $this->updateSession($session, $data);

        $validationResults = $this->validateSession($session);
        if (!$validationResults->hasErrors()) {
            $this->sessionRepository->update($session);
            $this->persistenceManager->persistAll();
            return $this->renderResponse([
                'message' => 'Session ' . $session->getTopic() . ' updated',
                'data' => [
                    'session' => $session->toArray()
                ]
            ]);
        }

        return $this->renderResponse([
            'status' => 'error',
            'message' => 'Request did not contain valid data'
        ]);
    }

    protected function validateSession(Session $session): Result
    {
        /** @var ValidatorResolver $validationResolver */
        $validationResolver = GeneralUtility::makeInstance(ValidatorResolver::class);
        $validator = $validationResolver->getBaseValidatorConjunction(Session::class);
        return $validator->validate($session);
    }

    protected function updateSession(Session $session, array $data = []): void
    {
        unset($data['uid']);
        foreach ($data as $field => $value) {
            switch ($field) {
                case 'room':
                    /** @var Room $room */
                    $room = $this->roomRepository->findByUid((int)$value);
                    $session->setRoom($room);
                    break;
                case 'slot':
                    /** @var Slot $slot */
                    $slot = $this->slotRepository->findByUid((int)$value);
                    $session->setSlot($slot);
                    break;
                case 'day':
                    /** @var Day $day */
                    $day = $this->dayRepository->findByUid((int)$value);
                    $session->setDay($day);
                    break;
                default:
                    $session->{'set' . GeneralUtility::underscoredToUpperCamelCase($field)}($value);
            }
        }
    }

    protected function hasAccess(): bool
    {
        if (!($this->backendUser->isAdmin() || $this->backendUser->check('modules', 'web_SessionplanerSessionplanerMain'))) {
            return false;
        }

        return true;
    }

    protected function getParameter(ServerRequestInterface $request): array
    {
        try {
            $payload = json_decode((string) $request->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return is_array($payload) ? $payload : [];
        } catch (\JsonException $exception) {
            return [];
        }
    }

    protected function renderResponse(array $data): ResponseInterface
    {
        return new JsonResponse(
            [
                'status' => $data['status'] ?? 'success',
                'message' => $data['message'] ?? 'ok',
                'data' => $data['data'] ?? [],
            ]
        );
    }
}
