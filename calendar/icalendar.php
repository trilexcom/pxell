<?php
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: icalendar.php,v 1.2 2005/05/30 16:17:58 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * iCal RFC: http://www.ietf.org/rfc/rfc2445.txt
 *
 * Basic iCal support for NetOffice Tasks and Milestones
 */

$checkSession = false;
require_once('../includes/library.php');
require_once('../includes/settings.php');

if ($_SESSION['icalAuth'] !== true) {
    $_SESSION['icalAuth'] = false;
}

if (!$_SERVER['PHP_AUTH_USER'] && $_SESSION['icalAuth'] === false) {
    authenticate();
    exit;
}

if ($_SESSION['icalAuth'] === false) {
    $tmpquery = "WHERE mem.login = '" . mysql_escape_string($_SERVER['PHP_AUTH_USER']) . 
                "' AND mem.login != 'demo' AND mem.profil != '4'";

    $listMember = new request();
    $listMember->openMembers($tmpquery);
    $comptListMember = count($listMember->mem_id);

    if ($comptListMember != 1){
        authenticate();
        exit;
    }
    
    if (!is_password_match(mysql_escape_string($_SERVER['PHP_AUTH_USER']), mysql_escape_string($_SERVER['PHP_AUTH_PW']), $listMember->mem_password[0])){
        authenticate();
        exit;
    }

    $_SESSION['idSession'] = $listMember->mem_id[0];
    $_SESSION['icalAuth'] = true;
}

// load the base iCal class
require_once('../includes/ical/class.iCal.inc.php');

$iCal = new iCal('-//netoffice.sourceforge.net//NetOffice v' . $version . '//' . strtoupper($langDefault), 0, '');

// now get the open task(s) for user_name
$tmpquery = "WHERE tas.assigned_to = '" . $_SESSION['idSession'] . 
            "' AND tas.status IN(0,2,3) AND pro.status IN(0,2,3)";
$listTasks = new request();
$listTasks->openTasks($tmpquery);
$comptListTasks = count($listTasks->tas_id);

