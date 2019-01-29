<?php

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_day');

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
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/iconmonstr-calendar-4_record.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'name'
    ],
    'columns' => [
        'name' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max'  => 256,
            ],
        ],
        'date' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 20,
                'eval' => 'date'
            ],
        ],
        'rooms' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-rooms',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_day_room_mm',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ],
        ],
        'slots' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_day-slots',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID###
                    ORDER BY tx_sessionplaner_domain_model_slot.start',
                'MM' => 'tx_sessionplaner_day_slot_mm',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 100,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
            name,
            date,
            rooms,
            slots
            '
        ]
    ],
];
