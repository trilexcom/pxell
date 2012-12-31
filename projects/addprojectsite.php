<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addprojectsite.php,v 1.7 2004/12/15 19:43:35 madbear Exp $
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

#$id = $_REQUEST['id'];
#$action = $_REQUEST['action'];

$tmpquery = "WHERE pro.id = '$id'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
$comptProjectDetail = count($projectDetail->pro_id);

if ($comptProjectDetail == '0') {
    header('Location: ../projects/listprojects.php?msg=blankProject');
    exit;
}

if ($_SESSION['idSession'] != $projectDetail->pro_owner[0] && $_SESSION['profilSession'] != '5') {
    header('Location: ../projects/listprojects.php?msg=projectOwner');
    exit;
}

if ($action == 'create') {
    $tmpquery = 'UPDATE ' . $tableCollab['projects'] . " SET published='0' WHERE id = '$id'";
    connectSql($tmpquery);
    header('Location: ../projects/viewprojectsite.php?id=' . $id . '&msg=createProjectSite');
    exit;
}



//--- header ---
$breadcrumbs[]=buildLink('../projects/listprojects.php?', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=buildLink('../projects/viewproject.php?id=' . $id, $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings['create_projectsite'];

$pageSection='projects';

require_once('../themes/' . THEME . '/header.php');

//--- content ---
$block1 = new block();

$block1->form = 'csdD';
$block1->openForm('../projects/addprojectsite.php?action=create&amp;id=' . $id);

$block1->headingForm($strings['create_projectsite']);

$block1->openContent();
$block1->contentTitle($strings['details']);
$block1->contentRow($strings['project'], buildLink('../projects/viewproject.php?id=' . $id, $projectDetail->pro_name[0], LINK_INSIDE));

if ($projectDetail->pro_org_id[0] == '1') {
    $block1->contentRow($strings['organization'], $strings['none']);
} else {
    $block1->contentRow($strings['organization'], buildLink('../clients/viewclient.php?id=' . $projectDetail->pro_org_id[0], $projectDetail->pro_org_name[0], LINK_INSIDE));
}

$block1->contentRow('', '<input type="submit" value="' . $strings['create'] . '">');
$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
