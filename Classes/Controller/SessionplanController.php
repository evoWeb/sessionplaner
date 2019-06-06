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

use Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SessionplanController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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

    public function injectSessionRepository(
        \Evoweb\Sessionplaner\Domain\Repository\SessionRepository $sessionRepository
    ) {
        $this->sessionRepository = $sessionRepository;
    }

    public function displayAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session) {
            $this->forward('show');
        }
        $day = $this->dayRepository->findByUid($this->settings['day']);
        $sessions = $this->sessionRepository->findByDay($this->settings['day']);
        $this->view->assign('day', $day);
        $this->view->assign('sessions', $sessions);
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
