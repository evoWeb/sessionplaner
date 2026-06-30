#!/usr/bin/env php
<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

if (PHP_SAPI !== 'cli') {
    die('Script must be called from command line.' . chr(10));
}

$host = getenv('typo3DatabaseHost');
$name = getenv('typo3DatabaseName');
$user = getenv('typo3DatabaseUsername');
$password = getenv('typo3DatabasePassword');

if ($host === false || $name === false || $user === false || $password === false) {
    fwrite(STDERR, 'Database environment variables are not set – skipping test data import.' . PHP_EOL);
    exit(0);
}

$pdo = new PDO(
    sprintf('mysql:host=%s;dbname=%s', $host, $name),
    $user,
    $password,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$statement = $pdo->prepare(
    'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = :schema'
);
$statement->execute(['schema' => $name]);
$tableCount = (int)$statement->fetchColumn();

if ($tableCount > 0) {
    echo sprintf('Database already contains %d tables – skipping test data import.', $tableCount) . PHP_EOL;
    exit(0);
}

echo 'Database is empty – importing test data.' . PHP_EOL;

$sqlFile = __DIR__ . '/../testdatabase.sql';
passthru('typo3 database:import < ' . escapeshellarg($sqlFile), $exitCode);

exit($exitCode);