<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listtopics.php,v 1.6 2004/12/14 23:20:39 pixtur Exp $
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
    if ($closeTopic == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET status='0' WHERE id IN($id)";
            $pieces = explode(",", $id);
            $num = count($pieces);
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET status='0' WHERE id = '$id'";
            $num = "1";
        } 
        connectSql("$tmpquery1");
        $msg = "closeTopic";
    } 

    if ($addToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='0' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "addToSite";
    } 

    if ($removeToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='1' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "removeToSite";
    } 
} 

//--- header ---
$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

if ($project != "") {
    $teamMember = "false";
    $tmpquery = "WHERE tea.project = '$project' AND tea.member = '" . $_SESSION['idSession'] . "'";
    $memberTest = new request();
    $memberTest->openTeams($tmpquery);
    $comptMemberTest = count($memberTest->tea_id);
    if ($comptMemberTest == "0") {
        $teamMember = "false";
    } 
	else {
        $teamMember = "true";
    } 

    $breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
    $breadcrumbs[]= $strings["discussions"];
} 
else {
    $breadcrumbs[]= buildLink("../general/home.php?", $strings["home"], LINK_INSIDE);
    $breadcrumbs[]= $strings["my_discussions"];
} 


require_once("../themes/" . THEME . "/header.php");


//--- content -----
$block1 = new block();

$block1->form = "saH";
$block1->openForm("../topics/listtopics.php?project=$project#" . $block1->form . "Anchor");

if ($project != "") {
    $block1->heading($strings["discussions"]);
} else {
    $block1->heading($strings["my_discussions"]);
} 

$block1->openPaletteIcon();

if ($teamMember == "true") {
    $block1->paletteIcon(0, "add", $strings["add"]);
} 
if ($_SESSION['idSession'] == $projectDetail->pro_owner[0]) {
    $block1->paletteIcon(1, "remove", $strings["delete"]);
    $block1->paletteIcon(2, "lock", $strings["close"]);
    if ($sitePublish == "true") {
        $block1->paletteIcon(3, "add_projectsite", $strings["add_project_site"]);
        $block1->paletteIcon(4, "remove_projectsite", $strings["remove_project_site"]);
    } 
} 
$block1->paletteIcon(5, "info", $strings["view"]);
$block1->closePaletteIcon();

$block1->sorting("discussions", $sortingUser->sor_discussions[0], "topic.last_post DESC", $sortingFields = array(0 => "topic.subject", 1 => "mem.login", 2 => "topic.posts", 3 => "topic.last_post", 4 => "topic.status", 5 => "topic.published"));

if ($project != "") {
    $tmpquery = "WHERE topic.project = '$project' ORDER BY $block1->sortingValue";
} else {
    $tmpquery = "WHERE topic.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block1->sortingValue";
} 
$listTopics = new request();
$listTopics->openTopics($tmpquery);
$comptListTopics = count($listTopics->top_id);

if ($comptListTopics != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings["topic"], 1 => $strings["owner"], 2 => $strings["posts"], 3 => $strings["last_post"], 4 => $strings["status"], 5 => $strings["published"]), "true");

    for ($i = 0;$i < $comptListTopics;$i++) {
        $idStatus = $listTopics->top_status[$i];
        $idPublish = $listTopics->top_published[$i];
        $block1->openRow($listTopics->top_id[$i]);
        $block1->checkboxRow($listTopics->top_id[$i]);
        $block1->cellRow(buildLink("../topics/viewtopic.php?id=" . $listTopics->top_id[$i], $listTopics->top_subject[$i], LINK_INSIDE));
        $block1->cellRow(buildLink($listTopics->top_mem_email_work[$i], $listTopics->top_mem_login[$i], LINK_MAIL));
        $block1->cellRow($listTopics->top_posts[$i]);
        if ($listTopics->top_last_post[$i] > $_SESSION['lastvisiteSession']) {
            $block1->cellRow("<b>" . createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']) . "</b>");
        } else {
            $block1->cellRow(createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']));
        } 
        $block1->cellRow($statusTopic[$idStatus]);
        if ($sitePublish == "true") {
            $block1->cellRow($statusPublish[$idPublish]);
        } 
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
if ($teamMember == "true") {
    $block1->paletteScript(0, "add", "../topics/addtopic.php?project=" . $projectDetail->pro_id[0] . "", "true,true,true", $strings["add"]);
} 
if ($_SESSION['idSession'] == $projectDetail->pro_owner[0]) {
    $block1->paletteScript(1, "remove", "../topics/deletetopics.php?project=" . $projectDetail->pro_id[0] . "", "false,true,true", $strings["delete"]);
    $block1->paletteScript(2, "lock", "../topics/listtopics.php?closeTopic=true&project=$project&action=publish", "false,true,true", $strings["close"]);
    if ($sitePublish == "true") {
        $block1->paletteScript(3, "add_projectsite", "../topics/listtopics.php?addToSite=true&project=" . $projectDetail->pro_id[0] . "&action=publish", "false,true,true", $strings["add_project_site"]);
        $block1->paletteScript(4, "remove_projectsite", "../topics/listtopics.php?removeToSite=true&project=" . $projectDetail->pro_id[0] . "&action=publish", "false,true,true", $strings["remove_project_site"]);
    } 
} 
$block1->paletteScript(5, "info", "../topics/viewtopic.php?", "false,true,false", $strings["view"]);
$block1->closePaletteScript($comptListTopics, $listTopics->top_id);

require_once("../themes/" . THEME . "/footer.php");

?>
