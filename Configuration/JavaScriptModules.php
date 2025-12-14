<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'dependencies' => [
        'backend',
    ],
    'tags' => [
        'backend.form',
        'backend.module',
    ],
    'imports' => [
        '@evoweb/sessionplaner/' => 'EXT:sessionplaner/Resources/Public/JavaScript/',
    ],
];
