<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SessionplanController extends ActionController
{
    protected DayRepository $dayRepository;

    public function __construct(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    public function displayAction(): ResponseInterface
    {
        $day = $this->dayRepository->findByUid($this->settings['day']);
        $this->view->assign('day', $day);

        return new HtmlResponse($this->view->render());
    }
}
