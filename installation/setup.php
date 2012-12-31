<?php // $Revision: 1.16 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: setup.php,v 1.16 2005/06/11 19:30:41 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

error_reporting(E_ALL & ~E_NOTICE);

require_once('../includes/error_handler.php');
require_once('../languages/help_en.php');

define("INSTALL", true);

$step = $_REQUEST['step'];
$connexion = $_REQUEST['connexion'];
$redirect = $_REQUEST['redirect'];
$action = $_REQUEST['action'];
$updatechecker = $_REQUEST['updatechecker'];
$installationType = $_REQUEST['installationType'];
$databaseType = $_REQUEST['databaseType'];
$myserver = $_REQUEST['myserver'];
$mylogin = $_REQUEST['mylogin'];
$mypassword = $_REQUEST['mypassword'];
$mydatabase = $_REQUEST['mydatabase'];
$myprefix = $_REQUEST['myprefix'];
$mkdirMethod = $_REQUEST['mkdirMethod'];
$notifications = $_REQUEST['notifications'];
$forcedlogin = $_REQUEST['forcedlogin'];
$langdefault = $_REQUEST['langdefault'];
$root = $_REQUEST['root'];
$loginMethod = $_REQUEST['loginMethod'];
$adminPwd = $_REQUEST['adminPwd'];
$cryptKey = get_crypt_key();
$basedir = preg_replace('/installation$/i', '', str_replace('\\', '/', dirname(__FILE__)), 1);

if ($redirect == "true" && $step == "2") {
    header("Location: ../installation/setup.php?step=2&connexion=$connexion");
}

if (substr($root, -1) == "/") {
    $root = substr($root, 0, -1);
}

if (substr($ftpRoot, -1) == '/') {
    $ftpRoot = substr($ftpRoot, 0, -1);
}

$version = '2.6.0b2';

$dateheure = date("Y-m-d H:i");

if ($action == "generate") {
    if ($myserver == '') {
        $error = 'Must be insert the database Server';
    } else if ($mylogin == '') {
        $error = 'Must be insert the database Login';
    } else if ($mydatabase == '') {
        $error = 'Must be insert the database Name';
    } else if ($root == '') {
        $error = 'Must be insert the Root path';
    } else if ($adminPwd == '') {
        $error = 'Must be insert the Admin password';
    }

    if ($installationType == "offline") {
        $updatechecker = "false";
    }

    require_once('./setup_settings.php');

    if (!$error) {
        $fp = fopen('../includes/settings.php', 'wb+');
        $fw = fwrite($fp, $content);
        
        if (!$fw) {
            $error = 1;
            echo "<br><b>PANIC! <br> settings.php can't be written!</b><br>";
        }
        
        fclose($fp);
        $msg = 'File settings.php created correctly.';
        // crypt admin and demo password
        $demoPwd = get_password("demo");
        $adminPwd = get_password($adminPwd);
        // create all tables
        require_once("./db_var.inc.php");
        require_once("./setup_db.php");
        if ($databaseType == "mysql") {
            $my = mysql_connect($myserver, $mylogin, $mypassword);
            if (mysql_errno($my) != 0) {
                print '<br><b>PANIC! <br> Error during connection on server MySQL.</b><br>';
                print "[". mysql_errno($my) . "] " . mysql_error($my) ."<br/>\n";
                exit;
            }
            
            mysql_select_db($mydatabase, $my);
            
            if (mysql_errno() != 0) {
                exit('<br><b>PANIC! <br> Error during selection database.</b><br>');
            }

            for($con = 0; $con < count($SQL); $con++) {
                mysql_query($SQL[$con]);
                // echo $SQL[$con] . ';<br>';
                
                if (mysql_errno() != 0) {
                    exit('<br><b>PANIC! <br> Error during the creation of the tables.</b><br> Error: ' . mysql_error());
                }
            }
        }

        $msg .= '<br>Tables and settings file created correctly.';
        $msg .= '<br><br><a href=../general/login.php>Please log in</a>';
    } else {
        $msg = $error;
    } 
} 

if ($step == "") {
    $step = "1";
} 

$setTitle = "Online Project Management";
define('THEME', 'deepblue');
$blank = "true";
require_once("../themes/" . THEME . "/block.class.php");


$breadcrumbs[]="<a href=\"../installation/setup.php\">Setup</a>";

if ($step == "1") {
    $breadcrumbs[]="License";
} else if ($step > "1") {
    $breadcrumbs[]="<a href=\"../installation/setup.php?step=1\">License</a>";
    if ($step == "2") {
        $breadcrumbs[]="Settings";
    } else if ($step > "2") {
        $breadcrumbs[]="<a href=\"../installation/setup.php?step=2\">Settings</a>";
        if ($step == "3") {
            $breadcrumbs[]="Control";
        } 
    } 
} 

