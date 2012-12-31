<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editmeeting.php,v 1.6 2005/01/06 09:27:32 luiswang Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once("../includes/library.php");

if ($id != "" && $action != "update" && $action != "add") {
    $tmpquery = "WHERE mee.id = '$id'";
    $meetingDetail = new request();
    $meetingDetail->openMeetings($tmpquery);

    $tmpquery = "WHERE att.meeting = '$id'";
    $attendantDetail = new request();
    $attendantDetail->openAttendants($tmpquery);
    $comptAttendantDetail = count($attendantDetail->att_id);

    $tmpquery = "WHERE pro.id = '" . $meetingDetail->mee_project[0] . "'";
    $project = $meetingDetail->mee_project[0];
} else {
    $tmpquery = "WHERE pro.id = '$project'";
    $comptAttendantDetail = "0" ;
} 

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

if ($teamMember == "false" && $_SESSION['profilSession'] != "5") {
    header("Location: ../meetings/listmeetings.php?project=$project&msg=meetingOwner");
    exit;
} 
if ($stm != "" && $etm != "" && $stm > $etm) {
    $etm = $stm;
}
// case update meeting
if ($id != "") {
    // case update meeting
    if ($action == "update") {
        // concat values from date selector and replace quotes by html code in name
        $mn = convertData($mn);
        $ma = convertData($ma);
        $ml = convertData($ml);
        $mm = convertData($mm);
        $mc = $S_CSEL[0];
        $mr = $S_RSEL[0];

        // case copy meeting
        if ($cpy == "true") {
            if ($pub == "") {
                $pub = "1";
            } 
            // Insert Meeting details
            $tmpquery1 = "INSERT INTO " . $tableCollab["meetings"] . "(project,name,agenda,location,minutes,chairman,recorder,status,priority,date,start_time,end_time,reminder,reminder_time1,reminder_time2,created,published) VALUES('$project','$mn','$ma','$ml','$mm','$mc','$mr','$st','$pr','$md','$stm','$etm','0','0','0','$dateheure','$pub')";
            connectSql("$tmpquery1");
            $tmpquery = $tableCollab["meetings"];
            last_id($tmpquery);
            $num = $lastId[0];
            unset($lastId);

            $att_mem_id_list = "";
            if ($S_ATSEL[0] == "ALL") {
                $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
                $listTeam1 = new request();
                $listTeam1->openTeams($tmpquery2);
                $comptListTeam1 = count($listTeam1->tea_id);
                $comptATSEL = $comptListTeam1;

                for ($i = 0; $i < $comptListTeam1; $i++) {
                    $mem_id1 = $listTeam1->tea_mem_id[$i];
                    $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                    connectSql("$tmpquery3");
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $mem_id1;
                    $mr = $mem_id1;
                }

                if ($projectDetail->pro_org_id[0] != "1") {
                    $tmpquery2 = "WHERE mem.organization = '" . $projectDetail->pro_org_id[0] . "' AND mem.profil = '3'";
                    $listClientMem1 = new request();
                    $listClientMem1->openMembers($tmpquery2);
                    $comptListClientMem1 = count($listClientMem1->mem_id);
                    $comptATSEL += $comptListClientMem1;

                    for ($i = 0; $i < $comptListClientMem1; $i++) {
                        $mem_id1 = $listClientMem1->mem_id[$i];
                        $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                        connectSql("$tmpquery3");
                        if ($att_mem_id_list != "") {
                            $att_mem_id_list .= ", ";
                        }
                        $att_mem_id_list .= $mem_id1;
                    }
                }
            }
            else if ($S_ATSEL[0] == "NOCLIENTS") {
                $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
                $listTeam1 = new request();
                $listTeam1->openTeams($tmpquery2);
                $comptListTeam1 = count($listTeam1->tea_id);
                $comptATSEL = $comptListTeam1;

                for ($i = 0; $i < $comptListTeam1; $i++) {
                    $mem_id1 = $listTeam1->tea_mem_id[$i];
                    $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                    connectSql("$tmpquery3");
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $mem_id1;
                    $mr = $mem_id1;
                }
            }
            else {
                $comptATSEL = count($S_ATSEL);

                for ($i = 0; $i < $comptATSEL; $i++) {
                    $mem_id1 = $S_ATSEL[$i];
                    $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                    connectSql("$tmpquery3");
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $mem_id1;
                    $mr = $mem_id1;
                }
            }

            if ($mr != "0") {
                $tmpquery4 = "UPDATE " . $tableCollab["meetings"] . " SET recorder='$mr' WHERE id = '$num'";
                connectSql($tmpquery4);
            }
            if ($att_mem_id_list != "") {
                // send meeting assignment mail if notifications = true
                if ($notifications == "true") {
                    require_once("../meetings/noti_meetingassignment.php");
                } 
            } 
            // create meeting sub-folder if filemanagement = true
            if ($fileManagement == "true") {
                createDir("files/$project/meetings");
                createDir("files/$project/meetings/$num");
            } 
            header("Location: ../meetings/viewmeeting.php?id=$num&msg=addMeeting");
            exit;
        // case update meeting
        } else {
            if ($pub == "") {
                $pub = "1";
            } 
            $tmpquery5 = "UPDATE " . $tableCollab["meetings"] . " SET name='$mn',agenda='$ma',location='$ml',minutes='$mm',chairman='$mc',recorder='$mr',status='$st',priority='$pr',date='$md',start_time='$stm',end_time='$etm',modified='$dateheure',published='$pub' WHERE id = '$id'";

            // if project different from past value, set project number in meetings table
            if ($project != $old_project) {
                $tmpquery6 = "UPDATE " . $tableCollab["meetings"] . " SET project='$project' WHERE id = '$id'";
                $tmpquery7 = "UPDATE " . $tableCollab["meetings_attachment"] . " SET project='$project' WHERE meeting = '$id'";
                $tmpquery8 = "UPDATE " . $tableCollab["meetings_time"] . " SET project='$project' WHERE meeting = '$id'";
                $tmpquery9 = "UPDATE " . $tableCollab["attendants"] . " SET project='$project' WHERE meeting = '$id'";
                connectSql($tmpquery6);
                connectSql($tmpquery7);
                connectSql($tmpquery8);
                connectSql($tmpquery9);
                createDir("files/$project/meetings");
                createDir("files/$project/meetings/$id");
                $dir = opendir("../files/$old_project/meetings/$id");
                if (is_resource($dir)) {
                    while ($v = readdir($dir)) {
                        if ($v != '.' && $v != '..') {
                            copy("../files/$old_project/meetings/$id/" . $v, "../files/$project/meetings/$id/" . $v);
                            @unlink("../files/$old_project/meetings/$id/" . $v);
                        } 
                    } 
                } 
            } 
            // if attendants different from past value, insert into assignment
            // add new assigned_to in team members (only if doesn't already exist)
            $new_attendants_count = 0;
            $att_mem_id_list = "";
            if ($S_ATSEL[0] == "ALL") {
                $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
                $listTeam1 = new request();
                $listTeam1->openTeams($tmpquery2);
                $comptListTeam1 = count($listTeam1->tea_id);
                $comptATSEL = $comptListTeam1;

                for ($i = 0; $i < $comptListTeam1; $i++) {
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $listTeam1->tea_mem_id[$i];
                    $new_attendants_list[$new_attendants_count] = $listTeam1->tea_mem_id[$i];
                    $new_attendants_count++;
                }

                if ($projectDetail->pro_org_id[0] != "1") {
                    $tmpquery2 = "WHERE mem.organization = '" . $old_org_id . "' AND mem.profil = '3'";
                    $listClientMem1 = new request();
                    $listClientMem1->openMembers($tmpquery2);
                    $comptListClientMem1 = count($listClientMem1->mem_id);
                    $comptATSEL += $comptListClientMem1;

                    for ($i = 0; $i < $comptListClientMem1; $i++) {
                        if ($att_mem_id_list != "") {
                            $att_mem_id_list .= ", ";
                        }
                        $att_mem_id_list .= $listClientMem1->mem_id[$i];
                        $new_attendants_list[$new_attendants_count] = $listClientMem1->mem_id[$i];
                        $new_attendants_count++;
                    }
                }
            } else if ($S_ATSEL[0] == "NOCLIENTS") {
                $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
                $listTeam1 = new request();
                $listTeam1->openTeams($tmpquery2);
                $comptListTeam1 = count($listTeam1->tea_id);
                $comptATSEL = $comptListTeam1;

                for ($i = 0; $i < $comptListTeam1; $i++) {
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $listTeam1->tea_mem_id[$i];
                    $new_attendants_list[$new_attendants_count] = $listTeam1->tea_mem_id[$i];
                    $new_attendants_count++;
                }
            } else {
                $comptATSEL = count($S_ATSEL);

                for ($i = 0; $i < $comptATSEL; $i++) {
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $S_ATSEL[$i];
                    $new_attendants_list[$new_attendants_count] = $S_ATSEL[$i];
                    $new_attendants_count++;
                }
            }
            if ($att_mem_id_list != $old_attendants) {
                $tmpquery9 = "DELETE FROM " . $tableCollab["attendants"] . " WHERE meeting='$id'";
                connectSql("$tmpquery9");

                for ($i = 0 ; $i < $new_attendants_count; $i++) {
                    $tmpquery9 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$id','" . $new_attendants_list[$i] . "','$pub',1)";
                    connectSql("$tmpquery9");
                }

                $msg = "updateAttendants";
                connectSql("$tmpquery5");
                $tmpquery = "WHERE mee.id = '$id'";
                $meetingDetail = new request();
                $meetingDetail->openMeetings($tmpquery);
                // send meeting assignment mail if notifications = true
                if ($notifications == "true") {
                    require_once("../meetings/noti_meetingassignment.php");
                } 
            } else {
                $msg = "update";
                connectSql("$tmpquery5");
                $tmpquery = "WHERE mee.id = '$id'";
                $meetingDetail = new request();
                $meetingDetail->openMeetings($tmpquery);
                // send status meeting change mail if notifications = true
                if ($comptATSEL != "0" && $st != $old_st) {
                    if ($notifications == "true") {
                        require_once("../meetings/noti_statusmeetingchange.php");
                    } 
                } 
                // send priority meeting change mail if notifications = true
                if ($comptATSEL != "0" && $pr != $old_pr) {
                    if ($notifications == "true") {
                        require_once("../meetings/noti_prioritymeetingchange.php");
                    } 
                } 
                // send location meeting change mail if notifications = true
                if ($comptATSEL != "0" && $ml != $old_location) {
                    if ($notifications == "true") {
                        require_once("../meetings/noti_locationmeetingchange.php");
                    } 
                } 
                // send date/time meeting change mail if notifications = true
                if ($comptATSEL != "0" && ($md != $old_date || $stm != $old_start_time || $etm != $old_end_time)) {
                    if ($notifications == "true") {
                        require_once("../meetings/noti_timemeetingchange.php");
                    } 
                } 
            } 

            if ($ml != $old_location) {
                $cUp .= "\n[location:$ml]";
            }
            if ($st != $old_st) {
                $cUp .= "\n[status:$st]";
            }
            if ($pr != $old_pr) {
                $cUp .= "\n[priority:$pr]";
            }
            if ($md != $old_date) {
                $cUp .= "\n[date:$md]";
            }
            if ($stm != $old_start_time) {
                $cUp .= "\n[stime:$stm]";
            }
            if ($etm != $old_end_time) {
                $cUp .= "\n[etime:$etm]";
            }

            if ($cUp != "" || $st != $old_st || $pr != $old_pr || $md != $old_date || $ml != $old_location || $stm != $old_start_time || $etm != $old_end_time) {
                $cUp = convertData($cUp);
                $tmpquery6 = "INSERT INTO " . $tableCollab["updates"] . "(type,item,member,comments,created) VALUES ('M','$id','" . $_SESSION['idSession'] . "','$cUp','$dateheure')";
                connectSql($tmpquery6);
            }
            header("Location: ../meetings/viewmeeting.php?id=$id&msg=$msg");
            exit;
        } 
    } 

    // set value in form
    $mn = $meetingDetail->mee_name[0];
    $ma = $meetingDetail->mee_agenda[0];
    $ml = $meetingDetail->mee_location[0];
    $mm = $meetingDetail->mee_minutes[0];
    $mc = $meetingDetail->mee_chairman[0];
    $mr = $meetingDetail->mee_recorder[0];
    $md = $meetingDetail->mee_date[0];
    $stm = $meetingDetail->mee_start_time[0];
    $etm = $meetingDetail->mee_end_time[0];
    $pub = $meetingDetail->mee_published[0];

    if ($pub == "0") {
        $checkedPub = "checked";
    } 
} 
// case add meeting
if ($id == "") {
    // case add meeting
    if ($action == "add") {
        // concat values from date selector and replace quotes by html code in name
        $mn = convertData($mn);
        $ma = convertData($ma);
        $ml = convertData($ml);
        $mm = convertData($mm);
        $mc = $S_CSEL[0];
        $mr = "0";

        if ($pub == "") {
            $pub = "1";
        } 
        $tmpquery1 = "INSERT INTO " . $tableCollab["meetings"] . "(project,name,agenda,location,minutes,chairman,recorder,status,priority,date,start_time,end_time,reminder,reminder_time1,reminder_time2,created,published) VALUES('$project','$mn','$ma','$ml','$mm','$mc','$mr','$st','$pr','$md','$stm','$etm','0','0','0','$dateheure','$pub')";
        connectSql("$tmpquery1");
        $tmpquery = $tableCollab["meetings"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);

        $att_mem_id_list = "";
        if ($S_ATSEL[0] == "ALL") {
            $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
            $listTeam1 = new request();
            $listTeam1->openTeams($tmpquery2);
            $comptListTeam1 = count($listTeam1->tea_id);
            $comptATSEL = $comptListTeam1;

            for ($i = 0; $i < $comptListTeam1; $i++) {
                $mem_id1 = $listTeam1->tea_mem_id[$i];
                $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                connectSql("$tmpquery3");
                if ($att_mem_id_list != "") {
                    $att_mem_id_list .= ", ";
                }
                $att_mem_id_list .= $mem_id1;
                $mr = $mem_id1;
            }

            if ($projectDetail->pro_org_id[0] != "1") {
                $tmpquery2 = "WHERE mem.organization = '" . $projectDetail->pro_org_id[0] . "' AND mem.profil = '3'";
                $listClientMem1 = new request();
                $listClientMem1->openMembers($tmpquery2);
                $comptListClientMem1 = count($listClientMem1->mem_id);
                $comptATSEL += $comptListClientMem1;

                for ($i = 0; $i < $comptListClientMem1; $i++) {
                    $mem_id1 = $listClientMem1->mem_id[$i];
                    $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                    connectSql("$tmpquery3");
                    if ($att_mem_id_list != "") {
                        $att_mem_id_list .= ", ";
                    }
                    $att_mem_id_list .= $mem_id1;
                }
            }
        }
        else if ($S_ATSEL[0] == "NOCLIENTS") {
            $tmpquery2 = "WHERE tea.project = '$project' AND mem.profil != '3'";
            $listTeam1 = new request();
            $listTeam1->openTeams($tmpquery2);
            $comptListTeam1 = count($listTeam1->tea_id);
            $comptATSEL = $comptListTeam1;

            for ($i = 0; $i < $comptListTeam1; $i++) {
                $mem_id1 = $listTeam1->tea_mem_id[$i];
                $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                connectSql("$tmpquery3");
                if ($att_mem_id_list != "") {
                    $att_mem_id_list .= ", ";
                }
                $att_mem_id_list .= $mem_id1;
                $mr = $mem_id1;
            }
        }
        else {
            $comptATSEL = count($S_ATSEL);

            for ($i = 0; $i < $comptATSEL; $i++) {
                $mem_id1 = $S_ATSEL[$i];
                $tmpquery3 = "INSERT INTO " . $tableCollab["attendants"] . "(project,meeting,member,published,authorized) VALUES('$project','$num','$mem_id1','$pub',1)";
                connectSql("$tmpquery3");
                if ($att_mem_id_list != "") {
                    $att_mem_id_list .= ", ";
                }
                $att_mem_id_list .= $mem_id1;
                $mr = $mem_id1;
            }
        }

        if ($mr != "0") {
            $tmpquery4 = "UPDATE " . $tableCollab["meetings"] . " SET recorder='$mr' WHERE id = '$num'";
            connectSql($tmpquery4);
        }
        if ($att_mem_id_list != "") {
            // send meeting assignment mail if notifications = true
            if ($notifications == "true") {
                require_once("../meetings/noti_meetingassignment.php");
            } 
        } 
        // create meeting sub-folder if filemanagement = true
        if ($fileManagement == "true") {
            createDir("files/$project/meetings");
            createDir("files/$project/meetings/$num");
        } 
        header("Location: ../meetings/viewmeeting.php?id=$num&msg=addMeeting");
        exit;
    } 
    // set default values
    $meetingDetail->mee_priority[0] = $projectDetail->pro_priority[0];
    $meetingDetail->mee_status[0] = "2";
} 

