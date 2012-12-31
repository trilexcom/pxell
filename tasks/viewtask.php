<?php // $Revision: 1.15 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewtask.php,v 1.15 2005/05/30 16:12:39 madbear Exp $
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

if ($task != "") {
    $cheatCode = "true";
} 

if ($action == "publish") {
    if ($addToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='0' WHERE id = '" . $id . "'";
        connectSql("$tmpquery1");
        $msg = "addToSite";
    }

    if ($removeToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["tasks"] . " SET published='1' WHERE id = '" . $id . "'";
        connectSql("$tmpquery1");
        $msg = "removeToSite";
    }

    if ($addToSiteFile == "true") {
        $id = str_replace("**", ",", $id);
        $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='0' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql("$tmpquery1");
        $msg = "addToSite";
        $id = $task;
    }

    if ($removeToSiteFile == "true") {
        $id = str_replace("**", ",", $id);
        $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET published='1' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql("$tmpquery1");
        $msg = "removeToSite";
        $id = $task;
    } 
} 

if ($task != "" && $cheatCode == "true") {
    $id = $task;
} 

$tmpquery = "WHERE tas.id = '$id'";
$taskDetail = new request();
$taskDetail->openTasks($tmpquery);

$tmpquery = "WHERE pro.id = '" . $taskDetail->tas_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

if ($projectDetail->pro_enable_phase[0] != "0") {
    $tPhase = $taskDetail->tas_parent_phase[0];
    $tmpquery = "WHERE pha.project_id = '" . $taskDetail->tas_project[0] . "' AND pha.order_num = '$tPhase'";
    $targetPhase = new request();
    $targetPhase->openPhases($tmpquery);
} 

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $taskDetail->tas_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);
if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
} 

if ($teamMember == "false" && $projectsFilter == "true") {
    header("Location:../general/permissiondenied.php");
    exit;
} 



//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);

