# phpMyAdmin SQL Dump
#
# Database : `netoffice`
#

# --------------------------------------------------------

#
# Table structure for table `netoffice_assignments`
#

CREATE TABLE `netoffice_assignments` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `task` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `assigned_to` mediumint(8) unsigned NOT NULL default '0',
  `comments` text,
  `assigned` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_assignments`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_bookmarks`
#

CREATE TABLE `netoffice_bookmarks` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `category` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `description` text,
  `shared` char(1) NOT NULL default '',
  `home` char(1) NOT NULL default '',
  `comments` char(1) NOT NULL default '',
  `users` varchar(255) default NULL,
  `created` varchar(16) default NULL,
  `modified` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_bookmarks`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_bookmarks_categories`
#

CREATE TABLE `netoffice_bookmarks_categories` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_bookmarks_categories`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_calendar`
#

CREATE TABLE `netoffice_calendar` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `subject` varchar(155) default NULL,
  `description` text,
  `shortname` varchar(155) default NULL,
  `date_start` varchar(10) default NULL,
  `date_end` varchar(10) default NULL,
  `time_start` varchar(155) default NULL,
  `time_end` varchar(155) default NULL,
  `reminder` char(1) NOT NULL default '',
  `recurring` char(1) NOT NULL default '',
  `recur_day` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_calendar`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_files`
#

CREATE TABLE `netoffice_files` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `project` mediumint(8) unsigned NOT NULL default '0',
  `task` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(255) default NULL,
  `date` varchar(16) default NULL,
  `size` varchar(155) default NULL,
  `extension` varchar(155) default NULL,
  `comments` varchar(255) default NULL,
  `comments_approval` varchar(255) default NULL,
  `approver` mediumint(8) unsigned NOT NULL default '0',
  `date_approval` varchar(16) default NULL,
  `upload` varchar(16) default NULL,
  `published` char(1) NOT NULL default '',
  `status` mediumint(8) unsigned NOT NULL default '0',
  `vc_status` varchar(255) NOT NULL default '0',
  `vc_version` varchar(255) NOT NULL default '0.0',
  `vc_parent` int(10) unsigned NOT NULL default '0',
  `phase` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_files`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_logs`
#

CREATE TABLE `netoffice_logs` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `login` varchar(155) default NULL,
  `password` varchar(155) default NULL,
  `ip` varchar(155) default NULL,
  `session` varchar(155) default NULL,
  `compt` mediumint(8) unsigned NOT NULL default '0',
  `last_visite` varchar(16) default NULL,
  `connected` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_logs`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_members`
#

CREATE TABLE `netoffice_members` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `organization` mediumint(8) unsigned NOT NULL default '0',
  `login` varchar(155) default NULL,
  `password` varchar(155) default NULL,
  `name` varchar(155) default NULL,
  `title` varchar(155) default NULL,
  `email_work` varchar(155) default NULL,
  `email_home` varchar(155) default NULL,
  `phone_work` varchar(155) default NULL,
  `phone_home` varchar(155) default NULL,
  `mobile` varchar(155) default NULL,
  `fax` varchar(155) default NULL,
  `comments` text,
  `profil` char(1) NOT NULL default '',
  `created` varchar(16) default NULL,
  `logout_time` mediumint(8) unsigned NOT NULL default '0',
  `last_page` varchar(255) default NULL,
  `timezone` char(3) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Dumping data for table `netoffice_members`
#

