<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: list_toggle_icons.php,v 1.3 2004/12/14 15:51:20 pixtur Exp $
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

$block1->headingToggle($strings["organizations"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$block1->sorting("organizations", $sortingUser->sor_organizations[0], "org.name ASC", $sortingFields = array(0 => "org.name", 1 => "org.phone", 2 => "org.url"));

$tmpquery = "WHERE org.id != '1' ORDER BY $block1->sortingValue";
$listOrganizations = new request();
$listOrganizations->openOrganizations($tmpquery);
$comptListOrganizations = count($listOrganizations->org_id);

if ($comptListOrganizations != "0") {
    $block1->openResults();
    $block1->labels($labels = array(0 => $strings["name"], 1 => $strings["phone"], 2 => $strings["url"]), "false");

    for ($i = 0;$i < $comptListOrganizations;$i++) {
        $block1->openRow($listOrganizations->org_id[$i]);
        $block1->checkboxRow($listOrganizations->org_id[$i]);
        $block1->cellRow(buildLink("../clients/viewclient.php?id=" . $listOrganizations->org_id[$i], $listOrganizations->org_name[$i], LINK_INSIDE));
        $block1->cellRow($listOrganizations->org_phone[$i]);
        $block1->cellRow(buildLink($listOrganizations->org_url[$i], $listOrganizations->org_url[$i], LINK_OUT));
        $block1->closeRow();
    } 
    $block1->closeResults();
} else {
    $block1->noresults();
} 
$block1->closeToggle();

$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../clients/editclient.php?", "true,false,false", $strings["add"]);
$block1->paletteScript(1, "remove", "../clients/deleteclients.php?", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListOrganizations, $listOrganizations->org_id);

require_once("../themes/" . THEME . "/footer.php");

?>
