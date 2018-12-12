<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    /**
     * Backend Module
     */
    if (TYPO3_MODE === 'BE') {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'Evoweb.sessionplaner',
            'web',
            'tx_sessionplaner_m1',
            '',
            [
                'Edit' => 'show',
            ],
            [
                'access' => 'user,group',
                'icon' => 'EXT:sessionplaner/Resources/Public/Icons/iconmonstr-calendar-4.svg',
                'labels' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
});
