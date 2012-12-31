<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: updatetasks.php,v 1.7 2005/05/27 19:42:52 madbear Exp $
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

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE tas.id IN($id)";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

if ($action == "update") {
    $acomm = convertData($acomm);
    if ($at != $strings["no_change"]) {
        $query = "assigned_to='$at'";
        $assignUpdate = "true";
    } 
    if ($st != $strings["no_change"]) {
        if ($query != "") {
            $query .= ",status='$st'";
        } else {
            $query .= "status='$st'";
        } 
    } 
    if ($compl != "") {
        if ($query != "") {
            $query .= ",completion='$compl'";
        } else {
            $query .= "completion='$compl'";
        } 
    } 
    if ($pr != $strings["no_change"]) {
        if ($query != "") {
            $query .= ",priority='$pr'";
        } else {
            $query .= "priority='$pr'";
        } 
    } 

    if ($sd != "--") {
        if ($query != "") {
            $query .= ",start_date='$sd'";
        } else {
            $query .= "start_date='$sd'";
        } 
    } 
    if ($dd != "--") {
        if ($query != "") {
            $query .= ",due_date='$dd'";
        } else {
            $query .= "due_date='$dd'";
        } 
    } 
    if ($query != "") {
        for ($i = 0;$i < $comptListTasks;$i++) {
            $sameAssign = "false";
            if ($at != "0" && $listTasks->tas_assigned[$i] == "") {
                $tmpquery6 = "UPDATE " . $tableCollab["tasks"] . " SET assigned='$dateheure' WHERE id = '" . $listTasks->tas_id[$i] . "'";
                connectSql("$tmpquery6"); 
                // echo $tmpquery6."<br>";
            } 
            if ($listTasks->tas_assigned_to[$i] == $at) {
                $sameAssign = "true";
            } 
            $tmpquery = "UPDATE " . $tableCollab["tasks"] . " SET $query,modified='$dateheure' WHERE id = '" . $listTasks->tas_id[$i] . "'";
            connectSql("$tmpquery"); 
            // echo $tmpquery."<br>";
            // echo $listTasks->tas_status[$i]." $st<br>";
            // echo $listTasks->tas_priority[$i]." $pr<br>";
            if ($st != $strings["no_change"] && $listTasks->tas_status[$i] != $st && $assignUpdate != "true" && $listTasks->tas_assigned_to[$i] != "0") {
                if ($notifications == "true") {
                    $statustaskchange = new notification();
                    $statustaskchange->taskNotification($listTasks->tas_assigned_to[$i], $listTasks->tas_id[$i], 'statustaskchange');
                }
            }
            if ($pr != $strings["no_change"] && $listTasks->tas_priority[$i] != $pr && $assignUpdate != "true" && $listTasks->tas_assigned_to[$i] != "0") {
                if ($notifications == "true") {
                    $prioritytaskchange = new notification();
                    $prioritytaskchange->taskNotification($listTasks->tas_assigned_to[$i], $listTasks->tas_id[$i], 'prioritytaskchange');
                }
            }
            if ($dd != "--" && $listTasks->tas_due_date[$i] != $dd && $assignUpdate != "true" && $listTasks->tas_assigned_to[$i] != "0") {
                if ($notifications == "true") {
                    $duedatetaskchange = new notification();
                    $duedatetaskchange->taskNotification($listTasks->tas_assigned_to[$i], $listTasks->tas_id[$i], 'duedatetaskchange');
                }
            }

            if ($at != "0" && $sameAssign != "true" && $assignUpdate == "true") {
                $tmpquery2 = "INSERT INTO " . $tableCollab["assignments"] . "(task,owner,assigned_to,comments,assigned) VALUES('" . $listTasks->tas_id[$i] . "','" . $listTasks->tas_owner[$i] . "','$at','$acomm','$dateheure')";
                connectSql("$tmpquery2");
                // echo $tmpquery2."<br>";
                $tmpquery = "WHERE tea.project = '$project' AND tea.member = '$at'";
                $testinTeam = new request();
                $testinTeam->openTeams($tmpquery);
                $comptTestinTeam = count($testinTeam->tea_id);
                if ($comptTestinTeam == "0") {
                    $tmpquery3 = "INSERT INTO " . $tableCollab["teams"] . "(project,member,published,authorized) VALUES('$project','$at','1','0')";
                    connectSql("$tmpquery3");
                }
                if ($notifications == "true") {
                    $taskassignment = new notification();
                    $taskassignment->taskNotification($at, $listTasks->tas_id[$i], 'taskassignment');
                }
            } 
        } 
    } 
    header("Location: ../tasks/listtasks.php?project=$project&msg=update&PHPSESSID=$PHPSESSID");
    exit;
} 


