<?php
namespace Evoweb\Sessionplaner\Controller;

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SessionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\DayRepository
     */
    protected $dayRepository;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $sessionRepository;

    public function injectDayRepository(\Evoweb\Sessionplaner\Domain\Repository\DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    public function listAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session) {
            $this->forward('show');
        }
        if ($this->settings['suggestions']) {
            $sessions = $this->sessionRepository->findSuggested();
        } else {
            $sessions = $this->sessionRepository->findByDayAndHasSlotHasRoom($this->settings['days']);
            $days = $this->dayRepository->findByUidsRaw($this->settings['days']);
            $this->view->assign('days', $days);
        }
        $this->view->assign('sessions', $sessions);
    }

    public function showAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session === null) {
            $this->forward('list');
        }
        $provider = GeneralUtility::makeInstance(EventTitleTagProvider::class);
        $provider->setTitle($session->getTopic());

        $ogMetaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
        $ogMetaTagManager->addProperty('og:title', $session->getTopic());

        $twitterMetaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('twitter:title');
        $twitterMetaTagManager->addProperty('twitter:title', $session->getTopic());

        $this->view->assign('session', $session);
    }

    /**
     * Disable error flash message
     *
     * @return bool
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
