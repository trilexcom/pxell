<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: clienttaskdetail.php,v 1.5 2004/12/22 22:16:31 madbear Exp $
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

if ($action == "update") {
    $comments = convertData($comments);
    if ($checkbox != "") {
        $tmpquery = "UPDATE " . $tableCollab["tasks"] . " SET comments='$comments',status='0',modified='$dateheure' WHERE id = '$id'";
    } else {
        $tmpquery = "UPDATE " . $tableCollab["tasks"] . " SET comments='$comments',status='3',modified='$dateheure' WHERE id = '$id'";
    } 
    connectSql("$tmpquery");
    header("Location: showallclienttasks.php");
    exit;
} 

$tmpquery = "WHERE tas.id = '$id'";
$taskDetail = new request();
$taskDetail->openTasks($tmpquery);

if ($taskDetail->tas_published[0] == "1" || $taskDetail->tas_project[0] != $_SESSION['projectSession']) {
    header("Location: index.php");
} 

$bouton[3] = "over";
$titlePage = $strings["client_task_details"];
require_once ("include_header.php");

$block1 = new block();

$block1->headingForm($strings["client_task_details"]);

echo "<table cellspacing=\"0\" cellpadding=\"3\">";
if ($taskDetail->tas_name[0] != "") {
    echo "<tr><td>" . $strings["name"] . " :</td><td>" . $taskDetail->tas_name[0] . "</td></tr>";
} 
if ($taskDetail->tas_description[0] != "") {
    echo "<tr><td>" . $strings["description"] . " :</td><td>" . nl2br($taskDetail->tas_description[0]) . "</td></tr>";
} 
$complValue = ($taskDetail->tas_completion[0] > 0) ? $taskDetail->tas_completion[0] . "0 %": $taskDetail->tas_completion[0] . " %";
echo "<tr><td>" . $strings["completion"] . " :</td><td>" . $complValue . "</td></tr>";
if ($taskDetail->tas_mem_name[0] != "") {
    echo "<tr><td>" . $strings["assigned_to"] . " :</td><td>" . $taskDetail->tas_mem_name[0] . "</td></tr>";
} 
if ($taskDetail->tas_comments[0] != "") {
    echo "<tr><td>" . $strings["comments"] . " :</td><td>" . nl2br($taskDetail->tas_comments[0]) . "</td></tr>";
} 
if ($taskDetail->tas_start_date[0] != "") {
    echo "<tr><td>" . $strings["start_date"] . " :</td><td>" . $taskDetail->tas_start_date[0] . "</td></tr>";
} 
if ($taskDetail->tas_due_date[0] != "") {
    echo "<tr><td>" . $strings["due_date"] . " :</td><td>" . $taskDetail->tas_due_date[0] . "</td></tr>";
} 
echo "<tr><td>" . $strings["updates_task"] . " :</td><td>";
$tmpquery = "WHERE upd.type='1' AND upd.item = '$id' ORDER BY upd.created DESC";
$listUpdates = new request();
$listUpdates->openUpdates($tmpquery);
$comptListUpdates = count($listUpdates->upd_id);

if ($comptListUpdates != "0") {
    $j = 1;
    for ($i = 0;$i < $comptListUpdates;$i++) {
        echo "<b>" . $j . ".</b> <i>" . createDate($listUpdates->upd_created[$i], $_SESSION['timezoneSession']) . "</i><br>" . nl2br($listUpdates->upd_comments[$i]);
        echo "<br>";
        $j++;
    } 
} else {
    echo $strings["no_items"];
} 

echo "</td></tr>
</table>
<hr>";

echo "<form accept-charset=\"UNKNOWN\" method=\"post\" action=\"../projects_site/clienttaskdetail.php?action=update\" name=\"clientTaskUpdate\" enctype=\"multipart/form-data\"><input name=\"id\" type=\"HIDDEN\" value=\"$id\">";

echo "<table cellspacing=\"0\" cellpadding=\"3\">
<tr><th colspan=\"2\">" . $strings["client_change_status"] . "</th></tr>
<tr><td>" . $strings["status"] . " :</td><td>";

if ($taskDetail->tas_status[0] == "0") {
    echo "<input checked value=\"checkbox\" name=\"checkbox\" type=\"checkbox\">";
} else {
    echo "<input value=\"checkbox\" name=\"checkbox\" type=\"checkbox\">";
} 

echo "&nbsp;$status[0]</td></tr>
<tr valign=\"top\"><td>" . $strings["comments"] . " :</td><td><textarea cols=\"40\" name=\"comments\" rows=\"5\">" . $taskDetail->tas_comments[0] . "</textarea></td></tr><tr align=\"top\"><td>&#160;</td><td><input name=\"submit\" type=\"submit\" value=\"" . $strings["save"] . "\"></td></tr>
</table>
</form>";

echo "<br><br>
<a href=\"showallclienttasks.php\">" . $strings["show_all"] . "</a>";

$block1->headingForm_close();
require_once ("include_footer.php");

?>
