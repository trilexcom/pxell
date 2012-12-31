<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallthreads.php,v 1.4 2004/12/22 22:16:31 madbear Exp $
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

$tmpquery = "WHERE topic.id = '$id'";
$detailTopic = new request();
$detailTopic->openTopics($tmpquery);

if ($detailTopic->top_published[0] == "1" || $detailTopic->top_project[0] != $_SESSION['projectSession']) {
    header('Location: index.php');
    exit;
} 

if ($action == "delete") {
    $detailTopic->top_posts[0] = $detailTopic->top_posts[0] - 1;
    $tmpquery = "DELETE FROM " . $tableCollab["posts"] . " WHERE id = '$post'";
    connectSql("$tmpquery");
    $tmpquery2 = "UPDATE " . $tableCollab["topics"] . " SET posts='" . $detailTopic->top_posts[0] . "' WHERE id = '$id'";
    connectSql("$tmpquery2");
    header("Location: showallthreads.php?id=$id");
    exit;
} 

$bouton[5] = "over";
$titlePage = $strings["bulletin_board_topic"];
require_once ("include_header.php");

$tmpquery = "WHERE pos.topic = '" . $detailTopic->top_id[0] . "' ORDER BY pos.created DESC";
$listPosts = new request();
$listPosts->openPosts($tmpquery);
$comptListPosts = count($listPosts->pos_id);

$idStatus = $detailTopic->top_status[0];

echo "<table cellspacing=\"0\" width=\"90%\" cellpadding=\"3\">
<tr><th colspan=\"4\">" . $strings["information"] . ":</th></tr>
<tr><th>" . $strings["subject"] . ":</th><td>" . $detailTopic->top_subject[0] . "</td><th>" . $strings["posts"] . ":</th><td>" . $detailTopic->top_posts[0] . "</td></tr>
<tr><th>" . $strings["project"] . ":</th><td>" . $projectDetail->pro_name[0] . "</td><th>" . $strings["last_post"] . ":</th><td>" . createDate($detailTopic->top_last_post[0], $_SESSION['timezoneSession']) . "</td></tr>
<tr><th>&nbsp;</th><td>&nbsp;</td><th>" . $strings["retired"] . ":</th><td>$statusTopicBis[$idStatus]</td></tr>
<tr><th>" . $strings["owner"] . ":</th><td colspan=\"3\"><a href=\"mailto:" . $detailTopic->top_mem_email_work[0] . "\">" . $detailTopic->top_mem_login[0] . "</a></td></tr>
<tr><td colspan=\"4\">&nbsp;</td></tr>
<tr><th colspan=\"4\">" . $strings["discussion"] . ":</th></tr>
<tr><td colspan=\"4\" align=\"right\"><a href=\"threadpost.php?id=$id\">" . $strings["post_reply"] . "</a></td></tr>";

if ($comptListPosts != "0") {
    for ($i = 0;$i < $comptListPosts;$i++) {
        if (!($i % 2)) {
            $class = "odd";
        } else {
            $class = "even";
        } 
        echo "<tr><td colspan=\"4\" class=\"$class\">&nbsp;</td></tr>
<tr class=\"$class\"><th>" . $strings["posted_by"] . " :</th><td>" . $listPosts->pos_mem_name[$i] . "</td><td colspan=\"2\" align=\"right\">";

        if ($detailProject->pro_owner[0] == $_SESSION['idSession'] || $_SESSION['profilSession'] == "0" || $listPosts->pos_member[$i] == $_SESSION['idSession']) {
            echo "<a href=\"../projects_site/showallthreads.php?id=$id&amp;action=delete&amp;post=" . $listPosts->pos_id[$i] . "\">" . $strings["delete_message"] . "</a>";
        } else {
            echo "&nbsp";
        } 

        echo "</td></tr>
<tr class=\"$class\"><th>" . $strings["email"] . " :</th><td colspan=\"3\"><a href=\"mailto:" . $listPosts->pos_mem_email_work[$i] . "\">" . $listPosts->pos_mem_email_work[$i] . "</a></td></tr>
<tr class=\"$class\"><th nowrap>" . $strings["when"] . " :</th><td colspan=\"3\">" . createDate($listPosts->pos_created[$i], $_SESSION['timezoneSession']) . "</td></tr>
<tr class=\"$class\"><th>" . $strings["message"] . " :</th><td colspan=\"3\">" . nl2br($listPosts->pos_message[$i]) . "</td></tr>";
    } 
} else {
    echo "<tr><td colspan=\"4\" class=\"ListOddRow\">" . $strings["no_items"] . "</td></tr>";
} 
echo "</table>";

require_once ("include_footer.php");

?>
