<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listusers.php,v 1.3 2004/12/14 15:51:18 pixtur Exp $
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

$tmpquery = "WHERE pro.id = '$id'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
$comptProjectDetail = count($projectDetail->pro_id);

if ($comptProjectDetail == "0") {
    header("Location: ../projects/listprojects.php?msg=blank");
    exit;
} 

//--- header ---
$breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]= $strings["team_members"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "saM";
$block1->openForm("../teams/listusers.php?id=$id#" . $block1->form . "Anchor");

$block1->heading($strings["team_members"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$block1->sorting("team", $sortingUser->sor_team[0], "mem.name ASC", $sortingFields = array(0 => "mem.name", 1 => "mem.title", 2 => "mem.login", 3 => "mem.phone_work", 4 => "log.connected", 5 => "tea.published"));

$tmpquery = "WHERE tea.project = '$id' AND mem.profil != '3' ORDER BY $block1->sortingValue";
$listTeam = new request();
$listTeam->openTeams($tmpquery);
$comptListTeam = count($listTeam->tea_id);

$block1->openResults();

$block1->labels($labels = array(0 => $strings["full_name"], 1 => $strings["title"], 2 => $strings["user_name"], 3 => $strings["work_phone"], 4 => $strings["connected"], 5 => $strings["published"]), "true");

for ($i = 0;$i < $comptListTeam;$i++) {
    if ($listTeam->tea_mem_phone_work[$i] == "") {
        $listTeam->tea_mem_phone_work[$i] = $strings["none"];
    } 
    $idPublish = $listTeam->tea_published[$i];
    $block1->openRow($listTeam->tea_mem_id[$i]);
    $block1->checkboxRow($listTeam->tea_mem_id[$i]);
    $block1->cellRow(buildLink("../users/viewuser.php?id=" . $listTeam->tea_mem_id[$i], $listTeam->tea_mem_name[$i], LINK_INSIDE));
    $block1->cellRow($listTeam->tea_mem_title[$i]);
    $block1->cellRow(buildLink($listTeam->tea_mem_email_work[$i], $listTeam->tea_mem_login[$i], LINK_MAIL));
    $block1->cellRow($listTeam->tea_mem_phone_work[$i]);

    if ($listTeam->tea_log_connected[$i] > $dateunix-5 * 60) {
        $block1->cellRow($strings["yes"] . " " . $z);
    } else {
        $block1->cellRow($strings["no"]);
    } 
    if ($sitePublish == "true") {
        $block1->cellRow($statusPublish[$idPublish]);
    } 
    $block1->closeRow();
} 
$block1->closeResults();

$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../teams/adduser.php?project=" . $projectDetail->pro_id[0] . "", "true,true,true", $strings["add"]);
$block1->paletteScript(1, "remove", "../teams/deleteusers.php?project=" . $projectDetail->pro_id[0] . "", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListTeam, $listTeam->tea_mem_id);

require_once("../themes/" . THEME . "/footer.php");

?>
