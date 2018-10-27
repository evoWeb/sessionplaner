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

use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
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

    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    public function newAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        // Has a session been submitted?
        if ($session === null) {
            // Get a blank one
            $session = $this->objectManager->get(\Evoweb\Sessionplaner\Domain\Model\Session::class);
        }
        $this->view->assign('session', $session);
    }

    public function createAction(\Evoweb\Sessionplaner\Domain\Model\Session $session = null)
    {
        if ($session === null) {
            // redirect to drop unwanted parameters
            $this->redirect('form');
        }

        $session = $this->setDefaultValues($session);
        $this->sessionRepository->add($session);

        $title = null;
        $message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('yourSessionIsSaved', 'sessionplaner');
        $this->addFlashMessage($message, $title);

        // Redirect to prevent multiple entries through reloading
        $this->redirect('new');
    }

    protected function setDefaultValues(
        \Evoweb\Sessionplaner\Domain\Model\Session $session
    ): \Evoweb\Sessionplaner\Domain\Model\Session {
        if (isset($this->settings['default'])
            && is_array($this->settings['default'])
            && !empty($this->settings['default'])) {
            foreach ($this->settings['default'] as $field => $value) {
                $value = $this->getDefaultValues($field, $value);

                $setter = 'set' . ucfirst($field);
                if (method_exists($session, $setter)) {
                    call_user_func([$session, $setter], $value);
                }
            }
        }

        return $session;
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @return mixed
     */
    protected function getDefaultValues($field, $value)
    {
        switch ($field) {
            case 'day':
                if (!empty($value) && intval($value) > 0) {
                    /** @var DayRepository $dayRepository */
                    $dayRepository = $this->objectManager->get(DayRepository::class);
                    $value = $dayRepository->findByUid($value);
                }
                break;
        }

        return $value;
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
