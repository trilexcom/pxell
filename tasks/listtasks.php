<?php // $Revision: 1.15 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listtasks.php,v 1.15 2005/06/11 05:23:56 vjack Exp $
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

if ($action == 'publish') {
    if ($addToSite == 'true') {
        $multi = strstr($id, '**');
        
        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['tasks'] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['tasks'] . " SET published='0' WHERE id = '$id'";
        }
        
        connectSql($tmpquery1);
        $msg = 'addToSite';
        $id = $project;
    }

    if ($removeToSite == 'true') {
        $multi = strstr($id, '**');
        
        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['tasks'] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['tasks'] . " SET published='1' WHERE id = '$id'";
        }
        
        connectSql($tmpquery1);
        $msg = 'removeToSite';
        $id = $project;
    }
}

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = 'false';
$tmpquery = "WHERE tea.project = '$project' AND tea.member = '" . $_SESSION['idSession'] . "'";

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

//--- header ---
$breadcrumbs[]=buildLink('../projects/listprojects.php?', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=buildLink('../projects/viewproject.php?id=' . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings['tasks'];

$pageSection='projects';
$pageTitle='<span class="type">' . $strings['project'] . ' : ' . $strings['tasks'] . '<br></span><span>' . $projectDetail->pro_name[0] . '</span>';
require_once('../themes/' . THEME . '/header.php');

//--- content ---
$blockPage=new block();
$blockPage->bornesNumber = '1';

// if phases are enabled grab phase data
if ($projectDetail->pro_phase_set[0] != '0') {
    $flag_phases = true;
    $tmpquery = "WHERE pha.project_id = '$project'";
    $listPhases = new request();
    $listPhases->openPhases($tmpquery);
}

//--- tasks open (ignore phases) ------------
{
    $block2 = new block();
    
    $block2->form = 'saTlO';
    $block2->openForm("../tasks/listtasks.php?project=$project#" . $block2->form . "Anchor");

    if (isset($flag_phases) && $flag_phases == true) {
        $block2->sorting(
            'tasks',
            $sortingUser->sor_tasks[0],
            'tas.due_date ASC',
            $sortingFields = array(
                #'tas.id',
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
    } else {
        $block2->sorting(
            'tasks',
            $sortingUser->sor_tasks[0],
            'tas.due_date ASC',
            $sortingFields = array(
                #'tas.id',
                'tas.priority',
                'tas.name',
                'tas.status',
                'tas.completion',
                'tas.due_date',
                'mem.login',
                'tas.published'
            )
        );
    }
    
    $block2->borne = $blockPage->returnBorne('1');
    $block2->rowsLimit = '50';
    
    $tmpquery = "WHERE tas.project = '$project' AND tas.status IN(0,2,3,5) AND tas.milestone = '1' ORDER BY $block2->sortingValue";
    $block2->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    $listOpenTasks = new request();
    $listOpenTasks->openTasks($tmpquery, $block2->borne, $block2->rowsLimit);
    $comptListTasks = count($listOpenTasks->tas_id);
    
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

        if (isset($flag_phases) && $flag_phases == true) {
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
            ), 'true');
        } else {
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
            ), 'true');
        }

        for ($i = 0; $i < $comptListTasks; $i++) {
            if ($listOpenTasks->tas_due_date[$i] == '') {
                $listOpenTasks->tas_due_date[$i] = $strings['none'];
            }

            $idStatus = $listOpenTasks->tas_status[$i];
            $idPriority = $listOpenTasks->tas_priority[$i];
            $idPublish = $listOpenTasks->tas_published[$i];
            $complValue = ($listOpenTasks->tas_completion[$i] > 0) ? $listOpenTasks->tas_completion[$i] . '0 %': $listOpenTasks->tas_completion[$i] . ' %';
            $block2->openRow($listOpenTasks->tas_id[$i]);

            $block2->checkboxRow($listOpenTasks->tas_id[$i]);

            //--- id ----
            #$block2->cellRow(buildLink("../tasks/viewtask.php?id=" . $listOpenTasks->tas_id[$i], $listOpenTasks->tas_id[$i], LINK_INSIDE));

            //--- prio ---
            if ($listOpenTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">'/* . $priority[$idPriority]*/, '1%', true);
            }

            //--- name ----
            if ($idStatus == 1) {
                $block2->cellRow(buildLink('../tasks/viewtask.php?id=' . $listOpenTasks->tas_id[$i], $listOpenTasks->tas_name[$i], LINK_STRIKE), "99%");
            } else {
                $block2->cellRow(buildLink('../tasks/viewtask.php?id=' . $listOpenTasks->tas_id[$i], $listOpenTasks->tas_name[$i], LINK_INSIDE),"99%");
            }

            //--- status ----
            if ($listOpenTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);
            }

            //--- complete ----
            if ($listOpenTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else {
                $block2->cellRow($complValue);
            }

            //---- due date ------
            if ($listOpenTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else if ($listOpenTasks->tas_due_date[$i] <= $date && $listOpenTasks->tas_completion[$i] != '10') {
                $block2->cellRow('<b>' . $listOpenTasks->tas_due_date[$i] . '</b>');
            } else {
                $block2->cellRow($listOpenTasks->tas_due_date[$i]);
            }
            if ($listOpenTasks->tas_start_date[$i] != "--" && $listOpenTasks->tas_due_date[$i] != '--') {
                $gantt = 'true';
            }
            
            //---- phase ------
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listOpenTasks->tas_parent_phase[$i];
                $block2->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
            }

            //--- assigned to -----
            if ($listOpenTasks->tas_milestone[$i] == "0") {
                $block2->cellRow("");
            } else if ($listOpenTasks->tas_assigned_to[$i] == '0') {
                $block2->cellRow($strings['unassigned']);
            }
            else {
                $block2->cellRow(buildLink($listOpenTasks->tas_mem_email_work[$i], $listOpenTasks->tas_mem_login[$i], LINK_MAIL));
            }
            
            //---- published ------
            if ($sitePublish == 'true') {
                if ($listOpenTasks->tas_milestone[$i] == "0") {
                    $block2->cellRow("");
                } else {
                    $block2->cellRow($statusPublish[$idPublish]);
                }
            }

            $block2->closeRow();
        }

        $block2->closeResults();
        $block2->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $project, 'id=' . $project);

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
    
    $block2->closePaletteScript($comptListTasks, $listOpenTasks->tas_id);
}

