<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: suprequestdetail.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
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

$tmpquery = "WHERE sr.id = '$id'";
$requestDetail = new request();
$requestDetail->openSupportRequests($tmpquery);

if ($requestDetail->sr_project[0] != $_SESSION['projectSession'] || $requestDetail->sr_user[0] != $_SESSION['idSession']) {
    header('Location: index.php');
    exit;
} 

$tmpquery = "WHERE sp.request_id = '$id' ORDER BY sp.date";
$postDetail = new request();
$postDetail->openSupportPosts($tmpquery);
$comptPostDetail = count($postDetail->sp_id);

$bouton[6] = "over";
$titlePage = $strings["support"];
require_once ("include_header.php");

echo "<table cellspacing=\"0\" width=\"90%\" cellpadding=\"3\">
<tr><th colspan=\"4\">" . $strings["information"] . ":</th></tr>";

$comptSupStatus = count($requestStatus);
for ($i = 0;$i < $comptSupStatus;$i++) {
    if ($requestDetail->sr_status[0] == $i) {
        $requestStatus = $requestStatus[$i];
    } 
} 
$comptPri = count($priority);
for ($i = 0;$i < $comptPri;$i++) {
    if ($requestDetail->sr_priority[0] == $i) {
        $requestPriority = $priority[$i];
    } 
} 

echo "<tr><th>" . $strings["support_id"] . ":</th><td>" . $requestDetail->sr_id[0] . "</td><th>" . $strings["status"] . ":</th><td>$requestStatus</td></tr>
<tr><th>" . $strings["subject"] . ":</th><td>" . $requestDetail->sr_subject[0] . "</td><th>" . $strings["priority"] . ":</th><td>$requestPriority</td></tr>
<tr><th>" . $strings["message"] . ":</th><td>" . $requestDetail->sr_message[0] . "</td><th>&nbsp;</th><td>&nbsp;</td></tr>";

echo "<tr><th>" . $strings["date_open"] . " :</th><td>" . $requestDetail->sr_date_open[0] . "</td><th>&nbsp;</th><td>&nbsp;</td></tr>";

if ($requestDetail->sr_status[0] == "2") {
    echo "<tr><th>" . $strings["date_close"] . " :</th><td>" . $requestDetail->sr_date_close[0] . "</td><th>&nbsp;</th><td>&nbsp;</td></tr>";
} 

echo "<tr><td colspan=\"4\">&nbsp;</td></tr>
<tr><th colspan=\"4\">" . $strings["responses"] . ":</th></tr>
<tr><td colspan=\"4\" align=\"right\"><a href=\"addsupportpost.php?id=$id\" class=\"FooterCell\">" . $strings["add_support_response"] . "</a></td></tr>";

if ($comptPostDetail != "0") {
    for ($i = 0;$i < $comptPostDetail;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        } 

        echo "<tr><td colspan=\"4\" class=\"$class\">&nbsp;</td></tr>

<tr class=\"$class\"><th>" . $strings["date"] . " :</th><td colspan=\"3\">" . $postDetail->sp_date[$i] . "</td></tr>";

        $tmpquery = "WHERE mem.id = '" . $postDetail->sp_owner[$i] . "'";
        $ownerDetail = new request();
        $ownerDetail->openMembers($tmpquery);

        echo "<tr class=\"$class\"><th>" . $strings["posted_by"] . " :</th><td colspan=\"3\">" . $ownerDetail->mem_name[0] . "</td></tr>
<tr class=\"$class\"><th>" . $strings["message"] . " :</th><td colspan=\"3\">" . nl2br($postDetail->sp_message[$i]) . "</td></tr>";
    } 
} else {
    echo "<tr><td colspan=\"4\" class=\"ListOddRow\">" . $strings["no_items"] . "</td></tr>";
} 
echo "</table>";

require_once ("include_footer.php");

?>
