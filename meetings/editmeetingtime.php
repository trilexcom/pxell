<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editmeetingtime.php,v 1.4 2005/05/27 21:39:26 madbear Exp $
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

// Make sure this person has the right to log hours for this meeting
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

// Meeting Detail
$tmpquery = "WHERE mee.id = '$meeting'";
$meetingDetail = new request();
$meetingDetail->openMeetings($tmpquery);

// Project Detail
$tmpquery = "WHERE pro.id = '" . $meetingDetail->mee_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

// Meeting Time Detail
$tmpquery = "WHERE mti.id = '$id'";
$meetingTimeDetail = new request();
$meetingTimeDetail->openMeetingTime($tmpquery);

// Check field values
if ($_GET['action'] == 'edit') {
    $msgLabel .= ''; // init
     
    // make sure we have the required information
    if (!empty($hr)) {
        if (!is_numeric($hr)) {
            // we need this to be numeric
            $msgLabel = '<b>' . $strings['attention'] . '</b> : ' . $strings['worked_hours']
             . ' ' . $strings['error_numerical'];
        } 
    } else {
        // we need this to be numeric
        $msgLabel = '<b>' . $strings['attention'] . '</b> : ' . $strings['worked_hours']
         . ' ' . $strings['error_required'];
    } 
    // update meeting time in database
    if (empty($msgLabel)) {
        $comm = addSlashes($comm); // resolves bug #768688
        
        $tmpquery1  = "UPDATE " . $tableCollab['meetings_time'] . " ";
        $tmpquery1 .= "SET owner='$owner', date='$ld', hours='$hr', ";
        $tmpquery1 .= "comments='$comm', modified=NOW() ";
        $tmpquery1 .= "WHERE id=$id";
        connectSql($tmpquery1);
        header("Location: ../meetings/addmeetingtime.php?id=$meeting&msg=update");
        exit;
    } 
} 

// --- header ----------------
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?project=" . $projectDetail->pro_id[0], $strings["meetings"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/viewmeeting.php?id=" . $meetingDetail->mee_id[0], $meetingDetail->mee_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["edit_meeting_time"];

require_once("../themes/" . THEME . "/header.php");

// --- content ----------------
$blockPage->bornesNumber = "1";
// get actual time for meeting
$meetingActualTime = new request();
$actualTime = $meetingActualTime->getMeetingTime($meeting);

$block1 = new block();

$block1->form = "saM";
$block1->openForm("../meetings/editmeetingtime.php?id=$id&meeting=$meeting&amp;action=edit#" . $block1->form . "Anchor");

$block1->headingForm($strings["edit_meeting_time"] . " : " . $meetingDetail->mee_name[0]);

$block1->openContent();
$block1->contentTitle($strings["info"]);
$block1->contentRow($strings["project"], $projectDetail->pro_name[0]);
$block1->contentRow($strings["meetings"], $meetingDetail->mee_name[0]);
$block1->contentRow($strings["me_agenda"], nl2br($meetingDetail->mee_agenda[0]));
$block1->contentRow($strings["actual_time"], $actualTime . " " . $strings["hours"]);
$block1->contentTitle($strings["edit_meeting_time"]);

$tmpquery = "WHERE tea.project = '" . $projectDetail->pro_id[0] . "' ORDER BY mem.name";

$projmem = new request();
$projmem->openTeams($tmpquery);
$comptProjmem = count($projmem->tea_mem_id);

echo "
<tr class='odd'>
  <td valign='top' class='leftvalue'>" . $strings['owner'] . " :</td>
  <td><select name='owner'>";
// get project team listing for owner select lists, default to logged user
for ($i = 0;$i < $comptProjmem;$i++) {
    $clientUser = '';

    if ($projmem->tea_mem_profil[$i] == '3') {
        $clientUser = ' (' . $strings['client_user'] . ')';
    } 

    if ($meetingTimeDetail->mti_owner[0] == $projmem->tea_mem_id[$i]) {
        echo "<option value='" . $projmem->tea_mem_id[$i] . "' selected>" . $projmem->tea_mem_name[$i] . "$clientUser</option>";
    } else {
        echo "<option value='" . $projmem->tea_mem_id[$i] . "'>" . $projmem->tea_mem_name[$i] . "$clientUser</option>";
    } 
} 

echo '
  </select></td>
</tr>';

if ($ld == '') {
    $ld = $date;
} 

$block1->contentRow($strings['date'], "
  <input type='text' style='width: 150px;' name='ld' id='sel1' size='20' 
  value='" . $meetingTimeDetail->mti_date[0] . "'><button type='reset' id=\"trigger_a\">...</button>
<script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

echo "
<tr class='odd'>
  <td valign='top' class='leftvalue'>" . $strings["worked_hours"] . " :</td>
  <td><input size='20' value='" . $meetingTimeDetail->mti_hours[0] . "' style='width: 150px;' name='hr' maxlength='6' type='text'></td>
</tr>
<tr class='odd'>
  <td valign='top' class='leftvalue'>" . $strings["comments"] . " :</td>
  <td><textarea rows='10' style='width: 400px; height: 150px;' name='comm' cols='47'>" . $meetingTimeDetail->mti_comments[0] . "</textarea></td>
</tr>
<tr class='odd'>
  <td valign='top' class='leftvalue'>&nbsp;</td>
  <td><input type='SUBMIT' value='" . $strings["update"] . "'><input type='button' name='cancel' value='" . $strings['cancel'] . "' onClick='history.back();'></td>
</tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
