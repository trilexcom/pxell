<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: selecthours.php,v 1.4 2005/05/23 06:31:21 juahonen Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * ../reports/selecthours.php
 * 
 * select options for report of hours logged
 * 
 * TODO:
 */

$checkSession = true;
require_once("../includes/library.php");


$breadcrumbs[]=$strings['reports'];
$breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], in) . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);

$pageSection = 'reports';
require_once("../themes/" . THEME . "/header.php");


// start the first block
$block1 = new block();
$block1->form = "xwbT";
$block1->openForm("../reports/hours.php#" . $block1->form . "Anchor");
$block1->openContent();
echo "<table>\n";
echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["loggedby"] . " :</td><td>";

if ($demoMode == true) {
    $tmpquery = "ORDER BY mem.name";
} else {
    $tmpquery = "WHERE mem.id != '2' ORDER BY mem.name";
} 

$listMembers = new request();
$listMembers->openMembers($tmpquery);
$comptListMembers = count($listMembers->mem_id);

echo "<select name=\"S_ATSEL[]\" size=\"4\" multiple><option selected value=\"ALL\">" . $strings["select_all"] . "</option><option value=\"0\">" . $strings["unassigned"] . "</option>";

for ($i = 0;$i < $comptListMembers;$i++) {
    echo "<option value=\"" . $listMembers->mem_id[$i] . "\">" . $listMembers->mem_login[$i];

    if ($listMembers->mem_profil[$i] == "3") {
        echo " (" . $strings["client_user"] . ")";
    } 

    echo "</option>";
} 

echo "</select></td></tr>";

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["organization"] . ":</td><td>";

$listOrganizations = new request();
$listOrganizations->openOrganizations("");
$comptListOrganizations = count($listOrganizations->org_id);

echo "<select name=\"S_ORSEL[]\"><option selected value=\"ALL\">" . $strings["select_all"] . "</option>";

for ($i = 0;$i<$comptListOrganizations;$i++) {
	echo "<option value=\"" . $listOrganizations->org_id[$i] . "\">" . $listOrganizations->org_name[$i] . "</option>";
}

echo "</select></td></tr>";


echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["logtime"] . " :</td><td>";

echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
<td width=\"16\" align=\"center\" class=\"infovalue\"><input checked name=S_COMPLETEDATE type=radio value=ALL></td>
<td align=\"left\" width=\"200\">" . $strings["all_dates"] . "</td>
</tr>
<tr>
<td width=\"16\" align=\"center\" class=\"infovalue\"><input  name=S_COMPLETEDATE type=radio value=DATERANGE></td>
<td align=\"left\" width=\"200\">" . $strings["between_dates"] . "</td>
</tr>
</table>
<table border=0 cellpadding=2 cellspacing=0>
<tr><td width=18><img height=8 src=\"../themes/" . THEME . "/spacer.gif\" alt=\"\" width=18></td>
<td class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_SDATE2\" id=\"sel1\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script></td>
</tr>
<tr>
<td width=18>&nbsp;" . $strings["and"] . "&nbsp;<TD class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_EDATE2\" id=\"sel3\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script></TD>
</tr>
</table>";
// need a submit button
echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"Save\" value=\"" . $strings["create"] . "\"></td></tr>";
echo "</td></tr></table>\n";

$block1->closeContent();
$block1->closeForm();
// close this block
require_once("../themes/" . THEME . "/footer.php");

?>
