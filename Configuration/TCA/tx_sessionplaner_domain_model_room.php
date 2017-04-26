<?php

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_room');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_room',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_room.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'name'
    ],
    'columns' => [
        'name' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'logo' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-logo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo', [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                    ],
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
                    'maxitems' => 1,
            ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ],
        'seats' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-seats',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'max' => 256,
            ],
        ],
        'days' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-days',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID###
                    ORDER BY tx_sessionplaner_domain_model_day.name',
                'MM' => 'tx_sessionplaner_day_room_mm',
                'MM_opposite_field' => 'rooms',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
            ],
        ],
        'slots' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-slots',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID###
                    ORDER BY tx_sessionplaner_domain_model_slot.start',
                'MM' => 'tx_sessionplaner_room_slot_mm',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 100,
            ],
        ],
        'sessions' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-sessions',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID###',
                'foreign_field' => 'room',
                'size' => 5,
                'autoSizeMax' => 20,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
            name,
            logo,
            seats,
            days,
            slots,
            sessions
            '
        ]
    ],
];
