<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

/**
 * Frontend Plugin Session Suggest
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sessionplaner',
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
    'sessionplaner',
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
    'sessionplaner',
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

/**
 * Frontend Plugin Speaker
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Speaker',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_speaker',
    'sessionplaner-plugin-speaker'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_speaker'] =
    'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_speaker'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_speaker',
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Speaker.xml'
);

/**
 * Frontend Plugin Tag
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Tag',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_tag',
    'sessionplaner-plugin-tag'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_tag'] =
    'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_tag'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_tag',
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Tag.xml'
);
