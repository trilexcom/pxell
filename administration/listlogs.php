<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listlogs.php,v 1.7 2004/12/15 19:43:11 madbear Exp $
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

if ($action == 'delete') {
    $tmpquery = 'DELETE FROM ' . $tableCollab['logs'];
    connectSql($tmpquery);
} 


//--- header ---
$breadcrumbs[]=buildLink('../administration/admin.php?', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['logs'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

//--- content ----
$block1 = new block();
$block1->form = 'adminD';
$block1->openForm('../administration/listlogs.php?action=delete&amp;id=' . $id . '#' . $block1->form . 'Anchor');
$block1->headingForm($strings['logs']);
$block1->openResults($checkbox = false);
$block1->labels($labels = array(0 => $strings['user_name'], 1 => $strings['ip'], 2 => $strings['session'], 3 => $strings['compteur'], 4 => $strings['last_visit'], 5 => $strings['connected']), false, $sorting = false, $sortingOff = array(0 => '4', 1 => 'DESC'));

$tmpquery = 'ORDER BY last_visite DESC';

$listLogs = new request();
$listLogs->openLogs($tmpquery);
$comptListLogs = count($listLogs->log_id);

$dateunix = date("U");

for ($i = 0;$i < $comptListLogs;$i++) {
    $block1->openRow();
    $block1->checkboxRow($listLogs->log_id[$i], $checkbox = false);
    $block1->cellRow($listLogs->log_login[$i]);
    $block1->cellRow($listLogs->log_ip[$i]);
    $block1->cellRow($listLogs->log_session[$i]);
    $block1->cellRow($listLogs->log_compt[$i]);
    $block1->cellRow(createDate($listLogs->log_last_visite[$i], $_SESSION['timezoneSession']));

    if ($listLogs->log_mem_profil[$i] == 3) {
        $z = '(Client on project site)';
    } else {
        $z = '';
    } 

    if ($listLogs->log_connected[$i] > $dateunix - 5 * 60) {
        $block1->cellRow($strings['yes'] . ' ' . $z);
    } else {
        $block1->cellRow($strings['no']);
    } 

    $block1->closeRow();
} 

$block1->closeResults();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
