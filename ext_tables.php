<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}


/**
 * Add Static Configuration Files
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Sessionplan');


/**
 * Allow tables on standard pages
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_day');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_room');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_session');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_slot');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_tag');


/**
 * Backend Module
 */
if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Evoweb.' . $_EXTKEY,
        'web',
        'tx_sessionplaner_m1',
        '',
        array(
            'Edit' => 'show',
        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/sessionplaner_module.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
        )
    );
}


/**
 * Frontend Plugin Session Suggest
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.' . $_EXTKEY,
    'Suggest',
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:tt_content.list_type_suggest',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_suggest'] = 'layout, select_key';


/**
 * Frontend Plugin Session
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.' . $_EXTKEY,
    'Session',
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:tt_content.list_type_session',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_session'] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_session'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_session',
    'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Session.xml'
);


/**
 * Frontend Plugin Sessionplan
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Evoweb.' . $_EXTKEY,
    'Sessionplan',
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:tt_content.list_type_sessionplan',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sessionplaner_sessionplan'] = 'layout, select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sessionplaner_sessionplan'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sessionplaner_sessionplan',
    'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Sessionplan.xml'
);
