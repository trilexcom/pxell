<?php // $Revision: 1.19 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: home.php,v 1.19 2005/06/11 05:23:55 vjack Exp $
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
$pageSection='home';


// DEBUG
// foreach ($_POST as $k => $v) { print "<font color=blue>\$_POST[$k] => $v</font><br>"; }
// foreach ($_GET as $k => $v) { print "<font color=green>\$_GET[$k] => $v</font><br>"; }
// foreach ($_SESSION as $k => $v) { print "<font color=red>\$_SESSION[$k] => $v</font><br>"; }
// foreach ($_COOKIE as $k => $v) { print "<font color=purple>\$_COOKIE[$k] => $v</font><br>"; }

$dateFilter='';
//--- construction date-filter for sql-querries ---
{
	$test = $date;
	$DateAnnee = substr($test, 0, 4);
	$DateMois = substr($test, 5, 2);
	$DateJour = substr($test, 8, 2);
	$DateMois = $DateMois - 1;

	if ($DateMois <= 0) {
	    $DateMois = $DateMois + 12;
	    $DateAnnee = $DateAnnee - 1;
	}

	$DateMois = (strlen($DateMois) > 1) ? $DateMois : '0' . $DateMois;

	$dateFilter = "$DateAnnee-$DateMois-$DateJour";
}


if ($action == 'publish') {
    if ($closeTopic == 'true') {
        $multi = strstr($id, '**');

        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET status='0' WHERE id IN($id)";
            $pieces = explode(',', $id);
            $num = count($pieces);
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET status='0' WHERE id = '$id'";
            $num = '1';
        }

        connectSql($tmpquery1);
        $msg = 'closeTopic';
    }

    if ($addToSiteTopic == 'true') {
        $multi = strstr($id, '**');

        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET published='0' WHERE id = '$id'";
        }

        connectSql($tmpquery1);
        $msg = 'addToSite';
    }

    if ($removeToSiteTopic == 'true') {
        $multi = strstr($id, '**');

        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET published='1' WHERE id = '$id'";
        }

        connectSql($tmpquery1);
        $msg = 'removeToSite';
    }
}



//--- build header ---


/* we don't need breadcrumbs in home

$breadcrumbs[]=buildLink('../general/home.php', $strings['home'], LINK_INSIDE));
$breadcrumbs[]=$_SESSION['nameSession']);

*/

$pageSection='home';
$pageTitle= "<span class=type>".$strings['home_of'] ."<br></span><span class=name>".$_SESSION['nameSession']."</span>";

require_once('../themes/' . THEME . '/header.php');

//--- content -----------------

