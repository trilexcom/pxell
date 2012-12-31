<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editproject.php,v 1.8 2004/12/15 19:43:35 madbear Exp $
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

#$id = $_REQUEST['id'];
#$msg = $_REQUEST['msg'];
#$cpy = $_REQUEST['cpy'];
#$action = $_REQUEST['action'];
#$project = $_REQUEST['project'];

$pn = $_POST['pn'];
$pr = $_POST['pr'];
$d = $_POST['d'];
$url_dev = $_POST['url_dev'];
$url_prod = $_POST['url_prod'];
$pown = $_POST['pown'];
$clod = $_POST['clod'];
$thisPhase = $_POST['thisPhase'];
$st = $_POST['st'];
$pt = $_POST['pt'];
$up = $_POST['up'];

if ($htaccessAuth == 'true') {
    require_once('../includes/htpasswd.class.php');
    $Htpasswd = new Htpasswd;
}

if ($enable_cvs == 'true') {
    require_once('../includes/cvslib.php');
}

// case update or copy project
if ($id != '') {
    if ($_SESSION['profilSession'] != '0' && $_SESSION['profilSession'] != '1' && $_SESSION['profilSession'] != '5') {
        header('Location: ../projects/viewproject.php?id=' . $id);
        exit;
    }

    // test exists selected project, redirect to list if not
    $tmpquery = "WHERE pro.id = '$id'";
    $projectDetail = new request();
    $projectDetail->openProjects($tmpquery);
    $comptProjectDetail = count($projectDetail->pro_id);

    if ($comptProjectDetail == '0') {
        header('Location: ../projects/listprojects.php?msg=blankProject');
        exit;
    }

    if ($_SESSION['idSession'] != $projectDetail->pro_owner[0] && $_SESSION['profilSession'] != '0' && $_SESSION['profilSession'] != '5') {
        header('Location: ../projects/listprojects.php?msg=projectOwner');
        exit;
    }

    // case update or copy project
    if ($action == 'update') {
        // replace quotes by html code in name and description
        $pn = convertData($_POST['pn']);
        $d = convertData($d);
        // case copy project
        if ($cpy == 'true') {
            // insert into projects and teams (with last id project)
            $tmpquery1 = 'INSERT INTO ' . $tableCollab['projects'] . "(name,priority,description,owner,organization,status,created,published,upload_max,url_dev,url_prod,phase_set,type) VALUES('$pn','$pr','$d','$pown','$clod','$st','$dateheure','$projectPublished','$up','$url_dev','$url_prod','$thisPhase','$pt')";
            connectSql($tmpquery1);
            $tmpquery = $tableCollab['projects'];
            last_id($tmpquery);
            $projectNew = $lastId[0];
            unset($lastId);

            $tmpquery2 = 'INSERT INTO ' . $tableCollab['teams'] . "(project,member,published,authorized) VALUES('$projectNew','$pown','1','0')";
            connectSql($tmpquery2);
            // create project folder if filemanagement = true
            if ($fileManagement == 'true') {
                createDir('files/' . $projectNew);
            }

            if ($htaccessAuth == 'true') {
                $content = <<<STAMP
AuthName "$setTitle"
AuthType Basic
Require valid-user
AuthUserFile $fullPath/files/$projectNew/.htpasswd
STAMP;
                $fp = @fopen('../files/' . $projectNew . '/.htaccess', 'wb+');
                $fw = fwrite($fp, $content);
                $fp = @fopen('../files/' . $projectNew . '/.htpasswd', 'wb+');

                $tmpquery = "WHERE mem.id = '$pown'";
                $detailMember = new request();
                $detailMember->openMembers($tmpquery);

                $Htpasswd = new Htpasswd;
                $Htpasswd->initialize('../files/' . $projectNew . '/.htpasswd');
                $Htpasswd->addUser($detailMember->mem_login[0], $detailMember->mem_password[0]);
            }

            $tmpquery = "WHERE tas.project = '$id'";
            $listTasks = new request();
            $listTasks->openTasks($tmpquery);
            $comptListTasks = count($listTasks->tas_id);

            for ($i = 0; $i < $comptListTasks; $i++) {
                $assigned = '';
                $at = '';
                $tn = convertData($listTasks->tas_name[$i]);
                $d = convertData($listTasks->tas_description[$i]);
                $ow = $listTasks->tas_owner[$i];
                $at = $listTasks->tas_assigned_to[$i];
                $st = $listTasks->tas_status[$i];
                $pr = $listTasks->tas_priority[$i];
                $sd = $listTasks->tas_start_date[$i];
                $dd = $listTasks->tas_due_date[$i];
                $cd = $listTasks->tas_complete_date[$i];
                $etm = $listTasks->tas_estimated_time[$i];
                $atm = $listTasks->tas_actual_time[$i];
                $c = convertData($listTasks->tas_comments[$i]);
                $pha = $listTasks->tas_parent_phase[$i];
                $published = $listTasks->tas_published[$i];
                $compl = $listTasks->tas_completion[$i];
                if ($at != '0') {
                    $assigned = $dateheure;
                }
                $tmpquery1 = 'INSERT INTO ' . $tableCollab['tasks'] . "(project,name,description,owner,assigned_to,status,priority,start_date,due_date,complete_date,estimated_time,actual_time,comments,created,assigned,published,completion,parent_phase) VALUES('$projectNew','$tn','$d','$ow','$at','$st','$pr','$sd','$dd','$cd','$etm','$atm','$c','$dateheure','$assigned','$published','$compl','$pha')";
                connectSql($tmpquery1);
                $tmpquery = $tableCollab['tasks'];
                last_id($tmpquery);
                $num = $lastId[0];
                unset($lastId);

                $tmpquery2 = 'INSERT INTO ' . $tableCollab['assignments'] . "(task,owner,assigned_to,assigned) VALUES('$num','$ow','$at','$dateheure')";
                connectSql($tmpquery2);

                if ($at != '0') {
                    $tmpquery = "WHERE tea.project = '$projectNew' AND tea.member = '$at'";
                    $testinTeam = new request();
                    $testinTeam->openTeams($tmpquery);
                    $comptTestinTeam = count($testinTeam->tea_id);
                    if ($comptTestinTeam == '0') {
                        $tmpquery3 = 'INSERT INTO ' . $tableCollab['teams'] . "(project,member,published,authorized) VALUES('$projectNew','$at','1','0')";
                        connectSql($tmpquery3);
                        if ($htaccessAuth == 'true') {
                            $tmpquery = "WHERE mem.id = '$at'";
                            $detailMember = new request();
                            $detailMember->openMembers($tmpquery);

                            $Htpasswd->initialize('../files/' . $projectNew . '/.htpasswd');
                            $Htpasswd->addUser($detailMember->mem_login[0], $detailMember->mem_password[0]);
                        }
                    }
                }
                // create task sub-folder if filemanagement = true
                if ($fileManagement == 'true') {
                    createDir('files/' .$projectNew . '/' .$num);
                }
            }
            // if mantis bug tracker enabled
            if ($enableMantis == 'true') {
                // call mantis function to copy project
                require_once('../mantis/proj_add.php');
            }
            // if CVS repository enabled
            if ($enable_cvs == 'true') {
                $user_query = "WHERE mem.id = '$pown'";
                $cvsUser = new request();
                $cvsUser->openMembers($user_query);
                cvs_add_repository($cvsUser->mem_login[0], $cvsUser->mem_password[0], $projectNew);
            }
            // create phase structure if enable phase was selected as true
            if ($thisPhase != '0') {
                $comptThisPhase = count($phaseArraySets[$thisPhase]);

                for($i = 0; $i < $comptThisPhase; $i++) {
                    $tmpquery = 'INSERT INTO ' . $tableCollab['phases'] . "(project_id,order_num,status,name) VALUES('$projectNew','$i','0','" . $phaseArraySets[$thisPhase][$i] . "')";
                    connectSql($tmpquery);
                }
            }

            header('Location: ../projects/viewproject.php?id=' . $projectNew . '&msg=add');
            exit;
        } else {
            // if project owner change, add new to team members (only if doesn't already exist)
            if ($pown != $projectDetail->pro_owner[0]) {
                $tmpquery = "WHERE tea.project = '$id' AND tea.member = '$pown'";
                $testinTeam = new request();
                $testinTeam->openTeams($tmpquery);
                $comptTestinTeam = count($testinTeam->tea_id);
                if ($comptTestinTeam == '0') {
                    $tmpquery2 = 'INSERT INTO ' . $tableCollab['teams'] . "(project,member,published,authorized) VALUES('$id','$pown','1','0')";
                    connectSql($tmpquery2);

                    if ($htaccessAuth == 'true') {
                        $tmpquery = "WHERE mem.id = '$pown'";
                        $detailMember = new request();
                        $detailMember->openMembers($tmpquery);

                        $Htpasswd->initialize('../files/' . $id . '/.htpasswd');
                        $Htpasswd->addUser($detailMember->mem_login[0], $detailMember->mem_password[0]);
                    }
                }
            }
            // if organization change, delete old organization permitted users from teams
            if ($clod != $projectDetail->pro_organization[0]) {
                $tmpquery = "WHERE tea.project = '$id' AND mem.profil = '3'";
                $suppTeamClient = new request();
                $suppTeamClient->openTeams($tmpquery);
                $comptSuppTeamClient = count($suppTeamClient->tea_id);
                if ($comptSuppTeamClient == '0') {
                    for ($i = 0; $i < $comptSuppTeamClient; $i++) {
                        $membersTeam .= $suppTeamClient->tea_mem_id[$i];
                        if ($i < $comptSuppTeamClient-1) {
                            $membersTeam .= ',';
                        }
                        if ($htaccessAuth == 'true') {
                            $Htpasswd->initialize('../files/' . $id . '/.htpasswd');
                            $Htpasswd->deleteUser($suppTeamClient->mem_login[$i]);
                        }
                    }
                    $tmpquery4 = 'DELETE FROM ' . $tableCollab['teams'] . " WHERE project = '$id' AND member IN($membersTeam)";
                    connectSql($tmpquery4);
                }
            }
            // -------------------------------------------------------------------------------------------------
            $tmpquery = "WHERE pro.id = '$id'";
            $targetProject = new request();
            $targetProject->openProjects($tmpquery);
            // Delete old or unused phases
            if ($targetProject->pro_phase_set[0] != $thisPhase) {
                $tmpquery = 'DELETE FROM ' . $tableCollab['phases'] . " WHERE project_id = $id";
                connectSql($tmpquery);
            }
            // Create new Phases
            if ($targetProject->pro_phase_set[0] != $thisPhase) {
                $comptThisPhase = count($phaseArraySets[$thisPhase]);

                for($i = 0; $i < $comptThisPhase; $i++) {
                    $tmpquery = 'INSERT INTO ' . $tableCollab['phases'] . "(project_id,order_num,status,name) VALUES('$id','$i','0','" . $phaseArraySets[$thisPhase][$i] . "')";
                    connectSql($tmpquery);
                }
                // Get a listing of project tasks and files and re-assign them to new phases if the phase set of a project is changed.
                $tmpquery = "WHERE tas.project = '" . $targetProject->pro_id[0] . "'";
                $listTasks = new request();
                $listTasks->openTasks($tmpquery);
                $comptListTasks = count($listTasks->tas_id);

                $tmpquery = "WHERE fil.project = '" . $targetProject->pro_id[0] . "' AND fil.phase !='0'";
                $listFiles = new request();
                $listFiles->openFiles($tmpquery);
                $comptListFiles = count($listFiles->fil_id);

                $tmpquery = "WHERE pha.project_id = '" . $targetProject->pro_id[0] . "' AND pha.order_num ='0'";
                $targetPhase = new request();
                $targetPhase->openPhases($tmpquery);
                $comptTargetPhase = count($targetPhase->pha_id);

                for($i = 0; $i < $comptListTasks; $i++) {
                    $tmpquery = 'UPDATE ' . $tableCollab['tasks'] . " SET parent_phase='0' WHERE id = '" . $listTasks->tas_id[$i] . "'";
                    connectSql("$tmpquery");
                    $tmpquery = 'UPDATE ' . $tableCollab['files'] . " SET phase='" . $targetPhase->pha_id[0] . "' WHERE id = '" . $listFiles->fil_id[$i] . "'";
                    connectSql($tmpquery);
                }
            }
            // update project
            $tmpquery = 'UPDATE ' . $tableCollab['projects'] . " SET name='$pn',priority='$pr',description='$d',url_dev='$url_dev',url_prod='$url_prod',owner='$pown',organization='$clod',status='$st',modified='$dateheure',upload_max='$up',phase_set='$thisPhase', type='$pt' WHERE id = '$id'";
            connectSql($tmpquery);
            // if mantis bug tracker enabled
            if ($enableMantis == 'true') {
                // call mantis function to copy project
                require_once('../mantis/proj_update.php');
            }
            header('Location: ../projects/viewproject.php?id=' . $id . '&msg=update');
            exit;
        }
    }
    // set value in form
    $pn = $projectDetail->pro_name[0];
    $d = $projectDetail->pro_description[0];
    $url_dev = $projectDetail->pro_url_dev[0];
    $url_prod = $projectDetail->pro_url_prod[0];
}
// case add project
if ($id == '') {
    if ($_SESSION['profilSession'] != '0' && $_SESSION['profilSession'] != '1' && $_SESSION['profilSession'] != '5') {
        header('Location: ../projects/listprojects.php');
        exit;
    }
    // set organization if add project action done from clientdetail
    if ($organization != '') {
        $projectDetail->pro_org_id[0] = $organization;
    }
    // set default values
    $projectDetail->pro_mem_id[0] = $_SESSION['idSession'];
    $projectDetail->pro_priority[0] = 3;

    $projectDetail->pro_status[0] = 2;
    $projectDetail->pro_upload_max[0] = $maxFileSize;
    // case add project
    if ($action == 'add') {

        // replace quotes by html code in name and description
        $pn = convertData($pn);
        $d = convertData($d);

        // insert into projects and teams (with last id project)
        $tmpquery1 = 'INSERT INTO ' . $tableCollab['projects'] . "(name,priority,description,owner,organization,status,created,published,upload_max,url_dev,url_prod,phase_set,type) VALUES('$pn','$pr','$d','$pown','$clod','$st','$dateheure','1','$up','$url_dev','$url_prod','$thisPhase','$pt')";

        connectSql($tmpquery1);

        $tmpquery = $tableCollab['projects'];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);

        $tmpquery2 = 'INSERT INTO ' . $tableCollab['teams'] . "(project,member,published,authorized) VALUES('$num','$pown','1','0')";
        connectSql($tmpquery2);

        // if CVS repository enabled
        if ($enable_cvs == 'true') {
            $user_query = "WHERE mem.id = '$pown'";
            $cvsUser = new request();
            $cvsUser->openMembers($user_query);
            cvs_add_repository($cvsUser->mem_login[0], $cvsUser->mem_password[0], $num);
        }

        // create project folder if filemanagement = true
        if ($fileManagement == 'true') {
            createDir('files/' . $num);
        }

        if ($htaccessAuth == 'true') {
            $content = <<<STAMP
AuthName "$setTitle"
AuthType Basic
Require valid-user
AuthUserFile $fullPath/files/$num/.htpasswd
STAMP;
            $fp = @fopen('../files/' . $num . '/.htaccess', 'wb+');
            $fw = fwrite($fp, $content);
            $fp = @fopen('../files/' .$num . '/.htpasswd', 'wb+');

            $tmpquery = "WHERE mem.id = '$pown'";
            $detailMember = new request();
            $detailMember->openMembers($tmpquery);

            $Htpasswd = new Htpasswd;
            $Htpasswd->initialize('../files/' . $num . '/.htpasswd');
            $Htpasswd->addUser($detailMember->mem_login[0], $detailMember->mem_password[0]);
        }
        // if mantis bug tracker enabled
        if ($enableMantis == 'true') {
            // call mantis function to copy project
            require_once('../mantis/proj_add.php');
        }
        // create phase structure if enable phase was selected as true
        if ($thisPhase != '0') {
            $comptThisPhase = count($phaseArraySets[$thisPhase]);

            for($i = 0; $i < $comptThisPhase; $i++) {
                $tmpquery = 'INSERT INTO ' . $tableCollab['phases'] . "(project_id,order_num,status,name) VALUES('$num','$i','0','" . $phaseArraySets[$thisPhase][$i] . "')";
                connectSql($tmpquery);
            }
        }

        header('Location: ../projects/viewproject.php?id=' . $num . '&msg=add');
        exit;
    }
}


