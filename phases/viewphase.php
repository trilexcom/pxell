<?php // $Revision: 1.11 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewphase.php,v 1.11 2005/05/30 16:12:39 madbear Exp $
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

if ($action == "publish") {
    if ($addToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='0' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "addToSite";
        $id = $phase;
    } 

    if ($removeToSite == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='1' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "removeToSite";
        $id = $phase;
    } 
    if ($addToSiteFile == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='0' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "addToSite";
        $id = $phase;
    } 

    if ($removeToSiteFile == "true") {
        $multi = strstr($id, "**");
        if ($multi != "") {
            $id = str_replace("**", ",", $id);
            $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='1' WHERE id = '$id'";
        } 
        connectSql("$tmpquery1");
        $msg = "removeToSite";
        $id = $phase;
    } 
} 


$tmpquery = "WHERE pha.id = '$id'";
$phaseDetail = new request();
$phaseDetail->openPhases($tmpquery);
$project = $phaseDetail->pha_project_id[0];
$phase = $phaseDetail->pha_id[0];

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '$project' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);

if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
}

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../phases/listphases.php?id=" . $projectDetail->pro_id[0], $strings["phases"], LINK_INSIDE);
$breadcrumbs[]=$phaseDetail->pha_name[0];

require_once("../themes/" . THEME . "/header.php");

//--- content ------
{
	$block1 = new block();
	$block1->form = "pppD";
	$block1->openForm("../projects/listprojects.php#" . $block1->form . "Anchor");
	$block1->headingToggle($strings["phase"] . " : " . $phaseDetail->pha_name[0]);

	if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "5") {
	    $block1->openPaletteIcon();
	    $block1->paletteIcon(0, "edit", $strings["edit"]);
	    $block1->closePaletteIcon();
	}
	else {
    	$block1->headingToggle_close();
	}

	$block1->openContent();
	$block1->contentTitle($strings["details"]);

	$block1->contentRow($strings["name"], $phaseDetail->pha_name[0]);
	$block1->contentRow($strings["phase_id"], $phaseDetail->pha_id[0]);
	$block1->contentRow($strings["status"], $phaseStatus[$phaseDetail->pha_status[0]]);

	$parentPhase = $phaseDetail->pha_order_num[0];
	$tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' AND tas.milestone != '0'";
	$countPhaseTasks = new request();
	$countPhaseTasks->openTasks($tmpquery);
	$comptlistTasks = count($countPhaseTasks->tas_id);

	$comptlistTasksRow = "0";
	$comptUncompleteTasks = "0";
	for ($k = 0;$k < $comptlistTasks;$k++) {
	    if ($countPhaseTasks->tas_status[$k] == "2" || $countPhaseTasks->tas_status[$k] == "3" || $countPhaseTasks->tas_status[$k] == "4") {
	        $comptUncompleteTasks = $comptUncompleteTasks + 1;
	    }
	}

    $tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' AND tas.milestone = '0'";
    $countPhaseMilestones = new request();
    $countPhaseMilestones->openTasks($tmpquery);
    $comptlistMilestones = count($countPhaseMilestones->tas_id);

	$block1->contentRow($strings["total_tasks"], $comptlistTasks);
	$block1->contentRow($strings["uncomplete_tasks"], $comptUncompleteTasks);
    $block1->contentRow($strings["milestone"], $comptlistMilestones);
    $block1->contentRow($strings['ical_url'], buildLink("$root/calendar/icalendar.php", "$root/calendar/icalendar.php", LINK_OUT));
	$block1->contentRow($strings["date_start"], $phaseDetail->pha_date_start[0]);
	$block1->contentRow($strings["date_end"], $phaseDetail->pha_date_end[0]);
	$block1->contentRow($strings["comments"], nl2br($phaseDetail->pha_comments[0]));

	$block1->closeContent();
	$block1->closeToggle();
	$block1->closeForm();

	if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "5") {
	    $block1->openPaletteScript();
	    $block1->paletteScript(0, "edit", "../phases/editphase.php?id=$id", "true,true,true", $strings["edit"]);
	    $block1->closePaletteScript($comptListPhaese, $listPhases->pha_id);
	}
}