//--- bookmarks ----------------------------------
{
	$block6 = new block();

	$block6->sorting('bookmarks', $sortingUser->sor_bookmarks[0], 'boo.name ASC', $sortingFields = array(0 => 'boo.name', 1 => 'boo.category', 2 => 'boo.shared'));

	$tmpquery = "WHERE boo.home = '1' AND boo.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block6->sortingValue";

	$listBookmarks = new request();
	$listBookmarks->openBookmarks($tmpquery);

	$comptListBookmarks = count($listBookmarks->boo_id);

	if ($comptListBookmarks != '0') {
	    $block6->form = 'boo';
	    $block6->openForm('../bookmarks/listbookmarks.php?view=my&amp;project=' . $project . '#' . $block6->form . 'Anchor');

	    $block6->headingToggle($strings['bookmarks_my']);

	    $block6->openPaletteIcon();
	    $block6->paletteIcon(0, 'add', $strings['add']);
	    $block6->paletteIcon(1, 'remove', $strings['delete']);
	    /*if ($sitePublish == 'true') {
			$block6->paletteIcon(3,'add_projectsite',$strings['add_project_site']);
			$block6->paletteIcon(4,'remove_projectsite',$strings['remove_project_site']);
		}*/
	    $block6->paletteIcon(5, 'info', $strings['view']);
	    $block6->paletteIcon(6, 'edit', $strings['edit']);

	    $block6->closePaletteIcon();

	    $block6->sorting('bookmarks', $sortingUser->sor_bookmarks[0], 'boo.name ASC', $sortingFields = array(0 => 'boo.name', 1 => 'boo.category', 2 => 'boo.shared'));

	    $tmpquery = "WHERE boo.home = '1' AND boo.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block6->sortingValue";

	    $listBookmarks = new request();
	    $listBookmarks->openBookmarks($tmpquery);

	    $comptListBookmarks = count($listBookmarks->boo_id);

	    if ($comptListBookmarks != '0') {
	        $block6->openResults();

	        $block6->labels($labels = array(0 => $strings['name'], 1 => $strings['bookmark_category'], 2 => $strings['shared']), 'false');

	        for ($i = 0;$i < $comptListBookmarks;$i++) {
	            $block6->openRow($listBookmarks->boo_id[$i]);
	            $block6->checkboxRow($listBookmarks->boo_id[$i]);
	            $block6->cellRow(buildLink("../bookmarks/viewbookmark.php?view=$view&amp;id=" . $listBookmarks->boo_id[$i], $listBookmarks->boo_name[$i], in) . ' ' . buildLink($listBookmarks->boo_url[$i], "(" . $strings["url"] . ")", LINK_OUT));
	            $block6->cellRow($listBookmarks->boo_boocat_name[$i]);

	            if ($listBookmarks->boo_shared[$i] == "1") {
	                $printShared = $strings["yes"];
	            } else {
	                $printShared = $strings["no"];
	            }

	            $block6->cellRow($printShared);
	            $block6->closeRow();
	        }

	        $block6->closeResults();
	    } else {
	        $block6->noresults();
	    }

	    $block6->closeToggle();
	    $block6->closeFormResults();

	    $block6->openPaletteScript();
	    $block6->paletteScript(0, "add", "../bookmarks/editbookmark.php", "true,false,false", $strings["add"]);
	    $block6->paletteScript(1, "remove", "../bookmarks/deletebookmarks.php", "false,true,true", $strings["delete"]);
	    /*$if ($sitePublish == "true") {
			$block6->paletteScript(3,"add_projectsite","../general/home.php?addToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["add_project_site"]);
			$block6->paletteScript(4,"remove_projectsite","../general/home.php?removeToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["remove_project_site"]);
		}*/

	    $block6->paletteScript(5, "info", "../bookmarks/viewbookmark.php", "false,true,false", $strings["view"]);
	    $block6->paletteScript(6, "edit", "../bookmarks/editbookmark.php", "false,true,false", $strings["edit"]);

	    $block6->closePaletteScript($comptListBookmarks, $listBookmarks->boo_id);
	}
}


