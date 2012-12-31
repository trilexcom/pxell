<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteclients.php,v 1.7 2005/01/20 16:41:58 madbear Exp $
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

// these user levels can't perform this action
if ( ($_SESSION['profilSession'] == 4) || ($_SESSION['profilSession'] == 3) || 
     ($_SESSION['profilSession'] == 2) ) {
    header("Location: ../general/home.php?msg=permissiondenied");
    exit;
}

if ($action == 'delete') {
	$id = str_replace('**', ',', $id);
	$tmpquery = "WHERE org.id IN($id)";

	$listOrganizations = new request();
	$listOrganizations->openOrganizations($tmpquery);
	$comptListOrganizations = count($listOrganizations->org_id);

	for ($i = 0; $i < $comptListOrganizations; $i++) {
	    if (file_exists('logos_clients/' . $listOrganizations->org_id[$i] . '.' . $listOrganizations->org_extension_logo[$i])) {
	        @unlink('logos_clients/' . $listOrganizations->org_id[$i] . '.' . $listOrganizations->org_extension_logo[$i]);
	    }
	}

	$tmpquery1 = 'DELETE FROM ' . $tableCollab['organizations'] . " WHERE id IN($id)";
	connectSql($tmpquery1);

	$tmpquery2 = 'UPDATE ' . $tableCollab['projects'] . " SET organization='1' WHERE organization IN($id)";
	connectSql($tmpquery2);

	$tmpquery3 = 'DELETE FROM ' . $tableCollab['members'] . " WHERE organization IN($id)";
	connectSql($tmpquery3);

	header('Location: ../clients/listclients.php?msg=delete');
	exit;
}



//----- header --------------------------------------------
$breadcrumbs[]=buildLink('../clients/listclients.php?', $strings['clients'], LINK_INSIDE);
$breadcrumbs[]=$strings['delete_organizations'];

$pageSection='clients';
require_once('../themes/' . THEME . '/header.php');

//----- content --------------------------------------------
$block1 = new block();

$block1->form = 'saP';
$block1->openForm("../clients/deleteclients.php?action=delete&amp;id=$id");

$block1->headingForm($strings['delete_organizations']);

$block1->openContent();
$block1->contentTitle($strings['delete_following']);

$id = str_replace('**', ',', $id);
$tmpquery = "WHERE org.id IN($id) ORDER BY org.name";

$listOrganizations = new request();
$listOrganizations->openOrganizations($tmpquery);
$comptListOrganizations = count($listOrganizations->org_id);

for ($i = 0; $i < $comptListOrganizations; $i++) {
    $block1->contentRow('#' . $listOrganizations->org_id[$i], $listOrganizations->org_name[$i]);
}

$block1->contentRow('', '<input type="submit" name="delete" value="' . $strings['delete'] . '"> <input type="button" name="cancel" value="' . $strings['cancel'] . '" onClick="history.back();">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

$block1->note($strings['delete_organizations_note']);

require_once('../themes/' . THEME . '/footer.php');

?>
