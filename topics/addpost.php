<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addpost.php,v 1.5 2004/12/15 12:25:12 pixtur Exp $
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

$tmpquery = "WHERE topic.id = '$id'";
$detailTopic = new request();
$detailTopic->openTopics($tmpquery);

$tmpquery = "WHERE pro.id = '" . $detailTopic->top_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

if ($action == "add") {
    $tpm = convertData($tpm);
    autoLinks($tpm);
    $detailTopic->top_posts[0] = $detailTopic->top_posts[0] + 1;
    $tmpquery1 = "INSERT INTO " . $tableCollab["posts"] . "(topic,member,created,message) VALUES('$id','" . $_SESSION['idSession'] . "','$dateheure','$newText')";
    connectSql("$tmpquery1");
    $tmpquery2 = "UPDATE " . $tableCollab["topics"] . " SET last_post='$dateheure',posts='" . $detailTopic->top_posts[0] . "' WHERE id = '$id'";
    connectSql("$tmpquery2");

    if ($notifications == "true") {
        require_once("../topics/noti_newpost.php");
    } 
    header("Location: ../topics/viewtopic.php?id=$id&msg=add");
    exit;
} 

$idStatus = $detailTopic->top_status[0];
$idPublish = $detailTopic->top_published[0];

$tmpquery = "WHERE pos.topic = '" . $detailTopic->top_id[0] . "' ORDER BY pos.created DESC";
$listPosts = new request();
$listPosts->openPosts($tmpquery);
$comptListPosts = count($listPosts->pos_id);

if ($projectDetail->pro_org_id[0] == "1") {
    $projectDetail->pro_org_name[0] = $strings["none"];
} 

//--- header ----
$breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]= buildLink("../topics/listtopics.php?project=" . $projectDetail->pro_id[0], $strings["discussions"], LINK_INSIDE);
$breadcrumbs[]=$detailTopic->top_subject[0];


$bodyCommand = "onLoad=\"document.ptTForm.tpm.focus();\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "ptT";
$block1->openForm("../topics/addpost.php?action=add&amp;id=" . $detailTopic->top_id[0] . "&amp;project=" . $detailTopic->top_project[0]);

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["post_to_discussion"] . " : " . $detailTopic->top_subject[0]);

$block1->openContent();
$block1->contentTitle($strings["info"]);

$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0] . " (#" . $projectDetail->pro_id[0] . ")", LINK_INSIDE));
$block1->contentRow($strings["organization"], $projectDetail->pro_org_name[0]);
$block1->contentRow($strings["owner"], buildLink("../users/viewuser.php?id=" . $projectDetail->pro_mem_id[0], $projectDetail->pro_mem_name[0], LINK_INSIDE) . " (" . buildLink($projectDetail->pro_mem_email_work[0], $projectDetail->pro_mem_login[0], LINK_MAIL) . ")");

if ($sitePublish == "true") {
    $block1->contentRow($strings["published"], $statusPublish[$idPublish]);
} 

$block1->contentRow($strings["retired"], $statusTopicBis[$idStatus]);
$block1->contentRow($strings["posts"], $detailTopic->top_posts[0]);
$block1->contentRow($strings["last_post"], createDate($detailTopic->top_last_post[0], $_SESSION['timezoneSession']));

$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["message"], "<textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"tpm\" cols=\"47\"></textarea>");
$block1->contentRow("", "<input type=\"SUBMIT\" value=\"" . $strings["save"] . "\">");

$block1->contentTitle($strings["posts"]);

for ($i = 0;$i < $comptListPosts;$i++) {
    $block1->contentRow($strings["posted_by"], buildLink($listPosts->pos_mem_email_work[$i], $listPosts->pos_mem_name[$i], LINK_MAIL));

    if ($listPosts->pos_created[$i] > $_SESSION['lastvisiteSession']) {
        $block1->contentRow($strings["when"], "<b>" . createDate($listPosts->pos_created[$i], $_SESSION['timezoneSession']) . "</b>");
    } else {
        $block1->contentRow($strings["when"], createDate($listPosts->pos_created[$i], $_SESSION['timezoneSession']));
    } 
    $block1->contentRow("", nl2br($listPosts->pos_message[$i]));
    $block1->contentRow("", "", "true");
} 

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
