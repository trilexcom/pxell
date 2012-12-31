<?php // $Revision: 1.10 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listprojects.php,v 1.10 2005/06/11 05:23:55 vjack Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

/**
 * listprojects.php
 *
 * list projects grouped by either 'Active', 'Inavtive', or 'All' by 
 * assigned status and sortable by header fields.
 */

$checkSession = true;
require_once('../includes/library.php');

#$show = $_REQUEST['show'];
#$borne1 = $_REQUEST['borne1'];
#$msg = $_REQUEST['msg'];

if ($show == '') {
    $show = 'active';
}



//--- breadcrumbs ---
$blockPage = new block();

$breadcrumbs[]=$strings['projects'];

if ($show == 'inactive') {
	$breadcrumbs[]=
		buildLink('../projects/listprojects.php?show=active', $strings['active'], in)
		.' | '. $strings['inactive']
		.' | '. buildLink('../projects/listprojects.php?show=all', $strings['all'], LINK_INSIDE);
}
else if ($show == 'active') {
	$breadcrumbs[]=
	    $strings['active']
		.' | '
		.buildLink('../projects/listprojects.php?show=inactive', $strings['inactive'], in)
		.' | '
		.buildLink('../projects/listprojects.php?show=all', $strings['all'], LINK_INSIDE);
}
else if ($show == 'all') {
    $breadcrumbs[]=
    	buildLink('../projects/listprojects.php?show=active', $strings['active'], in)
    	. ' | ' . buildLink('../projects/listprojects.php?show=inactive', $strings['inactive'], LINK_INSIDE)
    	. ' | ' . $strings['all'];
}


//--- print header ---
$pageSection='projects';
require_once('../themes/' . THEME . '/header.php');


$blockPage= new block();
$blockPage->bornesNumber = '1';