// iCal VTODO: Open Task(s)
// iCal VEVENT: Milestones for open projects
if ($comptListTasks >= 1) {
    for ($i = 0; $i < $comptListTasks; $i++) {
        $title         = (string) $listTasks->tas_name[$i];
        $description   = (string) $listTasks->tas_description[$i];

        if (empty($listTasks->tas_start_date[$i]) || $listTasks->tas_start_date[$i] == '--') {
            $start_date = '';
            continue;
        } else {
            $start_date = (int) strtotime($listTasks->tas_start_date[$i]);
        }

        if (empty($listTasks->tas_due_date[$i]) || $listTasks->tas_due_date[$i] == '--') {
            $due_date = '';
        } else {
            $due_date = (int) strtotime($listTasks->tas_due_date[$i]);
        }

        $percent_done  = (int) $listTasks->tas_completion[$i] . '0';
        $priority      = (int) $listTasks->tas_priority[$i];
        $status        = (int) $listTasks->tas_status[$i];

	    if (isset($start_date) && $start_date > 1 && isset($due_date) && $due_date > $start_date) {
             $task_duration = (int) (($due_date - $start_date) / 60);
	    } else {
             $task_duration = 0;
	    }

        // set the VTODO status
        switch ($status) {
            case 1:
                $ical_status = 4; // COMPLETED
                break;
            case 3:
                $ical_status = 5; // IN-PROCESS
                break;
            default:
                $ical_status = 3; // NEEDS-ACTION
        }
        
        // if the task is overdue then make status "NEEDS-ACTION"
        if (time() > $due_date) {
            $ical_status = 3;
        }
        
        // map the NetOffice priority number to one that fits the iCal standard
        switch ($priority) {
            case 1:
                $ical_priority = 9; // very low
                break;
            case 2:
                $ical_priority = 7; // low
                break;
            case 3:
                $ical_priority = 5; // medium
                break;
            case 4:
                $ical_priority = 3; // high
                break;
            case 5:
                $ical_priority = 1; // very high
                break;
            default:
                $ical_priority = 0; // none
        }

        $organizer     = array($listTasks->tas_mem2_name[0], $listTasks->tas_mem2_email_work[0]);
        $attendee      = array($listTasks->tas_mem_name[0] => $listTasks->tas_mem_email_work[0], 1);
        $categorie     = array('Work','NetOffice');
        
        if (empty($listTasks->tas_modified[$i])) {
            $last_modified  = '';
        } else {
            $last_modified = (int) strtotime($listTasks->tas_modified[$i]);
        }

        $task_url      = (string) $root . '/general/login.php?url=tasks/viewtask.php?id=' . $listTasks->tas_id[$i];
        $end_date      = '';
        
        if (empty($listTasks->tas_complete_date[$i]) || $listTasks->tas_complete_date[$i] == '--') {
            $end_date  = '';
        } else {
            $end_date  = (int) strtotime($listTasks->tas_complete_date[$i]);
        }

        if ($listTasks->tas_milestone[$i] == 1) {
            $iCal->addToDo(
               $title,            // Title
	           $description,      // Description
	           '',                // Location
	           $start_date,       // Start time
	           $task_duration,    // Duration in minutes
	           $end_date,         // End time
	           $percent_done,     // Percentage complete
	           $ical_priority,    // Priority = 0-9
	           $ical_status,      // Status of the VTODO  (3 = NEEDS-ACTION, 4 = COMPLETED, 5 = IN-PROCESS, 6 = CANCELLED)
	           0,                 // Class (0 = PRIVATE | 1 = PUBLIC | 2 = CONFIDENTIAL)
        	   $organizer,        // Organizer
        	   $attendee,         // Array (key = attendee name, value = e-mail, second value = role of the attendee [0 = CHAIR | 1 = REQ | 2 = OPT | 3 =NON])
        	   $categorie,        // categorie(s) - Array with Strings
	           $last_modified,    // Last Modification
        	   '',                // Sets the time in minutes an alarm appears before an event in the program. no alarm if empty string or 0
        	   '',                // 5  - frequency: 0 = once, secoundly - yearly = 1-7
        	   '',                // 10 - recurrency end: ('' = forever | integer = number of times | timestring = explicit date)
	           '',                // 1  - Interval for frequency (every 2,3,4 weeks...)
        	   '',                // array(2,3) - Array with the number of the days the event accures (example: array(0,1,5) = Sunday, Monday, Friday
        	   0,                 // Startday of the Week ( 0 = Sunday - 6 = Saturday)
        	   '',                // exeption dates: Array with timestamps of dates that should not be includes in the recurring event
        	   $task_url,         // optional URL for that event
        	   $langDefault,      // Language of the Strings
               ''                 // Optional UID for this ToDo
            );
        } else {
            $iCal->addEvent(
                $organizer,        // The organizer - use array('Name', 'name@domain.com')
                $start_date,       // Start time for the event (timestamp; if you want an allday event the startdate has to start at 00:00:00)
                $start_date + 86400,    // End time for the event (timestamp or write 'allday' for an allday event)
                '',                // Location
                0,                 // Transparancy (0 = OPAQUE | 1 = TRANSPARENT)
                $categorie,        // categorie(s) - Array with Strings (example: array('Freetime','Party'))
                $description,      // Description
                $title,            // Title for the event
                0,                 // Class (0 = PRIVATE | 1 = PUBLIC | 2 = CONFIDENTIAL)
                $attendee,         // attendees - Array (key = attendee name, value = e-mail, second value = role of the attendee [0 = CHAIR | 1 = REQ | 2 = OPT | 3 =NON])
                $ical_priority,    // Priority = 0-9
                0,                 // frequency: 0 = once, secoundly – yearly = 1–7
                1,                 // Recurrency end: ('' = forever | integer = number of times | timestring = explicit date)
                0,                 // Interval for frequency (every 2,3,4 weeks…)
                '',                // Array with the number of the days the event accures (example: array(0,1,5) = Sunday, Monday, Friday
                0,                 // Startday of the Week ( 0 = Sunday - 6 = Saturday)
                '',                // exeption dates: Array with timestamps of dates that should not be includes in the recurring event
                '',                // Array with all the alarm information, "''" for no alarm
                0,                 // Status of the event (0 = TENTATIVE, 1 = CONFIRMED, 2 = CANCELLED)
                $task_url,         // optional URL for this event
                $langDefault,      // Language of the strings used in the event (iso code)
                ''                 // Optional UID for this EVENT
            );
        }
    }
}

// now get open meetings for this login
$tmpquery = " INNER JOIN {$tableCollab['attendants']} att ON att.meeting = mee.id " . 
            "WHERE att.member = '{$_SESSION['idSession']}' " . 
            "AND mee.status IN(0,2,3) ORDER BY mee.date ASC";

$listMeetings = new request();
$listMeetings->openMeetings($tmpquery);
$comptListMeetings = count($listMeetings->mee_id);