/*
//--- tasks ? ----
{
	$block2 = new block();

	$block2->form = "saP";
	$block2->openForm("../phases/viewphase.php?id=$id#" . $block2->form . "Anchor");

	$block2->headingToggle($strings["tasks"]);

	$block2->openPaletteIcon();
	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block2->paletteIcon(0, "add", $strings["add"]);
	    $block2->paletteIcon(1, "remove", $strings["delete"]);
	    $block2->paletteIcon(2, "copy", $strings["copy"]);
	    // $block1->paletteIcon(3,"export",$strings["export"]);
	    if ($sitePublish == "true") {
	        $block2->paletteIcon(4, "add_projectsite", $strings["add_project_site"]);
	        $block2->paletteIcon(5, "remove_projectsite", $strings["remove_project_site"]);
	    }
	}

	$block2->paletteIcon(6, "info", $strings["view"]);
	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block2->paletteIcon(7, "edit", $strings["edit"]);
	    $block2->paletteIcon(8, "timelog", $strings["loghours"]);
	}
	$block2->closePaletteIcon();

	$block2->sorting("tasks", $sortingUser->sor_tasks[0], "tas.name ASC", $sortingFields = array(0 => "tas.id", 1 => "tas.name", 2 => "tas.priority", 3 => "tas.status", 4 => "tas.completion", 5 => "tas.due_date", 6 => "mem.login", 7 => "tas.published"));

	$tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' ORDER BY $block2->sortingValue";
	$listTasks = new request();
	$listTasks->openTasks($tmpquery);
	$comptListTasks = count($listTasks->tas_id);

	if ($comptListTasks != "0") {
	    $block2->openResults();
	    $block2->labels($labels = array(0 => $strings["id"],1 => $strings["task"], 2 => $strings["priority"], 3 => $strings["status"], 4 => $strings["completion"], 5 => $strings["due_date"], 6 => $strings["assigned_to"], 7 => $strings["published"]), "true");

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

	        $block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_id[$i], LINK_INSIDE));

	        if ($idStatus == 1) {
	            $block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_STRIKE));
	        } else {
	            $block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE));
	        }

            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("") ;
                $block2->cellRow("") ;
                $block2->cellRow("") ;
            } else {
	            $block2->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);
	            $block2->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);
	            $block2->cellRow($complValue);
            }
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("") ;
            } else if ($listTasks->tas_due_date[$i] <= $date) {
	            $block2->cellRow("<b>" . $listTasks->tas_due_date[$i] . "</b>");
	        } else {
	            $block2->cellRow($listTasks->tas_due_date[$i]);
	        }
	        if ($listTasks->tas_start_date[$i] != "--" && $listTasks->tas_due_date[$i] != "--") {
	            $gantt = "true";
	        }
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("") ;
	        } else if ($listTasks->tas_assigned_to[$i] == "0") {
	            $block2->cellRow($strings["unassigned"]);
	        } else {
	            $block2->cellRow(buildLink($listTasks->tas_mem_email_work[$i], $listTasks->tas_mem_login[$i], LINK_MAIL));
	        }
	        echo "</td>";
	        if ($sitePublish == "true") {
                if ($listTasks->tas_milestone[$i] == "0") {
                    $block2->cellRow("") ;
                } else {
	                $block2->cellRow($statusPublish[$idPublish]);
                }
	        }
	        $block2->closeRow();
	    }
	    $block2->closeResults();

	    if ($activeJpgraph == "true" && $gantt == "true") {
	        // show the expanded or compact Gantt Chart
	        if ($_GET['base'] == 1) {
	            echo "<a href='viewphase.php?id=$id&amp;base=0'>expand</a><br>";
	        } else {
	            echo "<a href='viewphase.php?id=$id&amp;base=1'>compact</a><br>";
	        }

	        echo "<img src=\"graphtasks.php?project=" . $projectDetail->pro_id[0] . "&amp;phase=" . $phaseDetail->pha_order_num[0] . "&amp;base=" . $_GET['base'] . "\" alt=\"\"><br>
	<span class=\"listEvenBold\">" . buildLink("http://www.aditus.nu/jpgraph/", "JpGraph", LINK_POWERED) . "</span>";
	    }
	} else {
	    $block2->noresults();
	}
	$block2->closeToggle();
	$block2->closeFormResults();

	$block2->openPaletteScript();
	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block2->paletteScript(0, "add", "../tasks/edittask.php?project=$project&phase=" . $phaseDetail->pha_order_num[0] . "", "true,true,true", $strings["add"]);
	    $block2->paletteScript(1, "remove", "../tasks/deletetasks.php?project=$project", "false,true,true", $strings["delete"]);
	    $block2->paletteScript(2, "copy", "../tasks/edittask.php?project=$project&cpy=true", "false,true,false", $strings["copy"]);
	    // $block1->paletteScript(3,"export","export.php?","false,true,true",$strings["export"]);
	    if ($sitePublish == "true") {
	        $block2->paletteScript(4, "add_projectsite", "../phases/viewphase.php?addToSite=true&phase=$phase&action=publish", "false,true,true", $strings["add_project_site"]);
	        $block2->paletteScript(5, "remove_projectsite", "../phases/viewphase.php?removeToSite=true&phase=$phase&action=publish", "false,true,true", $strings["remove_project_site"]);
	    }
	}
	$block2->paletteScript(6, "info", "../tasks/viewtask.php?", "false,true,false", $strings["view"]);
	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block2->paletteScript(7, "edit", "../tasks/edittask.php?project=$project&phase=" . $phaseDetail->pha_order_num[0] . "", "false,true,false", $strings["edit"]);
	    $block2->paletteScript(8, "timelog", "../tasks/addtasktime.php?project=$project&phase=" . $phaseDetail->pha_order_num[0] . "", "false,true,false", $strings["loghours"]);
	}
	$block2->closePaletteScript($comptListTasks, $listTasks->tas_id);
}
*/

