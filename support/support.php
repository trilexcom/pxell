<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: support.php,v 1.8 2004/12/20 23:45:00 pixtur Exp $
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

if ($supportType == "team") {
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
} 

if ($enableHelpSupport != "true") {
    header("Location: ../general/permissiondenied.php");
    exit;
} 

if ($supportType == "admin") {
    if ($_SESSION['profilSession'] != "0") {
        header("Location: ../general/permissiondenied.php");
        exit;
    } 
} 

if ($supportType == "team") {
    $tmpquery = "WHERE pro.id = '$project'";
    $requestProject = new request();
    $requestProject->openProjects($tmpquery);
} 



//--- header ---
$pageSection='projects';  
if ($supportType == "team") {
    $breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../projects/viewproject.php?id=" . $requestProject->pro_id[0], $requestProject->pro_name[0], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../support/listrequests.php?id=" . $requestProject->pro_id[0], $strings["support_requests"], LINK_INSIDE);
} else if ($supportType == "admin") {
    $breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
    $breadcrumbs[]=buildLink("../administration/support.php?", $strings["support_management"], LINK_INSIDE);
} 

if ($action == "new") {
    $breadcrumbs[]=$strings["new_requests"];
} 
else if ($action == "open") {
    $breadcrumbs[]=$strings["open_requests"];
} 
else if ($action == "complete") {
    $breadcrumbs[]=$strings["closed_requests"];
} 


require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();
$block1->form = "srs";
$block1->openForm("../support/support.php?action=$action&amp;project=$project#" . $block1->form . "Anchor");

if ($action == "new") {
    $block1->heading($strings["new_requests"]);
} elseif ($action == "open") {
    $block1->heading($strings["open_requests"]);
} elseif ($action == "complete") {
    $block1->heading($strings["closed_requests"]);
} 

if ($teamMember == "true" || $_SESSION['profilSession'] == "0") {
    $block1->openPaletteIcon(); 
    // $block1->paletteIcon(0,"add",$strings["add"]);
    $block1->paletteIcon(1, "edit", $strings["edit_status"]);
    $block1->paletteIcon(2, "remove", $strings["delete"]);
    $block1->paletteIcon(3, "info", $strings["view"]);
    $block1->closePaletteIcon();
} 
else {
	$block1->heading_close();
}
$block1->sorting("support_requests", $sortingUser->sor_support_requests[0], "sr.id ASC", $sortingFields = array(0 => "sr.id", 1 => "sr.subject", 2 => "sr.member", 3 => "sr.project", 4 => "sr.priority", 5 => "sr.status", 6 => "sr.date_open", 7 => "sr.date_close"));

if ($supportType == "team") {
    if ($action == "new") {
        $tmpquery = "WHERE sr.status = '0' AND sr.project = '$project' ORDER BY $block1->sortingValue";
    } elseif ($action == "open") {
        $tmpquery = "WHERE sr.status = '1' AND sr.project = '$project' ORDER BY $block1->sortingValue";
    } elseif ($action == "complete") {
        $tmpquery = "WHERE sr.status = '2' AND sr.project = '$project' ORDER BY $block1->sortingValue";
    } 
} elseif ($supportType == "admin") {
    if ($action == "new") {
        $tmpquery = "WHERE sr.status = '0' ORDER BY $block1->sortingValue";
    } elseif ($action == "open") {
        $tmpquery = "WHERE sr.status = '1' ORDER BY $block1->sortingValue";
    } elseif ($action == "complete") {
        $tmpquery = "WHERE sr.status = '2' ORDER BY $block1->sortingValue";
    } 
} 

if ($action != "" || $action != " ") {
    $listRequests = new request();
    $listRequests->openSupportRequests($tmpquery);
    $comptListRequests = count($listRequests->sr_id);
} 

if ($comptListRequests != "0") {
    $block1->openResults();
    $block1->labels($labels = array(0 => $strings["id"], 1 => $strings["subject"], 2 => $strings["owner"], 3 => $strings["project"], 4 => $strings["priority"], 5 => $strings["status"], 6 => $strings["date_open"], 7 => $strings["date_close"]), "false");

    for ($i = 0;$i < $comptListRequests;$i++) {
        $comptSta = count($requestStatus);
        for ($sr = 0;$sr < $comptSta;$sr++) {
            if ($listRequests->sr_status[$i] == $sr) {
                $currentStatus = $requestStatus[$sr];
            } 
        } 

        $comptPri = count($priority);
        for ($rp = 0;$rp < $comptPri;$rp++) {
            if ($listRequests->sr_priority[$i] == $rp) {
                $requestPriority = $priority[$rp];
            } 
        } 
        $block1->openRow($listRequests->sr_id[$i]);
        $block1->checkboxRow($listRequests->sr_id[$i]);
        $block1->cellRow($listRequests->sr_id[$i]);
        $block1->cellRow(buildLink("../support/viewrequest.php?id=" . $listRequests->sr_id[$i], $listRequests->sr_subject[$i], LINK_INSIDE));
        $block1->cellRow($listRequests->sr_mem_name[$i]);
        $block1->cellRow($listRequests->sr_project[$i]);
        $block1->cellRow($requestPriority);
        $block1->cellRow($currentStatus);
        $block1->cellRow($listRequests->sr_date_open[$i]);
        $block1->cellRow($listRequests->sr_date_close[$i]);
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();
if ($teamMember == "true" || $_SESSION['profilSession'] == "0") {
    $block1->openPaletteScript(); 
    // $block1->paletteScript(0,"add","../support/addpost.php?","false,true,true",$strings["respond"]);
    $block1->paletteScript(1, "edit", "../support/addpost.php?action=status", "false,true,false", $strings["edit_status"]);
    $block1->paletteScript(2, "remove", "../support/deleterequests.php?sendto=$action&action=deleteR", "false,true,true", $strings["delete"]);
    $block1->paletteScript(3, "info", "../support/viewrequest.php?", "false,true,false", $strings["view"]);
    $block1->closePaletteScript($comptListRequests, $listRequests->sr_id);
} 

require_once("../themes/" . THEME . "/footer.php");

?>