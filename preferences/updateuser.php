<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: updateuser.php,v 1.5 2004/12/13 00:18:25 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

if ($action == "update") {
    if (($logout_time < "30" && $logout_time != "0") || !is_numeric($logout_time)) {
        $logout_time = "30";
    } 

    $fn = convertData($fn);
    $tit = convertData($tit);
    $em = convertData($em);
    $wp = convertData($wp);
    $hp = convertData($hp);
    $mp = convertData($mp);
    $fax = convertData($fax);
    $logout_time = convertData($logout_time);
    $start_page = convertData($start_page);

    $tmpquery = "UPDATE " . $tableCollab["members"] . " SET name='$fn',title='$tit',email_work='$em',phone_work='$wp',phone_home='$hp',mobile='$mp',fax='$fax',logout_time='$logout_time',timezone='$tz',last_page='$start_page' WHERE id = '" . $_SESSION['idSession'] . "'";

    connectSql($tmpquery);

    // save to the session
    $_SESSION['logouttimeSession'] = $logout_time;
    $_SESSION['timezoneSession'] = $tz;
    $_SESSION['dateunixSession'] = date("U");
    $_SESSION['nameSession'] = $fn; 

    // if mantis bug tracker enabled
    if ($enableMantis == "true") {
        // Call mantis function for user profile changes..!!!
        require_once ("../mantis/user_profile.php");
    } 

    header("Location: ../preferences/updateuser.php?msg=update");
    exit;
} 

$tmpquery = "WHERE mem.id = '" . $_SESSION['idSession'] . "'";
$userPrefs = new request();
$userPrefs->openMembers($tmpquery);
$comptUserPrefs = count($userPrefs->mem_id);

if ($comptUserPrefs == "0") {
    header("Location: ../users/listusers.php?msg=blankUser");
    exit;
} 



//--- header ---
$breadcrumbs[]=$strings["preferences"];
if ($notifications == "true") {
    $breadcrumbs[]=$strings["user_profile"] . "&nbsp; | &nbsp;" . buildLink("../preferences/updatepassword.php?", $strings["change_password"], LINK_INSIDE) . "&nbsp; | &nbsp;" . buildLink("../preferences/updatenotifications.php?", $strings["notifications"], LINK_INSIDE);
} else {
    $breadcrumbs[]=$strings["user_profile"] . "&nbsp; | &nbsp;" . buildLink("../preferences/updatepassword.php?", $strings["change_password"], LINK_INSIDE);
} 



$bodyCommand = "onLoad=\"document.user_edit_profileForm.fn.focus();\"";
$pageSection = 'preferences';
require_once("../themes/" . THEME . "/header.php");

//--- content -------
$blockPage= new block();

$block1 = new block();

$block1->form = "user_edit_profile";
$block1->openForm("../preferences/updateuser.php");
echo "<input type=\"hidden\" name=\"action\" value=\"update\">";

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->heading($strings["user_profile"] . " : " . $userPrefs->mem_login[0]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "export", $strings["export"]);
$block1->closePaletteIcon();

$block1->openContent();
$block1->contentTitle($strings["edit_user_account"]);

$block1->contentRow($strings["full_name"], "<input size=\"24\" style=\"width: 250px;\" type=\"text\" name=\"fn\" value=\"" . $userPrefs->mem_name[0] . "\">");
$block1->contentRow($strings["title"], "<input size=\"24\" style=\"width: 250px;\" type=\"text\" name=\"tit\" value=\"" . $userPrefs->mem_title[0] . "\">");
$block1->contentRow($strings["email"], "<input size=\"24\" style=\"width: 250px;\" type=\"text\" name=\"em\" value=\"" . $userPrefs->mem_email_work[0] . "\">");
$block1->contentRow($strings["work_phone"], "<input size=\"14\" style=\"width: 150px;\" type=\"text\" name=\"wp\" value=\"" . $userPrefs->mem_phone_work[0] . "\">");
$block1->contentRow($strings["home_phone"], "<input size=\"14\" style=\"width: 150px;\" type=\"text\" name=\"hp\" value=\"" . $userPrefs->mem_phone_home[0] . "\">");
$block1->contentRow($strings["mobile_phone"], "<input size=\"14\" style=\"width: 150px;\" type=\"text\" name=\"mp\" value=\"" . $userPrefs->mem_mobile[0] . "\">");
$block1->contentRow($strings["fax"], "<input size=\"14\" style=\"width: 150px;\" type=\"text\" name=\"fax\" value=\"" . $userPrefs->mem_fax[0] . "\">");
// build the select menu
$logoutMenu = '<select name="logout_time" id="logout_time">';
foreach ($autoLogoutOptions as $key => $value) {
    if ($userPrefs->mem_logout_time[0] == $key) {
        $logoutMenu .= '<option value="' . $key . '" selected>' . $value . '</option>';
    } else {
        $logoutMenu .= '<option value="' . $key . '">' . $value . '</option>';
    } 
} 
$logoutMenu .= '</select>';
// $block1->contentRow($strings['logout_time'].$blockPage->printHelp('user_autologout'),$logoutMenu);
$block1->contentRow($strings['logout_time'], $logoutMenu);

if ($gmtTimezone == "true") {
    $selectTimezone = "<select name=\"tz\">";
    for ($i = -12;$i <= + 12;$i++) {
        if ($userPrefs->mem_timezone[0] == $i) {
            $selectTimezone .= "<option value=\"$i\" selected>$i</option>";
        } else {
            $selectTimezone .= "<option value=\"$i\">$i</option>";
        } 
    } 
    $selectTimezone .= "</select>";
    $block1->contentRow($strings["user_timezone"] . $blockPage->printHelp("user_timezone"), $selectTimezone);
} 

// let the user select the prefered startpage
$startPageMenu = '<select name="start_page" id="start_page">';

// if admin user then add the admin page to array
if ($userPrefs->mem_profil[0] == 0) {
    $startPageOptions = array_merge(array('administration/admin.php' => 'Administration page'), $startPageOptions);
}

// build the select list
foreach ($startPageOptions as $key => $value) {
    if ($userPrefs->mem_last_page[0] == $key) {
        $startPageMenu .= '<option value="' . $key . '" selected>' . $value . '</option>';
    } else {
        $startPageMenu .= '<option value="' . $key . '">' . $value . '</option>';
    } 
} 
$startPageMenu .= '</select>';

$block1->contentRow($strings['start_page'], $startPageMenu);

if ($userPrefs->mem_profil[0] == "0") {
    $block1->contentRow($strings["permissions"], $strings["administrator_permissions"]);
} else if ($userPrefs->mem_profil[0] == "1") {
    $block1->contentRow($strings["permissions"], $strings["project_manager_permissions"]);
} else if ($userPrefs->mem_profil[0] == "2") {
    $block1->contentRow($strings["permissions"], $strings["user_permissions"]);
} else if ($userPrefs->mem_profil[0] == "5") {
    $block1->contentRow($strings["permissions"], $strings["project_manager_administrator_permissions"]);
} 

$block1->contentRow($strings["account_created"], createDate($userPrefs->mem_created[0], $_SESSION['timezoneSession']));
$block1->contentRow("", "<input type=\"submit\" name=\"Save\" value=\"" . $strings["save"] . "\">");

$block1->closeContent();
$block1->closeForm();

$block1->openPaletteScript();
$block1->paletteScript(0, "export", "../users/exportuser.php?id=" . $_SESSION['idSession'], "true,true,true", $strings["export"]);
$block1->closePaletteScript("", "");

require_once("../themes/" . THEME . "/footer.php");

?>