//--- my projects -----------------
{
	$block1 = new block();

	$block1->form = "wbP";
	$block1->openForm('../general/home.php#' . $block1->form . 'Anchor');

	$block1->sorting(
		"home_projects",
		$sortingUser->sor_home_projects[0],
		"pro.name ASC",
		$sortingFields = array(
			#"pro.id",
			"pro.priority",
			"pro.name",
			"org2.name",
			"pro.status",
			"mem2.login",
			"pro.published"
		)
		);

	$tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "' AND pro.status IN(0,2,3,5) ORDER BY $block1->sortingValue";
	$listProjects = new request();
	$listProjects->openTeams($tmpquery);
	$comptListProjects = count($listProjects->tea_id);

	//--- title ---
	$block1->headingToggle($strings["my_projects"]." <span class=addition>($comptListProjects)</span>");
	$block1->openPaletteIcon();

	if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
	    $block1->paletteIcon(0, "add", $strings["add"]);
	    $block1->paletteIcon(1, "remove", $strings["delete"]);
	    $block1->paletteIcon(2, "copy", $strings["copy"]);
	    // $block1->paletteIcon(3,"import",$strings["import"]);
	    // $block1->paletteIcon(4,"export",$strings["export"]);
	}

	$block1->paletteIcon(5, "info", $strings["view"]);
	if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
	    $block1->paletteIcon(6, "edit", $strings["edit"]);
	}

	if ($enable_cvs == "true") {
	    $block1->paletteIcon(7, "cvs", $strings["browse_cvs"]);
	}
	// if mantis bug tracker enabled
	if ($enableMantis == "true") {
	    $block1->paletteIcon(8, "bug", $strings["bug"]);
	}
	$block1->closePaletteIcon();

	if ($comptListProjects != "0") {
	    $block1->openResults();

	    $block1->labels(
	    	$labels = array(
	    	#$strings["id"],
	    	#$strings["priority"],
	    	"P",
	    	$strings["project"],
	    	$strings["organization"],
	    	$strings["status"],
	    	$strings["owner"],
	    	$strings["project_site"]
	    	),
	    	'true'
	    );

	    for ($i = 0;$i < $comptListProjects;$i++) {
	        if ($listProjects->tea_org2_id[$i] == "1") {
	            $listProjects->tea_org2_name[$i] = $strings["none"];
	        }

	        $idStatus = $listProjects->tea_pro_status[$i];
	        $idPriority = $listProjects->tea_pro_priority[$i];

	        $block1->openRow($listProjects->tea_pro_id[$i]);
	        $block1->checkboxRow($listProjects->tea_pro_id[$i]);

            //--- id ---
	        #$block1->cellRow(buildLink("../projects/viewproject.php?id=" . $listProjects->tea_pro_id[$i], $listProjects->tea_pro_id[$i], LINK_INSIDE));

			//--- prio ----
	        $block1->cellRow(
	        	'<img src="../themes/'. THEME . '/gfx_priority/' . $idPriority . '.gif" title="' . $priority[$idPriority] . '">',
	        	#"&nbsp;".$priority[$idPriority]
	        	"1", true);

			//--- name  ---
	        $block1->cellRow(buildLink(
		        "../projects/viewproject.php?id=" . $listProjects->tea_pro_id[$i], $listProjects->tea_pro_name[$i], LINK_INSIDE),
	            "30"
	        );
	        // $block1->cellRow("<img src=\"../themes/".THEME."/gfx_priority/".$idPriority.".gif\" alt=\"\">&nbsp;".$priority[$idPriority]);


			//--- client ----
	        $block1->cellRow($listProjects->tea_org2_name[$i]);

			//--- status ---
	        $block1->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

			//--- owner ----
	        $block1->cellRow(
	        buildLink($listProjects->tea_mem2_email_work[$i], $listProjects->tea_mem2_login[$i], LINK_MAIL)
	        ,false,true
	        );

			//--- project-site ------
	        if ($sitePublish == "true") {
	            if ($listProjects->tea_pro_published[$i] == "1") {
	                $block1->cellRow("&lt;" . buildLink("../projects/addprojectsite.php?id=" . $listProjects->tea_pro_id[$i], $strings["create"] . "...", LINK_INSIDE) . "&gt;", "8");
	            } else {
	                $block1->cellRow("&lt;" . buildLink("../projects/viewprojectsite.php?id=" . $listProjects->tea_pro_id[$i], $strings["details"], LINK_INSIDE) . "&gt;", "8");
	            }
	        }

	        $block1->closeRow();
	        $projectsTopics .= $listProjects->tea_pro_id[$i];

	        if ($i != $comptListProjects-1) {
	            $projectsTopics .= ",";
	        }
	    }

	    $block1->closeResults();
	} else {
	    $block1->noresults();
	}

	$block1->closeToggle();
	$block1->closeFormResults();

	$block1->openPaletteScript();

	if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
	    $block1->paletteScript(0, "add", "../projects/editproject.php", "true,true,true", $strings["add"]);
	    $block1->paletteScript(1, "remove", "../projects/deleteproject.php", "false,true,false", $strings["delete"]);
	    $block1->paletteScript(2, "copy", "../projects/editproject.php?cpy=true", "false,true,false", $strings["copy"]);
	    // $block1->paletteScript(3,"import","import.php","true,false,false",$strings["import"]);
	    // $block1->paletteScript(4,"export","export.php","false,true,false",$strings["export"]);
	}

	$block1->paletteScript(5, "info", "../projects/viewproject.php", "false,true,false", $strings["view"]);

	if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
	    $block1->paletteScript(6, "edit", "../projects/editproject.php", "false,true,false", $strings["edit"]);
	}

	if ($enable_cvs == "true") {
	    $block1->paletteScript(7, "cvs", "../browsecvs/browsecvs.php", "false,true,false", $strings["browse_cvs"]);
	}
	// if mantis bug tracker enabled
	if ($enableMantis == "true") {
	    $block1->paletteScript(8, "bug", $pathMantis . "login.php?url=http://{$HTTP_HOST}{$REQUEST_URI}&f_username=" . $_SESSION['loginSession'] . "&f_password=" . $_SESSION['passwordSession'], "false,true,false", $strings["bug"]);
	}

	$block1->closePaletteScript($comptListProjects, $listProjects->tea_pro_id);
}

