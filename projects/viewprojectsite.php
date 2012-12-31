<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewprojectsite.php,v 1.8 2004/12/17 11:58:32 pixtur Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

#$id = $_REQUEST['id'];
#$msg = $_REQUEST['msg'];
#$action = $_REQUEST['action'];
#$project = $_REQUEST['project'];
#$addToSiteTeam = $_REQUEST['addToSiteTeam'];
#$removeToSiteTeam = $_REQUEST['removeToSiteTeam'];
#$action = $_REQUEST['action'];

if ($action == 'publish') {
    if ($addToSiteTeam == 'true') {
        $multi = strstr($id, '**');

        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['teams'] . " SET published='0' WHERE member IN($id) AND project = '$project'";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['teams'] . " SET published='0' WHERE member = '$id' AND project = '$project'";
        } 

        connectSql($tmpquery1);
        $msg = 'addToSite';
        $id = $project;
    } 

    if ($removeToSiteTeam == 'true') {
        $multi = strstr($id, '**');

        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['teams'] . " SET published='1' WHERE member IN($id) AND project = '$project'";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['teams'] . " SET published='1' WHERE member = '$id' AND project = '$project'";
        } 

        connectSql($tmpquery1);
        $msg = 'removeToSite';
        $id = $project;
    } 
} 

if ($msg == 'demo') {
    $id = $project;
} 

$tmpquery = "WHERE pro.id = '$id'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);
$comptProjectDetail = count($projectDetail->pro_id);

$teamMember = 'false';
$tmpquery = "WHERE tea.project = '$id' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);

if ($comptMemberTest == '0') {
    $teamMember = 'false';
} else {
    $teamMember = 'true';
} 

if ($teamMember == 'false' && $projectsFilter == 'true') {
    header('Location:../general/permissiondenied.php');
    exit;
} 

if ($comptPro == '0') {
    header('Location: ../projects/listprojects.php?msg=blankProject');
    exit;
} 




//--- header ----------
$breadcrumbs[]=buildLink('../projects/listprojects.php', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=buildLink('../projects/viewproject.php?id=' . $id, $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings['project_site'];

$pageSection='projects';

require_once('../themes/' . THEME . '/header.php');

//=== content ================================


//--- details ---------------
{
	$block1 = new block();

	$block1->form = 'uploadlogo';

	$block1->form = 'pdD';
	$block1->openForm('../projects/viewprojectsite.php?action=update&amp;id=' . $id . '&amp;#' . $block1->form . 'Anchor');

	$block1->heading($strings['project_site'] . ' : ' . $projectDetail->pro_name[0]);

	if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
	    $block1->openPaletteIcon();
	    $block1->paletteIcon(0, 'remove', $strings['delete']);
	    // $block1->paletteIcon(1,'template',$strings['template']);
	    // $block1->paletteIcon(2,'edit',$strings['edit']);
	    $block1->closePaletteIcon();
	}
	else {
		$block1->headingToggle_close();
	}

	$block1->openContent();
	$block1->contentTitle($strings['details']);

	$block1->contentRow($strings['project'], buildLink('../projects/viewproject.php?id=' . $id, $projectDetail->pro_name[0] . ' (#' . $projectDetail->pro_id[0] . ')', LINK_INSIDE));

	if ($projectDetail->pro_org_id[0] == '1') {
	    $block1->contentRow($strings['organization'], $strings['none']);
	} else {
	    $block1->contentRow($strings['organization'], buildLink('../clients/viewclient.php?id=' . $projectDetail->pro_org_id[0], $projectDetail->pro_org_name[0], LINK_INSIDE));
	}

	$block1->closeContent();
	$block1->block_close();
	$block1->closeForm();

	if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
	    $block1->openPaletteScript();
	    $block1->paletteScript(0, 'remove', '../projects/deleteprojectsite.php?project=' .$id, 'true,true,true', $strings['delete']);
	    // $block1->paletteScript(1,'template','addtemplate.php','true,true,true',$strings['template']);
	    // $block1->paletteScript(1,'template','editprojectsite.php','true,true,false',$strings['template']);
	    $block1->closePaletteScript('', '');
	}
}

