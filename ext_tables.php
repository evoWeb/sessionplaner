<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

use Evoweb\Sessionplaner\Controller\BackendModuleController;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if ((GeneralUtility::makeInstance(Typo3Version::class))->getMajorVersion() < 12) {
    ExtensionUtility::registerModule(
        'Sessionplaner',
        'web',
        'sessionplaner_main',
        '',
        [
            BackendModuleController::class => 'show',
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:sessionplaner/Resources/Public/Icons/module-sessionplaner.svg',
            'labels' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_mod.xlf',
        ]
    );
}