//--- tasks open (with phases) ------------
{
    $block2 = new block();

    $block2->form = 'wbTuuO';
    $block2->openForm("../phases/viewphase.php?id=$id#" . $block2->form . "Anchor");

    $block2->sorting(
        'project_tasks',
        $sortingUser->sor_project_tasks[0],
        'tas.due_date ASC',
        $sortingFields = array(
            #"tas.id",
            'tas.priority',
            'tas.name',
            'tas.status',
            'tas.completion',
            'tas.due_date',
            'mem.login',
            'tas.published'
        )
    );
    
    $blockPage= new block();
    
    $block2->borne = $blockPage->returnBorne('1');
    $block2->rowsLimit = '20';

    $tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' AND tas.status IN(0,2,3) AND tas.milestone = '1' ORDER BY $block2->sortingValue";
    $block2->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    $listTasks = new request();
    $listTasks->openTasks($tmpquery, $block2->borne, $block2->rowsLimit);
    $comptListTasks = count($listTasks->tas_id);
    
    $block2->headingToggle($strings['tasks_open'] . ' <span class=addition>(' . $comptListTasks . ')</span>');
    $block2->openPaletteIcon();

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block2->paletteIcon(0, 'add', $strings['add']);
        $block2->paletteIcon(1, 'remove', $strings['delete']);
        $block2->paletteIcon(2, 'copy', $strings['copy']);
        // $block2->paletteIcon(3,'export',$strings['export']);

        if ($sitePublish == 'true') {
            $block2->paletteIcon(4, 'add_projectsite', $strings['add_project_site']);
            $block2->paletteIcon(5, 'remove_projectsite', $strings['remove_project_site']);
        }
    }

    $block2->paletteIcon(6, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block2->paletteIcon(7, 'edit', $strings['edit']);
        $block2->paletteIcon(8, 'timelog', $strings['loghours']);
    }

    $block2->closePaletteIcon();

    if ($comptListTasks != '0') {
        $block2->openResults();

        $block2->labels(
            $labels = array(
                #$strings['id'],
                'P',
                $strings['name'],
                $strings['status'],
                $strings['completion'],
                $strings['due_date'],
                $strings['assigned_to'],
                $strings['published']
            ),
            'true'
        );

        for ($i = 0; $i < $comptListTasks; $i++) {
            if ($listTasks->tas_due_date[$i] == '') {
                $listTasks->tas_due_date[$i] = $strings['none'];
            }

            $idStatus = $listTasks->tas_status[$i];
            $idPriority = $listTasks->tas_priority[$i];
            $idPublish = $listTasks->tas_published[$i];
            $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . '0 %': $listTasks->tas_completion[$i] . ' %';
            $block2->openRow($listTasks->tas_id[$i]);

            $block2->checkboxRow($listTasks->tas_id[$i]);

            //--- id ----
            #$block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_id[$i], LINK_INSIDE));

            //--- prio ---
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">'/* . $priority[$idPriority]*/, '1%', true);
            }

            //--- name ----
            if ($idStatus == 1) {
                $block2->cellRow(buildLink('../tasks/viewtask.php?id=' . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_STRIKE), "99%");
            } else {
                $block2->cellRow(buildLink('../tasks/viewtask.php?id=' . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE),"99%");
            }

            //--- status ----
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);
            }

            //--- complete ----
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow($complValue);
            }

            //---- due date ------
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else if ($listTasks->tas_due_date[$i] <= $date && $listTasks->tas_completion[$i] != '10') {
                $block2->cellRow('<b>' . $listTasks->tas_due_date[$i] . '</b>');
            } else {
                $block2->cellRow($listTasks->tas_due_date[$i]);
            }
            if ($listTasks->tas_start_date[$i] != "--" && $listTasks->tas_due_date[$i] != '--') {
                $gantt = 'true';
            }
            
            //--- assigned to -----
            if ($listTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else if ($listTasks->tas_assigned_to[$i] == '0') {
                $block2->cellRow($strings['unassigned']);
            }
            else {
                $block2->cellRow(buildLink($listTasks->tas_mem_email_work[$i], $listTasks->tas_mem_login[$i], LINK_MAIL));
            }
            
            //---- published ------
            if ($sitePublish == 'true') {
                if ($listTasks->tas_milestone[$i] == "0") {
                    $block2->cellRow("");
                } else {
                    $block2->cellRow($statusPublish[$idPublish]);
                }
            }

            $block2->closeRow();
        }

        $block2->closeResults();
        $block2->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $id, 'id=' . $id);

        //--- jpg-graph ----
        if ($activeJpgraph == 'true' && $gantt == 'true') {
            // show the expanded or compact Gantt Chart
            if ($_GET['base'] == 1) {
                echo "<a href='viewphase.php?id=$id&amp;base=0'>expand</a><br>";
            } else {
                echo "<a href='viewphase.php?id=$id&amp;base=1'>compact</a><br>";
            }

            echo "<img src=\"graphtasks.php?project=" . $projectDetail->pro_id[0] . "&amp;phase=" . $phaseDetail->pha_order_num[0] . "&amp;base=" . $_GET['base'] . "\" alt=\"\"><br>
	<span class=\"listEvenBold\">" . buildLink("http://www.aditus.nu/jpgraph/", "JpGraph", LINK_POWERED) . "</span>";
        }

    } else {
        $block2->noresults();
    }
    $block2->closeToggle();
    $block2->closeFormResults();

    $block2->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block2->paletteScript(0, 'add', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
        $block2->paletteScript(1, 'remove', '../tasks/deletetasks.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block2->paletteScript(2, 'copy', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0] . '&cpy=true', 'false,true,false', $strings['copy']);
        // $block2->paletteScript(3,'export','../projects/exportproject.php','false,true,true',$strings['export']);
        if ($sitePublish == 'true') {
            $block2->paletteScript(4, 'add_projectsite', '../projects/viewproject.php?addToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block2->paletteScript(5, 'remove_projectsite', '../projects/viewproject.php?removeToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }
    $block2->paletteScript(6, 'info', '../tasks/viewtask.php', 'false,true,false', $strings['view']);
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block2->paletteScript(7, 'edit', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['edit']);
        $block2->paletteScript(8, 'timelog', '../tasks/addtasktime.php', 'false,true,false', $strings['loghours']);
    }
    $block2->closePaletteScript($comptListTasks, $listTasks->tas_id);
}

//--- milestones open ------------------------
{
    $block9 = new block();

    $block9->form = 'wbTuuM';
    $block9->openForm("../phases/viewphase.php?id=$id#" . $block9->form . "Anchor");

    $block9->sorting(
        'milestones',
        $sortingUser->sor_milestones[0],
        'tas.start_date ASC',
        $sortingFields = array(
            'tas.name',
            'tas.start_date'
        )
    );

    $block9->borne = $blockPage->returnBorne('1');
    $block9->rowsLimit = '20';

    $tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' AND tas.milestone = '0' ORDER BY $block9->sortingValue";

    $block9->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    $listMilestones = new request();
    $listMilestones->openTasks($tmpquery, $block9->borne, $block9->rowsLimit);
    $comptListMilestones = count($listMilestones->tas_id);
    
    $block9->headingToggle($strings['milestone']. ' <span class=addition>(' . $comptListMilestones . ')</span>');
    $block9->openPaletteIcon();

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block9->paletteIcon(0, 'add', $strings['add']);
        $block9->paletteIcon(1, 'remove', $strings['delete']);
        $block9->paletteIcon(2, 'copy', $strings['copy']);
    }

    $block9->paletteIcon(6, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block9->paletteIcon(7, 'edit', $strings['edit']);
    }

    $block9->closePaletteIcon();

    if ($comptListMilestones != '0') {
        $block9->openResults();

        $block9->labels(
            $labels = array(
                $strings['name'],
                $strings['date']
            ),
            'true'
        );

        for ($i = 0; $i < $comptListMilestones; $i++) {
            $idPublish = $listMilestones->tas_published[$i];
            $idStatus  = $listMilestones->tas_status[$i];

            $block9->openRow($listMilestones->tas_id[$i]);
            $block9->checkboxRow($listMilestones->tas_id[$i]);

            //--- name ----
            $block9->cellRow(buildLink('../tasks/viewtask.php?id=' . $listMilestones->tas_id[$i], $listMilestones->tas_name[$i], LINK_INSIDE),"70%");

            //--- date ---
            $block9->cellRow($listMilestones->tas_start_date[$i]);

            $block9->closeRow();
        }

        $block9->closeResults();
        $block9->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $id, 'id=' . $id);
    } else {
        $block9->noresults();
    }

    $block9->closeToggle();
    $block9->closeFormResults();

    $block9->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block9->paletteScript(0, 'add', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
        $block9->paletteScript(1, 'remove', '../tasks/deletetasks.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block9->paletteScript(2, 'copy', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0] . '&cpy=true', 'false,true,false', $strings['copy']);
    }

    $block9->paletteScript(6, 'info', '../tasks/viewtask.php', 'false,true,false', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block9->paletteScript(7, 'edit', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['edit']);
    }

    $block9->closePaletteScript($comptListMilestones, $listMilestones->tas_id);
}







