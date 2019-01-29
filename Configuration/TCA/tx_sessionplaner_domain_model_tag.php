<?php

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_tag');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_tag',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY label',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/iconmonstr-calendar-4_record.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'start'
    ],
    'columns' => [
        'label' => [
            'exclude' => 0,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_tag-label',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'sessions' => [
            'label' => $languageFile . 'tx_sessionplaner_domain_model_tag-sessions',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_sessionplaner_domain_model_tag',
                // needed for extbase query
                'foreign_table' => 'tx_sessionplaner_domain_model_tag',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_tag.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_tag_mm',
                'MM_opposite_field' => 'sessions',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                label,
                sessions
            '
        ]
    ],
];