//--- hack by pixtur -------
// NOTE:
// - those globals are required by 'header.php' and normally defined at library.php 
// - but library can NOT be included here, because it requires database to be setup.
// -
{
	//--- defining link-type-constants----
	define('LINK_INSIDE', 	'in');
	define('LINK_STRIKE',	'in_strike');
	define('LINK_BLANK',	'in_blank');
	define('LINK_OUT',		'out');
	define('LINK_ICON',		'icone');
	define('LINK_POWERED',	'powered');
	define('LINK_MAIL',		'mail');

	//--- all available sections with url (this should be a list of objects...)
	$headerSections=array(
		'login'=>		'../general/login.php',
		'requirements'=>'../general/systemrequirements.php',
		'license'=>		'../general/license.php',
		'home'=>		'../general/home.php',
		'projects'=>	'../projects/listprojects.php',
		'clients'=>		'../clients/listclients.php',
		'reports'=>		'../reports/createreport.php',
		'search'=>		'../search/createsearch.php',
		'calendar'=>	'../calendar/viewcalendar.php',
		'bookmarks'=>	'../bookmarks/listbookmarks.php?view=all',
		'preferences'=>	'../preferences/updateuser.php',
		'admin'=>	    '../administration/admin.php'
	);

	$notLogged=true;

	require_once("../themes/" . THEME . "/header.php");
}

$block1 = new block();

if ($step == "1") {
    $block1->headingForm("License");
}
else if ($step == "2") {
    $block1->headingForm("Settings");
}
else if ($step == "3") {
    $block1->headingForm("Control");
}

if ($step == "1") {
    $block1->openContent();
    //$block1->contentTitle("&nbsp;");

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>
	<div class=license>";
    include_once('../docs/copying.txt');
    echo "</div>
</td></tr>";
    $block1->closeContent();
}

if ($step == "2") {
    $block1->openContent();
    $block1->contentTitle("Details");
    $block1->form = "settings";
    $block1->openForm("../installation/setup.php?action=generate&amp;step=3");

    if ($connexion == "off") {
        echo "<input value=\"false\" name=\"updatechecker\" type=\"hidden\">";
    } else if (@join('', file("http://netoffice.sourceforge.net/version.txt"))) {
        echo "<input value=\"true\" name=\"updatechecker\" type=\"hidden\">";
    } else {
        echo "<input value=\"false\" name=\"updatechecker\" type=\"hidden\">";
    } 

    if ($connexion == "off") {
        $installCheckOffline = "checked";
    } else {
        $installCheckOnline = "checked";
    } 

    if ($databaseType == "mysql" || $databaseType == "") {
        $dbCheckMysql = "checked";
    } 

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Installation type :</td><td><input type=\"radio\" name=\"installationType\" value=\"offline\" $installCheckOffline> Offline (firewall/intranet, no update checker)&nbsp;<input type=\"radio\" name=\"installationType\" value=\"online\" $installCheckOnline> Online</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Database type :</td><td><input type=\"radio\" name=\"databaseType\" value=\"mysql\" $dbCheckMysql> MySql</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Database server :</td><td><input size=\"44\" value=\"$myserver\" style=\"width: 200px\" name=\"myserver\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Database login :</td><td><input size=\"44\" value=\"$mylogin\" style=\"width: 200px\" name=\"mylogin\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">Database password :</td><td><input size=\"44\" value=\"$mypassword\" style=\"width: 200px\" name=\"mypassword\" maxlength=\"100\" type=\"password\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Database name :</td><td><input size=\"44\" value=\"$mydatabase\" style=\"width: 200px\" name=\"mydatabase\" maxlength=\"100\" type=\"text\"></td></tr>

<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">Table prefix :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_myprefix"]) . "',ABOVE,SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td><input size=\"44\" value=\"$myprefix\" style=\"width: 200px\" name=\"myprefix\" maxlength=\"100\" type=\"text\"></td></tr>";

    $safemodeTest = ini_get(safe_mode);
    if ($safemodeTest == "1") {
        $checked1_a = "checked"; //false
        $safemode = "on";
    } else {
        $checked2_a = "checked"; //true
        $safemode = "off";
    } 

    $notificationsTest = function_exists('mail');
    if ($notificationsTest == "true") {
        $checked2_b = "checked"; //false
        $gdlibrary = "on";
    } else {
        $checked1_b = "checked"; //true
        $gdlibrary = "off";
    } 

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Create folder method :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_mkdirMethod"]) . "',SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td>

<table cellpadding=0 cellspacing=0><tr><td valign=top><input type=\"radio\" name=\"mkdirMethod\" value=\"FTP\" $checked1_a> FTP&nbsp;<input type=\"radio\" name=\"mkdirMethod\" value=\"PHP\" $checked2_a> PHP<br>[Safe-mode $safemode]</td><td align=right>";
    if ($safemodeTest == "1") {
        echo "Ftp server <input size=\"44\" value=\"$ftpserver\" style=\"width: 200px\" name=\"ftpserver\" maxlength=\"100\" type=\"text\"><br>
Ftp login <input size=\"44\" value=\"$ftplogin\" style=\"width: 200px\" name=\"ftplogin\" maxlength=\"100\" type=\"text\"><br>
Ftp password <input size=\"44\" value=\"$ftppassword\" style=\"width: 200px\" name=\"ftppassword\" maxlength=\"100\" type=\"password\"><br>
Ftp root <input size=\"44\" value=\"$ftpRoot\" style=\"width: 200px\" name=\"ftpRoot\" maxlength=\"100\" type=\"text\">";
    } 

    echo "</td></tr></table>

