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

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xlf:';

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'sessionplaner',
    $languageFile . 'tt_content.group',
);

/**
 * Frontend Plugin Session Suggest
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'sessionplaner',
    'Suggest',
    $languageFile . 'tt_content.list_type_suggest',
    'sessionplaner-plugin-suggest',
    'sessionplaner',
    $languageFile . 'tt_content.list_type_suggest_description',
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin,
            pages,
            recursive,
    ',
    $pluginSignature,
    'after:palette:headers',
);

foreach (['Session', 'Sessionplan', 'Speaker', 'Tag'] as $plugin) {
    $lowerCasePlugin = strtolower($plugin);
    $pluginSignature = ExtensionUtility::registerPlugin(
        'sessionplaner',
        $plugin,
        $languageFile . 'tt_content.list_type_' . $lowerCasePlugin,
        'sessionplaner-plugin-' . $lowerCasePlugin,
        'sessionplaner',
        $languageFile . 'tt_content.list_type_' . $lowerCasePlugin . '_description',
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:sessionplaner/Configuration/FlexForms/' . $plugin . '.xml',
        $pluginSignature,
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin,
                pi_flexform,
                pages,
                recursive,
        ',
        $pluginSignature,
        'after:palette:headers',
    );
}
