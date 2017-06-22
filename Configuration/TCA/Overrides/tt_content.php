<?php
defined('TYPO3_MODE') or die('Access denied.');

/**
 * Frontend Plugin Session Suggest
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.sessionplaner',
    'Suggest',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_suggest',
    'EXT:sessionplaner/ext_icon.gif'
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
    'EXT:sessionplaner/ext_icon.gif'
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
    'EXT:sessionplaner/ext_icon.gif'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_sessionplan'] =
    'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_sessionplan'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_sessionplan',
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Sessionplan.xml'
);
