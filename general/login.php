<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: login.php,v 1.7 2004/12/14 23:20:37 pixtur Exp $
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

// DEBUG
// foreach ($_POST as $k => $v) { print "<font color=blue>\$_POST[$k] => $v</font><br>"; }
// foreach ($_GET as $k => $v) { print "<font color=green>\$_GET[$k] => $v</font><br>"; }
// foreach ($_SESSION as $k => $v) { print "<font color=red>\$_SESSION[$k] => $v</font><br>"; }
// foreach ($_COOKIE as $k => $v) { print "<font color=purple>\$_COOKIE[$k] => $v</font><br>"; }
// foreach ($_SERVER as $k => $v) { print "<font color=purple>\$_SERVER[$k] => $v</font><br>"; }

if (($_GET['logout'] == 'true') and (isset($_SESSION['loginSession']))) {
    // update the logs table before logout
    $tmpquery1 = 'UPDATE ' . $tableCollab['logs'] . ' SET connected=NULL ';
    $tmpquery1 .= 'WHERE login="' . $_SESSION['loginSession'] . '"';
    connectSql($tmpquery1);

    // delete the authentication cookies
    setcookie('NetOfficeAuthCookie', '', time() - 86400, $base_uri);

    // handle the session
    $_SESSION = array(); // unset all session varables
    session_unset();
    _sess_mysql_destroy( session_id() ); // then destroy the session

    // redirection to login page with logout message
    header('Location: ../general/login.php?msg=logout');
    exit;
}

$match = false;
$ssl = false;
// if (!empty($SSL_CLIENT_CERT) && !$_GET['logout'] && $_GET['loginSubmit']) {
// $auth = 'on';
// $ssl = true;

// if (function_exists('openssl_x509_read')) {
// $x509 = openssl_x509_read($SSL_CLIENT_CERT);
// $cert_array = openssl_x509_parse($x509, true);
// $subject_array = $cert_array['subject'];
// $ssl_email = $subject_array['Email'];
// openssl_x509_free($x509);
// } else {
// $ssl_email = `echo "$SSL_CLIENT_CERT" | $pathToOpenssl x509 -noout -email`;
// }
// } else {
// test blank fields in form
if ($_POST['loginSubmit']) {
    if ($_POST['loginForm'] == '' and $_POST['passwordForm'] == '') {
        $error = $strings['login_username'] . '<br>' . $strings['login_password'];
    } else if ($_POST['loginForm'] == '') {
        $error = $strings['login_username'];
    } else if ($_POST['passwordForm'] == '') {
        $error = $strings['login_password'];
    } else {
        $auth = 'on';
        if ($rememberForm == 'on') {
            $storePwd = get_password($_POST['passwordForm']);
            $cookie_value = base64_encode(serialize(array('loginForm' => $_POST['loginForm'], 'storePwd' => $storePwd, 'tokenSession' => md5($_POST['loginForm'] . $cryptKey))));
            setcookie('NetOfficeAuthCookie', $cookie_value, time()+31536000, $base_uri);
        } else {
            setcookie('NetOfficeAuthCookie', '', time()-3600, $base_uri);
        }
    }
}

if ($forcedLogin == 'false') {
    if (($auth == 'on') and (!$_POST['loginForm']) and (!$_POST['passwordForm'])) {
        $auth = 'off';
        $error = 'Detecting variables poisoning ;-)';
    }
}
// }

// get cookie params
$authCookie = unserialize(base64_decode($_COOKIE['NetOfficeAuthCookie']));
$loginCookie = $authCookie['loginForm'];
$passwordCookie = $authCookie['storePwd'];
$tokenCookie = $authCookie['tokenSession'];

if ($loginCookie != '' && $passwordCookie != '' && $tokenCookie != '') {
    $auth = 'on';
}

