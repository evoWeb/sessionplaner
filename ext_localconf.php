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

call_user_func(function () {
    /**
     * Default PageTS
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:sessionplaner/Configuration/PageTS/ModWizards.tsconfig">'
    );

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
     * Default realurl configuration
     */
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['postVarSets']['_DEFAULT']['suggest'] = [
        [
            'GETvar' => 'tx_sessionplaner_suggest[action]',
        ]
    ];
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['postVarSets']['_DEFAULT']['session'] = [
        [
            'GETvar' => 'tx_sessionplaner_session[action]',
        ],
        [
            'GETvar' => 'tx_sessionplaner_session[session]',
            'lookUpTable' => [
                'table' => 'tx_sessionplaner_domain_model_session',
                'id_field' => 'uid',
                'alias_field' => 'topic',
                'addWhereClause' => ' AND NOT deleted',
                'useUniqueCache' => '1',
                'useUniqueCache_conf' => [
                    'strtolower' => '1',
                    'spaceCharacter' => '-',
                ],
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
    config.pageTitleProviders {
        event {
            provider = Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider
            before = record
            after = altPageTitle
        }
    }
'));
});
