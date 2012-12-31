<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: list_notoggle_icons_limititems.php,v 1.3 2004/12/14 15:51:20 pixtur Exp $
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

$blockPage= new block();
$blockPage->bornesNumber = "2";

$block1 = new block();

$block1->form = "clientList";
$block1->openForm("../clients/listclients.php#" . $block1->form . "Anchor");

$block1->heading($strings["organizations"]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "add", $strings["add"]);
$block1->paletteIcon(1, "remove", $strings["delete"]);
$block1->closePaletteIcon();

$block1->borne = $blockPage->returnBorne("1");
$block1->rowsLimit = "5";

$block1->sorting("organizations", $sortingUser->sor_organizations[0], "org.name ASC", $sortingFields = array(0 => "org.name", 1 => "org.phone", 2 => "org.url"));

$tmpquery = "WHERE org.id != '1' ORDER BY $block1->sortingValue";

$block1->recordsTotal = compt($initrequest["organizations"] . " " . $tmpquery);

$listOrganizations = new request();
$listOrganizations->openOrganizations($tmpquery, $block1->borne, $block1->rowsLimit);
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

    $block1->bornesFooter("1", $blockPage->bornesNumber, "../dev-kit/list_notoggle_icons_limititems.php?", "project=$project");
} else {
    $block1->noresults();
} 
$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, "add", "../clients/editclient.php?", "true,false,false", $strings["add"]);
$block1->paletteScript(1, "remove", "../clients/deleteclients.php?", "false,true,true", $strings["delete"]);
$block1->closePaletteScript($comptListOrganizations, $listOrganizations->org_id);

$block2 = new block();

$block2->form = "clientList2";
$block2->openForm("../clients/listclients.php#" . $block2->form . "Anchor");

$block2->heading($strings["organizations"]);

$block2->openPaletteIcon();
$block2->paletteIcon(0, "add", $strings["add"]);
$block2->paletteIcon(1, "remove", $strings["delete"]);
$block2->closePaletteIcon();

$block2->borne = $blockPage->returnBorne("2");
$block2->rowsLimit = "1";

$block2->sorting("organizations", $sortingUser->sor_organizations[0], "org.name ASC", $sortingFields = array(0 => "org.name", 1 => "org.phone", 2 => "org.url"));

$tmpquery = "WHERE org.id != '1' ORDER BY $block2->sortingValue";

$block2->recordsTotal = compt($initrequest["organizations"] . " " . $tmpquery);

$listOrganizations2 = new request();
$listOrganizations2->openOrganizations($tmpquery, $block2->borne, $block2->rowsLimit);
$comptlistOrganizations2 = count($listOrganizations2->org_id);

if ($comptlistOrganizations2 != "0") {
    $block2->openResults();
    $block2->labels($labels = array(0 => $strings["name"], 1 => $strings["phone"], 2 => $strings["url"]), "false", $sorting = "false", $sortingOff = array(0 => "2", 1 => "DESC"));

    for ($i = 0;$i < $comptlistOrganizations2;$i++) {
        $block2->openRow();
        $block2->checkboxRow($listOrganizations2->org_id[$i]);
        $block2->cellRow(buildLink("../clients/viewclient.php?id=" . $listOrganizations2->org_id[$i], $listOrganizations2->org_name[$i], LINK_INSIDE));
        $block2->cellRow($listOrganizations2->org_phone[$i]);
        $block2->cellRow(buildLink($listOrganizations2->org_url[$i], $listOrganizations2->org_url[$i], LINK_OUT));
        $block2->closeRow();
    } 
    $block2->closeResults();

    $block2->bornesFooter("2", $blockPage->bornesNumber, "", "project=$project");
} else {
    $block2->noresults();
} 
$block2->closeFormResults();

$block2->openPaletteScript();
$block2->paletteScript(0, "add", "../clients/editclient.php?", "true,false,false", $strings["add"]);
$block2->paletteScript(1, "remove", "../clients/deleteclients.php?", "false,true,true", $strings["delete"]);
$block2->closePaletteScript($comptlistOrganizations2, $listOrganizations2->org_id);

require_once("../themes/" . THEME . "/footer.php");

?>
