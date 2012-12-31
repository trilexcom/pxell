<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: emailusers.php,v 1.6 2004/12/15 19:43:40 madbear Exp $
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
// this limits it to just Admin
if ($_SESSION['profilSession'] != "0") {
    header("Location:../general/permissiondenied.php");
    exit;
} 

if ($action == "email") {
    global $root, $version, $setCharset;
    // get name and email of user sending the email
    $tmpquery = "WHERE mem.id = '" . $_SESSION['idSession'] . "'";
    $userPrefs = new request();
    $userPrefs->openMembers($tmpquery);
    // get company name
    $tmpquery = "WHERE org.id = '1'";
    $clientDetail = new request();
    $clientDetail->openOrganizations($tmpquery);
    // get users to email
    $id = str_replace("**", ",", $id);
    $tmpquery = "WHERE mem.id IN($id) ORDER BY mem.name";
    $listMembers = new request();
    $listMembers->openMembers($tmpquery);
    $comptListMembers = count($listMembers->mem_id);
    // format body and message
    $subject = stripslashes($subject);
    $message = stripslashes($message);
    $message = str_replace("\r\n", "\n", $message);

    for ($i = 0;$i < $comptListMembers;$i++) {
        // send email to each user
        $email = $listMembers->mem_email_work[$i];
        $priorityMail = "3";
        $headers = "Content-type:text/plain;charset=\"$setCharset\"\nFrom: \"" . $userPrefs->mem_name[0] . "\" <" . $userPrefs->mem_email_work[0] . ">\nX-Priority: $priorityMail\nX-Mailer: PhpCollab $version";

        $footer = "---\n" . $strings["noti_foot1"];
        $signature = $userPrefs->mem_name[0] . "\n";
        if ($userPrefs->mem_title[0] != "") {
            $signature .= $userPrefs->mem_title[0] . ", " . $clientDetail->org_name[0] . "\n";
        } else {
            $signature .= $clientDetail->org_name[0] . "\n";
        } 
        if ($userPrefs->mem_phone_work[0] != "") {
            $signature .= "Phone: " . $userPrefs->mem_phone_work[0] . "\n";
        } 
        if ($userPrefs->mem_mobile[0] != "") {
            $signature .= "Mobile: " . $userPrefs->mem_mobile[0] . "\n";
        } 
        if ($userPrefs->mem_fax[0] != "") {
            $signature .= "Fax: " . $userPrefs->mem_fax[0] . "\n";
        } 
        $newmessage = $message;
        $newmessage .= "\n\n" . $signature;
        $newmessage .= "\n" . $footer;
        @mail($email, $subject, $newmessage, $headers);
        $newmessage = "";
    } 
    header("Location:../users/listusers.php?id=$clod&msg=email");
    exit;
} 


//--- header---
$breadcrumbs[]= "<a href=\"../administration/admin.php\">" . $strings["administration"] . "</a>";
$breadcrumbs[]= $strings["user_management"];
$breadcrumbs[]= $strings["email_users"];


require_once("../themes/" . THEME . "/header.php");

//--- start main page---
$block1 = new block();

$block1->form = "user_email";
$block1->openForm("../users/emailusers.php?action=email");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["email_users"]);

$block1->openContent();
$block1->contentTitle($strings["email_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mem.id IN($id) ORDER BY mem.name";
$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

for ($i = 0;$i < $comptListMembers;$i++) {
    if ($listMembers->mem_email_work[$i] != "") {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listMembers->mem_login[$i] . "&nbsp;(" . $listMembers->mem_name[$i] . ")</td></tr>";
    } else {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listMembers->mem_login[$i] . "&nbsp;(" . $listMembers->mem_name[$i] . ") " . $strings["no_email"] . "</td></tr>";
    } 
} 

$block1->contentTitle($strings["email"]);

echo "<tr class=\"odd\"><td class=\"leftvalue\">" . $strings["subject"] . "</td><td><input size=\"44\" style=\"width: 400px\" name=\"subject\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["message"] . "</td><td><textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"message\" cols=\"47\"></textarea></td></tr>";

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["email"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"><input type=\"hidden\" value=\"$id\" name=\"id\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
