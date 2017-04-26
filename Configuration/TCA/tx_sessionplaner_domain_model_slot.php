<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot',
        'label' => 'start',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY start',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_slot.png',
    ),
    'interface' => array(
        'showRecordFieldList' => 'start'
    ),
    'columns' => array(
        'start' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot-start',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'time,required',
                'max' => 256,
            ),
        ),
        'duration' => array(
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot-duration',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'int,trim,required',
                'default' => 45,
                'max' => 256,
            )
        ),
        'break' => array(
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot-break',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'days' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot-days',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_day',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_day.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_day_slot_mm',
                'MM_opposite_field' => 'slots',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ),
        ),
        'rooms' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_slot-rooms',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sessionplaner_domain_model_room',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_room.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_room_slot_mm',
                'MM_opposite_field' => 'slots',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 100,
                'autoSizeMax' => 20,
            ),
        ),
    ),
    'types' => array(
        '0' => array(
            'showitem' => '
            start,
            duration,
            break,
            days,
            rooms
        '
        )
    ),
);
