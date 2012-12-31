<?php // $Revision: 1.14 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: updatesettings.php,v 1.14 2005/06/11 18:36:37 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

if ($_SESSION['profilSession'] != 0) {
    header('Location: ../general/permissiondenied.php');
    exit;
} 

$versionNew = '2.6.0b2';

if ($action == 'generate') {
    if ($installationTypeNew == 'offline') {
        $updateCheckerNew = 'false';
    } 

    if (substr($rootNew, -1) == '/') {
        $rootNew = substr($rootNew, 0, -1);
    } 

    if (substr($ftpRootNew, -1) == '/') {
        $ftpRootNew = substr($ftpRootNew, 0, -1);
    } 

    if (substr($pathMantisNew, -1) != '/') {
        $pathMantisNew = $pathMantisNew . '/';
    } 

    $content = <<<STAMP
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
\$installationType = '$installationTypeNew'; // select 'offline' or 'online'

# select database application
\$databaseType = '$databaseTypeNew'; // select 'mysql'

# database parameters
define('MYSERVER','$myserverNew');
define('MYLOGIN','$myloginNew');
define('MYPASSWORD','$mypasswordNew');
define('MYDATABASE','$mydatabaseNew');
\$databaseCharset = '$mycharsetNew';

# notification method
\$notificationMethod = '$notificationMethodNew'; // select 'mail' or 'smtp'

# smtp parameters (only if \$notificationMethod == 'smtp')
define('SMTPSERVER','$smtpserverNew');
define('SMTPLOGIN','$smtploginNew');
define('SMTPPASSWORD','$smtppasswordNew');

# create folder method
\$mkdirMethod = '$mkdirMethodNew'; // select 'FTP' or 'PHP'

# ftp parameters (only if \$mkdirMethod == 'FTP')
define('FTPSERVER','$ftpserverNew');
define('FTPLOGIN','$ftploginNew');
define('FTPPASSWORD','$ftppasswordNew');

# App root according to ftp account (only if \$mkdirMethod == 'FTP')
\$ftpRoot = '$ftpRootNew'; // no slash at the end

# theme choice
define('THEME','$mythemeNew');

# timezone GMT management
\$gmtTimezone = '$gmtTimezoneNew';

# language choice
\$langDefault = '$langNew';

# Mantis bug tracking parameters
# this is being removed to make way for a
# fully integrated bugtracking module 
\$enableMantis = '$enableMantis';

// Mantis installation directory
\$pathMantis = '$pathMantisNew'; // add slash at the end

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
\$loginMethod = '$loginMethodNew'; // select 'MD5', 'CRYPT', or 'PLAIN'

# enable LDAP
\$useLDAP = 'false';
\$configLDAP['ldapserver'] = 'your.ldap.server.address';
\$configLDAP['searchroot'] = 'ou=People, ou=Intranet, dc=YourCompany, dc=com';

# htaccess parameters
\$htaccessAuth = '$htaccessAuth';
\$fullPath = '$fullPath'; // no slash at the end

# file management parameters
\$fileManagement = '$fileManagement';
\$maxFileSize = $maxFileSizeNew; // bytes limit for upload
\$root = '$rootNew'; // no slash at the end

# Base directory of the NetOffice installation, needs trailing slash
\$basedir = '$basedir';

# security issue to disallow php files upload
\$allowPhp = '$allowPhp';

# project site creation
\$sitePublish = '$sitePublish';

# enable update checker
\$updateChecker = '$updateCheckerNew';

# e-mail notifications
\$notifications = '$notificationsNew';

# show peer review area
\$peerReview = '$peerReview';

# security issue to disallow auto-login from external link
\$forcedLogin = '$forcedloginNew';

# table prefix
\$tablePrefix = '$tablePrefixNew';

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
\$tableCollab['tasks_predecessor'] = \$tablePrefix.'tasks_predecessor';
\$tableCollab['tasks_resource'] = \$tablePrefix.'tasks_resource';

# App version
\$version = '$versionNew';

# demo mode parameters
\$demoMode = false;
\$urlContact = 'http://www.sourceforge.net/projects/netoffice';

# Gantt graphs
\$activeJpgraph = '$activeJpgraph';

# developement options in footer
\$footerDev = $footerdevNew;

# filter to see only logged user clients (in team / owner)
\$clientsFilter = '$clientsFilterNew';

# filter to see only logged user projects (in team / owner)
\$projectsFilter = '$projectsFilterNew';

# Enable help center support requests, values 'true' or 'false'
\$enableHelpSupport = '$enableHelpSupport';

# Return email address given for clients to respond too.
\$supportEmail = '$supportEmail';

# Support Type, either team or admin. If team is selected a notification will be sent to everyone in the team when a new request is added
\$supportType = '$supportType';

# html header parameters
\$setDoctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
\$setTitle = 'Online Project Management';
\$setDescription = 'Groupware module. Manage web projects with team collaboration, users management, tasks and projects tracking, files approval tracking, project sites clients access, customer relationship management.';
\$setKeywords = 'management, web, projects, tasks, organizations, reports, application, module, file management, project site, team collaboration, crm, CRM, cutomer relationship management, workflow, workgroup';
?>
STAMP;

    if (!@fopen('../includes/settings.php', 'wb+')) {
        $msg = 'settingsNotwritable';
    } else {
        $fp = @fopen('../includes/settings.php', 'wb+');
        $fw = @fwrite($fp, $content);

        if (!$fw) {
            $msg = 'settingsNotwritable';
            fclose($fp);
        } else {
            fclose($fp);
            header('Location: ../administration/admin.php?msg=update');
            exit;
        } 
    } 
} 




