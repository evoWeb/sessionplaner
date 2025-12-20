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
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

#[Autoconfigure(public: true)]
final class AjaxController
{
    private BackendUserAuthentication $backendUser;

    public function __construct(
        private readonly ValidatorResolver $validatorResolver,
        private readonly SessionRepository $sessionRepository,
        private readonly DayRepository $dayRepository,
        private readonly RoomRepository $roomRepository,
        private readonly SlotRepository $slotRepository,
        private readonly PersistenceManager $persistenceManager,
    ) {
        $this->backendUser = $GLOBALS['BE_USER'];
    }

    public function updateSessionAction(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->hasAccess()) {
            return $this->renderResponse([
                'status' => 'error',
                'message' => 'No access granted',
            ]);
        }

        $data = $this->getParameter($request)['session'] ?? [];
        $uid = (int)($data['uid'] ?? 0);
        unset($data['uid']);

        $session = $this->sessionRepository->findAnyByUid($uid);
        if ($session === null) {
            return $this->renderResponse([
                'status' => 'error',
                'message' => 'Session not found',
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
                    'session' => $session->toArray(),
                ],
            ]);
        }

        return $this->renderResponse([
            'status' => 'error',
            'message' => 'Request did not contain valid data',
        ]);
    }

    private function validateSession(Session $session): Result
    {
        return $this->validatorResolver->getBaseValidatorConjunction(Session::class)->validate($session);
    }

    private function updateSession(Session $session, array $data = []): void
    {
        foreach ($data as $field => $value) {
            switch ($field) {
                case 'room':
                    $room = $this->roomRepository->findByUid((int)$value);
                    $session->setRoom($room);
                    break;
                case 'slot':
                    $slot = $this->slotRepository->findByUid((int)$value);
                    $session->setSlot($slot);
                    break;
                case 'day':
                    $day = $this->dayRepository->findByUid((int)$value);
                    $session->setDay($day);
                    break;
                default:
                    $methodName = 'set' . GeneralUtility::underscoredToUpperCamelCase($field);
                    if (method_exists($session, $methodName)) {
                        // @phpstan-ignore method.dynamicName
                        $session->{$methodName}($value);
                    }
            }
        }
    }

    private function hasAccess(): bool
    {
        return $this->backendUser->isAdmin()
            || $this->backendUser->check('modules', 'web_SessionplanerSessionplanerMain');
    }

    private function getParameter(ServerRequestInterface $request): array
    {
        try {
            $payload = json_decode((string)$request->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return is_array($payload) ? $payload : [];
        } catch (\JsonException) {
            return [];
        }
    }

    private function renderResponse(array $data): ResponseInterface
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
