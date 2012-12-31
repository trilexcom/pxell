<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: resource_usage.php,v 1.6 2005/05/23 06:31:21 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/resource_usage.php
 * 
 * display total hours logged in a given time frame by project and
 * organization
 * FORMAT:
 * +------------------------------------------------------------+
 * | PARTNER                                                    |
 * +----------------------------+---------------+---------------+
 * | PROJECT                    | HOURS         | FEE/NO CHARGE |
 * +----------------------------+---------------+---------------+
 * | PROJECT                    | HOURS         | FEE/NO CHARGE |
 * +----------------------------+---------------+---------------+
 * |                            | TOTAL                         |
 * +----------------------------+---------------+---------------+
 * 
 * TODO: add month/year selection
 *        enable sorting
 * #       add CSV export
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
// display itemized member hours
if ($_REQUEST['S_MEMITEM']) {
    $displayMemHourItems = true;
} else {
    $displayMemHourItems = false;
} 
// display total project hours
if ($_REQUEST['S_PROJTOTAL']) {
    $displayProjTotals = true;
} else {
    $displayProjTotals = false;
} 
// display total project hours
if ($_REQUEST['S_ORGTOTAL']) {
    $displayOrgTotals = true;
} else {
    $displayOrgTotals = false;
} 
// display total member hours for project
if ($_REQUEST['S_MEMTOTAL']) {
    $displayMemTotals = true;
} else {
    $displayMemTotals = false;
} 
// display total member hours for period
if ($_REQUEST['S_MEMPTOTAL']) {
    $displayMemPTotals = true;
} else {
    $displayMemPTotals = false;
} 
// end of configuration
$checkSession = true;
require_once("../includes/library.php");


//--- header ---
$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");


// start the first block
$block1 = new block();
$block1->form = "xwbT";
$block1->openForm("../reports/selectru.php#" . $block1->form . "Anchor");
$block1->openContent();
// $block1->sorting("task_time",$sortingUser->sor_tasks_time[0],"tim.org_name ASC",$sortingFields = array(0=>"tim.org_name",1=>"tim.pro_name",2=>"tim.mem_name",3=>"tim.pro_type",4=>"tim.svc_type",5=>"tim.hours"));
// handle date ranges, if supplied
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
// $tmpquery = "$query ORDER BY $block1->sortingValue";
$tmpquery = "$query ORDER BY org.name,pro.name,mem.name";
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

// set up the header string
$headerString = $strings['reportsusage'];
if ($dateRange) {
	$headerString .= " $strings[reports_from] $s_sdate2 $strings[reports_to] $s_edate2";
}
$headerString .= ': ' . ($comptListHours == 1 ? "$comptListHours $strings[match]" : "$comptListHours $strings[matches]");
$block1->heading($headerString);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "export", $strings["export"]);
$block1->closePaletteIcon();
$block1->openPaletteScript();

