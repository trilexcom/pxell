<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteclientusers.php,v 1.4 2004/12/15 12:25:19 pixtur Exp $
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

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
$comptProjectDetail = count($projectDetail->pro_id);

if ($comptProjectDetail == "0") {
    header("Location: ../projects/listprojects.php?msg=blank");
    exit;
} 

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $pieces = explode(",", $id);

    if ($htaccessAuth == "true") {
        require_once("../includes/htpasswd.class.php");
        $Htpasswd = new Htpasswd;
        $Htpasswd->initialize("../files/" . $projectDetail->pro_id[0] . "/.htpasswd");

        $tmpquery = "WHERE mem.id IN($id)";
        $listMembers = new request();
        $listMembers->openMembers($tmpquery);
        $comptListMembers = count($listMembers->mem_id);

        for ($i = 0;$i < $comptListMembers;$i++) {
            $Htpasswd->deleteUser($listMembers->mem_login[$i]);
        } 
    } 
    // if mantis bug tracker enabled
    if ($enableMantis == "true") {
        // include mantis library
        require_once("../mantis/core_API.php");
    } 
    $compt = count($pieces);
    for ($i = 0;$i < $compt;$i++) {
        $tmpquery1 = "DELETE FROM " . $tableCollab["teams"] . " WHERE member = '$pieces[$i]'";
        connectSql("$tmpquery1");
        // if mantis bug tracker enabled
        if ($enableMantis == "true") {
            // Unassign user from this project in mantis
            $f_project_id = $project;
            $f_user_id = $pieces[$i];
            require_once("../mantis/user_proj_delete.php");
        } 
    } 
    if ($notifications == "true") {
        $organization = "";
        require_once("../teams/noti_removeprojectteam.php");
    } 
    header("Location: ../projects/viewprojectsite.php?id=$project&msg=removeClientToSite");
    exit;
} 



//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewprojectsite.php?id=" . $projectDetail->pro_id[0], $strings["project_site"], LINK_INSIDE);
$breadcrumbs[]=$strings["remove_team_client"];

require_once("../themes/" . THEME . "/header.php");

//--- content ----
$block1 = new block();

$block1->form = "crM";
$block1->openForm("../teams/deleteclientusers.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["remove_team_client"]);

$block1->openContent();
$block1->contentTitle($strings["remove_team_info"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mem.id IN($id) ORDER BY mem.name";
$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

for ($i = 0;$i < $comptListMembers;$i++) {
    $block1->contentRow("#" . $listMembers->mem_id[$i], $listMembers->mem_login[$i] . " (" . $listMembers->mem_name[$i] . ")");
} 

$block1->contentRow("", "<input type=\"SUBMIT\" value=\"" . $strings["delete"] . "\">&#160;<input type=\"BUTTON\" value=\"" . $strings["remove"] . "\" onClick=\"history.back();\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