</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Notifications :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_notifications"]) . "',SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td><input type=\"radio\" name=\"notifications\" value=\"false\" $checked1_b> False&nbsp;<input type=\"radio\" name=\"notifications\" value=\"true\" $checked2_b> True<br>[Mail $gdlibrary]</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Forced login :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_forcedlogin"]) . "',SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td><input type=\"radio\" name=\"forcedlogin\" value=\"false\" checked> False&nbsp;<input type=\"radio\" name=\"forcedlogin\" value=\"true\"> True</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">Default language :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_langdefault"]) . "',SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td>
           <select name=langdefault>
            <option value=\"\">Blank</option>
	<option value=az>Azerbaijani</option>
	<option value=pt-br>Brazilian Portuguese</option>
	<option value=bg>Bulgarian</option>
	<option value=ca>Catalan</option>
	<option value=zh>Chinese simplified</option>
	<option value=zh-tw>Chinese traditional</option>
	<option value=cs-iso>Czech (iso)</option>
	<option value=cs-win1250>Czech (win1250)</option>
	<option value=da>Danish</option>
	<option value=nl>Dutch</option>
	<option value=en>English</option>
	<option value=et>Estonian</option>
	<option value=fr>French</option>
	<option value=de>German</option>
	<option value=hu>Hungarian</option>
	<option value=is>Icelandic</option>
	<option value=in>Indonesian</option>
	<option value=it>Italian</option>
	<option value=ko>Korean</option>
	<option value=lv>Latvian</option>
	<option value=no>Norwegian</option>
	<option value=pl>Polish</option>
	<option value=pt>Portuguese</option>
	<option value=ro>Romanian</option>
	<option value=ru>Russian</option>
	<option value=sk-win1250>Slovak (win1250)</option>
	<option value=es>Spanish</option>
	<option value=sv>Swedish</option>
	<option value=tr>Turkish</option>
	<option value=uk>Ukrainian</option>
           </select>
          </td>
         </tr>";

    $url = $_SERVER['SERVER_NAME'];
    if ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) {
        $url .= ":" . $_SERVER['SERVER_PORT'];
    } 
    if ($_SERVER['HTTPS'] == "on") {
        $protocol = "https://";
    } else {
        $protocol = "http://";
    } 
    $root = $protocol . $url . dirname($_SERVER['PHP_SELF']);
    $root = str_replace("installation", "", $root);

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"> * Root :</td><td><input size=\"44\" value=\"$root\" style=\"width: 200px\" name=\"root\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Login method :<br>[<a href=\"javascript:void(0);\" onmouseover=\"return overlib('" . addslashes($help["setup_loginmethod"]) . "',SNAPX,550,BGCOLOR,'#5B7F93',FGCOLOR,'#C4D3DB');\" onmouseout=\"return nd();\">Help</a>] </td><td><input type=\"radio\" name=\"loginMethod\" value=\"PLAIN\"> Plain&nbsp;<input type=\"radio\" name=\"loginMethod\" value=\"MD5\"> Md5&nbsp;<input type=\"radio\" name=\"loginMethod\" value=\"CRYPT\" checked> Crypt</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* Admin password :</td><td><input size=\"44\" value=\"$adminPwd\" style=\"width: 200px\" name=\"adminPwd\" maxlength=\"100\" type=\"password\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"Save\"></td></tr>";
    $block1->closeContent();
    $block1->closeForm();
} 

if ($step == "3") {
    $block1->openContent();
    $block1->contentTitle("&nbsp;");

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>$msg</td></tr>";
    $block1->closeContent();
} 
$block1->headingForm_close();

$stepNext = $step + 1;
if ($step < "2") {
    echo "<form name=\"license\" action=\"../installation/setup.php?step=2&amp;redirect=true\" method=\"post\"><center><a href=\"javascript:document.license.submit();\"><b>Step $stepNext</b></a><br><br><input type=\"checkbox\" value=\"off\" name=\"connexion\"> Offline installation (firewall/intranet, no update checker)</center></form><br>";
} 

$footerDev = false;
require_once("../themes/" . THEME . "/footer.php");

// Generates the unique [en|de]cryption key for your installation
function get_crypt_key()
{
  srand((double)microtime()*1000000);
  return(md5(uniqid(rand(),1)));
}

// return a password using the globally specified method
function get_password($newPassword)
{
    global $loginMethod;

    switch ($loginMethod) {
        case MD5:
            return md5($newPassword);
        case CRYPT:
            $salt = substr($newPassword, 0, 2);
            return crypt($newPassword, $salt);
        case PLAIN:
            return $newPassword;
        default:
            return $newPassword;
    }
}

?>