//--- milestones open (ignore phases) ------------
{
    $block4 = new block();
    
    $block4->form = 'saTlM';
    $block4->openForm("../tasks/listtasks.php?project=$project#" . $block4->form . "Anchor");
    
    if (isset($flag_phases) && $flag_phases == true) {
        $block4->sorting(
            'milestones',
            $sortingUser->sor_milestones[0],
            'tas.start_date ASC',
            $sortingFields = array(
                'tas.name',
                'tas.start_date',
                'tas.parent_phase'
                )
            );
    } else {
        $block4->sorting(
            'milestones',
            $sortingUser->sor_milestones[0],
            'tas.start_date ASC',
            $sortingFields = array(
                'tas.name',
                'tas.start_date'
            )
        );
    }

    $block4->borne = $blockPage->returnBorne('1');
    $block4->rowsLimit = '10';
    
    $tmpquery = "WHERE tas.project = '$project' AND tas.milestone = '0' ORDER BY $block4->sortingValue";

    $block4->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    $listMilestones = new request();
    $listMilestones->openTasks($tmpquery, $block4->borne, $block4->rowsLimit);
    $comptListMilestones = count($listMilestones->tas_id);
    
    $block4->headingToggle($strings['milestone']. ' <span class=addition>(' . $comptListMilestones . ')</span>');
    $block4->openPaletteIcon();

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block4->paletteIcon(0, 'add', $strings['add']);
        $block4->paletteIcon(1, 'remove', $strings['delete']);
        $block4->paletteIcon(2, 'copy', $strings['copy']);
    }

    $block4->paletteIcon(6, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block4->paletteIcon(7, 'edit', $strings['edit']);
    }

    $block4->closePaletteIcon();

    if ($comptListMilestones != '0') {
        $block4->openResults();

        if (isset($flag_phases) && $flag_phases == true) {
            $block4->labels(
                $labels = array(
                    $strings['name'],
                    $strings['date'],
                    $strings['phase']
                    ),
                'true');
        } else {
            $block4->labels(
                $labels = array(
                    $strings['name'],
                    $strings['date']
                ),
            'true');
        }

        for ($i = 0; $i < $comptListMilestones; $i++) {
            $idPublish = $listMilestones->tas_published[$i];
            $idStatus  = $listMilestones->tas_status[$i];

            $block4->openRow($listMilestones->tas_id[$i]);
            $block4->checkboxRow($listMilestones->tas_id[$i]);

            //--- name ----
            $block4->cellRow(buildLink('../tasks/viewtask.php?id=' . $listMilestones->tas_id[$i], $listMilestones->tas_name[$i], LINK_INSIDE),"70%");

            //--- date ---
            $block4->cellRow($listMilestones->tas_start_date[$i]);

            //--- parent phase ---
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listMilestones->tas_parent_phase[$i];
                $block4->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
            }

            $block4->closeRow();
        }

        $block4->closeResults();
        $block4->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $project, 'id=' . $project);
    } else {
        $block4->noresults();
    }

    $block4->closeToggle();
    $block4->closeFormResults();

    $block4->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block4->paletteScript(0, 'add', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
        $block4->paletteScript(1, 'remove', '../tasks/deletetasks.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block4->paletteScript(2, 'copy', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0] . '&cpy=true', 'false,true,false', $strings['copy']);
    }

    $block4->paletteScript(6, 'info', '../tasks/viewtask.php', 'false,true,false', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block4->paletteScript(7, 'edit', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['edit']);
    }

    $block4->closePaletteScript($comptListMilestones, $listMilestones->tas_id);
}

