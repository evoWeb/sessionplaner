<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::registerPageTSConfigFile(
    'sessionplaner',
    'Configuration/PageTS/mod.tsconfig',
    'Limit to sessionplaner records',
);
