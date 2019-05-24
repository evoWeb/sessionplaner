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

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_session');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_session',
        'label' => 'topic',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY topic',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/iconmonstr-calendar-4_record.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'name'
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'suggestion' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-suggestion',
            'config' => [
                'type' => 'check',
            ],
        ],
        'social' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-social',
            'config' => [
                'type' => 'check',
                'default' => '1'
            ],
        ],
        'donotlink' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-donotlink',
            'config' => [
                'type' => 'check',
            ],
        ],
        'topic' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-topic',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'speaker' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-speaker',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'twitter' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-twitter',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'attendees' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-attendees',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'max' => 256,
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-description',
            'config' => [
                'type' => 'text'
            ],
        ],
        'documents' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-download',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'documents',
                ['maxitems' => 100],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'type' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-type',
            'config' => [
                'type' => 'check',
                'renderType' => 'selectSingle',
                'items' => [
                    [$languageFile . 'notassigned', 0],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-talk', 1],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-tutorial', 2],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-workshop', 3],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-wish', 6],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-other', 4],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-type-break', 5],
                ],
            ],
        ],
        'level' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-level',
            'config' => [
                'type' => 'check',
                'renderType' => 'selectSingle',
                'items' => [
                    [$languageFile . 'notassigned', 0],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-starter', 1],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-advanced', 2],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-pro', 3],
                ],
            ],
        ],
        'day' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-day',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'notassigned',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID### ORDER BY tx_sessionplaner_domain_model_day.date',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'room' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-room',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'notassigned',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'slot' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-slot',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        $languageFile . 'notassigned',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID###',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'tags' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-tags',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_sessionplaner_domain_model_tag',
                // needed for extbase query
                'foreign_table' => 'tx_sessionplaner_domain_model_tag',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_tag.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_tag_mm',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                hidden,
                suggestion,
                social,
                donotlink,
                topic,
                speaker,
                twitter,
                attendees,
                documents,
                description,
                --div--;Relations,
                type,
                level,
                day,
                room,
                slot,
                tags
            '
        ]
    ],
];
