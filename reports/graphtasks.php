<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: graphtasks.php,v 1.4 2005/05/24 15:09:10 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

// load the jpgraph classes
require_once ('../includes/jpgraph/jpgraph.php');
require_once ('../includes/jpgraph/jpgraph_gantt.php');

$tmpquery = "WHERE id = '" . $report . "'";
$reportDetail = new request();
$reportDetail->openReports($tmpquery);
$S_ORGSEL = $reportDetail->rep_clients[0];
$S_PRJSEL = $reportDetail->rep_projects[0];
$S_ATSEL = $reportDetail->rep_members[0];
$S_STATSEL = $reportDetail->rep_status[0];
$S_PRIOSEL = $reportDetail->rep_priorities[0];
$S_SDATE = $reportDetail->rep_date_due_start[0];
$S_EDATE = $reportDetail->rep_date_due_end[0];

if ($S_SDATE == "" && $S_EDATE == "") {
    $S_DUEDATE = "ALL";
} 

// echo "$S_PRJSEL + $S_ORGSEL + $S_ATSEL + $S_STATSEL + $S_PRIOSEL + $S_SDATE + $S_EDATE";
if ($S_ORGSEL != "ALL" || $S_PRJSEL != "ALL" || $S_ATSEL != "ALL" || $S_STATSEL != "ALL" || $S_PRIOSEL != "ALL" || $S_DUEDATE != "ALL") {
    $queryStart = "WHERE (";
    if ($S_PRJSEL != "ALL" && $S_PRJSEL != "") {
        $query = "tas.project IN($S_PRJSEL)";
    } 
    if ($S_ORGSEL != "ALL" && $S_ORGSEL != "") {
        if ($query != "") {
            $query .= " AND org.id IN($S_ORGSEL)";
        } else {
            $query .= "org.id IN($S_ORGSEL)";
        } 
    } 
    if ($S_ATSEL != "ALL" && $S_ATSEL != "") {
        if ($query != "") {
            $query .= " AND tas.assigned_to IN($S_ATSEL)";
        } else {
            $query .= "tas.assigned_to IN($S_ATSEL)";
        } 
    } 
    if ($S_STATSEL != "ALL" && $S_STATSEL != "") {
        if ($query != "") {
            $query .= " AND tas.status IN($S_STATSEL)";
        } else {
            $query .= "tas.status IN($S_STATSEL)";
        } 
    } 
    if ($S_PRIOSEL != "ALL" && $S_PRIOSEL != "") {
        if ($query != "") {
            $query .= " AND tas.priority IN($S_PRIOSEL)";
        } else {
            $query .= "tas.priority IN($S_PRIOSEL)";
        } 
    } 
    if ($S_DUEDATE != "ALL" && $S_SDATE != "--") {
        if ($query != "") {
            $query .= " AND tas.due_date >= '$S_SDATE'";
        } else {
            $query .= "tas.due_date >= '$S_SDATE'";
        } 
    } 
    if ($S_DUEDATE != "ALL" && $S_EDATE != "--") {
        if ($query != "") {
            $query .= " AND tas.due_date <= '$S_EDATE'";
        } else {
            $query .= "tas.due_date <= '$S_EDATE'";
        } 
    } 

    $query .= ")";
} 

$reportDetail->rep_created[0] = createDate($reportDetail->rep_created[0], $_SESSION['timezoneSession']);

// set up the graph
$graph = new GanttGraph(0, 0, 'auto');
$graph->SetBox();
$graph->SetShadow();
$graph->SetMarginColor('gainsboro');
$graph->SetMargin(10, 30, 25, 25);

// Set the Locale if you get errors with your environment
//$graph->scale->SetDateLocale('C');

// Add title
$graph->title->Set(' ' . $strings['report'] . ': ' . $reportDetail->rep_name[0]);
$graph->title->SetFont(FF_FONT1,FS_BOLD,12);
$graph->title->SetMargin(10);
$graph->title->SetBox('linen');
$graph->title->SetShadow();

// month and week scales are always displayed
$graph->scale->month->Show(true);
$graph->scale->week->Show(true);
                                                                                                                      
// Condensed Gantt or not?
if ($_GET['base'] == true) {
    $graph->scale->year->Show(true);
    $graph->scale->day->Show(false);
    $graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAME);
} else {
    $graph->scale->year->Show(false);
    $graph->scale->day->Show(true);
    $graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR4);
}
                                                                                                                      
