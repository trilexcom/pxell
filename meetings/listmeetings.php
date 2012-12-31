<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listmeetings.php,v 1.4 2004/12/14 20:59:07 madbear Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

if ($action == "publish") {
    if ($addToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='0' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "addToSite";
        $id = $project;
    } 

    if ($removeToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='1' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "removeToSite";
        $id = $project;
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '$project' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);
if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
} 
if ($teamMember == "false" && $projectsFilter == "true") {
    header("Location:../general/permissiondenied.php");
    exit;
} 

// ----- header --------------------------------
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["meetings"];

require_once("../themes/" . THEME . "/header.php");

// ----- content --------------------------------
$blockPage=new block();
$blockPage->bornesNumber = "1";

$block1 = new block();

$block1->form = "saM";
$block1->openForm("../meetings/listmeetings.php?project=$project#" . $block1->form . "Anchor");

$block1->heading($strings["meetings"]);

$block1->openPaletteIcon();
if ($teamMember == "true") {
    $block1->paletteIcon(0, "add", $strings["add"]);
    $block1->paletteIcon(1, "remove", $strings["delete"]);
    $block1->paletteIcon(2, "copy", $strings["copy"]); 
    // $block1->paletteIcon(3,"export",$strings["export"]);
    if ($sitePublish == "true") {
        $block1->paletteIcon(4, "add_projectsite", $strings["add_project_site"]);
        $block1->paletteIcon(5, "remove_projectsite", $strings["remove_project_site"]);
    } 
} 
$block1->paletteIcon(6, "info", $strings["view"]);
if ($teamMember == "true") {
    $block1->paletteIcon(7, "edit", $strings["edit"]);
    $block1->paletteIcon(8, "timelog", $strings["loghours"]);
} 
$block1->closePaletteIcon();

$block1->borne = $blockPage->returnBorne("1");
$block1->rowsLimit = "20";

$block1->sorting("meetings", $sortingUser->sor_meetings[0], 'mee.date DESC', $sortingFields = array(0 => 'mee.id', 1 => 'mee.name', 2 => 'mee.priority', 3 => 'mee.status', 4 => 'mee.date'));

$tmpquery = "WHERE mee.project = '$project' ORDER BY $block1->sortingValue";

$block1->recordsTotal = compt($initrequest["meetings"] . " " . $tmpquery);

$listMeetings = new request();
$listMeetings->openMeetings($tmpquery, $block1->borne, $block1->rowsLimit);
$comptListMeetings = count($listMeetings->mee_id);

if ($comptListMeetings != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings['id'], 1 => $strings['meeting'], 2 => $strings['priority'], 3 => $strings['status'], 4 => $strings['date']), 'true');

    for ($i = 0;$i < $comptListMeetings;$i++) {
        $idStatus = $listMeetings->mee_status[$i];
        $idPriority = $listMeetings->mee_priority[$i];

        $idPublish = $listMeetings->mee_published[$i];

        $block1->openRow($listMeetings->mee_id[$i]);
        $block1->checkboxRow($listMeetings->mee_id[$i]);

        $block1->cellRow(buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_id[$i], LINK_INSIDE));

        if ($idStatus == 1) {
            $block1->cellRow(buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_name[$i], LINK_STRIKE));
        } else {
            $block1->cellRow(buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_name[$i], LINK_INSIDE));
        } 

        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);
        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

        if ($listMeetings->mee_date[$i] <= $date && $idStatus != 1) {
            $block1->cellRow("<b>" . $listMeetings->mee_date[$i] . "</b>");
        } else {
            $block1->cellRow($listMeetings->mee_date[$i]);
        } 

        $block1->cellRow($complValue);

        $block1->closeRow();
    } 

    $block1->closeResults();
    $block1->bornesFooter("1", $blockPage->bornesNumber, "", "project=$project");

} else {
    $block1->noresults();
} 

$block1->closeFormResults();

$block1->openPaletteScript();

if ($teamMember == "true") {
    $block1->paletteScript(0, "add", "../meetings/editmeeting.php?project=$project", "true,false,false", $strings["add"]);
    $block1->paletteScript(1, "remove", "../meetings/deletemeetings.php?project=$project", "false,true,true", $strings["delete"]);
    $block1->paletteScript(2, "copy", "../meetings/editmeeting.php?project=$project&cpy=true", "false,true,false", $strings["copy"]); 
    // $block1->paletteScript(3,"export","export.php?","false,true,true",$strings["export"]);
    if ($sitePublish == "true") {
        $block1->paletteScript(4, "add_projectsite", "../meetings/listmeetings.php?addToSite=true&project=" . $projectDetail->pro_id[0] . "&action=publish", "false,true,true", $strings["add_project_site"]);
        $block1->paletteScript(5, "remove_projectsite", "../meetings/listmeetings.php?removeToSite=true&project=" . $projectDetail->pro_id[0] . "&action=publish", "false,true,true", $strings["remove_project_site"]);
    } 
} 

$block1->paletteScript(6, "info", "../meetings/viewmeeting.php?", "false,true,false", $strings["view"]);

if ($teamMember == "true") {
    $block1->paletteScript(7, "edit", "../meetings/editmeeting.php?project=$project", "false,true,true", $strings["edit"]);
    $block1->paletteScript(8, "timelog", "../meetings/addmeetingtime.php?", "false,true,false", $strings["loghours"]);
} 

$block1->closePaletteScript($comptListMeetings, $listMeetings->mee_id);

require_once("../themes/" . THEME . "/footer.php");

?>
