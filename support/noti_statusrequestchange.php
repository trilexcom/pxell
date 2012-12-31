<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: noti_statusrequestchange.php,v 1.2 2004/12/13 00:18:26 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$mail = new notification();

$mail->getUserinfo($_SESSION['idSession'], "from");

$tmpquery = "WHERE sr.id = '$id'";
$requestDetail = new request();
$requestDetail->openSupportRequests($tmpquery);

$tmpquery = "WHERE mem.id = '" . $requestDetail->sr_user[0] . "'";
$userDetail = new request();
$userDetail->openMembers($tmpquery);

$mail->partSubject = $strings["support"] . " " . $strings["support_id"];
$mail->partMessage = $strings["noti_support_status2"];
$subject = $mail->partSubject . ": " . $requestDetail->sr_id[0];
$body = $mail->partMessage . "";

$body .= "\n\n" . $strings["id"] . " : " . $requestDetail->sr_id[0] . "\n" . $strings["subject"] . " : " . $requestDetail->sr_subject[0] . "\n" . $strings["status"] . " : " . $requestStatus[$requestDetail->sr_status[0]] . "\n" . $strings["details"] . " : ";
if ($listTeam->tea_mem_profil[$i] == 3) {
    $body .= "$root/general/login.php?url=projects_site/home.php%3Fproject=" . $requestDetail->sr_project[0] . "\n\n";
} else {
    $body .= "$root/general/login.php?url=support/viewrequest.php%3Fid=$num \n\n";
} 

$mail->Subject = $subject;
$mail->Priority = "3";
$mail->Body = $body;
$mail->AddAddress($userDetail->mem_email_work[0], $userDetail->mem_name[0]);
$mail->Send();
$mail->ClearAddresses();

?>
