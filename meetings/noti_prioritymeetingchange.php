<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: noti_prioritymeetingchange.php,v 1.2 2004/12/13 00:18:23 madbear Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$tmpquery = "WHERE mee.id IN($id)";
$meetingNoti = new request();
$meetingNoti->openMeetings($tmpquery);

$tmpquery = "WHERE pro.id = '$project'";
$projectNoti = new request();
$projectNoti->openProjects($tmpquery);

$tmpquery = "WHERE noti.member IN($att_mem_id_list)";
$listNotifications = new request();
$listNotifications->openNotifications($tmpquery);
$comptListNotifications = count($listNotifications->not_id);

$count1 = 0;
for ($i = 0; $i < $comptListNotifications; $i++) {
    if ($listNotifications->not_prioritymeetingchange[$i] == "0") {
        $count1++;
    }
}

if ($count1 > 0) {
    $mail = new notification();

    $mail->getUserinfo($_SESSION['idSession'], "from");

    $mail->partSubject = $strings["noti_prioritymeetingchange1"];
    $mail->partMessage = $strings["noti_prioritymeetingchange2"];

    if ($projectNoti->pro_org_id[0] == "1") {
        $projectNoti->pro_org_name[0] = $strings["none"];
    } 
    $idStatus = $meetingNoti->mee_status[0];
    $idPriority = $meetingNoti->mee_priority[0];

    $body = $mail->partMessage . "\n\n" . $strings["meeting"] . " : " . $meetingNoti->mee_name[0] . "\n" . $strings["me_agenda"] . " : " . $meetingNoti->mee_agenda[0] . "\n" . $strings["date"] . " : " . $meetingNoti->mee_date[0] . "\n" . $strings["start_time"] . " : " . $meetingNoti->mee_start_time[0] . "\n" . $strings["end_time"] . " : " . $meetingNoti->mee_end_time[0] . "\n" . $strings["me_location"] . " : " . $meetingNoti->mee_location[0] . "\n" . $strings["priority"] . " : $priority[$idPriority]\n" . $strings["status"] . " : $status[$idStatus]\n\n" . $strings["project"] . " : " . $projectNoti->pro_name[0] . " (" . $projectNoti->pro_id[0] . ")\n" . $strings["organization"] . " : " . $projectNoti->pro_org_name[0] . "\n\n" . $strings["noti_moreinfo"] . "\n";

    if ($meetingNoti->mee_mem_organization[0] == "1") {
        $body .= "$root/general/login.php?url=meetings/viewmeeting.php%3Fid=$id";
    } else if ($meetingNoti->mee_mem_organization[0] != "1" && $projectNoti->pro_published[0] == "0" && $meetingNoti->mee_published[0] == "0") {
        $body .= "$root/general/login.php?url=projects_site/home.php%3Fproject=" . $projectNoti->pro_id[0];
    } 

    $body .= "\n\n" . $mail->footer;

    $subject = $mail->partSubject . " " . $meetingNoti->mee_name[0];

    $mail->Subject = $subject;
    if ($meetingNoti->mee_priority[0] == "4" || $meetingNoti->mee_priority[0] == "5") {
        $mail->Priority = "1";
    } else {
        $mail->Priority = "3";
    } 
    $mail->Body = $body;

    for ($i = 0; $i < $comptListNotifications; $i++) {
        if ($listNotifications->not_prioritymeetingchange[$i] == "0") {
            $mail->AddAddress($listNotifications->not_mem_email_work[$i], $listNotifications->not_mem_name[$i]);
        }
    }

    $mail->Send();
    $mail->ClearAddresses();
} 

?>
