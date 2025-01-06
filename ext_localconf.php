<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Evoweb\Sessionplaner\Controller\SessionController;
use Evoweb\Sessionplaner\Controller\SessionplanController;
use Evoweb\Sessionplaner\Controller\SpeakerController;
use Evoweb\Sessionplaner\Controller\SuggestController;
use Evoweb\Sessionplaner\Controller\TagController;
use Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die('Access denied.');

// PageTS
ExtensionManagementUtility::addPageTSConfig('@import \'EXT:sessionplaner/Configuration/PageTS/ModWizards.tsconfig\'');

// Register "sessionplannervh" as global fluid namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sessionplanervh'][] = 'Evoweb\\Sessionplaner\\ViewHelpers';

// Register Title Provider
ExtensionManagementUtility::addTypoScriptSetup(trim('
config.pageTitleProviders {
    event {
        provider = Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider
        before = seo
        after = altPageTitle
    }
    speaker {
        provider = Evoweb\Sessionplaner\TitleTagProvider\SpeakerTitleTagProvider
        before = seo
        after = altPageTitle
    }
}
'));

// Plugins
ExtensionUtility::configurePlugin(
    'Sessionplaner',
    'Session',
    [
        SessionController::class => 'list, show',
    ]
);
ExtensionUtility::configurePlugin(
    'Sessionplaner',
    'Sessionplan',
    [
        SessionplanController::class => 'display',
    ]
);
ExtensionUtility::configurePlugin(
    'Sessionplaner',
    'Speaker',
    [
        SpeakerController::class => 'list, show',
    ]
);
ExtensionUtility::configurePlugin(
    'Sessionplaner',
    'Suggest',
    [
        SuggestController::class => 'form',
    ],
    [
        SuggestController::class => 'form',
    ]
);
ExtensionUtility::configurePlugin(
    'Sessionplaner',
    'Tag',
    [
        TagController::class => 'show',
    ]
);

// Upgrades
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][SessionPathSegmentUpdate::class]
    = SessionPathSegmentUpdate::class;
