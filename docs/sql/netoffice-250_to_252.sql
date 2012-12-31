# phpMyAdmin SQL Dump
#
# Database : `netoffice`
#

# --------------------------------------------------------

#
# Table structure for table `netoffice_sessions`
#

CREATE TABLE `netoffice_sessions` (
  `id` varchar(32) NOT NULL default '',
  `ipaddr` varchar(16) NOT NULL default '',
  `session_data` longtext,
  `last_access` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`,`ipaddr`),
  KEY `last_access` (`last_access`)
) TYPE=MyISAM;

#
# Dumping data for table `netoffice_sessions`
#
