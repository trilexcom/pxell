<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewuser.php,v 1.6 2004/12/16 17:10:34 pixtur Exp $
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

if ($userDetail->mem_profil[0] == "3") {
    header("Location: ../users/viewclientuser.php?id=$id&organization=" . $userDetail->mem_organization[0]);
    exit;
} 

if ($comptUserDetail == "0") {
    header("Location: ../users/listusers.php?msg=blankUser");
    exit;
}

//--- header ---
$breadcrumbs[]= buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../users/listusers.php?", $strings["user_management"], LINK_INSIDE);
$breadcrumbs[]= $userDetail->mem_login[0];

$pageSection='clients';
$pageTitle='<span class="type">'. $strings["user_profile"] .'</span><br><span class="name">'.$userDetail->mem_name[0].'</span>';
require_once("../themes/" . THEME . "/header.php");


//--- content -----
$block1 = new block();

$block1->form = "userD";
$block1->openForm("../users/viewuser.php#" . $block1->form . "Anchor");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingToggle($strings["user_profile"]);

$block1->openPaletteIcon();
if ($_SESSION['profilSession'] == "0") {
    if ($id != "1" && $id != "2") {
        $block1->paletteIcon(0, "remove", $strings["delete"]);
    }
    $block1->paletteIcon(1, "edit", $strings["edit"]);
}
$block1->paletteIcon(2, "export", $strings["export"]);
$block1->closePaletteIcon();

$block1->openContent();
$block1->contentTitle($strings["user_details"]);

$block1->contentRow($strings["user_name"], $userDetail->mem_login[0]);
$block1->contentRow($strings["full_name"], $userDetail->mem_name[0]);
$block1->contentRow($strings["title"], $userDetail->mem_title[0]);
$block1->contentRow($strings["email"], buildLink($userDetail->mem_email_work[0], $userDetail->mem_email_work[0], LINK_MAIL));
$block1->contentRow($strings["work_phone"], $userDetail->mem_phone_work[0]);
$block1->contentRow($strings["home_phone"], $userDetail->mem_phone_home[0]);
$block1->contentRow($strings["mobile_phone"], $userDetail->mem_mobile[0]);
$block1->contentRow($strings["fax"], $userDetail->mem_fax[0]);

if ($userDetail->mem_profil[0] == "0") {
    $permission = $strings["administrator_permissions"];
} else if ($userDetail->mem_profil[0] == "1") {
    $permission = $strings["project_manager_permissions"];
} else if ($userDetail->mem_profil[0] == "2") {
    $permission = $strings["user_permissions"];
} else if ($userDetail->mem_profil[0] == "4") {
    $permission = $strings["disabled_permissions"];
} else if ($userDetail->mem_profil[0] == "5") {
    $permission = $strings["project_manager_administrator_permissions"];
}
$block1->contentRow($strings["permissions"], $permission);

$block1->contentRow($strings["comments"], nl2br($userDetail->mem_comments[0]));
$block1->contentRow($strings["account_created"], createDate($userDetail->mem_created[0], $_SESSION['timezoneSession']));

$block1->contentTitle($strings["information"]);

$tmpquery = "SELECT tea.id FROM " . $tableCollab["teams"] . " tea LEFT OUTER JOIN " . $tableCollab["projects"] . " pro ON pro.id = tea.project WHERE tea.member = '" . $userDetail->mem_id[0] . "' AND pro.status IN(0,2,3)";
compt($tmpquery);
$valueProjects = $countEnregTotal;

$tmpquery = "SELECT tas.id FROM " . $tableCollab["tasks"] . " tas LEFT OUTER JOIN " . $tableCollab["projects"] . " pro ON pro.id = tas.project WHERE tas.assigned_to = '" . $userDetail->mem_id[0] . "' AND tas.status IN(0,2,3) AND pro.status IN(0,2,3)";
compt($tmpquery);
$valueTasks = $countEnregTotal;

$tmpquery = "SELECT note.id FROM " . $tableCollab["notes"] . " note LEFT OUTER JOIN " . $tableCollab["projects"] . " pro ON pro.id = note.project WHERE note.owner = '" . $userDetail->mem_id[0] . "' AND pro.status IN(0,2,3)";
compt($tmpquery);
$valueNotes = $countEnregTotal;

$block1->contentRow($strings["projects"], $valueProjects);
$block1->contentRow($strings["tasks"], $valueTasks);
$block1->contentRow($strings["notes"], $valueNotes);

if ($userDetail->mem_log_connected[0] > $dateunix-5 * 60) {
    $connected_result = $strings["yes"] . " " . $z;
} else {
    $connected_result = $strings["no"];
}
$block1->contentRow($strings["connected"], $connected_result);

$block1->closeContent();
$block1->closeToggle();
$block1->closeForm();

$block1->openPaletteScript();
if ($_SESSION['profilSession'] == "0") {
    if ($id != "1" && $id != "2") {
        $block1->paletteScript(0, "remove", "../users/deleteusers.php?id=$id", "true,true,true", $strings["delete"]);
    }
    $block1->paletteScript(1, "edit", "../users/edituser.php?id=$id", "true,true,true", $strings["edit"]);
}
$block1->paletteScript(2, "export", "../users/exportuser.php?id=$id", "true,true,true", $strings["export"]);
$block1->closePaletteScript("", "");

require_once("../themes/" . THEME . "/footer.php");

?>