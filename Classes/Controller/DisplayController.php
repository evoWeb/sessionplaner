<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

/**
 * An display controller
 */
class DisplayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\DayRepository
     */
    protected $dayRepository;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $sessionRepository;

    public function injectDayRepository(\Evoweb\Sessionplaner\Domain\Repository\DayRepository $repository)
    {
        $this->dayRepository = $repository;
    }

    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    public function listDaysAction()
    {
        $days = $this->dayRepository->findAll();
        $this->view->assign('days', $days);
    }

    public function showDay()
    {
    }

    public function showRoom()
    {
    }

    public function listSessions()
    {
    }

    public function screenAction()
    {
    }
}
