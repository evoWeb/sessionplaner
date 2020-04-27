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

use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SessionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var DayRepository
     */
    protected $dayRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;

    public function __construct(DayRepository $dayRepository, SessionRepository $sessionRepository)
    {
        $this->dayRepository = $dayRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function listAction(Session $session = null)
    {
        if ($session) {
            $this->forward('show');
        }

        if ($this->settings['suggestions']) {
            $sessions = $this->sessionRepository->findSuggested();
        } else {
            $sessions = $this->sessionRepository->findByDayAndHasSlotHasRoom($this->settings['days']);
            $days = $this->dayRepository->findByUidListRaw($this->settings['days']);
            $this->view->assign('days', $days);
        }

        $this->view->assign('sessions', $sessions);
    }

    public function showAction(Session $session = null)
    {
        if ($session === null) {
            $this->forward('list');
        }

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
    }
}