$exportOptions = "";
// handle date ranges
if ($dateRange) {
    if ($exportOptions != "") {
        $exportOptions = "&s_date2=$s_sdate2&s_edate2=$s_edate2";
    } else {
        $exportOptions = "s_date2=$s_sdate2&s_edate2=$s_edate2";
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

$block1->paletteScript(0, "export", "../reports/exportru.php?$exportOptions", "true,false,false", $strings["export"]);
$block1->closePaletteScript($comptListHours, $listHours->tim_id);
// set up an organization name placeholder
$total_project_hours = 0;
$total_org_hours = 0;
$total_mem_hours = 0;
$project_name = "";
$org_name = "";
$mem_name = "";
$grand_total_member_hours = array();

if ($comptListHours != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["organization"], 1 => $strings["project"], 2 => $strings["name"], 3 => $strings["hours"]), "true");

    for ($i = 0;$i < $comptListHours;$i++) {
        // NEW ORGANIZATION
        if ($org_name != $listHours->tim_org_name[$i]) {
            // this is a new organization
            // print the totalled hours
            if ($org_name != "") {
                // display the individual member
                if ($displayMemTotals) {
                    $nice_print = sprintf("%01.2f", $total_mem_hours);

                    $block1->openRow();
                    $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
                    $block1->cellRow("");
                    $block1->cellRow("");
                    $block1->cellRow("$mem_name");
                    $block1->cellRow("$nice_print");
                    $block1->closeRow();
                } 
                // print the project totals
                if ($displayProjTotals) {
                    $block1->openRow();
                    $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
                    $block1->cellRow("");
                    $block1->cellRow("");
                    $block1->cellRow("<b>Total project hours:</b>");
                    $nice_print = sprintf("%01.2f", $total_project_hours);
                    $block1->cellRow($nice_print);
                    $block1->closeRow();
                } 

                if ($displayOrgTotals) {
                    $block1->openRow();
                    $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
                    $block1->cellRow("");
                    $block1->cellRow("");
                    $block1->cellRow("<b>Total for organization:</b>");
                    $nice_print = sprintf("%01.2f", $total_org_hours);
                    $block1->cellRow("<b>" . $nice_print . "</b>");
                    $block1->closeRow();
                } 
            } 
            // reset the counter
            $total_project_hours = 0;
            $project_name = $listHours->tim_pro_name[$i];
            $total_org_hours = 0;
            $org_name = $listHours->tim_org_name[$i];
            $total_mem_hours = 0;
            $mem_name = $listHours->tim_mem_name[$i]; 
            // print a header row
            $block1->openRow();
            $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
            $block1->cellRow($org_name);
            $block1->cellRow("");
            $block1->cellRow("");
            $block1->cellRow("");
            $block1->closeRow();

            $block1->openRow();
            $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
            $block1->cellRow("");
            $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listHours->tim_project[$i], $listHours->tim_pro_name[$i], in));
            $block1->cellRow("");
            $block1->cellRow("");
            $block1->closeRow();
        } 
        // NEW PROJECT
        if ($project_name != $listHours->tim_pro_name[$i]) {
            // display the individual member
            if ($displayMemTotals) {
                // this is a new member
                // print the line for the other member
                $nice_print = sprintf("%01.2f", $total_mem_hours);

                $block1->openRow();
                $block1->checkboxRow($listHours->tim_id[$i],
                    $checkbox = "false");
                $block1->cellRow("");
                $block1->cellRow("");
                $block1->cellRow($mem_name);
                $block1->cellRow($nice_print);
                $block1->closeRow();
            } 
            // this is a new project
            // print the totalled hours
            if ($displayProjTotals) {
                $block1->openRow();
                $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
                $block1->cellRow("");
                $block1->cellRow("");
                $block1->cellRow("<b>Total project hours:</b>");
                $nice_print = sprintf("<b>%01.2f</b>", $total_project_hours);
                $block1->cellRow($nice_print);
                $block1->closeRow();
            } 
            // print a new header row
            $block1->openRow();
            $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
            $block1->cellRow("");
            $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listHours->tim_project[$i], $listHours->tim_pro_name[$i], in));
            $block1->cellRow("");
            $block1->cellRow("");
            $block1->closeRow(); 
            // reset the counter
            $total_project_hours = 0;
            $project_name = $listHours->tim_pro_name[$i];
            $total_mem_hours = 0;
            $mem_name = $listHours->tim_mem_name[$i];
        } 
        // NEW MEMBER
        if ($mem_name != $listHours->tim_mem_name[$i]) {
            // this is a new member
            // print the line for the other member
            if ($displayMemTotals) {
                if ($mem_name != "") {
                    $nice_print = sprintf("%01.2f", $total_mem_hours);

                    $block1->openRow();
                    $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
                    $block1->cellRow("");
                    $block1->cellRow("");
                    $block1->cellRow($mem_name);
                    $block1->cellRow($nice_print);
                    $block1->closeRow();
                } 
            } 

            $total_mem_hours = 0;
            $mem_name = $listHours->tim_mem_name[$i];
        } 
        // increment the grand total
        $grand_total_member_hours [$listHours->tim_owner[$i]] += $listHours->tim_hours[$i];

        if ($displayMemHourItems) {
            $block1->openRow();
            $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
            $block1->cellRow("");
            $block1->cellRow("");
            $block1->cellRow("<i>" . $listHours->tim_mem_name[$i] . "</i>");
            $nice_print = sprintf("%01.2f", $listHours->tim_hours[$i]);
            $block1->cellRow("<i>$nice_print</i>");
            $block1->closeRow();
        } 

        $total_mem_hours += $listHours->tim_hours[$i];
        $total_org_hours += $listHours->tim_hours[$i];
        $total_project_hours += $listHours->tim_hours[$i];
    } 
    // pick up the last straggler
    if ($displayMemTotals) {
        $nice_print = sprintf("%01.2f", $total_mem_hours);

        $block1->openRow();
        $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
        $block1->cellRow("");
        $block1->cellRow("");
        $block1->cellRow($mem_name);
        $block1->cellRow($nice_print);
        $block1->closeRow();
    } 

    if ($displayProjTotals) {
        $block1->openRow();
        $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
        $block1->cellRow("");
        $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listHours->$project_name, $listHours->tim_pro_name[$i], in));
        $block1->cellRow("<b>Total project hours:</b>");
        $nice_print = sprintf("%01.2f", $total_project_hours);
        $block1->cellRow("<b>$nice_print</b>");
        $block1->closeRow();
    } 

    if ($displayOrgTotals) {
        $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
        $block1->cellRow("");
        $block1->cellRow("");
        $block1->cellRow("<b>Total for organization:</b>");
        $nice_print = sprintf("%01.2f", $total_org_hours);
        $block1->cellRow("<b>$nice_print</b>");
        $block1->closeRow();
    } 
    // show a member total
    if ($displayMemPTotals) {
        $block1->checkboxRow($listHours->tim_id[$i], $checkbox = "false");
        $block1->cellRow("<b>Total for members:</b>");
        $block1->cellRow("");
        $block1->cellRow("");
        $block1->cellRow("");
        $block1->closeRow(); 
        // sort($grand_total_member_hours);
        foreach ($grand_total_member_hours as $mem_id => $hrs) {
            $tmpquery = "WHERE mem.id = " . $mem_id;
            $listMembers = new request();
            $listMembers->openMembers($tmpquery);

            $mem_name = "Unknown";

            if ($listMembers->mem_name[0] != "") {
                $mem_name = $listMembers->mem_name[0];
            } 

            $nice_print = sprintf("%01.2f", $hrs);
            $block1->openRow();
            $block1->checkboxRow("", $checkbox = "false");
            $block1->cellRow("");
            $block1->cellRow($mem_name . ":");
            $block1->cellRow("");
            $block1->cellRow($nice_print);
            $block1->closeRow();
        } 
    } 

    $block1->closeResults();
} else {
    $block1->noresults();
} 
// close block1
$block1->closeFormResults();

require_once("../themes/" . THEME . "/footer.php");

?>
