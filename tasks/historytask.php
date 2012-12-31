<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: historytask.php,v 1.6 2004/12/15 15:49:15 madbear Exp $
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

if ($type == "1") {
    $tmpquery = "WHERE tas.id = '$item'";
    $taskDetail = new request();
    $taskDetail->openTasks($tmpquery);

    $tmpquery = "WHERE pro.id = '" . $taskDetail->tas_project[0] . "'";
    $projectDetail = new request();
    $projectDetail->openProjects($tmpquery);

    if ($projectDetail->pro_enable_phase[0] != "0") {
        $tPhase = $taskDetail->tas_parent_phase[0];
        $tmpquery = "WHERE pha.project_id = '" . $taskDetail->tas_project[0] . "' AND pha.order_num = '$tPhase'";
        $targetPhase = new request();
        $targetPhase->openPhases($tmpquery);
    } 
} 


//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);

if ($projectDetail->pro_phase_set[0] != "0") {
    $breadcrumbs[]=buildLink("../phases/listphases.php?id=" . $projectDetail->pro_id[0], $strings["phases"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../phases/viewphase.php?id=" . $targetPhase->pha_id[0], $targetPhase->pha_name[0], LINK_INSIDE);
} 

$breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/viewtask.php?id=" . $taskDetail->tas_id[0], $taskDetail->tas_name[0], LINK_INSIDE);

if($type == "1") {
    $breadcrumbs[]=$strings["updates_task"];
} 

$pageSection='projects';
require_once("../themes/" . THEME . "/header.php");

//--- content ----
$block1 = new block();

$block1->form = "tdP";
$block1->openForm("");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

if ($type == "1") {
    $block1->headingForm($strings["task"] . " : " . $taskDetail->tas_name[0]);
} 

$block1->openContent();
$block1->contentTitle($strings["details"]);

$tmpquery = "WHERE upd.type='$type' AND upd.item = '$item' ORDER BY upd.created DESC";
$listUpdates = new request();
$listUpdates->openUpdates($tmpquery);
$comptListUpdates = count($listUpdates->upd_id);

for ($i = 0;$i < $comptListUpdates;$i++) {
    if (ereg("\[status:([0-9])\]", $listUpdates->upd_comments[$i])) {
        preg_match("|\[status:([0-9])\]|i", $listUpdates->upd_comments[$i], $matches);
        $listUpdates->upd_comments[$i] = ereg_replace("\[status:([0-9])\]", "", $listUpdates->upd_comments[$i] . "<br>");
        $listUpdates->upd_comments[$i] .= $strings["status"] . " " . $status[$matches[1]];
    } 
    if (ereg("\[priority:([0-9])\]", $listUpdates->upd_comments[$i])) {
        preg_match("|\[priority:([0-9])\]|i", $listUpdates->upd_comments[$i], $matches);
        $listUpdates->upd_comments[$i] = ereg_replace("\[priority:([0-9])\]", "", $listUpdates->upd_comments[$i] . "<br>");
        $listUpdates->upd_comments[$i] .= $strings["priority"] . " " . $priority[$matches[1]];
    } 
    if (ereg("\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]", $listUpdates->upd_comments[$i])) {
        preg_match("|\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]|i", $listUpdates->upd_comments[$i], $matches);
        $listUpdates->upd_comments[$i] = ereg_replace("\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]", "", $listUpdates->upd_comments[$i] . "<br>");
        $listUpdates->upd_comments[$i] .= $strings["due_date"] . " " . $matches[1];
    } 

    $block1->contentRow($strings["posted_by"], buildLink($listUpdates->upd_mem_email_work[$i], $listUpdates->upd_mem_name[$i], LINK_MAIL));
    if ($listUpdates->upd_created[$i] > $_SESSION['lastvisiteSession']) {
        $block1->contentRow($strings["when"], "<b>" . createDate($listUpdates->upd_created[$i], $_SESSION['timezoneSession']) . "</b>");
    } else {
        $block1->contentRow($strings["when"], createDate($listUpdates->upd_created[$i], $_SESSION['timezoneSession']));
    } 
    $block1->contentRow("", nl2br($listUpdates->upd_comments[$i]));
    $block1->contentRow("", "", "true");
} 

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
