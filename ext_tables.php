<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

call_user_func(function () {
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
});
