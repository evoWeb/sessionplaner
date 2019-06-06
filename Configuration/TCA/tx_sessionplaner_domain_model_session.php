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
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-session'
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'name'
    ],
    'columns' => [
        'hidden' => [
            'exclude' => false,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'suggestion' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-suggestion',
            'config' => [
                'type' => 'check',
            ],
        ],
        'social' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-social',
            'config' => [
                'type' => 'check',
                'default' => '1'
            ],
        ],
        'donotlink' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-donotlink',
            'config' => [
                'type' => 'check',
            ],
        ],
        'topic' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-topic',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-path_segment',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['topic'],
                    'replacements' => [
                        '/' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'speaker' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-speaker',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max' => 256,
            ],
            'displayCond' => 'FIELD:speakers:REQ:false'
        ],
        'twitter' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-twitter',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
            'displayCond' => 'FIELD:speakers:REQ:false'
        ],
        'speakers' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-speakers',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'multiple' => 0,
                'foreign_table' => 'tx_sessionplaner_domain_model_speaker',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_speaker.pid = ###CURRENT_PID### ORDER BY tx_sessionplaner_domain_model_speaker.name',
                'MM' => 'tx_sessionplaner_session_speaker_mm',
            ],
            'onChange' => 'reload'
        ],
        'attendees' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-attendees',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'max' => 256,
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-description',
            'config' => [
                'type' => 'text'
            ],
        ],
        'documents' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-download',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'documents',
                ['maxitems' => 100],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'type' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-type',
            'config' => [
                'type' => 'select',
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
                'minitems' => 0,
                'maxitems' => 1,
                'maxitems' => 1,
            ],
        ],
        'level' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-level',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$languageFile . 'notassigned', 0],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-starter', 1],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-advanced', 2],
                    [$languageFile . 'tx_sessionplaner_domain_model_session-level-pro', 3],
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'day' => [
            'exclude' => false,
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
            'exclude' => false,
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
            'exclude' => false,
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
            'exclude' => false,
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
    'palettes' => [
        'options' => [
            'showitem' => '
                hidden,
                suggestion,
                social,
                donotlink,
            '
        ],
        'speaker_free' => [
            'showitem' => '
                speaker,
                twitter,
            '
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    --palette--;' . $languageFile . 'tx_sessionplaner_domain_model_session.palettes.options;options,
                    topic,
                    path_segment,
                    description,
                    --palette--;' . $languageFile . 'tx_sessionplaner_domain_model_session.palettes.speaker_free;speaker_free,
                    speakers,
                    attendees,
                    documents,
                --div--;Relations,
                    type,
                    level,
                    day,
                    room,
                    slot,
                    tags,
            '
        ]
    ],
];
