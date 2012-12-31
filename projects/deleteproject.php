<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteproject.php,v 1.7 2004/12/15 19:43:35 madbear Exp $
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

if ($enable_cvs == 'true') {
    require_once('../includes/cvslib.php');
}

$id = str_replace('**', ',', $id);
$tmpquery = 'WHERE pro.id IN(' . $id . ') ORDER BY pro.name';
$listProjects = new request();
$listProjects->openProjects($tmpquery);
$comptListProjects = count($listProjects->pro_id);

if ($comptListProjects == '0') {
    header('Location: ../projects/listprojects.php?msg=blankProject');
    exit;
}

if ($_SESSION['idSession'] != $listProjects->pro_owner[0] && $_SESSION['profilSession'] != '5') {
    header('Location: ../projects/listprojects.php?msg=projectOwner');
    exit;
}

if ($action == 'delete') {
    $id = str_replace('**', ',', $id);
    $tmpquery1 = 'DELETE FROM ' . $tableCollab['projects'] . ' WHERE id IN(' . $id . ')';
    $pieces = explode(',', $id);
    $comptPro = count($pieces);

    for ($i = 0; $i < $comptPro; $i++) {
        if ($fileManagement == 'true') {
            delDir('../files/' . $pieces[$i]);
        }

        if ($sitePublish == 'true') {
            delDir('project_sites/' . $pieces[$i]);
        }

        // if CVS repository enabled
        if ($enable_cvs == 'true') {
            cvs_delete_repository($pieces[$i]);
        }
    }

    $tmpquery = 'WHERE tas.project IN(' . $id . ')';
    $listTasks = new request();
    $listTasks->openTasks($tmpquery);
    $comptListTasks = count($listTasks->tas_id);

    for ($i = 0; $i < $comptListTasks; $i++) {
        if ($fileManagement == 'true') {
            delDir('../files/' . $id .'/' . $listTasks->tas_id[$i]);
        }

        $tasks .= $listTasks->tas_id[$i];

        if ($i != $comptListTasks - 1) {
            $tasks .= ',';
        }
    }

    $tmpquery = 'WHERE topic.project IN(' . $id .')';
    $listTopics = new request();
    $listTopics->openTopics($tmpquery);
    $comptListTopics = count($listTopics->top_id);

    for ($i = 0; $i < $comptListTopics; $i++) {
        $topics .= $listTopics->top_id[$i];

        if ($i != $comptListTopics - 1) {
            $topics .= ',';
        }
    }

    connectSql($tmpquery1);

    $tmpquery2 = 'DELETE FROM ' . $tableCollab['tasks'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery2);

    $tmpquery3 = 'DELETE FROM ' . $tableCollab['teams'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery3);

    $tmpquery4 = 'DELETE FROM ' . $tableCollab['topics'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery4);

    $tmpquery5 = 'DELETE FROM ' . $tableCollab['files'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery5);

    if ($tasks != '') {
        $tmpquery6 = 'DELETE FROM ' . $tableCollab['assignments'] . ' WHERE task IN(' . $tasks .')';
        connectSql($tmpquery6);
    }

    if ($topics != '') {
        $tmpquery7 = 'DELETE FROM ' . $tableCollab['posts'] . ' WHERE topic IN(' . $topics .')';
        connectSql($tmpquery7);
    }

    $tmpquery8 = 'DELETE FROM ' . $tableCollab['notes'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery8);

    $tmpquery9 = 'DELETE FROM ' . $tableCollab['support_requests'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery9);

    $tmpquery10 = 'DELETE FROM ' . $tableCollab['support_posts'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery10);

    $tmpquery11 = 'DELETE FROM ' . $tableCollab['phases'] . ' WHERE project_id IN(' . $id .')';
    connectSql($tmpquery11);

    $tmpquery12 = 'DELETE FROM ' . $tableCollab['tasks_time'] . ' WHERE project IN(' . $id .')';
    connectSql($tmpquery12);

    // if mantis bug tracker enabled
    if ($enableMantis == 'true') {
        // call mantis function to delete project
        require_once('../mantis/proj_delete.php');
    }

    header('Location: ../projects/listprojects.php?msg=delete');
    exit;
} 



//--- header ----
$breadcrumbs[]=buildLink('../projects/listprojects.php?', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=$strings['delete_projects'];

$pageSection='projects';

require_once('../themes/' . THEME . '/header.php');

//--- content ---
$block1 = new block();

$block1->form = 'saP';
$block1->openForm('../projects/deleteproject.php?action=delete&amp;id=' . $id);

$block1->headingForm($strings['delete_projects']);

$block1->openContent();
$block1->contentTitle($strings['delete_following']);

for ($i = 0; $i < $comptListProjects; $i++) {
    $block1->contentRow('#' . $listProjects->pro_id[$i], $listProjects->pro_name[$i]);
}

$block1->contentRow('', '<input type="submit" name="delete" value="' . $strings['delete'] . '"> <input type="button" name="cancel" value="' . $strings['cancel'] . '" onClick="history.back();">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
