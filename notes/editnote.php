<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editnote.php,v 1.5 2004/12/15 12:25:19 pixtur Exp $
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

if ($id != "" && $action != "add") {
    $tmpquery = "WHERE note.id = '$id'";
    $noteDetail = new request();
    $noteDetail->openNotes($tmpquery);
    $tmpquery = "WHERE pro.id = '" . $noteDetail->note_project[0] . "'";
    $project = $noteDetail->note_project[0];
    if ($noteDetail->note_owner[0] != $_SESSION['idSession']) {
        header("Location: ../notes/listnotes.php?project=$project&msg=noteOwner");
        exit;
    } 
} else {
    $tmpquery = "WHERE pro.id = '$project'";
} 

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
// case update note entry
if ($id != "") {
    // case update note entry
    if ($action == "update") {
        $subject = convertData($subject);
        $description = convertData($description);
        $tmpquery5 = "UPDATE " . $tableCollab["notes"] . " SET project='$projectMenu',topic='$topic',subject='$subject',description='$description',date='$dd',owner='" . $_SESSION['idSession'] . "' WHERE id = '$id'";
        $msg = "update";
        connectSql("$tmpquery5");
        header("Location: ../notes/viewnote.php?id=$id&msg=$msg");
        exit;
    } 
    // set value in form
    $dd = $noteDetail->note_date[0];
    $subject = $noteDetail->note_subject[0];
    $description = $noteDetail->note_description[0];
    $topic = $noteDetail->note_topic[0];
} 
// case add note entry
if ($id == "") {
    // case add note entry
    if ($action == "add") {
        $subject = convertData($subject);
        $description = convertData($description);
        $tmpquery1 = "INSERT INTO " . $tableCollab["notes"] . "(project,topic,subject,description,date,owner,published) VALUES('$projectMenu','$topic','$subject','$description','$dd','" . $_SESSION['idSession'] . "','1')";
        connectSql("$tmpquery1");
        $tmpquery = $tableCollab["notes"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
        header("Location: ../notes/viewnote.php?id=$num&msg=add");
        exit;
    } 
} 



//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../notes/listnotes.php?project=" . $projectDetail->pro_id[0], $strings["notes"], LINK_INSIDE);
if ($id == "") {
    $breadcrumbs[]=$strings["add_note"];
} 
if ($id != "") {
    $breadcrumbs[]=buildLink("../notes/viewnote.php?id=" . $noteDetail->note_id[0], $noteDetail->note_subject[0], LINK_INSIDE);
    $breadcrumbs[]=$strings["edit_note"];
} 



$bodyCommand = "onLoad=\"document.etDForm.subject.focus();\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();
if ($id == "") {
    $block1->form = "etD";
    $block1->openForm("../notes/editnote.php?project=$project&amp;id=$id&amp;action=add#" . $block1->form . "Anchor");
} 
if ($id != "") {
    $block1->form = "etD";
    $block1->openForm("../notes/editnote.php?project=$project&amp;id=$id&amp;action=update#" . $block1->form . "Anchor");
} 
if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 
if ($id == "") {
    $block1->headingForm($strings["add_note"]);
} 
else {
    $block1->headingForm($strings["edit_note"] . " : " . $noteDetail->note_subject[0]);
} 

$block1->openContent();
$block1->contentTitle($strings["details"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["project"] . " :</td><td><select name=\"projectMenu\">";

$tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "' ORDER BY pro.name";
$listProjects = new request();
$listProjects->openTeams($tmpquery);
$comptListProjects = count($listProjects->tea_id);

for ($i = 0;$i < $comptListProjects;$i++) {
    if ($listProjects->tea_pro_id[$i] == $noteDetail->note_project[0] || $project == $listProjects->tea_pro_id[$i]) {
        echo "<option value=\"" . $listProjects->tea_pro_id[$i] . "\" selected>" . $listProjects->tea_pro_name[$i] . "</option>";
    } else {
        echo "<option value=\"" . $listProjects->tea_pro_id[$i] . "\">" . $listProjects->tea_pro_name[$i] . "</option>";
    } 
} 

echo "</select></td></tr>";

$block1->contentRow($strings["date"], "<input type=\"text\" style=\"width: 150px;\" name=\"dd\" id=\"sel3\" size=\"20\" value=\"$dd\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script>");

$comptTopic = count($topicNote);

if ($comptTopic != "0") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["topic"] . " :</td><td><select name=\"topic\"><option value=\"\">" . $strings["choice"] . "</option>";

    for ($i = 1;$i <= $comptTopic;$i++) {
        if ($topic == $i) {
            echo "<option value=\"$i\" selected>$topicNote[$i]</option>";
        } else {
            echo "<option value=\"$i\">$topicNote[$i]</option>";
        } 
    } 
    echo "</select></td></tr>";
} 

$block1->contentRow($strings["subject"], "<input size=\"44\" value=\"$subject\" style=\"width: 400px\" name=\"subject\" maxlength=\"100\" type=\"TEXT\">");
$block1->contentRow($strings["description"], "<textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"description\" cols=\"47\">$description</textarea>");
$block1->contentRow("", "<input type=\"SUBMIT\" value=\"" . $strings["save"] . "\">");
$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
