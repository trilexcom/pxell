<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: hours.php,v 1.8 2005/06/08 06:49:52 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/hours.php
 * 
 * show hours logged
 * 
 * TODO: add month/year selection
 *        enable sorting
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
// limit to certain client organization
if ($_POST["S_ORSEL"]) {
	if ($_POST["S_ORSEL"] == "ALL") {
		$S_org = "ALL";
	} else {
		$S_org = implode(',', $_POST["S_ORSEL"]);
	}
} else {
	$S_org = "ALL";
}
// a date range was selected
if ($_POST{'S_COMPLETEDATE'} == 'DATERANGE') {
    $dateRange = true; 
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
    $dateRange = false;
} 
// end of configuration
$checkSession = true;
require_once("../includes/library.php");

//--- header ---
$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

//---- content ----
$block1 = new block();
$block1->form = "xwbT";
$block1->openForm("../reports/hours.php#" . $block1->form . "Anchor");
$block1->openContent();
// $block1->sorting("task_time",$sortingUser->sor_tasks_time[0],"tim.org_name ASC",$sortingFields = array(0=>"tim.org_name",1=>"tim.pro_name",2=>"tim.mem_name",3=>"tim.pro_type",4=>"tim.svc_type",5=>"tim.hours"));
// $query = " WHERE tim.date like '$reportDate%' ";
// $tmpquery = "$query ORDER BY $block1->sortingValue";
// a date range was selected
if ($dateRange) {
    if ($query != "") {
        $query .= "AND (tim.date <= '$s_edate2'  AND tim.date >= '$s_sdate2')";
    } else {
        $query .= "WHERE (tim.date <= '$s_edate2'  AND tim.date >= '$s_sdate2')";
    }
}
// a member selection was made
if ($S_mem != 'ALL' && $S_mem != "") {
    if ($query != "") {
        $query .= " AND tim.owner IN($S_mem)";
    } else {
        $query .= "WHERE tim.owner IN($S_mem)";
    }
}
// limit to certain client organization
if ($S_org != "ALL" && $S_org != "") {
	if ($query != "") {
		$query .= " AND org.id IN ($S_org)";
	} else {
		$query .= "WHERE org.id IN($S_org)";
	}
}

$tmpquery = "$query ORDER BY org.name,pro.name,mem.name,tim.date";
$listHours = new request();
$listHours->openTaskTime($tmpquery);
$comptListHours = count($listHours->tim_id);

$block0 = new block();

$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListHours == "0") {
    $block1->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
}

if ($comptListHours == "1") {
    $block1->contentRow("", "1 " . $strings["match"]);
}

if ($comptListHours > "1") {
    $block1->contentRow("", $comptListHours . " " . $strings["matches"]);
}

$block0->closeContent();

$heading_text = $strings['reporthours'];
if ($s_sdate2 != "") {
	$heading_text = "$heading_text $strings[reports_from] $s_sdate2 $strings[reports_to] $s_edate2";
}
$heading_text = $heading_text . ': ' . ($comptListHours == 1 ? "$comptListHours $strings[match]" : "$comptListHours $strings[matches]");
// set up the header string
$block1->heading($heading_text);
// initialize counters
$totalMemHours = 0;

$block1->openPaletteIcon();
$block1->paletteIcon(0, "export", $strings["export"]);
$block1->closePaletteIcon();


if ($comptListHours != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["organization"], 1 => $strings["project"], 2 => $strings["name"], 3 => $strings["date"], 4 => $strings["type"], 5 => $strings["service"], 6 => $strings["hours"]), "true");

    for ($i = 0;$i < $comptListHours;$i++) {
        $block1->openRow();
        $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
        $block1->cellRow($listHours->tim_org_name[$i]);
        $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listHours->tim_project[$i], $listHours->tim_pro_name[$i], LINK_INSIDE));
        $block1->cellRow($listHours->tim_mem_name[$i]);
        $block1->cellRow($listHours->tim_date[$i]);
        $block1->cellRow($projectType[$listHours->tim_pro_type[$i]]);
        // $block1->contentRow($strings["type"],$projectType[$projectDetail->pro_type[0]]);
        $block1->cellRow($listHours->tim_svc_name[$i]);
        $block1->cellRow($listHours->tim_hours[$i]);
        $block1->closeRow();
        // add to total hours
        $totalMemHours += $listHours->tim_hours[$i];
    }
    // print the totals
    $block1->openRow();
    $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
    $block1->cellRow("");
    $block1->cellRow("");
    $block1->cellRow("");
    $block1->cellRow("");
	$block1->cellRow("");
    $block1->cellRow("$strings[total]:");
    $block1->cellRow($totalMemHours);
    $block1->closeRow();

    $block1->closeResults();
} else {
    $block1->noresults();
}
// close block1
$block1->closeFormResults();
$block1->block_close();
$block1->openPaletteScript();

$exportOptions = "";
// handle date ranges
if ($dateRange) {
    if ($exportOptions != "") {
        $exportOptions = "&S_COMPLETEDATE=DATERANGE&S_SDATE2=$s_sdate2&S_EDATE2=$s_edate2";
    } else {
        $exportOptions = "S_COMPLETEDATE=DATERANGE&S_SDATE2=$s_sdate2&S_EDATE2=$s_edate2";
    }
}
// a member selection was made
if ($S_mem != 'ALL' && $S_mem != "") {
    if ($exportOptions != "") {
        $exportOptions .= "&S_mem=$S_mem";
    } else {
        $exportOptions .= "S_mem=$S_mem";
    }
}

$block1->paletteScript(0, "export", "../reports/exporthours.php?$exportOptions", "true,false,false", $strings["export"]);
$block1->closePaletteScript($comptListHours, $listHours->tim_id);

require_once("../themes/" . THEME . "/footer.php");

?>
