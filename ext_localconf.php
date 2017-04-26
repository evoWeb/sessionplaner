<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}


/**
 * Default PageTS
 */
/** @noinspection PhpUndefinedVariableInspection */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/ModWizards.ts">'
);


/**
 * Configure Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.' . $_EXTKEY,
    'Display',
    array(
        'Display' => 'listDays, showDay, showRoom, listSessions, screen',
    ),
    array()
);


/**
 * Configure Suggest Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.' . $_EXTKEY,
    'Suggest',
    array(
        'Suggest' => 'new, create',
    ),
    array(
        'Suggest' => 'new, create',
    )
);


/**
 * Configure Session Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.' . $_EXTKEY,
    'Session',
    array(
        'Session' => 'list, show',
    ),
    array()
);

/**
 * Configure Sessionplan Frontend Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Evoweb.' . $_EXTKEY,
    'Sessionplan',
    array(
        'Sessionplan' => 'display',
    ),
    array()
);


/**
 * Default realurl configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['postVarSets']['_DEFAULT']['suggest'] = array(
    array(
        'GETvar' => 'tx_sessionplaner_suggest[action]',
    )
);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['postVarSets']['_DEFAULT']['session'] = array(
    array(
        'GETvar' => 'tx_sessionplaner_session[action]',
    ),
    array (
        'GETvar' => 'tx_sessionplaner_session[session]',
        'lookUpTable' => array (
            'table' => 'tx_sessionplaner_domain_model_session',
            'id_field' => 'uid',
            'alias_field' => 'topic',
            'addWhereClause' => ' AND NOT deleted',
            'useUniqueCache' => '1',
            'useUniqueCache_conf' => array (
                'strtolower' => '1',
                'spaceCharacter' => '-',
            ),
        ),
    ),
);
