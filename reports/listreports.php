<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listreports.php,v 1.7 2004/12/23 16:39:19 pixtur Exp $
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




$breadcrumbs[]=buildLink("../reports/createreport.php?", $strings["reports"], LINK_INSIDE);
$breadcrumbs[]=$strings["my_reports"];

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

//---- content ------
$block1 = new block();

$block1->form = "wbSe";
$block1->openForm("../reports/listreports.php#" . $block1->form . "Anchor");

$block1->heading($strings["my_reports"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$block1->sorting("reports", $sortingUser->sor_reports[0], "rep.name ASC", $sortingFields = array(0 => "rep.name", 1 => "rep.created"));

$tmpquery = "WHERE rep.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block1->sortingValue";
$listReports = new request();
$listReports->openReports($tmpquery);
$comptListReports = count($listReports->rep_id);

if ($comptListReports != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings["name"], 1 => $strings["created"]), "false");

    for ($i = 0;$i < $comptListReports;$i++) {
        $block1->openRow($listReports->rep_id[$i]);
        $block1->checkboxRow($listReports->rep_id[$i]);
        $block1->cellRow(buildLink("../reports/resultsreport.php?id=" . $listReports->rep_id[$i], $listReports->rep_name[$i], LINK_INSIDE));
        $block1->cellRow(createDate($listReports->rep_created[$i], $_SESSION['timezoneSession']));
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
}
$block1->closeFormResults();
$block1->block_close();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../reports/createreport.php?", "true,true,true", $strings["add"]);
$block1->paletteScript(1, "remove", "../reports/deletereports.php?", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListReports, $listReports->rep_id);

require_once("../themes/" . THEME . "/footer.php");

?>