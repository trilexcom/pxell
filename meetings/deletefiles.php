<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletefiles.php,v 1.2 2004/12/15 12:25:11 pixtur Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

$meeting = $_REQUEST['meeting'];
$action = $_REQUEST['action'];
$id = $_REQUEST['id'];

if ($action == 'delete') {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["meetings_attachment"] . " WHERE id IN($id) OR vc_parent IN($id)";

    $tmpquery = "WHERE mat.id IN($id) OR mat.vc_parent IN($id) ORDER BY mat.name";
    $listFiles = new request();
    $listFiles->openMeetingsAttachment($tmpquery);
    $comptListFiles = count($listFiles->mat_id);
    for ($i = 0;$i < $comptListFiles;$i++) {
        if (file_exists ("../files/" . $project . "/meetings/" . $meeting . "/" . $listFiles->mat_name[$i])) {
            deleteFile("files/" . $project . "/meetings/" . $meeting . "/" . $listFiles->mat_name[$i]);
        } 
    } 
    connectSql("$tmpquery1");
    if ($sendto == "filedetails") {
        header('Location: ../meetings/viewfile.php?id=' . $listFiles->mat_vc_parent[0] . '&msg=deleteFile');
        exit;
    } else {
        header("Location: ../meetings/viewmeeting.php?id=$meeting&msg=deleteFile");
        exit;
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$tmpquery = "WHERE mee.id = '$meeting'";
$meetingDetail = new request();
$meetingDetail->openMeetings($tmpquery);

//--- header ----
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?project=" . $projectDetail->pro_id[0], $strings["meetings"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/viewmeeting.php?id=" . $meetingDetail->mee_id[0], $meetingDetail->mee_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["unlink_files"];

require_once("../themes/" . THEME . "/header.php");

//--- content ----
$block1 = new block();

$block1->form = "saC";
$block1->openForm("../meetings/deletefiles.php?project=$project&amp;meeting=$meeting&amp;action=delete&amp;id=$id&amp;sendto=$sendto");

$block1->headingForm($strings["unlink_files"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mat.id IN($id) ORDER BY mat.name";
$listFiles = new request();
$listFiles->openMeetingsAttachment($tmpquery);
$comptListFiles = count($listFiles->mat_id);

for ($i = 0;$i < $comptListFiles;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listFiles->mat_name[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["delete"] . "\">&#160;<input type=\"BUTTON\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
