mod.wizards {
    newContentElement {
        wizardItems {
            plugins {
                elements {
                    sessionplaner_display {
                        icon = gfx/c_wiz/regular_text.gif
                        title = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_sessionplan
                        description = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_sessionplan_description
                        tt_content_defValues {
                            CType = list
                            list_type = sessionplaner_sessionplan
                        }
                    }
                    sessionplaner_suggest {
                        icon = gfx/c_wiz/regular_text.gif
                        title = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_suggest
                        description = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_suggest_description
                        tt_content_defValues {
                            CType = list
                            list_type = sessionplaner_suggest
                        }
                    }
                    sessionplaner_session {
                        icon = gfx/c_wiz/regular_text.gif
                        title = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_session
                        description = LLL:EXT:sessionplaner/Resources/Private/Language/locallang_be.xml:tt_content.list_type_session_description
                        tt_content_defValues {
                            CType = list
                            list_type = sessionplaner_session
                        }
                    }
                }
                show = *
            }
        }
    }
}