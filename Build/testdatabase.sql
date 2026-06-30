
--
-- Table structure for table `be_users`
--

DROP TABLE IF EXISTS `be_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `be_users` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `disable` smallint unsigned NOT NULL DEFAULT '0',
  `starttime` int unsigned NOT NULL DEFAULT '0',
  `endtime` int unsigned NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `uc` mediumblob DEFAULT (NULL),
  `user_settings` json DEFAULT (NULL),
  `workspace_id` int NOT NULL DEFAULT '0',
  `mfa` mediumblob DEFAULT (NULL),
  `password_reset_token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `usergroup` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `avatar` int unsigned NOT NULL DEFAULT '0',
  `db_mountpoints` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `file_mountpoints` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `realName` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `admin` smallint unsigned NOT NULL DEFAULT '0',
  `options` smallint unsigned NOT NULL DEFAULT '3',
  `file_permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `workspace_perms` smallint unsigned NOT NULL DEFAULT '1',
  `lang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `userMods` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `allowed_languages` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `TSconfig` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `tsconfig_includes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lastlogin` bigint NOT NULL DEFAULT '0',
  `category_perms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `parent` (`pid`,`deleted`,`disable`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_users`
--

LOCK TABLES `be_users` WRITE;
/*!40000 ALTER TABLE `be_users` DISABLE KEYS */;
INSERT INTO `be_users` VALUES (1,0,1782839300,1782839300,0,0,0,0,NULL,_binary 'a:4:{s:10:\"moduleData\";a:0:{}s:14:\"emailMeAtLogin\";i:0;s:8:\"titleLen\";i:50;s:20:\"edit_docModuleUpload\";s:1:\"1\";}','{\"titleLen\": 50, \"emailMeAtLogin\": 0, \"edit_docModuleUpload\": \"1\"}',0,NULL,'','_cli_','$argon2i$v=19$m=65536,t=16,p=1$bHFNWHpxbnNPVUNIRDhEWA$Ce1S4OzW8s98BU7YAyd+6jAiw9WvVowPdutmjsoWNkI','',0,NULL,'','','',1,3,NULL,1,'en',NULL,'',NULL,'',0,NULL),(2,0,1782839302,1782839302,0,0,0,0,NULL,_binary 'a:7:{s:10:\"moduleData\";a:5:{s:10:\"web_layout\";a:3:{s:8:\"viewMode\";s:1:\"2\";s:10:\"showHidden\";b:1;s:9:\"languages\";a:1:{i:0;i:1;}}s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";a:0:{}s:16:\"browse_links.php\";a:1:{s:10:\"expandPage\";s:1:\"5\";}s:19:\"web_FormFormbuilder\";a:1:{s:6:\"action\";s:12:\"form_manager\";}s:7:\"records\";a:4:{s:9:\"clipBoard\";b:1;s:9:\"searchBox\";b:0;s:15:\"collapsedTables\";a:0:{}s:9:\"languages\";a:1:{i:0;i:0;}}}s:14:\"emailMeAtLogin\";i:0;s:8:\"titleLen\";i:50;s:20:\"edit_docModuleUpload\";s:1:\"1\";s:15:\"moduleSessionID\";a:5:{s:10:\"web_layout\";s:40:\"9d619cfc51e3de41a371ef7fa7bf5cc5bf1f97ea\";s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";s:40:\"9d619cfc51e3de41a371ef7fa7bf5cc5bf1f97ea\";s:16:\"browse_links.php\";s:40:\"9d619cfc51e3de41a371ef7fa7bf5cc5bf1f97ea\";s:19:\"web_FormFormbuilder\";s:40:\"9d619cfc51e3de41a371ef7fa7bf5cc5bf1f97ea\";s:7:\"records\";s:40:\"9d619cfc51e3de41a371ef7fa7bf5cc5bf1f97ea\";}s:13:\"pageLanguages\";a:2:{i:3;a:1:{i:0;i:1;}i:2;a:1:{i:0;i:0;}}s:10:\"inlineView\";s:105:\"{\"tx_sessionplaner_domain_model_day\":{\"1\":{\"tx_sessionplaner_domain_model_slot\":[1,2,3,4,5,6,7,8,9,10]}}}\";}','{\"titleLen\": 50, \"emailMeAtLogin\": 0, \"edit_docModuleUpload\": \"1\"}',0,NULL,'','sessionplaner','$argon2i$v=19$m=65536,t=16,p=1$bjdKdVhDelVVMUFJOGZqNA$LWJv20GA9DovWh+Fa2clwmAAZUswwjjZ2zdJ+QdyGjI','',0,NULL,'','','',1,3,NULL,1,'default',NULL,'',NULL,'',1782839310,NULL);
/*!40000 ALTER TABLE `be_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `starttime` int unsigned NOT NULL DEFAULT '0',
  `endtime` int unsigned NOT NULL DEFAULT '0',
  `fe_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sorting` int NOT NULL DEFAULT '0',
  `rowDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `editlock` smallint unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int NOT NULL DEFAULT '0',
  `l10n_parent` int unsigned NOT NULL DEFAULT '0',
  `l10n_source` int unsigned NOT NULL DEFAULT '0',
  `l10n_state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `l10n_diffsource` mediumblob DEFAULT (NULL),
  `t3ver_oid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_wsid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_state` smallint NOT NULL DEFAULT '0',
  `t3ver_stage` int NOT NULL DEFAULT '0',
  `perms_userid` int unsigned NOT NULL DEFAULT '0',
  `perms_groupid` int unsigned NOT NULL DEFAULT '0',
  `perms_user` smallint unsigned NOT NULL DEFAULT '0',
  `perms_group` smallint unsigned NOT NULL DEFAULT '0',
  `perms_everybody` smallint unsigned NOT NULL DEFAULT '0',
  `SYS_LASTCHANGED` int unsigned NOT NULL DEFAULT '0',
  `shortcut` int unsigned NOT NULL DEFAULT '0',
  `content_from_pid` int unsigned NOT NULL DEFAULT '0',
  `mount_pid` int unsigned NOT NULL DEFAULT '0',
  `sitemap_priority` decimal(2,1) NOT NULL DEFAULT '0.5',
  `nav_icon_set` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nav_icon_identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nav_icon` int unsigned DEFAULT '0',
  `thumbnail` int unsigned DEFAULT '0',
  `doktype` int unsigned NOT NULL DEFAULT '1',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `TSconfig` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `php_tree_stop` smallint unsigned NOT NULL DEFAULT '0',
  `categories` int unsigned NOT NULL DEFAULT '0',
  `layout` int unsigned NOT NULL DEFAULT '0',
  `extendToSubpages` smallint unsigned NOT NULL DEFAULT '0',
  `nav_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nav_hide` smallint unsigned NOT NULL DEFAULT '0',
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT (_utf8mb4''),
  `lastUpdated` bigint NOT NULL DEFAULT '0',
  `newUntil` bigint NOT NULL DEFAULT '0',
  `cache_timeout` int unsigned NOT NULL DEFAULT '0',
  `cache_tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `no_search` smallint unsigned NOT NULL DEFAULT '0',
  `shortcut_mode` int unsigned NOT NULL DEFAULT '0',
  `keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `abstract` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `media` int unsigned NOT NULL DEFAULT '0',
  `is_siteroot` smallint unsigned NOT NULL DEFAULT '0',
  `mount_pid_ol` smallint NOT NULL DEFAULT '0',
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `l18n_cfg` smallint unsigned NOT NULL DEFAULT '0',
  `backend_layout` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backend_layout_next_level` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tsconfig_includes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `seo_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `no_index` smallint unsigned NOT NULL DEFAULT '0',
  `no_follow` smallint unsigned NOT NULL DEFAULT '0',
  `sitemap_changefreq` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `canonical_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT (_utf8mb4''),
  `og_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `og_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `og_image` int unsigned NOT NULL DEFAULT '0',
  `twitter_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `twitter_image` int unsigned NOT NULL DEFAULT '0',
  `twitter_card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `determineSiteRoot` (`is_siteroot`),
  KEY `contentFromPid` (`content_from_pid`),
  KEY `slug` (`slug`(127)),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `language_identifier` (`l10n_parent`,`sys_language_uid`),
  KEY `translation_source` (`l10n_source`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,1782844700,1782844198,0,0,0,0,'',256,NULL,0,0,0,0,NULL,_binary '{\"TSconfig\":\"\",\"abstract\":\"\",\"author\":\"\",\"author_email\":\"\",\"backend_layout\":\"\",\"backend_layout_next_level\":\"\",\"categories\":\"\",\"doktype\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"extendToSubpages\":\"\",\"fe_group\":\"\",\"hidden\":\"\",\"is_siteroot\":\"\",\"l18n_cfg\":\"\",\"lastUpdated\":\"\",\"layout\":\"\",\"media\":\"\",\"nav_hide\":\"\",\"nav_icon\":\"\",\"nav_icon_set\":\"\",\"nav_title\":\"\",\"newUntil\":\"\",\"no_search\":\"\",\"php_tree_stop\":\"\",\"rowDescription\":\"\",\"shortcut\":\"\",\"shortcut_mode\":\"\",\"slug\":\"\",\"starttime\":\"\",\"subtitle\":\"\",\"target\":\"\",\"thumbnail\":\"\",\"title\":\"\",\"tsconfig_includes\":\"\"}',0,0,0,0,2,0,31,27,0,1782844224,0,0,0,0.5,'','',0,0,4,'Root','/',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,1,NULL,NULL,NULL,'','',0,1,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(2,1,1782846470,1782844319,0,0,0,0,'0',256,NULL,0,0,0,0,NULL,_binary '{\"TSconfig\":\"\",\"backend_layout\":\"\",\"backend_layout_next_level\":\"\",\"categories\":\"\",\"doktype\":\"\",\"editlock\":\"\",\"hidden\":\"\",\"media\":\"\",\"module\":\"\",\"rowDescription\":\"\",\"slug\":\"\",\"title\":\"\",\"tsconfig_includes\":\"\"}',0,0,0,0,2,1,31,31,0,0,0,0,0,0.5,'','',0,0,254,'Sessions','/sessions',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','','EXT:sessionplaner/Configuration/PageTS/mod.tsconfig','',0,0,'','','',NULL,0,'',NULL,0,''),(3,1,1782844629,1782844354,0,0,0,0,'',128,NULL,0,0,0,0,NULL,_binary '{\"TSconfig\":\"\",\"abstract\":\"\",\"author\":\"\",\"author_email\":\"\",\"backend_layout\":\"\",\"backend_layout_next_level\":\"\",\"cache_tags\":\"\",\"cache_timeout\":\"\",\"canonical_link\":\"\",\"categories\":\"\",\"content_from_pid\":\"\",\"description\":\"\",\"doktype\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"extendToSubpages\":\"\",\"fe_group\":\"\",\"hidden\":\"\",\"is_siteroot\":\"\",\"keywords\":\"\",\"l18n_cfg\":\"\",\"lastUpdated\":\"\",\"layout\":\"\",\"media\":\"\",\"module\":\"\",\"nav_hide\":\"\",\"nav_icon\":\"\",\"nav_icon_set\":\"\",\"nav_title\":\"\",\"newUntil\":\"\",\"no_follow\":\"\",\"no_index\":\"\",\"no_search\":\"\",\"og_description\":\"\",\"og_image\":\"\",\"og_title\":\"\",\"php_tree_stop\":\"\",\"rowDescription\":\"\",\"seo_title\":\"\",\"sitemap_changefreq\":\"\",\"sitemap_priority\":\"\",\"slug\":\"\",\"starttime\":\"\",\"subtitle\":\"\",\"target\":\"\",\"thumbnail\":\"\",\"title\":\"\",\"tsconfig_includes\":\"\",\"twitter_card\":\"\",\"twitter_description\":\"\",\"twitter_image\":\"\",\"twitter_title\":\"\"}',0,0,0,0,2,1,31,31,0,1782845709,0,0,0,0.5,'','',0,0,1,'Sessionplan','/sessionplan',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(4,1,1782844390,1782844386,0,0,0,0,'0',192,NULL,0,0,0,0,NULL,_binary '{\"hidden\":\"\"}',0,0,0,0,2,1,31,31,0,1782844410,0,0,0,0.5,'','',0,0,1,'Tag','/tag',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(5,1,1782844640,1782844421,0,0,0,0,'0',176,NULL,0,0,0,0,NULL,_binary '{\"hidden\":\"\"}',0,0,0,0,2,1,31,31,0,1782844640,0,0,0,0.5,'','',0,0,1,'Session','/session',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(6,1,1782844644,1782844439,0,0,0,0,'0',184,NULL,0,0,0,0,NULL,_binary '{\"hidden\":\"\"}',0,0,0,0,2,1,31,31,0,1782844644,0,0,0,0.5,'','',0,0,1,'Speaker','/speaker',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(7,1,1782844635,1782844462,0,0,0,0,'0',160,NULL,0,0,0,0,NULL,_binary '{\"hidden\":\"\"}',0,0,0,0,2,1,31,31,0,1782844635,0,0,0,0.5,'','',0,0,1,'Suggest','/suggest',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','',NULL,'',0,0,'','','',NULL,0,'',NULL,0,''),(8,1,1782844726,1782844726,0,1,0,0,'0',128,NULL,0,1,3,3,'{\"nav_hide\":\"parent\",\"link\":\"parent\",\"lastUpdated\":\"parent\",\"newUntil\":\"parent\",\"no_search\":\"parent\",\"shortcut\":\"parent\",\"shortcut_mode\":\"parent\",\"content_from_pid\":\"parent\",\"author\":\"parent\",\"author_email\":\"parent\",\"media\":\"parent\",\"starttime\":\"parent\",\"endtime\":\"parent\",\"og_image\":\"parent\",\"twitter_image\":\"parent\"}',_binary '{\"TSconfig\":\"\",\"author\":\"\",\"author_email\":\"\",\"backend_layout\":\"\",\"backend_layout_next_level\":\"\",\"cache_tags\":\"\",\"cache_timeout\":\"0\",\"categories\":\"0\",\"content_from_pid\":\"0\",\"doktype\":\"1\",\"editlock\":\"0\",\"endtime\":\"0\",\"extendToSubpages\":\"0\",\"hidden\":\"0\",\"is_siteroot\":\"0\",\"l10n_source\":\"0\",\"l18n_cfg\":\"0\",\"lastUpdated\":\"0\",\"layout\":\"0\",\"link\":\"\",\"media\":\"0\",\"module\":\"\",\"mount_pid\":\"0\",\"mount_pid_ol\":\"0\",\"nav_hide\":\"0\",\"nav_icon\":\"0\",\"nav_icon_identifier\":\"\",\"nav_icon_set\":\"\",\"newUntil\":\"0\",\"no_follow\":\"0\",\"no_index\":\"0\",\"no_search\":\"0\",\"og_image\":\"0\",\"php_tree_stop\":\"0\",\"shortcut\":\"0\",\"shortcut_mode\":\"0\",\"sitemap_priority\":\"0.5\",\"slug\":\"\\/sessionplan\",\"starttime\":\"0\",\"target\":\"\",\"thumbnail\":\"0\",\"title\":\"Sessionplan\",\"tsconfig_includes\":\"\",\"twitter_card\":\"\",\"twitter_image\":\"0\"}',0,0,0,0,2,1,31,31,0,0,0,0,0,0.5,'','',0,0,1,'[Translate to Deutsch:] Sessionplan','/translate-to-deutsch-sessionplan',NULL,0,0,0,0,'',0,'','','',0,0,0,'',0,0,NULL,NULL,NULL,'','',0,0,0,'',0,'','','','',0,0,'','','',NULL,0,'',NULL,0,'');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file`
--

DROP TABLE IF EXISTS `sys_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_file` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `last_indexed` int NOT NULL DEFAULT '0',
  `identifier` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `identifier_hash` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder_hash` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `sha1` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `creation_date` int NOT NULL DEFAULT '0',
  `modification_date` int NOT NULL DEFAULT '0',
  `size` bigint NOT NULL DEFAULT '0',
  `storage` int unsigned NOT NULL DEFAULT '0',
  `type` int unsigned NOT NULL DEFAULT '0',
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `missing` smallint unsigned NOT NULL DEFAULT '0',
  `metadata` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `sel01` (`storage`,`identifier_hash`),
  KEY `folder` (`storage`,`folder_hash`),
  KEY `tstamp` (`tstamp`),
  KEY `lastindex` (`last_indexed`),
  KEY `sha1` (`sha1`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file`
--

LOCK TABLES `sys_file` WRITE;
/*!40000 ALTER TABLE `sys_file` DISABLE KEYS */;
INSERT INTO `sys_file` VALUES (1,0,1782844250,1782844250,'/_assets/9b80d86a98af3ecc38aabe297d2c3695/Images/BootstrapPackage.svg','760d1af8a806b3df149ba4826a7f15c966215a7c','5e8c86041e2022a51f63bbaf56b3ae90109db902','svg','BootstrapPackage.svg','c57287d7c99a50c84cfb15cd5f1385cd9a4fc998',1782842270,1764687426,3700,0,2,'image/svg+xml',0,0),(2,0,1782844250,1782844250,'/_assets/9b80d86a98af3ecc38aabe297d2c3695/Images/BootstrapPackageInverted.svg','f4a6353e4d97d78f98f9d3ab740020169d2f33db','5e8c86041e2022a51f63bbaf56b3ae90109db902','svg','BootstrapPackageInverted.svg','57a4291a1c84e72ba894b59fe4c3ac4e20d83582',1782842270,1764687426,3648,0,2,'image/svg+xml',0,0),(3,0,1782846401,1782846401,'/_assets/6666cd76f96956469e7be39d750cc7d9/Images/speaker-placeholder.png','acbc61719bf0ec2b082b6108ee120146a3e52405','88e74a7e5dd14718ba5817ea7f984029f8fd3927','png','speaker-placeholder.png','a353e61a922f0cbf41a57918ee98e5f003d2f9b8',1771068884,1765729324,216568,0,2,'image/png',0,0);
/*!40000 ALTER TABLE `sys_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_metadata`
--

DROP TABLE IF EXISTS `sys_file_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_file_metadata` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int NOT NULL DEFAULT '0',
  `l10n_parent` int unsigned NOT NULL DEFAULT '0',
  `l10n_state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `l10n_diffsource` mediumblob DEFAULT (NULL),
  `t3ver_oid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_wsid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_state` smallint NOT NULL DEFAULT '0',
  `t3ver_stage` int NOT NULL DEFAULT '0',
  `title` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `alternative` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `categories` int unsigned NOT NULL DEFAULT '0',
  `file` int unsigned NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `width` int NOT NULL DEFAULT '0',
  `height` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `file` (`file`),
  KEY `parent` (`pid`),
  KEY `language_identifier` (`l10n_parent`,`sys_language_uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_metadata`
--

LOCK TABLES `sys_file_metadata` WRITE;
/*!40000 ALTER TABLE `sys_file_metadata` DISABLE KEYS */;
INSERT INTO `sys_file_metadata` VALUES (1,0,1782844250,1782844250,0,0,NULL,'',0,0,0,0,NULL,NULL,0,1,NULL,244,68),(2,0,1782844250,1782844250,0,0,NULL,'',0,0,0,0,NULL,NULL,0,2,NULL,244,68),(3,0,1782846401,1782846401,0,0,NULL,'',0,0,0,0,NULL,NULL,0,3,NULL,600,600);
/*!40000 ALTER TABLE `sys_file_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_processedfile`
--

DROP TABLE IF EXISTS `sys_file_processedfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_file_processedfile` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `tstamp` int NOT NULL DEFAULT '0',
  `crdate` int NOT NULL DEFAULT '0',
  `storage` int NOT NULL DEFAULT '0',
  `original` int NOT NULL DEFAULT '0',
  `identifier` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `processing_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `configuration` blob DEFAULT (NULL),
  `configurationsha1` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `originalfilesha1` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `task_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checksum` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `width` int DEFAULT '0',
  `height` int DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `combined_1` (`original`,`task_type`(100),`configurationsha1`),
  KEY `identifier` (`storage`,`identifier`(180))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_processedfile`
--

LOCK TABLES `sys_file_processedfile` WRITE;
/*!40000 ALTER TABLE `sys_file_processedfile` DISABLE KEYS */;
INSERT INTO `sys_file_processedfile` VALUES (1,1782844250,1782844250,0,1,'',NULL,'',_binary 'a:7:{s:5:\"width\";N;s:6:\"height\";N;s:8:\"minWidth\";N;s:9:\"minHeight\";N;s:8:\"maxWidth\";N;s:9:\"maxHeight\";N;s:4:\"crop\";N;}','24f48d5b4de7d99b7144e6559156976855e74b5d','c57287d7c99a50c84cfb15cd5f1385cd9a4fc998','Image.CropScaleMask','29eec9eeb5',244,68),(2,1782844250,1782844250,0,2,'',NULL,'',_binary 'a:7:{s:5:\"width\";N;s:6:\"height\";N;s:8:\"minWidth\";N;s:9:\"minHeight\";N;s:8:\"maxWidth\";N;s:9:\"maxHeight\";N;s:4:\"crop\";N;}','24f48d5b4de7d99b7144e6559156976855e74b5d','57a4291a1c84e72ba894b59fe4c3ac4e20d83582','Image.CropScaleMask','b2f2bfa916',244,68),(3,1782846401,1782846401,0,3,'/typo3temp/assets/_processed_/1/a/csm_speaker-placeholder_f34a2e53d6.png','csm_speaker-placeholder_f34a2e53d6.png',NULL,_binary 'a:7:{s:5:\"width\";s:3:\"34c\";s:6:\"height\";s:3:\"34c\";s:8:\"minWidth\";N;s:9:\"minHeight\";N;s:8:\"maxWidth\";N;s:9:\"maxHeight\";N;s:4:\"crop\";N;}','80e99a76dec68d43b381156319d2cb5ae7af72a5','a353e61a922f0cbf41a57918ee98e5f003d2f9b8','Image.CropScaleMask','f34a2e53d6',34,34),(4,1782846407,1782846407,0,3,'/typo3temp/assets/_processed_/1/a/csm_speaker-placeholder_24e9ad8cf8.png','csm_speaker-placeholder_24e9ad8cf8.png',NULL,_binary 'a:7:{s:5:\"width\";s:4:\"300c\";s:6:\"height\";s:4:\"300c\";s:8:\"minWidth\";N;s:9:\"minHeight\";N;s:8:\"maxWidth\";N;s:9:\"maxHeight\";N;s:4:\"crop\";N;}','4b8c1ced94f29d32065a4c0a67470233327cc92f','a353e61a922f0cbf41a57918ee98e5f003d2f9b8','Image.CropScaleMask','24e9ad8cf8',300,300),(5,1782846417,1782846417,0,3,'/typo3temp/assets/_processed_/1/a/csm_speaker-placeholder_1b2a849558.png','csm_speaker-placeholder_1b2a849558.png',NULL,_binary 'a:7:{s:5:\"width\";s:4:\"240c\";s:6:\"height\";s:4:\"240c\";s:8:\"minWidth\";N;s:9:\"minHeight\";N;s:8:\"maxWidth\";N;s:9:\"maxHeight\";N;s:4:\"crop\";N;}','509e4692735ff2e66b39ec238bd2545855edbf99','a353e61a922f0cbf41a57918ee98e5f003d2f9b8','Image.CropScaleMask','1b2a849558',240,240);
/*!40000 ALTER TABLE `sys_file_processedfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_storage`
--

DROP TABLE IF EXISTS `sys_file_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_file_storage` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `is_public` smallint NOT NULL DEFAULT '0',
  `processingfolder` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_browsable` smallint unsigned NOT NULL DEFAULT '1',
  `is_default` smallint unsigned NOT NULL DEFAULT '0',
  `is_writable` smallint unsigned NOT NULL DEFAULT '1',
  `is_online` smallint unsigned NOT NULL DEFAULT '1',
  `auto_extract_metadata` smallint unsigned NOT NULL DEFAULT '1',
  `driver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Local',
  `configuration` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_storage`
--

LOCK TABLES `sys_file_storage` WRITE;
/*!40000 ALTER TABLE `sys_file_storage` DISABLE KEYS */;
INSERT INTO `sys_file_storage` VALUES (1,0,1782844203,1782844203,0,'This is the local fileadmin/ directory. This storage mount has been created automatically by TYPO3.',1,NULL,'fileadmin',1,1,1,1,1,'Local','<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"basePath\">\n                    <value index=\"vDEF\">fileadmin/</value>\n                </field>\n                <field index=\"pathType\">\n                    <value index=\"vDEF\">relative</value>\n                </field>\n                <field index=\"caseSensitive\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>');
/*!40000 ALTER TABLE `sys_file_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_content`
--

DROP TABLE IF EXISTS `tt_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tt_content` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `starttime` int unsigned NOT NULL DEFAULT '0',
  `endtime` int unsigned NOT NULL DEFAULT '0',
  `fe_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sorting` int NOT NULL DEFAULT '0',
  `rowDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `editlock` smallint unsigned NOT NULL DEFAULT '0',
  `sys_language_uid` int NOT NULL DEFAULT '0',
  `l18n_parent` int unsigned NOT NULL DEFAULT '0',
  `l10n_source` int unsigned NOT NULL DEFAULT '0',
  `l10n_state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `l18n_diffsource` mediumblob DEFAULT (NULL),
  `t3ver_oid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_wsid` int unsigned NOT NULL DEFAULT '0',
  `t3ver_state` smallint NOT NULL DEFAULT '0',
  `t3ver_stage` int NOT NULL DEFAULT '0',
  `frame_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `colPos` int unsigned NOT NULL DEFAULT '0',
  `table_caption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subheader_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `teaser` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `aspect_ratio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.3333333333333',
  `items_per_page` int unsigned DEFAULT '10',
  `readmore_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `quote_source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `quote_link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `panel_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `file_folder` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon_set` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon_file` int unsigned DEFAULT '0',
  `icon_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon_size` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `icon_type` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `icon_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon_background` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `external_media_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `external_media_source` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `external_media_ratio` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tx_bootstrappackage_card_group_item` int unsigned DEFAULT '0',
  `tx_bootstrappackage_carousel_item` int unsigned DEFAULT '0',
  `tx_bootstrappackage_accordion_item` int unsigned DEFAULT '0',
  `tx_bootstrappackage_icon_group_item` int unsigned DEFAULT '0',
  `tx_bootstrappackage_tab_item` int unsigned DEFAULT '0',
  `tx_bootstrappackage_timeline_item` int unsigned DEFAULT '0',
  `frame_layout` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `frame_options` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `background_color_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `background_image` int unsigned DEFAULT '0',
  `background_image_options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `subitems_header_layout` int unsigned NOT NULL DEFAULT '4',
  `CType` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `categories` int unsigned NOT NULL DEFAULT '0',
  `layout` int unsigned NOT NULL DEFAULT '0',
  `space_before_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `space_after_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` bigint NOT NULL DEFAULT '0',
  `header` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `header_layout` int unsigned NOT NULL DEFAULT '0',
  `header_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `header_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT (_utf8mb4''),
  `subheader` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bodytext` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `image` int unsigned NOT NULL DEFAULT '0',
  `assets` int unsigned NOT NULL DEFAULT '0',
  `imagewidth` int unsigned DEFAULT NULL,
  `imageheight` int unsigned DEFAULT NULL,
  `imageorient` int unsigned NOT NULL DEFAULT '0',
  `imageborder` smallint unsigned NOT NULL DEFAULT '0',
  `image_zoom` smallint unsigned NOT NULL DEFAULT '0',
  `imagecols` int unsigned NOT NULL DEFAULT '2',
  `pages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `recursive` int unsigned NOT NULL DEFAULT '0',
  `media` int unsigned NOT NULL DEFAULT '0',
  `records` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `sectionIndex` smallint unsigned NOT NULL DEFAULT '1',
  `linkToTop` smallint unsigned NOT NULL DEFAULT '0',
  `pi_flexform` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `selected_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `category_field` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bullets_type` int unsigned NOT NULL DEFAULT '0',
  `cols` int unsigned NOT NULL DEFAULT '0',
  `table_class` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table_delimiter` int unsigned NOT NULL DEFAULT '124',
  `table_enclosure` int unsigned NOT NULL DEFAULT '0',
  `table_header_position` int unsigned NOT NULL DEFAULT '0',
  `table_tfoot` smallint unsigned NOT NULL DEFAULT '0',
  `file_collections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `filelink_size` smallint unsigned NOT NULL DEFAULT '0',
  `filelink_sorting` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filelink_sorting_direction` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `uploads_description` smallint unsigned NOT NULL DEFAULT '0',
  `uploads_type` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`sorting`),
  KEY `language_identifier` (`l18n_parent`,`sys_language_uid`),
  KEY `translation_source` (`l10n_source`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_content`
--

LOCK TABLES `tt_content` WRITE;
/*!40000 ALTER TABLE `tt_content` DISABLE KEYS */;
INSERT INTO `tt_content` VALUES (1,3,1782845709,1782844375,0,0,0,0,'',256,'',0,0,0,0,NULL,_binary '{\"CType\":\"\",\"background_color_class\":\"\",\"background_image\":\"\",\"background_image_options\":\"\",\"categories\":\"\",\"colPos\":\"\",\"date\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"fe_group\":\"\",\"frame_class\":\"\",\"frame_layout\":\"\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"\",\"layout\":\"\",\"linkToTop\":\"\",\"pages\":\"\",\"pi_flexform\":\"\",\"recursive\":\"\",\"rowDescription\":\"\",\"sectionIndex\":\"\",\"space_before_class\":\"\",\"starttime\":\"\",\"subheader\":\"\",\"subheader_class\":\"\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default',NULL,'','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_sessionplan',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'2',0,0,NULL,1,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"General\">\n            <language index=\"lDEF\">\n                <field index=\"settings.day\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n                <field index=\"settings.singlePid\">\n                    <value index=\"vDEF\">5</value>\n                </field>\n                <field index=\"settings.tagSinglePid\">\n                    <value index=\"vDEF\">4</value>\n                </field>\n                <field index=\"settings.speakerSinglePid\">\n                    <value index=\"vDEF\">6</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',NULL,'',0,0,'',124,0,0,0,NULL,0,'','','',0,0),(2,4,1782844410,1782844410,0,0,0,0,'',256,'',0,0,0,0,NULL,_binary '{\"CType\":\"\",\"background_color_class\":\"\",\"background_image\":\"\",\"background_image_options\":\"\",\"categories\":\"\",\"colPos\":\"\",\"date\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"fe_group\":\"\",\"frame_class\":\"\",\"frame_layout\":\"\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"\",\"layout\":\"\",\"linkToTop\":\"\",\"pages\":\"\",\"pi_flexform\":\"\",\"recursive\":\"\",\"rowDescription\":\"\",\"sectionIndex\":\"\",\"space_before_class\":\"\",\"starttime\":\"\",\"subheader\":\"\",\"subheader_class\":\"\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default',NULL,'','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_tag',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'',0,0,NULL,1,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"General\">\n            <language index=\"lDEF\">\n                <field index=\"settings.sessionSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.sessionplanPid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',NULL,'',0,0,'',124,0,0,0,NULL,0,'','','',0,0),(3,5,1782844430,1782844430,0,0,0,0,'',256,'',0,0,0,0,NULL,_binary '{\"CType\":\"\",\"background_color_class\":\"\",\"background_image\":\"\",\"background_image_options\":\"\",\"categories\":\"\",\"colPos\":\"\",\"date\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"fe_group\":\"\",\"frame_class\":\"\",\"frame_layout\":\"\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"\",\"layout\":\"\",\"linkToTop\":\"\",\"pages\":\"\",\"pi_flexform\":\"\",\"recursive\":\"\",\"rowDescription\":\"\",\"sectionIndex\":\"\",\"space_before_class\":\"\",\"starttime\":\"\",\"subheader\":\"\",\"subheader_class\":\"\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default',NULL,'','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_session',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'',0,0,NULL,1,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"General\">\n            <language index=\"lDEF\">\n                <field index=\"settings.suggestions\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.listViewHeadline\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.listViewText\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.days\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.singlePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.sessionplanPid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.speakerSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.tagSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',NULL,'',0,0,'',124,0,0,0,NULL,0,'','','',0,0),(4,6,1782844448,1782844448,0,0,0,0,'',256,'',0,0,0,0,NULL,_binary '{\"CType\":\"\",\"background_color_class\":\"\",\"background_image\":\"\",\"background_image_options\":\"\",\"categories\":\"\",\"colPos\":\"\",\"date\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"fe_group\":\"\",\"frame_class\":\"\",\"frame_layout\":\"\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"\",\"layout\":\"\",\"linkToTop\":\"\",\"pages\":\"\",\"pi_flexform\":\"\",\"recursive\":\"\",\"rowDescription\":\"\",\"sectionIndex\":\"\",\"space_before_class\":\"\",\"starttime\":\"\",\"subheader\":\"\",\"subheader_class\":\"\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default',NULL,'','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_speaker',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'',0,0,NULL,1,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"General\">\n            <language index=\"lDEF\">\n                <field index=\"settings.sessionSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',NULL,'',0,0,'',124,0,0,0,NULL,0,'','','',0,0),(5,7,1782844469,1782844469,0,0,0,0,'',256,'',0,0,0,0,NULL,_binary '{\"CType\":\"\",\"background_color_class\":\"\",\"background_image\":\"\",\"background_image_options\":\"\",\"categories\":\"\",\"colPos\":\"\",\"date\":\"\",\"editlock\":\"\",\"endtime\":\"\",\"fe_group\":\"\",\"frame_class\":\"\",\"frame_layout\":\"\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"\",\"layout\":\"\",\"linkToTop\":\"\",\"pages\":\"\",\"recursive\":\"\",\"rowDescription\":\"\",\"sectionIndex\":\"\",\"space_before_class\":\"\",\"starttime\":\"\",\"subheader\":\"\",\"subheader_class\":\"\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default',NULL,'','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_suggest',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'',0,0,NULL,1,0,NULL,NULL,'',0,0,'',124,0,0,0,NULL,0,'','','',0,0),(6,3,1782844842,1782844726,0,0,0,0,'',512,'',0,1,1,1,NULL,_binary '{\"CType\":\"sessionplaner_sessionplan\",\"aspect_ratio\":\"1.3333333333333\",\"assets\":\"0\",\"background_color_class\":\"none\",\"background_image\":\"0\",\"background_image_options\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"behaviour\\\">\\n                    <value index=\\\"vDEF\\\">cover<\\/value>\\n                <\\/field>\\n                <field index=\\\"parallax\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"fade\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"filter\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\",\"bodytext\":\"\",\"bullets_type\":\"0\",\"categories\":\"0\",\"category_field\":\"\",\"colPos\":\"0\",\"cols\":\"0\",\"date\":\"0\",\"editlock\":\"0\",\"endtime\":\"0\",\"external_media_ratio\":\"\",\"external_media_source\":\"\",\"external_media_title\":\"\",\"fe_group\":\"\",\"file_collections\":\"\",\"file_folder\":\"\",\"filelink_size\":\"0\",\"filelink_sorting\":\"\",\"filelink_sorting_direction\":\"\",\"frame_class\":\"default\",\"frame_layout\":\"default\",\"frame_options\":\"\",\"header\":\"\",\"header_class\":\"\",\"header_layout\":\"0\",\"header_link\":\"\",\"header_position\":\"\",\"hidden\":\"0\",\"icon\":\"\",\"icon_background\":\"\",\"icon_color\":\"\",\"icon_file\":\"0\",\"icon_position\":\"\",\"icon_set\":\"\",\"icon_size\":\"default\",\"icon_type\":\"default\",\"image\":\"0\",\"image_zoom\":\"0\",\"imageborder\":\"0\",\"imagecols\":\"2\",\"imageheight\":\"\",\"imageorient\":\"0\",\"imagewidth\":\"\",\"items_per_page\":\"10\",\"l10n_source\":\"0\",\"layout\":\"0\",\"linkToTop\":\"0\",\"media\":\"0\",\"pages\":\"2\",\"panel_class\":\"default\",\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"General\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.day\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.singlePid\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.tagSinglePid\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.speakerSinglePid\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\",\"quote_link\":\"\",\"quote_source\":\"\",\"readmore_label\":\"\",\"records\":\"\",\"recursive\":\"0\",\"rowDescription\":\"\",\"sectionIndex\":\"1\",\"selected_categories\":\"\",\"space_after_class\":\"\",\"space_before_class\":\"\",\"starttime\":\"0\",\"subheader\":\"\",\"subheader_class\":\"\",\"subitems_header_layout\":\"4\",\"table_caption\":\"\",\"table_class\":\"\",\"table_delimiter\":\"124\",\"table_enclosure\":\"0\",\"table_header_position\":\"0\",\"table_tfoot\":\"0\",\"target\":\"\",\"teaser\":\"\",\"tx_bootstrappackage_accordion_item\":\"0\",\"tx_bootstrappackage_card_group_item\":\"0\",\"tx_bootstrappackage_carousel_item\":\"0\",\"tx_bootstrappackage_icon_group_item\":\"0\",\"tx_bootstrappackage_tab_item\":\"0\",\"tx_bootstrappackage_timeline_item\":\"0\",\"uploads_description\":\"0\",\"uploads_type\":\"0\"}',0,0,0,0,'default',0,NULL,'','',NULL,'1.3333333333333',10,'','','','default','','','',0,'','default','default','','','','','',0,0,0,0,0,0,'default','','none',0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"behaviour\">\n                    <value index=\"vDEF\">cover</value>\n                </field>\n                <field index=\"parallax\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"fade\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"filter\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',4,'sessionplaner_sessionplan',0,0,'','',0,'',0,'','','',NULL,0,0,NULL,NULL,0,0,0,2,'2',0,0,'',1,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"General\">\n            <language index=\"lDEF\">\n                <field index=\"settings.day\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.singlePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.tagSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"settings.speakerSinglePid\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>','0','',0,0,'',124,0,0,0,'',0,'','','',0,0);
/*!40000 ALTER TABLE `tt_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_day_room_mm`
--

DROP TABLE IF EXISTS `tx_sessionplaner_day_room_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_day_room_mm` (
  `uid_local` int unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int unsigned NOT NULL DEFAULT '0',
  `sorting` int unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid_local`,`uid_foreign`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_day_room_mm`
--

LOCK TABLES `tx_sessionplaner_day_room_mm` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_day_room_mm` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_day_room_mm` VALUES (1,1,1,3),(1,2,2,3),(2,1,0,1),(2,2,0,1),(3,1,0,2),(3,2,0,2);
/*!40000 ALTER TABLE `tx_sessionplaner_day_room_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_day`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_day` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` bigint NOT NULL DEFAULT '0',
  `rooms` int unsigned NOT NULL DEFAULT '0',
  `slots` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_day`
--

LOCK TABLES `tx_sessionplaner_domain_model_day` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_day` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_day` VALUES (1,2,1782846235,1782844908,0,0,'Thursday',1785967200,2,10),(2,2,1782844966,1782844966,0,0,'Friday',1786053600,0,0),(3,2,1782844978,1782844978,0,0,'Saturday',1786140000,0,0);
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_room`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_room` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `logo` int unsigned NOT NULL DEFAULT '0',
  `seats` int unsigned NOT NULL DEFAULT '0',
  `days` int unsigned NOT NULL DEFAULT '0',
  `slots` int unsigned NOT NULL DEFAULT '0',
  `sessions` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_room`
--

LOCK TABLES `tx_sessionplaner_domain_model_room` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_room` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_room` VALUES (1,2,1782846284,1782845591,0,0,'main','Main hall',0,300,3,6,0),(2,2,1782845609,1782845609,0,0,'side','Side room',0,80,3,0,0);
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_session`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_session` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `suggestion` smallint unsigned NOT NULL DEFAULT '0',
  `social` smallint unsigned NOT NULL DEFAULT '1',
  `donotlink` smallint unsigned NOT NULL DEFAULT '0',
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `topic_addition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path_segment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `speaker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `speakers` int unsigned NOT NULL DEFAULT '0',
  `attendees` int unsigned NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `tag_suggestion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `documents` int unsigned NOT NULL DEFAULT '0',
  `type` int unsigned NOT NULL DEFAULT '0',
  `length` int unsigned NOT NULL DEFAULT '45',
  `level` int unsigned NOT NULL DEFAULT '0',
  `day` int unsigned NOT NULL DEFAULT '0',
  `room` int unsigned NOT NULL DEFAULT '0',
  `slot` int unsigned NOT NULL DEFAULT '0',
  `tags` int unsigned NOT NULL DEFAULT '0',
  `links` int unsigned NOT NULL DEFAULT '0',
  `requesttype` int unsigned NOT NULL DEFAULT '0',
  `norecording` smallint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_session`
--

LOCK TABLES `tx_sessionplaner_domain_model_session` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_session` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_session` VALUES (1,2,1782846498,1782846322,0,0,0,1,0,'Opening Session','More about it','opening-session','','',1,0,'','',0,0,45,0,1,1,1,1,0,0,0);
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_slot`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_slot` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `duration` int unsigned NOT NULL DEFAULT '45',
  `day` int unsigned NOT NULL DEFAULT '0',
  `start` bigint NOT NULL DEFAULT '0',
  `break` smallint unsigned NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `rooms` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_slot`
--

LOCK TABLES `tx_sessionplaner_domain_model_slot` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_slot` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_slot` VALUES (1,2,1782846235,1782845972,0,0,75,1,36000,0,NULL,1),(2,2,1782846235,1782845988,0,0,45,1,40500,0,NULL,2),(3,2,1782846235,1782846014,0,0,90,1,43200,1,'<p>Lunch</p>',0),(4,2,1782846235,1782846043,0,0,45,1,48600,0,NULL,2),(5,2,1782846235,1782846061,0,0,45,1,52200,0,NULL,2),(6,2,1782846235,1782846090,0,0,30,1,54900,1,'<p>Coffee Break</p>',2),(7,2,1782846235,1782846109,0,0,45,1,56700,0,NULL,2),(8,2,1782846235,1782846123,0,0,45,1,60300,0,NULL,2),(9,2,1782846235,1782846147,0,0,120,1,64800,1,'<p>Dinner</p>',0),(10,2,1782846235,1782846221,0,0,240,1,72000,1,'<p>Coding Night powered by</p>',0);
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_slot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_speaker`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_speaker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_speaker` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path_segment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `picture` int unsigned NOT NULL DEFAULT '0',
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `xing` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sessions` int unsigned NOT NULL DEFAULT '0',
  `detail_page` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_speaker`
--

LOCK TABLES `tx_sessionplaner_domain_model_speaker` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_speaker` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_speaker` VALUES (1,2,1782846338,1782846338,0,0,'John Doe','john-doe','',0,'','','','','',0,'0','');
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_speaker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_domain_model_tag`
--

DROP TABLE IF EXISTS `tx_sessionplaner_domain_model_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_domain_model_tag` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL DEFAULT '0',
  `tstamp` int unsigned NOT NULL DEFAULT '0',
  `crdate` int unsigned NOT NULL DEFAULT '0',
  `deleted` smallint unsigned NOT NULL DEFAULT '0',
  `hidden` smallint unsigned NOT NULL DEFAULT '0',
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `path_segment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT (NULL),
  `suggest_form_option` smallint unsigned NOT NULL DEFAULT '0',
  `sessions` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_domain_model_tag`
--

LOCK TABLES `tx_sessionplaner_domain_model_tag` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_tag` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_domain_model_tag` VALUES (1,2,1782846486,1782846486,0,0,'Opening Keynote','','','opening-keynote',0,0);
/*!40000 ALTER TABLE `tx_sessionplaner_domain_model_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_room_slot_mm`
--

DROP TABLE IF EXISTS `tx_sessionplaner_room_slot_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_room_slot_mm` (
  `uid_local` int unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int unsigned NOT NULL DEFAULT '0',
  `sorting` int unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid_local`,`uid_foreign`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_room_slot_mm`
--

LOCK TABLES `tx_sessionplaner_room_slot_mm` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_room_slot_mm` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_room_slot_mm` VALUES (1,1,1,1),(1,2,2,1),(1,4,3,1),(1,5,4,1),(1,7,5,1),(1,8,6,1),(2,2,0,2),(2,4,0,2),(2,5,0,2),(2,6,0,2),(2,7,0,2),(2,8,0,2);
/*!40000 ALTER TABLE `tx_sessionplaner_room_slot_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_session_speaker_mm`
--

DROP TABLE IF EXISTS `tx_sessionplaner_session_speaker_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_session_speaker_mm` (
  `uid_local` int unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int unsigned NOT NULL DEFAULT '0',
  `sorting` int unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid_local`,`uid_foreign`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_session_speaker_mm`
--

LOCK TABLES `tx_sessionplaner_session_speaker_mm` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_session_speaker_mm` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_session_speaker_mm` VALUES (1,1,1,0);
/*!40000 ALTER TABLE `tx_sessionplaner_session_speaker_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_sessionplaner_session_tag_mm`
--

DROP TABLE IF EXISTS `tx_sessionplaner_session_tag_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tx_sessionplaner_session_tag_mm` (
  `uid_local` int unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int unsigned NOT NULL DEFAULT '0',
  `sorting` int unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid_local`,`uid_foreign`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_sessionplaner_session_tag_mm`
--

LOCK TABLES `tx_sessionplaner_session_tag_mm` WRITE;
/*!40000 ALTER TABLE `tx_sessionplaner_session_tag_mm` DISABLE KEYS */;
INSERT INTO `tx_sessionplaner_session_tag_mm` VALUES (1,1,1,0);
/*!40000 ALTER TABLE `tx_sessionplaner_session_tag_mm` ENABLE KEYS */;
UNLOCK TABLES;
