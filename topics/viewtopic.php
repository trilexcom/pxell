<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewtopic.php,v 1.7 2004/12/20 23:45:03 pixtur Exp $
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

if ($_GET['action'] == "closeTopic") {
    $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET status='0' WHERE id = '" . $_GET['id'] . "'";
    $num = "1";
    connectSql("$tmpquery1");
    $msg = "closeTopic";
} 

if ($_GET['action'] == "addToSite") {
    $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='0' WHERE id = '" . $_GET['id'] . "'";
    connectSql("$tmpquery1");
    $msg = "addToSite";
} 

if ($_GET['action'] == "removeToSite") {
    $tmpquery1 = "UPDATE " . $tableCollab["topics"] . " SET published='1' WHERE id = '" . $_GET['id'] . "'";
    connectSql("$tmpquery1");
    $msg = "removeToSite";
} 

$tmpquery = "WHERE topic.id = '$id'";
$detailTopic = new request();
$detailTopic->openTopics($tmpquery);

$tmpquery = "WHERE pos.topic = '" . $detailTopic->top_id[0] . "' ORDER BY pos.created DESC";
$listPosts = new request();
$listPosts->openPosts($tmpquery);
$comptListPosts = count($listPosts->pos_id);

$tmpquery = "WHERE pro.id = '" . $detailTopic->top_project[0] . "'";
$detailProject = new request();
$detailProject->openProjects($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $detailTopic->top_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
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

if ($detailProject->pro_org_id[0] == "1") {
    $detailProject->pro_org_name[0] = $strings["none"];
} 

$idStatus = $detailTopic->top_status[0];
$idPublish = $detailTopic->top_published[0];



//--- header ---
$breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $detailProject->pro_id[0], $detailProject->pro_name[0], LINK_INSIDE);
$breadcrumbs[]= buildLink("../topics/listtopics.php?project=" . $detailProject->pro_id[0], $strings["discussions"], LINK_INSIDE);
$breadcrumbs[]= $detailTopic->top_subject[0];

//--- content ---
require_once("../themes/" . THEME . "/header.php");

$block1 = new block();

$block1->form = "tdP";
$block1->openForm("");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->heading($strings["discussion"] . " : " . $detailTopic->top_subject[0]);

if ($_SESSION['idSession'] == $detailTopic->top_owner[0]) {
    $block1->openPaletteIcon();
    $block1->paletteIcon(0, "remove", $strings["remove"]);
    $block1->paletteIcon(1, "lock", $strings["close"]);
    $block1->paletteIcon(2, "add_projectsite", $strings["add_project_site"]);
    $block1->paletteIcon(3, "remove_projectsite", $strings["remove_project_site"]);
    $block1->closePaletteIcon();
} 
else {
	$block1->heading_close();
}

$block1->openContent();
$block1->contentTitle($strings["info"]);

$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $detailProject->pro_id[0], $detailProject->pro_name[0] . " (#" . $detailProject->pro_id[0] . ")", LINK_INSIDE));
$block1->contentRow($strings["organization"], $detailProject->pro_org_name[0]);
$block1->contentRow($strings["owner"], buildLink("../users/viewuser.php?id=" . $detailProject->pro_mem_id[0], $detailProject->pro_mem_name[0], in) . " (" . buildLink($detailProject->pro_mem_email_work[0], $detailProject->pro_mem_login[0], LINK_MAIL) . ")");

if ($sitePublish == "true") {
    $block1->contentRow($strings["published"], $statusPublish[$idPublish]);
} 

$block1->contentRow($strings["retired"], $statusTopicBis[$idStatus]);
$block1->contentRow($strings["posts"], $detailTopic->top_posts[0]);
$block1->contentRow($strings["last_post"], createDate($detailTopic->top_last_post[0], $_SESSION['timezoneSession']));

$block1->contentTitle($strings["posts"]);

if ($detailTopic->top_status[0] == "1" && $teamMember == "true") {
    $block1->contentRow("", buildLink("../topics/addpost.php?id=" . $detailTopic->top_id[0], $strings["post_reply"], LINK_INSIDE));
} 

for ($i = 0;$i < $comptListPosts;$i++) {
    $block1->contentRow($strings["posted_by"], buildLink($listPosts->pos_mem_email_work[$i], $listPosts->pos_mem_name[$i], LINK_MAIL));

    if ($listPosts->pos_created[$i] > $_SESSION['lastvisiteSession']) {
        $block1->contentRow($strings["when"], "<b>" . createDate($listPosts->pos_created[$i], $_SESSION['timezoneSession']) . "</b>");
    } else {
        $block1->contentRow($strings["when"], createDate($listPosts->pos_created[$i], $_SESSION['timezoneSession']));
    } 
    if ($detailProject->pro_owner[0] == $_SESSION['idSession'] || $_SESSION['profilSession'] == "0" || $listPosts->pos_member[$i] == $_SESSION['idSession']) {
        $block1->contentRow(buildLink("../topics/deletepost.php?topic=" . $detailTopic->top_id[0] . "&amp;id=" . $listPosts->pos_id[$i], $strings["delete_message"], LINK_INSIDE), nl2br($listPosts->pos_message[$i]));
    } else {
        $block1->contentRow("", nl2br($listPosts->pos_message[$i]));
    } 
    $block1->contentRow("", "", "true");
} 

$block1->closeContent();
$block1->closeForm();

if ($_SESSION['idSession'] == $detailTopic->top_owner[0]) {
    $block1->openPaletteScript();
    $block1->paletteScript(0, "remove", "../topics/deletetopics.php?id=" . $detailTopic->top_id[0] . "", "true,true,false", $strings["remove"]);
    $block1->paletteScript(1, "lock", "../topics/viewtopic.php?id=" . $detailTopic->top_id[0] . "&action=closeTopic", "true,true,false", $strings["close"]);
    $block1->paletteScript(2, "add_projectsite", "../topics/viewtopic.php?id=" . $detailTopic->top_id[0] . "&action=addToSite", "true,true,false", $strings["add_project_site"]);
    $block1->paletteScript(3, "remove_projectsite", "../topics/viewtopic.php?id=" . $detailTopic->top_id[0] . "&action=removeToSite", "true,true,false", $strings["remove_project_site"]);
    $block1->closePaletteScript("", "");
} 

require_once("../themes/" . THEME . "/footer.php");

?>
