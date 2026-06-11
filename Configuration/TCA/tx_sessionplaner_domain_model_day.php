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
        'title' => $languageFile . 'tx_sessionplaner_domain_model_day',
        'label' => 'name',
        'label_alt' => 'date',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY date',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-day',
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => false,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'sys_language_uid' => [
            'exclude' => false,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'date' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-date',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'size' => 20,
            ],
        ],
        'rooms' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-rooms',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID### AND tx_sessionplaner_domain_model_room.sys_language_uid IN (-1,0)',
                'MM' => 'tx_sessionplaner_day_room_mm',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ],
        ],
        'slots' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-slots',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_field' => 'day',
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                ],
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    hidden,
                    sys_language_uid,
                    name,
                    date,
                    rooms,
                    slots
            ',
        ],
    ],
];
