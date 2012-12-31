<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletetasktime.php,v 1.5 2004/12/15 12:25:14 pixtur Exp $
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

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = 'DELETE FROM ' . $tableCollab['tasks_time'] . " WHERE id IN($id)";
    connectSql("$tmpquery1");

    if ($task != "") {
        header("Location: ../tasks/addtasktime.php?id=$task&msg=delete");
        exit;
    } else {
        header("Location: ../general/home.php?msg=delete");
        exit;
    } 
} 
// Task Detail
$tmpquery = "WHERE tas.id = '$task'";
$taskDetail = new request();
$taskDetail->openTasks($tmpquery);

if ($taskDetail->tas_estimated_time[0] < 1) {
    $taskDetail->tas_estimated_time[0] = 0;
} 
// Project Detail
$tmpquery = "WHERE pro.id = '" . $taskDetail->tas_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
// Make sure this person has thr right to delete hours for this task
$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $taskDetail->tas_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
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
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/viewtask.php?id=" . $taskDetail->tas_id[0], $taskDetail->tas_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["delete_task_time"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = 'saP';
$block1->openForm("../tasks/deletetasktime.php?task=$task&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete_task_time"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE tim.id IN($id) ORDER BY tim.id";
$listTaskTime = new request();
$listTaskTime->openTaskTime($tmpquery);
$comptListTaskTime = count($listTaskTime->tim_id);

for ($i = 0;$i < $comptListTaskTime;$i++) {
    echo "<tr class='odd'><td valign='top' class='leftvalue'>#"
     . $listTaskTime->tim_id[$i] . "</td><td> : " . $strings['worked_hours']
     . " = " . $listTaskTime->tim_hours[$i] . ", " . $listTaskTime->tim_comments[$i]
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
