<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: notification.class.php,v 1.3 2005/05/27 19:42:52 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

class notification extends phpmailer {
    function notification()
    {
        global $strings, $root, $notificationMethod, $setCharset, $base_dir;

        $this->Mailer = $notificationMethod;
        $this->PluginDir = $base_dir . 'includes/phpmailer/';

        // Sets the CharSet of the message
        $this->CharSet = $setCharset;

        if ($this->Mailer == 'smtp') {
            $this->Host = SMTPSERVER;
            $this->Username = SMTPLOGIN;
            $this->Password = SMTPPASSWORD;
        } 

        $this->footer = "--\n" . $strings['noti_foot1'] . "\n\n" .
                        $strings['noti_foot2'] . "\n" . 
                        $root . '/general/login.php';
    } 

    function getUserinfo($idUser, $type)
    {
        $tmpquery = "WHERE mem.id = '$idUser'";
        $detailUser = new request();
        $detailUser->openMembers($tmpquery);
        if ($type == "from") {
            $this->From = $detailUser->mem_email_work[0];
            $this->FromName = $detailUser->mem_name[0];
        } 
        if ($type == 'to') {
            $this->AddAddress($detailUser->mem_email_work[0], $detailUser->mem_name[0]);
        } 
    }
    
    function taskNotification($pAssigneeID, $pTaskID, $pTypeOfChange)
    {
        if ($num == '') {
            $num = $id;
        }
        
        $tmpquery = "WHERE tas.id IN($pTaskID)";
        $taskNoti = new request();
        $taskNoti->openTasks($tmpquery);

        $tmpquery = "WHERE pro.id = '$project'";
        $projectNoti = new request();
        $projectNoti->openProjects($tmpquery);

        $tmpquery = "WHERE noti.member IN ($pAssigneeID)";
        $listNotifications = new request();
        $listNotifications->openNotifications($tmpquery);
        $comptListNotifications = count($listNotifications->not_id);

        if ($listNotifications->not_taskassignment[0] == "0") {
            $this->getUserinfo($idSession, "from");

            $this->partSubject = $strings["noti_taskassignment1"];
            $this->partMessage = $strings["noti_taskassignment2"];

            if ($projectNoti->pro_org_id[0] == "1") {
                $projectNoti->pro_org_name[0] = $strings["none"];
            }

            $complValue = ($taskNoti->tas_completion[0] > 0) ? $taskNoti->tas_completion[0] . "0 %" : $taskNoti->tas_completion[0] . " %";
            $idStatus = $taskNoti->tas_status[0];
            $idPriority = $taskNoti->tas_priority[0];

            $body = $this->partMessage . "\n\n" . $strings["task"] . " : " . 
                    $taskNoti->tas_name[0] . "\n" . $strings["start_date"] . " : " . 
                    $taskNoti->tas_start_date[0] . "\n" . $strings["due_date"] . " : " . 
                    $taskNoti->tas_due_date[0] . "\n" . $strings["completion"] . " : " . 
                    $complValue . "\n" . $strings["priority"] . " : $priority[$idPriority]\n" . 
                    $strings["status"] . " : $status[$idStatus]\n" . $strings["description"] . " : " . 
                    $taskNoti->tas_description[0] . "\n\n" . $strings["project"] . " : " . 
                    $projectNoti->pro_name[0] . " (" . $projectNoti->pro_id[0] . ")\n" . 
                    $strings["organization"] . " : " . $projectNoti->pro_org_name[0] . "\n\n" . 
                    $strings["noti_moreinfo"]."\n";

            if ($taskNoti->tas_mem_organization[0] == "1") {
                $body .= "$root/general/login.php?url=tasks/viewtask.php%3Fid=$num";
            } else if ($taskNoti->tas_mem_organization[0] != "1" && $projectNoti->pro_published[0] == "0" && $taskNoti->tas_published[0] == "0") {
                $body .= "$root/general/login.php?url=projects_site/home.php%3Fproject=" . $projectNoti->pro_id[0];
            }

            $body .= "\n\n" . $this->footer;
            $subject = $this->partSubject . " " . $taskNoti->tas_name[0];
            $this->Subject = $subject;
            
            if ($taskNoti->tas_priority[0] == "4" || $taskNoti->tas_priority[0] == "5") {
                $this->Priority = "1";
            } else {
                $this->Priority = "3";
            }

            $this->Body = $body;
            $this->AddAddress($listNotifications->not_mem_email_work[0], $listNotifications->not_mem_name[0]);
            $this->Send();
            $this->ClearAddresses();
        }
    }
}

?>