if ($projectDetail->pro_org_id[0] == "1") {
    $projectDetail->pro_org_name[0] = $strings["none"];
} 

//--- header ----------------------------------------------------------------------------------
$breadcrumbs[]=buildLink('../projects/listprojects.php', $strings['projects'], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?project=" . $projectDetail->pro_id[0], $strings["meetings"], LINK_INSIDE);
if ($id == "") {
    $breadcrumbs[]=$strings["add_meeting"];
} 
if ($id != "") {
    $breadcrumbs[]=buildLink("../meetings/viewmeeting.php?id=" . $meetingDetail->mee_id[0], $meetingDetail->mee_name[0], LINK_INSIDE);
    $breadcrumbs[]=$strings["edit_meeting"];
} 

$pageSection='meetings';
$bodyCommand = "onload=\"document.emDForm.compl.value = document.emDForm.completion.selectedIndex;document.emDForm.tn.focus();\"";
require_once('../themes/' . THEME . '/header.php');

//--- content ---------------------------------------------------------------------------------
$block1 = new block();

if ($id == "") {
    $block1->form = "emD";
    $block1->openForm("../meetings/editmeeting.php?project=$project&amp;action=add#" . $block1->form . "Anchor");
} 
if ($id != "") {
    $block1->form = "emD";
    $block1->openForm("../meetings/editmeeting.php?project=$project&amp;id=$id&amp;action=update&amp;cpy=$cpy#" . $block1->form . "Anchor");
    echo "<input type=\"hidden\" name=\"old_pr\" value=\"" . $meetingDetail->mee_priority[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_st\" value=\"" . $meetingDetail->mee_status[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_project\" value=\"" . $meetingDetail->mee_project[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_org_id\" value=\"" . $$projectDetail->pro_org_id[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_location\" value=\"" . $meetingDetail->mee_location[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_date\" value=\"" . $meetingDetail->mee_date[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_start_time\" value=\"" . $meetingDetail->mee_start_time[0] . "\">";
    echo "<input type=\"hidden\" name=\"old_end_time\" value=\"" . $meetingDetail->mee_end_time[0] . "\">";

    $att_mem_id_list = "";
    for ($i = 0; $i < $comptAttendantDetail; $i++) {
        if ($att_mem_id_list != "") {
            $att_mem_id_list .= ", ";
        }
        $att_mem_id_list .= $attendantDetail->att_mem_id[$i];
    }
    echo "<input type=\"hidden\" name=\"old_attendants\" value=\"" . $att_mem_id_list . "\">";
} 

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

if ($id == "") {
    $block1->headingForm($strings["add_meeting"]);
} 
if ($id != "") {
    if ($cpy == "true") {
        $block1->headingForm($strings["copy_meeting"] . " : " . $meetingDetail->mee_name[0]);
    } else {
        $block1->headingForm($strings["edit_meeting"] . " : " . $meetingDetail->mee_name[0]);
    } 
} 

$block1->openContent();
$block1->contentTitle($strings["info"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["project"] . " :</td><td><select name=\"project\">";

if ($projectsFilter == "true") {
    $tmpquery = "LEFT OUTER JOIN " . $tableCollab["teams"] . " teams ON teams.project = pro.id ";
    $tmpquery .= "WHERE teams.member = '" . $_SESSION['idSession'] . "'";
} else {
    $tmpquery = "";
} 
$listProjects = new request();
$listProjects->openProjects($tmpquery);
$comptListProjects = count($listProjects->pro_id);

for ($i = 0;$i < $comptListProjects;$i++) {
    if ($listProjects->pro_id[$i] == $projectDetail->pro_id[0]) {
        echo "<option value=\"" . $listProjects->pro_id[$i] . "\" selected>" . $listProjects->pro_name[$i] . "</option>";
    } else {
        echo "<option value=\"" . $listProjects->pro_id[$i] . "\">" . $listProjects->pro_name[$i] . "</option>";
    } 
} 
echo "</select></td></tr>";
echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["organization"] . " :</td><td>" . $projectDetail->pro_org_name[0] . "</td></tr>";

$block1->contentTitle($strings["details"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["name"] . " :</td><td><input size=\"44\" value=\"";

if ($cpy == "true") {
    echo $strings["copy_of"];
} 

echo "$mn\" style=\"width: 400px\" name=\"mn\" maxlength=\"100\" type=\"TEXT\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["me_agenda"] . " :</td><td><textarea rows=\"4\" style=\"width: 400px; height: 64px;\" name=\"ma\" cols=\"47\">$ma</textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["me_location"] . " :</td><td><textarea rows=\"2\" style=\"width: 400px; height: 32px;\" name=\"ml\" cols=\"47\">$ml</textarea></td></tr>";

$tmpquery = "WHERE tea.project = '$project' AND mem.profil != '3'";
$listTeam = new request();
$listTeam->openTeams($tmpquery);
$comptListTeam = count($listTeam->tea_id);

if ($projectDetail->pro_org_id[0] != "1") {
    $tmpquery = "WHERE mem.organization = '" . $projectDetail->pro_org_id[0] . "' AND mem.profil = '3'";
    $listClientMem = new request();
    $listClientMem->openMembers($tmpquery);
    $comptListClientMem = count($listClientMem->mem_id);
}
else {
    $comptListClientMem = "0" ;
}

$comptListSum = $comptListTeam + $comptListClientMem;

if ($comptListSum != "0") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["me_chairman"] . " :</td><td><select name=\"S_CSEL[]\">";

    for ($i = 0; $i < $comptListTeam; $i++) {
        echo "<option value=\"" . $listTeam->tea_mem_id[$i] . "\"";

        if ($id != "") {
            if ($listTeam->tea_mem_id[$i] == $mc) {
                echo " selected";
            }
        }
        else {
            if ($listTeam->tea_mem_id[$i] == $_SESSION['idSession']) {
                echo " selected";
            }
        }

        echo ">" . $listTeam->tea_mem_login[$i] . " / " . $listTeam->tea_mem_name[$i] . "</option>";
    }

    for ($i = 0; $i < $comptListClientMem; $i++) {
        echo "<option value=\"" . $listClientMem->mem_id[$i] . "\">" . $listClientMem->mem_name[$i] . " (" . $strings["client_user"] . ")</option>";
    }

    echo "</select></td></tr>";
}

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"st\">";

$comptSta = count($status);

for ($i = 0;$i < $comptSta;$i++) {
    if ($meetingDetail->mee_status[0] == $i) {
        echo "<option value=\"$i\" selected>$status[$i]</option>";
    } else {
        echo "<option value=\"$i\">$status[$i]</option>";
    } 
} 

echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["priority"] . " :</td><td><select name=\"pr\">";

$comptPri = count($priority);

for ($i = 0;$i < $comptPri;$i++) {
    if ($meetingDetail->mee_priority[0] == $i) {
        echo "<option value=\"$i\" selected>$priority[$i]</option>";
    } else {
        echo "<option value=\"$i\">$priority[$i]</option>";
    } 
} 

echo "</select></td></tr>";

if ($md == "") {
    $md = $date;
} 

$block1->contentRow($strings["date"], "<input type=\"text\" style=\"width: 150px;\" name=\"md\" id=\"sel1\" size=\"20\" value=\"$md\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script>");

echo "
  <tr class=\"odd\">
    <td valign=\"top\" class=\"leftvalue\">" . $strings["start_time"] . " :</td>
    <td><select name=\"stm\">";
foreach ($timestampArray as $key => $value) {
    if ($key == $stm) {
        echo "<option value=\"$key\" selected>$value</option>";
    } else {
        echo "<option value=\"$key\">$value</option>";
    }
}
echo "</select></td></tr>";

echo "
  <tr class=\"odd\">
    <td valign=\"top\" class=\"leftvalue\">" . $strings["end_time"] . " :</td>
    <td><select name=\"etm\">";
foreach ($timestampArray as $key => $value) {
    if ($key == $etm) {
        echo "<option value=\"$key\" selected>$value</option>";
    } else {
        echo "<option value=\"$key\">$value</option>";
    }
}
echo "</select></td></tr>";

echo "
  <tr class=\"odd\">
    <td valign=\"top\" class=\"leftvalue\">" . $strings["published"] . " :</td>
    <td><input size=\"32\" value=\"0\" name=\"pub\" type=\"checkbox\" $checkedPub></td>
  </tr>";

if ($comptListSum != "0") {
    $block1->contentTitle($strings["attendants"]);

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"></td><td>";

    $selectSize = $comptListSum + 2;
    if ($comptAttendantDetail == "0") {
        echo "<select name=\"S_ATSEL[]\" size=\"" . $selectSize . "\" multiple><option selected value=\"ALL\">" . $strings["select_all"] . "</option><option value=\"NOCLIENTS\">" . $strings["select_all_but_clients"] . "</option>";
    }
    else {
        echo "<select name=\"S_ATSEL[]\" size=\"" . $selectSize . "\" multiple><option value=\"ALL\">" . $strings["select_all"] . "</option><option value=\"NOCLIENTS\">" . $strings["select_all_but_clients"] . "</option>";
    }

    for ($i = 0; $i < $comptListTeam; $i++) {
        echo "<option ";

        for ($j = 0; $j < $comptAttendantDetail; $j++) {
            if ($attendantDetail->att_mem_id[$j] == $listTeam->tea_mem_id[$i]) {
                echo "selected ";
                break;
            }
        }

        echo "value=\"" . $listTeam->tea_mem_id[$i] . "\">" . $listTeam->tea_mem_login[$i] . " / " . $listTeam->tea_mem_name[$i] . "</option>";
    }

    for ($i = 0; $i < $comptListClientMem; $i++) {
        echo "<option ";

        for ($j = 0; $j < $comptAttendantDetail; $j++) {
            if ($attendantDetail->att_mem_id[$j] == $listClientMem->mem_id[$i]) {
                echo "selected ";
                break;
            }
        }

        echo "value=\"" . $listClientMem->mem_id[$i] . "\">" . $listClientMem->mem_login[$i] . " / " .$listClientMem->mem_name[$i] . " (" . $strings["client_user"] . ")</option>";
    }

    echo "</select></td></tr>";
}

if ( ($id != "") && ($cpy != "true") ) {
    $block1->contentTitle($strings["me_minutes"]);

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"></td><td><textarea rows=\"24\" style=\"width: 600px; height: 384;\" name=\"mm\" cols=\"70\">$mm</textarea></td></tr>";

    if ($comptListSum != "0") {
        echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["me_recorder"] . " :</td><td><select name=\"S_RSEL[]\">";

        for ($i = 0; $i < $comptListTeam; $i++) {
            echo "<option value=\"" . $listTeam->tea_mem_id[$i] . "\"";
            if ($id != "") {
                if ($listTeam->tea_mem_id[$i] == $mr) {
                    echo " selected";
                }
            }
            else {
                if ($listTeam->tea_mem_id[$i] == $_SESSION['idSession']) {
                    echo " selected";
                }
            }
            echo ">" . $listTeam->tea_mem_login[$i] . " / " . $listTeam->tea_mem_name[$i] . "</option>";
        }

        for ($i = 0; $i < $comptListClientMem; $i++) {
            echo "<option value=\"" . $listClientMem->mem_id[$i] . "\">" . $listClientMem->mem_login[$i] . " / " . $listClientMem->mem_name[$i] . " (" . $strings["client_user"] . ")</option>";
        }

        echo "</select></td></tr>";
    }
}

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>";

$block1->closeContent();
if ($id != "") {
	$block1->headingForm_close();
}
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
