<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

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
        'color' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_tag-color',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', ''],
                    ['TYPO3', 'typo3'],
                    ['RED', 'red'],
                    ['PINK', 'pink'],
                    ['PURPLE', 'purple'],
                    ['DEEP PURPLE', 'deeppurple'],
                    ['INDIGO', 'indigo'],
                    ['BLUE', 'blue'],
                    ['LIGHT BLUE', 'lightblue'],
                    ['CYAN', 'cyan'],
                    ['TEAL', 'teal'],
                    ['GREEN', 'green'],
                    ['LIGHT GREEN', 'lightgreen'],
                    ['LIME', 'lime'],
                    ['YELLOW', 'yellow'],
                    ['AMBER', 'amber'],
                    ['ORANGE', 'orange'],
                    ['DEEP ORANGE', 'deeporange'],
                    ['BROWN', 'brown'],
                    ['GREY', 'grey'],
                    ['BLUE GREY', 'bluegrey'],
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'default' => '',
            ],
        ],
        'sessions' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_tag-sessions',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_tag_mm',
                'MM_opposite_field' => 'tags',
                'minitems' => 0,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                label,
                color,
                sessions
            '
        ]
    ],
];
