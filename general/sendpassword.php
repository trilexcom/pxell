<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: sendpassword.php,v 1.5 2004/12/15 12:25:21 pixtur Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = false;
require_once('../includes/library.php');
$pageSection='login';

// test send query
if ($action == 'send') {
    $tmpquery = "WHERE mem.login = '$loginForm'";
    $userDetail = new request();
    $userDetail->openMembers($tmpquery);
    $comptUserDetail = count ($userDetail->mem_id); 

    // test if user exists
    if ($comptUserDetail == "0") {
        $error = $strings["no_login"];
    } else if ($userDetail->mem_email_work[0] != "") {
        // test if email of user exists
        password_generator();
        $pw = get_password($pass_g);

        $tmpquery = 'UPDATE ' . $tableCollab['members'] . " SET password='$pw' WHERE login = '$loginForm'";
        connectSql($tmpquery);

        $body = $strings['user_name'] . ' : ' . $userDetail->mem_login[0] . "\n\n" . $strings['password'] . " : $pass_g";

        $mail = new notification();

        $mail->getUserinfo('1', 'from');

        $subject = 'NetOffice ' . $strings['password'];

        $mail->Subject = $subject;
        $mail->Priority = '1';
        $mail->Body = $body;
        $mail->AddAddress($userDetail->mem_email_work[0], $userDetail->mem_name[0]);
        $mail->Send();
        $mail->ClearAddresses();

        // redirect to login page with message
        header('Location: ../general/login.php?msg=emailpwd');
        exit;
    } else {
        $error = $strings['no_email'];
    } 

    $send = 'on';
} 

$notLogged = true;
$bodyCommand = 'onLoad="document.sendForm.loginForm.focus();"';


require_once('../themes/' . THEME . '/header.php');

$block1 = new block();

$block1->form = 'send';
$block1->openForm('../general/sendpassword.php?action=send');

if ($error != '') {
    $block1->headingError($strings['errors']);
    $block1->contentError($error);
} 

$block1->headingForm('NetOffice : ' . $strings['password']);

$block1->openContent();
$block1->contentTitle($strings['enter_login']);

$block1->contentRow('* ' . $strings['user_name'], '<input style="width: 125px" maxlength="16" size="16" value="' . $loginForm . '" type="text" name="loginForm">');
$block1->contentRow('', '<input type="submit" name="send" value="' . $strings['send'] . '">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
