<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deleteclientusers.php,v 1.5 2005/01/20 16:41:58 madbear Exp $
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

// these user levels can't perform this action
if ( ($_SESSION['profilSession'] == 4) || ($_SESSION['profilSession'] == 3) || 
     ($_SESSION['profilSession'] == 2) ) {
    header("Location: ../general/home.php?msg=permissiondenied");
    exit;
}

$tmpquery = "WHERE org.id = '$organization'";
$detailOrganization = new request();
$detailOrganization->openOrganizations($tmpquery);
$comptDetailOrganization = count($detailOrganization->org_id);

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["members"] . " WHERE id IN($id)";
    $tmpquery2 = "UPDATE " . $tableCollab["tasks"] . " SET assigned_to='$at' WHERE assigned_to IN($id)";
    $tmpquery3 = "UPDATE " . $tableCollab["assignments"] . " SET assigned_to='$at',assigned='$dateheure' WHERE assigned_to IN($id)";
    $tmpquery4 = "DELETE FROM " . $tableCollab["notifications"] . " WHERE member IN($id)";
    $tmpquery5 = "DELETE FROM " . $tableCollab["teams"] . " WHERE member IN($id)";
    connectSql("$tmpquery1");
    connectSql("$tmpquery2");
    connectSql("$tmpquery3");
    connectSql("$tmpquery4");
    connectSql("$tmpquery5");
    // if mantis bug tracker enabled
    if ($enableMantis == "true") {
        // Call mantis function to remove user
        require_once ("../mantis/user_delete.php");
    } 

    header("Location: ../clients/viewclient.php?id=$organization&msg=delete");
    exit;
} 

//--- header ---
$breadcrumbs[]= buildLink("../clients/listclients.php?", $strings["clients"], LINK_INSIDE);
$breadcrumbs[]= buildLink("../clients/viewclient.php?id=" . $detailOrganization->org_id[0], $detailOrganization->org_name[0], LINK_INSIDE);
$breadcrumbs[]= $strings["delete_users"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---

$block1 = new block();

$block1->form = "client_user_delete";
$block1->openForm("../users/deleteclientusers.php?organization=$organization&amp;action=delete");

$block1->headingForm($strings["delete_users"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE mem.id IN($id) ORDER BY mem.name";

$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

for ($i = 0;$i < $comptListMembers;$i++) {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $listMembers->mem_login[$i] . "&nbsp;(" . $listMembers->mem_name[$i] . ")</td></tr>";
} 

$tmpquery = "SELECT tas.id FROM " . $tableCollab["tasks"] . " tas WHERE tas.assigned_to IN($id)";
compt($tmpquery);
$totalTasks = $countEnregTotal;

$block1->contentTitle($strings["reassignment_clientuser"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td>" . $strings["there"] . " $totalTasks " . $strings["tasks"] . " " . $strings["owned_by"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><b>" . $strings["reassign_to"] . " : </b> ";

$tmpquery = "WHERE mem.profil != '3' ORDER BY mem.name";
$reassign = new request();
$reassign->openMembers($tmpquery);
$comptReassign = count($reassign->mem_id);

echo "<select name=\"at\">
<option value=\"0\" selected>" . $strings["unassigned"] . "</option>";

for ($i = 0;$i < $comptReassign;$i++) {
    echo "<option value=\"" . $reassign->mem_id[$i] . "\">" . $reassign->mem_login[$i] . " / " . $reassign->mem_name[$i] . "</option>";
} 

echo "</select></td></tr>

<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\"><input type=\"hidden\" value=\"$id\" name=\"id\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