//--- my tasks --------------
{
	$block2 = new block();

	$block2->form = "xwbT";
	$block2->openForm("../general/home.php#" . $block2->form . "Anchor");


	$block2->sorting(
	"home_tasks",
	$sortingUser->sor_home_tasks[0],
	"tas.name ASC",
	$sortingFields = array(
		#"tas.id",
		"tas.priority",
		"tas.name",
		"tas.status",
		"tas.completion",
		"tas.due_date",
		"mem2.login",
		"pro.name",
		"tas.published"
	));

	$tmpquery = "WHERE tas.assigned_to = '$_SESSION[idSession]' AND tas.status IN(0,2,3) AND pro.status IN(0,2,3) AND tas.milestone = '1' ORDER BY $block2->sortingValue";

	$listTasks = new request();
	$listTasks->openTasks($tmpquery);
	$comptListTasks = count($listTasks->tas_id);

  	$block2->headingToggle($strings["my_tasks"]." <span class=addition>($comptListTasks)</span>");

	$block2->openPaletteIcon();

	$block2->paletteIcon(0, "remove", $strings["delete"]);
	$block2->paletteIcon(1, "copy", $strings["copy"]);
	// $block2->paletteIcon(2,"export",$strings["export"]);
	$block2->paletteIcon(3, "info", $strings["view"]);
	$block2->paletteIcon(4, "edit", $strings["edit"]);
	$block2->paletteIcon(5, "timelog", $strings["loghours"]);

	$block2->closePaletteIcon();


	if ($comptListTasks != "0") {
	    $block2->openResults();

	    $block2->labels($labels = array(
	    #$strings['id'],
	    #$strings['priority'],
		"P",
	    $strings['name'],
	    $strings['status'],
	    $strings['completion'],
	    $strings['due_date'],
	    $strings['assigned_by'],
	    $strings['project'],
	    $strings['published']
	    ), 'true');

	    for ($i = 0;$i < $comptListTasks;$i++) {
	        if ($listTasks->tas_due_date[$i] == "") {
	            $listTasks->tas_due_date[$i] = $strings["none"];
	        }

	        $idStatus = $listTasks->tas_status[$i];
	        $idPriority = $listTasks->tas_priority[$i];
	        $idPublish = $listTasks->tas_published[$i];
	        $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . "0 %": $listTasks->tas_completion[$i] . " %";
	        $block2->openRow($listTasks->tas_id[$i]);
	        $block2->checkboxRow($listTasks->tas_id[$i]);

			//--- id ----
	        #$block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_id[$i], LINK_INSIDE));

   			//--- prio ---
	        $block2->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" title="' . $priority[$idPriority] . '">' /*. $priority[$idPriority]*/, '', true);

			//--- name ---
	        $block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE),
	        "30");


			//--- status ---
	        $block2->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

			//--- completion ---
	        $block2->cellRow($complValue);

			//--- due date ---
	        if ($listTasks->tas_due_date[$i] <= $date && $listTasks->tas_completion[$i] != "10") {
	            $block2->cellRow("<b>" . $listTasks->tas_due_date[$i] . "</b>");
	        } else {
	            $block2->cellRow($listTasks->tas_due_date[$i]);
	        }

			//--- assigned by ---
	        $block2->cellRow(buildLink($listTasks->tas_mem2_email_work[$i], $listTasks->tas_mem2_login[$i], LINK_MAIL));

			//--- project ---
	        $block2->cellRow(buildLink("../projects/viewproject.php?id=" . $listTasks->tas_project[$i], $listTasks->tas_pro_name[$i], LINK_INSIDE),
	        "20");

			//--- published ---
	        if ($sitePublish == "true") {
	            $block2->cellRow($statusPublish[$idPublish], "8");
	        }

	        $block2->closeRow();
	    }

	    $block2->closeResults();
	} else {
	    $block2->noresults();
	}

	$block2->closeToggle();
	$block2->closeFormResults();

	$block2->openPaletteScript();
	$block2->paletteScript(0, "remove", "../tasks/deletetasks.php", "false,true,true", $strings["delete"]);
	$block2->paletteScript(1, "copy", "../tasks/edittask.php?cpy=true", "false,true,false", $strings["copy"]);
	// $block2->paletteScript(2,"export","export.php","false,true,true",$strings["export"]);
	$block2->paletteScript(3, "info", "../tasks/viewtask.php", "false,true,false", $strings["view"]);
	$block2->paletteScript(4, "edit", "../tasks/edittask.php", "false,true,false", $strings["edit"]);
	$block2->paletteScript(5, "timelog", "../tasks/addtasktime.php", "false,true,false", $strings["loghours"]);
	$block2->closePaletteScript($comptListTasks, $listTasks->tas_id);
}

