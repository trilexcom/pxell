<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: exportcompleted.php,v 1.2 2004/12/12 20:31:58 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// get the configured information
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
    $daterange = true; 
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
    $daterange = false;
} 
// this is the filename the 'save as' file window will bring up by default
$filename = "completed";

$export = "true";

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

$query = " WHERE tas.status = 1 ";

$headerText = "Completed tasks";
// a date range was selected
if ($daterange) {
    $query .= "AND (tas.complete_date < '$s_edate2'  AND tas.complete_date > '$s_sdate2')";
    $headerText .= " from $s_sdate2 to $s_edate2";
} 
// a member selection was made
if ($S_mem != "ALL" && $S_mem != "") {
    if ($query != "") {
        $query .= " AND tas.assigned_to IN($S_mem)";
    } else {
        $query .= "tas.assigned_to IN($S_mem)";
    } 
} 

$tmpquery = "$query";
// echo "<b>$query</b><br/>\n";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

$dump_buffer = "\"$headerText\"" . $crlf;

if ($comptListTasks != "0") {
    /**
     * Construct the header row
     */

    $dump_buffer .= "\"" . $strings["assigned_to"] . "\",\"" . $strings["task"] . "\",\"" . $strings["project"] . "\",\"" . $strings["complete_date"] . "\"" . $crlf;

    for ($i = 0;$i < $comptListTasks;$i++) {
        /**
         * The individual fields
         */
        // member name
        $dump_buffer .= "\"" . $listTasks->tas_mem_login[$i] . "\","; 
        // task name
        $dump_buffer .= "\"" . $listTasks->tas_name[$i] . "\","; 
        // project name
        $dump_buffer .= "\"" . $listTasks->tas_pro_name[$i] . "\","; 
        // complete date
        $dump_buffer .= "\"" . $listTasks->tas_complete_date[$i] . "\"";
        $dump_buffer .= $crlf;
    } 
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
