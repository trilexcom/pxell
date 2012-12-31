#!/usr/bin/php
<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * $Id: taskreminder.php,v 1.1.1.1 2004/11/02 03:30:11 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../scripts/traskreminder.php
 * 
 * TODO: allow optional plain text format
 *        set up to send HTML mail as multipart MIME
 *        fix alternate table prefix bug
 */
// emails are html formatted
// TODO: actually create other text-only output if non-HTML is selected
$send_html = true;
// set the subject
$subject_txt = "Project List";
// The email appears to be sent by this user
$from_email = "netoffice@netoffice.org";
// a name for the sender
$from_name = "NetOffice";
// the organization id to limit to, usually 1
$orgID = 1;
// set testing mode
// in this mode, all emails will be sent to the value set in
// test_email
$test = 1;
// the email to use for testing
$test_email = 'test@netoffice.org';
// HTML mail colors
// the color to designate a late task
$late_task_color = "#FFFF00";
// color for tasks that are due today
$today_task_color = "#00FF00";
// color for all other tasks
$normal_task_color = "white";
// the URL of the online application
// this is to provide a handy link in the email for HTML mail
$app_url = 'http://www.netoffice.org/netoffice/';
// end of configuration
// IT IS NOT WISE TO MODIFY THE FOLLOWING CODE
require_once("../includes/library.php");
// check to make sure notifications are enabled
if ($notifications == "false") {
    print "notifications are disabled - no message will be sent\n";
    exit;
} 
// create the email content header
function task_header($name)
{
    $header = "<html><head></head>\n<body bgcolor=\"white\"><h1 align=\"center\">Task list for $name</h1><table width='100%'><tr bgcolor=\"lightgray\"><th>Task</th><th>Project</th><th>Priority</th><th>Status</th><th>Due</th>\n";
    return $header;
} 
// create the email content footer
function task_footer()
{
    $footer = "</table></body></html>\n";
    return $footer;
} 
// create the row for a task item
function task_row ($row, $task_color)
{
    global $priority, $status, $app_url;
    $task_priority = $priority[$row[4]];
    $task_status = $status[$row[5]]; 
    // start the row definition
    // set the background color for the task item
    $task = "<tr bgcolor=\"$task_color\">"; 
    // the task name, with a link to view the task
    $task .= "<td><a href=\"$app_url/tasks/viewtask.php?id={$row[0]}\">$row[1]</a></td>"; 
    // the project name, with a link to the project
    $task .= "<td><a href=\"$app_url/projects/viewproject.php?id={$row[2]}\">$row[3]</a></td>"; 
    // the task priority
    $task .= "<td>$task_priority</td>"; 
    // the task status
    $task .= "<td>$task_status</td>"; 
    // the due date
    $task .= "<td align=\"center\">$row[6]</td></tr>\n";
    return $task;
} 
// set up general variables and functions
$datenow = date("Y-m-d");
/* Date of today */
$content_type = ($send_html ? "text/html" : "text/plain");
$notice_list = array();
$notice_name = array();
// get the list of resources with tasks to list
$sql = "SELECT distinct mem.id, mem.email_work, mem.name 
FROM " . $tableCollab["members"] . " mem, " . $tableCollab["tasks"] . " tas
WHERE mem.organization = " . $orgID . "
AND tas.status  IN (2,3) 
AND mem.id = tas.assigned_to";

$res = openDatabase();

$rows = mysql_query($sql, $res);

while ($row = mysql_fetch_row($rows)) {
    $notice_list[$row[0]] = $row[1];
    $notice_name[$row[0]] = $row[2];
} 

@mysql_free_result($rows);
// iterate through the list of resources and pull all their tasks
foreach ($notice_list as $staffid => $email) {
    $recipient_name = $notice_name[$staffid];

    if ($test == 1) {
        $email = $test_email;
    } 

    print "mailing to $recipient_name <$email>\n";
    $content = task_header($recipient_name);
    $sql = "SELECT tas.id, tas.name, pro.id, pro.name, tas.priority, tas.status, tas.due_date
    FROM " . $tableCollab["tasks"] . " tas, " . $tableCollab["projects"] . " pro
    WHERE tas.status IN (2,3) 
    AND tas.project = pro.id
    AND tas.assigned_to = '$staffid'
    ORDER BY tas.due_date, tas.status";

    $rows = mysql_query($sql, $res);

    while ($row = mysql_fetch_row($rows)) {
        if ($row[6] < $datenow) {
            $content .= task_row($row, $late_task_color);
        } elseif ($row[6] == $datenow) {
            $content .= task_row($row, $today_task_color);
        } else {
            $content .= task_row($row, $normal_task_color);
        } 
    } 

    $content .= task_footer(); 
    // set up the email object
    $tasknotice = new notification();
    $tasknotice->From = $from_email;
    $tasknotice->FromName = $from_name;
    $tasknotice->Subject = $subject_txt;
    $tasknotice->Body = $content;
    $tasknotice->AddAddress($email); 
    // $tasknotice->getUserinfo($staffid,"to");
    if ($send_html) {
        $tasknotice->IsHTML("true");
        $tasknotice->AltBody = "this message uses html entities, but you prefer plain text !";
    } 
    // send the email
    if (!$tasknotice->Send()) {
        echo "Message was not sent\n";
        echo "Mailer Error: " . $tasknotice->ErrorInfo . "\n\n";
    } 
} 
@mysql_close($res);

?>
