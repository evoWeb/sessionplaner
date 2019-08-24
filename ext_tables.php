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

defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Sessionplaner',
    'web',
    'sessionplaner_main',
    '',
    [
        \Evoweb\Sessionplaner\Controller\BackendModuleController::class => 'show',
    ],
    [
        'access' => 'user,group',
        'icon' => 'EXT:sessionplaner/Resources/Public/Icons/module-sessionplaner.svg',
        'labels' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_mod.xlf',
    ]
);
