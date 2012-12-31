<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: assignmentcomment.php,v 1.4 2004/12/15 12:25:13 pixtur Exp $
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
    $acomm = convertData($acomm);
    $tmpquery6 = "UPDATE " . $tableCollab["assignments"] . " SET comments='$acomm' WHERE id = '$id'";
    connectSql("$tmpquery6");
    header("Location: ../tasks/viewtask.php?id=$task&msg=update");
    exit;
} 


$tmpquery = "WHERE tas.id = '$task'";
$taskDetail = new request();
$taskDetail->openTasks($tmpquery);

$tmpquery = "WHERE pro.id = '" . $taskDetail->tas_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/viewtask.php?id=" . $taskDetail->tas_id[0], $taskDetail->tas_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["assignment_comment"];


$bodyCommand = "onLoad=\"document.assignment_commentForm.acomm.focus();\"";
require_once("../themes/" . THEME . "/header.php");

//--- content ----
$block1 = new block();

$block1->form = "assignment_comment";
$block1->openForm("../tasks/assignmentcomment.php?action=update&amp;id=$id&amp;task=$task");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["assignment_comment"]);

$block1->openContent();
$block1->contentTitle($strings["assignment_comment_info"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["task"] . " :</td><td>" . $taskDetail->tas_name[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["comments"] . " :</td><td><input style=\"width: 400px;\" maxlength=\"128\" size=\"44\" name=\"acomm\"></input></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"Save\" value=\"" . $strings["save"] . "\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
