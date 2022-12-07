<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionController extends ActionController
{
    protected DayRepository $dayRepository;

    protected SessionRepository $sessionRepository;

    public function __construct(DayRepository $dayRepository, SessionRepository $sessionRepository)
    {
        $this->dayRepository = $dayRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function listAction(Session $session = null): ResponseInterface
    {
        if ($session) {
            $response = new ForwardResponse('show');
        } else {
            if ($this->settings['suggestions']) {
                $sessions = $this->sessionRepository->findSuggested();
            } else {
                $sessions = $this->sessionRepository->findByDayAndHasSlotHasRoom($this->settings['days']);
                $days = $this->dayRepository->findByUidList($this->settings['days']);
                $this->view->assign('days', $days);
            }

            $this->view->assign('sessions', $sessions);

            $response = new HtmlResponse($this->view->render());
        }

        return $response;
    }

    public function showAction(Session $session = null): ResponseInterface
    {
        if ($session === null) {
            $response = new ForwardResponse('list');
        } else {
            /** @var EventTitleTagProvider $provider */
            $provider = GeneralUtility::makeInstance(EventTitleTagProvider::class);
            $provider->setTitle($session->getTopic());

            /** @var MetaTagManagerRegistry $metaTagRegistry */
            $metaTagRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);

            $ogMetaTagManager = $metaTagRegistry->getManagerForProperty('og:title');
            $ogMetaTagManager->addProperty('og:title', $session->getTopic());

            $twitterMetaTagManager = $metaTagRegistry->getManagerForProperty('twitter:title');
            $twitterMetaTagManager->addProperty('twitter:title', $session->getTopic());

            $this->view->assign('session', $session);

            $response = new HtmlResponse($this->view->render());
        }

        return $response;
    }
}