if ($projectDetail->pro_phase_set[0] != "0") {
    $breadcrumbs[]=buildLink("../phases/listphases.php?id=" . $projectDetail->pro_id[0], $strings["phases"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../phases/viewphase.php?id=" . $targetPhase->pha_id[0], $targetPhase->pha_name[0], LINK_INSIDE);
} 

$breadcrumbs[]=buildLink("../tasks/listtasks.php?project=" . $projectDetail->pro_id[0], $strings["tasks"], LINK_INSIDE);
$breadcrumbs[]=$taskDetail->tas_name[0];

$pageSection='projects';
$pageTitle= '<span class=type>'.$strings["task"].'<br></span>'. "<span class=name>" . $taskDetail->tas_name[0]."</span>";
require_once("../themes/" . THEME . "/header.php");

//==== content =====================================
$blockPage= new block();


//--- tasks ---------------------------
{
	$block1 = new block();

	$block1->form = "tdD";
	$block1->openForm("../tasks/viewtask.php#" . $block1->form . "Anchor");

	$block1->headingToggle($strings["task"] . " / " . $strings['information']);

	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block1->openPaletteIcon();
	    $block1->paletteIcon(0, "remove", $strings["delete"]);
	    $block1->paletteIcon(1, "copy", $strings["copy"]);
	    // $block1->paletteIcon(2,"export",$strings["export"]);
	    if ($sitePublish == "true") {
	        $block1->paletteIcon(3, "add_projectsite", $strings["add_project_site"]);
	        $block1->paletteIcon(4, "remove_projectsite", $strings["remove_project_site"]);
	    }
	    $block1->paletteIcon(5, "edit", $strings["edit"]);
        if ($taskDetail->tas_milestone[0] != "0") {
	        $block1->paletteIcon(6, "timelog", $strings["loghours"]);
        }
	    $block1->closePaletteIcon();
	}
	else {
    	$block1->headingToggle_close();
	}

	if ($projectDetail->pro_org_id[0] == "1") {
	    $projectDetail->pro_org_name[0] = $strings["none"];
	}

	$block1->openContent();
	$block1->contentTitle($strings["info"]);

	$block1->contentRow($strings["project"], buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE));

	if ($projectDetail->pro_phase_set[0] != "0") {
	    $block1->contentRow($strings["phase"], buildLink("../phases/viewphase.php?id=" . $targetPhase->pha_id[0], $targetPhase->pha_name[0], LINK_INSIDE));
	}

	$block1->contentRow($strings["organization"], $projectDetail->pro_org_name[0]);

	$block1->contentRow($strings["created"], createDate($taskDetail->tas_created[0], $_SESSION['timezoneSession']));
	$block1->contentRow($strings["assigned"], createDate($taskDetail->tas_assigned[0], $_SESSION['timezoneSession']));
	$block1->contentRow($strings["modified"], createDate($taskDetail->tas_modified[0], $_SESSION['timezoneSession']));

	$block1->contentTitle($strings["details"]);

	$block1->contentRow($strings["name"], $taskDetail->tas_name[0]);
	$block1->contentRow($strings['task_id'], $taskDetail->tas_id[0]);

	$block1->contentRow($strings["description"], nl2br($taskDetail->tas_description[0]));
	$block1->contentRow($strings['ical_url'], buildLink("$root/calendar/icalendar.php", "$root/calendar/icalendar.php", LINK_OUT));

    if ($taskDetail->tas_milestone[0] != "0") {
	    $tmpquery = "WHERE id='" . $taskDetail->tas_service[0] . "'";
	    $serviceDetail = new request();
	    $serviceDetail->openServices($tmpquery);

	    $servicePrintName = $serviceDetail->serv_name_print[0];
	    $serviceHourlyRate = $serviceDetail->serv_hourly_rate[0];

	    if ($servicePrintName) {
	        $block1->contentRow($strings["service"], $servicePrintName . ' (' . $strings['hourly_rate'] . ' $' . $serviceHourlyRate . ')');
	    } else {
	        $block1->contentRow($strings["service"], $strings['none']);
	    }
    }

	$idStatus = $taskDetail->tas_status[0];
	$idPriority = $taskDetail->tas_priority[0];
	$idPublish = $taskDetail->tas_published[0];
	$complValue = ($taskDetail->tas_completion[0] > 0) ? $taskDetail->tas_completion[0] . "0 %": $taskDetail->tas_completion[0] . " %";

    $block1->contentRow($strings["milestone"], $milestoneis[$taskDetail->tas_milestone[0]]);
    if ($taskDetail->tas_milestone[0] != "0") {
	    $block1->contentRow($strings["status"], $status[$idStatus]);
	    $block1->contentRow($strings["completion"], $complValue);
	    $block1->contentRow($strings["priority"], $priority[$idPriority]);
	    $block1->contentRow($strings["start_date"], $taskDetail->tas_start_date[0]);
	    if ($taskDetail->tas_due_date[0] <= $date && $taskDetail->tas_completion[0] != "10") {
	        $block1->contentRow($strings["due_date"], "<b>" . $taskDetail->tas_due_date[0] . "</b>");
	    } else {
	        $block1->contentRow($strings["due_date"], $taskDetail->tas_due_date[0]);
	    }
	    if ($taskDetail->tas_complete_date[0] != "" && $taskDetail->tas_complete_date[0] != "--" && $taskDetail->tas_due_date[0] != "--") {
	        $diff = diff_date($taskDetail->tas_complete_date[0], $taskDetail->tas_due_date[0]);
	        if ($diff > 0) {
	            $diff = "<b>+$diff</b>";
	        }
	        $block1->contentRow($strings["complete_date"], $taskDetail->tas_complete_date[0]);
	        $block1->contentRow($strings["scope_creep"] . $blockPage->printHelp("task_scope_creep"), "$diff " . $strings["days"]);
	    }
	    $block1->contentRow($strings["estimated_time"], $taskDetail->tas_estimated_time[0] . " " . $strings["hours"]);

	    $taskActualTime = new request();
	    $actual_time = $taskActualTime->getTaskTime($id);
	    // $block1->contentRow($strings["actual_time"],$taskDetail->tas_actual_time[0]." ".$strings["hours"]);
	    $block1->contentRow($strings["actual_time"], $actual_time . " " . $strings["hours"]);

	    if ($sitePublish == "true") {
	        $block1->contentRow($strings["published"], $statusPublish[$idPublish]);
	    }
    } else {
        $block1->contentRow($strings["date"], $taskDetail->tas_start_date[0]);
    }

	$block1->contentRow($strings["comments"], nl2br($taskDetail->tas_comments[0]));

	$block1->contentTitle($strings["updates_task"]);
	$tmpquery = "WHERE upd.type='1' AND upd.item = '$id' ORDER BY upd.created DESC";
	$listUpdates = new request();
	$listUpdates->openUpdates($tmpquery);
	$comptListUpdates = count($listUpdates->upd_id);

	echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>";
	if ($comptListUpdates != "0") {
	    $j = 1;
	    for ($i = 0;$i < $comptListUpdates;$i++) {
	        if (ereg("\[status:([0-9])\]", $listUpdates->upd_comments[$i])) {
	            preg_match("|\[status:([0-9])\]|i", $listUpdates->upd_comments[$i], $matches);
	            $listUpdates->upd_comments[$i] = ereg_replace("\[status:([0-9])\]", "", $listUpdates->upd_comments[$i] . "<br>");
	            $listUpdates->upd_comments[$i] .= $strings["status"] . " " . $status[$matches[1]];
	        }
	        if (ereg("\[priority:([0-9])\]", $listUpdates->upd_comments[$i])) {
	            preg_match("|\[priority:([0-9])\]|i", $listUpdates->upd_comments[$i], $matches);
	            $listUpdates->upd_comments[$i] = ereg_replace("\[priority:([0-9])\]", "", $listUpdates->upd_comments[$i] . "<br>");
	            $listUpdates->upd_comments[$i] .= $strings["priority"] . " " . $priority[$matches[1]];
	        }
	        if (ereg("\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]", $listUpdates->upd_comments[$i])) {
	            preg_match("|\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]|i", $listUpdates->upd_comments[$i], $matches);
	            $listUpdates->upd_comments[$i] = ereg_replace("\[datedue:([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})\]", "", $listUpdates->upd_comments[$i] . "<br>");
	            $listUpdates->upd_comments[$i] .= $strings["due_date"] . " " . $matches[1];
	        }

	        $abbrev = stripslashes(substr($listUpdates->upd_comments[$i], 0, 100));

	        echo "<b>" . $j . ".</b> <i>" . createDate($listUpdates->upd_created[$i], $_SESSION['timezoneSession']) . "</i> $abbrev";
	        if (100 < strlen($listUpdates->upd_comments[$i])) {
	            echo "...<br>";
	        } else {
	            echo "<br>";
	        }
	        $j++;
	    }
	    echo "<br>" . buildLink("../tasks/historytask.php?type=1&amp;item=$id", $strings["show_details"], LINK_INSIDE);
	} else {
	    echo $strings["no_items"];
	}

	echo "</td></tr>";

	$block1->closeContent();
	$block1->closeToggle();
	$block1->closeForm();

	if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
	    $block1->openPaletteScript();
	    $block1->paletteScript(0, "remove", "../tasks/deletetasks.php?project=" . $taskDetail->tas_project[0] . "&id=" . $taskDetail->tas_id[0] . "", "true,true,false", $strings["delete"]);
	    $block1->paletteScript(1, "copy", "../tasks/edittask.php?project=" . $taskDetail->tas_project[0] . "&id=" . $taskDetail->tas_id[0] . '&cpy=true', "true,true,false", $strings["copy"]);
	    // $block1->paletteScript(2,"export","export.php?","true,true,false",$strings["export"]);
	    if ($sitePublish == "true") {
	        $block1->paletteScript(3, "add_projectsite", "../tasks/viewtask.php?addToSite=true&id=" . $taskDetail->tas_id[0] . "&action=publish", "true,true,true", $strings["add_project_site"]);
	        $block1->paletteScript(4, "remove_projectsite", "../tasks/viewtask.php?removeToSite=true&id=" . $taskDetail->tas_id[0] . "&action=publish", "true,true,true", $strings["remove_project_site"]);
	    }
	    $block1->paletteScript(5, "edit", "../tasks/edittask.php?project=" . $taskDetail->tas_project[0] . "&id=" . $taskDetail->tas_id[0] . '&cpy=false', "true,true,false", $strings["edit"]);
        if ($taskDetail->tas_milestone[0] != "0") {
	        $block1->paletteScript(6, "timelog", "../tasks/addtasktime.php?id=" . $taskDetail->tas_id[0], "true,true,false", $strings["loghours"]);
        }
	    $block1->closePaletteScript("", "");
	}
}

