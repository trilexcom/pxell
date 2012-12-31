<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: upgrade_settings.php,v 1.5 2004/12/22 17:13:45 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * Part of upgrade script, this upgrades the settings.php file
 */
// database constants
$myserver = constant("MYSERVER");
$mylogin = constant("MYLOGIN");
$mypassword = constant("MYPASSWORD");
$mydatabase = constant("MYDATABASE");
// smtp constants
$smtpserver = constant("SMTPSERVER");
$smtplogin = constant("SMTPLOGIN");
$smtppassword = constant("SMTPPASSWORD");
// ftp constants
$ftpserver = constant("FTPSERVER");
$ftplogin = constant("FTPLOGIN");
$ftppassword = constant("FTPPASSWORD");
// theme constant
$mytheme = constant("THEME");

// handle boolean settings
if ($footerDev == false) {
    $footerDev = 'false';
} else {
    $footerDev = 'true';
} 

if ($demoMode == false) {
    $demoMode = 'false';
} else {
    $demoMode = 'true';
} 
// the settings file
$settingsNew = <<<STAMP
<?php
/* vim: set expandtab ts=4 sw=4 sts=4: */
/***************************************************************************
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * NetOffice Settings file
 ***************************************************************************/

# installation type
\$installationType = '$installationType'; // select 'offline' or 'online'

# select database application
\$databaseType = '$databaseType'; // select 'mysql'

# database parameters
define('MYSERVER','$myserver');
define('MYLOGIN','$mylogin');
define('MYPASSWORD','$mypassword');
define('MYDATABASE','$mydatabase');

# notification method
\$notificationMethod = '$notificationMethod'; // select 'mail' or 'smtp'

# smtp parameters (only if \$notificationMethod == 'smtp')
define('SMTPSERVER','$smtpserver');
define('SMTPLOGIN','$smtplogin');
define('SMTPPASSWORD','$smtppassword');

# create folder method
\$mkdirMethod = '$mkdirMethod'; // select 'FTP' or 'PHP'

# ftp parameters (only if \$mkdirMethod == 'FTP')
define('FTPSERVER','$ftpserver');
define('FTPLOGIN','$ftplogin');
define('FTPPASSWORD','$ftppassword');

# App root according to ftp account (only if \$mkdirMethod == 'FTP')
\$ftpRoot = '$ftpRoot'; // no slash at the end

# theme choice
define('THEME','$mytheme');

# timezone GMT management
\$gmtTimezone = '$gmtTimezone';

# language choice
\$langDefault = '$langDefault';

# Mantis bug tracking parameters
# this is being removed to make way for a
# fully integrated bugtracking module 
\$enableMantis = '$enableMantis';

// Mantis installation directory
\$pathMantis = '$pathMantis'; // add slash at the end

# CVS parameters
// Should CVS be enabled?
\$enable_cvs = '$enable_cvs';

// Should browsing CVS be limited to project members?
\$cvs_protected = '$cvs_protected';

// Define where CVS repositories should be stored
\$cvs_root = '$cvs_root'; // no slash at the end

// Who is the owner CVS files?
// Note that this should be user that runs the web server.
// Most *nix systems use 'apache' or 'apache'
\$cvs_owner = '$cvs_owner';

// CVS related commands
\$cvs_co = '$cvs_co';
\$cvs_rlog = '$cvs_rlog';
\$cvs_cmd = '$cvs_cmd';

# https related parameters
\$pathToOpenssl = '$pathToOpenssl';

# The [en|de]cryption key unique to your site, used for session validity checks
\$cryptKey = '$cryptKey';

# login method, set to 'CRYPT' in order CVS authentication to work (if CVS support is enabled)
\$loginMethod = '$loginMethod'; // select 'MD5', 'CRYPT', or 'PLAIN'

# enable LDAP
\$useLDAP = '$useLDAP';
\$configLDAP['ldapserver'] = '$configLDAP[ldapserver]';
\$configLDAP['searchroot'] = '$configLDAP[searchroot]';

