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

use Evoweb\Sessionplaner\Domain\Repository\DayRepository;

class SessionplanController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var DayRepository
     */
    protected $dayRepository;

    public function injectDayRepository(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    public function displayAction()
    {
        $day = $this->dayRepository->findByUid($this->settings['day']);
        $this->view->assign('day', $day);
    }
}
