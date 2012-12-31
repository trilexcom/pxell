<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addteamtask.php,v 1.4 2005/01/04 06:40:43 luiswang Exp $
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
// case add task
if ($id == "") {
    // case add task
    if ($action == "add") {
        // concat values from date selector and replace quotes by html code in name
        $tn = convertData($tn);
        $d = convertData($d);
        $c = convertData($c);

        $tmpquery1 = "INSERT INTO " . $tableCollab["tasks"] . "(project,name,description,owner,assigned_to,status,priority,start_date,due_date,estimated_time,actual_time,comments,created,published,completion,milestone) VALUES('" . $_SESSION['projectSession'] . "','$tn','$d','" . $_SESSION['idSession'] . "','0','2','$pr','$sd','$dd','$etm','$atm','$c','$dateheure','$pub','0','$miles')";
        connectSql("$tmpquery1");
        $tmpquery = $tableCollab["tasks"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);

        $tmpquery2 = "INSERT INTO " . $tableCollab["assignments"] . "(task,owner,assigned_to,assigned) VALUES('$num','" . $_SESSION['idSession'] . "','$at','$dateheure')";
        connectSql("$tmpquery2");
        // send task assignment mail if notifications = true
        if ($notifications == "true") {
            require_once("../tasks/noti_clientaddtask.php");
        } 
        // create task sub-folder if filemanagement = true
        if ($fileManagement == "true") {
            createDir("../files/" . $_SESSION['projectSession'] . "/$num");
        } 
        header('Location: showallteamtasks.php');
        exit;
    } 
} 

$bodyCommand = "onload=\"document.etDForm.tn.focus();\"";

$bouton[2] = "over";
$titlePage = $strings["add_task"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/addteamtask.php?project=" . $_SESSION['projectSession'] . "&amp;action=add#etDAnchor\" name=\"etDForm\" enctype=\"application/x-www-form-urlencoded\">";

echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\">
<tr><th colspan=\"2\">" . $strings["add_task"] . "</th></tr>
<tr><th>*&nbsp;" . $strings["name"] . " :</th><td><input size=\"44\" value=\"$tn\" style=\"width: 400px\" name=\"tn\" maxlength=\"100\" type=\"TEXT\"></td></tr>
<tr><th>" . $strings["description"] . " :</th><td><textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"d\" cols=\"47\">$d</textarea></td></tr>

<input type=\"hidden\" name=\"owner\" value=\"" . $projectDetail->pro_owner[0] . "\">
<input type=\"hidden\" name=\"at\" value=\"0\">
<input type=\"hidden\" name=\"st\" value=\"2\">
<input type=\"hidden\" name=\"completion\" value=\"0\">
<input type=\"hidden\" value=\"1\" name=\"pub\">
<input type=\"hidden\" value=\"1\" name=\"miles\">
<tr><th>" . $strings["priority"] . " :</th><td><select name=\"pr\">";

$comptPri = count($priority);

for ($i = 0;$i < $comptPri;$i++) {
    if ($taskDetail->tas_priority[0] == $i) {
        echo "<option value=\"$i\" selected>$priority[$i]</option>";
    } else {
        echo "<option value=\"$i\">$priority[$i]</option>";
    } 
} 

echo "</select></td></tr>";

if ($sd == "") {
    $sd = $date;
} 
if ($dd == "") {
    $dd = "--";
} 

echo "<tr><th>" . $strings["start_date"] . " :</th><td><input type=\"text\" style=\"width: 150px;\" name=\"sd\" id=\"sel1\" size=\"20\" value=\"$sd\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script></td></tr>

<tr><th>" . $strings["due_date"] . " :</th><td><input type=\"text\" style=\"width: 150px;\" name=\"dd\" id=\"sel3\" size=\"20\" value=\"$dd\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script></td></tr>

<tr><th>" . $strings["comments"] . " :</th><td><textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"c\" cols=\"47\">$c</textarea></td></tr>
<tr><th>&nbsp;</th><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>
</table>
</form>
<p class=\"note\">" . $strings["client_add_task_note"] . "</p>";

require_once ("include_footer.php");

?>
