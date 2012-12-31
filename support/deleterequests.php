<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleterequests.php,v 1.5 2004/12/15 19:43:38 madbear Exp $
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

if ($enableHelpSupport != "true") {
    header("Location: ../general/permissiondenied.php");
    exit;
} 

if ($supportType == "admin") {
    if ($_SESSION['profilSession'] != "0") {
        header("Location: ../general/permissiondenied.php");
        exit;
    } 
} 

if ($action == "deleteRequest") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["support_requests"] . " WHERE id IN($id)";
    $tmpquery2 = "DELETE FROM " . $tableCollab["support_posts"] . " WHERE request_id IN($id)";
    $pieces = explode(",", $id);
    $num = count($pieces);
    connectSql("$tmpquery1");
    connectSql("$tmpquery2");

    header("Location: ../support/support.php?msg=delete&action=$sendto&project=$project");
    exit;
} 

if ($action == "deletePost") {
    $id = str_replace("**", ",", $id);
    $tmpquery3 = "DELETE FROM " . $tableCollab["support_posts"] . " WHERE id IN($id)";
    $pieces = explode(",", $id);
    $num = count($pieces);
    connectSql("$tmpquery3");

    header("Location: ../support/viewrequest.php?msg=delete&id=$sendto");
    exit;
} 

if ($action == "deleteR") {
    $id = str_replace("**", ",", $id);
    $tmpquery = "WHERE sr.id IN($id) ORDER BY sr.subject";
    $listRequest = new request();
    $listRequest->openSupportRequests($tmpquery);
    $comptListRequest = count($listRequest->sr_id);
} elseif ($action == "deleteP") {
    $id = str_replace("**", ",", $id);
    $tmpquery = "WHERE sp.id IN($id) ORDER BY sp.id";
    $listPost = new request();
    $listPost->openSupportPosts($tmpquery);
    $comptListPost = count($listPost->sp_id);

    $tmpquery2 = "WHERE sr.id IN(" . $listPost->sp_request_id[0] . ") ORDER BY sr.subject";
    $listRequest = new request();
    $listRequest->openSupportRequests($tmpquery2);
    $comptListRequest = count($listRequest->sr_id);
} 



//--- header ---
$pageSection='projects';  
if ($supportType == "team") {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $listRequest->sr_project[0], $listRequest->sr_pro_name[0], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $listRequest->sr_project[0], $strings["support_requests"], LINK_INSIDE);
    if ($action == "deleteR") {
        $breadcrumbs[]=$strings["delete_request"];
    } else if ($action == "deleteP") {
        $breadcrumbs[]=$strings["delete_support_post"];
    } 
} elseif ($supportType == "admin") {
    $breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../administration/support.php?", $strings["support_management"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $listRequest->sr_project[0], $strings["support_requests"], LINK_INSIDE);
    if ($action == "deleteR") {
        $breadcrumbs[]=$strings["delete_request"];
    } else if ($action == "deleteP") {
        $breadcrumbs[]=$strings["delete_support_post"];
    }
}

require_once("../themes/" . THEME . "/header.php");

//--- content  ---
$block1 = new block();

$block1->form = "saP";
if ($action == "deleteR") {
    $block1->openForm("../support/deleterequests.php?action=deleteRequest&amp;id=$id&amp;sendto=$sendto&amp;project=" . $listRequest->sr_project[0]);
} elseif ($action == "deleteP") {
    $block1->openForm("../support/deleterequests.php?action=deletePost&amp;id=$id&amp;sendto=" . $listRequest->sr_id[0]);
} 

if ($action == "deleteR") {
    $block1->headingForm($strings["delete_request"]);
} elseif ($action == "deleteP") {
    $block1->headingForm($strings["delete_support_post"]);
} 

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

if ($action == "deleteR") {
    for ($i = 0;$i < $comptListRequest;$i++) {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listRequest->sr_subject[$i] . "</td></tr>";
    } 
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";
} elseif ($action == "deleteP") {
    for ($i = 0;$i < $comptListPost;$i++) {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listPost->sp_id[$i] . "</td></tr>";
    } 
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";
} 

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>