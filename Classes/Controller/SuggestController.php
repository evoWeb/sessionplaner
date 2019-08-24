<?php
declare(strict_types = 1);
namespace Evoweb\Sessionplaner\Controller;

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

use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Repository\DayRepository;

class SuggestController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SessionRepository
     */
    protected $sessionRepository;

    public function injectSessionRepository(\Evoweb\Sessionplaner\Domain\Repository\SessionRepository $repository)
    {
        $this->sessionRepository = $repository;
    }

    public function newAction(Session $session = null)
    {
        // Has a session been submitted?
        if ($session === null) {
            // Get a blank one
            $session = $this->objectManager->get(Session::class);
        }
        $this->view->assign('session', $session);
    }

    public function createAction(Session $session = null)
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

    protected function setDefaultValues(Session $session): Session
    {
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
    protected function getDefaultValues(string $field, $value)
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
}