// add iCal VEVENT for each open meeting, if any
if ($comptListMeetings >= 1) {
    for ($i = 0; $i < $comptListMeetings; $i++) {
        $organizer = array($listMeetings->mee_chairman_name[$i], $listMeetings->mee_chairman_email[$i]);

        if (empty($listMeetings->mee_date[$i]) || $listMeetings->mee_date[$i] == '--') {
            continue;
        } else {
            $start_time = (int) strtotime($listMeetings->mee_date[$i] . ' ' . $listMeetings->mee_start_time[$i]);;
            $end_time   = (int) strtotime($listMeetings->mee_date[$i] . ' ' . $listMeetings->mee_end_time[$i]);
        }

        $location    = (string) $listMeetings->mee_location[$i];
        $categorie   = array('Work', 'NetOffice');
        $description = (string) $listMeetings->mee_agenda[$i];
        $title       = (string) $listMeetings->mee_name[$i];

        // get attendants of this meeting
        $tmpquery = "WHERE att.meeting = '{$listMeetings->mee_id[$i]}'";
        $attendantDetail = new request();
        $attendantDetail->openAttendants($tmpquery);
        $comptAttendantDetail = count($attendantDetail->att_id);
        
        if ($comptAttendantDetail >= 1) {
            for ($j = 0; $j < $comptAttendantDetail; $j++) {
                // role of the attendee [0 = CHAIR | 1 = REQ | 2 = OPT | 3 =NON]
                $role = 1; // default to REQ

                if ($attendantDetail->att_mem_name[$j] == $listMeetings->mee_chairman_name[$i]) {
                    $role = 0; // this person is the CHAIR
                }

                $att_name  = $attendantDetail->att_mem_name[$j];
                $att_email = $attendantDetail->att_mem_email_work[$j];

                if (empty($att_email)) {
                    $att_email = 'unknown@somewhere.com';
                }

                // array of attendants
                $attendees[$att_name] = "$att_email,$role";
            }
        } else {
            $attendees = '';
        }

        $priority    = (int) $listMeetings->mee_priority[$i];
        $task_url    = (string) $root . '/general/login.php?url=meetings/viewmeeting.php?id=' . $listMeetings->mee_id[$i];
        
        // map the NetOffice priority number to one that fits the iCal standard
        switch ($priority) {
            case 1:
                $ical_priority = 9; // very low
                break;
            case 2:
                $ical_priority = 7; // low
                break;
            case 3:
                $ical_priority = 5; // medium
                break;
            case 4:
                $ical_priority = 3; // high
                break;
            case 5:
                $ical_priority = 1; // very high
                break;
            default:
                $ical_priority = 0; // none
        }
        
        $iCal->addEvent(
            $organizer,        // The organizer - use array('Name', 'name@domain.com')
            $start_time,       // Start time for the event (timestamp; if you want an allday event the startdate has to start at 00:00:00)
            $end_time,         // End time for the event (timestamp or write 'allday' for an allday event)
            $location,         // Location
            0,                 // Transparancy (0 = OPAQUE | 1 = TRANSPARENT)
            $categorie,        // categorie(s) - Array with Strings (example: array('Freetime','Party'))
            $description,      // Description
            $title,            // Title for the event
            0,                 // Class (0 = PRIVATE | 1 = PUBLIC | 2 = CONFIDENTIAL)
            $attendees,        // attendees - Array (key = attendee name, value = e-mail, second value = role of the attendee [0 = CHAIR | 1 = REQ | 2 = OPT | 3 =NON])
            $ical_priority,    // Priority = 0-9
            0,                 // frequency: 0 = once, secoundly – yearly = 1–7
            1,                 // Recurrency end: ('' = forever | integer = number of times | timestring = explicit date)
            0,                 // Interval for frequency (every 2,3,4 weeks…)
            '',                // Array with the number of the days the event accures (example: array(0,1,5) = Sunday, Monday, Friday
            0,                 // Startday of the Week ( 0 = Sunday - 6 = Saturday)
            '',                // exeption dates: Array with timestamps of dates that should not be includes in the recurring event
            '',                // Array with all the alarm information, "''" for no alarm
            0,                 // Status of the event (0 = TENTATIVE, 1 = CONFIRMED, 2 = CANCELLED)
            $task_url,         // optional URL for this event
            $langDefault,      // Language of the strings used in the event (iso code)
            ''                 // Optional UID for this EVENT
        );
    }
}

// output the ics file
$iCal->outputFile('ics');

//----------------------
//--- functions --------
//----------------------
function authenticate()
{
    header('WWW-Authenticate: Basic realm="My NetOffice iCalendar"');
    header('HTTP/1.0 401 Unauthorized');
    die('Invalid Credentials!');
}

?>