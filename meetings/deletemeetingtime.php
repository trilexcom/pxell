<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletemeetingtime.php,v 1.3 2004/12/15 12:25:11 pixtur Exp $
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

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = 'DELETE FROM ' . $tableCollab['meetings_time'] . " WHERE id IN($id)";
    connectSql("$tmpquery1");

    if ($meeting != "") {
        header("Location: ../meetings/addmeetingtime.php?id=$meeting&msg=delete");
        exit;
    } else {
        header("Location: ../general/home.php?msg=delete");
        exit;
    } 
} 
// Meeting Detail
$tmpquery = "WHERE mee.id = '$meeting'";
$meetingDetail = new request();
$meetingDetail->openMeetings($tmpquery);

// Project Detail
$tmpquery = "WHERE pro.id = '" . $meetingDetail->mee_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
// Make sure this person has thr right to delete hours for this meeting
$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $meetingDetail->mee_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
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

//  ---- header ------------------------------
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?project=" . $projectDetail->pro_id[0], $strings["meetings"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/viewmeeting.php?id=" . $meetingDetail->mee_id[0], $meetingDetail->mee_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["delete_meeting_time"];

require_once("../themes/" . THEME . "/header.php");

//  ---- content ------------------------------
$block1 = new block();

$block1->form = 'saP';
$block1->openForm("../meetings/deletemeetingtime.php?meeting=$meeting&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete_meeting_time"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mti.id IN($id) ORDER BY mti.id";
$listMeetingTime = new request();
$listMeetingTime->openMeetingTime($tmpquery);
$comptListMeetingTime = count($listMeetingTime->mti_id);

for ($i = 0;$i < $comptListMeetingTime;$i++) {
    echo "<tr class='odd'><td valign='top' class='leftvalue'>#"
     . $listMeetingTime->mti_id[$i] . "</td><td> : " . $strings['worked_hours']
     . " = " . $listMeetingTime->mti_hours[$i] . ", " . $listMeetingTime->mti_comments[$i]
     . "</td></tr>";
} 

echo "
<tr class='odd'>
  <td valign='top' class='leftvalue'>&nbsp;</td>
  <td><input type='submit' name='delete' value='" . $strings['delete'] . "'> 
    <input type='button' name='cancel' value='" . $strings['cancel'] . "' onClick='history.back();'></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
