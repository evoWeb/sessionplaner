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

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_link');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_link',
        'label' => 'link',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'typeicon_classes' => [
            'default' => 'actions-link'
        ],
    ],
    'columns' => [
        'link_text' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_link-linktext',
            'config' => [
                'type' => 'input',
                'max' => 255,
                'eval' => 'trim,required',
            ],
        ],
        'link' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_link-link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'eval' => 'required',
            ],
        ],
    ],
    'palettes' => [
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    link_text,
                    link,
            '
        ]
    ],
];
