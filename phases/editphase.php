<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editphase.php,v 1.5 2005/05/17 05:33:54 vjack Exp $
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

$tmpquery = "WHERE pha.id = '$id'";
$phaseDetail = new request();
$phaseDetail->openPhases($tmpquery);
$project = $phaseDetail->pha_project_id[0];

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

if ($action == "update") {
    $c = convertData($c);

    if ($st == 0) {
        $ed = "--";
    } 

    if ($st == 1) {
        $ed = "--";
    } 

    if ($st == 2 && $ed == "--") {
        $ed = date('Y-m-d');
    } 

    $tmpquery = "UPDATE " . $tableCollab["phases"] . " SET status='$st', date_start='$sd', date_end='$ed', comments='$c' WHERE id = '$id'";
    connectSql("$tmpquery");

    if ($st != 1) {
        $tmpquery = "WHERE tas.parent_phase = '$id' AND tas.status = '3'";
        $changeTasks = new request();
        $changeTasks->openTasks($tmpquery);
        $comptchangeTasks = count($changeTasks->tas_id);
        for ($i = 0;$i < $comptchangeTasks;$i++) {
            $taskID = $changeTasks->tas_id[$i];
            $tmpquery = "UPDATE " . $tableCollab["tasks"] . " SET status='4' WHERE id = '$taskID'";
            connectSql("$tmpquery");
        } 
    } 
    header("Location: ../phases/viewphase.php?id=$id");
    exit;
} 

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$phaseDetail->pha_name[0];

require_once("../themes/" . THEME . "/header.php");

//--- content ---------
// set value in form
$sd = $phaseDetail->pha_date_start[0];

$ed = $phaseDetail->pha_date_end[0];
$c = $phaseDetail->pha_comments[0];

$block1 = new block();
$block1->form = "pdD";
$block1->openForm('../phases/editphase.php?id=' . $id . '&amp;action=update#' . $block1->form . 'Anchor');
$block1->headingForm($strings['edit_phase'] . ' : ' . $phaseDetail->pha_name[0]);
$block1->openContent();
$block1->contentTitle($strings["details"]);

echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["name"] . " :</td><td>" . $phaseDetail->pha_name[0] . "</td></tr>";
echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["phase_id"] . " :</td><td>" . $phaseDetail->pha_id[0] . "</td></tr>";

echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"st\">";

$comptSta = count($phaseStatus);

for ($i = 0;$i < $comptSta;$i++) {
    if ($phaseDetail->pha_status[0] == $i) {
        echo "<option value=\"$i\" selected>$phaseStatus[$i]</option>";
    } else {
        echo "<option value=\"$i\">$phaseStatus[$i]</option>";
    }
}

echo "</select></td></tr>";

if ($sd == "") {
    $sd = $date;
}
if ($ed == "") {
    $ed = "--";
}

$block1->contentRow($strings["date_start"], "<input type=\"text\" style=\"width: 150px;\" name=\"sd\" id=\"sel1\" size=\"20\" value=\"$sd\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

$block1->contentRow($strings["date_end"], "<input type=\"text\" style=\"width: 150px;\" name=\"ed\" id=\"sel3\" size=\"20\" value=\"$ed\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script>");

echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["comments"] . " :</td><td><textarea rows=\"3\" style=\"width: 400px; height: 100px;\" name=\"c\" cols=\"43\">$c</textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>";
$block1->closeContent();
$block1->closeToggle();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
