<?php // $Revision: 1.10 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addtasktime.php,v 1.10 2005/05/27 21:39:27 madbear Exp $
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

if ($task != "") {
    $cheatCode = "true";
} 

if ($task != "" && $cheatCode == "true") {
    $id = $task;
} 

// Task Detail
$tmpquery = "WHERE tas.id = '$id'";
$taskDetail = new request();
$taskDetail->openTasks($tmpquery);

if ($taskDetail->tas_estimated_time[0] < 1) {
    $taskDetail->tas_estimated_time[0] = 0;
} 

// Project Detail
$tmpquery = "WHERE pro.id = '" . $taskDetail->tas_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

// Make sure this person has thr right to log hours for this task
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

if (($teamMember == "false" && $projectsFilter == "true") || $taskDetail->tas_milestone[0] == "0") {
    header("Location:../general/permissiondenied.php");
    exit;
}



// Check field values
if ($_GET['action'] == 'add') {
    $msgLabel .= ''; // init
     
    // make sure we have the required information
    if (!empty($hr)) {
        if (!is_numeric($hr)) {
            // we need this to be numeric
            $msgLabel = '<b>' . $strings['attention'] . '</b> : ' . $strings['worked_hours'] . ' ' . $strings['error_numerical'];
        } 
    } else {
        // we need this to be numeric
        $msgLabel = '<b>' . $strings['attention'] . '</b> : ' . $strings['worked_hours'] . ' ' . $strings['error_required'];
    } 

    // insert task time in database
    if (empty($msgLabel)) {
        $comm = addSlashes($comm); // resolves bug #768688
        $tmpquery1 = 'INSERT INTO ' . $tableCollab['tasks_time'] . " (project,task,owner,date,hours,comments,created,modified) VALUES ('" . $projectDetail->pro_id[0] . "', '$id','$owner','$ld','$hr','$comm',NOW(),NOW())";
        connectSql($tmpquery1);
        $ld = null;
        $hr = null;
        $comm = null; 
        // successful insert
        $msgLabel = '<b>' . $strings['success'] . '</b> : ' . $strings['hours_updated'];
    }
	$msg= $msgLabel;
}

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/viewtask.php?id=" . $taskDetail->tas_id[0], $taskDetail->tas_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["add_task_time"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---
$tmpquery1 = "SELECT sum(hours) FROM " . $tableCollab['tasks_time'];


$blockPage= new block();
$blockPage->bornesNumber = "1";

