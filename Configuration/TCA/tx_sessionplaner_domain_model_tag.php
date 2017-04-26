<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_tag',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY label',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'iconfile' => 'EXT:sessionplaner/Resources/Public/Icons/sessionplaner_tag.png',
    ),
    'interface' => array(
        'showRecordFieldList' => 'start'
    ),
    'columns' => array(
        'label' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_tag-label',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ),
        ),
        'sessions' => array(
            'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xml:tx_sessionplaner_domain_model_tag-sessions',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_sessionplaner_domain_model_tag',
                // needed for extbase query
                'foreign_table' => 'tx_sessionplaner_domain_model_tag',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_tag.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_tag_mm',
                'MM_opposite_field' => 'sessions',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            ),
        ),
    ),
    'types' => array(
        '0' => array(
            'showitem' => '
            label,
            sessions
        '
        )
    ),
);
