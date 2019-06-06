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

use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionplanController extends ActionController
{
    /**
     * @var DayRepository
     */
    protected $dayRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;

    public function injectDayRepository(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    public function injectSessionRepository(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function displayAction()
    {
        $day = $this->dayRepository->findByUid($this->settings['day']);
        $sessions = $this->sessionRepository->findByDay($this->settings['day']);
        $this->view->assign('day', $day);
        $this->view->assign('sessions', $sessions);
    }
}
