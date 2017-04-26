<?php
namespace Evoweb\Sessionplaner\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Benjamin Kott <info@bk2k.info>
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

/**
 * Session Controller
 */
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
    
    /**
     * @param \Evoweb\Sessionplaner\Domain\Repository\DayRepository $dayRepository
     * @return void
     */
    public function injectDayRepository(\Evoweb\Sessionplaner\Domain\Repository\DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository
     * @return void
     */
    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Session $session
     * @return void
     */
    public function listAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session) {
            $this->forward('show');
        }
        if ($this->settings['suggestions']) {
            $sessions = $this->sessionRepository->findBySuggestion(true);
        } else {
            $sessions = $this->sessionRepository->findByDayAndHasSlotHasRoom($this->settings['days']);
            $days = $this->dayRepository->findByUidsRaw($this->settings['days']);
            $this->view->assign('days', $days);
        }
        $this->view->assign('sessions', $sessions);
    }

    /**
     * action show
     *
     * @param \Evoweb\Sessionplaner\Domain\Model\Session $session
     * @return void
     */
    public function showAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session === null) {
            $this->forward('list');
        }
        $this->view->assign('session', $session);
    }

    /**
     * Disable error flash message
     *
     * @return boolean
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
