<?php // $Revision: 1.12 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: upgrade.php,v 1.12 2005/06/11 19:30:41 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * Web based script to upgrade existing installations of NetOffice, easily.
 */

error_reporting(E_ALL & ~E_NOTICE);

define('THEME', 'deepblue');

require_once('../includes/settings.php');
require_once('../includes/error_handler.php');
require_once('../languages/lang_en.php');
require_once('../languages/help_en.php');

$versionNew = '2.6.0b2';

define("INSTALL", true);

// upgrades the settings.php file
if ($_GET['action'] == 'settings') {
    // get unique cryptKey for this installation if needed
    if (empty($cryptKey)) {
        $cryptKey = get_crypt_key();
    }

    // basedir of NetOffice, in windows change the \ to /
    $basedir = preg_replace('/installation$/i', '', str_replace('\\', '/', dirname(__FILE__)), 1);

    include_once('./upgrade_settings.php');

    $fp = fopen('../includes/settings.php', 'wb+');
    $fw = fwrite($fp, $settingsNew);

    if (!$fw) {
        $_GET['step'] = 2;
        $msg = '<b>PANIC! error while writing settings.php file!</b>';
    } else {
        $msg = 'File settings.php created correctly.<br>';
    } 

    fclose($fp);
} 

// update database
if ($_GET['action'] == 'database') {
    include_once('./upgrade_db.php');

    if (count($SQL) >= 1) {
        if ($databaseType == 'mysql') {
            $my = mysql_connect(MYSERVER, MYLOGIN, MYPASSWORD);

            if (mysql_errno() != 0) {
                exit('<br><b>PANIC! Error during connection on server MySQL.</b><br>');
            } 

            mysql_select_db(MYDATABASE, $my);

            if (mysql_errno() != 0) {
                exit('<br><b>PANIC! Error during selection database.</b><br>');
            } 

            for($con = 0; $con < count($SQL); $con++) {
                mysql_query($SQL[$con]); 
                // echo $SQL[$con].'<br>';
                if (mysql_errno() != 0) {
                    exit('<br><b>PANIC! Error during the update of the database.</b><br> Error: ' . mysql_error());
                } 
            } 
        } 

        $msg = 'Database has been updated successfully.';
    } else {
        $msg = 'There were no database changes required.';
    } 
} 

// page settings
if ($_GET['step'] == 4) {
    $setTitle = 'NetOffice v' . $versionNew;
} else {
    $setTitle = 'NetOffice v' . $versionNew . ' upgrade from v' . $version;
} 

$blank = 'true';
require_once('../themes/' . THEME . '/block.class.php');

// set default step if empty
if ($_GET['step'] == '') {
    $_GET['step'] = 1;
} 

$breadcrumbs[]='<a href="../installation/upgrade.php">Upgrade</a>';

// setup breadcrumb navigation links
if ($_GET['step'] == 1 or $_GET['step'] > 4) {
    $breadcrumbs[]='License';
} else if ($_GET['step'] > 1) {
    $breadcrumbs[]='<a href="../installation/upgrade.php?step=1">License</a>';
    if ($_GET['step'] == 2) {
        $breadcrumbs[]='Database';
    } else if ($_GET['step'] > 2) {
        $breadcrumbs[]='<a href="../installation/upgrade.php?step=2">Database</a>';
        if ($_GET['step'] == 3) {
            $breadcrumbs[]='Settings';
        } else if ($_GET['step'] > 3) {
            $breadcrumbs[]='<a href="../installation/upgrade.php?step=3">Settings</a>';
            if ($_GET['step'] == 4) {
                $breadcrumbs[]='Done';
            } 
        } 
    } 
} 

require_once('../themes/' . THEME . '/header.php');

//--- content -----
$block1 = new block();
// headings
if ($_GET['step'] == 2) {
    $block1->headingForm('Database');
} 
else if ($_GET['step'] == 3) {
    $block1->headingForm('Settings');
} 
else if ($_GET['step'] == 4) {
    $block1->headingForm('Done');
} 
else {
    $block1->headingForm('License');
} 
// page contents for different steps
if ($_GET['step'] == '2') {
    $block1->openContent();
    $block1->contentTitle('Here the update script will update the database to the current version.');
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>';
    echo 'Be sure to backup the database before you proceed, you can never be too careful.';
    echo '</td></tr>';
    $block1->form = 'database';
    $block1->openForm('../installation/upgrade.php?action=database&amp;step=3');
    $block1->closeContent();
    echo '<center><input type="submit" name="submit" value="STEP 3 >>"></center>';
    $block1->closeForm();
} 
else if ($_GET['step'] == '3') {
    $block1->openContent();
    $block1->contentTitle('Here the update script will update the settings.php file with any new parameters.');
    $file_error = false;
    if (!file_exists('../includes/settings.php')) {
        $block1->contentRow('ERROR', '../includes/settings.php not found!');
        $file_error = true;
    } 

    if (!is_writeable('../includes/settings.php')) {
        $block1->contentRow('ERROR', '../includes/settings.php is not writeable! Please check the permissions (on unix chmod 666)');
        $file_error = true;
    } 

    if (!$file_error) {
        echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>Make a backup copy of your settings.php file!</td></tr>';
        echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>Every thing appears OK, press the continue button to write the new settings.php file.</td></tr>';
        $block1->form = 'settings';
        $block1->openForm('../installation/upgrade.php?action=settings&amp;step=4');
        $block1->closeContent();
        echo '<center><input type="submit" name="submit" value="STEP 4 >>"></center>';
        $block1->closeForm();
    } else {
        $block1->closeContent();
    } 
} 
else if ($_GET['step'] == '4') {
    $block1->openContent();
    $block1->contentTitle('Upgrade was successful');
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>';
    echo 'NetOffice has been successfully upgraded.</td></tr>';
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>';
    echo 'You may now <a href="../general/login.php">login to NetOffice v' . $versionNew . '</a></td></tr>';
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>&nbsp;</td></tr>';
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td>';
    echo '<b>SECURITY NOTE:</b> Be sure to remove the installation directory along with its contents!</td></tr>';
    $block1->closeContent();
}
else {
    $block1->openContent();
    //$block1->contentTitle('&nbsp;');
    echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td><div class=license>';
    include_once('../docs/copying.txt');
    echo '</div></td></tr>';
    $block1->form = 'license';
    $block1->openForm('../installation/upgrade.php?step=2');
    $block1->closeContent();
    echo '<center><input type="submit" name="submit" value="STEP 2 >>"></center>';
    $block1->closeForm();
} 
$block1->headingForm_close();

$footerDev = false;
require_once('../themes/' . THEME . '/footer.php');

// Generates the unique [en|de]cryption key for your installation
function get_crypt_key()
{
  srand((double)microtime()*1000000);
  return(md5(uniqid(rand(),1)));
}

?>
