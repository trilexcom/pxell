<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallsupport.php,v 1.3 2004/12/15 18:38:52 pixtur Exp $
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

$bouton[6] = "over";
$titlePage = $strings["support"];
require_once ("include_header.php");

$tmpquery = "WHERE mem.id = '" .$_SESSION['idSession'] . "'";
$userDetail = new request();
$userDetail->openMembers($tmpquery);

$tmpquery = "WHERE sr.member = '" . $_SESSION['idSession'] . "' AND sr.project = '$project'";
$listRequests = new request();
$listRequests->openSupportRequests($tmpquery);
$comptListRequests = count($listRequests->sr_id);

$block1 = new block();

$block1->headingForm($strings["my_support_request"]);

if ($comptListRequests != "0") {
    echo "<table  cols=\"4\" class=\"listing\">
<tr><th width=1% class=\"active\">" . $strings["id"] . "</th><th>" . $strings["subject"] . "</th><th>" . $strings["priority"] . "</th><th>" . $strings["status"] . "</th><th>" . $strings["project"] . "</th><th>" . $strings["date_open"] . "</th><th>" . $strings["date_close"] . "</th></tr>";

    for ($i = 0;$i < $comptListRequests;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        }

        $comptSta = count($requestStatus);
        for ($sr = 0;$sr < $comptSta;$sr++) {
            if ($listRequests->sr_status[$i] == $sr) {
                $currentStatus = $requestStatus[$sr];
            }
        }

        $comptPri = count($priority);
        for ($rp = 0;$rp < $comptPri;$rp++) {
            if ($listRequests->sr_priority[$i] == $rp) {
                $requestPriority = $priority[$rp];
            }
        }

        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\">
<td>" . $listRequests->sr_id[$i] . "</td>
<td><a href=\"suprequestdetail.php?id=" . $listRequests->sr_id[$i] . "\">" . $listRequests->sr_subject[$i] . "</a></td>
<td>$requestPriority</td>
<td>$currentStatus</td>
<td>" . $listRequests->sr_project[$i] . "</td>
<td>" . $listRequests->sr_date_open[$i] . "</td>
<td>" . $listRequests->sr_date_close[$i] . "</td>
</tr>";
    }
    echo "</table>";
} else {
    echo "<table ><tr><td colspan=\"4\">" . $strings["no_items"] . "</td></tr></table>";
}
echo "<br><br>
<a href=\"addsupport.php\" class=\"FooterCell\">" . $strings["add_support_request"] . "</a>";

$block1->headingForm_close();
require_once ("include_footer.php");

?>