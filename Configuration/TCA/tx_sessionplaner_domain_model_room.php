<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_room',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY name',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-room',
        ],
    ],
    'columns' => [
        'type' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => ''],
                    ['label' => $languageFile . 'tx_sessionplaner_domain_model_room-type-main', 'value' => 'main'],
                    ['label' => $languageFile . 'tx_sessionplaner_domain_model_room-type-side', 'value' => 'side'],
                ],
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 255,
            ],
        ],
        'logo' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-logo',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 100,
            ],
        ],
        'seats' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-seats',
            'config' => [
                'type' => 'number',
                'range' => [
                    'lower' => 1,
                ],
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
                'type' => 'inline',
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID###',
                'foreign_field' => 'room',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    type,
                    name,
                    logo,
                    seats,
                    days,
                    slots,
            ',
        ],
    ],
];
