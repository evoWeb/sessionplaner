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
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-tag'
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'start'
    ],
    'columns' => [
        'label' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_tag-label',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'sessions' => [
            'exclude' => false,
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
