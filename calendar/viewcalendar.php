<?php // $Revision: 1.11 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewcalendar.php,v 1.11 2005/05/18 03:47:13 vjack Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

function _dayOfWeek($timestamp)
{
    return intval(strftime("%w", $timestamp) + 1);
} 

$year = date("Y");
$month = date("n");
$day = date("j");
if (strlen($month) == 1) {
    $month = "0$month";
} 
if (strlen($day) == 1) {
    $day = "0$day";
} 
$dateToday = "$year-$month-$day";

$tmpquery = " WHERE id='" . $_SESSION['idSession'] . "'";
$sortingDetail = new request();
$sortingDetail->openSorting($tmpquery);
if ($sortingDetail->sor_calendar_view[0] == NULL) {
    $lastDateCalend = $dateToday;
    $lastViewCalend = "0";
} else {
    $lastDateCalend = substr($sortingDetail->sor_calendar_view[0], 0, 10);
    $lastViewCalend = trim(substr($sortingDetail->sor_calendar_view[0], 10));
}

if ($type == "") {
    $type = "monthPreview";
    if ($sortingDetail->sor_calendar_view[0] == NULL) {
        $viewCalend = "0";
    } else {
        $viewCalend = $lastViewCalend;
    }
} else if ($type == "monthPreview" && $viewCalend == "") {
    $viewCalend = $S_VIEW;
} 

if ($dateCalend == "") {
    if ($sortingDetail->sor_calendar_view[0] == NULL) {
        $dateCalend = $dateToday;
    } else {
        $dateCalend = $lastDateCalend;
    }
} 
$year = substr("$dateCalend", 0, 4);
$month = substr("$dateCalend", 5, 2);
$day = substr("$dateCalend", 8, 2);

if ($type == "monthPreview" && ($lastDateCalend != $dateCalend || $lastViewCalend != $viewCalend)) {
    $newCalendarView = $dateCalend . $viewCalend;
    $tmpquery = "UPDATE " . $tableCollab["sorting"] . " set calendar_view='$newCalendarView' WHERE id='" . $_SESSION['idSession'] . "'";
    connectSql("$tmpquery") ;
}

if ($viewCalend != 0) {
    $tmpquery = " WHERE tea.project='$viewCalend'";
    $listTeam = new request();
    $listTeam->openTeams($tmpquery);
}

$yearDay = date("Y");
$monthDay = date("n");
$dayDay = date("d");

$dayName = date("w", mktime(0, 0, 0, $month, $day, $year));
$monthName = date("n", mktime(0, 0, 0, $month, $day, $year));
$dayName = $dayNameArray[$dayName];
$monthName = $monthNameArray[$monthName];

$daysmonth = date("t", mktime(0, 0, 0, $month, $day, $year));
$firstday = date("w", mktime(0, 0, 0, $month, 1, $year));
$padmonth = date("m", mktime(0, 0, 0, $month, $day, $year));
$padday = date("d", mktime(0, 0, 0, $month, $day, $year));

if ($firstday == 0) {
    $firstday = 7;
} 

