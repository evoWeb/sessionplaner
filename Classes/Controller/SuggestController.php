<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SuggestController extends ActionController
{
    public function formAction(): ResponseInterface
    {
        /** @var ViewInterface $view */
        $view = $this->view;
        return $this->htmlResponse($view->render());
    }
}
