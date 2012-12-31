<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: sheet_toggle_icons.php,v 1.4 2004/12/13 00:18:22 madbear Exp $
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

$id = $_GET['id'];

$tmpquery = "WHERE org.id = '$id'";
$clientDetail = new request();
$clientDetail->openOrganizations($tmpquery);
$comptClientDetail = count($clientDetail->org_id);

if ($comptClientDetail == "0") {
    header('Location: ../clients/listclients.php?msg=blankClient');
    exit;
} 




//--- header ---
$breadcrumbs[]=buildLink("../clients/listclients.php?", $strings["organizations"], LINK_INSIDE);
$breadcrumbs[]=$strings["organizations"];

//--- content ----
require_once("../themes/" . THEME . "/header.php");


$block1 = new block();

$block1->form = "ecD";
$block1->openForm("../projects/listprojects.php#" . $block1->form . "Anchor");

$block1->headingToggle($strings["organization"] . " : " . $clientDetail->org_name[0]);

$block1->openPaletteIcon();
$block1->paletteIcon(0, "remove", $strings["delete"]);
$block1->paletteIcon(1, "edit", $strings["edit"]);
$block1->closePaletteIcon();

$block1->openContent();
$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["name"], $clientDetail->org_name[0]);
$block1->contentRow($strings["address"], $clientDetail->org_address1[0]);
$block1->contentRow($strings["phone"], $clientDetail->org_phone[0]);
$block1->contentRow($strings["url"], buildLink($clientDetail->org_url[0], $clientDetail->org_url[0], LINK_OUT));
$block1->contentRow($strings["email"], buildLink($clientDetail->org_email[0], $clientDetail->org_email[0], LINK_MAIL));

$block1->contentTitle($strings["details"]);

$block1->contentRow($strings["comments"], nl2br($clientDetail->org_comments[0]));
$block1->contentRow($strings["created"], createDate($clientDetail->org_created[0], $_SESSION['timezoneSession']));

$block1->closeContent();
$block1->closeToggle();
$block1->closeForm();

$block1->openPaletteScript();
$block1->paletteScript(0, "remove", "../clients/deleteclients.php?id=" . $clientDetail->org_id[0] . "", "true,true,false", $strings["delete"]);
$block1->paletteScript(1, "edit", "../clients/editclient.php?id=" . $clientDetail->org_id[0] . "", "true,true,false", $strings["edit"]);
$block1->closePaletteScript("", "");

require_once("../themes/" . THEME . "/footer.php");

?>