{
	// get actual time for task
	$taskActualTime = new request();
	$actualTime = $taskActualTime->getTaskTime($id);

	$block1 = new block();

	$block1->form = "saT";
	$block1->openForm("../tasks/addtasktime.php?id=$id&amp;project=" . $projectDetail->pro_name[0] . "&amp;action=add#" . $block1->form . "Anchor");

	$block1->heading($strings["add_task_time"] . " : " . $taskDetail->tas_name[0]);
	$block1->heading_close();

	$block1->openContent();
	$block1->contentTitle($strings["info"]);
	$block1->contentRow($strings["project"], $projectDetail->pro_name[0]);
	$block1->contentRow($strings["tasks"], $taskDetail->tas_name[0]);
	$block1->contentRow($strings["description"], nl2br($taskDetail->tas_description[0]));
	$block1->contentRow($strings["estimated_time"], $taskDetail->tas_estimated_time[0] . " " . $strings["hours"]);
	$block1->contentRow($strings["actual_time"], $actualTime . " " . $strings["hours"]);
	$block1->contentTitle($strings["add_task_time"]);

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
	    // if ($taskDetail->tas_assigned_to[0] == $projmem->tea_mem_id[$i])
	    if ($_SESSION['nameSession'] == $projmem->tea_mem_name[$i]) {
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

	$block1->contentRow($strings['date'], "<input type=\"text\" style=\"width: 150px;\" name=\"ld\" id=\"sel1\"
	size=\"20\" value=\"$ld\"><button type=\"reset\" id=\"trigger_a\">...</button>
	<script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

	echo "
	<tr class='odd'>
	  <td valign='top' class='leftvalue'>" . $strings["worked_hours"] . " :</td>
	  <td><input size='20' value='$hr' style='width: 150px;' name='hr' maxlength='6' type='text'></td>
	</tr>
	<tr class='odd'>
	  <td valign='top' class='leftvalue'>" . $strings["comments"] . " :</td>
	  <td><textarea rows='10' style='width: 400px; height: 150px;' name='comm' cols='47'>$comm</textarea></td>
	</tr>
	<tr class='odd'>
	  <td valign='top' class='leftvalue'>&nbsp;</td>
	  <td><input type='SUBMIT' value='" . $strings["save"] . "'></td>
	</tr>";

	$block1->closeContent();
	$block1->block_close();
	$block1->closeForm();
}

// This will display time log detail for the current task
{
	$block2 = new block();

	$block2->form = "ahT";
	$block2->openForm("../tasks/addtasktime.php?id=$id#" . $block2->form . "Anchor");

	$block2->heading($strings["task_time"] . ' : ' . $strings["details"]);

	$block2->openPaletteIcon();
	$block2->paletteIcon(0, "remove", $strings["delete"]);
	$block2->paletteIcon(1, "edit", $strings["edit"]);
	$block2->closePaletteIcon();

	$block2->borne = $blockPage->returnBorne("1");
	$block2->rowsLimit = "20";

	$block2->sorting('tasks_time', $sortingUser->sor_tasks_time[0], 'tim.date ASC', $sortingFields = array(0 => 'mem.name', 1 => 'tim.date', 2 => 'tim.hours', 3 => 'tim.created', 4 => 'tim.modified', 5 => 'tim.comments'));

	$tmpquery = "WHERE tim.task = '$id' ORDER BY $block2->sortingValue";

	$block2->recordsTotal = compt($initrequest["tasks_time"] . " " . $tmpquery);

	$listTaskTimes = new request();

	$listTaskTimes->openTaskTime($tmpquery, $block2->borne, $block2->rowsLimit);
	$comptListTaskTimes = count($listTaskTimes->tim_id);

	if ($comptListTaskTimes != "0") {
	    $block2->openResults();

	    $block2->labels($labels = array(0 => $strings["owner"], 1 => $strings["date"], 2 => ucfirst($strings["hours"]), 3 => $strings["created"], 4 => $strings["modified"], 5 => $strings['comment']), "true");
	    // display logged hours for project
	    for ($i = 0;$i < $comptListTaskTimes;$i++) {
	        // only PM, PMA, and OWNERS can modify/delete
	        if (($_SESSION['profilSession'] == 1) or ($_SESSION['profilSession'] == 5) or
	                ($_SESSION['idSession'] == $listTaskTimes->tim_owner[$i])) {
	            $block2->openRow($listTaskTimes->tim_id[$i]);
	            $block2->checkboxRow($listTaskTimes->tim_id[$i], 'true');
	            $block2->cellRow($listTaskTimes->tim_mem_name[$i]);
	            $block2->cellRow($listTaskTimes->tim_date[$i]);
	            $block2->cellRow($listTaskTimes->tim_hours[$i]);
	            $block2->cellRow($listTaskTimes->tim_created[$i]);
	            $block2->cellRow($listTaskTimes->tim_modified[$i]);
	            // truncate large comments to keep the display clean
	            $comments = $listTaskTimes->tim_comments[$i];
	            $lenComm = 40;
	            if (strLen($comments) > $lenComm) {
	                $comments = substr($listTaskTimes->tim_comments[$i], 0, $lenComm) . ' ...';
	            }

	            $block2->cellRow($comments);
	            $block2->closeRow();
	        }
	    }

	    $block2->closeResults();
	    $block2->bornesFooter("1", $blockPage->bornesNumber, "", "id=$id");
	} else {
	    $block2->noresults();
	}

	$block2->closeFormResults();
	$block2->block_close();
	$block2->closeForm();

	$block2->openPaletteScript();
	$block2->paletteScript(0, "remove", "../tasks/deletetasktime.php?task=$id", "false,true,true", $strings["delete"]);
	$block2->paletteScript(1, "edit", "../tasks/edittasktime.php?task=$id", "false,true,false", $strings["edit"]);
	$block2->closePaletteScript($comptListTaskTimes, $listTaskTimes->tim_id);
}

require_once("../themes/" . THEME . "/footer.php");

?>
