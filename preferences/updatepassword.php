<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: updatepassword.php,v 1.7 2004/12/15 12:25:22 pixtur Exp $
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

if ($enable_cvs == "true") {
    require_once("../includes/cvslib.php");
} 

if ($action == "update") {
    // encrypt the old password using the defined loginMethod
    $opw = get_password($opw);

    if ($opw != $_SESSION['passwordSession']) {
        $error = $strings["old_password_error"];
    } else {
        if ($npw != $pwa || $npw == "") {
            $error = $strings["new_password_error"];
        } else {
            $cnpw = get_password($npw);

            if ($htaccessAuth == "true") {
                require_once("../includes/htpasswd.class.php");
                $Htpasswd = new Htpasswd;
                $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "'";
                $listProjects = new request();
                $listProjects->openTeams($tmpquery);
                $comptListProjects = count($listProjects->tea_id);

                if ($comptListProjects != "0") {
                    for ($i = 0;$i < $comptListProjects;$i++) {
                        $Htpasswd->initialize("../files/" . $listProjects->tea_pro_id[$i] . "/.htpasswd");
                        $Htpasswd->changePass($_SESSION['loginSession'], $cnpw);
                    } 
                } 
            } 

            $tmpquery = "UPDATE " . $tableCollab["members"] . " SET password='$cnpw' WHERE id = '" . $_SESSION['idSession'] . "'";
            connectSql("$tmpquery");
            // if mantis bug tracker enabled
            if ($enableMantis == "true") {
                // call mantis function to reset user password
                require_once ("../mantis/user_reset_pwd.php");
            } 
            // if CVS repository enabled
            if ($enable_cvs == "true") {
                $query = "WHERE tea.member = '" . $_SESSION['idSession'] . "'";
                $cvsMembers = new request();
                $cvsMembers->openTeams($query);
                // change the password in every repository
                for ($i = 0;$i < (count($cvsMembers->tea_id));$i++) {
                    cvs_change_password($cvsMembers->tea_mem_login[$i], $cnpw, $cvsMembers->tea_pro_id[$i]);
                } 
            } 

            // encrypt the new password to the session using the defined loginMethod
            $_SESSION['passwordSession'] = get_password($npw);
            header("Location: ../preferences/updateuser.php?msg=update");
            exit;
        } 
    } 
} 

$tmpquery = "WHERE mem.id = '" . $_SESSION['idSession'] . "'";
$userDetail = new request();
$userDetail->openMembers($tmpquery);
$comptUserDetail = count($userDetail->mem_id);

if ($comptUserDetail == "0") {
    header("Location: ../users/listusers.php?msg=blankUser");
    exit;
} 


//--- header ---
$breadcrumbs[]=$strings["preferences"];
if ($notifications == "true") {
    $breadcrumbs[]=buildLink("../preferences/updateuser.php?", $strings["user_profile"], LINK_INSIDE) . "&nbsp; | &nbsp;" . $strings["change_password"] . "&nbsp; | &nbsp;" . buildLink("../preferences/updatenotifications.php?", $strings["notifications"], LINK_INSIDE);
} else {
    $breadcrumbs[]=buildLink("../preferences/updateuser.php?", $strings["user_profile"], LINK_INSIDE) . " | " . $strings["change_password"];
} 

$bodyCommand = "onLoad=\"document.change_passwordForm.opw.focus();\"";
$pageSection = 'preferences';
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "change_password";
$block1->openForm("../preferences/updatepassword.php?action=update");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["change_password"] . " : " . $userDetail->mem_login[0]);

$block1->openContent();
$block1->contentTitle($strings["change_password_intro"]);

$block1->contentRow("* " . $strings["old_password"], "<input style=\"width: 150px;\" type=\"password\" name=\"opw\" value=\"\">");
$block1->contentRow("* " . $strings["new_password"], "<input style=\"width: 150px;\" type=\"password\" name=\"npw\" value=\"\">");
$block1->contentRow("* " . $strings["confirm_password"], "<input style=\"width: 150px;\" type=\"password\" name=\"pwa\" value=\"\">");
$block1->contentRow("", "<input type=\"submit\" name=\"Save\" value=\"" . $strings["save"] . "\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
