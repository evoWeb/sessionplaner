<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
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
});
