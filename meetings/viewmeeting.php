<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewmeeting.php,v 1.6 2005/05/30 16:12:38 madbear Exp $
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

$id = $_REQUEST['id'];

if ($meeting != "") {
    $cheatCode = "true";
} 

if ($action == "publish") {
    if ($addToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='0' WHERE id = '" . $id . "'";
        connectSql("$tmpquery1");
        $msg = "addToSite";
    } 

    if ($removeToSite == "true") {
        $tmpquery1 = "UPDATE " . $tableCollab["meetings"] . " SET published='1' WHERE id = '" . $id . "'";
        connectSql("$tmpquery1");
        $msg = "removeToSite";
    } 

    if ($addToSiteFile == "true") {
        $id = str_replace("**", ",", $id);
        $tmpquery1 = "UPDATE " . $tableCollab["meetings_attachment"] . " SET published='0' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql("$tmpquery1");
        $msg = "addToSite";
        $id = $meeting;
    } 

    if ($removeToSiteFile == "true") {
        $id = str_replace("**", ",", $id);
        $tmpquery1 = "UPDATE " . $tableCollab["meetings_attachment"] . " SET published='1' WHERE id IN($id) OR vc_parent IN ($id)";
        connectSql("$tmpquery1");
        $msg = "removeToSite";
        $id = $meeting;
    } 
} 

if ($meeting != "" && $cheatCode == "true") {
    $id = $meeting;
} 

$tmpquery = "WHERE mee.id = '$id'";
$meetingDetail = new request();
$meetingDetail->openMeetings($tmpquery);

$tmpquery = "WHERE att.meeting = '$id'";
$attendantDetail = new request();
$attendantDetail->openAttendants($tmpquery);
$comptAttendantDetail = count($attendantDetail->att_id);

$tmpquery = "WHERE pro.id = '" . $meetingDetail->mee_project[0] . "'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '" . $meetingDetail->mee_project[0] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
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

// --- header -----------------------
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $projectDetail->pro_id[0], $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?project=" . $projectDetail->pro_id[0], $strings["meetings"], LINK_INSIDE);
$breadcrumbs[]=$meetingDetail->mee_name[0];

require_once("../themes/" . THEME . "/header.php");

// --- content -----------------------
$block1 = new block();

$block1->form = "mdD";
$block1->openForm("../meetings/viewmeeting.php#" . $block1->form . "Anchor");

$block1->headingToggle($strings["meeting"] . " : " . $meetingDetail->mee_name[0]);

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
    $block1->paletteIcon(6, "timelog", $strings["loghours"]);
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

$block1->contentRow($strings["organization"], $projectDetail->pro_org_name[0]);

$block1->contentRow($strings["created"], createDate($meetingDetail->mee_created[0], $_SESSION['timezoneSession']));
$block1->contentRow($strings["modified"], createDate($meetingDetail->mee_modified[0], $_SESSION['timezoneSession']));

$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["name"], $meetingDetail->mee_name[0]);
$block1->contentRow($strings['meeting_id'], $meetingDetail->mee_id[0]);


$idStatus = $meetingDetail->mee_status[0];
$idPriority = $meetingDetail->mee_priority[0];
$idPublish = $meetingDetail->mee_published[0];

$block1->contentRow($strings["status"], $status[$idStatus]);
$block1->contentRow($strings["priority"], $priority[$idPriority]);
if ($meetingDetail->mee_date[0] <= $date && $idStatus != 1) {
    $block1->contentRow($strings["date"], "<b>" . $meetingDetail->mee_date[0] . "</b>");
} else {
    $block1->contentRow($strings["date"], $meetingDetail->mee_date[0]);
} 

$block1->contentRow($strings["start_time"], $meetingDetail->mee_start_time[0]);
$block1->contentRow($strings["end_time"], $meetingDetail->mee_end_time[0]);
$block1->contentRow($strings["me_agenda"], nl2br($meetingDetail->mee_agenda[0]));
$block1->contentRow($strings["me_location"], nl2br($meetingDetail->mee_location[0]));

