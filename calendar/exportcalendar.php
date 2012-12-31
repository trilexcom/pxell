<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: exportcalendar.php,v 1.3 2005/06/11 20:32:09 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = false;
require_once("../includes/library.php");

$tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND cal.id = '$id'";
$detailCalendar = new request();
$detailCalendar->openCalendar($tmpquery);
$comptDetailCalendar = count($detailCalendar->cal_id);
// echo $_SESSION['idSession'] . " - $id - $comptDetailCalendar<br>";
if ($comptDetailCalendar != "0") {
    $filename = $detailCalendar->cal_subject[0] . ".ics";
    header("Content-Type: text/x-iCalendar");
    header("Content-Disposition: attachment; filename=$filename");
    // echo $filename;
    $DescDump = str_replace("\r\n", "\\n", $detailCalendar->cal_description[0]);

    $vCalStart = str_replace("-", "", $detailCalendar->cal_date_start[0]);
    $vCalEnd = str_replace("-", "", $detailCalendar->cal_date_end[0]);
} 
echo "BEGIN:VCALENDAR
PRODID:NetOffice $version
VERSION:2.0
METHOD:PUBLISH
BEGIN:VEVENT
ORGANIZER:MAILTO:" . $detailCalendar->cal_mem_email_work[0] . "
DTSTART;VALUE=DATE:$vCalStart
DTEND;VALUE=DATE:$vCalEnd 
TRANSP:OPAQUE
SEQUENCE:0
UID:040000008200E00074C5B7101A82E00800000000A03EAED7766FC2010000000000000000100
 0000056B56C3860D17B448DC0B0DB90B2BEB6
DTSTAMP:20021009T073253Z
DESCRIPTION:" . $DescDump . "
SUMMARY:" . $detailCalendar->cal_subject[0] . "
PRIORITY:5
CLASS:PUBLIC\n";
if ($detailCalendar->cal_reminder[0] == "1") {
    echo "BEGIN:VALARM
TRIGGER:PT15M
ACTION:DISPLAY
DESCRIPTION:Reminder
END:VALARM\n";
} 
echo "END:VEVENT
END:VCALENDAR";

?>
