<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: index.php,v 1.4 2004/12/15 12:25:19 pixtur Exp $
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

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
$comptProjectDetail = count($projectDetail->pro_id);
// test exists selected project, redirect to list if not
if ($comptProjectDetail == "0") {
    header("Location: ../projects/listprojects.php?msg=blank");
    exit;
} 

if ($action == "delete") {
    $id = str_replace("**", ",", $id);

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

    $multi = strstr($id, ",");
    if ($multi != "") {
        $pieces = explode(",", $id);
        $compt = count($pieces);
        for ($i = 0;$i < $compt;$i++) {
            if ($projectDetail->pro_owner[0] != $pieces[$i]) {
                $tmpquery1 = "DELETE FROM " . $tableCollab["teams"] . " WHERE member = '$pieces[$i]' AND project = '$project'";
                connectSql("$tmpquery1"); 
                // if mantis bug tracker enabled
                if ($enableMantis == "true") {
                    // Unassign multiple user from this project in mantis
                    $f_project_id = $project;
                    $f_user_id = $pieces[$i];
                    require_once("../mantis/user_proj_delete.php");
                } 
                // if CVS repository enabled
                if ($enable_cvs == "true") {
                    $user_query = "WHERE mem.id = '$pieces[$i]'";
                    $cvsMember = new request();
                    $cvsMember->openMembers($user_query);
                    cvs_delete_user($cvsMember->mem_login[$i], $project);
                } 
            } 
            if ($projectDetail->pro_owner[0] == $pieces[$i]) {
                $foundOwner = "true";
            } 
        } 
        if ($foundOwner == "true") {
            $msg = "deleteTeamOwnerMix";
        } else {
            $msg = "delete";
        } 
    } else {
        $tmpquery1 = "DELETE FROM " . $tableCollab["teams"] . " WHERE member = '$id' AND project = '$project'";
        if ($projectDetail->pro_owner[0] == $id) {
            $msg = "deleteTeamOwner";
        } else {
            connectSql("$tmpquery1");
            $msg = "delete"; 
            // if mantis bug tracker enabled
            if ($enableMantis == "true") {
                // Unassign single user from this project in mantis
                $f_project_id = $project;
                $f_user_id = $id;
                require_once("../mantis/user_proj_delete.php");
            } 
            // if CVS repository enabled
            if ($enable_cvs == "true") {
                $user_query = "WHERE mem.id = '$id'";
                $cvsMember = new request();
                $cvsMember->openMembers($user_query);
                cvs_delete_user($cvsMember->mem_login[0], $project);
            } 
        } 
    } 
    // $tmpquery3 = "UPDATE ".$tableCollab["tasks"]." SET assigned_to='0' WHERE assigned_to IN($id) AND assigned_to != '$projectDetail->pro_owner[0]'";
    // connectSql("$tmpquery3");
    if ($notifications == "true") {
        $organization = "1";
        require_once("../teams/noti_removeprojectteam.php");
    } 
    header("Location: ../projects/viewproject.php?id=$project&msg=$msg");
    exit;
} 


//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["remove_team"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "crM";
$block1->openForm("../teams/deleteusers.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["remove_team"]);

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

$block1->contentRow("", "<input type=\"SUBMIT\" value=\"" . $strings["remove"] . "\">&#160;<input type=\"BUTTON\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();


require_once("../themes/" . THEME . "/footer.php");

?>
