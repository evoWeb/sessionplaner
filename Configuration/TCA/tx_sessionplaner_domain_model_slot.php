<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_slot');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_slot',
        'label' => 'start',
        'label_userFunc' => \Evoweb\Sessionplaner\Userfuncs\Tca::class . '->slotLabel',
        'hideTable' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY start',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-slot'
        ],
    ],
    'columns' => [
        'day' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-day',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid=###CURRENT_PID###',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'start' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-start',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'time,required',
            ],
        ],
        'duration' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-duration',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'int,trim,required',
                'default' => 45,
                'max' => 256,
            ]
        ],
        'break' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-break',
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
                'richtextConfiguration' => 'default'
            ],
            'displayCond' => 'FIELD:break:REQ:true'
        ],
        'rooms' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_slot-rooms',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
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
                day,
                start,
                duration,
                break,
                description,
                rooms,
            '
        ]
    ],
];
