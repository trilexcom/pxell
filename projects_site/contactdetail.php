<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: contactdetail.php,v 1.2 2004/12/22 22:16:31 madbear Exp $
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

$tmpquery = "WHERE tea.project = '" . $_SESSION['projectSession'] . "' AND tea.member = '$id'";
$detailContact = new request();
$detailContact->openTeams($tmpquery);

if ($detailContact->tea_published[0] == "1" || $detailContact->tea_project[0] != $_SESSION['projectSession']) {
    header("Location: index.php");
} 

$bouton[1] = "over";
$titlePage = $strings["team_member_details"];
require_once ("include_header.php");

echo "<h1 class=\"heading\">" . $strings["team_member_details"] . "</h1>";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";

if ($userDetail->mem_name[0] != "") {
    echo "<tr><td>" . $strings["full_name"] . " :</td><td>" . $userDetail->mem_name[0] . "</td></tr>";
} 
if ($userDetail->mem_organization[0] != "") {
    echo "<tr><td>" . $strings["company"] . " :</td><td>" . $userDetail->mem_org_name[0] . "</td></tr>";
} 
if ($userDetail->mem_title[0] != "") {
    echo "<tr><td>" . $strings["title"] . " :</td><td>" . $userDetail->mem_title[0] . "</td></tr>";
} 
if ($userDetail->mem_email_work[0] != "") {
    echo "<tr><td>" . $strings["email"] . " : </td><td><a href=\"mailto:" . $userDetail->mem_email_work[0] . "\">" . $userDetail->mem_email_work[0] . "</a></td></tr>";
} 
if ($userDetail->mem_phone_home[0] != "") {
    echo "<tr><td>" . $strings["home_phone"] . " :</td><td>" . $userDetail->mem_phone_home[0] . "</td></tr>";
} 
if ($userDetail->mem_phone_work[0] != "") {
    echo "<tr><td>" . $strings["work_phone"] . " : </td><td>" . $userDetail->mem_phone_work[0] . "</td></tr>";
} 
if ($userDetail->mem_mobile[0] != "") {
    echo "<tr><td>" . $strings["mobile_phone"] . " :</td><td>" . $userDetail->mem_mobile[0] . "</td></tr>";
} 
if ($userDetail->mem_fax[0] != "") {
    echo "<tr><td> " . $strings["fax"] . " :</td><td>" . $userDetail->mem_fax[0] . "</td></tr>";
} 
echo "</table>
<hr>";

echo "<br><br>
<a href=\"showallcontacts.php\">" . $strings["show_all"] . "</a>";

require_once ("include_footer.php");

?>
