<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletefiles.php,v 1.4 2004/12/15 12:25:11 pixtur Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

#$task = $_REQUEST['task'];
#$action = $_REQUEST['action'];
#$id = $_REQUEST['id'];

if ($task == '') {
    $task = '0';
} 

if ($action == 'delete') {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["files"] . " WHERE id IN($id) OR vc_parent IN($id)";

    $tmpquery = "WHERE fil.id IN($id) OR fil.vc_parent IN($id) ORDER BY fil.name";
    $listFiles = new request();
    $listFiles->openFiles($tmpquery);
    $comptListFiles = count($listFiles->fil_id);
    for ($i = 0;$i < $comptListFiles;$i++) {
        if ($task != "0") {
            if (file_exists ("../files/" . $project . "/" . $task . "/" . $listFiles->fil_name[$i])) {
                deleteFile("files/" . $project . "/" . $task . "/" . $listFiles->fil_name[$i]);
            } 
        } else {
            if (file_exists ("../files/" . $project . "/" . $listFiles->fil_name[$i])) {
                deleteFile("files/" . $project . "/" . $listFiles->fil_name[$i]);
            } 
        } 
    } 
    connectSql("$tmpquery1");
    if ($sendto == "filedetails") {
        header('Location: ../linkedcontent/viewfile.php?id=' . $listFiles->fil_vc_parent[0] . '&msg=deleteFile');
        exit;
    } else {
        if ($task != "0") {
            header("Location: ../tasks/viewtask.php?id=$task&msg=deleteFile");
            exit;
        } else {
            header("Location: ../projects/viewproject.php?id=$project&msg=deleteFile");
            exit;
        } 
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

if ($task != "0") {
    $tmpquery = "WHERE tas.id = '$task'";
    $taskDetail = new request();
    $taskDetail->openTasks($tmpquery);
} 



//--- header ----
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);

if ($task != "0") {
    $breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../tasks/viewtask.php?id=" . $taskDetail->tas_id[0], $taskDetail->tas_name[0], LINK_INSIDE);
} 

$breadcrumbs[]=$strings["unlink_files"];

require_once("../themes/" . THEME . "/header.php");


//--- content ---

$block1 = new block();

$block1->form = "saC";
$block1->openForm("../linkedcontent/deletefiles.php?project=$project&amp;task=$task&amp;action=delete&amp;id=$id&amp;sendto=$sendto");

$block1->headingForm($strings["unlink_files"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE fil.id IN($id) ORDER BY fil.name";
$listFiles = new request();
$listFiles->openFiles($tmpquery);
$comptListFiles = count($listFiles->fil_id);

for ($i = 0;$i < $comptListFiles;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listFiles->fil_name[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["delete"] . "\">&#160;<input type=\"BUTTON\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
