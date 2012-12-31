<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addclientuser.php,v 1.5 2005/01/20 16:41:58 madbear Exp $
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

// these user levels can't perform this action
if ( ($_SESSION['profilSession'] == 4) || ($_SESSION['profilSession'] == 3) || 
     ($_SESSION['profilSession'] == 2) ) {
    header("Location: ../general/home.php?msg=permissiondenied");
    exit;
}

$tmpquery = "WHERE org.id = '$organization'";
$clientDetail = new request();
$clientDetail->openOrganizations($tmpquery);
$comptClientDetail = count($clientDetail->org_id);

// case add client user
// test if login already exists
if ($action == "add") {
    if (!ereg("^[A-Za-z0-9]+$", $un)) {
        $error = $strings["alpha_only"];
    } else {
        $tmpquery = "WHERE mem.login = '$un'";
        $existsUser = new request();
        $existsUser->openMembers($tmpquery);
        $comptExistsUser = count($existsUser->mem_id);
        if ($comptExistsUser != "0") {
            $error = $strings["user_already_exists"];
        } else {
            // test if 2 passwords match
            if ($pw != $pwa || $pw == "") {
                $error = $strings["new_password_error"];
            } else {
                // replace quotes by html code in name and address
                $fn = convertData($fn);
                $tit = convertData($tit);
                $c = convertData($c);
                $pw = get_password($pw);
                $tmpquery1 = "INSERT INTO " . $tableCollab["members"] . "(organization,login,name,title,email_work,phone_work,phone_home,mobile,fax,comments,password,profil,created,timezone) VALUES('$clod','$un','$fn','$tit','$em','$wp','$hp','$mp','$fax','$c','$pw','3','$dateheure','0')";
                connectSql("$tmpquery1");
                $tmpquery = $tableCollab["members"];
                last_id($tmpquery);
                $num = $lastId[0];
                unset($lastId);
                $tmpquery3 = "INSERT INTO " . $tableCollab["notifications"] . "(member,taskAssignment,removeProjectTeam,addProjectTeam,newTopic,newPost,statusTaskChange,priorityTaskChange,duedateTaskChange,clientAddTask) VALUES ('$num','0','0','0','0','0','0','0','0','0')";
                connectSql("$tmpquery3");
                // if mantis bug tracker enabled
                if ($enableMantis == "true") {
                    // Call mantis function for new user creation!!!
                    $f_access_level = $client_user_level; // Reporter
                    require_once ("../mantis/create_new_user.php");
                } 
                header("Location: ../clients/viewclient.php?id=$clod&msg=add");
                exit;
            } 
        } 
    } 
} 



//--- header ---
$breadcrumbs[]= buildLink("../clients/listclients.php?", $strings["clients"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../clients/viewclient.php?id=" . $clientDetail->org_id[0], $clientDetail->org_name[0], LINK_INSIDE);
$breadcrumbs[]= $strings["add_client_user"];

$bodyCommand = "onLoad=\"document.client_user_addForm.un.focus();\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "client_user_add";
$block1->openForm("../users/addclientuser.php?organization=$organization&action=add");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["add_client_user"]);

$block1->openContent();
$block1->contentTitle($strings["enter_user_details"]);

$block1->contentRow($strings["user_name"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"16\" type=\"text\" name=\"un\" value=\"$un\">");
$block1->contentRow($strings["full_name"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"64\" type=\"text\" name=\"fn\" value=\"$fn\">");
$block1->contentRow($strings["title"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"64\" type=\"text\" name=\"tit\" value=\"$tit\">");

$selectOrganization = "<select name=\"clod\">";

$tmpquery = "WHERE org.id != '1' ORDER BY org.name";
$listOrganizations = new request();
$listOrganizations->openOrganizations($tmpquery);
$comptListOrganizations = count($listOrganizations->org_id);

for ($i = 0;$i < $comptListOrganizations;$i++) {
    if ($organization == $listOrganizations->org_id[$i]) {
        $selectOrganization .= "<option value=\"" . $listOrganizations->org_id[$i] . "\" selected>" . $listOrganizations->org_name[$i] . "</option>";
    } else {
        $selectOrganization .= "<option value=\"" . $listOrganizations->org_id[$i] . "\">" . $listOrganizations->org_name[$i] . "</option>";
    } 
} 

$selectOrganization .= "</select>";
$block1->contentRow($strings["organization"], $selectOrganization);

$block1->contentRow($strings["email"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"128\" type=\"text\" name=\"em\" value=\"$em\">");
$block1->contentRow($strings["work_phone"], "<input size=\"14\" style=\"width: 150px;\" maxlength=\"32\" type=\"text\" name=\"wp\" value=\"$wp\">");
$block1->contentRow($strings["home_phone"], "<input size=\"14\" style=\"width: 150px;\" maxlength=\"32\" type=\"text\" name=\"hp\" value=\"$hp\">");
$block1->contentRow($strings["mobile_phone"], "<input size=\"14\" style=\"width: 150px;\" maxlength=\"32\" type=\"text\" name=\"mp\" value=\"$mp\">");
$block1->contentRow($strings["fax"], "<input size=\"14\" style=\"width: 150px;\" maxlength=\"32\" type=\"text\" name=\"fax\" value=\"$fax\">");
$block1->contentRow($strings["comments"], "<textarea style=\"width: 400px; height: 50px;\" name=\"c\" cols=\"35\" rows=\"2\">$c</textarea>");

$block1->contentTitle($strings["enter_password"]);
$block1->contentRow($strings["password"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"16\" type=\"password\" name=\"pw\" value=\"\">");
$block1->contentRow($strings["confirm_password"], "<input size=\"24\" style=\"width: 250px;\" maxlength=\"16\" type=\"password\" name=\"pwa\" value=\"\">");
$block1->contentRow("", "<input type=\"submit\" name=\"Save\" value=\"" . $strings["save"] . "\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
