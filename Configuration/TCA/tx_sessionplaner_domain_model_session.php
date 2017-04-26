<?php

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_session');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_session',
        'label' => 'topic',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY topic',
        'dividers2tabs' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_session.png',
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
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('documents', [
                'foreign_types' => [
                    '0' => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                        'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
					--palette--;;filePalette'
                    ],
                ],
                'minitems' => 0,
                'maxitems' => 100
            ]),
        ],
        'type' => [
            'exclude' => 0,
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
            ],
        ],
        'level' => [
            'exclude' => 0,
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
            ],
        ],
        'day' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-day',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID###',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    '0' => [
                        '0' => $languageFile . 'notassigned',
                    ],
                ],
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ],
        ],
        'room' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-room',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    '0' => [
                        '0' => $languageFile . 'notassigned',
                    ],
                ],
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ],
        ],
        'slot' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_session-slot',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID###',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    '0' => [
                        '0' => $languageFile . 'notassigned',
                    ],
                ],
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
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
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
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
            --div--;
            Relations,
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
