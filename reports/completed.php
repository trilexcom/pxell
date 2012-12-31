<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: completed.php,v 1.6 2005/05/23 06:31:21 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/completed.php
 * 
 * show completed tasks for a particular timespan
 * 
 * TODO: enable month/year selection, as well as start/end times
 */
// configuration options
// set up the member selection
if ($_POST['S_ATSEL']) {
    if ($_POST['S_ATSEL'] == 'ALL') {
        $S_mem = "ALL";
    } else {
        $S_mem = implode (',', $_POST['S_ATSEL']);
    } 
} else {
    $S_mem = "ALL";
} 
// a date range was selected
if ($_POST{'S_COMPLETEDATE'} == 'DATERANGE') {
    $daterange = true; 
    // get the range start date (if given)
    if ($_POST{'S_SDATE2'}) {
        $s_sdate2 = $_POST{'S_SDATE2'};
    } else {
        $s_sdate2 = date("Y-m-d",
            mktime (0, 0, 0, date("m"), "1", date("Y")));
    } 
    // get the range end date
    if ($_POST{'S_EDATE2'}) {
        $s_edate2 = $_POST{'S_EDATE2'};
    } else {
        $s_edate2 = date("Y-m-d",
            mktime (0, 0, 0, date("m"), date("d"), date("Y")));
    } 
} else {
    // select all dates
    $daterange = false;
} 
// end of configuration
$checkSession = true;
require_once("../includes/library.php");

//--- header ---
$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], LINK_INSIDE) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

//--- content ----
// start the first block
$block1 = new block();
$block1->form = "xwbT";
$block1->openForm("../reports/completed.php#" . $block1->form . "Anchor");
$block1->openContent();

$block1->sorting("tasks", $sortingUser->sor_tasks[0], "tas.name ASC", $sortingFields = array(0 => "mem.login", 1 => "tas.name", 2 => "tas.project", 3 => "tas.complete_date"));
$query = " WHERE tas.status = 1 ";
// a date range was selected
if ($daterange) {
    $query .= "AND (tas.complete_date < '$s_edate2'  AND tas.complete_date > '$s_sdate2')";
}
// a member selection was made
if ($S_mem != "ALL" && $S_mem != "") {
    if ($query != "") {
        $query .= " AND tas.assigned_to IN($S_mem)";
    } else {
        $query .= "tas.assigned_to IN($S_mem)";
    }
}

$tmpquery = "$query ORDER BY $block1->sortingValue";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$block0 = new block();

$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListTasks == "0") {
    $block1->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
}

if ($comptListTasks == "1") {
    $block1->contentRow("", "1 " . $strings["match"]);
}

if ($comptListTasks > "1") {
    $block1->contentRow("", $comptListTasks . " " . $strings["matches"]);
}

$block0->closeContent();


// set up the header string
$headerString = $strings['reportscompleted'];

if ($daterange) {
    $headerString .= " $strings[reports_from] $s_sdate2 $strings[reports_to] $s_edate2";
}
$headerString .= ': ' . ($comptListTasks == 1 ? "$comptListTasks $strings[match]" : "$comptListTasks $strings[matches]");

$block1->heading($headerString);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "export", $strings["export"]);
$block1->closePaletteIcon();

if ($comptListTasks != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["assigned_to"], 1 => $strings["task"], 2 => $strings["project"], 3 => $strings["complete_date"],), "false");

    for ($i = 0;$i < $comptListTasks;$i++) {
        $block1->openRow();
        $block1->checkboxRow($listTasks->tas_id[$i], $checkbox = "false");

        if ($listTasks->tas_assigned_to[$i] == "0") {
            $block1->cellRow($strings["unassigned"]);
        } else {
            $block1->cellRow(buildLink($listTasks->tas_mem_email_work[$i], $listTasks->tas_mem_login[$i], LINK_MAIL));
        }

        $block1->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE));
        $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listTasks->tas_project[$i], $listTasks->tas_pro_name[$i], LINK_INSIDE));
        $block1->cellRow($listTasks->tas_complete_date[$i]);
        $block1->closeRow();
    }

    $block1->closeResults();
} else {
    $block1->noresults();
}

$block1->closeFormResults();
$block1->openPaletteScript();
$block1->paletteScript(0, "export", "../reports/exportcompleted.php?s_date2=$s_date2&", "true,false,false", $strings["export"]);
$block1->closePaletteScript($comptListOrganizations, $listOrganizations->org_id);

// close this block
require_once("../themes/" . THEME . "/footer.php");

?>
