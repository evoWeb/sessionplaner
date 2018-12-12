mod.wizards.newContentElement.wizardItems
{
  plugins.elements
  {
    sessionplaner_display
    {
      iconIdentifier = content - text
      title = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_sessionplan
      description = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_sessionplan_description
      tt_content_defValues
      {
        CType = list
        list_type = sessionplaner_sessionplan
      }
    }
    sessionplaner_suggest
    {
      iconIdentifier = content - text
      title = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_suggest
      description = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_suggest_description
      tt_content_defValues
      {
        CType = list
        list_type = sessionplaner_suggest
      }
    }
    sessionplaner_session
    {
      iconIdentifier = content - text
      title = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_session
      description = LLL
    :
      EXT:sessionplaner / Resources / Private / Language / locallang_be.xlf
    :
      tt_content.list_type_session_description
      tt_content_defValues
      {
        CType = list
        list_type = sessionplaner_session
      }
    }
  }
  plugins.show
:
  = addToList(sessionplaner_display)
  plugins.show
:
  = addToList(sessionplaner_suggest)
  plugins.show
:
  = addToList(sessionplaner_session)
}
