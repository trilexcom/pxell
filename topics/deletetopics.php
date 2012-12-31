<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletetopics.php,v 1.4 2004/12/15 12:25:13 pixtur Exp $
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
    $tmpquery1 = "DELETE FROM " . $tableCollab["topics"] . " WHERE id IN($id)";
    $tmpquery2 = "DELETE FROM " . $tableCollab["posts"] . " WHERE topic IN($id)";
    $pieces = explode(",", $id);
    $num = count($pieces);
    connectSql("$tmpquery1");
    connectSql("$tmpquery2");
    if ($project != "") {
        header("Location: ../projects/viewproject.php?num=$num&msg=deleteTopic&id=$project");
        exit;
    } else {
        header("Location: ../general/home.php?num=$num&msg=deleteTopic");
        exit;
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

//--- header ---
if ($project != "") {
    $breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
    $breadcrumbs[]= buildLink("../topics/listtopics.php?project=" . $projectDetail->pro_id[0], $strings["discussions"], LINK_INSIDE);
} else {
    $breadcrumbs[]= buildLink("../general/home.php?", $strings["home"], LINK_INSIDE);
    $breadcrumbs[]= buildLink("../topics/listtopics.php?", $strings["my_discussions"], LINK_INSIDE);
} 
$breadcrumbs[]= $strings["delete_discussions"];

require_once("../themes/" . THEME . "/header.php");

//---- content ----
$block1 = new block();

$block1->form = "saP";
$block1->openForm("../topics/deletetopics.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete_discussions"]);

$block1->openContent();

$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE topic.id IN($id) ORDER BY topic.subject";
$listTopics = new request();
$listTopics->openTopics($tmpquery);
$comptListTopics = count($listTopics->top_id);

for ($i = 0;$i < $comptListTopics;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listTopics->top_subject[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
