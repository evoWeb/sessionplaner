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
            'default' => 'sessionplaner-record-room',
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
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'type' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-type',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
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
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'required' => true,
                'max' => 256,
            ],
        ],
        'logo' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-logo',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
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
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'number',
                'size' => 20,
                'max' => 256,
            ],
        ],
        'days' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_room-days',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID### AND (tx_sessionplaner_domain_model_day.sys_language_uid IN (-1,0) OR tx_sessionplaner_domain_model_day.sys_language_uid = ###REC_FIELD_sys_language_uid###)
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
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID### AND (tx_sessionplaner_domain_model_slot.sys_language_uid IN (-1,0) OR tx_sessionplaner_domain_model_slot.sys_language_uid = ###REC_FIELD_sys_language_uid###)
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
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID### AND (tx_sessionplaner_domain_model_session.sys_language_uid IN (-1,0) OR tx_sessionplaner_domain_model_session.sys_language_uid = ###REC_FIELD_sys_language_uid###)',
                'foreign_field' => 'room',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    hidden,
                    sys_language_uid,
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