if ($auth == 'on') {
    $loginForm = strip_tags($_POST['loginForm']);
    $passwordForm = strip_tags($_POST['passwordForm']);

    if ($loginCookie != '' && $passwordCookie != '' && $tokenCookie != '') {
        $loginForm = $loginCookie;
    } 

    // query in members table (demo user not listed if demo mode false,
    // to prohibit the access)
    if ($demoMode != true) {
        if ($ssl) {
            $tmpquery = "WHERE mem.email_work = '$ssl_email' AND mem.login != 'demo' AND mem.profil != '4'";
        } else {
            $tmpquery = "WHERE mem.login = '$loginForm' AND mem.login != 'demo' AND mem.profil != '4'";
        } 
    } else {
        $tmpquery = "WHERE mem.login = '$loginForm' AND mem.profil != '4'";
    } 

    $loginUser = new request();
    $loginUser->openMembers($tmpquery);
    $comptLoginUser = count($loginUser->mem_id); 

    // test if user exits
    if ($comptLoginUser == '0') {
        $error = $strings['invalid_login']; 
        setcookie('NetOfficeAuthCookie', '', time()-3600, $base_uri);
    } else {
        // test password
        if ($loginCookie != '' && $passwordCookie != '' && $tokenCookie != '') {
            if (!$ssl && $passwordCookie != $loginUser->mem_password[0]) {
                $error = $strings['invalid_login'];
                setcookie('NetOfficeAuthCookie', '', time()-3600, $base_uri);
            } else {
                // password passed, now test token
                if (!$ssl && $tokenCookie != md5($loginCookie . $cryptKey)) {
                    $error = $strings['invalid_login'];
                    setcookie('NetOfficeAuthCookie', '', time()-3600, $base_uri);
                } else {
                    $match = true;
                }
            }
        } else {
            if ((!$ssl) and (!is_password_match($loginForm, $passwordForm, $loginUser->mem_password[0]))) {
                $error = $strings['invalid_login'];
            } else {
                $match = true;
            } 
        }

        if ($match == true) {
            // encrypt password in session using the defined loginMethod from settings.php
            $passwordForm = get_password($passwordForm);

            // get the ip addr
            $ip = SESS_REMOTE_ADDR; 

            // set session variables
            $_SESSION['browserSession'] = $HTTP_USER_AGENT;
            $_SESSION['idSession'] = $loginUser->mem_id[0];
            $_SESSION['timezoneSession'] = $loginUser->mem_timezone[0];
            $_SESSION['languageSession'] = $languageForm;
            $_SESSION['loginSession'] = $loginForm;
            $_SESSION['passwordSession'] = $passwordForm;
            $_SESSION['nameSession'] = $loginUser->mem_name[0];
            $_SESSION['ipSession'] = $ip;
            $_SESSION['dateunixSession'] = date('U');
            $_SESSION['dateSession'] = date('d-m-Y H:i:s');
            $_SESSION['profilSession'] = $loginUser->mem_profil[0];
            $_SESSION['logouttimeSession'] = $loginUser->mem_logout_time[0]; 
            $_SESSION['tokenSession'] = md5($loginForm . $cryptKey);

            // register demo session = true in session if user = demo
            if ($loginForm == 'demo') {
                $demoSession = true;
                $_SESSION['demoSession'] = $demoSession;
            } 

            // insert into or update log
            $tmpquery = "WHERE log.login = '$loginForm'";
            $registerLog = new request();
            $registerLog->openLogs($tmpquery);
            $comptRegisterLog = count($registerLog->log_id);
            $session = session_id();

            if ($comptRegisterLog == '0') {
                $tmpquery1 = 'INSERT INTO ' . $tableCollab['logs'] . "(login,password,ip,session,compt,last_visite) VALUES('$loginForm','$passwordForm','$ip','$session','1','$dateheure')";
                connectSql($tmpquery1);
            } else {
                $_SESSION['lastvisiteSession'] = $registerLog->log_last_visite[0];
                $increm = $registerLog->log_compt[0] + 1;
                $tmpquery1 = 'UPDATE ' . $tableCollab['logs'] . " SET ip='$ip',session='$session',compt='$increm',last_visite='$dateheure' WHERE login = '$loginForm'";
                connectSql($tmpquery1);
            } 
            // redirect for external link to internal page
            if ($_GET['url'] != '') {
                if ($loginUser->mem_profil[0] == '3') {
                    header('Location: ../' . $_GET['url'] . '&updateProject=true');
                    exit;
                } else {
                    header('Location: ../' . $_GET['url']);
                    exit;
                } 
            } else if (($loginUser->mem_last_page[0] != '') and ($loginUser->mem_profil[0] != '3')) {
                // redirect to selected start page
                header('Location: ../' . $loginUser->mem_last_page[0]);
                exit;
                // } else if ($loginUser->mem_last_page[0] != '' && ($loginCookie != '' && $passwordCookie != '' && $tokenCookie != '') && $loginUser->mem_profil[0] != '3') {
                // $tmpquery = 'UPDATE '.$tableCollab['members']." SET last_page='' WHERE login = '$loginForm'";
                // connectSql($tmpquery);
                // header('Location: ../'.$loginUser->mem_last_page[0]);
                // exit;
            } else {
                // redirect to home or admin page (if user is administrator)
                if ($loginUser->mem_profil[0] == '3') {
                    header('Location: ../projects_site/home.php');
                    exit;
                } else if ($loginUser->mem_profil[0] == '0') {
                    header('Location: ../administration/admin.php');
                    exit;
                } else {
                    header('Location: ../general/home.php');
                    exit;
                } 
            } 
        } 
    } 
}

if (($_GET['session'] == 'false') and ($_GET['url'] == '')) {
    $error = $strings['session_false'];
}

if ($_GET['logout'] == 'true') {
    $msg = 'logout';
}

if ($demoMode == true) {
    $loginForm = 'demo';
    $passwordForm = 'demo';
}

$notLogged = true;
$bodyCommand = 'onLoad="document.loginForm.loginForm.focus();"';


//---- header ---------------------------
require_once('../themes/' . THEME . '/header.php');


//------- content ----------------------------------------------------
$block1 = new block();

$block1->form = 'login';
$block1->openForm($_SERVER['REQUEST_URI']);

if ($_GET['url'] != '') {
    echo '<input value="' . $_GET['url'] . '" type="hidden" name="url">';
}

if ($error != '') {
    $block1->headingError($strings['errors']);
    $block1->contentError($error);
}

$block1->headingForm('NetOffice : ' . $strings['login']);

$block1->openContent();
#$block1->contentTitle($strings['please_login']);
// build lang drop list
$selectLanguage = '<select name="languageForm">';
array_multisort($langValue, SORT_ASC, SORT_STRING);
foreach ($langValue as $key => $value) {
    if (file_exists('../languages/lang_' . $key . '.php')) {
        if ($langDefault == $key) {
            $selectLanguage .= '<option value="' . $key . '" selected>' . $value . ' (Default)</option>';
        } else {
            $selectLanguage .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
}
$selectLanguage .= '</select>';

$block1->contentRow($strings['language'], $selectLanguage);
$block1->contentRow('* ' . $strings['user_name'], '<input value="' . $loginForm . '" type="text" name="loginForm">');
$block1->contentRow('* ' . $strings['password'], '<input value="' . $passwordForm . '" type="password" name="passwordForm">');
$block1->contentRow($strings['remember_password'],'<input type="checkbox" name="rememberForm" value="on">');
$block1->contentRow('', '<input type="submit" name="loginSubmit" value="' . $strings['login'] . '"><br><br><br>' . buildLink('../general/sendpassword.php', $strings['forgot_pwd'], in));

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>