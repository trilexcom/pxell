<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewrequest.php,v 1.6 2004/12/20 23:45:00 pixtur Exp $
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

if ($enableHelpSupport != "true") {
    header("Location: ../general/permissiondenied.php");
    exit;
} 

if ($supportType == "admin") {
    if ($_SESSION['profilSession'] != "0") {
        header("Location: ../general/permissiondenied.php");
        exit;
    } 
} 

$tmpquery = "WHERE sr.id = '$id'";
$requestDetail = new request();
$requestDetail->openSupportRequests($tmpquery);

$tmpquery = "WHERE sp.request_id = '$id' ORDER BY sp.date DESC";
$listPosts = new request();
$listPosts->openSupportPosts($tmpquery);
$comptListPosts = count($listPosts->sp_id);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $requestDetail->sr_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);
if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
} 


//--- header ---
$pageSection='projects';
if ($supportType == "team") {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $requestDetail->sr_project[0], $requestDetail->sr_pro_name[0], LINK_INSIDE);
} 
else if ($supportType == "admin") {
    $breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../administration/support.php?", $strings["support_management"], LINK_INSIDE);
} 
$breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $requestDetail->sr_project[0], $strings["support_requests"], LINK_INSIDE);
$breadcrumbs[]=$requestDetail->sr_subject[0];

require_once("../themes/" . THEME . "/header.php");


//--- content ---
$block1 = new block();

$block1->form = "sdt";
$block1->openForm("");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["support_request"] . " : " . $requestDetail->sr_subject[0]);
if ($teamMember == "true" || $_SESSION['profilSession'] == "0") {
    $block1->openPaletteIcon();
    $block1->paletteIcon(0, "edit", $strings["edit_status"]);
    $block1->paletteIcon(1, "remove", $strings["delete"]);
    $block1->closePaletteIcon();
} 
else {
	$block1->headingForm_close();
}
$block1->openContent();
$block1->contentTitle($strings["info"]);

$comptSupStatus = count($requestStatus);
for ($i = 0;$i < $comptSupStatus;$i++) {
    if ($requestDetail->sr_status[0] == $i) {
        $status = $requestStatus[$i];
    } 
} 
$comptPri = count($priority);
for ($i = 0;$i < $comptPri;$i++) {
    if ($requestDetail->sr_priority[0] == $i) {
        $requestPriority = $priority[$i];
    } 
} 

$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $requestDetail->sr_project[0], $requestDetail->sr_pro_name[0], LINK_INSIDE));
$block1->contentRow($strings["subject"], $requestDetail->sr_subject[0]);
$block1->contentRow($strings["priority"], $requestPriority);
$block1->contentRow($strings["status"], $status);
$block1->contentRow($strings["date"], $requestDetail->sr_date_open[0]);
$block1->contentRow($strings["user"], buildLink($requestDetail->sr_mem_email_work[0], $requestDetail->sr_mem_name[0], LINK_MAIL));
$block1->contentRow($strings["message"], nl2br($requestDetail->sr_message[0]));

$block1->contentTitle($strings["responses"]);

if ($teamMember == "true" || $_SESSION['profilSession'] != "0") {
    $block1->contentRow("", buildLink("../support/addpost.php?id=" . $requestDetail->sr_id[0], $strings["add_support_response"], LINK_INSIDE));
} 

for ($i = 0;$i < $comptListPosts;$i++) {
    $block1->contentRow($strings["posted_by"], buildLink($listPosts->sp_mem_email_work[$i], $listPosts->sp_mem_name[$i], LINK_MAIL));
    $block1->contentRow($strings["date"], createDate($listPosts->sp_date[$i], $_SESSION['timezoneSession']));

    if ($teamMember == "true" || $_SESSION['profilSession'] == "0") {
        $block1->contentRow(buildLink("../support/deleterequests.php?action=deleteP&amp;id=" . $listPosts->sp_id[$i], $strings["delete_message"], LINK_INSIDE), nl2br($listPosts->sp_message[$i]));
    } else {
        $block1->contentRow("", nl2br($listPosts->sp_message[$i]));
    } 
    $block1->contentRow("", "", "true");
} 

if ($status == $requestStatus[0]) {
    $status = "new";
} elseif ($status == $requestStatus[1]) {
    $status = "open";
} elseif ($status == $requestStatus[2]) {
    $status = "complete";
} 

$block1->closeContent();
$block1->openPaletteScript();
$block1->paletteScript(0, "edit", "../support/addpost.php?action=status&id=" . $requestDetail->sr_id[0] . "", "true,true,true", $strings["edit_status"]);
$block1->paletteScript(1, "remove", "../support/deleterequests.php?action=deleteR&sendto=$status&id=" . $requestDetail->sr_id[0] . "", "true,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListRequests, $listRequests->sr_id);
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>