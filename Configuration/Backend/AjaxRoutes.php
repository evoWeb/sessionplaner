<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\Controller\AjaxController;

return [
    'evoweb_sessionplaner_create' => [
        'path' => '/evoweb/sessionplaner/create',
        'methods' => ['POST'],
        'target' => AjaxController::class . '::createSessionAction'
    ],
    'evoweb_sessionplaner_update' => [
        'path' => '/evoweb/sessionplaner/update',
        'methods' => ['POST'],
        'target' => AjaxController::class . '::updateSessionAction'
    ],
    'evoweb_sessionplaner_delete' => [
        'path' => '/evoweb/sessionplaner/delete',
        'methods' => ['POST'],
        'target' => AjaxController::class . '::deleteSessionAction'
    ]
];
