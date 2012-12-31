<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listservices.php,v 1.5 2004/12/15 19:43:37 madbear Exp $
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

//--- header ---
$breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
$breadcrumbs[]=$strings["service_management"];

$pageSection = 'admin';
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "servList";
$block1->openForm("../services/listservices.php#" . $block1->form . "Anchor");

$block1->heading($strings["service_management"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->paletteIcon(2, "info", $strings["view"]);
$block1->paletteIcon(3, "edit", $strings["edit"]);
$block1->closePaletteIcon();

$tmpquery = "ORDER BY serv.name ASC";
$listServices = new request();
$listServices->openServices($tmpquery);
$comptListServices = count($listServices->serv_id);

if ($comptListServices != "0") {
    $block1->openResults();

    $block1->labels($labels = array(0 => $strings["name"], 1 => $strings["hourly_rate"]), "false", $sorting = "false", $sortingOff = array(0 => "0", 1 => "ASC"));

    for ($i = 0;$i < $comptListServices;$i++) {
        $block1->openRow($listServices->serv_id[$i]);
        $block1->checkboxRow($listServices->serv_id[$i]);
        $block1->cellRow(buildLink("../services/viewservice.php?id=" . $listServices->serv_id[$i], $listServices->serv_name[$i], LINK_INSIDE));
        $block1->cellRow($listServices->serv_hourly_rate[$i]);
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../services/editservice.php?", "true,true,true", $strings["add"]);
$block1->paletteScript(1, "remove", "../services/deleteservices.php?", "false,true,true", $strings["delete"]);
$block1->paletteScript(2, "info", "../services/viewservice.php?", "false,true,false", $strings["view"]);
$block1->paletteScript(3, "edit", "../services/editservice.php?", "false,true,false", $strings["edit"]);
$block1->closePaletteScript($comptListServices, $listServices->serv_id);

require_once("../themes/" . THEME . "/footer.php");

?>
