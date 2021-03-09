<?php

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

return [
    // Dispatch the create action
    'evoweb_sessionplaner_create' => [
        'path' => '/evoweb/sessionplaner/create',
        'target' => \Evoweb\Sessionplaner\Controller\AjaxController::class . '::createSessionAction'
    ],
    // Dispatch the update action
    'evoweb_sessionplaner_update' => [
        'path' => '/evoweb/sessionplaner/update',
        'target' => \Evoweb\Sessionplaner\Controller\AjaxController::class . '::updateSessionAction'
    ],
    // Dispatch the delete action
    'evoweb_sessionplaner_delete' => [
        'path' => '/evoweb/sessionplaner/delete',
        'target' => \Evoweb\Sessionplaner\Controller\AjaxController::class . '::deleteSessionAction'
    ]
];