if ($meetingDetail->mee_chairman_login[0] == "") {
    $block1->contentRow($strings["me_chairman"], "");
} else {
    $block1->contentRow($strings["me_chairman"], buildLink('../users/viewuser.php?id=' . $meetingDetail->mee_chairman[0], $meetingDetail->mee_chairman_name[0], LINK_INSIDE) . ' (' . buildLink($meetingDetail->mee_chairman_email[0], $meetingDetail->mee_chairman_login[0], LINK_MAIL) . ')');
}

for ($i = 0; $i < $comptAttendantDetail; $i++) {
    if ($i == 0) {
        $column1 = $strings["attendants"];
    } else {
        $column1 = "";
    }

    $tmpquery = "WHERE mem.organization = '" . $projectDetail->pro_org_id[0] . "' AND mem.profil = '3' AND mem.id = '" . $attendantDetail->att_mem_id[$i] . "'";
    $clientMem = new request();
    $clientMem->openMembers($tmpquery);

    $column2 = $attendantDetail->att_mem_login[$i] . " / " . $attendantDetail->att_mem_name[$i];
    if (count($clientMem->mem_id) != 0) {
        $column2 .= " (" . $strings["client_user"] . ")";
    }

    $block1->contentRow($column1, $column2);
}

if ($meetingDetail->mee_recorder_login[0] == "") {
    $block1->contentRow($strings["me_recorder"], "");
} else {
    $block1->contentRow($strings["me_recorder"], buildLink('../users/viewuser.php?id=' . $meetingDetail->mee_recorder[0], $meetingDetail->mee_recorder_name[0], LINK_INSIDE) . ' (' . buildLink($meetingDetail->mee_recorder_email[0], $meetingDetail->mee_recorder_login[0], LINK_MAIL) . ')');
}

$block1->contentRow($strings["me_minutes"], nl2br($meetingDetail->mee_minutes[0]));
$block1->contentRow($strings['ical_url'], buildLink("$root/calendar/icalendar.php", "$root/calendar/icalendar.php", LINK_OUT));

if ($sitePublish == "true") {
    $block1->contentRow($strings["published"], $statusPublish[$idPublish]);
} 

$block1->contentTitle($strings["updates_meeting"]);
$tmpquery = "WHERE upd.type='M' AND upd.item = '$id' ORDER BY upd.created DESC";
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

        $abbrev = substr($listUpdates->upd_comments[$i], 0, 100);

        echo "<b>" . $j . ".</b> <i>" . createDate($listUpdates->upd_created[$i], $_SESSION['timezoneSession']) . "</i> $abbrev";
        if (100 < strlen($listUpdates->upd_comments[$i])) {
            echo "...<br>";
        } else {
            echo "<br>";
        } 
        $j++;
    } 
    echo "<br>" . buildLink("../meetings/historymeeting.php?type=1&amp;item=$id", $strings["show_details"], LINK_INSIDE);
} else {
    echo $strings["no_items"];
} 

echo "</td></tr>";

$block1->closeContent();
$block1->closeToggle();
$block1->closeForm();

if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
    $block1->openPaletteScript();
    $block1->paletteScript(0, "remove", "../meetings/deletemeetings.php?project=" . $meetingDetail->mee_project[0] . "&id=" . $meetingDetail->mee_id[0] . "", "true,true,false", $strings["delete"]);
    $block1->paletteScript(1, "copy", "../meetings/editmeeting.php?project=" . $meetingDetail->mee_project[0] . "&id=" . $meetingDetail->mee_id[0] . '&cpy=true', "true,true,false", $strings["copy"]);
    // $block1->paletteScript(2,"export","export.php?","true,true,false",$strings["export"]);
    if ($sitePublish == "true") {
        $block1->paletteScript(3, "add_projectsite", "../meetings/viewmeeting.php?addToSite=true&id=" . $meetingDetail->mee_id[0] . "&action=publish", "true,true,true", $strings["add_project_site"]);
        $block1->paletteScript(4, "remove_projectsite", "../meetings/viewmeeting.php?removeToSite=true&id=" . $meetingDetail->mee_id[0] . "&action=publish", "true,true,true", $strings["remove_project_site"]);
    } 
    $block1->paletteScript(5, "edit", "../meetings/editmeeting.php?project=" . $meetingDetail->mee_project[0] . "&id=" . $meetingDetail->mee_id[0] . '&cpy=false', "true,true,false", $strings["edit"]);
    $block1->paletteScript(6, "timelog", "../meetings/addmeetingtime.php?id=" . $meetingDetail->mee_id[0], "true,true,false", $strings["loghours"]);
    $block1->closePaletteScript("", "");
} 

