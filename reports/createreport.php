<?php // $Revision: 1.8 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: createreport.php,v 1.8 2004/12/23 16:39:19 pixtur Exp $
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

if ($typeReports == '') {
    $typeReports = 'create';
}

//--- header ----
$breadcrumbs[]=$strings['reports'];
if ($typeReports == 'create') {
    $breadcrumbs[]=$strings['create_report'] . ' | ' . buildLink('../reports/createreport.php?typeReports=custom', $strings['custom_reports'], LINK_INSIDE);
} 
else if ($typeReports == 'custom') {
    $breadcrumbs[]=buildLink('../reports/createreport.php?typeReports=create', $strings["create_report"], LINK_INSIDE) . ' | ' . $strings['custom_reports'];
} 

$pageSection = 'reports';
require_once('../themes/' . THEME . '/header.php');

//---- content ------
if ($typeReports == 'create') {
    $block1 = new block();

    $block1->form = "customsearch";
    $block1->openForm("../reports/resultsreport.php");

    $block1->headingForm($strings["create_report"]);

    $block1->openContent();
    $block1->contentTitle($strings["report_intro"]);

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["clients"] . " :</td><td>";

    if ($clientsFilter == "true" && $_SESSION['profilSession'] == "2") {
        $teamMember = "false";
        $tmpquery = "WHERE tea.member = '" . $_SESSION['idSession'] . "'";
        $memberTest = new request();
        $memberTest->openTeams($tmpquery);
        $comptMemberTest = count($memberTest->tea_id);

        if ($comptMemberTest == "0") {
            $listClients = "false";
        } else {
            for ($i = 0;$i < $comptMemberTest;$i++) {
                $clientsOk .= $memberTest->tea_org2_id[$i];

                if ($comptMemberTest-1 != $i) {
                    $clientsOk .= ",";
                }
            }

            if ($clientsOk == "") {
                $listClients = "false";
            } else {
                $tmpquery = "WHERE org.id IN($clientsOk) AND org.id != '1' ORDER BY org.name";
            }
        }
    } else if ($clientsFilter == "true" && $_SESSION['profilSession'] == "1") {
        $tmpquery = "WHERE org.owner = '" . $_SESSION['idSession'] . "' AND org.id != '1' ORDER BY org.name";
    } else {
        $tmpquery = "WHERE org.id != '1' ORDER BY org.name";
    }

    $listOrganizations = new request();
    $listOrganizations->openOrganizations($tmpquery);
    $comptListOrganizations = count($listOrganizations->org_id);

    echo "<select name=\"S_ORGSEL[]\" size=\"4\" multiple><option selected value=\"ALL\">" . $strings["select_all"] . "</option>";

    for ($i = 0;$i < $comptListOrganizations;$i++) {
        echo "<option value=\"" . $listOrganizations->org_id[$i] . "\">" . $listOrganizations->org_name[$i] . "</option>";
    }

    echo "</select></td></tr><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["projects"] . " :</td><td>";

    if ($projectsFilter == "true") {
        $tmpquery = "LEFT OUTER JOIN " . $tableCollab["teams"] . " teams ON teams.project = pro.id ";
        $tmpquery .= "WHERE pro.status IN(0,2,3) AND teams.member = '" . $_SESSION['idSession'] . "' ORDER BY pro.name";
    } else {
        $tmpquery = "WHERE pro.status IN(0,2,3)  ORDER BY pro.name";
    }

    $listProjects = new request();
    $listProjects->openProjects($tmpquery);
    $comptListProjects = count($listProjects->pro_id);

    echo "<select name=\"S_PRJSEL[]\" size=\"4\" multiple><option selected value=\"ALL\">" . $strings["select_all"] . "</option>";

    for ($i = 0;$i < $comptListProjects;$i++) {
        echo "<option value=\"" . $listProjects->pro_id[$i] . "\">" . $listProjects->pro_name[$i] . "</option>";
    }

    echo "</select></td></tr><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["assigned_to"] . " :</td><td>";

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

    echo "</select></td></tr><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["due_date"] . " :</td><td>";

    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
<td width=\"16\" align=\"center\" class=\"infovalue\"><input checked name=S_DUEDATE type=radio value=ALL></td>
<td align=\"left\" width=\"200\">" . $strings["all_dates"] . "</td>
</tr>
<tr>
<td width=\"16\" align=\"center\" class=\"infovalue\"><input  name=S_DUEDATE type=radio value=DATERANGE></td>
<td align=\"left\" width=\"200\">" . $strings["between_dates"] . "</td>
</tr>
</table>
<table border=0 cellpadding=2 cellspacing=0>
<tr><td width=18><img height=8 src=\"../themes/" . THEME . "/spacer.gif\" alt=\"\" width=18></td>
<td class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_SDATE\" id=\"sel1\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_a\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel1\", button:\"trigger_a\" });</script></td>
</tr>
<tr>
<td width=18>&nbsp;" . $strings["and"] . "&nbsp;<TD class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_EDATE\" id=\"sel3\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_b\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel3\", button:\"trigger_b\" });</script></TD>
</tr>
</table>";

    echo "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["complete_date"] . " :</td><td>";

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
<td class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_SDATE2\" id=\"sel5\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_c\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel5\", button:\"trigger_c\" });</script></td>
</tr>
<tr>
<td width=18>&nbsp;" . $strings["and"] . "&nbsp;<TD class=infoValue noWrap><input type=\"text\" style=\"width: 150px;\" name=\"S_EDATE2\" id=\"sel7\" size=\"20\" value=\"\"><button type=\"reset\" id=\"trigger_d\">...</button><script type=\"text/javascript\">Calendar.setup({ inputField:\"sel7\", button:\"trigger_d\" });</script></TD>
</tr>
</table>";

    echo "</td></tr><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td>";

    $comptSta = count($status);

    echo "<select name=\"S_STATSEL[]\" size=\"4\" multiple><option value=\"ALL\" selected>" . $strings["select_all"] . "</option>";

    for ($i = 0;$i < $comptSta;$i++) {
        echo "<option value=\"$i\">$status[$i]</option>";
    } 

    echo "</select></td></tr><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["priority"] . " :</td><td>";

    $comptPri = count($priority);

    echo "<select name=\"S_PRIOSEL[]\" size=\"4\" multiple>
<option value=\"ALL\" selected>" . $strings["select_all"] . "</option>";

    for ($i = 0;$i < $comptPri;$i++) {
        echo "<option value=\"$i\">$priority[$i]</option>";
    } 

    echo "</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"Save\" value=\"" . $strings["create"] . "\"></td></tr>";

    $block1->closeContent();

	$block1->headingForm_close();

    $block1->closeForm();
}
else if ($typeReports == 'custom') {
    $block1 = new block();
    $block1->headingForm($strings['custom_reports']);

    $block1->openContent();
    $block1->contentTitle($strings['custom_report_intro']);

    $block1->contentRow(buildLink('../reports/selectcompleted.php?typeReports=' . $typeReports, $strings['completed_task_report'], LINK_INSIDE), $strings['completed_task_report_desc'], true);

    $block1->contentRow(buildLink('../reports/selecthours.php?typeReports=' . $typeReports, $strings['time_report'], LINK_INSIDE), $strings['time_report_desc'], true);

    $block1->contentRow(buildLink('../reports/overdue.php?typeReports=' . $typeReports, $strings['overdue_tasks'], LINK_INSIDE), $strings['overdue_tasks_desc'], true);

    $block1->contentRow(buildLink('../reports/snapshot.php?typeReports=' . $typeReports, $strings['project_snapshot'], LINK_INSIDE), $strings['project_snapshot_desc'], true);

    $block1->contentRow(buildLink('../reports/phasestatus.php?typeReports=' . $typeReports, $strings['project_phasestatus'], LINK_INSIDE), $strings['project_phasestatus_desc'], true);

//    $block1->contentRow(buildLink('../custom/pending_tasks.php?typeReports=' . $typeReports, $strings['pending_tasks'], LINK_INSIDE), $strings['pending_tasks_desc'], true);
                                                                                             
//    $block1->contentRow(buildLink('../reports/pm_report.php?typeReports=' . $typeReports, $strings['pm_report'], LINK_INSIDE), $strings['pm_report_desc'], true);

    $block1->contentRow(buildLink('../reports/selectru.php?typeReports=' . $typeReports, $strings['resource_usage'], LINK_INSIDE), $strings['resource_usage_desc'], true);

    $block1->contentRow(buildLink('../reports/projectbreakdown.php?typeReports=' . $typeReports, $strings['project_breakdown'], LINK_INSIDE), $strings['project_breakdown_desc'], true);

    $block1->closeContent();
    $block1->headingForm_close();
}

require_once('../themes/' . THEME . '/footer.php');

?>