<?php

$EM_CONF['sessionplaner'] = [
    'title' => 'Session Planer',
    'description' => 'Plan and display sessions for bar camp like events',
    'category' => 'misc',
    'author' => 'Sebastian Fischer, Benjamin Kott',
    'author_email' => 'typo3@evoweb.de, benjamin.kott@outlook.com',
    'author_company' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '2.0.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
    ],
];
