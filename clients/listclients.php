<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listclients.php,v 1.6 2004/12/15 19:43:32 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');



//--- header ---
$breadcrumbs[]= buildLink('../clients/listclients.php?', $strings['clients'], LINK_INSIDE);
$breadcrumbs[]= $strings['organizations'];
$pageSection='clients';
require_once('../themes/' . THEME . '/header.php');

//--- content ---
$blockPage= new block();
$blockPage->bornesNumber = '1';

$block1 = new block();

$block1->form = 'clientList';
$block1->openForm('../clients/listclients.php#' . $block1->form . 'Anchor');

$block1->heading($strings['organizations']);

$block1->openPaletteIcon();

if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
    $block1->paletteIcon(0, 'add', $strings['add']);
    $block1->paletteIcon(1, 'remove', $strings['delete']);
}

$block1->paletteIcon(2, 'info', $strings['view']);

if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
    $block1->paletteIcon(3, 'edit', $strings['edit']);
}

$block1->closePaletteIcon();

$block1->borne = $blockPage->returnBorne('1');
$block1->rowsLimit = '20';

$block1->sorting('organizations', $sortingUser->sor_organizations[0], 'org.name ASC', $sortingFields = array(0 => 'org.name', 1 => 'org.phone', 2 => 'org.url'));

if ($clientsFilter == 'true' && $_SESSION['profilSession'] == '2') {
    $teamMember = 'false';
    $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "'";
    $memberTest = new request();
    $memberTest->openTeams($tmpquery);
    $comptMemberTest = count($memberTest->tea_id);

    if ($comptMemberTest == '0') {
        $listClients = 'false';
    } else {
        for ($i = 0; $i < $comptMemberTest; $i++) {
            $clientsOk .= $memberTest->tea_org2_id[$i];

            if ($comptMemberTest - 1 != $i) {
                $clientsOk .= ',';
            }
        }

        if ($clientsOk == '') {
            $listClients = 'false';
        } else {
            $tmpquery = "WHERE org.id IN($clientsOk) AND org.id != '1' ORDER BY $block1->sortingValue";
        }
    }
} else if ($clientsFilter == 'true' && $_SESSION['profilSession'] == '1') {
    $tmpquery = "WHERE org.owner = '" . $_SESSION['idSession'] . "' AND org.id != '1' ORDER BY $block1->sortingValue";
} else {
    $tmpquery = "WHERE org.id != '1' ORDER BY $block1->sortingValue";
}

$block1->recordsTotal = compt($initrequest['organizations'] . ' ' . $tmpquery);

if ($listClients != 'false') {
    $listOrganizations = new request();
    $listOrganizations->openOrganizations($tmpquery, $block1->borne, $block1->rowsLimit);
    $comptListOrganizations = count($listOrganizations->org_id);
} else {
    $comptListOrganizations = 0;
}

if ($comptListOrganizations != '0') {
    $block1->openResults();
    $block1->labels($labels = array(0 => $strings['name'], 1 => $strings['phone'], 2 => $strings['url']), 'false');

    for ($i = 0; $i < $comptListOrganizations; $i++) {
        $block1->openRow($listOrganizations->org_id[$i]);
        $block1->checkboxRow($listOrganizations->org_id[$i]);
        $block1->cellRow(buildLink('../clients/viewclient.php?id=' . $listOrganizations->org_id[$i], $listOrganizations->org_name[$i], LINK_INSIDE));
        $block1->cellRow($listOrganizations->org_phone[$i]);
        $block1->cellRow(buildLink($listOrganizations->org_url[$i], $listOrganizations->org_url[$i], LINK_OUT));
        $block1->closeRow();
    }

    $block1->closeResults();
    $block1->bornesFooter("1", $blockPage->bornesNumber, "", "");
} else {
    $block1->noresults();
}

$block1->headingForm_close();
$block1->closeFormResults();

$block1->openPaletteScript();

if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
    $block1->paletteScript(0, 'add', '../clients/editclient.php?', 'true,false,false', $strings['add']);
    $block1->paletteScript(1, 'remove', '../clients/deleteclients.php?', 'false,true,true', $strings['delete']);
}

$block1->paletteScript(2, 'info', '../clients/viewclient.php?', 'false,true,false', $strings['view']);

if ($_SESSION['profilSession'] == '0' || $_SESSION['profilSession'] == '1' || $_SESSION['profilSession'] == '5') {
    $block1->paletteScript(3, 'edit', '../clients/editclient.php?', 'false,true,false', $strings['edit']);
} 
$block1->closePaletteScript($comptListOrganizations, $listOrganizations->org_id);

require_once('../themes/' . THEME . '/footer.php');

?>
