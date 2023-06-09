#
# Table structure for table 'tx_sessionplaner_domain_model_day'
#
CREATE TABLE tx_sessionplaner_domain_model_day
(
    name            varchar(255) DEFAULT '' NOT NULL,
    date            varchar(255) DEFAULT '' NOT NULL,
    rooms           int(11) unsigned DEFAULT '0' NOT NULL,
    slots           int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_room'
#
CREATE TABLE tx_sessionplaner_domain_model_room
(
    type            varchar(255) DEFAULT '' NOT NULL,
    name            varchar(255) DEFAULT '' NOT NULL,
    logo            int(11) unsigned DEFAULT '0' NOT NULL,
    seats           int(11) unsigned DEFAULT '0' NOT NULL,

    days            int(11) unsigned DEFAULT '0' NOT NULL,
    slots           int(11) unsigned DEFAULT '0' NOT NULL,
    sessions        int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_slot'
#
CREATE TABLE tx_sessionplaner_domain_model_slot
(
    day             int(11) unsigned DEFAULT '0' NOT NULL,
    start           int(11) DEFAULT '0' NOT NULL,
    duration        int(11) unsigned DEFAULT '45' NOT NULL,
    break           tinyint(4) unsigned DEFAULT '0' NOT NULL,
    description     text,

    rooms           int(11) unsigned DEFAULT '0' NOT NULL,
    sessions        int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_session'
#
CREATE TABLE tx_sessionplaner_domain_model_session
(
    topic           varchar (255) DEFAULT '' NOT NULL,
    path_segment    varchar(2048),
    speaker         varchar(255) DEFAULT '' NOT NULL,
    twitter         varchar(255) DEFAULT '' NOT NULL,
    attendees       int(11) unsigned DEFAULT '0' NOT NULL,
    suggestion      tinyint(4) unsigned DEFAULT '0' NOT NULL,
    social          tinyint(4) unsigned DEFAULT '0' NOT NULL,
    donotlink       tinyint(4) unsigned DEFAULT '0' NOT NULL,
    type            int(11) unsigned DEFAULT '0' NOT NULL,
    level           int(11) unsigned DEFAULT '0' NOT NULL,
		requesttype     int(11) unsigned DEFAULT '0' NOT NULL,
		norecording     tinyint(4) unsigned DEFAULT '0' NOT NULL,
    description     text,

    # references
    speakers        int(11) unsigned DEFAULT '0' NOT NULL,
    day             int(11) unsigned,
    room            int(11) unsigned,
    slot            int(11) unsigned,
    tags            int(11) unsigned DEFAULT '0' NOT NULL,
    links           int(11) unsigned DEFAULT '0' NOT NULL,
    documents       int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_tag'
#
CREATE TABLE tx_sessionplaner_domain_model_tag
(
    label           varchar(255) DEFAULT '' NOT NULL,
    color           varchar(255) DEFAULT '' NOT NULL,
    sessions        int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_speaker'
#
CREATE TABLE tx_sessionplaner_domain_model_speaker
(
    name            varchar(255) DEFAULT '' NOT NULL,
    path_segment    varchar(2048),
    bio             text,
    company         varchar(255) DEFAULT '' NOT NULL,
    picture         int(11) unsigned DEFAULT '0' NOT NULL,

    website         varchar(255) DEFAULT '' NOT NULL,
    twitter         varchar(255) DEFAULT '' NOT NULL,
    linkedin        varchar(255) DEFAULT '' NOT NULL,
    xing            varchar(255) DEFAULT '' NOT NULL,
    email           varchar(255) DEFAULT '' NOT NULL,

    sessions        int(11) unsigned DEFAULT '0' NOT NULL,
    detail_page     int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_domain_model_link'
#
CREATE TABLE tx_sessionplaner_domain_model_link
(
    parentid        int(11) DEFAULT '0' NOT NULL,
    parenttable     varchar(255) DEFAULT '' NOT NULL,

    link            tinytext DEFAULT '' NOT NULL,
    link_text       tinytext DEFAULT '' NOT NULL
);

#
# Table structure for table 'tx_sessionplaner_day_room_mm'
#
CREATE TABLE tx_sessionplaner_day_room_mm
(
    uid_local       int(11) DEFAULT '0' NOT NULL,
    uid_foreign     int(11) DEFAULT '0' NOT NULL,
    sorting         int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    tablenames      varchar(255) DEFAULT '' NOT NULL,

    KEY             uid_local (uid_local),
    KEY             uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_sessionplaner_room_slot_mm'
#
CREATE TABLE tx_sessionplaner_room_slot_mm
(
    uid_local       int(11) DEFAULT '0' NOT NULL,
    uid_foreign     int(11) DEFAULT '0' NOT NULL,
    sorting         int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    tablenames      varchar(255) DEFAULT '' NOT NULL,

    KEY             uid_local (uid_local),
    KEY             uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_sessionplaner_session_tag_mm'
#
CREATE TABLE tx_sessionplaner_session_tag_mm
(
    uid_local       int(11) DEFAULT '0' NOT NULL,
    uid_foreign     int(11) DEFAULT '0' NOT NULL,
    sorting         int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    tablenames      varchar(255) DEFAULT '' NOT NULL,

    KEY             uid_local (uid_local),
    KEY             uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_sessionplaner_session_speaker_mm'
#
CREATE TABLE tx_sessionplaner_session_speaker_mm (
    uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY             uid_local (uid_local),
    KEY             uid_foreign (uid_foreign)
);
