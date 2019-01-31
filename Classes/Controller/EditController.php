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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EditController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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

    protected function initializeAction()
    {
        /** @var \TYPO3\CMS\Core\Page\PageRenderer::class $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Sessionplaner/Edit', 'function(sessionplaner) {
            sessionplaner.setPageId(' . (int)GeneralUtility::_GP('id') . ');
        }');
    }

    public function showAction()
    {
        if ($this->request->hasArgument('day')) {
            $day = $this->dayRepository->findByUid($this->request->getArgument('day'));
        } else {
            /** @var \Evoweb\Sessionplaner\Domain\Model\Day $day */
            $day = $this->dayRepository->findAll()->getFirst();
        }

        $this->view->assign('currentDay', $day);
        $this->view->assign('roomCount', is_object($day) ? count($day->getRooms()) : 0);
        $this->view->assign('days', $this->dayRepository->findAll());
        $this->view->assign('unassignedSessions', $this->sessionRepository->findByDayAndEmptySlot($day));
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
