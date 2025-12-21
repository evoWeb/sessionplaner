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
        'title' => $languageFile . 'tx_sessionplaner_domain_model_slot',
        'label' => 'start',
        'label_userFunc' => \Evoweb\Sessionplaner\Userfuncs\Tca::class . '->slotLabel',
        'hideTable' => false, // @TEMP DISABLED
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY start',
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
            'default' => 'sessionplaner-record-slot',
        ],
    ],
    'columns' => [
        'day' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-day',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid=###CURRENT_PID### AND (tx_sessionplaner_domain_model_day.sys_language_uid IN (-1,0) OR tx_sessionplaner_domain_model_day.sys_language_uid = ###REC_FIELD_sys_language_uid###)',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'start' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-start',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'datetime',
                'format' => 'time',
                'required' => true,
            ],
        ],
        'duration' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-duration',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'number',
                'size' => 20,
                'required' => true,
                'default' => 45,
                'max' => 256,
            ],
        ],
        'break' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-break',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'check',
            ],
        ],
        'description' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-description',
            'config' => [
                'type' => 'text',
                'cols' => '80',
                'rows' => '15',
                'softref' => 'typolink_tag,email[subst],url',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
            'displayCond' => 'FIELD:break:REQ:true',
        ],
        'rooms' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-rooms',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID### AND (tx_sessionplaner_domain_model_room.sys_language_uid IN (-1,0) OR tx_sessionplaner_domain_model_room.sys_language_uid = ###REC_FIELD_sys_language_uid###)',
                'MM' => 'tx_sessionplaner_room_slot_mm',
                'MM_opposite_field' => 'slots',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    hidden,
                    day,
                    start,
                    duration,
                    break,
                    description,
                    rooms,
            ',
        ],
    ],
];
