<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * Author: Michael Cook <michael@ink.org>
 * Date:   07-14-2003
 * 
 * $Id: overdue.php,v 1.8 2005/06/08 06:49:52 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/overdue.php
 * 
 * show tasks which are overdue
 */


/*
NOTE: !!!!!
- we have some weird intermix between two blocks here.
- this might lead to potential errors and should be fixed

*/


// configuration options
// today's date
$datenow = date("Y-m-d");
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
$block1->openForm("../reports/overdue.php#" . $block1->form . "Anchor");
$block1->openContent();

$block1->sorting("home_tasks", $sortingUser->sor_home_tasks[0], "tas.priority DESC", $sortingFields = array(0 => "tas.name", 1 => "pro.name", 2 => "tas.status", 3 => "tas.completion", 4 => "tas.due_date", 5 => "mem.login", 6 => "tas.priority"));

$query = " WHERE tas.status > 1 and (tas.due_date < '$datenow' AND tas.due_date <> '--')";
$tmpquery = "$query ORDER BY $block1->sortingValue";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$block0 = new block();

$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListTasks == "0") {
    $block0->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
}

if ($comptListTasks == "1") {
    $block0->contentRow("", "1 " . $strings["match"]);
}

if ($comptListTasks > "1") {
    $block0->contentRow("", $comptListTasks . " " . $strings["matches"]);
}

$block0->closeContent();

// set up the header string
$block1->headingForm($strings['reportsoverdue']. ': ' . ($comptListTasks == 1 ? "$comptListTasks $strings[match]" : "$comptListTasks $strings[matches]"));

if ($comptListTasks != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["task"], 1 => $strings["project"], 2 => $strings["status"], 3 => $strings["completion"], 4 => $strings["due_date"], 5 => $strings["assigned_to"], 6 => $strings["priority"]), "true");

    for ($i = 0;$i < $comptListTasks;$i++) {
        if ($listTasks->tas_due_date[$i] == "") {
            $listTasks->tas_due_date[$i] = $strings["none"];
        }

        $idStatus = $listTasks->tas_status[$i];
        $idPriority = $listTasks->tas_priority[$i];
        $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . "0 %": $listTasks->tas_completion[$i] . " %";
        $block1->openRow();
        $block1->checkboxRow($listTasks->tas_id[$i], $checkbox = "false");
        $block1->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE));
        $block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listTasks->tas_project[$i], $listTasks->tas_pro_name[$i], LINK_INSIDE));
        $block1->cellRow($status[$idStatus]);
        $block1->cellRow($complValue);
        $block1->cellRow($listTasks->tas_due_date[$i]);

        if ($listTasks->tas_assigned_to[$i] == "0") {
            $block1->cellRow($strings["unassigned"]);
        } else {
            $block1->cellRow(buildLink($listTasks->tas_mem_email_work[$i], $listTasks->tas_mem_login[$i], LINK_MAIL));
        }

        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);
        $block1->closeRow();
    }

    $block1->closeResults();
}
else {
    $block1->noresults();
}
// close block1
$block1->closeFormResults();
$block1->block_close();


require_once("../themes/" . THEME . "/footer.php");

?>
