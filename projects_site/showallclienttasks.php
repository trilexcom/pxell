<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallclienttasks.php,v 1.5 2004/12/22 22:16:31 madbear Exp $
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

$bouton[3] = "over";
$titlePage = $strings["client_tasks"];
require_once ("include_header.php");

$tmpquery = "WHERE tas.project = '" . $_SESSION['projectSession'] . "' AND tas.assigned_to != '0' AND tas.published = '0' AND mem.profil = '3' ORDER BY tas.name";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$block1 = new block();

$block1->headingForm($strings["client_tasks"]);

if ($comptListTasks != "0") {
     echo '<table cellspacing="0" width="90%" border="0" cellpadding="3" cols="4" class="listing">';
    echo '<tr>';
    echo '<th class="active">';
    echo $strings["name"];
    echo '</th><th>';
    echo $strings["description"];
    echo '</th><th>:';
    echo $strings["status"];
    echo '</th><th>';
    echo $strings["due"];
    echo '</th></tr>';

    for ($i = 0;$i < $comptListTasks;$i++) {
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        }
        else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        }
        if ($listTasks->tas_due_date[$i] == "") {
            $listTasks->tas_due_date[$i] = $strings["none"];
        }
        $idStatus = $listTasks->tas_status[$i];
        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td><a href=\"clienttaskdetail.php?id=" . $listTasks->tas_id[$i] . "\">" . $listTasks->tas_name[$i] . "</a></td><td>" . nl2br($listTasks->tas_description[$i]) . "</td><td>$status[$idStatus]</td><td>" . $listTasks->tas_due_date[$i] . "</td></tr>";
    }
    echo "</table>
\n";
}
else {
    echo '<table cellspacing="0" border="0" cellpadding="2"><tr><td colspan="4">';
    echo $strings["no_items"];
    echo '</td></tr></table>';
}
$block1->headingForm_close();

require_once ("include_footer.php");


?>