//--- header ---
if ($report != "") {
    $tmpquery = "WHERE id = '$report'";
    $reportDetail = new request();
    $reportDetail->openReports($tmpquery);
    $breadcrumbs[]=buildLink("../reports/createreport.php?", $strings["reports"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../reports/resultsreport.php?id=" . $reportDetail->rep_id[0], $reportDetail->rep_name[0], LINK_INSIDE);
} 
else {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../tasks/listtasks.php?project=$project", $strings["tasks"], LINK_INSIDE);
} 
$breadcrumbs[]=$strings["edit_multiple_tasks"];

// $bodyCommand="onload=\"document.forms[0].compl.value = document.forms[0].completion.selectedIndex;\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();
$block1->form = "batT";
$block1->openForm("../tasks/updatetasks.php?action=update#" . $block1->form . "Anchor");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["edit_multiple_tasks"]);

$block1->openContent();
$block1->contentTitle($strings["details"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>$comptListTasks " . $strings["tasks_selected"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["assigned_to"] . "</td><td><select name=\"at\">
<option value=\"" . $strings["no_change"] . "\" selected>" . $strings["no_change"] . " :</option>
<option value=\"0\">" . $strings["unassigned"] . "</option>";

if ($_SESSION['idSession'] == "1") {
    echo "<option value=\"1\">" . $strings["administrator"] . "</option>";
} 

$tmpquery = "WHERE mem.id != '1' AND mem.profil != '3' ORDER BY mem.name";
$assignTo = new request();
$assignTo->openMembers($tmpquery);
$comptAssignTo = count($assignTo->mem_id);

for ($i = 0;$i < $comptAssignTo;$i++) {
    echo "<option value=\"" . $assignTo->mem_id[$i] . "\">" . $assignTo->mem_name[$i] . "</option>";
} 

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["assignment_comment"] . " :</td><td><textarea rows=\"3\" style=\"width: 400px; height: 50px;\" name=\"acomm\" cols=\"43\"></textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"st\" onchange=\"changeSt(this)\">
<option value=\"" . $strings["no_change"] . "\" selected>" . $strings["no_change"] . "</option>";

$comptSta = count($status);

for ($i = 0;$i < $comptSta;$i++) {
    echo "<option value=\"$i\">$status[$i]</option>";
} 

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["completion"] . " :</td><td><input name=\"compl\" type=\"hidden\" value=\"\"><select name=\"completion\" onchange=\"changeCompletion(this)\">
<option value=\"" . $strings["no_change"] . "\" selected>" . $strings["no_change"] . "</option>";

for ($i = 0;$i < 11;$i++) {
    $complValue = ($i > 0) ? $i . "0 %": $i . " %";
    echo "<option value=\"" . $i . "\">" . $complValue . "</option>";
} 

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["priority"] . " : </td><td><select name=\"pr\">
<option value=\"" . $strings["no_change"] . "\" selected>" . $strings["no_change"] . "</option>";

$comptPri = count($priority);

for ($i = 0;$i < $comptPri;$i++) {
    echo "<option value=\"$i\">$priority[$i]</option>";
} 

echo "</select></td></tr>";

if ($sd == "") {
    $sd = "--";
} 
if ($dd == "") {
    $dd = "--";
} 

$block1->contentRow($strings["start_date"], "<input type=\"text\" style=\"width: 150px;\" name=\"sd\" id=\"sel1\" size=\"20\" value=\"$sd\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

$block1->contentRow($strings["due_date"], "<input type=\"text\" style=\"width: 150px;\" name=\"dd\" id=\"sel3\" size=\"20\" value=\"$dd\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script>");

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["update"] . "\"></td></tr>";

echo "<input name=\"id\" type=\"HIDDEN\" value=\"$id\"><input name=\"project\" type=\"HIDDEN\" value=\"$project\">";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
<script>
function changeSt(theObj, firstRun){
	if (theObj.selectedIndex==4) {
		if (firstRun!=true) document.forms[0].completion.selectedIndex=1;
		document.forms[0].compl.value=0;
		document.forms[0].completion.disabled=false;
	} else {
		if (theObj.selectedIndex==0) {
			document.forms[0].completion.selectedIndex=0;
			document.forms[0].compl.value='';
		} else if (theObj.selectedIndex==1 || theObj.selectedIndex==2) {
			document.forms[0].completion.selectedIndex=11;
			document.forms[0].compl.value=10;
		} else {
			document.forms[0].completion.selectedIndex=1;
			document.forms[0].compl.value=0;
		}
		document.forms[0].completion.disabled=true;
	}
}

function changeCompletion(){
	document.forms[0].compl.value = document.forms[0].completion.selectedIndex-1;
}

changeSt(document.forms[0].st, true);
</script>