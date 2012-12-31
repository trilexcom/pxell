<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listusers.php,v 1.8 2004/12/15 19:43:40 madbear Exp $
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



if ($_SESSION['profilSession'] != "0") {
    header("Location: ../general/permissiondenied.php");
    exit;
} 

$breadcrumbs[]= buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
$breadcrumbs[]= $strings["user_management"];

require_once("../themes/" . THEME . "/header.php");


//--- content -----
$block1 = new block();

$block1->form = "ulU";
$block1->openForm("../users/listusers.php#" . $block1->form . "Anchor");

$block1->heading($strings["user_management"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->paletteIcon(2, "info", $strings["view"]);
$block1->paletteIcon(3, "edit", $strings["edit"]);
$block1->paletteIcon(4, "email", $strings["email"]);
$block1->closePaletteIcon();

$block1->sorting("users", $sortingUser->sor_users[0], "mem.name ASC", $sortingFields = array(0 => "mem.name", 1 => "mem.login", 2 => "mem.email_work", 3 => "mem.profil", 4 => "log.connected"));

if ($demoMode == true) {
    $tmpquery = "WHERE mem.id != '1' AND mem.profil != '3' ORDER BY $block1->sortingValue";
} else {
    $tmpquery = "WHERE mem.id != '1' AND mem.profil != '3' AND mem.id != '2' ORDER BY $block1->sortingValue";
} 
$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

if ($comptListMembers != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings["full_name"], 1 => $strings["user_name"], 2 => $strings["email"], 3 => $strings["profile"], 4 => $strings["connected"]), "false");

    for ($i = 0;$i < $comptListMembers;$i++) {
        $idProfil = $listMembers->mem_profil[$i];
        $block1->openRow($listMembers->mem_id[$i]);
        $block1->checkboxRow($listMembers->mem_id[$i]);
        $block1->cellRow(buildLink("../users/viewuser.php?id=" . $listMembers->mem_id[$i], $listMembers->mem_name[$i], LINK_INSIDE));
        $block1->cellRow($listMembers->mem_login[$i]);
        $block1->cellRow(buildLink($listMembers->mem_email_work[$i], $listMembers->mem_email_work[$i], LINK_MAIL));
        $block1->cellRow($profil[$idProfil]);
        if ($listMembers->mem_log_connected[$i] > $dateunix-5 * 60) {
            $block1->cellRow($strings["yes"] . " " . $z);
        } else {
            $block1->cellRow($strings["no"]);
        } 
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../users/edituser.php?", "true,true,true", $strings["add"]);
$block1->paletteScript(1, "remove", "../users/deleteusers.php?", "false,true,true", $strings["delete"]);
$block1->paletteScript(2, "info", "../users/viewuser.php?", "false,true,false", $strings["view"]);
$block1->paletteScript(3, "edit", "../users/edituser.php?", "false,true,false", $strings["edit"]);
$block1->paletteScript(4, "email", "../users/emailusers.php?", "false,true,true", $strings["email"]);
$block1->closePaletteScript($comptListMembers, $listMembers->mem_id);

require_once("../themes/" . THEME . "/footer.php");

?>
