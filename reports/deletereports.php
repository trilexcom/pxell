<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletereports.php,v 1.5 2004/12/15 12:25:19 pixtur Exp $
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
    $tmpquery1 = "DELETE FROM " . $tableCollab["reports"] . " WHERE id IN($id)";
    connectSql($tmpquery1);
    header("Location: ../general/home.php?msg=deleteReport");
    exit;
} 




//--- header ---
$breadcrumbs[]=buildLink("../reports/listreports.php?", $strings["my_reports"], LINK_INSIDE);
$breadcrumbs[]=$strings["delete_reports"];

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "saS";
$block1->openForm("../reports/deletereports.php?action=delete&amp;id=$id");

$block1->headingForm($strings["delete_reports"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE rep.id IN($id) ORDER BY rep.name";
$listReports = new request();
$listReports->openReports($tmpquery);
$comptListReports = count($listReports->rep_id);

for ($i = 0;$i < $comptListReports;$i++) {
    $block1->contentRow("#" . $listReports->rep_id[$i], $listReports->rep_name[$i]);
} 

$block1->contentRow("", "<input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