if ($fileManagement == "true") {
    $block2 = new block();

    $block2->form = "mdC";
    $block2->openForm("../meetings/viewmeeting.php?id=$id#" . $block2->form . "Anchor");

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

    $block2->sorting("meetings_attachment", $sortingUser->sor_meetings_attachment[0], "mat.name ASC", $sortingFields = array(0 => "mat.extension", 1 => "mat.name", 2 => "mat.date", 3 => "mat.status", 4 => "mat.published"));

    $tmpquery = "WHERE mat.meeting = '$id' AND mat.vc_parent = '0' ORDER BY $block2->sortingValue";
    $listAttachments = new request();
    $listAttachments->openMeetingsAttachment($tmpquery);
    $comptListFiles = count($listAttachments->mat_id);

    if ($comptListFiles != "0") {
        $block2->openResults();

        $block2->labels($labels = array(0 => $strings["type"], 1 => $strings["name"], 2 => $strings["date"], 3 => $strings["approval_tracking"], 4 => $strings["published"]), "true");

        require_once("../includes/files_types.php");

        for ($i = 0;$i < $comptListFiles;$i++) {
            $existFile = "false";
            $idStatus = $listAttachments->mat_status[$i];
            $idPublish = $listAttachments->mat_published[$i];

            $type = file_info_type($listAttachments->mat_extension[$i]);
            if (file_exists("../files/" . $listAttachments->mat_project[$i] . "/meetings/" . $listAttachments->mat_meeting[$i] . "/" . $listAttachments->mat_name[$i])) {
                $existFile = "true";
            } 
            $block2->openRow($listAttachments->mat_id[$i]);
            $block2->checkboxRow($listAttachments->mat_id[$i]);
            if ($existFile == "true") {
                $block2->cellRow(buildLink("../meetings/viewfile.php?id=" . $listAttachments->mat_id[$i], $type, icone));
            } else {
                $block2->cellRow("&nbsp;");
            } 
            if ($existFile == "true") {
                $block2->cellRow(buildLink("../meetings/viewfile.php?id=" . $listAttachments->mat_id[$i], $listAttachments->mat_name[$i], LINK_INSIDE));
            } else {
                $block2->cellRow($strings["missing_file"] . " (" . $listAttachments->mat_name[$i] . ")");
            } 
            $block2->cellRow($listAttachments->mat_date[$i]);
            $block2->cellRow(buildLink("../meetings/viewfile.php?id=" . $listAttachments->mat_id[$i], $statusFile[$idStatus], LINK_INSIDE));
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
        $block2->paletteScript(0, "add", "../meetings/addfile.php?project=" . $meetingDetail->mee_project[0] . "&meeting=$id", "true,true,true", $strings["add"]);
        $block2->paletteScript(1, "remove", "../meetings/deletefiles.php?project=" . $projectDetail->pro_id[0] . "&meeting=" . $meetingDetail->mee_id[0] . "", "false,true,true", $strings["delete"]);
        if ($sitePublish == "true") {
            $block2->paletteScript(2, "add_projectsite", "../meetings/viewmeeting.php?addToSiteFile=true&meeting=" . $meetingDetail->mee_id[0] . "&action=publish", "false,true,true", $strings["add_project_site"]);
            $block2->paletteScript(3, "remove_projectsite", "../meetings/viewmeeting.php?removeToSiteFile=true&meeting=" . $meetingDetail->mee_id[0] . "&action=publish", "false,true,true", $strings["remove_project_site"]);
        } 
    } 
    $block2->paletteScript(4, "info", "../meetings/viewfile.php?", "false,true,false", $strings["view"]);
    if ($teamMember == "true" || $_SESSION['profilSession'] == "5") {
        $block2->paletteScript(5, "edit", "../meetings/viewfile.php?edit=true", "false,true,false", $strings["edit"]);
    } 
    $block2->closePaletteScript($comptListFiles, $listAttachments->mat_id);
} 

require_once("../themes/" . THEME . "/footer.php");

?>