//--- tasks closed (ignore phases) ------------
{
    $block10 = new block();

    //--- block header ----
    $block10->form = 'wbTuuC';
    $block10->openForm("../phases/viewphase.php?id=$id#" . $block10->form . "Anchor");

    $block10->sorting(
        'tasks_closed',
        $sortingUser->sor_tasks_closed[0],
        'tas.due_date ASC',
        $sortingFields = array(
            #"tas.id",
            'tas.priority',
            'tas.name',
            'tas.status',
            'tas.completion',
            'tas.due_date',
            'mem.login',
            'tas.published'
        )
    );
    
    $block10->borne = $blockPage->returnBorne('1');
    $block10->rowsLimit = '20';
    
    //--- get data from sql ---------
    $tmpquery = "WHERE tas.project = '$project' AND tas.parent_phase = '$parentPhase' AND tas.status NOT IN(0,2,3) AND tas.milestone = '1' ORDER BY $block10->sortingValue";
    $block10->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    //--- list ---------
    $listTasks = new request();
    $listTasks->openTasks($tmpquery, $block10->borne, $block10->rowsLimit);
    $comptListTasks = count($listTasks->tas_id);
    
    $block10->headingToggle($strings['tasks_closed'] . ' <span class=addition>(' . $comptListTasks . ')</span>');
    $block10->openPaletteIcon();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block10->paletteIcon(0, 'add', $strings['add']);
        $block10->paletteIcon(1, 'remove', $strings['delete']);
        $block10->paletteIcon(2, 'copy', $strings['copy']);
        // $block10->paletteIcon(3,'export',$strings['export']);
        if ($sitePublish == 'true') {
            $block10->paletteIcon(4, 'add_projectsite', $strings['add_project_site']);
            $block10->paletteIcon(5, 'remove_projectsite', $strings['remove_project_site']);
        }
    }
    
    $block10->paletteIcon(6, 'info', $strings['view']);
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block10->paletteIcon(7, 'edit', $strings['edit']);
        $block10->paletteIcon(8, 'timelog', $strings['loghours']);
    }
    
    $block10->closePaletteIcon();

    if ($comptListTasks != '0') {
        $block10->openResults();

        $block10->labels(
            $labels = array(
                #$strings['id'],
                'P',
                $strings['name'],
                $strings['status'],
                $strings['completion'],
                $strings['due_date'],
                $strings['assigned_to'],
                $strings['published']
            ),
            'true'
        );
        
        for ($i = 0; $i < $comptListTasks; $i++) {
            if ($listTasks->tas_due_date[$i] == '') {
                $listTasks->tas_due_date[$i] = $strings['none'];
            }

            $idStatus = $listTasks->tas_status[$i];
            $idPriority = $listTasks->tas_priority[$i];
            $idPublish = $listTasks->tas_published[$i];
            $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . '0 %': $listTasks->tas_completion[$i] . ' %';
            $block10->openRow($listTasks->tas_id[$i]);

            $block10->checkboxRow($listTasks->tas_id[$i]);

            //--- id ----
            #$block10->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_id[$i], LINK_INSIDE));

            //--- prio ---
            $block10->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">'/* . $priority[$idPriority]*/, '1%', true);

            //--- name ----
            if ($idStatus == 1) {
                $block10->cellRow(buildLink('../tasks/viewtask.php?id=' . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_STRIKE), "99%");
            } else {
                $block10->cellRow(buildLink('../tasks/viewtask.php?id=' . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE),"99%");
            }

            //--- status ----
            $block10->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

            //--- complete ----
            $block10->cellRow($complValue);

            //---- due date ------
            if ($listTasks->tas_due_date[$i] <= $date && $listTasks->tas_completion[$i] != '10') {
                $block10->cellRow('<b>' . $listTasks->tas_due_date[$i] . '</b>');
            } else {
                $block10->cellRow($listTasks->tas_due_date[$i]);
            }
            if ($listTasks->tas_start_date[$i] != "--" && $listTasks->tas_due_date[$i] != '--') {
                $gantt = 'true';
            }
            
            //--- assigned to -----
            if ($listTasks->tas_assigned_to[$i] == '0') {
                $block10->cellRow($strings['unassigned']);
            }
            else {
                $block10->cellRow(buildLink($listTasks->tas_mem_email_work[$i], $listTasks->tas_mem_login[$i], LINK_MAIL));
            }

            //---- published ------
            if ($sitePublish == 'true') {
                $block10->cellRow($statusPublish[$idPublish]);
            }
            $block10->closeRow();
        }

        $block10->closeResults();
        $block10->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $id, 'id=' . $id);
    } else {
        $block10->noresults();
    }

    $block10->closeToggle();
    $block10->closeFormResults();

    $block10->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block10->paletteScript(0, 'add', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
        $block10->paletteScript(1, 'remove', '../tasks/deletetasks.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block10->paletteScript(2, 'copy', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0] . '&cpy=true', 'false,true,false', $strings['copy']);
        // $block10->paletteScript(3,'export','../projects/exportproject.php','false,true,true',$strings['export']);
        if ($sitePublish == 'true') {
            $block10->paletteScript(4, 'add_projectsite', '../projects/viewproject.php?addToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block10->paletteScript(5, 'remove_projectsite', '../projects/viewproject.php?removeToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }
    $block10->paletteScript(6, 'info', '../tasks/viewtask.php', 'false,true,false', $strings['view']);
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block10->paletteScript(7, 'edit', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['edit']);
        $block10->paletteScript(8, 'timelog', '../tasks/addtasktime.php', 'false,true,false', $strings['loghours']);
    }
    $block10->closePaletteScript($comptListTasks, $listTasks->tas_id);
}

//--- linked content --------------
{
    if ($fileManagement == "true") {
        $block3 = new block();

        $block3->form = "tdC";
        $block3->openForm("../phases/viewphase.php?id=$id#" . $block3->form . "Anchor");
        
        $block3->sorting(
            "files", 
            $sortingUser->sor_files[0], 
            "fil.name ASC", 
            $sortingFields = array(
                "fil.extension", 
                "fil.name", 
                "fil.date", 
                "fil.status", 
                "fil.published"
            )
        );
        
        $tmpquery = "WHERE fil.project = '" . $projectDetail->pro_id[0] . "' AND fil.phase = '" . $phaseDetail->pha_id[0] . "' AND fil.task = '0' AND fil.vc_parent = '0' ORDER BY $block3->sortingValue";
        
        $listFiles = new request();
        $listFiles->openFiles($tmpquery);
        $comptListFiles = count($listFiles->fil_id);

        $block3->headingToggle($strings["linked_content"] . ' <span class=addition>(' . $comptListFiles . ')</span>');
        $block3->openPaletteIcon();
        
        if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
            $block3->paletteIcon(0, "add", $strings["add"]);
            $block3->paletteIcon(1, "remove", $strings["delete"]);
            
            if ($sitePublish == "true") {
                $block3->paletteIcon(2, "add_projectsite", $strings["add_project_site"]);
                $block3->paletteIcon(3, "remove_projectsite", $strings["remove_project_site"]);
            }
        }
        
        $block3->paletteIcon(4, "info", $strings["view"]);
        
        if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
            $block3->paletteIcon(5, "edit", $strings["edit"]);
        }
        
        $block3->closePaletteIcon();

        if ($comptListFiles != "0") {
            $block3->openResults();

            $block3->labels(
                $labels = array(
                    0 => $strings["type"], 
                    1 => $strings["name"], 
                    2 => $strings["date"], 
                    3 => $strings["approval_tracking"], 
                    4 => $strings["published"]
                ), 
                "true"
            );

            include_once("../includes/files_types.php");

            for ($i = 0;$i < $comptListFiles;$i++) {
                $existFile = "false";
                $idStatus = $listFiles->fil_status[$i];
                $idPublish = $listFiles->fil_published[$i];
                $type = file_info_type($listFiles->fil_extension[$i]);
                
                if (file_exists("../files/" . $listFiles->fil_project[$i] . "/" . $listFiles->fil_name[$i])) {
                    $existFile = "true";
                }
                
                $block3->openRow($listFiles->fil_id[$i]);
                $block3->checkboxRow($listFiles->fil_id[$i]);
                
                if ($existFile == "true") {
                    $block3->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $type, LINK_ICON));
                } else {
                    $block3->cellRow("&nbsp;");
                }
                
                if ($existFile == "true") {
                    $block3->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $listFiles->fil_name[$i], LINK_INSIDE));
                } else {
                    $block3->cellRow($strings["missing_file"] . " (" . $listFiles->fil_name[$i] . ")");
                }
                
                $block3->cellRow($listFiles->fil_date[$i]);
                $block3->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $statusFile[$idStatus], LINK_INSIDE));
                if ($sitePublish == "true") {
                    $block3->cellRow($statusPublish[$idPublish]);
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
        
        if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
            $block3->paletteScript(0, "add", "../linkedcontent/addfile.php?project=" . $projectDetail->pro_id[0] . "&phase=" . $phaseDetail->pha_id[0] . "", "true,true,true", $strings["add"]);
            $block3->paletteScript(1, "remove", "../linkedcontent/deletefiles.php?project=" . $projectDetail->pro_id[0] . "&phase=" . $phaseDetail->pha_id[0] . "&sendto=phasedetail", "false,true,true", $strings["delete"]);
            
            if ($sitePublish == "true") {
                $block3->paletteScript(2, "add_projectsite", "../phases/viewphase.php?addToSiteFile=true&phase=" . $phaseDetail->pha_id[0] . "&action=publish", "false,true,true", $strings["add_project_site"]);
                $block3->paletteScript(3, "remove_projectsite", "../phases/viewphase.php?removeToSiteFile=true&phase=" . $phaseDetail->pha_id[0] . "&action=publish", "false,true,true", $strings["remove_project_site"]);
            }
        }
        
        $block3->paletteScript(4, "info", "../linkedcontent/viewfile.php?", "false,true,false", $strings["view"]);
        
        if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
            $block3->paletteScript(5, "edit", "../linkedcontent/viewfile.php?edit=true", "false,true,false", $strings["edit"]);
        }
        
        $block3->closePaletteScript($comptListFiles, $listFiles->fil_id);
    }
}

require_once("../themes/" . THEME . "/footer.php");

?>