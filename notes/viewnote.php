<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewnote.php,v 1.6 2004/12/20 23:45:03 pixtur Exp $
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

if ($action == "publish") {
    if ($addToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["notes"] . " SET published='0' WHERE id = '$id'";
        connectSql("$tmpquery1");
        $msg = "addToSite";
    } 
    if ($removeToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["notes"] . " SET published='1' WHERE id = '$id'";
        connectSql("$tmpquery1");
        $msg = "removeToSite";
    } 
} 


$tmpquery = "WHERE note.id = '$id'";
$noteDetail = new request();
$noteDetail->openNotes($tmpquery);

$tmpquery = "WHERE pro.id = '" . $noteDetail->note_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $noteDetail->note_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);
if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
} 

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../notes/listnotes.php?project=" . $projectDetail->pro_id[0], $strings["notes"], LINK_INSIDE);
$breadcrumbs[]=$noteDetail->note_subject[0];


require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();
$block1->form = "tdD";
$block1->openForm("../notes/viewnote.php#" . $block1->form . "Anchor");
$block1->headingForm($strings["note"] . " : " . $noteDetail->note_subject[0]);
if ($teamMember == "true" && $_SESSION['idSession'] == $noteDetail->note_owner[0]) {
    $block1->openPaletteIcon();
    $block1->paletteIcon(0, "remove", $strings["delete"]);
    // $block1->paletteIcon(1,"export",$strings["export"]);
    if ($sitePublish == "true") {
        $block1->paletteIcon(2, "add_projectsite", $strings["add_project_site"]);
        $block1->paletteIcon(3, "remove_projectsite", $strings["remove_project_site"]);
    }
    $block1->paletteIcon(4, "edit", $strings["edit"]);
    $block1->closePaletteIcon();
}
else {
	$block1->headingForm_close();
}
if ($projectDetail->pro_org_id[0] == "1") {
    $projectDetail->pro_org_name[0] = $strings["none"];
}

$block1->openContent();
$block1->contentTitle($strings["info"]);

$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE));

if ($noteDetail->note_topic[0] != "") {
    $block1->contentRow($strings["topic"], $topicNote[$noteDetail->note_topic[0]]);
}

$block1->contentRow($strings["subject"], $noteDetail->note_subject[0]);
$block1->contentRow($strings["description"], nl2br($noteDetail->note_description[0]));
$block1->contentRow($strings["date"], $noteDetail->note_date[0]);
$block1->contentRow($strings["owner"], buildLink($noteDetail->note_mem_email_work[0], $noteDetail->note_mem_login[0], LINK_MAIL));

$idPublish = $noteDetail->note_published[0];
if ($sitePublish == "true") {
    $block1->contentRow($strings["published"], $statusPublish[$idPublish]);
}

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

if ($teamMember == "true" && $_SESSION['idSession'] == $noteDetail->note_owner[0]) {
    $block1->openPaletteScript();
    $block1->paletteScript(0, "remove", "../notes/deletenotes.php?project=" . $noteDetail->note_project[0] . "&id=" . $noteDetail->note_id[0] . "", "true,true,false", $strings["delete"]);
    // $block1->paletteScript(1,"export","export.php?","true,true,false",$strings["export"]);
    if ($sitePublish == "true") {
        $block1->paletteScript(2, "add_projectsite", "../notes/viewnote.php?addToSite=true&id=" . $noteDetail->note_id[0] . "&action=publish", "true,true,true", $strings["add_project_site"]);
        $block1->paletteScript(3, "remove_projectsite", "../notes/viewnote.php?removeToSite=true&id=" . $noteDetail->note_id[0] . "&action=publish", "true,true,true", $strings["remove_project_site"]);
    }
    $block1->paletteScript(4, "edit", "../notes/editnote.php?project=" . $noteDetail->note_project[0] . "&id=" . $noteDetail->note_id[0] . "", "true,true,false", $strings["edit"]);
    $block1->closePaletteScript("", "");
}

require_once("../themes/" . THEME . "/footer.php");

?>