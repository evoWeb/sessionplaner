<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\Controller\BackendModuleController;

return [
    'sessionplaner_show' => [
        'parent' => 'web',
        'access' => 'user',
        'path' => '/module/sessionplaner/show',
        'iconIdentifier' => 'sessionplaner-module-show',
        'labels' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_mod.xlf',
        'extensionName' => 'Sessionplaner',
        'controllerActions' => [
            BackendModuleController::class => [
                'show',
            ],
        ],
        'aliases' => [
            'web_SessionplanerSessionplanerMain'
        ],
    ],
];
