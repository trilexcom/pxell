<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewclient.php,v 1.7 2004/12/16 17:10:33 pixtur Exp $
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

if ($clientsFilter == 'true' && $_SESSION['profilSession'] == '2') {
    $teamMember = 'false';
    $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "' AND org2.id = '$id'";
    $memberTest = new request();
    $memberTest->openTeams($tmpquery);
    $comptMemberTest = count($memberTest->tea_id);

    if ($comptMemberTest == '0') {
        header('Location: ../clients/listclients.php?msg=blankClient');
        exit;
    } else {
        $tmpquery = "WHERE org.id = '$id'";
    } 
} else if ($clientsFilter == 'true' && $_SESSION['profilSession'] == '1') {
    $tmpquery = "WHERE org.owner = '" . $_SESSION['idSession'] . "' AND org.id = '$id'";
} else {
    $tmpquery = "WHERE org.id = '$id'";
}

$clientDetail = new request();
$clientDetail->openOrganizations($tmpquery);
$comptClientDetail = count($clientDetail->org_id);

if ($comptClientDetail == '0') {
    header('Location: ../clients/listclients.php?msg=blankClient');
    exit;
}

//--- header---
$breadcrumbs[]=buildLink('../clients/listclients.php?', $strings['clients'], LINK_INSIDE);
$breadcrumbs[]=$clientDetail->org_name[0];
$pageSection='clients';
require_once('../themes/' . THEME . '/header.php');


//---- content ---

//---- client details ----------------------
{
	$block1 = new block();

	$block1->form = 'ecD';
	$block1->openForm('../projects/listprojects.php#' . $block1->form . 'Anchor');

	$block1->heading($strings['organization'] . ' : ' . $clientDetail->org_name[0]);

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block1->openPaletteIcon();
	    $block1->paletteIcon(0, 'remove', $strings['delete']);
	    $block1->paletteIcon(1, 'edit', $strings['edit']);
	    $block1->closePaletteIcon();
	}
	else {
		$block1->heading_close();
	}

	$block1->openContent();
	$block1->contentTitle($strings['details']);

	if ($clientsFilter == 'true') {
	    $block1->contentRow($strings['owner'], buildLink('../users/viewuser.php?id=' . $clientDetail->org_mem_id[0], $clientDetail->org_mem_name[0], LINK_INSIDE) . ' (' . buildLink($clientDetail->org_mem_email_work[0], $clientDetail->org_mem_login[0], LINK_MAIL) . ')');
	}

	$block1->contentRow($strings['name'], $clientDetail->org_name[0]);
	$block1->contentRow($strings['address'], $clientDetail->org_address1[0]);
	$block1->contentRow($strings['phone'], $clientDetail->org_phone[0]);
	$block1->contentRow($strings['url'], buildLink($clientDetail->org_url[0], $clientDetail->org_url[0], LINK_OUT));
	$block1->contentRow($strings['email'], buildLink($clientDetail->org_email[0], $clientDetail->org_email[0], LINK_MAIL));
	$block1->contentRow($strings['comments'], nl2br($clientDetail->org_comments[0]));
	$block1->contentRow($strings['created'], createDate($clientDetail->org_created[0], $_SESSION['timezoneSession']));

	if (file_exists('../logos_clients/' . $id . '.' . $clientDetail->org_extension_logo[0])) {
	    $block1->contentRow($strings['logo'], '<img src="../logos_clients/' . $id . '.' . $clientDetail->org_extension_logo[0] . '">');
	}

	$block1->closeContent();
	$block1->closeToggle();
	$block1->closeForm();

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block1->openPaletteScript();
	    $block1->paletteScript(0, 'remove', '../clients/deleteclients.php?id=' . $clientDetail->org_id[0], 'true,true,false', $strings['delete']);
	    $block1->paletteScript(1, 'edit', '../clients/editclient.php?id=' . $clientDetail->org_id[0], 'true,true,false', $strings['edit']);
	    $block1->closePaletteScript('', '');
	}
}

