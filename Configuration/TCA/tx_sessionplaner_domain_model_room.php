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
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-room'
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'name'
    ],
    'columns' => [
        'type' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', ''],
                    [$languageFile . 'tx_sessionplaner_domain_model_room-type-main', 'main'],
                    [$languageFile . 'tx_sessionplaner_domain_model_room-type-side', 'side'],
                ]
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'logo' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-logo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logo',
                ['maxitems' => 100],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'seats' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-seats',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'max' => 256,
            ],
        ],
        'days' => [
            'exclude' => false,
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
            'exclude' => false,
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
            'exclude' => false,
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
            type,
            name,
            logo,
            seats,
            days,
            slots,
            sessions,
            '
        ]
    ],
];
