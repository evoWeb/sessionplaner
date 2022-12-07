<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

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
    'columns' => [
        'hidden' => [
            'exclude' => false,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
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
                'default' => 1
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
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_speaker.pid = ###CURRENT_PID### '
                    . 'ORDER BY tx_sessionplaner_domain_model_speaker.name',
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
                'type' => 'text',
                'cols' => 80,
                'rows' => 15,
                'softref' => 'typolink_tag,images,email[subst],url',
                'enableRichtext' => true,
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
                'items' => array_merge([['', 0]], \Evoweb\Sessionplaner\Enum\SessionTypeEnum::getTcaOptions()),
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'level' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-level',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array_merge([['', 0]], \Evoweb\Sessionplaner\Enum\SessionLevelEnum::getTcaOptions()),
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
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID### '
                    . 'ORDER BY tx_sessionplaner_domain_model_day.date',
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
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_tag',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_tag.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_tag_mm',
                'minitems' => 0,
            ],
        ],
        'links' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-links',
            'description' => $languageFile . 'tx_sessionplaner_domain_model_session-links-description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sessionplaner_domain_model_link',
                'foreign_field' => 'parentid',
                'foreign_table_field' => 'parenttable',
                'minitems' => 0,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'useSortable' => 1,
                    'enabledControls' => [
                        'info' => false,
                        'new' => true,
                        'sort' => false,
                        'hide' => true,
                        'dragdrop' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                    'levelLinksPosition' => 'top',
                ],
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
                    --palette--;' . $languageFile
                . 'tx_sessionplaner_domain_model_session.palettes.speaker_free;speaker_free,
                    speakers,
                    attendees,
                    links,
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
