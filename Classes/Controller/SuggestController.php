<?php

declare(strict_types=1);

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

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SuggestController extends ActionController
{
    public function formAction(): ResponseInterface
    {
        return new HtmlResponse($this->view->render());
    }
}
