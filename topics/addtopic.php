<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addtopic.php,v 1.5 2004/12/15 12:25:12 pixtur Exp $
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

if ($projectDetail->pro_org_id[0] == "1") {
    $projectDetail->pro_org_name[0] = $strings["none"];
} 

if ($action == "add") {
    if ($pub == "") {
        $pub = "1";
    } 
    $ttt = convertData($ttt);
    $tpm = convertData($tpm);
    $tmpquery1 = "INSERT INTO " . $tableCollab["topics"] . "(project,owner,subject,status,last_post,posts,published) VALUES('$project','" . $_SESSION['idSession'] . "','$ttt','1','$dateheure','1','$pub')";
    connectSql("$tmpquery1");
    $tmpquery = $tableCollab["topics"];
    last_id($tmpquery);
    $num = $lastId[0];
    unset($lastId);
    autoLinks($tpm);
    $tmpquery2 = "INSERT INTO " . $tableCollab["posts"] . "(topic,member,created,message) VALUES('$num','" . $_SESSION['idSession'] . "','$dateheure','$newText')";
    connectSql("$tmpquery2");

    if ($notifications == "true") {
        require_once("../topics/noti_newtopic.php");
    } 
    header("Location: ../topics/viewtopic.php?project=$project&id=$num&msg=add");
    exit;
} 

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $projectDetail->pro_id[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
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


//--- header ---
$breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]= buildLink("../topics/listtopics.php?project=" . $projectDetail->pro_id[0], $strings["discussions"], LINK_INSIDE);
$breadcrumbs[]= $strings["add_discussion"];

$bodyCommand = "onLoad=\"document.ctTForm.ttt.focus();\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ----
$block1 = new block();

$block1->form = "ctT";
$block1->openForm("../topics/addtopic.php?project=" . $projectDetail->pro_id[0] . "&amp;action=add");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["add_discussion"]);

$block1->openContent();
$block1->contentTitle($strings["info"]);

$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0] . " (#" . $projectDetail->pro_id[0] . ")", LINK_INSIDE));
$block1->contentRow($strings["organization"], $projectDetail->pro_org_name[0]);
$block1->contentRow($strings["owner"], buildLink("../users/viewuser.php?id=" . $projectDetail->pro_mem_id[0], $projectDetail->pro_mem_name[0], LINK_INSIDE) . " (" . buildLink($projectDetail->pro_mem_email_work[0], $projectDetail->pro_mem_login[0], LINK_MAIL) . ")");

$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["topic"], "<input size=\"44\" value=\"$ttt\" style=\"width: 400px\" name=\"ttt\" maxlength=\"64\" type=\"TEXT\">");
$block1->contentRow($strings["message"], "<textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"tpm\" cols=\"47\">$tpm</textarea>");
$block1->contentRow($strings["published"], "<input size=\"32\" value=\"0\" name=\"pub\" type=\"checkbox\">");
$block1->contentRow("", "<input type=\"SUBMIT\" value=\"" . $strings["save"] . "\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