//--- client projects ---------------------------
{
	$block2 = new block();

	$block2->form = 'clPr';
	$block2->openForm("../clients/viewclient.php?id=$id#" . $block2->form . 'Anchor');

	$block2->headingToggle($strings['client_projects']);

	$block2->openPaletteIcon();

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block2->paletteIcon(0, 'add', $strings['add']);
	    $block2->paletteIcon(1, 'remove', $strings['delete']);
	}

	$block2->paletteIcon(2, 'info', $strings['view']);

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block2->paletteIcon(3, 'edit', $strings['edit']);
	}
	// if mantis bug tracker enabled
	if ($enableMantis == 'true') {
	    $block2->paletteIcon(4, 'bug', $strings['bug']);
	}

	$block2->closePaletteIcon();

	$block2->sorting('organization_projects', $sortingUser->sor_organization_projects[0], 'pro.name ASC', $sortingFields = array(0 => 'pro.id', 1 => 'pro.name', 2 => 'pro.priority', 3 => 'pro.status', 4 => 'mem.login', 5 => 'pro.published'));

	if ($projectsFilter == 'true') {
	    $tmpquery = 'LEFT OUTER JOIN ' . $tableCollab['teams'] . ' teams ON teams.project = pro.id ';
	    $tmpquery .= 'WHERE pro.organization = "' . $clientDetail->org_id[0] . '" AND teams.member = "' . $_SESSION['idSession'] . '" ORDER BY ' . $block2->sortingValue;
	} else {
	    $tmpquery = 'WHERE pro.organization = "' . $clientDetail->org_id[0] . '" ORDER BY ' . $block2->sortingValue;
	}

	$listProjects = new request();
	$listProjects->openProjects($tmpquery);
	$comptListProjects = count($listProjects->pro_id);

	if ($comptListProjects != '0') {
	    $block2->openResults();

	    $block2->labels($labels = array(0 => $strings['id'], 1 => $strings['project'], 2 => $strings['priority'], 3 => $strings['status'], 4 => $strings['owner'], 5 => $strings['project_site']), 'true');

	    for ($i = 0; $i < $comptListProjects; $i++) {
	        $idStatus = $listProjects->pro_status[$i];
	        $idPriority = $listProjects->pro_priority[$i];

	        $block2->openRow($listProjects->pro_id[$i]);
	        $block2->checkboxRow($listProjects->pro_id[$i]);
	        $block2->cellRow(buildLink('../projects/viewproject.php?id=' . $listProjects->pro_id[$i], $listProjects->pro_id[$i], LINK_INSIDE));
	        $block2->cellRow(buildLink('../projects/viewproject.php?id=' . $listProjects->pro_id[$i], $listProjects->pro_name[$i], LINK_INSIDE));
	        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);

	        $block2->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

	        $block2->cellRow(buildLink($listProjects->pro_mem_email_work[$i], $listProjects->pro_mem_login[$i], LINK_MAIL));

	        if ($sitePublish == 'true') {
	            if ($listProjects->pro_published[$i] == '1') {
	                $block2->cellRow('&lt;' . buildLink('../projects/addprojectsite.php?id=' . $listProjects->pro_id[$i], $strings['create'] . '...', LINK_INSIDE) . '&gt;');
	            } else {
	                $block2->cellRow('&lt;' . buildLink('../projects/viewprojectsite.php?id=' . $listProjects->pro_id[$i], $strings['details'], LINK_INSIDE) . '&gt;');
	            }
	        }
	    }

	    $block2->closeResults();
	} else {
	    $block2->noresults();
	}

	$block2->closeToggle();
	$block2->closeFormResults();

	$block2->openPaletteScript();
	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block2->paletteScript(0, 'add', '../projects/editproject.php?organization=' . $clientDetail->org_id[0], 'true,false,false', $strings['add']);
	    $block2->paletteScript(1, 'remove', '../projects/deleteproject.php?', 'false,true,false', $strings['delete']);
	}

	$block2->paletteScript(2, 'info', '../projects/viewproject.php?', 'false,true,false', $strings['view']);

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block2->paletteScript(3, 'edit', '../projects/editproject.php?', 'false,true,false', $strings['edit']);
	}
	// if mantis bug tracker enabled
	if ($enableMantis == 'true') {
	    $block2->paletteScript(4, 'bug', $pathMantis . "login.php?url=http://{$HTTP_HOST}{$REQUEST_URI}&f_username=" . $_SESSION['loginSession'] . "&f_password=" . $_SESSION['passwordSession'], 'false,true,false', $strings['bug']);
	}

	$block2->closePaletteScript($comptListProjects, $listProjects->pro_id);
}

