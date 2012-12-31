<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * Author: Michael Cook <michael@ink.org>
 * Date:   07-14-2003
 * 
 * $Id: snapshot.php,v 1.7 2005/06/08 06:49:52 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/snapshot.php
 * 
 * show a basic overview of all projects for a project manager
 */

$checkSession = true;
require_once("../includes/library.php");


//--- header ---
$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");
$blockPage= new block();

//--- content ---
$query = " WHERE pro.owner = '" . $_SESSION['idSession'] . "' and pro.status > 1";
$tmpquery = "$query ORDER BY pro.name";
$listProjects = new request();
$listProjects->openProjects($tmpquery);
$comptListProjects = count($listProjects->pro_id);
// show the nice number-of-results header
$block0 = new block();
$block0->openContent();
$block0->contentTitle($strings["report_results"]);

if ($comptListProjects == "0") {
    $blockPage->contentRow("", "0 " . $strings["matches"] . "<br>" . $strings["no_results_report"]);
} 

if ($comptListProjects == "1") {
    $blockPage->contentRow("", "1 " . $strings["match"]);
} 

if ($comptListProjects > "1") {
    $blockPage->contentRow("", $comptListProjects . " " . $strings["matches"]);
} 

$block0->closeContent();
$block0->block_close();

if ($comptListProjects != "0") {
    for ($j = 0;$j < $comptListProjects;$j++) {
        $projectTitle = $listProjects->pro_name[$j];
        $projectId = $listProjects->pro_id[$j];
        $projectPriority = $listProjects->pro_priority[$j];
        $blockProject = new block();
  
        $blockProject->headingForm(buildLink("../projects/viewproject.php?id=" . $projectId, $projectTitle, LINK_INSIDE));
		$blockProject->openContent(); // correct order????
        $blockProject->contentTitle($strings["details"]);
        $blockProject->contentRow($strings["priority"], "<img src=\"../themes/" . THEME . "/gfx_priority/" . $projectPriority . ".gif\" alt=\"\">&nbsp;" . $priority[$projectPriority]);
        $blockProject->contentRow($strings["created"], createDate($listProjects->pro_created[$j], $_SESSION['timezoneSession']));
        $blockProject->contentRow($strings["modified"], createDate($listProjects->pro_modified[$j], $_SESSION['timezoneSession']));

        if ($listProjects->pro_org_id[$j] == "1") {
            $blockProject->contentRow($strings["organization"],
                $strings["none"]);
        } else {
            $blockProject->contentRow($strings["organization"], buildLink("../clients/viewclient.php?id=" . $listProjects->pro_org_id[$j], $listProjects->pro_org_name[$j], LINK_INSIDE));
        } 

        $blockProject->contentRow($strings["status"], $status[$listProjects->pro_status[$j]]);
        $queryTask = " WHERE tas.project = '$projectId'";
        $tmpqueryTask = "$queryTask ORDER BY tas.due_date";

		$blockProject->closeContent();
		$blockProject->heading_close();

        $listTasks = new request();
        $listTasks->openTasks($tmpqueryTask);
        $comptListTasks = count($listTasks->tas_id);
		
        $blockProject->openResults("false");

        $blockProject->labels($labels = array(0 => $strings["task"], 1 => $strings["priority"], 2 => $strings["status"], 3 => $strings["due_date"], 4 => $strings["completed"], 5 => $strings["assigned_to"], 6 => $strings["published"]), "true");

        if ($comptListProjects != "0") {
            for ($i = 0;$i < $comptListTasks;$i++) {
                if ($listTasks->tas_due_date[$i] == "--" or
                    $listTasks->tas_due_date[$i] == "") {
                    $listTasks->tas_due_date[$i] = $strings["none"];
                } 

                $idStatus = $listTasks->tas_status[$i];
                $idPriority = $listTasks->tas_priority[$i];
                $idPublished = $listTasks->tas_published[$i];
                $complValue = ($listTasks->tas_completion[$i] > 0) ? $listTasks->tas_completion[$i] . "0 %": $listTasks->tas_completion[$i] . " %";

                $blockProject->openRow();
                $blockProject->checkboxRow($listTasks->tas_id[$i], $checkbox = "false");
                $blockProject->cellRow(buildLink("../tasks/viewtask.php?id=" . $listTasks->tas_id[$i], $listTasks->tas_name[$i], LINK_INSIDE));

                $blockProject->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);
                $blockProject->cellRow($status[$idStatus]);
                $blockProject->cellRow($listTasks->tas_due_date[$i]);

                if ($complValue != "100 %") {
                    $blockProject->cellRow($complValue);
                } else {
                    $blockProject->cellRow($listTasks->tas_complete_date[$i]);
                } 

                if ($listTasks->tas_assigned_to[$i] == "0") {
                    $blockProject->cellRow($strings["unassigned"]);
                } else {
                    $blockProject->cellRow($listTasks->tas_mem_login[$i]);
                } 

                $blockProject->cellRow($statusPublish[$idPublished]);
                $blockProject->closeRow();
            } 
        } else {
            // no tasks for project
        } 

        $blockProject->closeResults();
		$blockProject->block_close();
		$blockProject->block_close();
    } 
    // $blockProject->closeContent();
} else {
    // $block1->noresults();
} 
// $block1->closeContent();
require_once("../themes/" . THEME . "/footer.php");

?>
