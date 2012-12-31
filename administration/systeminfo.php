<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: systeminfo.php,v 1.7 2004/12/15 19:43:11 madbear Exp $
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

if ($_SESSION['profilSession'] != '0') {
    header('Location: ../general/permissiondenied.php');
    exit;
} 





$breadcrumbs[]=buildLink('../administration/admin.php?', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['system_information'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');


$block1 = new block();

$block1->headingForm($strings['system_information']);

$block1->openContent();
$block1->contentTitle($strings['product_information']);

$block1->contentRow('NetOffice Version', $version);
$block1->contentRow('File Management', $fileManagement . " (default max file size $maxFileSize $byteUnits[0])");

if ($mkdirMethod == 'FTP') {
    $mkdirMethodMore = ' (Path to root with mentionned account: ' . $ftpRoot . ')';
} 

$block1->contentRow('Create folder method', $mkdirMethod . $mkdirMethodMore);
$block1->contentRow('Theme', THEME);
$block1->contentRow('Product Site Publish', $sitePublish);
$block1->contentRow('Notifications', $notifications);
$block1->contentRow('Root', $root);

if ($useLDAP == true) {
    $loginMethodMore = ' + LDAP';
} 

$block1->contentRow('Login Method', $loginMethod . $loginMethodMore);

if ($databaseType == 'mysql') {
    $databaseTypeMore = 'MySql';
    $MY_DBH = openDatabase();
    $local_query = 'SELECT VERSION() as version';
    $res = mysql_query($local_query, $MY_DBH);
    $databaseVersion = mysql_result($res, 0, 'version');
} 

$block1->contentRow('Database Type', $databaseTypeMore);
$block1->contentRow('Files folder size', convertSize(folder_info_size('../files/')));

$block1->contentTitle($strings['system_properties']);
$block1->contentRow('PHP Version', phpversion() . ' ' . buildLink('../administration/phpinfo.php?', 'PhpInfo', LINK_BLANK));
$block1->contentRow($databaseTypeMore . ' version', $databaseVersion);
$block1->contentRow('extension_dir', ini_get(extension_dir));

$ext = get_loaded_extensions();
$comptExt = count($ext);

for ($i = 0;$i < $comptExt;$i++) {
    $extensions .= $ext[$i];

    if ($i != $comptExt-1) {
        $extensions .= ', ';
    } 
} 

$block1->contentRow('Loaded extensions', $extensions);

$include_path = ini_get(include_path);

if ($include_path == '') {
    $include_result = '<i>No value</i>';
} else {
    $include_result = $include_path;
} 

$block1->contentRow('include_path', $include_result);

$register_globals = ini_get(register_globals);

if ($register_globals == 1) {
    $register_result = 'On';
} else {
    $register_result = 'Off';
} 

$block1->contentRow('register_globals', $register_result);

$magic_quotes_gpc = ini_get(magic_quotes_gpc);

if ($magic_quotes_gpc == 1) {
    $magic_gpc_result = 'On';
} else {
    $magic_gpc_result = 'Off';
} 

$block1->contentRow('magic_quotes_gpc', $magic_gpc_result);

$magic_quotes_runtime = ini_get(magic_quotes_runtime);

if ($magic_quotes_runtime == 1) {
    $magic_runtime_result = 'On';
} else {
    $magic_runtime_result = 'Off';
} 

$block1->contentRow('magic_quotes_runtime', $magic_runtime_result);

$safemodeTest = ini_get(safe_mode);

if ($safemodeTest == 1) {
    $safe_mode_result = 'On';
} else {
    $safe_mode_result = 'Off';
} 

$block1->contentRow('safe_mode', $safe_mode_result);

$notificationsTest = function_exists('mail');

if ($notificationsTest == true) {
    $mail_result = 'On';
} else {
    $mail_result = 'Off';
} 

$block1->contentRow('Mail', $mail_result);

$gdlibraryTest = function_exists('imagecreate');

if ($gdlibraryTest == true) {
    ob_start();
    phpinfo();
    $buffer = ob_get_contents();
    ob_end_clean();
    preg_match("|<b>GD Version</b></td><td align=\"left\">([^<]*)</td>|i", $buffer, $matches);
    preg_match("|GD Version </td><td class=\"v\">([^<]*)</td>|i", $buffer, $matches);
    preg_match("|GD Version</B></td><TD ALIGN=\"left\">([^<]*)</td>|i", $buffer, $matches);
    $gd_result = 'On';
} else {
    $gd_result = 'Off';
} 

$block1->contentRow('GD', $gd_result);

if ($matches[1] != '') {
    $block1->contentRow('GD version', $matches[1]);
} 

$block1->contentRow('SMTP', ini_get(SMTP));
$block1->contentRow('upload_max_filesize', ini_get(upload_max_filesize));
$block1->contentRow('session.name', session_name());
$block1->contentRow('HTTP_HOST', $_SERVER['HTTP_HOST']);

if (substr(PHP_OS, 0, 3) == 'WIN') {
    $block1->contentRow('PATH_TRANSLATED', stripSlashes($_SERVER['PATH_TRANSLATED']));
} else {
    $block1->contentRow('PATH_TRANSLATED', $_SERVER['PATH_TRANSLATED']);
} 

$block1->contentRow('SERVER_NAME', $_SERVER['SERVER_NAME']);
$block1->contentRow('SERVER_PORT', $_SERVER['SERVER_PORT']);
$block1->contentRow('SERVER_SOFTWARE', $_SERVER['SERVER_SOFTWARE']);
$block1->contentRow('SERVER_OS', PHP_OS);

$block1->closeContent();
$block1->headingForm_close();

require_once('../themes/' . THEME . '/footer.php');

?>
