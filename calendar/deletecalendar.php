<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletecalendar.php,v 1.4 2004/12/15 12:25:18 pixtur Exp $
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

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["calendar"] . " WHERE id IN($id)";
    connectSql("$tmpquery1");
    header('Location: ../calendar/viewcalendar.php?msg=delete');
    exit;
} 




$breadcrumbs[]=buildLink("../calendar/viewcalendar.php?", $strings["calendar"], LINK_INSIDE);
$breadcrumbs[]=$strings["delete"];

require_once("../themes/" . THEME . "/header.php");

$block1 = new block();
$block1->form = "saP";
$block1->openForm("../calendar/deletecalendar.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE cal.id IN($id) ORDER BY cal.subject";
$listCalendar = new request();
$listCalendar->openCalendar($tmpquery);
$comptListCalendar = count($listCalendar->cal_id);

for ($i = 0;$i < $comptListCalendar;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">#" . $listCalendar->cal_id[$i] . "</td><td>" . $listCalendar->cal_subject[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
