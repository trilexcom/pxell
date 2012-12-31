<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: setup_settings.php,v 1.6 2004/12/22 17:13:44 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$content = <<<STAMP
<?php
#Path by root: ../includes/settings.php

# installation type
\$installationType = '$installationType'; //select 'offline' or 'online'

# select database application
\$databaseType = '$databaseType'; //select 'mysql'

# database parameters
define('MYSERVER','$myserver');
define('MYLOGIN','$mylogin');
define('MYPASSWORD','$mypassword');
define('MYDATABASE','$mydatabase');

# notification method
\$notificationMethod = 'mail'; //select 'mail' or 'smtp'

# smtp parameters (only if \$notificationMethod == 'smtp')
define('SMTPSERVER','');
define('SMTPLOGIN','');
define('SMTPPASSWORD','');

# create folder method
\$mkdirMethod = '$mkdirMethod'; //select 'FTP' or 'PHP'

# ftp parameters (only if \$mkdirMethod == 'FTP')
define('FTPSERVER','$ftpserver');
define('FTPLOGIN','$ftplogin');
define('FTPPASSWORD','$ftppassword');

# App root according to ftp account (only if \$mkdirMethod == 'FTP')
\$ftpRoot = '$ftpRoot'; //no slash at the end

# theme choice
define('THEME','deepblue');

# timezone GMT management
\$gmtTimezone = 'false';

# language choice
\$langDefault = '$langdefault';

# Mantis bug tracking parameters
# this is being removed to make way for a
# fully integrated bugtracking module
\$enableMantis = 'false';

// Mantis installation directory
\$pathMantis = 'http://localhost/mantis/';  // add slash at the end

# CVS parameters
// Should CVS be enabled?
\$enable_cvs = 'false';

// Should browsing CVS be limited to project members?
\$cvs_protected = 'false';

// Define where CVS repositories should be stored
\$cvs_root = 'D:\cvs'; //no slash at the end

// Who is the owner CVS files?
// Note that this should be user that runs the web server.
// Most *nix systems use 'apache' or 'apache'
\$cvs_owner = 'apache';

// CVS related commands
\$cvs_co = '/usr/bin/co';
\$cvs_rlog = '/usr/bin/rlog';
\$cvs_cmd = '/usr/bin/cvs';

# https related parameters
\$pathToOpenssl = '/usr/bin/openssl';

# The [en|de]cryption key unique to your site, used for session validity checks
\$cryptKey = '$cryptKey';

# login method, set to 'CRYPT' in order CVS authentication to work (if CVS support is enabled)
\$loginMethod = '$loginMethod'; //select 'MD5', 'CRYPT', or 'PLAIN'

# enable LDAP
\$useLDAP = 'false';
\$configLDAP['ldapserver'] = 'your.ldap.server.address';
\$configLDAP['searchroot'] = 'ou=People, ou=Intranet, dc=YourCompany, dc=com';

# htaccess parameters
\$htaccessAuth = 'false';
\$fullPath = '/var/www/html/netoffice/files'; //no slash at the end

# file management parameters
\$fileManagement = 'true';
\$maxFileSize = 51200; //bytes limit for upload
\$root = '$root'; //no slash at the end

# Base directory of the NetOffice installation, needs trailing slash
\$basedir = '$basedir';

# security issue to disallow php files upload
\$allowPhp = 'false';

# project site creation
\$sitePublish = 'true';

# enable update checker
\$updateChecker = '$updatechecker';

# e-mail notifications
\$notifications = '$notifications';

# show peer review area
\$peerReview = 'true';

# security issue to disallow auto-login from external link
\$forcedLogin = '$forcedlogin';

# table prefix
\$tablePrefix = '$myprefix';

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
\$version = "$version";

# demo mode parameters
\$demoMode = false;
\$urlContact = "http://www.sourceforge.net/projects/netoffice";

# Gantt graphs
\$activeJpgraph = 'true';

# developement options in footer
\$footerDev = false;

# filter to see only logged user clients (in team / owner)
\$clientsFilter = 'false';

# filter to see only logged user projects (in team / owner)
\$projectsFilter = 'false';

# Enable help center support requests, values "true" or "false"
\$enableHelpSupport = 'true';

# Return email address given for clients to respond too.
\$supportEmail = 'email@yourdomain.com';

# Support Type, either team or admin. If team is selected a notification will be sent to everyone in the team when a new request is added
\$supportType = 'team';

# html header parameters
\$setDoctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
\$setTitle = 'Online Project Management';
\$setDescription = 'Groupware module. Manage web projects with team collaboration, users management, tasks and projects tracking, files approval tracking, project sites clients access, customer relationship management.';
\$setKeywords = 'management, web, projects, tasks, organizations, reports, application, module, file management, project site, team collaboration, crm, CRM, cutomer relationship management, workflow, workgroup';
?>
STAMP;

?>
