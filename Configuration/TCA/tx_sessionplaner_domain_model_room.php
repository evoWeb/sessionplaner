<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_room.png',
    ),
    'interface' => array(
        'showRecordFieldList' => 'name'
    ),
    'columns' => array(
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-name',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ),
        ),
        'logo' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-logo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo', array(
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                    ),
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                    --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
				    --palette--;;filePalette'
                        ),
                    ),
                    'minitems' => 0,
                    'maxitems' => 1,
                ), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ),
        'seats' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-seats',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'max' => 256,
            ),
        ),
        'days' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-days',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID### ORDER BY tx_sessionplaner_domain_model_day.name',
                'MM' => 'tx_sessionplaner_day_room_mm',
                'MM_opposite_field' => 'rooms',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
            ),
        ),
        'slots' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-slots',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID### ORDER BY tx_sessionplaner_domain_model_slot.start',
                'MM' => 'tx_sessionplaner_room_slot_mm',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 100,
            ),
        ),
        'sessions' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_room-sessions',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID###',
                'foreign_field' => 'room',
                'size' => 5,
                'autoSizeMax' => 20,
            ),
        ),
    ),
    'types' => array(
        '0' => array(
            'showitem' => '
            name,
            logo,
            seats,
            days,
            slots,
            sessions
        ')
    ),
);
