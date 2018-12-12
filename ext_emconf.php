<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF['sessionplaner'] = [
    'title' => 'Session Planer',
    'description' => '',
    'category' => 'misc',
    'author' => 'Sebastian Fischer, Benjamin Kott',
    'author_email' => 'typo3@evoweb.de, benjamin.kott@outlook.com',
    'author_company' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload-dev' => [
        'psr-4' => [
            'Evoweb\\Sessionplaner\\Tests\\' => 'Tests/',
        ],
    ],
];