//--- tasks closed (ignore phases) ------------
{
    $block3 = new block();

    //--- block header ----
    $block3->form = 'saTlC';
    $block3->openForm("../tasks/listtasks.php?project=$project#" . $block3->form . "Anchor");

    if (isset($flag_phases) && $flag_phases == true) {
        $block3->sorting(
            "tasks_closed",
            $sortingUser->sor_tasks_closed[0],
            "tas.due_date ASC",
            $sortingFields = array(
                #"tas.id",
                "tas.priority",
                "tas.name",
                "tas.status",
                "tas.completion",
                "tas.due_date",
                'tas.parent_phase',
                "mem.login",
                "tas.published"
            )
        );
    } else {
        $block3->sorting(
            "tasks_closed",
            $sortingUser->sor_tasks_closed[0],
            "tas.due_date ASC",
            $sortingFields = array(
                #"tas.id",
                "tas.priority",
                "tas.name",
                "tas.status",
                "tas.completion",
                "tas.due_date",
                "mem.login",
                "tas.published"
            )
        );
    }
    
    $block3->borne = $blockPage->returnBorne('1');
    $block3->rowsLimit = '20';
    
    //--- get data from sql ---------
    $tmpquery = "WHERE tas.project = '$project' AND tas.status NOT IN(0,2,3,5) AND tas.milestone = '1' ORDER BY $block3->sortingValue";
    $block3->recordsTotal = compt($initrequest['tasks'] . ' ' . $tmpquery);

    //--- list ---------
    $listClosedTasks = new request();
    $listClosedTasks->openTasks($tmpquery, $block3->borne, $block3->rowsLimit);
    $comptListTasks = count($listClosedTasks->tas_id);
    
    $block3->headingToggle($strings['tasks_closed'] . ' <span class=addition>(' . $comptListTasks . ')</span>');
    $block3->openPaletteIcon();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteIcon(0, 'add', $strings['add']);
        $block3->paletteIcon(1, 'remove', $strings['delete']);
        $block3->paletteIcon(2, 'copy', $strings['copy']);
        // $block3->paletteIcon(3,'export',$strings['export']);
        if ($sitePublish == 'true') {
            $block3->paletteIcon(4, 'add_projectsite', $strings['add_project_site']);
            $block3->paletteIcon(5, 'remove_projectsite', $strings['remove_project_site']);
        }
    }
    
    $block3->paletteIcon(6, 'info', $strings['view']);
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteIcon(7, 'edit', $strings['edit']);
        $block3->paletteIcon(8, 'timelog', $strings['loghours']);
    }
    
    $block3->closePaletteIcon();

    if ($comptListTasks != '0') {
        $block3->openResults();

        if (isset($flag_phases) && $flag_phases == true) {
            $block3->labels(
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
            ), 'true');
        } else {
            $block3->labels(
            $labels = array(
                #$strings['id'],
                'P',
                $strings['name'],
                $strings['status'],
                $strings['completion'],
                $strings['due_date'],
                $strings['assigned_to'],
                $strings['published']
            ), 'true');
        }
        
        for ($i = 0; $i < $comptListTasks; $i++) {
            if ($listClosedTasks->tas_due_date[$i] == '') {
                $listClosedTasks->tas_due_date[$i] = $strings['none'];
            }

            $idStatus = $listClosedTasks->tas_status[$i];
            $idPriority = $listClosedTasks->tas_priority[$i];
            $idPublish = $listClosedTasks->tas_published[$i];
            $complValue = ($listClosedTasks->tas_completion[$i] > 0) ? $listClosedTasks->tas_completion[$i] . '0 %': $listClosedTasks->tas_completion[$i] . ' %';
            $block3->openRow($listClosedTasks->tas_id[$i]);

            $block3->checkboxRow($listClosedTasks->tas_id[$i]);

            //--- id ----
            #$block3->cellRow(buildLink("../tasks/viewtask.php?id=" . $listClosedTasks->tas_id[$i], $listClosedTasks->tas_id[$i], LINK_INSIDE));

            //--- prio ---
            $block3->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">'/* . $priority[$idPriority]*/, '1%', true);

            //--- name ----
            if ($idStatus == 1 OR $idStatus == 6) {
                $block3->cellRow(buildLink('../tasks/viewtask.php?id=' . $listClosedTasks->tas_id[$i], $listClosedTasks->tas_name[$i], LINK_STRIKE), "99%");
            } else {
                $block3->cellRow(buildLink('../tasks/viewtask.php?id=' . $listClosedTasks->tas_id[$i], $listClosedTasks->tas_name[$i], LINK_INSIDE),"99%");
            }

            //--- status ----
            $block3->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

            //--- complete ----
            $block3->cellRow($complValue);

            //---- due date ------
            if ($listClosedTasks->tas_due_date[$i] <= $date && $listClosedTasks->tas_completion[$i] != '10') {
                $block3->cellRow('<b>' . $listClosedTasks->tas_due_date[$i] . '</b>');
            } else {
                $block3->cellRow($listClosedTasks->tas_due_date[$i]);
            }
            if ($listClosedTasks->tas_start_date[$i] != "--" && $listClosedTasks->tas_due_date[$i] != '--') {
                $gantt = 'true';
            }
            
            //---- phase ------
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listClosedTasks->tas_parent_phase[$i];
                $block3->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
            }

            //--- assigned to -----
            if ($listClosedTasks->tas_assigned_to[$i] == '0') {
                $block3->cellRow($strings['unassigned']);
            }
            else {
                $block3->cellRow(buildLink($listClosedTasks->tas_mem_email_work[$i], $listClosedTasks->tas_mem_login[$i], LINK_MAIL));
            }

            //---- published ------
            if ($sitePublish == 'true') {
                $block3->cellRow($statusPublish[$idPublish]);
            }
            $block3->closeRow();
        }

        $block3->closeResults();
        $block3->bornesFooter('1', $blockPage->bornesNumber, '../tasks/listtasks.php?project=' . $project, 'id=' . $project);
    } else {
        $block3->noresults();
    }
    
    $block3->closeToggle();
    $block3->closeFormResults();

    $block3->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteScript(0, 'add', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
        $block3->paletteScript(1, 'remove', '../tasks/deletetasks.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block3->paletteScript(2, 'copy', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0] . '&cpy=true', 'false,true,false', $strings['copy']);
        // $block3->paletteScript(3,'export','../projects/exportproject.php','false,true,true',$strings['export']);
        if ($sitePublish == 'true') {
            $block3->paletteScript(4, 'add_projectsite', '../projects/viewproject.php?addToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block3->paletteScript(5, 'remove_projectsite', '../projects/viewproject.php?removeToSiteTask=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }
    $block3->paletteScript(6, 'info', '../tasks/viewtask.php', 'false,true,false', $strings['view']);
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteScript(7, 'edit', '../tasks/edittask.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['edit']);
        $block3->paletteScript(8, 'timelog', '../tasks/addtasktime.php', 'false,true,false', $strings['loghours']);
    }
    $block3->closePaletteScript($comptListTasks, $listClosedTasks->tas_id);
}

require_once("../themes/" . THEME . "/footer.php");

?>