if ($type == "calendEdit") {
    if ($action == "update") {
        if ($recurring == "") {
            $recurring = "0";
        } else {
            $dateStart_A = substr("$dateStart", 0, 4);
            $dateStart_M = substr("$dateStart", 5, 2);
            $dateStart_J = substr("$dateStart", 8, 2);
            $dayRecurr = _dayOfWeek(mktime(12, 12, 12, $dateStart_M, $dateStart_J, $dateStart_A));
        } 
        $subject = convertData($subject);
        $description = convertData($description);
        $tmpquery = "UPDATE " . $tableCollab["calendar"] . " SET subject='$subject',description='$description',shortname='$shortname',date_start='$dateStart',date_end='$dateEnd',time_start='$time_start',time_end='$time_end',reminder='$reminder',recurring='$recurring',recur_day='$dayRecurr' WHERE id = '$dateEnreg'";
        connectSql("$tmpquery");
        header("Location: ../calendar/viewcalendar.php?viewCalend=$viewCalend&dateEnreg=$dateEnreg&dateCalend=$dateCalend&type=calendDetail&msg=update");
        exit;
    } 
    if ($action == "add") {
        if ($shortname == "") {
            $error = $strings["blank_fields"];
        } else {
            if ($recurring == "") {
                $recurring = "0";
            } else {
                $dateStart_A = substr("$dateStart", 0, 4);
                $dateStart_M = substr("$dateStart", 5, 2);
                $dateStart_J = substr("$dateStart", 8, 2);
                $dayRecurr = _dayOfWeek(mktime(12, 12, 12, $dateStart_M, $dateStart_J, $dateStart_A));
            } 
            $subject = convertData($subject);
            $description = convertData($description);
            $shortname = convertData($shortname);
            if ($viewCalend == 0) {
                $tmpquery = "INSERT INTO " . $tableCollab["calendar"] . "(owner,subject,description,shortname,date_start,date_end,time_start,time_end,reminder,recurring,recur_day) VALUES('" . $_SESSION['idSession'] . "','$subject','$description','$shortname','$dateStart','$dateEnd','$time_start','$time_end','$reminder','$recurring','$dayRecurr')";
            } else {
                $tmpquery = "INSERT INTO " . $tableCollab["calendar"] . "(project,subject,description,shortname,date_start,date_end,time_start,time_end,reminder,recurring,recur_day) VALUES('$viewCalend','$subject','$description','$shortname','$dateStart','$dateEnd','$time_start','$time_end','$reminder','$recurring','$dayRecurr')";
            }
            connectSql("$tmpquery");
            $tmpquery = $tableCollab["calendar"];
            last_id($tmpquery);
            $num = $lastId[0];
            unset($lastId);
            header("Location: ../calendar/viewcalendar.php?viewCalend=$viewCalend&dateEnreg=$num&dateCalend=$dateCalend&type=calendDetail&msg=add&");
            exit;
        } 
    } 
} 

if ($type == "calendEdit") {
    if ($dateEnreg == "" && $id != "") {
        $dateEnreg = $id;
    } 
    if ($id != "") {
        if ($viewCalend == 0) {
            $tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND cal.id = '$dateEnreg'";
        } else {
            $tmpquery = "WHERE cal.project = '$viewCalend' AND cal.id = '$dateEnreg'";
        }
        $detailCalendar = new request();
        $detailCalendar->openCalendar($tmpquery);
        $comptDetailCalendar = count($detailCalendar->cal_id);
        if ($comptDetailCalendar == "0") {
            header('Location: ../calendar/viewcalendar.php');
            exit;
        } 
    } 
} 

if ($type == "calendDetail") {
    if ($dateEnreg == "" && $id != "") {
        $dateEnreg = $id;
    } 
    if ($viewCalend == 0) {
        $tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND cal.id = '$dateEnreg'";
    } else {
        $tmpquery = "WHERE cal.project = '$viewCalend' AND cal.id = '$dateEnreg'";
    }
    $detailCalendar = new request();
    $detailCalendar->openCalendar($tmpquery);
    $comptDetailCalendar = count($detailCalendar->cal_id);
    if ($comptDetailCalendar == "0") {
        header("Location: ../calendar/viewcalendar.php");
        exit;
    } 
} 

if ($type == "calendEdit") {
    $bodyCommand = "onLoad=\"document.calendForm.subject.focus();\"";
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?type=monthPreview", $strings["calendar"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=monthPreview&amp;dateCalend=$dateCalend", "$monthName $year", LINK_INSIDE);
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=dayList&amp;dateCalend=$dateCalend", "$dayName $day $monthName $year", LINK_INSIDE);
} 


