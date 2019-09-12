<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    /**
     * Register "sessionplannervh" as global fluid namespace
     */
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sessionplanervh'][] =
        'Evoweb\\Sessionplaner\\ViewHelpers';

    /**
     * Register Icons
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $icons = [
        'plugin-display',
        'plugin-session',
        'plugin-suggest',
        'plugin-speaker',
        'record-day',
        'record-room',
        'record-session',
        'record-slot',
        'record-tag',
        'record-speaker',
    ];
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'sessionplaner-' . $icon,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:sessionplaner/Resources/Public/Icons/' . $icon . '.svg']
        );
    }

    /**
     * Add default PageTsConfig
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import \'EXT:sessionplaner/Configuration/PageTS/ModWizards.tsconfig\''
    );

    /**
     * Register Update Wizards
     */
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][
        \Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class
    ] = \Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class;

    if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) < 10000000) {
        // @todo remove once TYPO3 9.5.x support is dropped
        $extensionName = 'Evoweb.sessionplaner';
        $sessionController = 'Session';
        $sessionPlanController = 'Sessionplan';
        $speakerController = 'Speaker';
        $suggestController = 'Suggest';
    } else {
        $extensionName = 'Sessionplaner';
        $sessionController = \Evoweb\Sessionplaner\Controller\SessionController::class;
        $sessionPlanController = \Evoweb\Sessionplaner\Controller\SessionplanController::class;
        $speakerController = \Evoweb\Sessionplaner\Controller\SpeakerController::class;
        $suggestController = \Evoweb\Sessionplaner\Controller\SuggestController::class;
    }

    /**
     * Configure Session Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Session',
        [
            $sessionController => 'list, show',
        ]
    );

    /**
     * Configure Sessionplan Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Sessionplan',
        [
            $sessionPlanController => 'display',
        ]
    );

    /**
     * Configure Speaker Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Speaker',
        [
            $speakerController => 'list, show',
        ]
    );

    /**
     * Configure Suggest Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $extensionName,
        'Suggest',
        [
            $suggestController => 'new, create',
        ],
        [
            $suggestController => 'new, create',
        ]
    );

    /**
     * Register Title Provider
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        trim(
            '
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
'
        )
    );
});
