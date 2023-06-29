<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\Controller\AjaxController;

return [
    'evoweb_sessionplaner_update' => [
        'path' => '/evoweb/sessionplaner/update',
        'methods' => ['POST'],
        'target' => AjaxController::class . '::updateSessionAction'
    ]
];
