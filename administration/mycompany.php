<?php // $Revision: 1.9 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: mycompany.php,v 1.9 2004/12/22 22:15:42 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

if ($_SESSION['profilSession'] != 0) {
    header('Location: ../general/permissiondenied.php');
    exit;
} 

$action = $_GET['action'];

if ($action == 'update') {
    $extension = $_POST['extension'];
    $extensionOld = $_POST['extensionOld'];
    $cn = $_POST['cn'];
    $add = $_POST['add'];
    $wp = $_POST['wp'];
    $url = $_POST['url'];
    $email = $_POST['email'];
    $c = $_POST['c'];
    $logoDel = $_POST['logoDel'];

    if ($logoDel == 'on') {
        $tmpquery = 'UPDATE ' . $tableCollab['organizations'] . " SET extension_logo='' WHERE id='1'";
        connectSql($tmpquery);
        @unlink("../logos_clients/1.$extensionOld");
    } 

    $extension = strtolower(substr(strrchr($_FILES['upload']['name'], '.'), 1));

    if (@move_uploaded_file($_FILES['upload']['tmp_name'], "../logos_clients/1.$extension")) {
        $tmpquery = 'UPDATE ' . $tableCollab['organizations'] . " SET extension_logo='$extension' WHERE id='1'";
        connectSql($tmpquery);
    } 

    $cn = convertData($cn);
    $add = convertData($add);
    $c = convertData($c);
    $tmpquery = 'UPDATE ' . $tableCollab['organizations'] . " SET name='$cn',address1='$add',phone='$wp',url='$url',email='$email',comments='$c' WHERE id = '1'";
    connectSql($tmpquery);
    header('Location: ../administration/mycompany.php');
} 

$tmpquery = "WHERE org.id='1'";

$clientDetail = new request();
$clientDetail->openOrganizations($tmpquery);

$cn = $clientDetail->org_name[0];
$add = $clientDetail->org_address1[0];
$wp = $clientDetail->org_phone[0];
$url = $clientDetail->org_url[0];
$email = $clientDetail->org_email[0];
$c = $clientDetail->org_comments[0];



//--- header ---------
$breadcrumbs[]=buildLink('../administration/admin.php?', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['company_details'];


$bodyCommand = 'onLoad="document.adminDForm.cn.focus();"';

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

//---- content -------
$blockPage= new block();

$block1 = new block();
echo '<a name="' . $block1->form . 'Anchor"></a>';
echo '<form accept-charset="UNKNOWN" method="POST" action="../administration/mycompany.php?action=update" name="adminDForm" enctype="multipart/form-data">';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="100000000">';

if ($error != '') {
    $block1->headingError($strings['errors']);
    $block1->contentError($error);
} 

$block1->headingForm($strings['company_details']);
$block1->openContent();
$block1->contentTitle($strings['company_info']);
$block1->contentRow($strings['name'], '<input size="44" value="' . $cn . '" style="width: 400px" name="cn" maxlength="100" type="TEXT">');
$block1->contentRow($strings['address'], '<textarea rows="3" style="width: 400px; height: 50px;" name="add" cols="43">' . $add . '</textarea>');
$block1->contentRow($strings['phone'], '<input size="32" value="' . $wp . '" style="width: 250px" name="wp" maxlength="32" type="TEXT">');
$block1->contentRow($strings['url'], '<input size="44" value="' . $url . '" style="width: 400px" name="url" maxlength="2000" type="TEXT">');
$block1->contentRow($strings['email'], '<input size="44" value="' . $email . '" style="width: 400px" name="email" maxlength="2000" type="TEXT">');
$block1->contentRow($strings['comments'], '<textarea rows="3" style="width: 400px; height: 50px;" name="c" cols="43">' . $c . '</textarea>');
$block1->contentRow($strings['logo'] . $blockPage->printHelp('mycompany_logo'), '<input size="44" style="width: 400px" name="upload" type="file">');

if (file_exists('../logos_clients/1.' . $clientDetail->org_extension_logo[0])) {
    $block1->contentRow('', '<img src="../logos_clients/1.' . $clientDetail->org_extension_logo[0] . '" border="0" alt="' . $clientDetail->org_name[0] . '"><input name="extensionOld" type="hidden" value="' . $clientDetail->org_extension_logo[0] . '"> <input name="logoDel" type="checkbox" value="on"> ' . $strings['delete']);
} 

$block1->contentRow('', '<input type="SUBMIT" value="' . $strings['save'] . '">');
$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
