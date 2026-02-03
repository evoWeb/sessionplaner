<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\Enum\SessionLevelEnum;
use Evoweb\Sessionplaner\Enum\SessionRequestTypeEnum;
use Evoweb\Sessionplaner\Enum\SessionTypeEnum;

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

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
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-session',
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
                'default' => 1,
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
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'topic_addition' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-topic_addition',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => false,
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
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
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
            'displayCond' => 'FIELD:speakers:REQ:false',
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
            'displayCond' => 'FIELD:speakers:REQ:false',
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
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
            ],
            'onChange' => 'reload',
        ],
        'attendees' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-attendees',
            'config' => [
                'type' => 'number',
                'size' => 20,
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
                'softref' => 'typolink_tag,email[subst],url',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'tag_suggestion' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-tag_suggestion',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => false,
                'max' => 256,
            ],
        ],
        'documents' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-download',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 100,
            ],
        ],
        'type' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => SessionTypeEnum::getTcaOptions(),
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
                'items' => SessionLevelEnum::getTcaOptions(),
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'day' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-day',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'notassigned',
                        'value' => 0,
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
                        'label' => $languageFile . 'notassigned',
                        'value' => 0,
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
                        'label' => $languageFile . 'notassigned',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID### AND tx_sessionplaner_domain_model_slot.day = ###REC_FIELD_day###',
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
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
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
        'requesttype' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-requesttype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => SessionRequestTypeEnum::getTcaOptions(),
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'norecording' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-norecording',
            'description' => $languageFile . 'tx_sessionplaner_domain_model_session-norecording-description',
            'config' => [
                'type' => 'check',
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
                --linebreak--, norecording,
            ',
        ],
        'speaker_free' => [
            'showitem' => '
                speaker,
                twitter,
            ',
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    --palette--;' . $languageFile . 'tx_sessionplaner_domain_model_session.palettes.options;options,
                    topic,
                    topic_addition,
                    path_segment,
                    description,
                    --palette--;' . $languageFile
                . 'tx_sessionplaner_domain_model_session.palettes.speaker_free;speaker_free,
                    speakers,
                    attendees,
                    links,
                    documents,
                --div--;Relations,
                    requesttype,
                    type,
                    level,
                    day,
                    room,
                    slot,
                    tag_suggestion,
                    tags,
            ',
        ],
    ],
];
