<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: noti_addprojectteam.php,v 1.2 2004/12/13 00:18:27 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$tmpquery = "WHERE noti.member IN($id)";
$listNotifications = new request();
$listNotifications->openNotifications($tmpquery);
$comptListNotifications = count($listNotifications->not_id);

$mail = new notification();

$mail->getUserinfo($_SESSION['idSession'], "from");

$mail->partSubject = $strings["noti_addprojectteam1"];
$mail->partMessage = $strings["noti_addprojectteam2"];

$subject = $mail->partSubject . " " . $projectDetail->pro_name[0];

if ($projectDetail->pro_org_id[0] == "1") {
    $projectDetail->pro_org_name[0] = $strings["none"];
} 

$body = $mail->partMessage . "\n\n" . $strings["project"] . " : " . $projectDetail->pro_name[0] . " (" . $projectDetail->pro_id[0] . ")\n" . $strings["organization"] . " : " . $projectDetail->pro_org_name[0] . "\n\n" . $strings["noti_moreinfo"] . "\n";

if ($organization == "1") {
    $body .= "$root/general/login.php?url=projects/viewproject.php%3Fid=" . $projectDetail->pro_id[0];
} else if ($organization != "1" && $projectDetail->pro_published[0] == "0") {
    $body .= "$root/general/login.php?url=projects_site/home.php%3Fproject=" . $projectDetail->pro_id[0];
} 

$body .= "\n\n" . $mail->footer;

for ($i = 0;$i < $comptListNotifications;$i++) {
    if ($listNotifications->not_addprojectteam[$i] == "0" && $listNotifications->not_mem_email_work[$i] != "") {
        $mail->Subject = $subject;
        $mail->Priority = "3";
        $mail->Body = $body;
        $mail->AddAddress($listNotifications->not_mem_email_work[$i], $listNotifications->not_mem_name[$i]);
        $mail->Send();
        $mail->ClearAddresses();
    } 
} 

?>
