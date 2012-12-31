<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallteamtasks.php,v 1.5 2005/01/04 06:40:43 luiswang Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$projectSite = "true";

$checkSession = true;
require_once("../includes/library.php");

$bouton[2] = "over";
$titlePage = $strings["team_tasks"];
require_once ("include_header.php");

$tmpquery = "WHERE tas.project = '" . $_SESSION['projectSession'] . "' AND tas.assigned_to != '0' AND tas.published = '0' AND tas.milestone <> '0' AND mem.organization = '1' ORDER BY tas.name";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$block1 = new block();

$block1->headingForm($strings["team_tasks"]);

if ($comptListTasks != "0") {
    if ($activeJpgraph == "true") {
        // show the expanded or compact Gantt Chart
        if ($_GET['base'] == 1) {
            echo "<a href='showallteamtasks.php'>expand</a><br>";
        } else {
            echo "<a href='showallteamtasks.php?base=1'>compact</a><br>";
        }

        echo "<img src=\"graphtasks.php?project=" . $projectDetail->pro_id[0] . '&amp;base=' . $_GET['base'] . "\" alt=\"\"><br>
<span class=\"listEvenBold\">Powered by <a href=\"http://www.aditus.nu/jpgraph/\" target=\"_blank\">JpGraph</a></span><br><br>";
    }

    echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\" class=\"listing\">
<tr><th class=\"active\">" . $strings["name"] . "</th><th>" . $strings["description"] . "</th><th>" . $strings["status"] . "</th><th>" . $strings["due"] . "</th></tr>";

    for ($i = 0;$i < $comptListTasks;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        }
        if ($listTasks->tas_due_date[$i] == "") {
            $listTasks->tas_due_date[$i] = $strings["none"];
        }
        $idStatus = $listTasks->tas_status[$i];
        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td><a href=\"teamtaskdetail.php?id=" . $listTasks->tas_id[$i] . "\">" . $listTasks->tas_name[$i] . "</a></td><td>" . nl2br($listTasks->tas_description[$i]) . "</td><td>$status[$idStatus]</td><td>" . $listTasks->tas_due_date[$i] . "</td></tr>";
    }

    echo "</table>\n";
}
else {
    echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\"><tr><td colspan=\"4\">" . $strings["no_items"] . "</td></tr></table>";
}

echo "<br><br>

<a href=\"addteamtask.php\" class=\"FooterCell\">" . $strings["add_task"] . "</a>";

$block1->headingForm_close();
require_once ("include_footer.php");

?>
