<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: noti_newpost.php,v 1.2 2004/12/13 00:18:28 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$tmpquery = "WHERE pos.topic = '" . $detailTopic->top_id[0] . "'  AND pos.member != '" . $_SESSION['idSession'] . "' ORDER BY mem.id";
$listPosts = new request();
$listPosts->openPosts($tmpquery);
$comptListPosts = count($listPosts->pos_id);

for ($i = 0;$i < $comptListPosts;$i++) {
    if ($listPosts->pos_mem_id[$i] != $distinct) {
        $posters .= $listPosts->pos_mem_id[$i] . ",";
    } 
    $distinct = $listPosts->pos_mem_id[$i];
} 
if (substr($posters, -1) == ",") {
    $posters = substr($posters, 0, -1);
} 
// echo $posters;
if ($posters != "") {
    $tmpquery = "WHERE noti.member IN($posters)";
    $listNotifications = new request();
    $listNotifications->openNotifications($tmpquery);
    $comptListNotifications = count($listNotifications->not_id);

    $mail = new notification();

    $mail->getUserinfo($_SESSION['idSession'], "from");

    $mail->partSubject = $strings["noti_newpost1"];
    $mail->partMessage = $strings["noti_newpost2"];

    $subject = $mail->partSubject . " " . $detailTopic->top_subject[0];

    if ($projectDetail->pro_org_id[0] == "1") {
        $projectDetail->pro_org_name[0] = $strings["none"];
    } 

    for ($i = 0;$i < $comptListNotifications;$i++) {
        if (($listNotifications->not_mem_organization[$i] != "1" && $detailTopic->top_published[0] == "0" && $projectDetail->pro_published[0] == "0") || $listNotifications->not_mem_organization[$i] == "1") {
            if ($listNotifications->not_newpost[$i] == "0" && $listNotifications->not_mem_email_work[$i] != "") {
                $body = $mail->partMessage . "\n\n" . $strings["discussion"] . " : " . $detailTopic->top_subject[0] . "\n" . $strings["posted_by"] . " : " . $_SESSION['nameSession'] . " (" . $_SESSION['loginSession'] . ")\n\n" . $strings["project"] . " : " . $projectDetail->pro_name[0] . " (" . $projectDetail->pro_id[0] . ")\n" . $strings["organization"] . " : " . $projectDetail->pro_org_name[0] . "\n\n" . $strings["noti_moreinfo"] . "\n";

                if ($listNotifications->not_mem_organization[$i] == "1") {
                    $body .= "$root/general/login.php?url=topics/viewtopic.php%3Fid=" . $detailTopic->top_id[0];
                } else if ($listNotifications->not_mem_organization[$i] != "1") {
                    $body .= "$root/general/login.php?url=projects_site/home.php%3Fproject=" . $projectDetail->pro_id[0];
                } 

                $body .= "\n\n" . $mail->footer;

                $mail->Subject = $subject;
                $mail->Priority = "3";
                $mail->Body = $body;
                $mail->AddAddress($listNotifications->not_mem_email_work[$i], $listNotifications->not_mem_name[$i]);
                $mail->Send();
                $mail->ClearAddresses();
            } 
        } 
    } 
} 

?>