//--- linked content ------------------
if ($fileManagement == "true") {
    $block2 = new block();

    $block2->form = "tdC";
    $block2->openForm("../tasks/viewtask.php?id=$id#" . $block2->form . "Anchor");

    $block2->headingToggle($strings["linked_content"]);

    $block2->openPaletteIcon();
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        $block2->paletteIcon(0, "add", $strings["add"]);
        $block2->paletteIcon(1, "remove", $strings["delete"]);
        if ($sitePublish == "true") {
            $block2->paletteIcon(2, "add_projectsite", $strings["add_project_site"]);
            $block2->paletteIcon(3, "remove_projectsite", $strings["remove_project_site"]);
        }
    }
    $block2->paletteIcon(4, "info", $strings["view"]);
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        $block2->paletteIcon(5, "edit", $strings["edit"]);
    }
    $block2->closePaletteIcon();

    $block2->sorting("files", $sortingUser->sor_files[0], "fil.name ASC", $sortingFields = array(0 => "fil.extension", 1 => "fil.name", 2 => "fil.date", 3 => "fil.status", 4 => "fil.published"));

    $tmpquery = "WHERE fil.task = '$id' AND fil.vc_parent = '0' ORDER BY $block2->sortingValue";
    $listFiles = new request();
    $listFiles->openFiles($tmpquery);
    $comptListFiles = count($listFiles->fil_id);

    if ($comptListFiles != "0") {
        $block2->openResults();

        $block2->labels($labels = array(0 => $strings["type"], 1 => $strings["name"], 2 => $strings["date"], 3 => $strings["approval_tracking"], 4 => $strings["published"]), "true");

        require_once("../includes/files_types.php");

        for ($i = 0;$i < $comptListFiles;$i++) {
            $existFile = "false";
            $idStatus = $listFiles->fil_status[$i];
            $idPublish = $listFiles->fil_published[$i];

            $type = file_info_type($listFiles->fil_extension[$i]);
            if (file_exists("../files/" . $listFiles->fil_project[$i] . "/" . $listFiles->fil_task[$i] . "/" . $listFiles->fil_name[$i])) {
                $existFile = "true";
            } 
            $block2->openRow($listFiles->fil_id[$i]);
            $block2->checkboxRow($listFiles->fil_id[$i]);
            if ($existFile == "true") {
                $block2->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $type, LINK_ICON));
            } else {
                $block2->cellRow("&nbsp;");
            } 
            if ($existFile == "true") {
                $block2->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $listFiles->fil_name[$i], LINK_INSIDE));
            } else {
                $block2->cellRow($strings["missing_file"] . " (" . $listFiles->fil_name[$i] . ")");
            }
            $block2->cellRow($listFiles->fil_date[$i]);
            $block2->cellRow(buildLink("../linkedcontent/viewfile.php?id=" . $listFiles->fil_id[$i], $statusFile[$idStatus], LINK_INSIDE));
            if ($sitePublish == "true") {
                $block2->cellRow($statusPublish[$idPublish]);
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
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        $block2->paletteScript(0, "add", "../linkedcontent/addfile.php?project=" . $taskDetail->tas_project[0] . "&task=$id", "true,true,true", $strings["add"]);
        $block2->paletteScript(1, "remove", "../linkedcontent/deletefiles.php?project=" . $projectDetail->pro_id[0] . "&task=" . $taskDetail->tas_id[0] . "", "false,true,true", $strings["delete"]);
        if ($sitePublish == "true") {
            $block2->paletteScript(2, "add_projectsite", "../tasks/viewtask.php?addToSiteFile=true&task=" . $taskDetail->tas_id[0] . "&action=publish", "false,true,true", $strings["add_project_site"]);
            $block2->paletteScript(3, "remove_projectsite", "../tasks/viewtask.php?removeToSiteFile=true&task=" . $taskDetail->tas_id[0] . "&action=publish", "false,true,true", $strings["remove_project_site"]);
        }
    }
    $block2->paletteScript(4, "info", "../linkedcontent/viewfile.php?", "false,true,false", $strings["view"]);
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        $block2->paletteScript(5, "edit", "../linkedcontent/viewfile.php?edit=true", "false,true,false", $strings["edit"]);
    }
    $block2->closePaletteScript($comptListFiles, $listFiles->fil_id);
}

