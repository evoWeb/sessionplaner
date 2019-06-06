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

/**
 * Register "sessionplannervh" as global fluid namespace
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sessionplanervh'][] = 'Evoweb\\Sessionplaner\\ViewHelpers';

/**
 * Register Icons
 */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$icons = [
    'plugin-display',
    'plugin-session',
    'plugin-suggest',
    'plugin-speaker',
    'record-day',
    'record-room',
    'record-session',
    'record-slot',
    'record-tag',
    'record-speaker',
];
foreach ($icons as $icon) {
    $iconRegistry->registerIcon(
        'sessionplaner-' . $icon,
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:sessionplaner/Resources/Public/Icons/' . $icon . '.svg']
    );
}

/**
 * Add default PageTsConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:sessionplaner/Configuration/PageTS/ModWizards.tsconfig">'
);

/**
 * Register Update Wizards
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class]
    = \Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class;

/**
 * Configure Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.sessionplaner',
    'Display',
    [
        'Display' => 'listDays, showDay, showRoom, listSessions, screen',
    ]
);

/**
 * Configure Suggest Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.sessionplaner',
    'Suggest',
    [
        'Suggest' => 'new, create',
    ],
    [
        'Suggest' => 'new, create',
    ]
);

/**
 * Configure Session Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.sessionplaner',
    'Session',
    [
        'Session' => 'list, show',
    ]
);

/**
 * Configure Sessionplan Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.sessionplaner',
    'Sessionplan',
    [
        'Sessionplan' => 'display',
    ]
);

/**
 * Configure Speaker Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.sessionplaner',
    'Speaker',
    [
        'Speaker' => 'list, show',
    ]
);

/**
 * Register Event Title Provider
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
    config.pageTitleProviders {
        event {
            provider = Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider
            before = record
            after = altPageTitle
        }
    }
'));
