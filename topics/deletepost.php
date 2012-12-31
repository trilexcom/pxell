<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletepost.php,v 1.4 2004/12/15 12:25:12 pixtur Exp $
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

$tmpquery = "WHERE topic.id = '$topic'";
$detailTopic = new request();
$detailTopic->openTopics($tmpquery);

if ($action == "delete") {
    $detailTopic->top_posts[0] = $detailTopic->top_posts[0] - 1;
    $tmpquery = "DELETE FROM " . $tableCollab["posts"] . " WHERE id = '$id'";
    connectSql("$tmpquery");
    $tmpquery2 = "UPDATE " . $tableCollab["topics"] . " SET posts='" . $detailTopic->top_posts[0] . "' WHERE id = '$topic'";
    connectSql("$tmpquery2");
    header("Location: ../topics/viewtopic.php?msg=delete&id=$topic");
    exit;
} 

$tmpquery = "WHERE pos.id = '$id'";
$detailPost = new request();
$detailPost->openPosts($tmpquery);



//--- header ---
$breadcrumbs[]= buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../projects/viewproject.php?id=" . $detailTopic->top_pro_id[0], $detailTopic->top_pro_name[0], LINK_INSIDE);
$breadcrumbs[]= buildLink("../topics/listtopics.php?topic=" . $detailTopic->top_id[0], $strings["discussion"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../topics/viewtopic.php?id=" . $detailTopic->top_id[0], $detailTopic->top_subject[0], LINK_INSIDE);
$breadcrumbs[]= $strings["delete_messages"];


require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "saP";
$block1->openForm("../topics/deletepost.php?id=$id&amp;topic=$topic&amp;action=delete");

$block1->headingForm($strings["delete_messages"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . nl2br($detailPost->pos_message[0]) . "</td>

<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
