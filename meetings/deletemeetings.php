<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletemeetings.php,v 1.2 2004/12/15 12:25:11 pixtur Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
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
    $tmpquery1 = "DELETE FROM " . $tableCollab["meetings"] . " WHERE id IN($id)";
    $tmpquery2 = "DELETE FROM " . $tableCollab["attendants"] . " WHERE meeting IN($id)";
    $tmpquery3 = "DELETE FROM " . $tableCollab["meetings_attachment"] . " WHERE meeting IN($id)";
    $tmpquery4 = "DELETE FROM " . $tableCollab["meetings_time"] . " WHERE meeting IN($id)";

    $tmpquery = "WHERE mee.id IN($id)";
    $listMeetings = new request();
    $listMeetings->openMeetings($tmpquery);
    $comptListMeetings = count($listMeetings->mee_id);
    for ($i = 0;$i < $comptListMeetings;$i++) {
        if ($fileManagement == "true") {
            delDir("../files/" . $listMeetings->mee_project[$i] . "/meetings/" . $listMeetings->mee_id[$i]);
        } 
    } 
    connectSql("$tmpquery1");
    connectSql("$tmpquery2");
    connectSql("$tmpquery3");
    connectSql("$tmpquery4");
    if ($project != "") {
        header("Location: ../projects/viewproject.php?id=$project&msg=delete");
        exit;
    } else {
        header("Location: ../general/home.php?msg=delete");
        exit;
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

// ---- header -----------------
if ($project != "") {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
    $breadcrumbs[]=$strings["delete_meetings"];
} else {
    $breadcrumbs[]=buildLink("../general/home.php?", $strings["home"], LINK_INSIDE);
    $breadcrumbs[]=$strings["my_meetings"];
} 

require_once("../themes/" . THEME . "/header.php");

// ---- content -----------------
$block1 = new block();

$block1->form = "saP";
$block1->openForm("../meetings/deletemeetings.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete_meetings"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mee.id IN($id) ORDER BY mee.name";
$listMeetings = new request();
$listMeetings->openMeetings($tmpquery);
$comptListMeetings = count($listMeetings->mee_id);

for ($i = 0;$i < $comptListMeetings;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">#" . $listMeetings->mee_id[$i] . "</td><td>" . $listMeetings->mee_name[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" 
value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" 
onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