//--- assignment history ----------
{
	$block3 = new block();

	$block3->form = "ahT";
	$block3->openForm("../tasks/viewtask.php?id=$id#" . $block3->form . "Anchor");

	$block3->headingToggle($strings["assignment_history"]);
	$block3->headingToggle_close();

	$block3->sorting("assignment", $sortingUser->sor_assignment[0], "ass.assigned DESC", $sortingFields = array(0 => "ass.comments", 1 => "mem1.login", 2 => "mem2.login", 3 => "ass.assigned"));

	$tmpquery = "WHERE ass.task = '$id' ORDER BY $block3->sortingValue";
	$listAssign = new request();
	$listAssign->openAssignments($tmpquery);
	$comptListAssign = count($listAssign->ass_id);

	$block3->openResults($checkbox = "false");

	$block3->labels($labels = array(0 => $strings["comment"], 1 => $strings["assigned_by"], 2 => $strings["to"], 3 => $strings["assigned_on"]), "false");

	for ($i = 0;$i < $comptListAssign;$i++) {
	    $block3->openRow();
	    $block3->checkboxRow($listAssign->ass_id[$i], $checkbox = "false");
	    if ($listAssign->ass_comments[$i] != "") {
	        $block3->cellRow($listAssign->ass_comments[$i]);
	    } else if ($listAssign->ass_assigned_to[$i] == "0") {
	        $block3->cellRow($strings["task_unassigned"]);
	    } else {
	        $block3->cellRow($strings["task_assigned"] . " " . $listAssign->ass_mem2_name[$i] . " (" . $listAssign->ass_mem2_login[$i] . ")");
	    }
	    $block3->cellRow(buildLink($listAssign->ass_mem1_email_work[$i], $listAssign->ass_mem1_login[$i], LINK_MAIL));
	    if ($listAssign->ass_assigned_to[$i] == "0") {
	        $block3->cellRow($strings["unassigned"]);
	    } else {
	        $block3->cellRow(buildLink($listAssign->ass_mem2_email_work[$i], $listAssign->ass_mem2_login[$i], LINK_MAIL));
	    }
	    $block3->cellRow(createDate($listAssign->ass_assigned[$i], $_SESSION['timezoneSession']));
	    $block3->closeRow();
	}
	$block3->closeResults();

	$block3->closeToggle();
	$block3->closeFormResults();
	$block3->headingForm_close();
	$block3->closeForm();     //was missing ????
}

require_once("../themes/" . THEME . "/footer.php");

?>
