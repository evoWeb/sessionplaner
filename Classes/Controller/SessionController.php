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
use Evoweb\Sessionplaner\TitleTagProvider\SessionTitleTagProvider;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionController extends ActionController
{
    public function __construct(
        protected readonly DayRepository $dayRepository,
        protected readonly SessionRepository $sessionRepository,
    ) {}

    public function listAction(?Session $session = null): ResponseInterface
    {
        if ($session !== null) {
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

    public function showAction(?Session $session = null): ResponseInterface
    {
        if ($session === null) {
            $response = new ForwardResponse('list');
        } else {
            /** @var SessionTitleTagProvider $provider */
            $provider = GeneralUtility::makeInstance(SessionTitleTagProvider::class);
            $provider->setTitle($session->getTopic());

            /** @var MetaTagManagerRegistry $metaTagRegistry */
            $metaTagRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);

            $ogMetaTagManager = $metaTagRegistry->getManagerForProperty('og:title');
            // @extensionScannerIgnoreLine
            $ogMetaTagManager->addProperty('og:title', $session->getTopic());

            $twitterMetaTagManager = $metaTagRegistry->getManagerForProperty('twitter:title');
            // @extensionScannerIgnoreLine
            $twitterMetaTagManager->addProperty('twitter:title', $session->getTopic());

            $this->view->assign('session', $session);

            $response = new HtmlResponse($this->view->render());
        }

        return $response;
    }
}
