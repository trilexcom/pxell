<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: exportproject.php,v 1.2 2004/12/13 00:18:25 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = false;
require_once('../includes/library.php');

#$id = $_REQUEST['id'];
#$project = $_REQUEST['project'];

require_once('../includes/phpmyadmin/defines.lib.php');

function which_crlf()
{
    $the_crlf = "\n"; 

    // The 'USR_OS' constant is defined in "./libraries/defines.lib.php"
    if (USR_OS == 'Win') {
        // Win case
        $the_crlf = "\r\n";
    } else if (USR_OS == 'Mac') {
        // Mac case
        $the_crlf = "\r";
    } else {
        // Others
        $the_crlf = "\n";
    }

    return($the_crlf);
} 

@set_time_limit(600);
$crlf = which_crlf();

/**
 * Send headers depending on whether the user choosen to download a dump file
 * or not
 */

$tmpquery = "WHERE pro.id = '$id'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

if ($projectDetail->pro_org_id[0] == '1') {
    $projectDetail->pro_org_name[0] = $strings['none'];
}

$idStatus = $projectDetail->pro_status[0];
$idPriority = $projectDetail->pro_priority[0];
$idType = $projectDetail->pro_type[0];

$dump_buffer .= $strings['project'] . $crlf;
$dump_buffer .= '"' . $strings['name'] . '";"' . $strings['description'] . '";"' . $strings['owner'] . '";"' . $strings['priority'] . '";"' . $strings['status'] . '";"' . $strings['type'] . '";"' . $strings['created'] . '";"' . $strings['organization'] . '"' . $crlf;
$dump_buffer .= '"' . $projectDetail->pro_name[0] . '";"' . $projectDetail->pro_description[0] . '";"' . $projectDetail->pro_mem_login[0] . '";"' . $priority[$idPriority] . '";"' . $status[$idStatus] . '";"' . $projectType[$idType] . '";"' . createDate($projectDetail->pro_created[0], $_SESSION['timezoneSession']) . '";"' . $projectDetail->pro_org_name[0] . '"' . $crlf . $crlf;

$tmpquery = "WHERE tas.project = '$id'";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

if ($comptListTasks != '0') {
    $dump_buffer .= $strings['tasks'] . $crlf;
    $dump_buffer .= '"' . $strings['name'] . '";"' . $strings['description'] . '";"' . $strings['owner'] . '";"' . $strings['priority'] . '";"' . $strings['status'] . '";"' . $strings['created'] . '";"' . $strings['start_date'] . '";"' . $strings['due_date'] . '";"' . $strings['complete_date'] . '";"' . $strings['completion'] . '";"' . $strings['scope_creep'] . '";"' . $strings['estimated_time'] . '";"' . $strings['actual_time'] . '";"' . $strings['published'] . '";"' . $strings['comments'] . '";"' . $strings['assigned'] . '";"' . $strings['assigned_to'] . '"' . $crlf;

    for ($i = 0; $i < $comptListTasks; $i++) {
        if ($listTasks->tas_assigned_to[$i] == '0') {
            $listTasks->tas_mem_login[$i] = $strings['unassigned'];
        }

        // get actual time for task
        $taskActualTime = new request();
        $actual_time = $taskActualTime->getTaskTime($i);

        $idStatus = $listTasks->tas_status[$i];
        $idPriority = $listTasks->tas_priority[$i];
        $idPublish = $listTasks->tas_published[$i];
        $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . '0 %': $listTasks->tas_completion[$i] . ' %';

        if ($listTasks->tas_complete_date[$i] != '' && $listTasks->tas_complete_date[$i] != '--' && $listTasks->tas_due_date[$i] != '--') {
            $diff = diff_date($listTasks->tas_complete_date[$i], $listTasks->tas_due_date[$i]);
        } 

        $dump_buffer .= '"' . $listTasks->tas_name[$i] . '";"' . $listTasks->tas_description[$i] . '";"' . $listTasks->tas_mem2_login[$i] . '";"' . $priority[$idPriority] . '";"' . $status[$idStatus] . '";"' . createDate($listTasks->tas_created[$i], $_SESSION['timezoneSession']) . '";"' . $listTasks->tas_start_date[$i] . '";"' . $listTasks->tas_due_date[$i] . '";"' . $listTasks->tas_complete_date[$i] . '";"' . $complValue . '";"' . $diff . '";"' . $listTasks->tas_estimated_time[$i] . '";"' . $actual_time . '";"' . $statusPublish[$idPublish] . '";"' . $listTasks->tas_comments[$i] . '";"' . $listTasks->tas_assigned[$i] . '";"' . $listTasks->tas_mem_login[$i] . '"' . $crlf;
    } 
} 

$filename = $strings['project'] . $projectDetail->pro_id[0];

$ext = 'csv';
$mime_type = 'text/x-csv';

// Send headers
header('Content-Type: ' . $mime_type);

// lem9: we need "inline" instead of "attachment" for IE 5.5
$content_disp = (USR_BROWSER_AGENT == 'IE') ? 'inline' : 'attachment';

header('Content-Disposition:  ' . $content_disp . '; filename="' . $filename . '.' . $ext . '"');
header('Pragma: no-cache');
header('Expires: 0');

echo $dump_buffer;

?>