{

	$block1 = new block();

	$block1->form = 'saP';
	$block1->openForm('../projects/listprojects.php?borne1=' . $borne1 . '&show=' . $show . '#' . $block1->form . 'Anchor');

	$block1->heading($strings['projects']);

	$block1->openPaletteIcon();

	if ($_SESSION['profilSession'] == 0 || $_SESSION['profilSession'] == 1 || $_SESSION['profilSession'] == 5) {
	    $block1->paletteIcon(0, 'add', $strings['add']);
	    $block1->paletteIcon(1, 'remove', $strings['delete']);
	}

	$block1->paletteIcon(2, 'info', $strings['view']);

	if ($_SESSION['profilSession'] == 0 || $_SESSION['profilSession'] == 1 || $_SESSION['profilSession'] == 5) {
	    $block1->paletteIcon(3, 'edit', $strings['edit']);
	    $block1->paletteIcon(4, 'copy', $strings['copy']);
	}

	if ($enable_cvs == 'true') {
	    $block1->paletteIcon(7, 'cvs', $strings['browse_cvs']);
	}

	// will be replacing with internal module for bug tracking
	if ($enableMantis == 'true') {
	    $block1->paletteIcon(8, 'bug', $strings['bug']);
	}
	$block1->closePaletteIcon();

	$block1->borne = $blockPage->returnBorne('1');
	$block1->rowsLimit = 20;
	
	$block1->sorting(
	   'projects', 
	   $sortingUser->sor_projects[0], 
	   'pro.name ASC', 
	   $sortingFields = array(
	       #'pro.id', 
	       'pro.priority', 
	       'pro.name', 
	       'org.name', 
	       'pro.status', 
	       'mem.login', 
	       'pro.published'
	       )
	   );

	if ($show == 'inactive') {
	    if ($projectsFilter == 'true') {
	        $tmpquery = 'LEFT OUTER JOIN ' . $tableCollab['teams'] . ' teams ON teams.project = pro.id ';
	        $tmpquery .= ' WHERE pro.status IN(1,4,6) AND teams.member = ' . $_SESSION['idSession'] . ' ORDER BY ' . $block1->sortingValue;
	    } else {
	        $tmpquery = 'WHERE pro.status IN(1,4,6) ORDER BY ' . $block1->sortingValue;
	    }
	} else if ($show == 'active') {
	    if ($projectsFilter == 'true') {
	        $tmpquery = 'LEFT OUTER JOIN ' . $tableCollab['teams'] . ' teams ON teams.project = pro.id ';
	        $tmpquery .= 'WHERE pro.status IN(0,2,3,5) AND teams.member = ' . $_SESSION['idSession'] . ' ORDER BY ' . $block1->sortingValue;
	    } else {
	        $tmpquery = 'WHERE pro.status IN(0,2,3,5) ORDER BY ' . $block1->sortingValue;
	    }
	} else if ($show == 'all') {
	    if ($projectsFilter == 'true') {
	        $tmpquery = 'LEFT OUTER JOIN ' . $tableCollab['teams'] . ' teams ON teams.project = pro.id ';
	        $tmpquery .= 'WHERE teams.member = ' . $_SESSION['idSession'] . ' ORDER BY ' . $block1->sortingValue;
	    } else {
	        $tmpquery = 'ORDER BY ' . $block1->sortingValue;
	    }
	}

	$block1->recordsTotal = compt($initrequest['projects'] . ' ' . $tmpquery);

	$listProjects = new request();
	$listProjects->openProjects($tmpquery, $block1->borne, $block1->rowsLimit);
	$comptListProjects = count($listProjects->pro_id);

	if ($comptListProjects != 0) {
	    $block1->openResults();
	    
	    $block1->labels(
	       $labels = array(
	               #$strings['id'], 
	               #$strings['priority'], 
	               "P",
	               $strings['project'], 
	               $strings['organization'], 
	               $strings['status'], 
	               $strings['owner'], 
	               $strings['project_site']
	           ), 
	           'true'
	       );

	    for ($i = 0; $i < $comptListProjects; $i++) {
	        if ($listProjects->pro_org_id[$i] == 1) {
	            $listProjects->pro_org_name[$i] = $strings['none'];
	        }

	        $idStatus = $listProjects->pro_status[$i];
	        $idPriority = $listProjects->pro_priority[$i];

	        $block1->openRow($listProjects->pro_id[$i]);
	        $block1->checkboxRow($listProjects->pro_id[$i]);

	        //--- id ---
	        //$block1->cellRow(buildLink('../projects/viewproject.php?id=' . $listProjects->pro_id[$i], $listProjects->pro_id[$i], LINK_INSIDE));
	        
	        //--- prio ----
	        $block1->cellRow(
	        	'<img src="../themes/'. THEME . '/gfx_priority/' . $idPriority . '.gif" title="' . $priority[$idPriority] . '">',
	        	#"&nbsp;".$priority[$idPriority]
	        	"1", true);
	        	
	        //--- name  ---
	        $block1->cellRow(buildLink(
	            '../projects/viewproject.php?id=' . $listProjects->pro_id[$i], $listProjects->pro_name[$i], LINK_INSIDE),
	            "30"
	        );
	        
	        //--- client ----
	        $block1->cellRow($listProjects->pro_org_name[$i]);

	        //--- status ---
	        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

	        //--- owner ----
	        $block1->cellRow(buildLink($listProjects->pro_mem_email_work[$i], $listProjects->pro_mem_login[$i], LINK_MAIL),false,true);

	        //--- project-site ------
	        if ($sitePublish == 'true') {
	            if ($listProjects->pro_published[$i] == "1") {
	                $block1->cellRow('&lt;' . buildLink('../projects/addprojectsite.php?id=' . $listProjects->pro_id[$i], $strings['create'] . '...', LINK_INSIDE) . '&gt;', "8");
	            } else {
	                $block1->cellRow('&lt;' . buildLink('../projects/viewprojectsite.php?id=' . $listProjects->pro_id[$i], $strings['details'], LINK_INSIDE) . '&gt;', "8");
	            }
	        }

	        $block1->closeRow();
	    }

	    $block1->closeResults();
	    $block1->bornesFooter(1, $blockPage->bornesNumber, '', 'show=' . $show);
	} else {
	    $block1->noresults();
	}

	$block1->closeFormResults();
	$block1->headingForm_close();	//added


	$block1->openPaletteScript();

	if ($_SESSION['profilSession'] == 0 || $_SESSION['profilSession'] == 1 || $_SESSION['profilSession'] == 5) {
	    $block1->paletteScript(0, 'add', '../projects/editproject.php', 'true,false,false', $strings['add']);
	    $block1->paletteScript(1, 'remove', '../projects/deleteproject.php', 'false,true,false', $strings['delete']);
	}

	$block1->paletteScript(2, 'info', '../projects/viewproject.php', 'false,true,false', $strings['view']);

	if ($_SESSION['profilSession'] == 0 || $_SESSION['profilSession'] == 1 || $_SESSION['profilSession'] == 5) {
	    $block1->paletteScript(3, 'edit', '../projects/editproject.php', 'false,true,false', $strings['edit']);
	    $block1->paletteScript(4, 'copy', '../projects/editproject.php?cpy=true', 'false,true,false', $strings['copy']);
	}

	if ($enable_cvs == 'true') {
	    $block1->paletteScript(7, 'cvs', '../browsecvs/browsecvs.php', 'false,true,false', $strings['browse_cvs']);
	}

	// this will be replced with the internal bug module in the future
	if ($enableMantis == 'true') {
	    $block1->paletteScript(8, 'bug', $pathMantis . "login.php?url=http://{$HTTP_HOST}{$REQUEST_URI}&f_username=" . $_SESSION['loginSession'] . "&f_password=" . $_SESSION['passwordSession'], 'false,true,false', $strings['bug']);
	}

	$block1->closePaletteScript($comptListProjects, $listProjects->pro_id);
}


require_once('../themes/' . THEME . '/footer.php');

?>