$breadcrumbs[]=buildLink('../administration/admin.php?', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['edit_settings'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

$blockPage= new block();

//--- content -----
$block1 = new block();
$block1->headingForm($strings['edit_settings']);
$block1->openContent();
$block1->contentTitle('General');
$block1->form = 'settings';
$block1->openForm('../administration/updatesettings.php?action=generate');

if (substr($ftpRoot, -1) == '/') {
    $ftpRoot = substr($ftpRoot, 0, -1);
} 

$tablePrefix = substr($tableCollab['projects'], 0, -8);

echo '
<input value="' . $tablePrefix . '" name="tablePrefixNew" type="hidden">
<input value="' . $databaseType . '" name="databaseTypeNew" type="hidden">
<input value="' . MYSERVER . '" name="myserverNew" type="hidden">
<input value="' . MYLOGIN . '" name="myloginNew" type="hidden">
<input value="' . MYPASSWORD . '" name="mypasswordNew" type="hidden">
<input value="' . MYDATABASE . '" name="mydatabaseNew" type="hidden">
<input value="' . $loginMethod . '" name="loginMethodNew" type="hidden">';

if ($version == $versionNew) {
    if ($versionOld == '') {
        $versionOld = $version;
    } 

    echo '<input value="' . $versionOld . '" name="versionOldNew" type="hidden">';
} else {
    echo '<input value="' . $version . '" name="versionOldNew" type="hidden">';
} 

$safemodeTest = ini_get(safe_mode);

if ($safemodeTest == '1') {
    $safemode = 'on';
} else {
    $safemode = 'off';
} 

$notificationsTest = function_exists('mail');

if ($notificationsTest == 'true') {
    $mail = 'on';
} else {
    $mail = 'off';
} 

if ($mkdirMethod == 'FTP') {
    $checked1_a = 'checked';
} else {
    $checked2_a = 'checked';
} 

if ($notifications == 'true') {
    $checked2_b = 'checked';
} else {
    $checked1_b = 'checked';
} 

if ($forcedLogin == 'true') {
    $checked1_c = 'checked';
} else {
    $checked2_c = 'checked';
} 

if ($clientsFilter == 'true') {
    $checked1_d = 'checked';
} else {
    $checked2_d = 'checked';
} 

if ($updateChecker == 'true') {
    $checked1_e = 'checked';
} else {
    $checked2_e = 'checked';
} 

if ($gmtTimezone == 'true') {
    $checked1_f = 'checked';
} else {
    $checked2_f = 'checked';
} 

if ($projectsFilter == 'true') {
    $checked1_h = 'checked';
} else {
    $checked2_h = 'checked';
} 

if ($footerDev == true) {
    $checked1_j = 'checked';
} else {
    $checked2_j = 'checked';
} 

if ($enableMantis == 'true') {
    $checked1_k = 'checked';
} else {
    $checked2_k = 'checked';
} 

if ($notificationMethod == 'smtp') {
    $checked1_g = 'checked';
} else {
    $checked2_g = 'checked';
} 

if ($installationType == 'offline') {
    $installCheckOffline = 'checked';
} else {
    $installCheckOnline = 'checked';
} 

$block1->contentRow('Installation type', '<input type="radio" name="installationTypeNew" value="offline" ' . $installCheckOffline . '> Offline (firewall/intranet, no update checker)&nbsp;<input type="radio" name="installationTypeNew" value="online" ' . $installCheckOnline . '> Online');

$block1->contentRow('Update checker', '<input type="radio" name="updateCheckerNew" value="false" ' . $checked2_e . '> False&nbsp;<input type="radio" name="updateCheckerNew" value="true" ' . $checked1_e . '> True');

echo '
  <tr class="odd">
    <td valign="top" class="leftvalue">* Create folder method' . $blockPage->printHelp('setup_mkdirMethod') . '</td>
    <td>
	  <table cellpadding="0" cellspacing="0" width="500">
        <tr>
          <td valign="top">
		    <input type="radio" name="mkdirMethodNew" value="PHP" ' . $checked2_a . '> PHP&nbsp;
            <input type="radio" name="mkdirMethodNew" value="FTP" ' . $checked1_a . '> FTP<br>
            [Safe-mode ' . $safemode . ']</td>
          <td align="right">
            Ftp server <input size="44" value="' . FTPSERVER . '" style="width: 200px" name="ftpserverNew" maxlength="100" type="text"><br>
            Ftp login <input size="44" value="' . FTPLOGIN . '" style="width: 200px" name="ftploginNew" maxlength="100" type="text"><br>
            Ftp password <input size="44" value="' . FTPPASSWORD . '" style="width: 200px" name="ftppasswordNew" maxlength="100" type="password"><br>
            Ftp root <input size="44" value="' . $ftpRoot . '" style="width: 200px" name="ftpRootNew" maxlength="100" type="text">
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr class="odd">
    <td valign="top" class="leftvalue">* Notification method' . $blockPage->printHelp('setup_notificationMethod') . '</td>
	<td>
      <table cellpadding="0" cellspacing="0" width="500">
	    <tr>
		  <td valign="top">
		    <input type="radio" name="notificationMethodNew" value="mail" ' . $checked2_g . '> PHP mail function&nbsp;
			<input type="radio" name="notificationMethodNew" value="smtp" ' . $checked1_g . '> SMTP</td>
          <td align="right">
            Smtp server <input size="44" value="' . SMTPSERVER . '" style="width: 200px" name="smtpserverNew" maxlength="100" type="text"><br>
            Smtp login <input size="44" value="' . SMTPLOGIN . '" style="width: 200px" name="smtploginNew" maxlength="100" type="text"><br>
            Smtp password <input size="44" value="' . SMTPPASSWORD . '" style="width: 200px" name="smtppasswordNew" maxlength="100" type="password">
          </td>
		</tr>
      </table>
    </td>
  </tr>
  <tr class="odd">
    <td valign="top" class="leftvalue">* Theme :</td>
    <td><select name="mythemeNew">';

$all = opendir('../themes');
while ($directory = readdir($all)) {
    if ($directory != 'index.html' && $directory != '..' && $directory != '.' && $directory != 'CVS') {
        if ($directory == THEME) {
            echo '<option value="' . $directory . '" selected>' . $directory . '</option>';
        } else {
            echo '<option value="' . $directory . '">' . $directory . '</option>';
        } 
    } 
} 
closedir($all);

echo '</td></tr>';

$block1->contentRow('Notifications' . $blockPage->printHelp('setup_notifications'), '<input type="radio" name="notificationsNew" value="false" ' . $checked1_b . '> False&nbsp;<input type="radio" name="notificationsNew" value="true" ' . $checked2_b . '> True<br>[Mail ' . $mail . ']');
$block1->contentRow('Timezone (GMT)', '<input type="radio" name="gmtTimezoneNew" value="false" ' . $checked2_f . '> False&nbsp;<input type="radio" name="gmtTimezoneNew" value="true" ' . $checked1_f . '> True');
$block1->contentRow('* Forced login' . $blockPage->printHelp('setup_forcedlogin'), '<input type="radio" name="forcedloginNew" value="false" ' . $checked2_c . '> False&nbsp;<input type="radio" name="forcedloginNew" value="true" ' . $checked1_c . '> True');

echo '
  <tr class="odd">
    <td valign="top" class="leftvalue">Default language' . $blockPage->printHelp('setup_langdefault') . '</td>
    <td><select name="langNew">
      <option value="">Blank</option>
      <option value="az" ' . $langSelected['az'] . '>Azerbaijani</option>
      <option value="pt-br" ' . $langSelected['pt-br'] . '>Brazilian Portuguese</option>
      <option value="bg" ' . $langSelected['bg'] . '>Bulgarian</option>
      <option value="ca" ' . $langSelected['ca'] . '>Catalan</option>
      <option value="zh" ' . $langSelected['zh'] . '>Chinese simplified</option>
      <option value="zh-tw" ' . $langSelected['zh-tw'] . '>Chinese traditional</option>
      <option value="cs-iso" ' . $langSelected['cs-iso'] . '>Czech (iso)</option>
      <option value="cs-win1250" ' . $langSelected['cs-win1250'] . '>Czech (win1250)</option>
      <option value="da" ' . $langSelected['da'] . '>Danish</option>
      <option value="nl" ' . $langSelected['nl'] . '>Dutch</option>
      <option value="en" ' . $langSelected['en'] . '>English</option>
      <option value="et" ' . $langSelected['et'] . '>Estonian</option>
      <option value="fr" ' . $langSelected['fr'] . '>French</option>
      <option value="de" ' . $langSelected['de'] . '>German</option>
      <option value="hu" ' . $langSelected['hu'] . '>Hungarian</option>
      <option value="is" ' . $langSelected['is'] . '>Icelandic</option>
      <option value="in" ' . $langSelected['in'] . '>Indonesian</option>
      <option value="it" ' . $langSelected['it'] . '>Italian</option>
      <option value="ko" ' . $langSelected['ko'] . '>Korean</option>
      <option value="lv" ' . $langSelected['lv'] . '>Latvian</option>
      <option value="no" ' . $langSelected['no'] . '>Norwegian</option>
      <option value="pl" ' . $langSelected['pl'] . '>Polish</option>
      <option value="pt" ' . $langSelected['pt'] . '>Portuguese</option>
      <option value="ro" ' . $langSelected['ro'] . '>Romanian</option>
      <option value="ru" ' . $langSelected['ru'] . '>Russian</option>
      <option value="sk-win1250" ' . $langSelected['sk-win1250'] . '>Slovak (win1250)</option>
      <option value="es" ' . $langSelected['es'] . '>Spanish</option>
      <option value="tr" ' . $langSelected['tr'] . '>Turkish</option>
      <option value="uk" ' . $langSelected['uk'] . '>Ukrainian</option>
      </select>
    </td>
  </tr>';

$block1->contentRow('* Root', '<input size="44" value="' . $root . '" style="width: 200px" name="rootNew" maxlength="100" type="text">');

$block1->contentRow('* Default max file size', '<input size="44" value="' . $maxFileSize . '" style="width: 200px" name="maxFileSizeNew" maxlength="100" type="text"> ' . $byteUnits[0]);

$block1->contentTitle('Options');
$block1->contentRow('Clients filter' . $blockPage->printHelp('setup_clientsfilter'), '<input type="radio" name="clientsFilterNew" value="false" ' . $checked2_d . '> False&nbsp;<input type="radio" name="clientsFilterNew" value="true" ' . $checked1_d . '> True');
$block1->contentRow('Projects filter' . $blockPage->printHelp('setup_projectsfilter'), '<input type="radio" name="projectsFilterNew" value="false" ' . $checked2_h . '> False&nbsp;<input type="radio" name="projectsFilterNew" value="true" ' . $checked1_h . '> True');

$block1->contentTitle('Advanced');
$block1->contentRow('Extended footer (dev)', '<input type="radio" name="footerdevNew" value="false" ' . $checked2_j . '> False&nbsp;<input type="radio" name="footerdevNew" value="true" ' . $checked1_j . '> True');
$block1->contentRow('MySQL client charset', '<input name="mycharsetNew" value="'.$databaseCharset.'" size="10" maxlength="50" type="text"');
// $block1->contentRow('Mantis integration','<input type="radio" name="mantisNew" value="false" '.$checked2_k.'> False&nbsp;<input type="radio" name="mantisNew" value="true" '.$checked1_k.'> True');
// $block1->contentRow('Mantis url','<input size="44" value="'.$pathMantis.'" style="width: 200px" name="pathMantisNew" maxlength="100" type="text">');
$block1->contentRow('', '<input type="SUBMIT" value="' . $strings['save'] . '">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
