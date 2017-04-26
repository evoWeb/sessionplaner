<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_day',
        'label' => 'name',
        'label_alt' => 'date',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY date',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_day.png'
    ),
    'interface' => array(
        'showRecordFieldList' => 'name'
    ),
    'columns' => array(
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_day-name',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max'  => 256,
            ),
        ),
        'date' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_day-date',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'date',
                'max'  => 256,
            ),
        ),
        'rooms' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_day-rooms',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_day_room_mm',
                'size' => 6,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ),
        ),
        'slots' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_day-slots',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_slot',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_slot.pid = ###CURRENT_PID### ORDER BY tx_sessionplaner_domain_model_slot.start',
                'MM' => 'tx_sessionplaner_day_slot_mm',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 100,
            ),
        ),
    ),
    'types' => array(
        '0' => array('showitem' => '
            name,
            date,
            rooms,
            slots
        ')
    ),
);
