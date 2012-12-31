<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: showallcontacts.php,v 1.4 2004/12/22 22:16:31 madbear Exp $
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

$bouton[1] = "over";
$titlePage = $strings["project_team"];
require_once ("include_header.php");

$tmpquery = "WHERE tea.project = '" . $_SESSION['projectSession'] . "' AND tea.published = '0' ORDER BY mem.name";
$listContacts = new request();
$listContacts->openTeams($tmpquery);
$comptListTeams = count($listContacts->tea_id);

$block1 = new block();

$block1->headingForm($strings["project_team"]);

if ($comptListTeams != "0") {
    echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\" class=\"listing\">
<tr><th class=\"active\">" . $strings["name"] . "</th><th>" . $strings["title"] . "</th><th>" . $strings["company"] . "</th><th>" . $strings["email"] . "</th></tr>";

    for ($i = 0;$i < $comptListTeams;$i++) {
        if ($listContacts->tea_mem_phone_work[$i] == "") {
            $listContacts->tea_mem_phone_work[$i] = $strings["none"];
        } 
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $block1->oddColor;
        } else {
            $class = "even";
            $highlightOff = $block1->evenColor;
        } 
        echo "<tr class=\"$class\" onmouseover=\"this.style.backgroundColor='" . $block1->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td><a href=\"contactdetail.php?id=" . $listContacts->tea_mem_id[$i] . "\">" . $listContacts->tea_mem_name[$i] . "</a></td><td>" . $listContacts->tea_mem_title[$i] . "</td><td>" . $listContacts->tea_org_name[$i] . "</td><td><a href=\"mailto:" . $listContacts->tea_mem_email_work[$i] . "\">" . $listContacts->tea_mem_email_work[$i] . "</a></td></tr>";
    } 
    echo "</table>
<hr />\n";
} else {
    echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"2\"><tr><td colspan=\"4\">" . $strings["no_items"] . "</td></tr></table><hr>";
} 

$block1->headingForm_close();

require_once ("include_footer.php");

?>