//--- my meetings ------------
{
    $block6 = new block();

    $block6->form = "hMet";
    //$block6->openForm("../general/home.php?project=$project#" . $block6->form . "Anchor");
    $block6->openForm("../general/home.php#" . $block6->form . "Anchor");

    $block6->sorting(
    "meetings",
    $sortingUser->sor_meetings[0],
    "mee.date ASC",
    $sortingFields = array(
    //"mee.id",
    "mee.priority",
    "mee.name",
    "mee.date",
    "mee.start_time",
    "mee.end_time",
    "mee.published"
    )
    );

    $tmpquery = " INNER JOIN " . $tableCollab["attendants"] . " att ON att.meeting=mee.id WHERE att.member = '" . $_SESSION['idSession'] . "' AND mee.date >= '$dateFilter' AND mee.status IN(0,2,3) ORDER BY $block6->sortingValue";

    $listMeetings = new request();
    $listMeetings->openMeetings($tmpquery);
    $comptListMeetings = count($listMeetings->mee_id);

    $block6->headingToggle($strings["my_meetings"]." <span class=addition>($comptListMeetings)</span>");

    $block6->openPaletteIcon();
    $block6->paletteIcon(5, "info", $strings["view"]);
    $block6->paletteIcon(6, "edit", $strings["edit"]);
    $block6->closePaletteIcon();

    if ($comptListMeetings != "0") {
        $block6->openResults();

        $block6->labels(
        $labels = array(
        //$strings["id"],
        "P",
        $strings["name"],
        $strings["date"],
        $strings["start_time"],
        $strings["end_time"],
        $strings["published"]
        ),
        "true"
        );

        for ($i = 0;$i < $comptListMeetings;$i++) {
            $idPublish = $listMeetings->mee_published[$i];
            $idPriority = $listMeetings->mee_priority[$i];
            $block6->openRow($listMeetings->mee_id[$i]);
            $block6->checkboxRow($listMeetings->mee_id[$i]);

            //--- id ----
            //$block6->cellRow(buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_id[$i], LINK_INSIDE));

            //--- prio ---
            $block2->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" title="' . $priority[$idPriority] . '">' /*. $priority[$idPriority]*/, '5', true);

            //--- name ----
            $block6->cellRow(buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_name[$i], LINK_INSIDE), "30");

            //--- date ----
            $block6->cellRow($listMeetings->mee_date[$i]);

            //--- start time ----
            $block6->cellRow($listMeetings->mee_start_time[$i]);

            //--- end time ----
            $block6->cellRow($listMeetings->mee_end_time[$i]);

            //--- published ----
            if ($sitePublish == "true") {
                $block6->cellRow($statusPublish[$idPublish], "8");
            }

            $block6->closeRow();
        }

        $block6->closeResults();
    } else {
        $block6->noresults();
    }

    $block6->closeToggle();
    $block6->closeFormResults();

    $block6->openPaletteScript();
    $block6->paletteScript(5, "info", "../meetings/viewmeeting.php", "false,true,false", $strings["view"]);
    $block6->paletteScript(6, "edit", "../meetings/editmeeting.php?project=$project", "false,true,false", $strings["edit"]);
    $block6->closePaletteScript($comptListMeetings, $listMeetings->mee_id);
}