INSERT INTO `netoffice_members` (`id`, `organization`, `login`, `password`, `name`, `title`, `email_work`, `email_home`, `phone_work`, `phone_home`, `mobile`, `fax`, `comments`, `profil`, `created`, `logout_time`, `last_page`, `timezone`) VALUES (1, 1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2003-09-04 14:00', 0, NULL, '');
INSERT INTO `netoffice_members` (`id`, `organization`, `login`, `password`, `name`, `title`, `email_work`, `email_home`, `phone_work`, `phone_home`, `mobile`, `fax`, `comments`, `profil`, `created`, `logout_time`, `last_page`, `timezone`) VALUES (2, 1, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Demo user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2003-09-04 14:00', 0, NULL, '');

# --------------------------------------------------------

#
# Table structure for table `netoffice_notes`
#

CREATE TABLE `netoffice_notes` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `topic` varchar(255) default NULL,
  `subject` varchar(155) default NULL,
  `description` text,
  `date` varchar(10) default NULL,
  `published` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_notes`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_notifications`
#

CREATE TABLE `netoffice_notifications` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `member` mediumint(8) unsigned NOT NULL default '0',
  `taskAssignment` char(1) NOT NULL default '0',
  `removeProjectTeam` char(1) NOT NULL default '0',
  `addProjectTeam` char(1) NOT NULL default '0',
  `newTopic` char(1) NOT NULL default '0',
  `newPost` char(1) NOT NULL default '0',
  `statusTaskChange` char(1) NOT NULL default '0',
  `priorityTaskChange` char(1) NOT NULL default '0',
  `duedateTaskChange` char(1) NOT NULL default '0',
  `clientAddTask` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Dumping data for table `netoffice_notifications`
#

INSERT INTO `netoffice_notifications` (`id`, `member`, `taskAssignment`, `removeProjectTeam`, `addProjectTeam`, `newTopic`, `newPost`, `statusTaskChange`, `priorityTaskChange`, `duedateTaskChange`, `clientAddTask`) VALUES (1, 1, '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `netoffice_notifications` (`id`, `member`, `taskAssignment`, `removeProjectTeam`, `addProjectTeam`, `newTopic`, `newPost`, `statusTaskChange`, `priorityTaskChange`, `duedateTaskChange`, `clientAddTask`) VALUES (2, 2, '0', '0', '0', '0', '0', '0', '0', '0', '0');

# --------------------------------------------------------

#
# Table structure for table `netoffice_organizations`
#

CREATE TABLE `netoffice_organizations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `address1` varchar(255) default NULL,
  `address2` varchar(255) default NULL,
  `zip_code` varchar(155) default NULL,
  `city` varchar(155) default NULL,
  `country` varchar(155) default NULL,
  `phone` varchar(155) default NULL,
  `fax` varchar(155) default NULL,
  `url` varchar(255) default NULL,
  `email` varchar(155) default NULL,
  `comments` text,
  `created` varchar(16) default NULL,
  `extension_logo` char(3) NOT NULL default '',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Dumping data for table `netoffice_organizations`
#

INSERT INTO `netoffice_organizations` (`id`, `name`, `address1`, `address2`, `zip_code`, `city`, `country`, `phone`, `fax`, `url`, `email`, `comments`, `created`, `extension_logo`, `owner`) VALUES (1, 'My Company Name', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2003-09-04 14:00', '', 0);

# --------------------------------------------------------

#
# Table structure for table `netoffice_phases`
#

CREATE TABLE `netoffice_phases` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project_id` mediumint(8) unsigned NOT NULL default '0',
  `order_num` mediumint(8) unsigned NOT NULL default '0',
  `status` varchar(10) default NULL,
  `name` varchar(155) default NULL,
  `date_start` varchar(10) default NULL,
  `date_end` varchar(10) default NULL,
  `comments` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_phases`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_posts`
#

CREATE TABLE `netoffice_posts` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic` mediumint(8) unsigned NOT NULL default '0',
  `member` mediumint(8) unsigned NOT NULL default '0',
  `created` varchar(16) default NULL,
  `message` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_posts`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_projects`
#

CREATE TABLE `netoffice_projects` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `organization` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `priority` mediumint(8) unsigned NOT NULL default '0',
  `status` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(155) default NULL,
  `description` text,
  `url_dev` varchar(255) default NULL,
  `url_prod` varchar(255) default NULL,
  `created` varchar(16) default NULL,
  `modified` varchar(16) default NULL,
  `published` char(1) NOT NULL default '',
  `upload_max` varchar(155) default NULL,
  `phase_set` mediumint(8) unsigned NOT NULL default '0',
  `type` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_projects`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_reports`
#

CREATE TABLE `netoffice_reports` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(155) default NULL,
  `projects` varchar(255) default NULL,
  `members` varchar(255) default NULL,
  `priorities` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  `date_due_start` varchar(10) default NULL,
  `date_due_end` varchar(10) default NULL,
  `created` varchar(16) default NULL,
  `date_complete_start` varchar(10) default NULL,
  `date_complete_end` varchar(10) default NULL,
  `clients` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_reports`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_services`
#

CREATE TABLE `netoffice_services` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(155) default NULL,
  `name_print` varchar(155) default NULL,
  `hourly_rate` float(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_services`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_sorting`
#

CREATE TABLE `netoffice_sorting` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `member` mediumint(8) unsigned NOT NULL default '0',
  `home_projects` varchar(155) default NULL,
  `home_tasks` varchar(155) default NULL,
  `home_discussions` varchar(155) default NULL,
  `home_reports` varchar(155) default NULL,
  `projects` varchar(155) default NULL,
  `organizations` varchar(155) default NULL,
  `project_tasks` varchar(155) default NULL,
  `discussions` varchar(155) default NULL,
  `project_discussions` varchar(155) default NULL,
  `users` varchar(155) default NULL,
  `team` varchar(155) default NULL,
  `tasks` varchar(155) default NULL,
  `report_tasks` varchar(155) default NULL,
  `assignment` varchar(155) default NULL,
  `reports` varchar(155) default NULL,
  `files` varchar(155) default NULL,
  `organization_projects` varchar(155) default NULL,
  `notes` varchar(155) default NULL,
  `calendar` varchar(155) default NULL,
  `phases` varchar(155) default NULL,
  `support_requests` varchar(155) default NULL,
  `bookmarks` varchar(155) default NULL,
  `tasks_time` varchar(155) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Dumping data for table `netoffice_sorting`
#

INSERT INTO `netoffice_sorting` (`id`, `member`, `home_projects`, `home_tasks`, `home_discussions`, `home_reports`, `projects`, `organizations`, `project_tasks`, `discussions`, `project_discussions`, `users`, `team`, `tasks`, `report_tasks`, `assignment`, `reports`, `files`, `organization_projects`, `notes`, `calendar`, `phases`, `support_requests`, `bookmarks`, `tasks_time`) VALUES (1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `netoffice_sorting` (`id`, `member`, `home_projects`, `home_tasks`, `home_discussions`, `home_reports`, `projects`, `organizations`, `project_tasks`, `discussions`, `project_discussions`, `users`, `team`, `tasks`, `report_tasks`, `assignment`, `reports`, `files`, `organization_projects`, `notes`, `calendar`, `phases`, `support_requests`, `bookmarks`, `tasks_time`) VALUES (2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

# --------------------------------------------------------

#
# Table structure for table `netoffice_support_posts`
#

CREATE TABLE `netoffice_support_posts` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `request_id` mediumint(8) unsigned NOT NULL default '0',
  `message` text,
  `date` varchar(16) default NULL,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `project` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_support_posts`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_support_requests`
#

CREATE TABLE `netoffice_support_requests` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `status` mediumint(8) unsigned NOT NULL default '0',
  `member` mediumint(8) unsigned NOT NULL default '0',
  `priority` mediumint(8) unsigned NOT NULL default '0',
  `subject` varchar(255) default NULL,
  `message` text,
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `date_open` varchar(16) default NULL,
  `date_close` varchar(16) default NULL,
  `project` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_support_requests`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_tasks`
#

CREATE TABLE `netoffice_tasks` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `priority` mediumint(8) unsigned NOT NULL default '0',
  `status` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `assigned_to` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(155) default NULL,
  `description` text,
  `start_date` varchar(10) default NULL,
  `due_date` varchar(10) default NULL,
  `estimated_time` varchar(10) default NULL,
  `actual_time` varchar(10) default NULL,
  `comments` text,
  `completion` mediumint(8) unsigned NOT NULL default '0',
  `created` varchar(16) default NULL,
  `modified` varchar(16) default NULL,
  `assigned` varchar(16) default NULL,
  `published` char(1) NOT NULL default '',
  `parent_phase` int(10) unsigned NOT NULL default '0',
  `complete_date` varchar(10) default NULL,
  `service` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_tasks`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_tasks_time`
#

CREATE TABLE `netoffice_tasks_time` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `task` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `date` varchar(16) default NULL,
  `hours` float(10,2) NOT NULL default '0.00',
  `comments` text,
  `created` varchar(16) default NULL,
  `modified` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_tasks_time`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_teams`
#

CREATE TABLE `netoffice_teams` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `member` mediumint(8) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '',
  `authorized` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_teams`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_topics`
#

CREATE TABLE `netoffice_topics` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `project` mediumint(8) unsigned NOT NULL default '0',
  `owner` mediumint(8) unsigned NOT NULL default '0',
  `subject` varchar(155) default NULL,
  `status` char(1) NOT NULL default '',
  `last_post` varchar(16) default NULL,
  `posts` smallint(5) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_topics`
#


# --------------------------------------------------------

#
# Table structure for table `netoffice_updates`
#

CREATE TABLE `netoffice_updates` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `type` char(1) NOT NULL default '',
  `item` mediumint(8) unsigned NOT NULL default '0',
  `member` mediumint(8) unsigned NOT NULL default '0',
  `comments` text,
  `created` varchar(16) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `netoffice_updates`
#

