<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addpost.php,v 1.6 2004/12/15 19:43:37 madbear Exp $
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

$tmpquery = "WHERE sr.id = '$id'";
$requestDetail = new request();
$requestDetail->openSupportRequests($tmpquery);

if ($action == "edit") {
    if ($sta == 2) {
        $tmpquery2 = "UPDATE " . $tableCollab["support_requests"] . " SET status='$sta',date_close='$dateheure' WHERE id = '$id'";
        connectSql("$tmpquery2");
    } else {
        $tmpquery2 = "UPDATE " . $tableCollab["support_requests"] . " SET status='$sta',date_close='--' WHERE id = '$id'";
        connectSql($tmpquery2);
    } 

    if ($notifications == "true") {
        if ($requestDetail->sr_status[0] != $sta) {
            require_once("../support/noti_statusrequestchange.php");
        } 
    } 

    header("Location: ../support/viewrequest.php?id=$id");
    exit;
} 

if ($action == "add") {
    $mes = convertData($mes);

    $tmpquery1 = "INSERT INTO " . $tableCollab["support_posts"] . "(request_id,message,date,owner,project) VALUES('$id','$mes','$dateheure','" . $_SESSION['idSession'] . "','" . $requestDetail->sr_project[0] . "')";
    connectSql("$tmpquery1");
    $tmpquery = $tableCollab["support_posts"];
    last_id($tmpquery);

    $num = $lastId[0];
    unset($lastId);

    if ($notifications == "true") {
        if ($mes != "") {
            require_once("../support/noti_newpost.php");
        } 
    } 

    header("Location: ../support/viewrequest.php?id=$id");
    exit;
} 





//--- header ---
$pageSection='projects';  
if ($supportType == "team") {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $requestDetail->sr_project[0], $requestDetail->sr_pro_name[0], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $requestDetail->sr_project[0], $strings["support_requests"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/viewrequest.php?id=" . $requestDetail->sr_id[0], $requestDetail->sr_subject[0], LINK_INSIDE);
    if ($action == "status") {
        $breadcrumbs[]=$strings["edit_status"];
    } 
	else {
        $breadcrumbs[]=$strings["add_support_response"];
    } 
} 
else if ($supportType == "admin") {
    $breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../administration/support.php?", $strings["support_management"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $requestDetail->sr_project[0], $strings["support_requests"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/viewrequest.php?id=" . $requestDetail->sr_id[0], $requestDetail->sr_subject[0], LINK_INSIDE);
    if ($action == "status") {
        $breadcrumbs[]=$strings["edit_status"];
    } 
	else {
        $breadcrumbs[]=$strings["add_support_response"];
    } 
} 

require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block2 = new block();

$block2->form = "sr";
if ($action == "status") {
    $block2->openForm("../support/addpost.php?action=edit&amp;id=$id#" . $block2->form . "Anchor");
} else {
    $block2->openForm("../support/addpost.php?action=add&amp;id=$id#" . $block2->form . "Anchor");
} 
if ($error != "") {
    $block2->headingError($strings["errors"]);
    $block2->contentError($error);
} 

$block2->headingForm($strings["add_support_respose"]);

$block2->openContent();
$block2->contentTitle($strings["details"]);
if ($action == "status") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"sta\">";

    $comptSta = count($requestStatus);
    for ($i = 0;$i < $comptSta;$i++) {
        if ($requestDetail->sr_status[0] == $i) {
            echo "<option value=\"$i\" selected>$requestStatus[$i]</option>";
        } else {
            echo "<option value=\"$i\">$requestStatus[$i]</option>";
        } 
    } 
    echo "</select></td></tr>";
} else {
    echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["message"] . "</td><td><textarea rows=\"3\" style=\"width: 400px; height: 200px;\" name=\"mes\" cols=\"43\">$mes</textarea></td></tr>
<input type=\"hidden\" name=\"user\" value=\"" . $_SESSION['idSession'] . "\">";
} 
echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["submit"] . "\"></td></tr>";

$block2->closeContent();
$block2->headingForm_close();

require_once("../themes/" . THEME . "/footer.php");

?>