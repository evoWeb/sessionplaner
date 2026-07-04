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
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'typeicon_classes' => [
            'default' => 'actions-link',
        ],
    ],
    'columns' => [
        'link_text' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_link-linktext',
            'config' => [
                'type' => 'input',
                'max' => 256,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'link' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_link-link',
            'config' => [
                'type' => 'link',
                'required' => true,
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    link_text,
                    link,
            ',
        ],
    ],
];
