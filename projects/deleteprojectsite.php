<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteprojectsite.php,v 1.5 2004/12/15 12:25:13 pixtur Exp $
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
#$msg = $_REQUEST['msg'];
#$action = $_REQUEST['action'];
#$project = $_REQUEST['project'];

if ($action == 'delete') {
    $tmpquery = 'UPDATE ' . $tableCollab['projects'] . " SET published='1' WHERE id = '$project'";
    connectSql($tmpquery);
    header('Location: ../projects/viewproject.php?id=$project&msg=removeProjectSite');
    exit;
}


$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);



//--- header ---
$breadcrumbs[]=buildLink('../projects/listprojects.php?', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=buildLink('../projects/viewproject.php?id=' . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink('../projects/viewprojectsite.php?id=' . $projectDetail->pro_id[0], $strings['project_site'], LINK_INSIDE);
$breadcrumbs[]=$strings['delete_projectsite'];


$pageSection='projects';

require_once('../themes/' . THEME . '/header.php');


//--- content -------
$block1 = new block();

$block1->form = 'projectsite_delete';
$block1->openForm('../projects/deleteprojectsite.php?action=delete&amp;project=' . $project);

$block1->headingForm($strings['delete_projectsite']);

$block1->openContent();
$block1->contentTitle($strings['delete_following']);

$block1->contentRow('', $projectDetail->pro_name[0]);
$block1->contentRow('', '<input type="submit" name="delete" value="' . $strings['delete'] . '"> <input type="button" name="cancel" value="' . $strings['cancel'] . '" onClick="history.back();">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
