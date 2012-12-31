<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewservice.php,v 1.4 2004/12/15 19:43:37 madbear Exp $
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

$tmpquery = "WHERE serv.id = '$id'";
$detailService = new request();
$detailService->openServices($tmpquery);
$comptDetailService = count($detailService->serv_id);

//--- header ---
$breadcrumbs[]=buildLink("../administration/admin.php?", $strings["administration"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../services/listservices.php?", $strings["service_management"], LINK_INSIDE);
$breadcrumbs[]=$detailService->serv_name[0];

$pageSection = 'admin';
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "serviceD";
$block1->openForm("../services/viewservice.php#" . $block1->form . "Anchor");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->heading($strings["service"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "remove", $strings["delete"]);
$block1->paletteIcon(1, "edit", $strings["edit"]);
$block1->closePaletteIcon();

$block1->openContent();
$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["name"], $detailService->serv_name[0]);
$block1->contentRow($strings["name_print"], $detailService->serv_name_print[0]);
$block1->contentRow($strings["hourly_rate"], $detailService->serv_hourly_rate[0]);

$block1->closeContent();
$block1->closeForm();

$block1->openPaletteScript();
$block1->paletteScript(0, "remove", "../services/deleteservices.php?id=$id", "true,true,true", $strings["delete"]);
$block1->paletteScript(1, "edit", "../services/editservice.php?id=$id", "true,true,true", $strings["edit"]);
$block1->closePaletteScript("", "");

require_once("../themes/" . THEME . "/footer.php");

?>