# htaccess parameters
\$htaccessAuth = '$htaccessAuth';
\$fullPath = '$fullPath'; // no slash at the end

# file management parameters
\$fileManagement = '$fileManagement';
\$maxFileSize = $maxFileSize; // bytes limit for upload
\$root = '$root'; // no slash at the end

# Base directory of the NetOffice installation, needs trailing slash
\$basedir = '$basedir';

# security issue to disallow php files upload
\$allowPhp = '$allowPhp';

# project site creation
\$sitePublish = '$sitePublish';

# enable update checker
\$updateChecker = '$updateChecker';

# e-mail notifications
\$notifications = '$notifications';

# show peer review area
\$peerReview = '$peerReview';

# security issue to disallow auto-login from external link
\$forcedLogin = '$forcedLogin';

# table prefix
\$tablePrefix = '$tablePrefix';

# database tables
\$tableCollab['assignments'] = \$tablePrefix.'assignments';
\$tableCollab['calendar'] = \$tablePrefix.'calendar';
\$tableCollab['files'] = \$tablePrefix.'files';
\$tableCollab['logs'] = \$tablePrefix.'logs';
\$tableCollab['members'] = \$tablePrefix.'members';
\$tableCollab['notes'] = \$tablePrefix.'notes';
\$tableCollab['notifications'] = \$tablePrefix.'notifications';
\$tableCollab['organizations'] = \$tablePrefix.'organizations';
\$tableCollab['posts'] = \$tablePrefix.'posts';
\$tableCollab['projects'] = \$tablePrefix.'projects';
\$tableCollab['reports'] = \$tablePrefix.'reports';
\$tableCollab['sorting'] = \$tablePrefix.'sorting';
\$tableCollab['tasks'] = \$tablePrefix.'tasks';
\$tableCollab['tasks_time'] = \$tablePrefix.'tasks_time';
\$tableCollab['teams'] = \$tablePrefix.'teams';
\$tableCollab['topics'] = \$tablePrefix.'topics';
\$tableCollab['phases'] = \$tablePrefix.'phases';
\$tableCollab['support_requests'] = \$tablePrefix.'support_requests';
\$tableCollab['support_posts'] = \$tablePrefix.'support_posts';
\$tableCollab['updates'] = \$tablePrefix.'updates';
\$tableCollab['bookmarks'] = \$tablePrefix.'bookmarks';
\$tableCollab['bookmarks_categories'] = \$tablePrefix.'bookmarks_categories';
\$tableCollab['services'] = \$tablePrefix.'services';
\$tableCollab['sessions'] = \$tablePrefix.'sessions';
\$tableCollab['meetings'] = \$tablePrefix.'meetings';
\$tableCollab['meetings_time'] = \$tablePrefix.'meetings_time';
\$tableCollab['meetings_attachment'] = \$tablePrefix.'meetings_attachment';
\$tableCollab['attendants'] = \$tablePrefix.'attendants';
\$tableCollab['holiday'] = \$tablePrefix.'holiday';

# App version
\$version = '$versionNew';

# demo mode parameters
\$demoMode = false;
\$urlContact = '$urlContact';

# Gantt graphs
\$activeJpgraph = '$activeJpgraph';

# developement options in footer
\$footerDev = $footerDev;

# filter to see only logged user clients (in team / owner)
\$clientsFilter = '$clientsFilter';

# filter to see only logged user projects (in team / owner)
\$projectsFilter = '$projectsFilter';

# Enable help center support requests, values 'true' or 'false'
\$enableHelpSupport = '$enableHelpSupport';

# Return email address given for clients to respond too.
\$supportEmail = '$supportEmail';

# Support Type, either team or admin. If team is selected a notification will be sent to everyone in the team when a new request is added
\$supportType = '$supportType';

# html header parameters
\$setDoctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
\$setTitle = '$setTitle';
\$setDescription = '$setDescription';
\$setKeywords = '$setKeywords';
?>
STAMP;

?>
