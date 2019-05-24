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
 * Frontend Plugin Session Suggest
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.sessionplaner',
    'Suggest',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_suggest',
    'sessionplaner-plugin-suggest'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_suggest'] =
    'layout, select_key';

/**
 * Frontend Plugin Session
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.sessionplaner',
    'Session',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_session',
    'sessionplaner-plugin-session'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_session'] =
    'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_session'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_session',
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Session.xml'
);

/**
 * Frontend Plugin Sessionplan
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.sessionplaner',
    'Sessionplan',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_sessionplan',
    'sessionplaner-plugin-display'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_sessionplan'] =
    'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_sessionplan'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_sessionplan',
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Sessionplan.xml'
);
