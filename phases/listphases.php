<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listphases.php,v 1.8 2005/05/25 01:25:59 madbear Exp $
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


$tmpquery = "WHERE pro.id = '$id'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = "false";

$tmpquery = "WHERE tea.project = '$id' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);

if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
}

$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["phases"];

require_once("../themes/" . THEME . "/header.php");

//--- Phases -----------------------------------------
if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
    $block7 = new block();
    $block7->form = "wbSe";
    $block7->openForm("../phases/listphases.php?id=$id#" . $block7->form . "Anchor");

    $block7->sorting(
        'phases', 
        $sortingUser->sor_phases[0], 
        'pha.order_num ASC', 
        $sortingFields = array(
            'pha.order_num', 
            'pha.name', 
            'none', 
            'none', 
            'none', 
            'pha.status', 
            'pha.date_start', 
            'pha.date_end'
        )
    );
    
    $tmpquery = "WHERE pha.project_id = '$id' ORDER BY $block7->sortingValue";
    $listPhases = new request();
    $listPhases->openPhases($tmpquery);
    $comptListPhases = count($listPhases->pha_id);

    $block7->headingToggle($strings['phases'] . " <span class=addition>($comptListPhases)</span>");
    $block7->openPaletteIcon();
    
    $block7->paletteIcon(0, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
            $block7->paletteIcon(1, 'edit', $strings['edit']);
        }
    }
    
    $block7->closePaletteIcon();

    if ($comptListPhases != '0') {
        $block7->openResults();
        $block7->labels(
            $labels = array(
                $strings['order'], 
                $strings['name'], 
                $strings['total_tasks'], 
                $strings['uncomplete_tasks'], 
                $strings['milestone'], 
                $strings['status'], 
                $strings['date_start'], 
                $strings['date_end']), 
            'false'
        );

        $tmpquery = "WHERE tas.project = '$id'";
        $countPhaseTasks = new request();
        $countPhaseTasks->openTasks($tmpquery);
        $comptlistTasks = count($countPhaseTasks->tas_id);

        for ($i = 0; $i < $comptListPhases; $i++) {
            $comptlistTasksRow = 0;
            $comptUncompleteTasks = 0;
            $comptMilestones = 0;
            
            for ($k = 0; $k < $comptlistTasks; $k++) {
                if ($listPhases->pha_order_num[$i] == $countPhaseTasks->tas_parent_phase[$k]) {
                    if ($countPhaseTasks->tas_milestone[$k] == '0') {
                        $comptMilestones = $comptMilestones + 1;
                    } else {
                        $comptlistTasksRow = $comptlistTasksRow + 1;
                        
                        if ($countPhaseTasks->tas_status[$k] == '2' || $countPhaseTasks->tas_status[$k] == '3' || $countPhaseTasks->tas_status[$k] == '4') {
                            $comptUncompleteTasks = $comptUncompleteTasks + 1;
                        }
                    }
                }
            }

            $block7->openRow($listPhases->pha_id[$i]);
            $block7->checkboxRow($listPhases->pha_id[$i]);
            $block7->cellRow($listPhases->pha_order_num[$i]);
            $block7->cellRow(buildLink('../phases/viewphase.php?id=' . $listPhases->pha_id[$i], $listPhases->pha_name[$i], LINK_INSIDE));
            $block7->cellRow($comptlistTasksRow);
            $block7->cellRow($comptUncompleteTasks);
            $block7->cellRow($comptMilestones);
            $block7->cellRow('<img src="../themes/' . THEME . '/gfx_status/phase_' . $listPhases->pha_status[$i] . '.gif" alt="' . $phaseStatus[$listPhases->pha_status[$i]] . '">&nbsp;' . $phaseStatus[$listPhases->pha_status[$i]], '', true);
            $block7->cellRow($listPhases->pha_date_start[$i]);
            $block7->cellRow($listPhases->pha_date_end[$i]);
            $block7->closeRow();
        }
        $block7->closeResults();
    } else {
        $block7->noresults();
    }
    
    $block7->closeToggle();
    $block7->closeFormResults();

    $block7->openPaletteScript();
    $block7->paletteScript(0, "info", "../phases/viewphase.php?", "false,true,true", $strings["view"]);
    
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "5") {
            $block7->paletteScript(1, "edit", "../phases/editphase.php?", "false,true,true", $strings["edit"]);
        } 
    }
    
    $block7->closePaletteScript($comptListPhases, $listPhases->pha_id);
}








//--- tasks open (with phases) ------------
{
    $block2 = new block();

    $block2->form = 'wbTuuO';
    $block2->openForm("../phases/listphases.php?id=$id#" . $block2->form . "Anchor");

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
            'tas.parent_phase',
            'mem.login',
            'tas.published'
        )
    );
    
    $blockPage= new block();
    
    $block2->borne = $blockPage->returnBorne('1');
    $block2->rowsLimit = '20';

    $tmpquery = "WHERE tas.project = '$id' AND tas.status IN(0,2,3) AND tas.milestone = '1' ORDER BY $block2->sortingValue";
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
                $strings['phase'],
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
            
            //---- phase ------
            $pha_id = $listTasks->tas_parent_phase[$i];
            $block2->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');

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
                echo "<a href='../projects/viewproject.php?id=" . $projectDetail->pro_id[0] . "'>expand</a><br>";
            } else {
                echo "<a href='../projects/viewproject.php?id=" . $projectDetail->pro_id[0] . "&amp;base=1'>compact</a><br>";
            }

            echo '<img src="../tasks/graphtasks.php?project=' . $projectDetail->pro_id[0] . '&amp;base=' . $_GET['base'] . '" alt=""><br>
<span class="listEvenBold">' . buildLink('http://www.aditus.nu/jpgraph/', 'JpGraph', LINK_POWERED) . '</span>';
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
    $block9->openForm("../phases/listphases.php?id=$id#" . $block9->form . "Anchor");

    $block9->sorting(
        'milestones',
        $sortingUser->sor_milestones[0],
        'tas.start_date ASC',
        $sortingFields = array(
            'tas.name',
            'tas.start_date',
            'tas.parent_phase'
        )
    );

    $block9->borne = $blockPage->returnBorne('1');
    $block9->rowsLimit = '20';

    $tmpquery = "WHERE tas.project = '$id' AND tas.milestone = '0' ORDER BY $block9->sortingValue";

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
                $strings['date'],
                $strings['phase']
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

            //--- parent phase ---
            $pha_id = $listMilestones->tas_parent_phase[$i];
            $block9->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');

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
    $block10->openForm("../phases/listphases.php?id=$id#" . $block10->form . "Anchor");

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
            'tas.parent_phase',
            'mem.login',
            'tas.published'
        )
    );
    
    $block10->borne = $blockPage->returnBorne('1');
    $block10->rowsLimit = '20';
    
    //--- get data from sql ---------
    $tmpquery = "WHERE tas.project = '$id' AND tas.status NOT IN(0,2,3) AND tas.milestone = '1' ORDER BY $block10->sortingValue";
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
                $strings['phase'],
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
            
            //---- phase ------
            $pha_id = $listTasks->tas_parent_phase[$i];
            $block10->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');

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

require_once("../themes/" . THEME . "/footer.php");

?>