//--- client permitted users -----------------------
if ($projectDetail->pro_organization[0] != '' && $projectDetail->pro_organization[0] != '1') {
    $block2 = new block();

    $block2->form = 'csU';
    $block2->openForm('../projects/viewprojectsite.php?id=' . $projectDetail->pro_id[0] . '#' . $block2->form . 'Anchor');

    $block2->heading($strings['permitted_client']);

    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block2->openPaletteIcon();
        $block2->paletteIcon(0, 'add', $strings['add']);
        $block2->paletteIcon(1, 'remove', $strings['delete']);

        if ($sitePublish == 'true') {
            $block2->paletteIcon(2, 'add_projectsite', $strings['add_project_site']);
            $block2->paletteIcon(3, 'remove_projectsite', $strings['remove_project_site']);
        }

        $block2->closePaletteIcon();
    }
    else {
		$block2->headingToggle_close();
	}

	$block2->openContent();
    $block2->sorting('team', $sortingUser->sor_team[0], 'mem.name ASC', $sortingFields = array(0 => 'mem.name', 1 => 'mem.title', 2 => 'mem.login', 3 => 'mem.phone_work', 4 => 'log.connected', 5 => 'tea.published'));

    $tmpquery = "WHERE tea.project = '$id' AND mem.profil = '3' ORDER BY $block2->sortingValue";
    $listPermitted = new request();
    $listPermitted->openTeams($tmpquery);
    $comptListPermitted = count($listPermitted->tea_id);

    if ($comptListPermitted != '0') {
        $block2->openResults();

        $block2->labels($labels = array(0 => $strings['full_name'], 1 => $strings['title'], 2 => $strings['user_name'], 3 => $strings['work_phone'], 4 => $strings['connected'], 5 => $strings['published']), 'true');

        for ($i = 0; $i < $comptListPermitted; $i++) {
            if ($listPermitted->tea_mem_phone_work[$i] == '') {
                $listPermitted->tea_mem_phone_work[$i] = $strings['none'];
            }

            $idPublish = $listPermitted->tea_published[$i];

            $block2->openRow($listPermitted->tea_mem_id[$i]);
            $block2->checkboxRow($listPermitted->tea_mem_id[$i]);

            $block2->cellRow(buildLink('../users/viewclientuser.php?id=' . $listPermitted->tea_mem_id[$i] . '&amp;organization=' . $projectDetail->pro_organization[0], $listPermitted->tea_mem_name[$i], LINK_INSIDE));
            $block2->cellRow($listPermitted->tea_mem_title[$i]);
            $block2->cellRow(buildLink($listPermitted->tea_mem_email_work[$i], $listPermitted->tea_mem_login[$i], LINK_MAIL));
            $block2->cellRow($listPermitted->tea_mem_phone_work[$i]);

            if ($listPermitted->tea_mem_profil[$i] == '3') {
                $z = '(Client on project site)';
            } else {
                $z = '';
            } 

            if ($listPermitted->tea_log_connected[$i] > $dateunix-5 * 60) {
                $block2->cellRow($strings['yes'] . ' ' . $z);
            } else {
                $block2->cellRow($strings['no']);
            } 

            if ($sitePublish == 'true') {
                $block2->cellRow($statusPublish[$idPublish]);
            } 

            $block2->closeRow();
        } 

        $block2->closeResults();
    } else {
        $block2->noresults();
    } 

    $block2->closeFormResults();

    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block2->openPaletteScript();
        $block2->paletteScript(0, 'add', '../teams/addclientuser.php?project=' . $id, 'true,false,false', $strings['add']);
        $block2->paletteScript(1, 'remove', '../teams/deleteclientusers.php?project=' . $id, 'false,true,true', $strings['delete']);

        if ($sitePublish == 'true') {
            $block2->paletteScript(2, 'add_projectsite', '../projects/viewprojectsite.php?addToSiteTeam=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block2->paletteScript(3, 'remove_projectsite', '../projects/viewprojectsite.php?removeToSiteTeam=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        } 

        $block2->closePaletteScript($comptListPermitted, $listPermitted->tea_mem_id);
    } 
	$block2->closeContent();
	$block2->block_close();
	$block2->closeForm();

}

require_once('../themes/' . THEME . '/footer.php');

?>