<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: projectbreakdown.php,v 1.5 2005/05/23 06:31:21 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/projectbreakdown.php
 * 
 * list projects by manager
 * 
 * TODO: add export to CSV capabilities
 */
// configuration options
// end of configuration
$checkSession = true;
require_once("../includes/library.php");

$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

// start the first block
$block1 = new block();
$block1->form = "xwbT";
$block1->openForm("../reports/projectbreakdown.php#" . $block1->form . "Anchor");
$block1->openContent();

$block1->sorting("projects", $sortingUser->sor_projects[0], "mem.name ASC", $sortingFields = array(0 => "mem.name", 1 => "pro.name", 2 => "org.name", 3 => "pro.status"));
// $query = " WHERE pro.status = 1 ";
$tmpquery = "$query ORDER BY $block1->sortingValue";
// $tmpquery = $query;
$listProjects = new request();
$listProjects->openProjects($tmpquery);
$comptListProjects = count($listProjects->pro_id);

$block0 = new block();

$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListProjects == "0") {
    $block1->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
}

if ($comptListProjects == "1") {
    $block1->contentRow("", "1 " . $strings["match"]);
}

if ($comptListProjects > "1") {
    $block1->contentRow("", $comptListProjects . " " . $strings["matches"]);
}

$block0->closeContent();

/*
$block1->openPaletteIcon();
$block1->paletteIcon(0,"export",$strings["export"]);
$block1->closePaletteIcon();

$block1->openPaletteScript();
$block1->paletteScript(0,"export","../reports/exportcompleted.php?s_date2=$s_date2&","true,false,false",$strings["export"]);
$block1->closePaletteScript($comptListOrganizations,$listOrganizations->org_id);
*/
// set up the header string
$headerString = $strings['project_breakdown'];
$headerString .= ': ' . ($comptListProjects == 1 ? "$comptListProjects $strings[match]" : "$comptListProjects $strings[matches]");

$block1->heading($headerString);
$block1->heading_close();

if ($comptListProjects != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["owner"], 1 => $strings["project"], 2 => $strings["organization"], 3 => $strings["status"],), "false");

    for ($i = 0;$i < $comptListProjects;$i++) {
        $idStatus = $listProjects->pro_status[$i];
        $block1->openRow();
        $block1->checkboxRow($listProjects->pro_id[$i], $checkbox = "false");

        if ($listProjects->pro_owner[$i] == "0") {
            $block1->cellRow($strings["unassigned"]);
        } else {
            $block1->cellRow(buildLink($listProjects->pro_mem_email_work[$i], $listProjects->pro_mem_name[$i], LINK_MAIL));
        }

        $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listProjects->pro_id[$i], $listProjects->pro_name[$i], LINK_INSIDE));
        $block1->cellRow(buildLink("../clients/viewclient.php?id=" . $listProjects->pro_org_id[$i], $listProjects->pro_org_name[$i], LINK_INSIDE));
        // $block1->cellRow($listProjects->pro_status[$i]);
        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);
        $block1->closeRow();
    }

    $block1->closeResults();
} else {
    $block1->noresults();
} 

$block1->closeFormResults(); 
// close this block
require_once("../themes/" . THEME . "/footer.php");

?>