if ($type == "calendEdit") {
    if ($id != "") {
        $subject = $detailCalendar->cal_subject[0];
        $description = $detailCalendar->cal_description[0];
        $shortname = $detailCalendar->cal_shortname[0];
        $date_start = $detailCalendar->cal_date_start[0];
        $date_end = $detailCalendar->cal_date_end[0];
        $time_start = $detailCalendar->cal_time_start[0];
        $time_end = $detailCalendar->cal_time_end[0];
        $reminder = $detailCalendar->cal_reminder[0];
        $recurring = $detailCalendar->cal_recurring[0];
        if ($recurring == "1") {
            $checked2_a = "checked"; //true
        } 
        if ($reminder == "0") {
            $checked1_b = "checked"; //false
        } else {
            $checked2_b = "checked"; //true
        } 
    } else {
        $checked2_b = "checked"; //true
    } 

	//--- header -----
    if ($id != "") {
        $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=calendDetail&amp;dateCalend=$dateCalend&amp;dateEnreg=$dateEnreg", $detailCalendar->cal_shortname[0], LINK_INSIDE);
        $breadcrumbs[]=$strings["edit"];
    } else {
        $breadcrumbs[]=$strings["add"];
    } 
	$pageSection='calendar';
	require_once("../themes/" . THEME . "/header.php");

    

    $block1 = new block();

    $block1->form = "calend";
    if ($id != "") {
        $block1->openForm("../calendar/viewcalendar.php?viewCalend=$viewCalend&dateEnreg=$dateEnreg&amp;dateCalend=$dateCalend&amp;type=$type&amp;action=update#" . $block1->form . "Anchor");
    } else {
        $block1->openForm("../calendar/viewcalendar.php?viewCalend=$viewCalend&dateEnreg=$dateEnreg&amp;dateCalend=$dateCalend&amp;type=$type&amp;action=add#" . $block1->form . "Anchor");
    } 

    if ($error != "") {
        $block1->headingError($strings["errors"]);
        $block1->contentError($error);
    } 

    if ($id != "") {
        $block1->headingForm($strings["edit"] . ": " . $detailCalendar->cal_shortname[0]);
    } 
	else {
        $block1->headingForm($strings["add"] . ":");
    } 

    $block1->openContent();
    $block1->contentTitle($strings["details"]);

    if ($viewCalend != 0) {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['project'] . " :</td><td>" . $listTeam->tea_pro_name[0] . "</td></tr>";
    }

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["subject"] . " :</td><td><input size=\"24\" style=\"width: 250px;\" maxlength=\"128\" type=\"text\" name=\"subject\" value=\"$subject\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["description"] . " :</td><td><textarea style=\"width: 400px; height: 50px;\" name=\"description\" cols=\"35\" rows=\"2\">$description</textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* " . $strings["shortname"] . $template->printHelp("calendar_shortname") . " :</td><td><input size=\"24\" style=\"width: 250px;\" maxlength=\"128\" type=\"text\" name=\"shortname\" value=\"$shortname\"></td></tr>";

    if ($date_start == "") {
        $date_start = $dateCalend;
    } 
    if ($date_end == "") {
        $date_end = $dateCalend;
    } 

    $block1->contentRow($strings["date_start"], "<input type=\"text\" style=\"width: 150px;\" name=\"dateStart\" id=\"sel1\" size=\"20\" value=\"$date_start\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

    $block1->contentRow($strings["date_end"], "<input type=\"text\" style=\"width: 150px;\" name=\"dateEnd\" id=\"sel3\" size=\"20\" value=\"$date_end\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script>");

    echo "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["time_start"] . " :</td><td><input size=\"24\" style=\"width: 250px;\" maxlength=\"128\" type=\"text\" name=\"time_start\" value=\"$time_start\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["time_end"] . " :</td><td><input size=\"24\" style=\"width: 250px;\" maxlength=\"128\" type=\"text\" name=\"time_end\" value=\"$time_end\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["calendar_reminder"] . " :</td><td><input type=\"radio\" name=\"reminder\" value=\"0\" $checked1_b> " . $strings["no"] . "&nbsp;<input type=\"radio\" name=\"reminder\" value=\"1\" $checked2_b> " . $strings["yes"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["calendar_recurring"] . " :</td><td><input type=\"checkbox\" name=\"recurring\" value=\"1\" $checked2_a></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>";

    $block1->closeContent();
	$block1->headingForm_close();
    $block1->closeForm();
}




// calendDetail
if ($type == "calendDetail") {
    $reminder = $detailCalendar->cal_reminder[0];
    $recurring = $detailCalendar->cal_recurring[0];
    if ($reminder == "0") {
        $reminder = $strings["no"];
    } else {
        $reminder = $strings["yes"];
    }
    if ($recurring == "0") {
        $recurring = $strings["no"];
    } else {
        $recurring = $strings["yes"];
    }


	//--- header ----
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?type=monthPreview", $strings["calendar"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=monthPreview&amp;dateCalend=$dateCalend", "$monthName $year", LINK_INSIDE);
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=dayList&amp;dateCalend=$dateCalend", "$dayName $day $monthName $year", LINK_INSIDE);
    $breadcrumbs[]=$detailCalendar->cal_shortname[0];

	$pageSection='calendar';
	require_once("../themes/" . THEME . "/header.php");

	//--- content -----
    $block1 = new block();

    $block1->form = "calend";
    $block1->openForm("../calendar/viewcalendar.php#" . $block1->form . "Anchor");

    if ($error != "") {
        $block1->headingError($strings["errors"]);
        $block1->contentError($error);
    }

    $block1->heading($detailCalendar->cal_shortname[0]);

    $block1->openPaletteIcon();
    $block1->paletteIcon(0, "remove", $strings["delete"]);
    $block1->paletteIcon(1, "edit", $strings["edit"]);
    $block1->paletteIcon(2, "export", $strings["export"]);
    $block1->closePaletteIcon();

    $block1->openContent();
    $block1->contentTitle($strings["details"]);

    if ($viewCalend != 0) {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['project'] . " :</td><td>" . $listTeam->tea_pro_name[0] . "</td></tr>";
    }

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["subject"] . " :</td><td>" . $detailCalendar->cal_subject[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["description"] . " :</td><td>" . nl2br($detailCalendar->cal_description[0]) . "&nbsp;</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["shortname"] . $template->printHelp("calendar_shortname") . " :</td><td>" . $detailCalendar->cal_shortname[0] . "&nbsp;</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["date_start"] . " :</td><td>" . $detailCalendar->cal_date_start[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["date_end"] . " :</td><td>" . $detailCalendar->cal_date_end[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["time_start"] . " :</td><td>" . $detailCalendar->cal_time_start[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["time_end"] . " :</td><td>" . $detailCalendar->cal_time_end[0] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["calendar_reminder"] . " :</td><td>$reminder</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["calendar_recurring"] . " :</td><td>$recurring</td></tr>";

    $block1->closeContent();
    $block1->closeForm();

    $block1->openPaletteScript();
    $block1->paletteScript(0, "remove", "../calendar/deletecalendar.php?id=$dateEnreg", "true,true,true", $strings["delete"]);
    $block1->paletteScript(1, "edit", "../calendar/viewcalendar.php?viewCalend=$viewCalend&id=$dateEnreg&type=calendEdit&dateCalend=$dateCalend", "true,true,true", $strings["edit"]);
    $block1->paletteScript(2, "export", "../calendar/exportcalendar.php?id=$dateEnreg", "true,true,true", $strings["export"]);
    $block1->closePaletteScript("", "");
}
else if ($type == "dayList") {

	//--- header----
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?type=monthPreview", $strings["calendar"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=monthPreview&amp;dateCalend=$dateCalend", "$monthName $year", LINK_INSIDE);
    $breadcrumbs[]="$dayName $day $monthName $year";
	$pageSection='calendar';
	require_once("../themes/" . THEME . "/header.php");


	//--- content--------
    $block1 = new block();

    $block1->form = "calendList";
    $block1->openForm("../calendar/viewcalendar.php?viewCalend=$viewCalend&type=$type&amp;dateCalend=$dateCalend#" . $block1->form . "Anchor");

    if ($viewCalend == 0) {
        $heading_posfix = "(" . $strings['cal_personal'] . $strings['calendar'] . ")";
    } else {
        $heading_posfix = "(" . $strings['project'] . $strings['calendar'] . "-" . $listTeam->tea_pro_name[0] . ")";
    }
    $block1->heading("$dayName $day $monthName $year" . $heading_posfix);

    $block1->openPaletteIcon();

    $block1->paletteIcon(0, "add", $strings["add"]);
    $block1->paletteIcon(1, "remove", $strings["delete"]);
    $block1->paletteIcon(2, "info", $strings["view"]);
    $block1->paletteIcon(3, "edit", $strings["edit"]);

    $block1->closePaletteIcon();

    $block1->sorting("calendar", $sortingUser->sor_calendar[0], "cal.date_end DESC", $sortingFields = array(0 => "cal.shortname", 1 => "cal.subject", 2 => "cal.date_start", 3 => "cal.date_end"));

    $dayRecurr = _dayOfWeek(mktime(12, 12, 12, $month, $day, $year));

    if ($viewCalend == 0) {
        $tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND ((cal.date_start <= '$dateCalend' AND cal.date_end >= '$dateCalend' AND cal.recurring = '0') OR ((cal.date_start <= '$dateCalend' AND cal.date_end <= '$dateCalend') AND cal.recurring = '1' AND cal.recur_day = '$dayRecurr')) ORDER BY cal.shortname";
    } else {
        $tmpquery = "WHERE cal.project = '$viewCalend' AND ((cal.date_start <= '$dateCalend' AND cal.date_end >= '$dateCalend' AND cal.recurring = '0') OR ((cal.date_start <= '$dateCalend' AND cal.date_end <= '$dateCalend') AND cal.recurring = '1' AND cal.recur_day = '$dayRecurr')) ORDER BY cal.shortname";
    }

    // $tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND cal.date_start <= '$dateCalend' AND cal.date_end >= '$dateCalend' ORDER BY $block1->sortingValue";
    $listCalendar = new request();
    $listCalendar->openCalendar($tmpquery);
    $comptListCalendar = count($listCalendar->cal_id);

    if ($comptListCalendar != "0") {
        $block1->openResults();

        $block1->labels($labels = array(0 => $strings["shortname"], 1 => $strings["subject"], 2 => $strings["date_start"], 3 => $strings["date_end"]), "false");

        for ($i = 0;$i < $comptListCalendar;$i++) {
            $block1->openRow($listCalendar->cal_id[$i]);
            $block1->checkboxRow($listCalendar->cal_id[$i]);
            $block1->cellRow(buildLink("../calendar/viewcalendar.php?$dateEnreg=" . $listCalendar->cal_id[$i] . "&amp;viewCalend=$viewCalend&amp;type=calendDetail&amp;dateCalend=$dateCalend", $listCalendar->cal_shortname[$i], LINK_INSIDE));
            $block1->cellRow($listCalendar->cal_subject[$i]);
            $block1->cellRow($listCalendar->cal_date_start[$i]);
            $block1->cellRow($listCalendar->cal_date_end[$i]);
            $block1->closeRow();
        } 
        $block1->closeResults();
    } else {
        $block1->noresults();
    } 
    $block1->closeFormResults();

    $block1->openPaletteScript();
    $block1->paletteScript(0, "add", "../calendar/viewcalendar.php?viewCalend=$viewCalend&dateCalend=$dateCalend&type=calendEdit", "true,false,false", $strings["add"]);
    $block1->paletteScript(1, "remove", "../calendar/deletecalendar.php?", "false,true,true", $strings["delete"]);
    $block1->paletteScript(2, "info", "../calendar/viewcalendar.php?viewCalend=$viewCalend&dateCalend=$dateCalend&type=calendDetail", "false,true,false", $strings["view"]);
    $block1->paletteScript(3, "edit", "../calendar/viewcalendar.php?viewCalend=$viewCalend&dateCalend=$dateCalend&type=calendEdit", "false,true,false", $strings["edit"]);
    $block1->closePaletteScript($comptListCalendar, $listCalendar->cal_id);
} 

else if ($type == "monthPreview") {

    //--- header ----
	$breadcrumbs[]=buildLink("../calendar/viewcalendar.php?", $strings["calendar"], LINK_INSIDE);
    $breadcrumbs[]="$monthName $year";
	$pageSection='calendar';
	require_once("../themes/" . THEME . "/header.php");

    $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "' ORDER BY tea.project";
    $teamList = new request();
    $teamList->openTeams($tmpquery);
    $comptTeamList = count($teamList->tea_id);

    $block9 = new block();
    $block9->form = "caV";
    $block9->openForm("../calendar/viewcalendar.php?dateCalend=$dateCalend&amp;type=$type#" . $block9->form . "Anchor");

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["view"] . " :</td><td><select name=\"S_VIEW\" onchange=\"document.caVForm.submit()\">";
    echo "<option value=\"0\"";
    if ($viewCalend == 0) {
        echo " selected";
    }
    echo ">" . $strings['cal_personal'] . "</option>";

    for ($t = 0; $t < $comptTeamList; $t++) {
        echo "<option value=\"" . $teamList->tea_project[$t] . "\"";
        if ($viewCalend == $teamList->tea_project[$t]) {
            echo " selected";
        }
        echo ">" . $strings['project'] . ":" . $teamList->tea_pro_name[$t] . "</option>";
    }

    echo "</select></td></tr>";

    $block9->closeForm();
	//--- content -----
    $block2 = new block();

    $block2->headingForm("$monthName $year");

    $block2->openContent();
    echo "<tr><td>";
    echo "<table border=0 cellpadding=0 cellspacing=2 width=100% class=listing><tr>";
    for($daynumber = 1; $daynumber < 8; $daynumber++) {
        echo "<td width=14% class=calendDays>&nbsp;$dayNameArray[$daynumber]</td>";
    }
    echo "</tr>";
    // Print the calendar
    echo "<tr>";

    if ($viewCalend == 0) {
        $tmpquery = "WHERE tas.assigned_to = '" . $_SESSION['idSession'] . "' ORDER BY tas.name";
    } else {
        $tmpquery = "WHERE tas.project = '$viewCalend' ORDER BY tas.name";
    }

    $listTasks = new request();
    $listTasks->openTasks($tmpquery);
    $comptListTasks = count($listTasks->tas_id);

    if ($viewCalend == 0) {
        $tmpquery = "WHERE att.member = '" . $_SESSION['idSession'] . "'";
        $listAttendants = new request();
        $listAttendants->openAttendants($tmpquery);
        $comptListAttendants = count($listAttendants->att_id);
        $meetingIdList = "";
        for ($m = 0; $m < $comptListAttendants; $m++) {
            if ($meetingIdList != "") {
                $meetingIdList .= ", ";
            }
            $meetingIdList .= $listAttendants->att_meeting[$m];
        }
        if ($meetingIdList == "") {
            $tmpquery = "WHERE mee.id = -1";
        } else {
            $tmpquery = "WHERE mee.id IN (" . $meetingIdList . ") ORDER BY mee.name";
        }
    } else {
        $tmpquery = "WHERE mee.project = '$viewCalend' ORDER BY mee.name";
    }

    $listMeetings = new request();
    $listMeetings->openMeetings($tmpquery);
    $comptListMeetings = count($listMeetings->mee_id);

    for ($g = 0;$g < $comptListTasks;$g++) {
        if (substr($listTasks->tas_start_date[$g], 0, 7) == substr($dateCalend, 0, 7)) {
            $gantt = "true";
        }
    } 

    for ($i = 1; $i < $daysmonth + $firstday; $i++) {
        $a = $i - $firstday + 1;
        $day = $i - $firstday + 1;
        if (strlen($a) == 1) {
            $a = "0$a";
        } 
        if (strlen($month) == 1) {
            $month = "0$month";
        } 
        $dateLink = "$year-$month-$a";
        $todayClass = "";
        $dayRecurr = _dayOfWeek(mktime(12, 12, 12, $month, $a, $year));
        $comptListCalendarScan = "0";

        if ($viewCalend == 0) {
            $tmpquery = "WHERE cal.owner = '" . $_SESSION['idSession'] . "' AND ((cal.date_start <= '$dateLink' AND cal.date_end >= '$dateLink' AND cal.recurring = '0') OR ((cal.date_start <= '$dateLink' AND cal.date_end <= '$dateLink') AND cal.recurring = '1' AND cal.recur_day = '$dayRecurr')) ORDER BY cal.shortname";
        } else {
            $tmpquery = "WHERE cal.project = '$viewCalend' AND ((cal.date_start <= '$dateLink' AND cal.date_end >= '$dateLink' AND cal.recurring = '0') OR ((cal.date_start <= '$dateLink' AND cal.date_end <= '$dateLink') AND cal.recurring = '1' AND cal.recur_day = '$dayRecurr')) ORDER BY cal.shortname";
        }

        $listCalendarScan = new request();
        $listCalendarScan->openCalendar($tmpquery);
        $comptListCalendarScan = count($listCalendarScan->cal_id);

        if (($i < $firstday) || ($a == "00")) {
            echo "<td width=14% class=even>&nbsp;</td>";
        } else {
            if ($dateLink == $dateToday) {
                $classCell = "old";
            } else {
                $classCell = "odd";
            } 

            echo "<td width=14% align=left valign=top class=\"$classCell\" onmouseover=\"this.style.backgroundColor='" . $block2->highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><div align=right>" . buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$dateLink&amp;type=dayList", $day, LINK_INSIDE) . "</div>";
            if ($comptListCalendarScan != "0") {
                for ($h = 0;$h < $comptListCalendarScan;$h++) {
                    echo buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&amp;dateEnreg=" . $listCalendarScan->cal_id[$h] . "&amp;type=calendDetail&amp;dateCalend=$dateLink", $listCalendarScan->cal_shortname[$h], LINK_INSIDE) . "<br>";
                } 
            }
            if ($comptListMeetings != "0") {
                for ($h = 0;$h < $comptListMeetings;$h++) {
                    if ($listMeetings->mee_date[$h] == $dateLink) {
                        echo $strings["meeting"] . ": ";
                        echo buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$h], $listMeetings->mee_name[$h], LINK_INSIDE) . "<br>";
                    } 
                }
            }
            if ($comptListTasks != "0") {
                for ($h = 0;$h < $comptListTasks;$h++) {
                    if ($listTasks->tas_start_date[$h] == $dateLink && $listTasks->tas_start_date[$h] != $listTasks->tas_due_date[$h]) {
                        echo $strings["task"] . ": ";
                        echo buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$h], $listTasks->tas_name[$h], LINK_INSIDE) . " (" . $strings["start_date"] . ")<br>";
                    } 

                    if ($listTasks->tas_due_date[$h] == $dateLink && $listTasks->tas_start_date[$h] != $listTasks->tas_due_date[$h]) {
                        echo $strings["task"] . ": ";
                        if ($listTasks->tas_due_date[$h] <= $date && $listTasks->tas_completion[$h] != "10") {
                            echo buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$h], "<b>" . $listTasks->tas_name[$h] . "</b>", LINK_INSIDE) . " (" . $strings["due_date"] . ")<br>";
                        } else {
                            echo buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$h], $listTasks->tas_name[$h], LINK_INSIDE) . " (" . $strings["due_date"] . ")<br>";
                        } 
                    } 

                    if ($listTasks->tas_start_date[$h] == $dateLink && $listTasks->tas_due_date[$h] == $dateLink) {
                        echo $strings["task"] . ": ";
                        if ($listTasks->tas_due_date[$h] <= $date && $listTasks->tas_completion[$h] != "10") {
                            echo buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$h], "<b>" . $listTasks->tas_name[$h] . "</b>", LINK_INSIDE) . "<br>";
                        } else {
                            echo buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$h], $listTasks->tas_name[$h], LINK_INSIDE) . "<br>";
                        } 
                    } 
                } 
            } 
            if ($comptListTasks == "0" || $comptListMeetings == "0" || $comptListCalendarScan == "0") {
                echo "<br>";
            } 
            echo "</td>";
        } 

        if (($i % 7) == 0) {
            echo "</tr><tr>\n";
        } 
    } 

    if (($i % 7) != 1) {
        echo "</tr><tr>\n";
    } 

    echo "</table>";
    echo "</td></tr>";
    $block2->closeContent();
    $block2->headingForm_close();

    if ($month == 1) {
        $pyear = $year - 1;
        $pmonth = 12;
    } else {
        $pyear = $year;
        $pmonth = $month - 1;
    } 

    if ($month == 12) {
        $nyear = $year + 1;
        $nmonth = 1;
    } else {
        $nyear = $year;
        $nmonth = $month + 1;
    } 

    $year = date("Y");
    $month = date("n");
    $day = date("j");
    if (strlen($month) == 1) {
        $month = "0$month";
    } 
    if (strlen($pmonth) == 1) {
        $pmonth = "0$pmonth";
    } 
    if (strlen($nmonth) == 1) {
        $nmonth = "0$nmonth";
    } 
    if (strlen($day) == 1) {
        $day = "0$day";
    } 
    $datePast = "$pyear-$pmonth-01";
    $dateNext = "$nyear-$nmonth-01";

    $dateToday = "$year-$month-$day";
    echo "<table><tr><td class=calend> </td></tr></table>";

    echo "<table cellspacing=\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\"><tr><td nowrap align=\"right\" class=\"footerCell\">" . buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$datePast", $strings["previous"], LINK_INSIDE) . " | " . buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$dateToday", $strings["today"], LINK_INSIDE) . " | " . buildLink("../calendar/viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$dateNext", $strings["next"], LINK_INSIDE) . "</td></tr><tr><td height=\"5\" colspan=\"2\"><img width=\"1\" height=\"5\" border=\"0\" src=\"../themes/" . THEME . "/spacer.gif\" alt=\"\"></td></tr></table>";

    if ($activeJpgraph == "true" && $gantt == "true") {
        // show the expanded or compact Gantt Chart
        if ($_GET['base'] == 1) {
            echo "<a href='viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$dateCalend&amp;base=0'>expand</a><br>";
        } else {
            echo "<a href='viewcalendar.php?viewCalend=$viewCalend&amp;dateCalend=$dateCalend&amp;base=1'>compact</a><br>";
        }

        echo "<img src=\"graphtasks.php?viewCalend=$viewCalend&amp;dateCalend=$dateCalend&amp;base=" . $_GET['base'] . "\" alt=\"\"><br>
<span class=\"listEvenBold\">" . buildLink("http://www.aditus.nu/jpgraph/", "JpGraph", LINK_POWERED) . "</span>";
    } 
} 

require_once("../themes/" . THEME . "/footer.php");

?>