//--- my discussions -------------
{
	$block3 = new block();

	$block3->sorting("home_discussions", $sortingUser->sor_home_discussions[0], "topic.last_post DESC", $sortingFields = array(0 => "topic.subject", 1 => "mem.login", 2 => "topic.posts", 3 => "topic.last_post", 4 => "topic.status", 5 => "pro.name", 6 => "topic.published"));

	if ($projectsTopics == "") {
	    $projectsTopics = "0";
	}

	$tmpquery = "WHERE topic.project IN($projectsTopics) AND topic.last_post > '$dateFilter' AND topic.status = '1' ORDER BY $block3->sortingValue";
	$listTopics = new request();
	$listTopics->openTopics($tmpquery);
	$comptListTopics = count($listTopics->top_id);

	$block3->form = "wbTh";
	$block3->openForm("../general/home.php#" . $block3->form . "Anchor");

	$block3->headingToggle($strings["my_discussions"]." <span class=addition>($comptListTopics)</span>");
	$block3->openPaletteIcon();

	$block3->paletteIcon(0, "add", $strings["add"]);
	$block3->paletteIcon(1, "lock", $strings["close"]);
	$block3->paletteIcon(2, "add_projectsite", $strings["add_project_site"]);
	$block3->paletteIcon(3, "remove_projectsite", $strings["remove_project_site"]);
	$block3->paletteIcon(4, "info", $strings["view"]);

	$block3->closePaletteIcon();

	if ($comptListTopics != "0") {
	    $block3->openResults();

	    $block3->labels($labels = array(0 => $strings["topic"], 1 => $strings["owner"], 2 => $strings["posts"], 3 => $strings["last_post"], 4 => $strings["status"], 5 => $strings["project"], 6 => $strings["published"]), "true");

	    for ($i = 0;$i < $comptListTopics;$i++) {
	        $idStatus = $listTopics->top_status[$i];
	        $idPublish = $listTopics->top_published[$i];
	        $block3->openRow($listTopics->top_id[$i]);
	        $block3->checkboxRow($listTopics->top_id[$i]);
	        $block3->cellRow(buildLink("../topics/viewtopic.php?project=" . $listTopics->top_project[$i] . "&amp;id=" . $listTopics->top_id[$i], $listTopics->top_subject[$i], LINK_INSIDE));
	        $block3->cellRow(buildLink($listTopics->top_mem_email_work[$i], $listTopics->top_mem_login[$i], LINK_MAIL));
	        $block3->cellRow($listTopics->top_posts[$i]);

	        if ($listTopics->top_last_post[$i] > $_SESSION['lastvisiteSession']) {
	            $block3->cellRow("<b>" . createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']) . "</b>");
	        } else {
	            $block3->cellRow(createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']));
	        }

	        $block3->cellRow($statusTopic[$idStatus]);
	        $block3->cellRow(buildLink("../projects/viewproject.php?id=" . $listTopics->top_project[$i], $listTopics->top_pro_name[$i], LINK_INSIDE));

	        if ($sitePublish == "true") {
	            $block3->cellRow($statusPublish[$idPublish], "8");
	        }

	        $block3->closeRow();
	    }

	    $block3->closeResults();
	} else {
	    $block3->noresults();
	}

	$block3->closeToggle();
	$block3->closeFormResults();

	$block3->openPaletteScript();
	$block3->paletteScript(0, "remove", "../topics/deletetopics.php", "false,true,true", $strings["delete"]);
	$block3->paletteScript(1, "lock", "../general/home.php?closeTopic=true&action=publish", "false,true,true", $strings["close"]);
	$block3->paletteScript(2, "add_projectsite", "../general/home.php?addToSiteTopic=true&action=publish", "false,true,true", $strings["add_project_site"]);
	$block3->paletteScript(3, "remove_projectsite", "../general/home.php?removeToSiteTopic=true&action=publish", "false,true,true", $strings["remove_project_site"]);
	$block3->paletteScript(4, "info", "threaddetail", "false,true,false", $strings["view"]);
	$block3->closePaletteScript($comptListTopics, $listTopics->top_id);
}

//--- my notes ------------
{
    $block5 = new block();

    $comptTopic = count($topicNote);
    if ($comptTopic != "0") {
        $block5->sorting(
        "notes",
        $sortingUser->sor_notes[0],
        "note.date DESC",
        $sortingFields = array(
        "note.subject",
        "note.topic",
        "note.date",
        "mem.login",
        "note.published"
        )
        );
    }
    else {
        $block5->sorting(
        "notes",
        $sortingUser->sor_notes[0],
        "note.date DESC",
        $sortingFields = array(
        "note.subject",
        "note.date",
        "mem.login",
        "note.published"
        )
        );
    }

    $tmpquery = "WHERE note.owner = '" . $_SESSION['idSession'] . "' AND note.date > '$dateFilter' AND pro.status IN(0,2,3) ORDER BY $block5->sortingValue";
    $listNotes = new request();
    $listNotes->openNotes($tmpquery);
    $comptListNotes = count($listNotes->note_id);

    $block5->form = "saJ";
    $block5->openForm("../general/home.php?project=$project#" . $block5->form . "Anchor");


    //--- title ------
    $block5->headingToggle($strings["my_notes"]." <span class=addition>($comptListNotes)</span>");

    $block5->openPaletteIcon();
    // $block5->paletteIcon(0,"add",$strings["add"]);
    // $block5->paletteIcon(1,"remove",$strings["delete"]);
    // $block5->paletteIcon(2,"export",$strings["export"]);
    /*if ($sitePublish == "true") {
    $block5->paletteIcon(3,"add_projectsite",$strings["add_project_site"]);
    $block5->paletteIcon(4,"remove_projectsite",$strings["remove_project_site"]);
    }*/
    $block5->paletteIcon(5, "info", $strings["view"]);
    $block5->paletteIcon(6, "edit", $strings["edit"]);
    $block5->closePaletteIcon();



    if ($comptListNotes != "0") {
        $block5->openResults();

        if ($comptTopic != "0") {
            $block5->labels(
            $labels = array(
            $strings["subject"],
            $strings["topic"],
            $strings["date"],
            $strings["owner"],
            $strings["published"]
            ), "true"
            );
        }
        else {
            $block5->labels(
            $labels = array(
            $strings["subject"],
            $strings["date"],
            $strings["owner"],
            $strings["published"]
            ), "true"
            );
        }

        for ($i = 0;$i < $comptListNotes;$i++) {
            $idPublish = $listNotes->note_published[$i];

            $block5->openRow($listNotes->note_id[$i]);
            $block5->checkboxRow($listNotes->note_id[$i]);

            //--- subject ------
            $block5->cellRow(buildLink("../notes/viewnote.php?id=" . $listNotes->note_id[$i], $listNotes->note_subject[$i], LINK_INSIDE));

            //--- topic ---------
            if ($comptTopic != "0") {
                $block5->cellRow($topicNote[$listNotes->note_topic[$i]]);
            }

            //--- date ------
            $block5->cellRow($listNotes->note_date[$i]);

            //--- owner ---------
            $block5->cellRow(buildLink($listNotes->note_mem_email_work[$i], $listNotes->note_mem_login[$i], LINK_MAIL));

            //--- published --------
            if ($sitePublish == "true") {
                $block5->cellRow($statusPublish[$idPublish], "8");
            }

            $block5->closeRow();
        }

        $block5->closeResults();
    } else {
        $block5->noresults();
    }

    $block5->closeToggle();
    $block5->closeFormResults();

    $block5->openPaletteScript();
    // $block5->paletteScript(0,"add","../notes/editnote.php?project=$project","true,true,true",$strings["add"]);
    // $block5->paletteScript(1,"remove","../notes/deletenotes.php?project=$project","false,true,true",$strings["delete"]);
    // $block5->paletteScript(2,"export","export.php","false,true,true",$strings["export"]);
    /*if ($sitePublish == "true") {
    $block5->paletteScript(3,"add_projectsite","../general/home.php?addToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["add_project_site"]);
    $block5->paletteScript(4,"remove_projectsite","../general/home.php?removeToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["remove_project_site"]);
    }*/
    $block5->paletteScript(5, "info", "../notes/viewnote.php", "false,true,false", $strings["view"]);
    $block5->paletteScript(6, "edit", "../notes/editnote.php?project=$project", "false,true,false", $strings["edit"]);
    $block5->closePaletteScript($comptListNotes, $listNotes->note_id);
}

//--- my reports -----------
{

	$block4 = new block();

	$block4->form = "wbSe";
	$block4->openForm("../general/home.php#" . $block4->form . "Anchor");
	$block4->sorting("home_reports", $sortingUser->sor_home_reports[0], "rep.name ASC", $sortingFields = array(0 => "rep.name", 1 => "rep.created"));

	$tmpquery = "WHERE rep.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block4->sortingValue";
	$listReports = new request();
	$listReports->openReports($tmpquery);
	$comptListReports = count($listReports->rep_id);


	$block4->headingToggle($strings["my_reports"]." <span class=addition>($comptListReports)</span>" );

	$block4->openPaletteIcon();
	$block4->paletteIcon(0, "add", $strings["new"]);
	$block4->paletteIcon(1, "remove", $strings["delete"]);
	$block4->paletteIcon(2, "info", $strings["view"]);
	$block4->closePaletteIcon();



	if ($comptListReports != "0") {
	    $block4->openResults();

	    $block4->labels($labels = array(0 => $strings["name"], 1 => $strings["created"]), "false");

	    for ($i = 0;$i < $comptListReports;$i++) {
	        $block4->openRow($listReports->rep_id[$i]);
	        $block4->checkboxRow($listReports->rep_id[$i]);
	        $block4->cellRow(buildLink("../reports/resultsreport.php?id=" . $listReports->rep_id[$i], $listReports->rep_name[$i], LINK_INSIDE), "31");
	        $block4->cellRow(createDate($listReports->rep_created[$i], $_SESSION['timezoneSession']));
	        $block4->closeRow();
	    }

	    $block4->closeResults();
	} else {
	    $block4->noresults();
	}

	$block4->closeToggle();
	$block4->closeFormResults();

	$block4->openPaletteScript();
	$block4->paletteScript(0, "add", "../reports/createreport.php", "true,true,true", $strings["new"]);
	$block4->paletteScript(1, "remove", "../reports/deletereports.php", "false,true,true", $strings["delete"]);
	$block4->paletteScript(2, "info", "../reports/resultsreport.php", "false,true,true", $strings["view"]);
	$block4->closePaletteScript($comptListReports, $listReports->rep_id);
}

require_once("../themes/" . THEME . "/footer.php");

?>