<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: support.php,v 1.6 2004/12/15 19:43:11 madbear Exp $
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

if ($_SESSION['profilSession'] != 0 || $enableHelpSupport != 'true') {
    header('Location: ../general/permissiondenied.php');
    exit;
} 




$breadcrumbs[]=buildLink('../administration/admin.php?', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['support_management'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

if ($enableHelpSupport == true) {
    $tmpquery = "WHERE sr.status='0'";
    $listNewRequests = new request();
    $listNewRequests->openSupportRequests($tmpquery);
    $comptListNewRequests = count($listNewRequests->sr_id);

    $tmpquery = "WHERE sr.status='1'";
    $listOpenRequests = new request();
    $listOpenRequests->openSupportRequests($tmpquery);
    $comptListOpenRequests = count($listOpenRequests->sr_id);

    $tmpquery = "WHERE sr.status='2'";
    $listCompleteRequests = new request();
    $listCompleteRequests->openSupportRequests($tmpquery);
    $comptListCompleteRequests = count($listCompleteRequests->sr_id);

    $block1 = new block();
    $block1->form = 'help';

    if ($error != '') {
        $block1->headingError($strings['errors']);
        $block1->contentError($error);
    } 

    $block1->headingForm($strings['support_requests']);
    $block1->openContent();
    $block1->contentTitle($strings['information']);
    $block1->contentRow($strings['new_requests'], "$comptListNewRequests - " . buildLink('../support/support.php?action=new', $strings['manage_new_requests'], LINK_INSIDE) . '<br><br>');
    $block1->contentRow($strings['open_requests'], "$comptListOpenRequests - " . buildLink('../support/support.php?action=open', $strings['manage_open_requests'], LINK_INSIDE) . '<br><br>');
    $block1->contentRow($strings['closed_requests'], "$comptListCompleteRequests - " . buildLink('../support/support.php?action=complete', $strings['manage_closed_requests'], LINK_INSIDE) . '<br><br>');
    $block1->closeContent();
} 
$block1->headingForm_close();

require_once('../themes/' . THEME . '/footer.php');

?>
