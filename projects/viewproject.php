<?php // $Revision: 1.27 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewproject.php,v 1.27 2005/05/30 16:12:39 madbear Exp $
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
    $closeTopic = $_GET['closeTopic'];
    
    if ($closeTopic == 'true') {
        $multi = strstr($id, '**');
        
        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET status='0' WHERE id IN($id)";
            $pieces = explode(',', $id);
            $num = count($pieces);
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['topics'] . " SET status='0' WHERE id = '$id'";
            $num = 1;
        }
        
        connectSql($tmpquery1);
        $msg = 'closeTopic';
        $id = $project;
    }

    $addToSiteTask = $_GET['addToSiteTask'];
    
    if ($addToSiteTask == 'true') {
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

    $removeToSiteTask = $_GET['removeToSiteTask'];
    
    if ($removeToSiteTask == 'true') {
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

    $addToSiteTopic = $_GET['addToSiteTopic'];
    
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
        $id = $project;
    }

    $removeToSiteTopic = $_GET['removeToSiteTopic'];
    
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
        $id = $project;
    }

    $addToSiteTeam = $_GET['addToSiteTeam'];
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

    $removeToSiteTeam = $_GET['removeToSiteTeam'];
    
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

    $addToSiteFile = $_GET['addToSiteFile'];
    
    if ($addToSiteFile == 'true') {
        $id = str_replace('**', ',', $id);
        $tmpquery1 = 'UPDATE ' . $tableCollab['files'] . " SET published='0' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql($tmpquery1);
        $msg = 'addToSite';
        $id = $project;
    }

    $removeToSiteFile = $_GET['removeToSiteFile'];
    
    if ($removeToSiteFile == 'true') {
        $id = str_replace('**', ',', $id);
        $tmpquery1 = 'UPDATE ' . $tableCollab['files'] . " SET published='1' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql($tmpquery1);
        $msg = 'removeToSite';
        $id = $project;
    }

    $addToSiteNote = $_GET['addToSiteNote'];
    
    if ($addToSiteNote == 'true') {
        $multi = strstr($id, '**');
        
        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='0' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='0' WHERE id = '$id'";
        }
        
        connectSql($tmpquery1);
        $msg = 'addToSite';
        $id = $project;
    }

    $removeToSiteNote = $_GET['removeToSiteNote'];
    
    if ($removeToSiteNote == 'true') {
        $multi = strstr($id, '**');
        
        if ($multi != '') {
            $id = str_replace('**', ',', $id);
            $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='1' WHERE id IN($id)";
        } else {
            $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='1' WHERE id = '$id'";
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

if ($comptProjectDetail == '0') {
    header('Location: ../projects/listprojects.php?msg=blankProject');
    exit;
}

$tmpquery = "WHERE tas.project = '$id' AND tas.milestone <> '0' ORDER BY tas.name";
$listTasksTime = new request();
$listTasksTime->openTasks($tmpquery);
$comptListTasksTime = count($listTasksTime->tas_id);

if ($comptListTasksTime != '0') {
    for ($i = 0; $i < $comptListTasksTime; $i++) {
        $estimated_time = $estimated_time + $listTasksTime->tas_estimated_time[$i];
        // $actual_time = $actual_time + $listTasksTime->tas_actual_time[$i];
        
        if ($listTasksTime->tas_complete_date[$i] != '' && $listTasksTime->tas_complete_date[$i] != '--' && $listTasksTime->tas_due_date[$i] != '--') {
            $diff = diff_date($listTasksTime->tas_complete_date[$i], $listTasksTime->tas_due_date[$i]);
            $diff_time = $diff_time + $diff;
        }
    }
    
    if ($diff_time > 0) {
        $diff_time = '<b>+' . $diff_time . '</b>';
    }
}

// get Project Actual Time
$projActualTime = new request();
$proj_time = $projActualTime->getProjectTime($id);

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
    header('Location: ../general/permissiondenied.php');
    exit;
}

if ($enableHelpSupport == 'true' && ($teamMember == 'true' || $_SESSION['profilSession'] == '5')) {
    $tmpquery = "WHERE sr.status = '0' AND sr.project = '" . $projectDetail->pro_id[0] . "'";
    $listNewRequests = new request();
    $listNewRequests->openSupportRequests($tmpquery);
    $comptListNewRequests = count($listNewRequests->sr_id);

    $tmpquery = "WHERE sr.status = '1' AND sr.project = '" . $projectDetail->pro_id[0] . "'";
    $listOpenRequests = new request();
    $listOpenRequests->openSupportRequests($tmpquery);
    $comptListOpenRequests = count($listOpenRequests->sr_id);

    $tmpquery = "WHERE sr.status = '2' AND sr.project = '" . $projectDetail->pro_id[0] . "'";
    $listCompleteRequests = new request();
    $listCompleteRequests->openSupportRequests($tmpquery);
    $comptListCompleteRequests = count($listCompleteRequests->sr_id);
}

//--- header ----------------------------------------------------------------------------------
$breadcrumbs[]=buildLink('../projects/listprojects.php', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=$projectDetail->pro_name[0];

$pageSection='projects';
$pageTitle= "<span class=type>". $strings['project']."<br></span><span class=name>". $projectDetail->pro_name[0]."</span>";
require_once('../themes/' . THEME . '/header.php');

//--- content ---------------------------------------------------------------------------------
$blockPage= new block();
$blockPage->bornesNumber = '4';

$idStatus = $projectDetail->pro_status[0];
$idPriority = $projectDetail->pro_priority[0];

//--- details --------
{
    $block1 = new block();

    $block1->form = 'pdD';
    $block1->openForm('../projects/listprojects.php#' . $block1->form . 'Anchor');

    #$block1->headingToggle($strings['project'] . ' : ' . $projectDetail->pro_name[0]);
    $block1->headingToggle($strings['details']);

    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $enable_cvs == 'true' || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
        $block1->openPaletteIcon();
        
        if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
            $block1->paletteIcon(0, 'remove', $strings['delete']);
            $block1->paletteIcon(1, 'copy', $strings['copy']);
            $block1->paletteIcon(2, 'export', $strings['export']);
            $block1->paletteIcon(3, 'edit', $strings['edit']);
        }
        
        if ($enable_cvs == 'true') {
            $block1->paletteIcon(4, 'cvs', $strings['browse_cvs']);
        }
        
        // if mantis bug tracker enabled
        if ($enableMantis == 'true') {
            $block1->paletteIcon(5, 'bug', $strings['bug']);
        }

        $block1->closePaletteIcon();
    } else {
        $block1->headingToggle_close();
    }

    $block1->openContent();
    $block1->contentTitle($strings['details']);

    $block1->contentRow($strings['name'], $projectDetail->pro_name[0]);
    $block1->contentRow($strings['project_id'], $projectDetail->pro_id[0]);
    $block1->contentRow($strings['priority'], $priority[$idPriority]);
    
    // List open phases and link to phase details
    if ($projectDetail->pro_phase_set[0] != '0') {
        $tmpquery = "WHERE pha.project_id = '$id' AND status = '1' ORDER BY pha.order_num";
        $currentPhase = new request();
        $currentPhase->openPhases($tmpquery);
        $comptCurrentPhase = count($currentPhase->pha_id);
        
        if ($comptCurrentPhase == 0) {
            $block1->contentRow($strings['current_phase'], $strings['no_current_phase']);
        } else {
            for ($i = 0; $i < $comptCurrentPhase; $i++) {
                if ($i != $comptCurrentPhase) {
                    $pnum = $i + 1;
                    $phasesList .= "$pnum.<a href=\"../phases/viewphase.php?id=" . $currentPhase->pha_id[$i] . '">' . $currentPhase->pha_name[$i] . '</a>  ';
                }
            }
            
            $block1->contentRow($strings['current_phase'], $phasesList);
        }
    } else {
        $block1->contentRow($strings['phase_enabled'], $strings['false']);
    }

    $block1->contentRow($strings['description'], nl2br($projectDetail->pro_description[0]));
    $block1->contentRow($strings['ical_url'], buildLink("$root/calendar/icalendar.php", "$root/calendar/icalendar.php", LINK_OUT));
    $block1->contentRow($strings['url_dev'], buildLink($projectDetail->pro_url_dev[0], $projectDetail->pro_url_dev[0], LINK_OUT));
    $block1->contentRow($strings['url_prod'], buildLink($projectDetail->pro_url_prod[0], $projectDetail->pro_url_prod[0], LINK_OUT));
    $block1->contentRow($strings['owner'], buildLink('../users/viewuser.php?id=' . $projectDetail->pro_mem_id[0], $projectDetail->pro_mem_name[0], LINK_INSIDE) . ' (' . buildLink($projectDetail->pro_mem_email_work[0], $projectDetail->pro_mem_login[0], LINK_MAIL) . ')');
    $block1->contentRow($strings['created'], createDate($projectDetail->pro_created[0], $_SESSION['timezoneSession']));
    $block1->contentRow($strings['modified'], createDate($projectDetail->pro_modified[0], $_SESSION['timezoneSession']));
    
    if ($projectDetail->pro_org_id[0] == '1') {
        $block1->contentRow($strings['organization'], $strings['none']);
    } else {
        $block1->contentRow($strings['organization'], buildLink('../clients/viewclient.php?id=' . $projectDetail->pro_org_id[0], $projectDetail->pro_org_name[0], LINK_INSIDE));
    }

    $block1->contentRow($strings['status'], $status[$idStatus]);
    $block1->contentRow($strings['type'], $projectType[$projectDetail->pro_type[0]]);

    if ($fileManagement == 'true') {
        $block1->contentRow($strings['max_upload'] . $blockPage->printHelp('max_file_size'), convertSize($projectDetail->pro_upload_max[0]));
        $block1->contentRow($strings['project_folder_size'] . $blockPage->printHelp('project_disk_space'), convertSize(folder_info_size('../files/' . $projectDetail->pro_id[0] . '/')));
    }
    
    $block1->contentRow($strings['estimated_time'], $estimated_time . ' ' . $strings['hours']);
    $block1->contentRow($strings['actual_time'], $proj_time . ' ' . $strings['hours']);
    $block1->contentRow($strings['scope_creep'] . $blockPage->printHelp('project_scope_creep'), $diff_time . ' ' . $strings['days']);
    
    if ($sitePublish == 'true') {
        if ($projectDetail->pro_published[0] == '1') {
            $block1->contentRow($strings['project_site'], '&lt;' . buildLink('../projects/addprojectsite.php?id=' . $id, $strings['create'] . '...', LINK_INSIDE) . '&gt;');
        } else {
            $block1->contentRow($strings['project_site'], '&lt;' . buildLink('../projects/viewprojectsite.php?id=' . $id, $strings['details'], LINK_INSIDE) . '&gt;');
        }
    }

    if ($enableHelpSupport == 'true' && ($teamMember == 'true' || $_SESSION['profilSession'] == '5') && $supportType == 'team') {
        $block1->contentTitle($strings['support']);
        $block1->contentRow($strings['new_requests'], $comptListNewRequests . ' - ' . buildLink('../support/support.php?action=new&amp;project=' . $projectDetail->pro_id[0], $strings['manage_new_requests'], LINK_INSIDE));
        $block1->contentRow($strings['open_requests'], $comptListOpenRequests . ' - ' . buildLink('../support/support.php?action=open&amp;project=' . $projectDetail->pro_id[0], $strings['manage_open_requests'], LINK_INSIDE));
        $block1->contentRow($strings['closed_requests'], $comptListCompleteRequests . ' - ' . buildLink('../support/support.php?action=complete&amp;project=' . $projectDetail->pro_id[0], $strings['manage_closed_requests'], LINK_INSIDE));
    }
    
    $block1->closeContent();
    $block1->closeToggle();
    $block1->closeForm();

    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $enable_cvs == 'true' || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
        $block1->openPaletteScript();
        
        if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
            $block1->paletteScript(0, 'remove', '../projects/deleteproject.php?id=' . $id, 'true,true,false', $strings['delete']);
            $block1->paletteScript(1, 'copy', '../projects/editproject.php?id=' . $projectDetail->pro_id[0] . '&cpy=true', 'true,true,false', $strings['copy']);
            $block1->paletteScript(2, 'export', '../projects/exportproject.php?languageSession=' . $_SESSION['languageSession'] . '&type=project&id=' . $projectDetail->pro_id[0], 'true,true,false', $strings['export']);
            $block1->paletteScript(3, 'edit', '../projects/editproject.php?id=' . $projectDetail->pro_id[0] . '&cpy=false', 'true,true,false', $strings['edit']);
        }

        if ($enable_cvs == 'true') {
            $block1->paletteScript(4, 'cvs', '../browsecvs/browsecvs.php?id=' . $id, 'true,true,false', $strings['browse_cvs']);
        }

        if ($enableMantis == 'true') {
            $block1->paletteScript(5, 'bug', $pathMantis . 'login.php?id=' . $projectDetail->pro_id[0] . "url=http://{$HTTP_HOST}{$REQUEST_URI}&f_username=" . $_SESSION['loginSession'] . "&f_password=" . $_SESSION['passwordSession'], 'true,true,false', $strings['bug']);
        }

        $block1->closePaletteScript('', '');
    }
}