//--- header ---------
$breadcrumbs[]=buildLink('../projects/listprojects.php', $strings['projects'], LINK_INSIDE);
// case add project
if ($id == '') {
    $breadcrumbs[]=$strings['add_project'];
}
// case update or copy project
if ($id != '') {
    $breadcrumbs[]=buildLink('../projects/viewproject.php?id=' . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
    if ($cpy == 'true') {
        $breadcrumbs[]=$strings['copy_project'];
    } else {
        $breadcrumbs[]=$strings['edit_project'];
    }
}

$bodyCommand = 'onLoad="document.epDForm.pn.focus();"';
$pageSection='projects';

require_once('../themes/' . THEME . '/header.php');

//--- content ---------
$block1 = new block();
// case add project
if ($id == '') {
    $block1->form = 'epD';
    $block1->openForm('../projects/editproject.php?action=add&amp;#' . $block1->form . 'Anchor');
}
// case update or copy project
if ($id != '') {
    $block1->form = 'epD';
    $block1->openForm('../projects/editproject.php?id=' . $id . '&amp;action=update&amp;cpy=' . $cpy . '&amp;#' . $block1->form . 'Anchor');
    echo '<input type="hidden" value="' . $projectDetail->pro_published[0] . '" name="projectPublished">';
}

if ($error != '') {
    $block1->headingError($strings['errors']);
    $block1->contentError($error);
}
// case add project
if ($id == '') {
    $block1->headingForm($strings['add_project']);
}
// case update or copy project
else {
    if ($cpy == 'true') {
        $block1->headingForm($strings['copy_project'] . ' : ' . $projectDetail->pro_name[0]);
    } 
	else {
        $block1->headingForm($strings['edit_project'] . ' : ' . $projectDetail->pro_name[0]);
    }
}

$block1->openContent();
$block1->contentTitle($strings['details']);

echo '<tr class="odd"><td valign="top" class="leftvalue">' . $strings['name'] . ' :</td><td><input size="44" value="';
// case copy project
if ($cpy == 'true') {
    echo $strings['copy_of'];
}

echo "$pn\" style=\"width: 400px\" name=\"pn\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['priority'] . ' :</td><td><select name="pr">';

$comptPri = count($priority);

for ($i = 0; $i < $comptPri; $i++) {
    if ($projectDetail->pro_priority[0] == $i) {
        echo '<option value="' . $i . '" selected>' . $priority[$i] . '</option>';
    } else {
        echo '<option value="' . $i . '">' .$priority[$i] . '</option>';
    }
}

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['description'] . " :</td><td><textarea rows=\"10\" style=\"width: 400px; height: 160px;\" name=\"d\" cols=\"47\">$d</textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['url_dev'] . " :</td><td><input size=\"44\" value=\"$url_dev\" style=\"width: 400px\" name=\"url_dev\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['url_prod'] . " :</td><td><input size=\"44\" value=\"$url_prod\" style=\"width: 400px\" name=\"url_prod\" maxlength=\"100\" type=\"text\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings['owner'] . " :</td><td><select name=\"pown\">";

if ($demoMode == true) {
    $tmpquery = "WHERE (mem.profil = '1' OR mem.profil = '0' OR mem.profil = '5') ORDER BY mem.name";
} else {
    $tmpquery = "WHERE (mem.profil = '1' OR mem.profil = '0' OR mem.profil = '5') AND mem.id != '2' ORDER BY mem.name";
} 

$assignOwner = new request();

$assignOwner->openMembers($tmpquery);
$comptAssignOwner = count($assignOwner->mem_id);

for ($i = 0; $i < $comptAssignOwner; $i++) {
    if ($projectDetail->pro_mem_id[0] == $assignOwner->mem_id[$i]) {
        echo '<option value="' . $assignOwner->mem_id[$i] . '" selected>' . $assignOwner->mem_login[$i] . ' / ' . $assignOwner->mem_name[$i] . '</option>';
    } else {
        echo '<option value="' . $assignOwner->mem_id[$i] . '">' . $assignOwner->mem_login[$i] . ' / ' . $assignOwner->mem_name[$i] . '</option>';
    }
} 

echo '</select></td></tr>
<tr class="odd"><td valign="top" class="leftvalue">' . $strings['organization'] . ' :</td><td><select name="clod">';

if ($clientsFilter == 'true' && $_SESSION['profilSession'] == '1') {
    $tmpquery = "WHERE org.owner = '" . $_SESSION['idSession'] . "' AND org.id != '1' ORDER BY org.name";
} else {
    $tmpquery = "WHERE org.id != '1' ORDER BY org.name";
}
$listClients = new request();
$listClients->openOrganizations($tmpquery);
$comptListClients = count($listClients->org_id);

if ($projectDetail->pro_org_id[0] == '1') {
    echo '<option value="1" selected>' . $strings['none'] . '</option>';
} else {
    echo '<option value="1">' . $strings['none'] . '</option>';
}

for ($i = 0; $i < $comptListClients; $i++) {
    if ($projectDetail->pro_org_id[0] == $listClients->org_id[$i]) {
        echo '<option value="' . $listClients->org_id[$i] . '" selected>' . $listClients->org_name[$i] . '</option>';
    } else {
        echo '<option value="' . $listClients->org_id[$i] . '">' . $listClients->org_name[$i] . '</option>';
    }
}

echo '</select></td></tr>
<tr class="odd"><td valign="top" class="leftvalue">' . $strings['enable_phases'] . ' :</td><td>
<select name="thisPhase">';

$compSets = count($phaseArraySets['sets']);

if ($projectDetail->pro_phase_set[0] == '0') {
    echo '<option value="0" selected>' . $strings['none'] . '</option>';
} else {
    echo '<option value="0">' . $strings['none'] . '</option>';
}

for($i = 1; $i <= $compSets; $i++) {
    if ($projectDetail->pro_phase_set[0] == $i) {
        echo '<option value="' . $i . '" selected>' . $phaseArraySets['sets'][$i] . '</option>';
    } else {
        echo '<option value="' . $i . '">' . $phaseArraySets['sets'][$i] . '</option>';
    } 
} 

echo '</select></td></tr>
<tr class="odd"><td valign="top" class="leftvalue">' . $strings['status'] . ' :</td><td><select name="st">';

$comptSta = count($status);

for ($i = 0; $i < $comptSta; $i++) {
    if ($projectDetail->pro_status[0] == $i) {
        echo '<option value="' . $i . '" selected>' . $status[$i] . '</option>';
    } else {
        echo '<option value="' . $i . '">' . $status[$i] . '</option>';
    } 
} 

echo '</select></td></tr>';

echo '
  <tr class="odd">
    <td valign="top" class="leftvalue">' . $strings['type'] . ' :</td>
    <td>
      <select name="pt">';

foreach ($projectType as $k => $v) {
    if ($k == $projectDetail->pro_type[0]) {
        echo '        <option value="' . $k . '" selected>' . $v . '</option>';
    } else {
        echo '        <option value="' . $k . '">' . $v . '</option>';
    } 
}

echo '      </select>
    </td>
  </tr>';

if ($fileManagement == 'true') {
    echo '<tr class="odd"><td valign="top" class="leftvalue">' . $strings['max_upload'] . ' :</td><td><input size="20" value="' . $projectDetail->pro_upload_max[0] . '" style="width: 150px" name="up" maxlength="100" type="TEXT"> ' . $byteUnits[0] . '</td></tr>';
} 

echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td><input type="SUBMIT" value="' . $strings['save'] . '"></td></tr>';

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
