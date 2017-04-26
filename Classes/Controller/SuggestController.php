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

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Session Suggest Controller
 */
class SuggestController extends ActionController
{
    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $sessionRepository;

    /**
     * @param \Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository
     * @return void
     */
    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Session|null $session
     *
     * @return void
     */
    public function newAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        // Has a session been submitted?
        if ($session === null) {
            // Get a blank one
            $session = $this->objectManager->get("Evoweb\\Sessionplaner\\Domain\\Model\\Session");
        }
        $this->view->assign('session', $session);
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Session $session
     */
    public function createAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session === null) {
            // redirect to drop unwanted parameters
            $this->redirect('form');
        }

        $session->setHidden(true);
        $session->setSuggestion(true);
        $this->sessionRepository->add($session);
        $title = null;
        $message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('yourSessionIsSaved', 'sessionplaner');
        $this->addFlashMessage($message, $title);

        // Redirect to prevent multiple entries through reloading
        $this->redirect('new');
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
