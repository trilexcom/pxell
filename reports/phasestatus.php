<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: phasestatus.php,v 1.6 2005/06/08 06:49:52 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/phasestatus.php
 * 
 * show a basic overview of all active projects and their phases
 */

$checkSession = true;
require_once("../includes/library.php");


$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");

$blockPage= new block();


// These are considered active project status numbers
// 0 = Client Completed (not a closed project still active)
// 2 = Not Started (in the pipe sort of speak)
// 3 = Open (an open project)
$query = "WHERE pro.status IN (0,2,3) AND pro.phase_set != 0";
$tmpquery = "$query ORDER BY pro.name";
$listProjects = new request();
$listProjects->openProjects($tmpquery);
$comptListProjects = count($listProjects->pro_id);
// show the nice number-of-results header
$block0 = new block();
$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListProjects == "0") {
    $blockPage->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
} 

if ($comptListProjects == "1") {
    $blockPage->contentRow("", "1 " . $strings["match"]);
} 

if ($comptListProjects > "1") {
    $blockPage->contentRow("", $comptListProjects . " " . $strings["matches"]);
} 

$block0->closeContent();

if ($comptListProjects != "0") {
    for ($j = 0;$j < $comptListProjects;$j++) {
        $projectTitle = $listProjects->pro_name[$j];
        $projectId = $listProjects->pro_id[$j];
        $projectPriority = $listProjects->pro_priority[$j];

        $blockProject = new block();
        $blockProject->headingForm(buildLink("../projects/viewproject.php?id=" . $projectId, $projectTitle, LINK_INSIDE));
//         $blockProject->openContent();

        $queryPhase = "WHERE pha.project_id = '$projectId' ";
        $queryPhase .= "ORDER BY pha.order_num";

        $listPhases = new request();
        $listPhases->openPhases($queryPhase);
        $comptListPhases = count($listPhases->pha_id);

        $blockProject->openResults($checkbox = "false");
        // $blockProject->labels($labels = array(0=>$strings["phase"],1=>$strings["status"],2=>$strings["total_tasks"],3=>$strings["uncomplete_tasks"],4=>$strings["date_start"],5=>$strings["date_end"],6=>$strings['completion']),"true");
        $blockProject->labels($labels = array(0 => $strings["phase"], 1 => $strings["status"], 2 => $strings["total_tasks"], 3 => $strings["uncomplete_tasks"], 4 => $strings["date_start"], 5 => $strings["date_end"]), "true");

        if ($comptListProjects != "0") {
            for ($i = 0;$i < $comptListPhases;$i++) {
                $phaseNum = $listPhases->pha_order_num[$i];
                $phaseName = $listPhases->pha_name[$i];
                $phaseStart = $listPhases->pha_date_start[$i];
                $phaseEnd = $listPhases->pha_date_end[$i];

                $tmpquery = "WHERE tas.project = '$projectId' ";
                $tmpquery .= "AND tas.parent_phase = '$phaseNum'";
                $countPhaseTasks = new request();
                $countPhaseTasks->openTasks($tmpquery);
                $comptlistTasks = count($countPhaseTasks->tas_id);

                $comptlistTasksRow = "0";
                $comptUncompleteTasks = "0";
                $phaseCompleted = 0;

                for ($k = 0;$k < $comptlistTasks;$k++) {
                    if ($phaseNum == $countPhaseTasks->tas_parent_phase[$k]) {
                        $comptlistTasksRow = $comptlistTasksRow + 1;
                        if ($countPhaseTasks->tas_status[$k] == "2" || $countPhaseTasks->tas_status[$k] == "3" || $countPhaseTasks->tas_status[$k] == "4") {
                            $comptUncompleteTasks = $comptUncompleteTasks + 1;
                        } 
                    } 

                    if ($countPhaseTasks->tas_start_date[$k] != "--" and
                        $countPhaseTasks->tas_start_date[$k] != "") {
                        if ($phaseStart == "--" or $phaseStart == "") {
                            $phaseStart = $countPhaseTasks->tas_start_date[$k];
                        } 
                        if ($phaseStart > $countPhaseTasks->tas_start_date[$k]) {
                            $phaseStart = $countPhaseTasks->tas_start_date[$k];
                        } 
                    } 

                    if ($countPhaseTasks->tas_due_date[$k] != "--" and
                        $countPhaseTasks->tas_due_date[$k] != "") {
                        if ($phaseEnd == "--" or $phaseStart == "") {
                            $phaseEnd = $countPhaseTasks->tas_due_date[$k];
                        } 
                        if ($phaseEnd > $countPhaseTasks->tas_due_date[$k]) {
                            $phaseEnd = $countPhaseTasks->tas_due_date[$k];
                        } 
                    } 
                    // determine overall completion of phase
                    $phaseCompleted += $countPhaseTasks->tas_completion[$k];
                } 
                // calculate overall percentage completion for all task(s) within this phase
                if ($phaseCompleted > 0) {
                    $phaseCompletion = ($phaseCompleted * 10) / $comptlistTasksRow;
                    $phaseCompletion = number_format($phaseCompletion, 0, '.', '') . ' %';
                } else {
                    $phaseCompletion = '0 %';
                } 

                /**
                 * determine phase start and end dates by finding the
                 * earliest start times and latest end times for
                 * member tasks
                 */

                /**
                 * start task
                 */

                if ($phaseStart == "--" or $phaseStart == "") {
                    $phaseStart = $strings["none"];
                } 

                if ($phaseEnd == "--" or $phaseEnd == "") {
                    $phaseEnd = $strings["none"];
                } 

                $blockProject->openRow();
                $blockProject->checkboxRow($phaseID, $checkbox = "false");
                $blockProject->cellRow(buildLink("../phases/viewphase.php?id=" . $listPhases->pha_id[$i], $phaseName, LINK_INSIDE));
                $blockProject->cellRow($phaseStatus[$listPhases->pha_status[$i]]);
                $blockProject->cellRow($comptlistTasksRow);
                $blockProject->cellRow($comptUncompleteTasks);
                $blockProject->cellRow($phaseStart);
                $blockProject->cellRow($phaseEnd);
                // $blockProject->cellRow($phaseCompletion);
                $blockProject->closeRow();
            } 
        } else {
            // no tasks for project
        } 

        $blockProject->closeResults();
	$blockProject->heading_close();
        print "<p><br></p>";
    } 
//    $blockProject->closeContent();
	$blockProject->block_close();
} else {
    // $block1->noresults();
} 
// $block1->closeContent();


require_once("../themes/" . THEME . "/footer.php");

?>
