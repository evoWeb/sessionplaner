# 5.0.0

## FEATURE

- fc4dd7e [FEATURE] Create session tags detail pages (#41)
- 9c78bc9 [FEATURE] Allow to link back to session plan from session detail
- f365bbd [FEATURE] Show BE module name and current day in browser title
- d1218dd [FEATURE] Add replyTo header to suggest notification mail enabling direct response to sender
- ef1d308 [FEATURE] Add typoscript config for session suggest form to customize field list and labels
- e613b77 [FEATURE] Add fields for request type and no-recording to session record
- 5e93866 [FEATURE] Add day to slot label in TCA lists
- a90c190 [FEATURE] Limit values in slot select field of session to slots on selected day

## TASK

- a3a7758 [TASK] Switch to PHP-based Documentation Rendering
- cd56544 [TASK] Add field controls to speakers and session relations
- c4c96df [TASK] Refresh frontend rendering
- 352b37a [TASK] Add button for speaker, room and day to module
- cbb16bc [TASK] Hide speakers with no assigned sessions to schedule
- 778d275 [TASK] Show room seats in backend
- 6cc6d76 [TASK] Allow v12
- 34a7047 [TASK] Optimize spacing in backend module
- b3e95a9 [TASK] Link speaker in backend
- 77d3a5a [TASK] Add title to icons in backend module
- 6194b8a [TASK] Add links to slots in backend
- 2e283b2 [TASK] Link rooms in backend
- f3f6f20 [TASK] Fixate position of backend module
- c5e4d91 [TASK] Link day in backend view
- 7caf3c1 [TASK] Make backend module compatible with v12
- 361cbe7 [TASK] Drop html tags from templates
- 5851f60 [TASK] Limit ajax routes to post
- 6fd895a [TASK] Drop obsolete folder protection
- 99a91ae [TASK] Remove obsolete ordering comments
- e71451b [TASK] Make session repository compatible with v12
- 0fa5493 [TASK] Use imports
- d95dd84 [TASK] Remove obvious comment from services config
- 22caad0 [TASK] Add additional dev dependencies
- 36d318d [TASK] Migrate module registration
- 124fb87 [TASK] Migrate icon registration
- 8b1386b [TASK] Update structure
- a041c32 [TASK] Cleanup die() statements
- 6e886d2 [TASK] Update gitattributes
- 808c134 [TASK] Update editorconfig
- 3a376d4 [TASK] Remove obsolete softRef 'images'
- 52dfc3d [TASK] Make rte configuration uniform
- 092cf92 [TASK] Improve drag'n'drop in be module
- b478d65 [TASK] Use typo3 ci xliff linter
- 366325e [TASK] Switch linting and add cgl to ci
- d40ad55 [TASK] Update cgl fixer
- df85ea9 [TASK] Adapt workflows
- 55738cc [TASK] Use dev-main for core instead of master
- 3a70974 [TASK] Fixate testing framework version
- 7c799e6 [TASK] Allow TYPO3 12.x dev installation
- 16f067a [TASK] Set TYPO3 11.5 as minimum requirement
- 10ac06d [TASK] Format composer.json
- 49f0b18 [TASK] Use always ubuntu-latest for ci runners
- 3072f42 [TASK] Use actions/checkout@v3

## BUGFIX

- 1e0e2e2 [BUGFIX] Make `StringLengthValidator` configuration v12+ compatible (#34)
- 10284c3 [BUGFIX] Register `SuggestFormFactory` as service (#33)
- c18291d [BUGFIX] CGL
- 9c23d47 [BUGFIX] Display all tags in session planer frontend
- d41ae4c [BUGFIX] Correct label rendering
- c8871b2 [BUGFIX] Correct storage type condition
- 93b51da [BUGFIX] Reverse condition
- 4dad1a3 [BUGFIX] Corret date formatting
- 7fb82f8 [BUGFIX] Add missing namespaces
- 48a7bff [BUGFIX] Correct indention in xlf
- 46d40ee [BUGFIX] Correct v12 css vars
- 1247b62 [BUGFIX] Invalid viewhelper config
- 9bfb212 [BUGFIX] Avoid format.html in backend
- 4122236 [BUGFIX] Format break slot description in backend
- 3c56bcf [BUGFIX] Correct type of date to datetime
- 8c1635d [BUGFIX] Ensure module icon is displayed in v11
- e13b4be [BUGFIX] Ensure arguments can be accessed on v11
- 12d6fc3 [BUGFIX] Ignore storagepage on findAnyByUid
- 8648ed7 [BUGFIX] Use legacy module name
- 58f5447 [BUGFIX] Avoid processing slotlabel on new records
- e43ae38 [BUGFIX] Correct minimal dependencies
- f724637 [BUGFIX] Fixed some css issues with broken overides
- 49a32f9 [BUGFIX] Type issue with mixed '0' and 'null' values for empty objects
- 9a2c41f [BUGFIX] Wrong module identifier
- f3a7fd4 [BUGFIX] Allow more versions of overtrue/phplint
- 9dbe586 [BUGFIX] Fix return data of session controller

## MISC

- 1e7eb2a [CHORE] Update npm packages
- 5c13b27 Bump braces and gulp in /Build
- 8d829af Bump ip from 2.0.0 to 2.0.1 in /Build
- c256b07 Bump @babel/traverse from 7.22.5 to 7.23.2 in /Build
- eedbeeb Bump postcss and autoprefixer in /Build
- b288e7b Fix initialization of unittests on deploy
- 79126fc Fix broken drag´n´drop in BE module
- 62fd4a4 Add some screenshots and expand Documentation/Introduction.rst
- 4c91538 Remove the lazy marker from Slot::$day, as it causes type issues.
- 8eab2f7 Avoid error when room logo is not assigned
- b0a70f0 Remove object manager from SuggestFormFactory
- e84c1e4 Fix initialization of mail finisher.
- b681a22 Merge tag '4.0.0' into develop

## Contributors

- Andreas Kienast
- Andreas Kienast
- André Spindler
- André Spindler
- Benjamin Kott
- Chris Müller
- Larry Garfield
- Marvin Buchmann
- Philipp Zumstein
- Sandra Erbel
- Sebastian Fischer
- dependabot[bot]

# 4.0.0

## MISC

- 251e0a3 Change release package
- 29777cc Improve templates and viewhelpers
- 82562df Change ter release process
- 33a0ebc Modify default values
- 1717bd6 Replace use
- 7fddb61 Cleanup with php-cs-fixer
- 936ee88 Cleanup with rector and php-cs-fixer
- 449c184 Update npm package.json
- 79ffdc9 Change display of build status
- e9e45f5 Bump ini from 1.3.5 to 1.3.8 in /.Build
- c3c093a Change import
- 2c823b1 Use new @import to include dependency
- cccbbde Modify test
- be4aa04 Modify test
- 5458347 Modify test
- 45c74a2 Modify test
- b02a668 Fix initalization of session model
- bc30ee3 Fix type issue when setting session pid
- e453ad4 Replace deployment from travisci to gitlab actions
- e25bd08 Bump lodash from 4.17.15 to 4.17.19 in /.Build
- cbde8aa Replace copied classes with core class usage
- ef6d3d1 remove yaml options from typoscript
- ab4ca44 Merge tag '3.0.0' into develop

## Contributors

- André Spindler
- Sebastian Fischer
- dependabot[bot]

# 3.0.0

## FEATURE

- 5961938 [FEATURE] Make suggest form confirmation configurable
- a7974a4 [FEATURE] Enhance session submissions

## TASK

- 884ca22 [TASK] Improve suggest form

## BUGFIX

- c6adb41 [BUGFIX] Correct CGL by applying php-cs-fixer

## MISC

- 82e047f Remove 9.5 testing
- 2df79a3 Limit compatibility to 10.4 due to usage of Services.yaml
- 63c41fa Fix some errors after testing in backend
- cab3ab0 Remove duplicated language key
- fdcf76e Fix locallang xmlns
- 74421e9 Add xliff schema
- d3ef7d8 PSR-12 Cleanup and DI Optimization Restructure resource build pipeline
- a85cd8b Bump mixin-deep from 1.3.1 to 1.3.2
- b3b8f9d Bump lodash.merge from 4.6.1 to 4.6.2
- 63d22f2 Bump lodash from 4.17.11 to 4.17.15
- 9b0fd9f Merge tag '2.0.0' into develop

## Contributors

- Benjamin Kott
- Sebastian Fischer
- dependabot[bot]

# 2.0.0

## BREAKING

- f4198a9 [!!!][TASK] Remove unnused property no break after from slot
- 9be6699 [!!!][TASK] Drop unused viewhelpers for meta and title tags
- 6b62d41 [!!!][TASK] Rename editcontroller and differenciate templates
- ba577d7 [!!!][FEATURE] Allow individual slot configuration per day

## FEATURE

- 9102ed9 [FEATURE] Add website links for speakers
- d340234 [FEATURE] Add color support for tags
- 164434f [FEATURE] Allow management of hidden session in the backend
- ca5afc0 [FEATURE] Style speaker detail page
- 511d9f1 [FEATURE] Add gravatar support for speaker
- 32da56b [FEATURE] Enable rich text editor for speaker bio
- a9d02d3 [FEATURE] Enable rich-text editor for session descriptions
- 631537d [FEATURE] New frontend layout for sessionplan (#3)
- 962ccac [FEATURE] Add types to rooms
- 55bb937 [FEATURE] Enable descriptions for breaks
- 37c8342 [FEATURE] Add getter for endtime to slot
- 52daaab [FEATURE] Add optional speaker profiles  (#4)
- aed7c8e [FEATURE] Add path segments for sessions
- ba577d7 [!!!][FEATURE] Allow individual slot configuration per day
- 253b99c [FEATURE] Make all typoscript constants configurable through constant editor

## TASK

- 3bc8e1e [TASK] Correct cgl
- 6f902e2 [TASK] Added new link model, to add links or documents to sessions. (#5)
- 3131023 [TASK] Align tags in session planer
- 5be3a72 [TASK] Add support for 5 parallel tracks
- 287cbb8 [TASK] Disallow dropping of session into breaks
- cdb8f3b [TASK] Expose assigned speakers to the planning view
- 5581e63 [TASK] Show all unassigned sessions in backend module
- d72cf77 [TASK] Add session detail styling
- 4b42c45 [TASK] Style session listing
- 8e211d8 [TASK] Improve speaker listing
- ca61ab0 [TASK] Add speaker list styling
- ebb31cf [TASK] Split frontend scss
- 9cad66e [TASK] Use linkwrap for all speaker links
- 6c95b82 [TASK] Streamline section names
- 415f259 [TASK] Remove speaker detail pid
- aea0d18 [TASK] Do not disable error messages
- 8310b85 [TASK] Drop unessesary query for sessions
- c435ef1 [TASK] Cleanup sessionplan controller
- e0a3842 [TASK] Remove obsolete show forwarding in display action of sessionplaner
- 9d0a88b [TASK] Reformat all flexforms to match editorconfig
- 578db9a [TASK] Drop obsolete display controller
- f73b545 [TASK] Drop inaccessible show action from sessionplan controller
- 0a1bf51 [TASK] Drop unnused partial day
- f4198a9 [!!!][TASK] Remove unnused property no break after from slot
- 9be6699 [!!!][TASK] Drop unused viewhelpers for meta and title tags
- aaa5ead [TASK] Add comment to title provider registration
- 1e29fb8 [TASK] Remove call_user_func wrap
- 189e896 [TASK] Log compilation errors
- 6b62d41 [!!!][TASK] Rename editcontroller and differenciate templates
- 8321565 [TASK] Remove unsupported tempalte for edit controller
- 3507bbf [TASK] Add more indention headroom to sql definition
- 092f252 [TASK] Import classes in ajax controller
- e8e195a [TASK] Remove skipDefaultArguments
- 8b8c22a [TASK] Removed linting on PHP 7.0 and 7.1
- 9baddf4 [TASK] Drop realurl autoconfig for v9
- 5f37ac7 [TASK] Add break info to slot label
- bdda841 [TASK] Show endtime in slot records
- 717c0a5 [TASK] Correct content element wizard and streamline icons
- de7254e [TASK] Remove german translations and streamline language files
- acf56ea [TASK] Allow all fields to be editable when record permission exist
- 66d77c1 [TASK] Format SQL file
- 920764b [TASK] Streamline html formatting
- bdfb9e0 [TASK] Add editorconfig
- 9552e09 [TASK] Remove unused assets
- 35dd4ea [TASK] Apply CGL fixer and correct note about license file name
- bbb5e16 [TASK] Simplify asset building
- c61ec10 [TASK] Added Extbase validations
- ce09f87 [TASK] Added fallback for Fluid template paths
- 35429c9 [TASK] Fixed tsconfig markup
- f555ff9 [TASK] Added PHP CS fixer and .editorconfig file
- 4245ee4 [TASK] Added PHP CS fixer and .editorconfig file
- 28ec21d [TASK] Update travis-ci settings
- 32d0bf7 [TASK] Update travis-ci settings
- d82c079 [TASK] Make extension CMS9 compatible

## BUGFIX

- b314caa [BUGFIX] Restore routing for list view
- 6309b93 [BUGFIX] Ensure correct resolving of speakers and session in multisites
- e759df5 [BUGFIX] Correct loading order of page title provider
- 3ffce9c [BUGFIX] Add speaker title tag provider
- b8fd34e [BUGFIX] Correct false condition in speaker profile
- 66b3972 [BUGFIX] Enable hidden state for speaker records
- 861875b [BUGFIX] Now finally the tags are aligned
- 2bbca19 [BUGFIX] Always color tags
- 11308b2 [BUGFIX] Show speaker records also in session plan view
- 43d1d16 [BUGFIX] Correct cgl
- 777ec0d [BUGFIX] Correct use statements
- 5d04195 [BUGFIX] Avoid stretching of speaker images
- df2b573 [BUGFIX] Ensure room always delivers slots sorted
- 2baaf7a [BUGFIX] Ensure slots are always sorted correctly
- 0b0d72f [BUGFIX] Add streamline sorting for slot
- 96ffa1f [BUGFIX] Add streamline sorting for speaker
- 02fc454 [BUGFIX] Add streamline sorting for rooms
- cc6669d [BUGFIX] Enable company field
- 01c06b4 [BUGFIX] Use correct type for bidirectional connection
- 3174dcb [BUGFIX] Correct bidirecitonal connection of session and tags
- 0834f3e [BUGFIX] Ensure data persistence and js scoping is working correctly
- 683d7b9 [BUGFIX] Editing data after creation works again
- 2c455a0 [BUGFIX] Use correct module for day switching
- 66627af [BUGFIX] Disable new button if storage folder does not contain any rooms
- 82c7e43 [BUGFIX] Only check for slug properties on new object
- 36202c9 [BUGFIX] Make speaker optional
- 4a099d1 [BUGFIX] Ensure ensure sessions are validated correctly
- ba3c91a [BUGFIX] Add missing namespace to xlf file
- 8d0cd93 [BUGFIX]  Add missing userfunction
- 00f306d [BUGFIX] Allow session status to be editable in record view
- ca9c31e [BUGFIX] Correct typos in translations files
- e428a7f [BUGFIX] Enable session editing in backend record view
- 3784d87 [BUGFIX] Do not use datetime for hour and minute rendering
- e7d6856 [BUGFIX] Readme should state correct name of the extension

## MISC

- b416db6 Change version number
- 02fcd57 Fix spelling errors
- 9f21133 Fix html warning
- 1435944 Correct missing } in condition
- 74c374a Change registration of backend module
- 5cc39f0 Cleanup registerPlugin call
- c66fa38 Change version comparison
- d423adb Change core package to install for tests
- 91cc4e1 Modify travisci config
- 91c72cd Make compatible with TYPO3 10.x
- 1fc57a5 Remove php cs fixer call
- 9bed180 Merge changes from haassie
- a729166 Merge tag '1.0.1' into develop

## Contributors

- Benjamin Kott
- Chris Müller
- Naderio
- Richard Haeser
- Sebastian Fischer

# 1.0.1

## MISC

- a57699f Automatic rerelease of previous tag
- b817e33 Merge tag '1.0.0' into develop

## Contributors

- Sebastian Fischer

# 1.0.0

## MISC

- bda80f5 Use global ter-client
- 570ff38 Update .travis.yml
- 8aa6abe Merge tag '1.0.0' into develop
- d86ab6c Modify copyright date
- 3b64545 Remove 8.7 from testing because the compatibility was raised to 9.5 and higher
- 7108275 Remove deprecated second argument from ajax actions and replace with returning new Response object
- fa24d35 Cleanup php classes
- 135ac38 Cleanup flexform
- b89a2a0 Replace usage of deprecated functionality and raise minimal TYPO3 compatibility to 9.5

## Contributors

- Sebastian Fischer

# 0.9.0

## MISC

- df4fe55 Change readme
- 9d40c5a Improve build file
- d4927d6 Add filter on session to show only session of room of the day in current slot
- df3114c Compile sourcemap
- 09ade31 Improve sessionplaner css remove debug code
- b0565c6 Fix deleting newly create sessions from plan
- 0c4132c Add create session for room and slot
- 5543569 Add session button to cells
- b7f36ea Cleanup controllers Streamline ajax actions
- ae874ed Cleanup build process and Edit.js
- 13db8c4 Move extension icon
- 10f418f Add automatic version setting
- 6b3f147 Fix layout path
- 4328f8b Fix tca deprecations
- 228fdf2 Change suggestions handling
- b0cfb3d Replace reference to moved file
- a3b8773 Fix update card after storing update to database
- 00ba00e Fix moving card directly after creating
- f75f1ea Add unminified js files to ignore
- df2a280 Add deleting sessions from inside sessionplaner module
- 0ded877 tweak styling
- 672c405 Add functional css classes
- 65ab208 Add styles to form to position fields right of their labels
- 965c894 Improve sessioncards
- e278b43 Improve initialization Fix output of rooms if no session is assigned
- a32de3c Remove unneeded class
- 5a55fc0 Improve drag n drop handling
- 5db4eed Cchange llabels
- 477adeb Fix edit dialog not getting previous values
- 8fc1c8c Fix update to allow moving session to stash
- 3d33d6c Fix output of sessions in rooms
- 16ab7f9 Restore ajax update action
- 44684eb remove class that prevented drop allowance
- 397bd3f Fix draggable couldnt be droppped
- a3f968b Change adding parent values
- 6505fe5 Merge changes
- 142430f Fix moving element
- 4ea0c70 Add label tabs
- 8748a0b Fix styling
- 9333907 Improve drag and drop
- ab02801 Remove unneeded requirement
- ba4da9b Improve drag'n drop behaviour
- 58277df Cleanup jsdoc
- 2bbb539 Refactor module structure
- 60423a7 Modify edit modal
- 957330b Fix field type so extbase columnmap does not interprets it as relation
- 3b15a7f Fix modal dialog
- dbdfddc Add missing id
- a6a564c Update minification
- ef7a8b9 Javascript file was marked as modified by grund task
- ee89a7a Add .sass-cache to ignore
- c790358 Change translation and button rendering
- a4eb16e improve language labels
- eb14923 Fix button output
- e368c7f Add licence docu
- 2a98485 Cleanup extension
- d0ec730 Cleanup extension
- cc1054c Create composer.json
- ed8ffbc Initial commit

## Contributors

- Sebastian Fischer

