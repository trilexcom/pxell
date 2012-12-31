<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: graphtasks.php,v 1.5 2005/05/24 15:09:10 madbear Exp $
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
require_once('../includes/jpgraph/jpgraph.php');
require_once('../includes/jpgraph/jpgraph_gantt.php');

$tmpquery = "WHERE pro.id = '" . $project . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$projectDetail->pro_created[0] = createDate($projectDetail->pro_created[0], $_SESSION['timezoneSession']);
$projectDetail->pro_name[0] = str_replace('&quot;', '"', $projectDetail->pro_name[0]);
$projectDetail->pro_name[0] = str_replace("&#39;", "'", $projectDetail->pro_name[0]);

// set up the graph
$graph = new GanttGraph(0, 0, 'auto');
$graph->SetBox();
$graph->SetShadow();
$graph->SetMarginColor('gainsboro');
$graph->SetMargin(10, 30, 25, 25);

// Set the Locale if you get errors with your environment
//$graph->scale->SetDateLocale('C');

// Add title
$graph->title->Set(' ' . $projectDetail->pro_name[0]);
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

// query for data, milestones are not publishable
$tmpquery = "WHERE tas.project = '" . $project . "' AND tas.start_date != '--' AND tas.due_date != '--' AND tas.published != '1' AND tas.milestone != '0' ORDER BY tas.due_date";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$ms_cnt = 0;

for ($i = 0; $i < $comptListTasks; $i++) {
    $listTasks->tas_name[$i] = str_replace('&quot;', '"', $listTasks->tas_name[$i]);
    $listTasks->tas_name[$i] = str_replace("&#39;", "'", $listTasks->tas_name[$i]);
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