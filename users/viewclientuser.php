<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewclientuser.php,v 1.6 2004/12/16 17:10:34 pixtur Exp $
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

$tmpquery = "WHERE mem.id = '$id'";
$userDetail = new request();
$userDetail->openMembers($tmpquery);
$comptUserDetail = count($userDetail->mem_id);

if ($comptUserDetail == "0") {
    header("Location: ../clients/viewclient.php?msg=blankUser&id=$organization");
    exit;
}
$organization = $userDetail->mem_organization[0];

if ($clientsFilter == "true" && $_SESSION['profilSession'] == "2") {
    $teamMember = "false";
    $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "' AND org2.id = '$organization'";
    $memberTest = new request();
    $memberTest->openTeams($tmpquery);
    $comptMemberTest = count($memberTest->tea_id);
    if ($comptMemberTest == "0") {
        header("Location: ../clients/listclients.php?msg=blankClient");
        exit;
    } else {
    }
} else if ($clientsFilter == "true" && $_SESSION['profilSession'] == "1") {
    $tmpquery = "WHERE org.owner = '" . $_SESSION['idSession'] . "' AND org.id = '$organization'";
} else {
    $tmpquery = "WHERE org.id = '$organization'";
}

$comptDetailClient = "0";
$detailClient = new request();
$detailClient->openOrganizations($tmpquery);
$comptDetailClient = count($detailClient->org_id);

if ($comptDetailClient == "0") {
    header("Location: ../clients/listclients.php?msg=blankClient");
    exit;
}

//--- header ------------
$breadcrumbs[]= buildLink("../clients/listclients.php?", $strings["clients"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../clients/viewclient.php?id=$organization", $detailClient->org_name[0], LINK_INSIDE);
$breadcrumbs[]= $userDetail->mem_login[0];


$pageSection='clients';
$pageTitle='<span class="type">'. $strings["client_user"] .'</span><br><span class="name">'.$userDetail->mem_name[0].'</span>';

require_once("../themes/" . THEME . "/header.php");


//--- content ------------
$block1 = new block();

$block1->form = "cuserD";
$block1->openForm("../users/viewclientuser.php#" . $block1->form . "Anchor");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
}

$block1->heading($strings["client_user"]);

$block1->openPaletteIcon();
if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
    $block1->paletteIcon(0, "remove", $strings["delete"]);
    $block1->paletteIcon(1, "edit", $strings["edit"]);
}
$block1->paletteIcon(2, "export", $strings["export"]);
$block1->closePaletteIcon();

$block1->openContent();
$block1->contentTitle($strings["user_details"]);

$block1->contentRow($strings["user_name"], $userDetail->mem_login[0]);
$block1->contentRow($strings["full_name"], $userDetail->mem_name[0]);
$block1->contentRow($strings["organization"], $userDetail->mem_org_name[0]);
$block1->contentRow($strings["email"], $userDetail->mem_email_work[0]);
$block1->contentRow($strings["work_phone"], $userDetail->mem_phone_work[0]);
$block1->contentRow($strings["home_phone"], $userDetail->mem_phone_home[0]);
$block1->contentRow($strings["mobile_phone"], $userDetail->mem_mobile[0]);
$block1->contentRow($strings["fax"], $userDetail->mem_fax[0]);
$block1->contentRow($strings["comments"], nl2br($userDetail->mem_comments[0]));
$block1->contentRow($strings["account_created"], createDate($userDetail->mem_created[0], $_SESSION['timezoneSession']));

$block1->contentTitle($strings["information"]);

$tmpquery = "SELECT tas.id FROM " . $tableCollab["tasks"] . " tas LEFT OUTER JOIN " . $tableCollab["projects"] . " pro ON pro.id = tas.project WHERE tas.assigned_to = '" . $userDetail->mem_id[0] . "' AND tas.status IN(0,2,3) AND pro.status IN(0,2,3)";
compt($tmpquery);
$valueTasks = $countEnregTotal;

$block1->contentRow($strings["tasks"], $valueTasks);

$z = "(Client on project site)";
if ($userDetail->mem_log_connected[0] > $dateunix-5 * 60) {
    $connected_result = $strings["yes"] . " " . $z;
} else {
    $connected_result = $strings["no"];
} 
$block1->contentRow($strings["connected"], $connected_result);

$block1->closeContent();
$block1->closeForm();

$block1->openPaletteScript();
if ($_SESSION['profilSession'] == "0" || $_SESSION['profilSession'] == "1") {
    $block1->paletteScript(0, "remove", "../users/deleteclientusers.php?id=$id&organization=$organization", "true,true,true", $strings["delete"]);
    $block1->paletteScript(1, "edit", "../users/updateclientuser.php?id=$id&organization=$organization", "true,true,true", $strings["edit"]);
} 
$block1->paletteScript(2, "export", "../users/exportuser.php?id=$id", "true,true,true", $strings["export"]);
$block1->closePaletteScript("", "");

require_once("../themes/" . THEME . "/footer.php");

?>