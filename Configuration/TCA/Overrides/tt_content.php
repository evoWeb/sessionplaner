<?php

defined('TYPO3') or die('Access denied.');

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'list_type',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.group',
);

/**
 * Frontend Plugin Session Suggest
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Suggest',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_suggest',
    'sessionplaner-plugin-suggest',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_suggest_description',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout, select_key';

/**
 * Frontend Plugin Session
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Session',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_session',
    'sessionplaner-plugin-session',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_session_description',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Session.xml'
);

/**
 * Frontend Plugin Sessionplan
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Sessionplan',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_sessionplan',
    'sessionplaner-plugin-display',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_sessionplan_description',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Sessionplan.xml'
);

/**
 * Frontend Plugin Speaker
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Speaker',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_speaker',
    'sessionplaner-plugin-speaker',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_speaker_description',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Speaker.xml'
);

/**
 * Frontend Plugin Tag
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Tag',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_tag',
    'sessionplaner-plugin-tag',
    'sessionplaner',
    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_tag_description',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:sessionplaner/Configuration/FlexForms/Tag.xml'
);