// week scale properties
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
$graph->scale->week->SetFont(FF_FONT0);
                                                                                                                      
// month scale properties
$graph->scale->month->SetFontColor('white');
$graph->scale->month->SetBackgroundColor('steelblue4');
                                                                                                                      
// year scale properties
$graph->scale->year->SetFontColor('white');
$graph->scale->year->SetBackgroundColor('steelblue4');

// Modify the appearance of the dividing lines
$graph->scale->divider->SetWeight(4);
$graph->scale->divider->SetColor('steelblue4');
$graph->scale->dividerh->SetWeight(1);
$graph->scale->dividerh->SetColor('black');
$graph->SetBox(true,'black',1);

// NetOffice footer, please don't remove
$graph->footer->right->Set('Created by NetOffice v' . $version . '   ');
$graph->footer->right->SetColor('gray6');
$graph->footer->right->SetFont(FF_FONT1);

// Column Titles
$graph->scale->actinfo->SetColTitles(array($strings['name'],$strings['duration']));
$graph->scale->actinfo->SetBackgroundColor('steelblue4');
$graph->scale->actinfo->SetFontColor('white');
$graph->scale->actinfo->SetFont(FF_FONT1,FS_BOLD);

// query for data
$tmpquery = "$queryStart $query ORDER BY tas.due_date";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$ms_cnt = 0;

for ($i = 0; $i < $comptListTasks; $i++) {
    $listTasks->tas_name[$i] = str_replace('&quot;', '"', $listTasks->tas_name[$i]);
    $listTasks->tas_name[$i] = str_replace("&#39;", "'", $listTasks->tas_name[$i]);
    #$listTasks->tas_pro_name[$i] = str_replace('&quot;', '"', $listTasks->tas_pro_name[$i]);
    #$listTasks->tas_pro_name[$i] = str_replace("&#39;", "'", $listTasks->tas_pro_name[$i]);
    $progress = round($listTasks->tas_completion[$i] / 10, 2);
    $printProgress = $listTasks->tas_completion[$i] * 10;

    // get the duration in days for this task
    $duration = diff_date($listTasks->tas_due_date[$i], $listTasks->tas_start_date[$i]);

    if ($duration > 1) {
        $duration_label = sprintf("%s %s", $duration, $strings['days']);
    } else {
        $duration_label = sprintf("%s %s", $duration, $strings['day']);
    }

    // build an activity bar
    if ($listTasks->tas_milestone[$i] != '0') {
        $activity = new GanttBar(
                            $i, 
                            #array($listTasks->tas_pro_name[$i], $listTasks->tas_name[$i], $duration_label), 
                            array($listTasks->tas_name[$i], $duration_label), 
                            $listTasks->tas_start_date[$i], 
                            $listTasks->tas_due_date[$i]
                        );

        switch ($listTasks->tas_status[$i]) {
            case 0:
                $pattern = 'steelblue'; // client completed
                break;
            case 1:
                $pattern = 'blue'; // Completed
                break;
            case 2:
                $pattern = 'orange'; // Not Started
                break;
            case 3:
                $pattern = 'green'; // Open
                break;
            case 4:
                $pattern = 'yellow'; // Suspended
                break;
            default:
                $pattern = 'yellow'; // default color
        }

        $activity->SetPattern(BAND_RDIAG, $pattern);

        $activity->caption->Set($listTasks->tas_mem_login[$i] . ' (' . $printProgress . '%)');
        $activity->caption->SetFont(FF_FONT0);
        $activity->SetFillColor($pattern);

        if ($listTasks->tas_priority[$i] == 4 || $listTasks->tas_priority[$i] == 5) {
            $activity->progress->SetPattern(BAND_SOLID, 'red');
        } else {
            $activity->progress->SetPattern(BAND_SOLID, 'darkred');
        }

        $activity->progress->Set($progress);
        $graph->Add($activity);
    } else {
        // build a milestone
        $ms_cnt++;
        $ms = new MileStone($i, $listTasks->tas_name[$i], $listTasks->tas_start_date[$i], 'M' . $ms_cnt);
        $ms->title->SetFont(FF_FONT1,FS_BOLD);
        $ms->title->SetColor('darkred');
        $graph->Add($ms);
    }
} 

$graph->Stroke();

?>