<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: doclists.php,v 1.5 2004/12/22 22:16:31 madbear Exp $
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

$bouton[4] = "over";
$titlePage = $strings["document_list"];
require_once ("include_header.php");


$tmpquery = "WHERE fil.project = '" . $_SESSION['projectSession'] . "' AND fil.published = '0' AND fil.vc_parent = '0' ORDER BY fil.name";
$listFiles = new request();
$listFiles->openFiles($tmpquery);
$comptListFiles = count($listFiles->fil_id);

$block1 = new block();

$block1->headingForm($strings["document_list"]);

if ($comptListFiles != "0") {
    echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"3\" cols=\"4\" class=\"listing\">
<tr><th class=\"active\">" . $strings["name"] . "</th><th>" . $strings["topic"] . "</th><th>" . $strings["date"] . "</th><th width=\"1%\" >" . $strings["approval_tracking"] . "</th></tr>";

    for ($i = 0;$i < $comptListFiles;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        } 
        $idStatus = $listFiles->fil_status[$i];
        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td>";
        if ($listFiles->fil_task[$i] != "0") {
            echo "<a href=\"clientfiledetail.php?id=" . $listFiles->fil_id[$i] . "\">" . $listFiles->fil_name[$i] . "</a>";
            $folder = $listFiles->fil_project[0] . "/" . $listFiles->fil_task[0];
        } else {
            echo "<a href=\"clientfiledetail.php?id=" . $listFiles->fil_id[$i] . "\">" . $listFiles->fil_name[$i] . "</a>";
            $folder = $listFiles->fil_project[0];
        } 
        echo " </td><td><a href=\"createthread.php?topicField=" . $listFiles->fil_name[$i] . "\">" . $strings["create"] . "</a></td><td>" . $listFiles->fil_date[$i] . "</td><td width=\"20%\" class=\"$class\"><a href=\"docitemapproval.php?id=" . $listFiles->fil_id[$i] . "\">$statusFile[$idStatus]</a></td></tr>";
    } 
    echo "</table>\n";
} else {
    echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\"><tr><td colspan=\"4\" class=\"listOddBold\">" . $strings["no_items"] . "</td></tr></table>";
} 

echo "<br><br>

<a href=\"uploadfile.php\" class=\"FooterCell\">" . $strings["upload_file"] . "</a>";
$block1->headingForm_close();

require_once ("include_footer.php");

?>