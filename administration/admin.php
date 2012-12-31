<?php // $Revision: 1.9 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: admin.php,v 1.9 2005/01/27 10:32:28 dylan_cuthbert Exp $
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

$breadcrumbs[]=buildLink('../administration/admin.php', $strings['administration'], LINK_INSIDE);
$breadcrumbs[]=$strings['admin_intro'];

$pageSection = 'admin';
require_once('../themes/' . THEME . '/header.php');

$block1 = new block();
$block1->headingForm($strings['administration']);

$block1->openContent();
$block1->contentTitle($strings['admin_intro']);

$block1->contentRow('', buildLink('../users/listusers.php', $strings['user_management'], LINK_INSIDE));
$block1->contentRow('', buildLink('../services/listservices.php', $strings['service_management'], LINK_INSIDE));

if ($supportType == 'admin') {
    $block1->contentRow('', buildLink('../administration/support.php', $strings['support_management'], LINK_INSIDE));
}

if ($databaseType == 'mysql') {
    $block1->contentRow('', buildLink('../administration/phpmyadmin.php', $strings['database'], LINK_INSIDE));
}

$block1->contentRow('', buildLink('../administration/systeminfo.php', text('system_information'), LINK_INSIDE));
$block1->contentRow('', buildLink('../administration/mycompany.php', text('company_details'), LINK_INSIDE));
$block1->contentRow('', buildLink('../administration/listlogs.php', text('logs' ), LINK_INSIDE));
$block1->contentRow('', buildLink('../administration/updatesettings.php', text('edit_settings'), LINK_INSIDE));
$block1->contentRow('', buildLink('../administration/listholidays.php', text('edit_holidays'), LINK_INSIDE));
$block1->contentRow('', buildLink('../administration/edit_language.php', text('edit_language'), LINK_INSIDE));

if ($updateChecker == 'true' && $installationType == 'online') {
    $block1->contentRow('', updatechecker($version));
}

if (is_dir('../installation')) {
    $block1->contentRow('', '<b>' . $strings['attention'] . '</b> : ' . $strings['install_erase']);
}

$block1->closeContent();
$block1->headingForm_close();


require_once('../themes/' . THEME . '/footer.php');

?>
