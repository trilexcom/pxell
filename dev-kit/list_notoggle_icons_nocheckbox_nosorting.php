<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: list_notoggle_icons_nocheckbox_nosorting.php,v 1.3 2004/11/25 13:04:24 pixtur Exp $
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




$breadcrumbs[]=buildLink("../clients/listclients.php?", $strings["organizations"], LINK_INSIDE);
$breadcrumbs[]=$strings["organizations"];
require_once("../themes/" . THEME . "/header.php");


$block1 = new block();

$block1->form = "clientList";
$block1->openForm("../clients/listclients.php#" . $block1->form . "Anchor");

$block1->heading($strings["organizations"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$tmpquery = "WHERE org.id != '1' ORDER BY org.url DESC";
$listOrganizations = new request();
$listOrganizations->openOrganizations($tmpquery);
$comptListOrganizations = count($listOrganizations->org_id);

if ($comptListOrganizations != "0") {
    $block1->openResults($checkbox = "false");
    $block1->labels($labels = array(0 => $strings["name"], 1 => $strings["phone"], 2 => $strings["url"]), "false", $sorting = "false", $sortingOff = array(0 => "2", 1 => "DESC"));

    for ($i = 0;$i < $comptListOrganizations;$i++) {
        $block1->openRow();
        $block1->checkboxRow($listOrganizations->org_id[$i], $checkbox = "false");
        $block1->cellRow(buildLink("../clients/viewclient.php?id=" . $listOrganizations->org_id[$i], $listOrganizations->org_name[$i], LINK_INSIDE));
        $block1->cellRow($listOrganizations->org_phone[$i]);
        $block1->cellRow(buildLink($listOrganizations->org_url[$i], $listOrganizations->org_url[$i], LINK_OUT));
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../clients/editclient.php?", "true,false,false", $strings["add"]);
$block1->paletteScript(1, "remove", "../clients/deleteclients.php?", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListOrganizations, $listOrganizations->org_id);

require_once("../themes/" . THEME . "/footer.php");

?>