//--- client users -----------------------------
{
	$block3 = new block();

	$block3->form = 'clU';
	$block3->openForm("../clients/viewclient.php?id=$id#" . $block3->form . 'Anchor');

	$block3->headingToggle($strings['client_users']);

	$block3->openPaletteIcon();

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block3->paletteIcon(0, 'add', $strings['add']);
	    $block3->paletteIcon(1, 'remove', $strings['delete']);
	}

	$block3->paletteIcon(2, 'info', $strings['view']);

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block3->paletteIcon(3, 'edit', $strings['edit']);
	}

	$block3->closePaletteIcon();

	$block3->sorting('users', $sortingUser->sor_users[0], 'mem.name ASC', $sortingFields = array(0 => 'mem.name', 1 => 'mem.login', 2 => 'mem.email_work', 3 => 'mem.profil', 4 => 'connected'));

	$tmpquery = "WHERE mem.organization = '$id' ORDER BY $block3->sortingValue";
	$listMembers = new request();
	$listMembers->openMembers($tmpquery);
	$comptListMembers = count($listMembers->mem_id);

	if ($comptListMembers != '0') {
	    $block3->openResults();

	    $block3->labels($labels = array(0 => $strings['full_name'], 1 => $strings['user_name'], 2 => $strings['email'], 3 => $strings['work_phone'], 4 => $strings['connected']), 'false');

	    for ($i = 0; $i < $comptListMembers; $i++) {
	        $block3->openRow($listMembers->mem_id[$i]);
	        $block3->checkboxRow($listMembers->mem_id[$i]);
	        $block3->cellRow(buildLink('../users/viewclientuser.php?id=' . $listMembers->mem_id[$i] . "&amp;organization=$id", $listMembers->mem_name[$i], LINK_INSIDE));
	        $block3->cellRow($listMembers->mem_login[$i]);
	        $block3->cellRow(buildLink($listMembers->mem_email_work[$i], $listMembers->mem_email_work[$i], LINK_MAIL));
	        $block3->cellRow($listMembers->mem_phone_work[$i]);

	        $z = '(Client on project site)';

	        if ($listMembers->mem_log_connected[$i] > $dateunix-5 * 60) {
	            $block3->cellRow($strings['yes'] . ' ' . $z);
	        } else {
	            $block3->cellRow($strings['no']);
	        }
	    }

	    $block3->closeResults();
	} else {
	    $block3->noresults();
	}

	$block3->closeToggle();
	$block3->closeFormResults();

	$block3->openPaletteScript();

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block3->paletteScript(0, 'add', '../users/addclientuser.php?organization=' . $id, 'true,true,true', $strings['add']);
	    $block3->paletteScript(1, 'remove', '../users/deleteclientusers.php?organization=' . $id, 'false,true,true', $strings['delete']);
	}

	$block3->paletteScript(2, 'info', '../users/viewclientuser.php?organization=' . $id, 'false,true,false', $strings['view']);

	if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
	    $block3->paletteScript(3, 'edit', '../users/updateclientuser.php?organization=' . $id, 'false,true,false', $strings['edit']);
	}

	$block3->closePaletteScript($comptListMembers, $listMembers->mem_id);
}

require_once('../themes/' . THEME . '/footer.php');

?>