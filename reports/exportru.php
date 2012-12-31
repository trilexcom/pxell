<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: exportru.php,v 1.2 2004/12/12 20:31:58 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// configuration options
// set up the member selection
if ($_GET['S_ATSEL']) {
    if ($_GET['S_ATSEL'] == 'ALL') {
        $S_mem = "ALL";
    } else {
        $S_mem = implode (',', $_GET['S_ATSEL']);
    } 
} else {
    $S_mem = "ALL";
} 
// a date range was selected
if ($_GET{'S_COMPLETEDATE'} == 'DATERANGE') {
    $dateRange = true; 
    // get the range start date (if given)
    if ($_GET{'S_SDATE2'}) {
        $s_sdate2 = $_GET{'S_SDATE2'};
    } else {
        $s_sdate2 = date("Y-m-d",
            mktime (0, 0, 0, date("m"), "1", date("Y")));
    } 
    // get the range end date
    if ($_GET{'S_EDATE2'}) {
        $s_edate2 = $_GET{'S_EDATE2'};
    } else {
        $s_edate2 = date("Y-m-d",
            mktime (0, 0, 0, date("m"), date("d"), date("Y")));
    } 
} else {
    // select all dates
    $dateRange = false;
} 
// end of configuration
// this is the filename the 'save as' file window will bring up by default
$filename = "rusage";

$checkSession = false;
require_once("../includes/library.php");

require_once("../includes/phpmyadmin/defines.lib.php");
function which_crlf()
{
    $the_crlf = "\n"; 
    // The 'USR_OS' constant is defined in "./libraries/defines.lib.php"
    // Win case
    if (USR_OS == 'Win') {
        $the_crlf = "\r\n";
    } 
    // Mac case
    else if (USR_OS == 'Mac') {
        $the_crlf = "\r";
    } 
    // Others
    else {
        $the_crlf = "\n";
    } 

    return $the_crlf;
} 

@set_time_limit(600);
$crlf = which_crlf();

/**
 * Send headers depending on whether the user choosen to download a dump file
 * or not
 */

$reportHeader = "\"Resource Usage Detail\"" . $crlf;
if ($dateRange) {
    if ($query != "") {
        $query .= "AND (tim.date >= '$s_sdate2'  AND tim.date <= '$s_edate2')";
    } else {
        $query .= "WHERE (tim.date >= '$s_sdate2'  AND tim.date <= '$s_edate2')";
    } 
    $reportHeader = "\"Resource Usage Detail from $s_sdate2 to $s_edate2\"" . $crlf;
} 
// a member selection was made
if ($S_mem != 'ALL' && $S_mem != "") {
    if ($query != "") {
        $query .= " AND tim.owner IN($S_mem)";
    } else {
        $query .= "WHERE tim.owner IN($S_mem)";
    } 
} 

$tmpquery = "$query ORDER BY org.name,pro.name,mem.name,tim.date";
$listHours = new request();
$listHours->openTaskTime($tmpquery);
$comptListHours = count($listHours->tim_id);

$dump_buffer = $reportHeader . $crlf;

if ($comptListHours != "0") {
    /**
     * Construct the header row
     */

    $dump_buffer .= "\"" . $strings["organization"] . "\",\"" . $strings["project"] . "\",\"" . $strings["name"] . "\",\"" . $strings['hours'] . "\"" . $crlf;

    for ($i = 0;$i < $comptListHours;$i++) {
        if ($org_name != $listHours->tim_org_name[$i]) {
            // this is a new organization
            // print the totalled hours
            if ($org_name != "") {
                // print the project totals
                $dump_buffer .= "\"\",";
                $dump_buffer .= "\"\",";
                $dump_buffer .= "\"Total hours:\",";
                $nice_print = sprintf("%01.2f", $total_project_hours);
                $dump_buffer .= "\"" . $nice_print . "\",";
                $dump_buffer .= $crlf;

                $dump_buffer .= "\"\",";
                $dump_buffer .= "\"\",";
                $dump_buffer .= "\"Total for organization:\",";
                $nice_print = sprintf("%01.2f", $total_org_hours);
                $dump_buffer .= "\"" . $nice_print . "\",";
                $dump_buffer .= $crlf;
            } 
            // reset the counter
            $total_project_hours = 0;
            $project_name = $listHours->tim_pro_name[$i];
            $total_org_hours = 0;
            $org_name = $listHours->tim_org_name[$i]; 
            // print a header row
            $dump_buffer .= "\"" . $org_name . "\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= $crlf;

            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"" . $listHours->tim_pro_name[$i] . "\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= $crlf;
        } 

        if ($project_name != $listHours->tim_pro_name[$i]) {
            // this is a new project
            // print the totalled hours
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"Total hours:\",";
            $nice_print = sprintf("%01.2f", $total_project_hours);
            $dump_buffer .= "\"" . $nice_print . "\",";
            $dump_buffer .= $crlf; 
            // print a new header row
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"" . $listHours->tim_pro_name[$i] . "\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= "\"\",";
            $dump_buffer .= $crlf; 
            // reset the counter
            $total_project_hours = 0;
            $project_name = $listHours->tim_pro_name[$i];
        } 
        // display the individual member
        $dump_buffer .= "\"\",";
        $dump_buffer .= "\"\",";
        $dump_buffer .= "\"" . $listHours->tim_mem_name[$i] . "\",";
        $nice_print = sprintf("%01.2f", $listHours->tim_hours[$i]);
        $dump_buffer .= "\"" . $nice_print . "\",";
        $dump_buffer .= $crlf;

        $total_org_hours += $listHours->tim_hours[$i];
        $total_project_hours += $listHours->tim_hours[$i];
    } 
    // pick up the last straggler
    $dump_buffer .= "\"\",";
    $dump_buffer .= "\"" . $listHours->tim_pro_name[$i] . "\",";
    $dump_buffer .= "\"Total hours:\",";
    $nice_print = sprintf("%01.2f", $total_project_hours);
    $dump_buffer .= "\"" . $nice_print . "\",";
    $dump_buffer .= $crlf;

    $dump_buffer .= "\"\",";
    $dump_buffer .= "\"\",";
    $dump_buffer .= "\"Total for organization:\",";
    $nice_print = sprintf("%01.2f", $total_org_hours);
    $dump_buffer .= "\"" . $nice_print . "\",";
    $dump_buffer .= $crlf;
} 

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