//--- Phases -----------------------------------------
if ($projectDetail->pro_phase_set[0] != '0') {
    $flag_phases = true;
    
    $block7 = new block();
    $block7->form = 'wbSe';
    $block7->openForm('../projects/viewproject.php?id=' . $id . '&amp;#' . $block7->form . 'Anchor');
    
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
        $block7->labels($labels = array(0 => $strings['order'], 1 => $strings['name'], 2 => $strings['total_tasks'], 3 => $strings['uncomplete_tasks'], 4 => $strings['milestone'], 5 => $strings['status'], 6 => $strings['date_start'], 7 => $strings['date_end']), 'false');

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
    $block7->paletteScript(0, 'info', '../phases/viewphase.php', 'false,true,true', $strings['view']);
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '5') {
            $block7->paletteScript(1, 'edit', '../phases/editphase.php', 'false,true,true', $strings['edit']);
        }
    }
    
    $block7->closePaletteScript($comptListPhases, $listPhases->pha_id);
}

//--- tasks open (ignore phases) ------------
{
    $block2 = new block();

    $block2->form = 'wbTuuO';
    $block2->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block2->form . 'Anchor');

    if (isset($flag_phases) && $flag_phases == true) {
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
    } else {
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
    }
    
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
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listTasks->tas_parent_phase[$i];
                $block2->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
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

