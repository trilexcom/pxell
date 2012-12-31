<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addclientuser.php,v 1.3 2004/12/14 15:51:18 pixtur Exp $
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

if ($action == "add") {
    if ($id != "") {
        $pieces = explode("**", $id);
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
                $Htpasswd->addUser($listMembers->mem_login[$i], $listMembers->mem_password[$i]);
            } 
        } 
        // if mantis bug tracker enabled
        if ($enableMantis == "true") {
            // include mantis library
            require_once("../mantis/core_API.php");
        } 
        $comptTeam = count($pieces);
        for($i = 0;$i < $comptTeam;$i++) {
            $tmpquery = "INSERT INTO " . $tableCollab["teams"] . "(project, member,published,authorized) VALUES ('" . $projectDetail->pro_id[0] . "','$pieces[$i]','1','0')";
            connectSql("$tmpquery");
            // if mantis bug tracker enabled
            if ($enableMantis == "true") {
                // Assign user to this project in mantis
                $f_access_level = $client_user_level; // Reporter access
                $f_project_id = $projectDetail->pro_id[0];
                $f_user_id = $pieces[$i];
                require_once("../mantis/user_proj_add.php");
            } 
        } 

        if ($notifications == "true") {
            $organization = "";
            require_once("../teams/noti_addprojectteam.php");
        } 
        header("Location: ../projects/viewprojectsite.php?id=" . $projectDetail->pro_id[0] . "&msg=addClientToSite");
        exit;
    } 
} 



//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewprojectsite.php?id=" . $projectDetail->pro_id[0], $strings["project_site"], LINK_INSIDE);
$breadcrumbs[]=$strings["grant_client"];
require_once("../themes/" . THEME . "/header.php");

// echo "$tmpquery<br>$comptMulti<br>";

//--- content ---

$block1 = new block();

$block1->form = "atpt";
$block1->openForm("../teams/addclientuser.php?project=$project#" . $block1->form . "Anchor");

$block1->heading($strings["add_team"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "info", $strings["view"]);
$block1->paletteIcon(2, "edit", $strings["edit"]);
$block1->closePaletteIcon();

$block1->sorting("team", $sortingUser->sor_users[0], "mem.name ASC", $sortingFields = array(0 => "mem.name", 1 => "mem.title", 2 => "mem.login", 3 => "mem.phone_work", 4 => "log.connected"));

$tmpquery = "WHERE tea.project = '$project' AND mem.profil = '3'";
$concatMembers = new request();
$concatMembers->openTeams($tmpquery);
$comptConcatMembers = count($concatMembers->tea_id);
if ($comptConcatMembers != "0") {
    for ($i = 0;$i < $comptConcatMembers;$i++) {
        $membersTeam .= $concatMembers->tea_mem_id[$i];
        if ($i < $comptConcatMembers-1) {
            $membersTeam .= ",";
        } 
    } 
    $queryBonus = "AND mem.id NOT IN($membersTeam)";
} 

$tmpquery = "WHERE mem.organization = '" . $projectDetail->pro_organization[0] . "' $queryBonus AND mem.profil = '3' ORDER BY $block1->sortingValue";
$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

if ($comptListMembers != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings["full_name"], 1 => $strings["title"], 2 => $strings["user_name"], 3 => $strings["work_phone"], 4 => $strings["connected"]), "false");

    for ($i = 0;$i < $comptListMembers;$i++) {
        if ($listMembers->mem_phone_work[$i] == "") {
            $listMembers->mem_phone_work[$i] = $strings["none"];
        } 
        $block1->openRow($listMembers->mem_id[$i]);
        $block1->checkboxRow($listMembers->mem_id[$i]);
        $block1->cellRow(buildLink("../users/viewuser.php?id=" . $listMembers->mem_id[$i], $listMembers->mem_name[$i], LINK_INSIDE));
        $block1->cellRow($listMembers->mem_title[$i]);
        $block1->cellRow(buildLink($listMembers->mem_email_work[$i], $listMembers->mem_login[$i], LINK_MAIL));
        $block1->cellRow($listMembers->mem_phone_work[$i]);
        if ($listMembers->mem_profil[$i] == "3") {
            $z = "(Client on project site)";
        } else {
            $z = "";
        } 
        if ($listMembers->mem_log_connected[$i] > $dateunix-5 * 60) {
            $block1->cellRow($strings["yes"] . " " . $z);
        } else {
            $block1->cellRow($strings["no"]);
        } 
        $block1->closeRow();
    } 

    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../teams/addclientuser.php?project=$project&action=add", "false,true,true", $strings["add"]);
$block1->paletteScript(1, "info", "../users/viewuser.php?", "false,true,false", $strings["view"]);
$block1->paletteScript(2, "edit", "../users/updateclientuser.php?organization=" . $projectDetail->pro_organization[0] . "", "false,true,false", $strings["edit"]);
$block1->closePaletteScript($comptListMembers, $listMembers->mem_id);

require_once("../themes/" . THEME . "/footer.php");

?>
