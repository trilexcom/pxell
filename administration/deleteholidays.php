<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteholidays.php,v 1.2 2004/12/15 19:43:07 madbear Exp $
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

if ($_SESSION['profilSession'] != 0) {
    header('Location: ../general/permissiondenied.php');
    exit;
}

$breadcrumbs[]=buildLink('../administration/admin.php', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['holidays'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

$block1 = new block();
$block1->headingForm($strings['delete_holidays']);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$block1->form = 'hoP';
$block1->openForm("../administration/listholidays.php?action=delete&amp;id=$id");

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE hol.id IN($id) ORDER BY hol.comments";
$listHoliday = new request();
$listHoliday->openHoliday($tmpquery);
$comptListHoliday = count($listHoliday->hol_id);

for ($i = 0;$i < $comptListHoliday;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">#" . $listHoliday->hol_id[$i] . "</td><td>" . $listHoliday->hol_comments[$i] . "</td></tr>";
} 

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" 
value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" 
onClick=\"history.back();\"></td></tr>";

$block1->closeForm();
$block1->closeContent();
$block1->headingForm_close();

require_once("../themes/" . THEME . "/footer.php");

?>