//--- milestones open (ignore phases) ------------
{
    $block9 = new block();

    $block9->form = 'wbTuuM';
    $block9->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block9->form . 'Anchor');
    
    if (isset($flag_phases) && $flag_phases == true) {
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
    } else {
        $block9->sorting(
            'project_tasks',
            $sortingUser->sor_milestones[0],
            'tas.start_date ASC',
            $sortingFields = array(
                'tas.name',
                'tas.start_date'
            )
        );
    }
    
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

        if (isset($flag_phases) && $flag_phases == true) {
            $block9->labels(
                $labels = array(
                    $strings['name'],
                    $strings['date'],
                    $strings['phase']
                    ),
                'true');
        } else {
            $block9->labels(
                $labels = array(
                    $strings['name'],
                    $strings['date']
                ),
            'true');
        }

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
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listMilestones->tas_parent_phase[$i];
                $block9->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
            }

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
    $block10->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block10->form . 'Anchor');

    if (isset($flag_phases) && $flag_phases == true) {
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
    } else {
        $block10->sorting(
        'project_tasks',
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
    }
    
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

        if (isset($flag_phases) && $flag_phases == true) {
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
            ), 'true');
        } else {
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
            ), 'true');
        }
        
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
            if (isset($flag_phases) && $flag_phases == true) {
                $pha_id = $listTasks->tas_parent_phase[$i];
                $block10->cellRow('<a href="../phases/viewphase.php?id=' . $listPhases->pha_id[$pha_id] . '">' . $listPhases->pha_name[$pha_id] . '</a>');
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

//--- meetings ------------
{
    $block8 = new block();
    $block8->form = 'wbK';
    $block8->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block8->form . 'Anchor');

    $block8->borne = $blockPage->returnBorne('5');
    $block8->rowsLimit = '5';

    $block8->sorting('meetings', $sortingUser->sor_meetings[0], 'mee.date DESC', $sortingFields = array(0 => 'mee.id', 1 => 'mee.name', 2 => 'mee.priority', 3 => 'mee.status', 4 => 'mee.date'));

    $tmpquery = "WHERE mee.project = '$id' ORDER BY $block8->sortingValue";

    $block8->recordsTotal = compt($initrequest['meetings'] . ' ' . $tmpquery);

    $listMeetings = new request();

    $listMeetings->openMeetings($tmpquery, $block8->borne, $block8->rowsLimit);
    $comptListMeetings = count($listMeetings->mee_id);
    
    $block8->headingToggle($strings['meetings'] . ' <span class=addition>(' . $comptListMeetings . ')</span>');
    $block8->openPaletteIcon();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block8->paletteIcon(0, 'add', $strings['add']);
        $block8->paletteIcon(1, 'remove', $strings['delete']);
        $block8->paletteIcon(2, 'copy', $strings['copy']);
        // $block8->paletteIcon(3,'export',$strings['export']);

        if ($sitePublish == 'true') {
            $block8->paletteIcon(4, 'add_projectsite', $strings['add_project_site']);
            $block8->paletteIcon(5, 'remove_projectsite', $strings['remove_project_site']);
        }
    }

    $block8->paletteIcon(6, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block8->paletteIcon(7, 'edit', $strings['edit']);
        $block8->paletteIcon(8, 'timelog', $strings['loghours']);
    }

    $block8->closePaletteIcon();

    if ($comptListMeetings != '0') {
        $block8->openResults();
        $block8->labels($labels = array(0 => $strings['id'], 1 => $strings['meeting'], 2 => $strings['priority'], 3 => $strings['status'], 4 => $strings['date']), 'true');
        for ($i = 0; $i < $comptListMeetings; $i++) {
            $idStatus = $listMeetings->mee_status[$i];
            $idPriority = $listMeetings->mee_priority[$i];

            $block8->openRow($listMeetings->mee_id[$i]);
            $block8->checkboxRow($listMeetings->mee_id[$i]);

            if ($listMeetings->mee_reminder[$i] == '1') {
                $block8->cellRow("<img src=\"../themes/" . THEME . "/bell.gif\" alt=\"" . $listMeetings->mee_id[$i] . "\">&nbsp;" . buildLink("../meetings/viewmeeting.php?id=" . $listMeetings->mee_id[$i], $listMeetings->mee_id[$i], LINK_INSIDE));
            } else {
                $block8->cellRow(buildLink('../meetings/viewmeeting.php?id=' . $listMeetings->mee_id[$i], $listMeetings->mee_id[$i], LINK_INSIDE));
            }

            if ($idStatus == 1) {
                $block8->cellRow(buildLink('../meetings/viewmeeting.php?id=' . $listMeetings->mee_id[$i], $listMeetings->mee_name[$i], LINK_STRIKE));
            } else {
                $block8->cellRow(buildLink('../meetings/viewmeeting.php?id=' . $listMeetings->mee_id[$i], $listMeetings->mee_name[$i], LINK_INSIDE));
            }

            $block8->cellRow('<img src="../themes/' . THEME . '/gfx_priority/' . $idPriority . '.gif" alt="' . $priority[$idPriority] . '">&nbsp;' . $priority[$idPriority], '', true);
            $block8->cellRow('<img src="../themes/' . THEME . '/gfx_status/' . $idStatus . '.gif" alt="' . $status[$idStatus] . '">&nbsp;' . $status[$idStatus], '', true);

            if ($listMeetings->mee_date[$i] <= $date && $idStatus != 1) {
                $block8->cellRow("<b>" . $listMeetings->mee_date[$i] . "</b>");
            } else {
                $block8->cellRow($listMeetings->mee_date[$i]);
            }

            $block8->closeRow();
        }

        $block8->closeResults();

        $block8->bornesFooter('5', $blockPage->bornesNumber, '../meetings/listmeetings.php?project=' . $id, 'id=' . $id);
    } else {
        $block8->noresults();
    }
    $block8->closeToggle();
    $block8->closeFormResults();

    $block8->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block8->paletteScript(0, 'add', '../meetings/editmeeting.php?project=' . $projectDetail->pro_id[0], 'true,true,true', $strings['add']);
        $block8->paletteScript(1, 'remove', '../meetings/deletemeetings.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block8->paletteScript(2, 'copy', '../meetings/editmeeting.php?project=' . $projectDetail->pro_id[0] . "&cpy=true", 'false,true,false', $strings['copy']);
        if ($sitePublish == 'true') {
            $block8->paletteScript(4, 'add_projectsite', '../projects/viewproject.php?addToSiteNote=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block8->paletteScript(5, 'remove_projectsite', '../projects/viewproject.php?removeToSiteNote=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }

    $block8->paletteScript(6, 'info', '../meetings/viewmeeting.php', 'false,true,false', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block8->paletteScript(7, 'edit', '../meetings/editmeeting.php?project=' . $projectDetail->pro_id[0], 'false,true,false', $strings['edit']);
        $block8->paletteScript(8, 'timelog', '../meetings/addmeetingtime.php?project=' . $projectDetail->pro_id[0], 'false,true,false', $strings['loghours']);
    }
    $block8->closePaletteScript($comptListMeetings, $listMeetings->mee_id);
}

//--- discussions open ------------
{
    $block3 = new block();

    $block3->form = 'pdH';
    $block3->openForm('../projects/viewproject.php?id=' . $id . '#' . $block3->form . 'Anchor');

    $block3->sorting(
        'project_discussions', 
        $sortingUser->sor_project_discussions[0], 
        'topic.last_post DESC', 
        $sortingFields = array(
            'topic.subject', 
            'mem.login', 
            'topic.posts', 
            'topic.last_post', 
            'topic.status', 
            'topic.published'
        )
    );

    $block3->borne = $blockPage->returnBorne('2');
    $block3->rowsLimit = '5';

    $tmpquery = "WHERE topic.project = '$id' ORDER BY $block3->sortingValue";

    $block3->recordsTotal = compt($initrequest['topics'] . ' ' . $tmpquery);

    $listTopics = new request();
    $listTopics->openTopics($tmpquery, $block3->borne, $block3->rowsLimit);
    $comptListTopics = count($listTopics->top_id);
    
    $block3->headingToggle($strings['discussions'] . ' <span class=addition>(' . $comptListTopics . ')</span>');
    $block3->openPaletteIcon();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteIcon(0, 'add', $strings['add']);
    }
    
    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block3->paletteIcon(1, 'remove', $strings['delete']);
        $block3->paletteIcon(2, 'lock', $strings['close']);
        
        if ($sitePublish == 'true') {
            $block3->paletteIcon(3, 'add_projectsite', $strings['add_project_site']);
            $block3->paletteIcon(4, 'remove_projectsite', $strings['remove_project_site']);
        }
    }
    
    $block3->paletteIcon(5, 'info', $strings['view']);
    $block3->closePaletteIcon();

    if ($comptListTopics != '0') {
        $block3->openResults();

        $block3->labels($labels = array(0 => $strings['topic'], 1 => $strings['owner'], 2 => $strings['posts'], 3 => $strings['last_post'], 4 => $strings['status'], 5 => $strings['published']), 'true');

        for ($i = 0;$i < $comptListTopics;$i++) {
            $idStatus = $listTopics->top_status[$i];
            $idPublish = $listTopics->top_published[$i];
            $block3->openRow($listTopics->top_id[$i]);
            $block3->checkboxRow($listTopics->top_id[$i]);
            $block3->cellRow(buildLink('../topics/viewtopic.php?id=' . $listTopics->top_id[$i], $listTopics->top_subject[$i], LINK_INSIDE));
            $block3->cellRow(buildLink($listTopics->top_mem_email_work[$i], $listTopics->top_mem_login[$i], LINK_MAIL));
            $block3->cellRow($listTopics->top_posts[$i]);
            
            if ($listTopics->top_last_post[$i] > $_SESSION['lastvisiteSession']) {
                $block3->cellRow('<b>' . createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']) . '</b>');
            } else {
                $block3->cellRow(createDate($listTopics->top_last_post[$i], $_SESSION['timezoneSession']));
            }
            
            $block3->cellRow($statusTopic[$idStatus]);
            
            if ($sitePublish == 'true') {
                $block3->cellRow($statusPublish[$idPublish]);
            }
            
            $block3->closeRow();
        }
        
        $block3->closeResults();
        $block3->bornesFooter('2', $blockPage->bornesNumber, '../topics/listtopics.php?project=' . $id, 'id=' . $id);
    } else {
        $block3->noresults();
    }

    $block3->closeToggle();
    $block3->closeFormResults();

    $block3->openPaletteScript();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block3->paletteScript(0, 'add', '../topics/addtopic.php?project=' . $projectDetail->pro_id[0], 'true,false,false', $strings['add']);
    }
    
    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block3->paletteScript(1, 'remove', '../topics/deletetopics.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        $block3->paletteScript(2, 'lock', '../projects/viewproject.php?closeTopic=true&project=' . $id . '&action=publish', 'false,true,true', $strings['close']);
        if ($sitePublish == 'true') {
            $block3->paletteScript(3, 'add_projectsite', '../projects/viewproject.php?addToSiteTopic=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block3->paletteScript(4, 'remove_projectsite', '../projects/viewproject.php?removeToSiteTopic=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }
    
    $block3->paletteScript(5, 'info', '../topics/viewtopic.php', 'false,true,false', $strings['view']);
    $block3->closePaletteScript($comptListTopics, $listTopics->top_id);
}

//--- team members ------------
{
    $block4 = new block();

    $block4->form = 'pdM';
    $block4->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block4->form . 'Anchor');

    $block4->borne = $blockPage->returnBorne('3');
    $block4->rowsLimit = '5';

    $block4->sorting(
        'team', 
        $sortingUser->sor_team[0], 
        'mem.name ASC', 
        $sortingFields = array(
            'mem.name', 
            'mem.title', 
            'mem.login', 
            'mem.phone_work', 
            'log.connected', 
            'tea.published'
        )
    );

    $tmpquery = "WHERE tea.project = '$id' AND mem.profil != '3' ORDER BY $block4->sortingValue";

    $block4->recordsTotal = compt($initrequest['teams'] . ' ' . $tmpquery);

    $listTeam = new request();
    $listTeam->openTeams($tmpquery, $block4->borne, $block4->rowsLimit);
    $comptListTeam = count($listTeam->tea_id);
    
    $block4->headingToggle($strings['team'] . ' <span class=addition>(' . $comptListTeam . ')</span>');
    $block4->openPaletteIcon();
    
    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block4->paletteIcon(0, 'add', $strings['add']);
        $block4->paletteIcon(1, 'remove', $strings['delete']);
        if ($sitePublish == 'true') {
            $block4->paletteIcon(2, 'add_projectsite', $strings['add_project_site']);
            $block4->paletteIcon(3, 'remove_projectsite', $strings['remove_project_site']);
        }
    }
    
    $block4->paletteIcon(4, 'info', $strings['view']);
    // $block4->paletteIcon(5,'email',$strings['email']);
    $block4->closePaletteIcon();

    $block4->openResults();
    $block4->labels($labels = array(0 => $strings['full_name'], 1 => $strings['title'], 2 => $strings['user_name'], 3 => $strings['work_phone'], 4 => $strings['connected'], 5 => $strings['published']), 'true');

    for ($i = 0; $i < $comptListTeam; $i++) {
        if ($listTeam->tea_mem_phone_work[$i] == '') {
            $listTeam->tea_mem_phone_work[$i] = $strings['none'];
        }
        if ($listTeam->tea_mem_title[$i] == '') {
            $listTeam->tea_mem_title[$i] = $strings['none'];
        }
        $idPublish = $listTeam->tea_published[$i];
        $block4->openRow($listTeam->tea_mem_id[$i]);
        $block4->checkboxRow($listTeam->tea_mem_id[$i]);
        $block4->cellRow(buildLink('../users/viewuser.php?id=' . $listTeam->tea_mem_id[$i], $listTeam->tea_mem_name[$i], LINK_INSIDE));
        $block4->cellRow($listTeam->tea_mem_title[$i]);
        $block4->cellRow(buildLink($listTeam->tea_mem_email_work[$i], $listTeam->tea_mem_login[$i], LINK_MAIL));
        $block4->cellRow($listTeam->tea_mem_phone_work[$i]);

        if ($listTeam->tea_log_connected[$i] > $dateunix-5 * 60) {
            $block4->cellRow($strings['yes'] . ' ' . $z);
        } else {
            $block4->cellRow($strings['no']);
        }
        if ($sitePublish == 'true') {
            $block4->cellRow($statusPublish[$idPublish]);
        }
        $block4->closeRow();
    }
    $block4->closeResults();

    $block4->bornesFooter('3', $blockPage->bornesNumber, '../teams/listusers.php?id=' . $id, 'id=' . $id);

    $block4->closeToggle();
    $block4->closeFormResults();

    $block4->openPaletteScript();
    if ($_SESSION['idSession'] == $projectDetail->pro_owner[0] || $_SESSION['profilSession'] == '5') {
        $block4->paletteScript(0, 'add', '../teams/adduser.php?project=' . $projectDetail->pro_id[0], 'true,true,true', $strings['add']);
        $block4->paletteScript(1, 'remove', '../teams/deleteusers.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);

        if ($sitePublish == 'true') {
            $block4->paletteScript(2, 'add_projectsite', '../projects/viewproject.php?addToSiteTeam=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block4->paletteScript(3, 'remove_projectsite', '../projects/viewproject.php?removeToSiteTeam=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }
    $block4->paletteScript(4, 'info', '../users/viewuser.php?', 'false,true,false', $strings['view']);
    // $block4->paletteScript(5,'email','../users/emailusers.php','false,true,true',$strings['email']);
    $block4->closePaletteScript($comptListTeam, $listTeam->tea_mem_id);
}

//--- linked content ------------
{
    if ($fileManagement == 'true') {
        $block5 = new block();

        $block5->form = 'tdC';
        $block5->openForm('../projects/viewproject.php?id=' . $id . '#' . $block5->form . 'Anchor');

        $block5->sorting(
            'files', 
            $sortingUser->sor_files[0], 
            'fil.name ASC', 
            $sortingFields = array(
                'fil.extension', 
                'fil.name', 
                'fil.date', 
                'fil.status', 
                'fil.published'
            )
        );

        $tmpquery = "WHERE fil.project = '$id' AND fil.task = '0' AND fil.vc_parent = '0' AND fil.phase = '0' ORDER BY $block5->sortingValue";
        
        $listFiles = new request();
        $listFiles->openFiles($tmpquery);
        $comptListFiles = count($listFiles->fil_id);

        $block5->headingToggle($strings['linked_content'] . ' <span class=addition>(' . $comptListFiles . ')</span>');
        $block5->openPaletteIcon();
        
        if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
            $block5->paletteIcon(0, 'add', $strings['add']);
            $block5->paletteIcon(1, 'remove', $strings['delete']);
            
            if ($sitePublish == 'true') {
                $block5->paletteIcon(2, 'add_projectsite', $strings['add_project_site']);
                $block5->paletteIcon(3, 'remove_projectsite', $strings['remove_project_site']);
            }
        }
        
        $block5->paletteIcon(4, 'info', $strings['view']);
        
        if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
            $block5->paletteIcon(5, 'edit', $strings['edit']);
        }
        
        $block5->closePaletteIcon();

        if ($comptListFiles != '0') {
            $block5->openResults();

            $block5->labels($labels = array(0 => $strings['type'], 1 => $strings['name'], 2 => $strings['date'], 3 => $strings['approval_tracking'], 4 => $strings['published']), 'true');

            include_once('../includes/files_types.php');

            for ($i = 0; $i < $comptListFiles; $i++) {
                $existFile = 'false';
                $idStatus = $listFiles->fil_status[$i];

                $idPublish = $listFiles->fil_published[$i];
                $type = file_info_type($listFiles->fil_extension[$i]);
                if (file_exists('../files/' . $listFiles->fil_project[$i] . '/' . $listFiles->fil_name[$i])) {
                    $existFile = 'true';
                }
                $block5->openRow($listFiles->fil_id[$i]);
                $block5->checkboxRow($listFiles->fil_id[$i]);

                if ($existFile == 'true') {
                    $block5->cellRow(buildLink('../linkedcontent/viewfile.php?id=' . $listFiles->fil_id[$i], $type, LINK_ICON));
                } else {
                    $block5->cellRow('&nbsp;');
                }

                if ($existFile == 'true') {
                    $block5->cellRow(buildLink('../linkedcontent/viewfile.php?id=' . $listFiles->fil_id[$i], $listFiles->fil_name[$i], LINK_INSIDE));
                } else {
                    $block5->cellRow($strings['missing_file'] . ' (' . $listFiles->fil_name[$i] . ')');
                }
                $block5->cellRow($listFiles->fil_date[$i]);
                $block5->cellRow(buildLink('../linkedcontent/viewfile.php?id=' . $listFiles->fil_id[$i], $statusFile[$idStatus], LINK_INSIDE));
                if ($sitePublish == 'true') {
                    $block5->cellRow($statusPublish[$idPublish]);
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
        if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
            $block5->paletteScript(0, 'add', '../linkedcontent/addfile.php?project=' . $id, 'true,true,true', $strings['add']);
            $block5->paletteScript(1, 'remove', '../linkedcontent/deletefiles.php?project=' . $id, 'false,true,true', $strings['delete']);
            if ($sitePublish == 'true') {
                $block5->paletteScript(2, 'add_projectsite', '../projects/viewproject.php?addToSiteFile=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
                $block5->paletteScript(3, 'remove_projectsite', '../projects/viewproject.php?removeToSiteFile=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
            }
        }
        $block5->paletteScript(4, 'info', '../linkedcontent/viewfile.php', 'false,true,false', $strings['view']);
        if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
            $block5->paletteScript(5, 'edit', '../linkedcontent/viewfile.php?edit=true', 'false,true,false', $strings['edit']);
        }
        $block5->closePaletteScript($comptListFiles, $listFiles->fil_id);
    }
}

//--- notes ------------
{
    $block6 = new block();
    $block6->form = 'wbJ';
    $block6->openForm('../projects/viewproject.php?id=' . $projectDetail->pro_id[0] . '#' . $block6->form . 'Anchor');

    $block6->borne = $blockPage->returnBorne('4');
    $block6->rowsLimit = '5';

    $comptTopic = count($topicNote);

    if ($comptTopic != '0') {
        $block6->sorting('notes', $sortingUser->sor_notes[0], 'note.date DESC', $sortingFields = array(0 => 'note.subject', 1 => 'note.topic', 2 => 'note.date', 3 => 'mem.login', 4 => 'note.published'));
    } else {
        $block6->sorting('notes', $sortingUser->sor_notes[0], 'note.date DESC', $sortingFields = array(0 => 'note.subject', 1 => 'note.date', 2 => 'mem.login', 3 => 'note.published'));
    }

    $tmpquery = "WHERE note.project = '$id' ORDER BY $block6->sortingValue";

    $block6->recordsTotal = compt($initrequest['notes'] . ' ' . $tmpquery);

    $listNotes = new request();

    $listNotes->openNotes($tmpquery, $block6->borne, $block6->rowsLimit);
    $comptListNotes = count($listNotes->note_id);
    
    $block6->headingToggle($strings['notes'] . ' <span class=addition>(' . $comptListNotes . ')</span>');
    $block6->openPaletteIcon();
    
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block6->paletteIcon(0, 'add', $strings['add']);
        $block6->paletteIcon(1, 'remove', $strings['delete']);
        // $block6->paletteIcon(2,'export',$strings['export']);
        if ($sitePublish == 'true') {
            $block6->paletteIcon(3, 'add_projectsite', $strings['add_project_site']);
            $block6->paletteIcon(4, 'remove_projectsite', $strings['remove_project_site']);
        }
    }

    $block6->paletteIcon(5, 'info', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block6->paletteIcon(6, 'edit', $strings['edit']);
    }

    $block6->closePaletteIcon();

    if ($comptListNotes != '0') {
        $block6->openResults();
        if ($comptTopic != '0') {
            $block6->labels($labels = array(0 => $strings['subject'], 1 => $strings['topic'], 2 => $strings['date'], 3 => $strings['owner'], 4 => $strings['published']), 'true');
        } else {
            $block6->labels($labels = array(0 => $strings['subject'], 1 => $strings['date'], 2 => $strings['owner'], 3 => $strings['published']), 'true');
        }
        for ($i = 0; $i < $comptListNotes; $i++) {
            $idPublish = $listNotes->note_published[$i];
            $block6->openRow($listNotes->note_id[$i]);
            $block6->checkboxRow($listNotes->note_id[$i]);
            $block6->cellRow(buildLink('../notes/viewnote.php?id=' . $listNotes->note_id[$i], $listNotes->note_subject[$i], LINK_INSIDE));
            if ($comptTopic != '0') {
                $block6->cellRow($topicNote[$listNotes->note_topic[$i]]);
            }
            $block6->cellRow($listNotes->note_date[$i]);
            $block6->cellRow(buildLink($listNotes->note_mem_email_work[$i], $listNotes->note_mem_login[$i], LINK_MAIL));
            if ($sitePublish == 'true') {
                $block6->cellRow($statusPublish[$idPublish]);
            } else {
                $block6->cellRow('&nbsp;');
            }
            $block6->closeRow();
        }

        $block6->closeResults();

        $block6->bornesFooter('4', $blockPage->bornesNumber, '../notes/listnotes.php?project=' . $id, 'id=' . $id);
    } else {
        $block6->noresults();
    }
    $block6->closeToggle();
    $block6->closeFormResults();

    $block6->openPaletteScript();
    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block6->paletteScript(0, 'add', '../notes/editnote.php?project=' . $projectDetail->pro_id[0], 'true,true,true', $strings['add']);
        $block6->paletteScript(1, 'remove', '../notes/deletenotes.php?project=' . $projectDetail->pro_id[0], 'false,true,true', $strings['delete']);
        // $block6->paletteScript(2,'export','../projects/exportproject.php','false,true,true',$strings['export']);
        if ($sitePublish == 'true') {
            $block6->paletteScript(3, 'add_projectsite', '../projects/viewproject.php?addToSiteNote=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['add_project_site']);
            $block6->paletteScript(4, 'remove_projectsite', '../projects/viewproject.php?removeToSiteNote=true&project=' . $projectDetail->pro_id[0] . '&action=publish', 'false,true,true', $strings['remove_project_site']);
        }
    }

    $block6->paletteScript(5, 'info', '../notes/viewnote.php', 'false,true,false', $strings['view']);

    if ($teamMember == 'true' || $_SESSION['profilSession'] == '5') {
        $block6->paletteScript(6, 'edit', '../notes/editnote.php?project=' . $projectDetail->pro_id[0], 'false,true,false', $strings['edit']);
    }
    $block6->closePaletteScript($comptListNotes, $listNotes->note_id);
}

require_once('../themes/' . THEME . '/footer.php');

?>
