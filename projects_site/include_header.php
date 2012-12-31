<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: include_header.php,v 1.7 2005/04/06 01:23:02 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */


//--- validate user-status -----------
if ($_SESSION['projectSession'] != "" && $changeProject != "true") {
    $tmpquery = "WHERE pro.id = '" . $_SESSION['projectSession'] . "'";
    $projectDetail = new request();
    $projectDetail->openProjects($tmpquery);

    $teamMember = "false";
    $tmpquery = "WHERE tea.project = '" . $_SESSION['projectSession'] . "' AND tea.member = '" . $_SESSION['idSession'] . "'";
    $memberTest = new request();
    $memberTest->openTeams($tmpquery);
    $comptMemberTest = count($memberTest->tea_id);
    if ($comptMemberTest == "0") {
        $teamMember = "false";
    } else {
        $teamMember = "true";
    }
    if ($teamMember == "false") {
        header('Location: index.php');
        exit;
    }
}

//--- html-header ---------------------
{

	echo $setDoctype;
	echo $setCopyright;
	echo '
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=$setCharset">
	<meta name="robots" content="none">
	<meta name="description" content="'.$setDescription.'">
	<meta name="keywords" content="'.$setKeywords.'">
	<title>
	';
	echo $setTitle;

	if ($_SESSION['projectSession'] != "" && $changeProject != "true") {
	    echo $projectDetail->pro_name[0];
	}
	if ($_SESSION['projectSession'] == "" || $changeProject == "true") {
	    echo $strings["my_projects"];
	}
	echo "</title>";

	echo '
	<meta http-equiv="Content-Type" content="text/html; charset='.$setCharset.'">
	<script type="text/JavaScript" src="../javascript/jscalendar/calendar.js"></script>
	<script type="text/JavaScript" src="../javascript/jscalendar/lang/calendar-' . $lang . '.js"></script>
	<script type="text/JavaScript" src="../javascript/jscalendar/calendar-setup.js"></script>
	<link rel="stylesheet" href="../themes/' . THEME . '/calendar.css">
	<link rel="stylesheet" href="../themes/' . THEME . '/stylesheet.css">
	</head>
	<body '.$bodyCommand.'>';
}

//--- header -------
/*
echo '<table cellpadding="0" cellspacing="0" border="0"width="100%" background="bg_header.jpg">';
echo '<tr>';
echo '<td align="left">';
echo '<img src="spacer_black.gif" width="1" height="24" border="0">';
echo '</td>';
echo '<td align="right">';
echo '<img src="spacer_black.gif" width="1" height="24" border="0">';
echo '</td>';
echo '</tr>';
echo '</table>';
*/

echo '<table cellpadding=0 cellspacing=0 border=0 height="95%" width="100%">';
echo '<tr><td valign="middle" width="150" bgcolor="#5B7F93" height="75">';
echo '<img src="../themes/' . THEME . '/spacer.gif" width="150" height="75" alt="">';
echo '</td><td bgcolor="#EFEFEF" height="75">&nbsp;&nbsp;&nbsp;<b>';
echo $titlePage;
echo '</b></td></tr>';
echo '<tr><td valign="top" bgcolor="#C4D3DB"><br>';


echo '<!-- menu -->';
echo '<table cellspacing="2" cellpadding="3" border="0">';


for ($i = 0;$i < 7;$i++) {
    if ($bouton[$i] == "") {
        $bouton[$i] = "normal";
    }
}

if ($_SESSION['projectSession'] != "" && $changeProject != "true") {
    echo "<tr><td colspan=2><b>" . $strings["project"] . " :<br>" . $projectDetail->pro_name[0] . "</b></td></tr>
<tr><td><img src=\"ico_arrow_" . $bouton[0] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"home.php\">" . $strings["home"] . "</a></td></tr>
<tr><td><img src=\"ico_arrow_" . $bouton[1] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"showallcontacts.php?\">" . $strings["project_team"] . "</a></td></tr>
<tr><td><img src=\"ico_arrow_" . $bouton[2] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"showallteamtasks.php?\">" . $strings["team_tasks"] . "</a></td></tr>";

    if ($projectDetail->pro_organization[0] != "" && $projectDetail->pro_organization[0] != "1") {
        echo "<tr><td><img src=\"ico_arrow_" . $bouton[3] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"showallclienttasks.php?\">" . $strings["client_tasks"] . "</a></td></tr>";
    }

    if ($fileManagement == "true") {
        echo "<tr><td><img src=\"ico_arrow_" . $bouton[4] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"doclists.php?\">" . $strings["document_list"] . "</a></td></tr>";
    }

    echo "<tr><td><img src=\"ico_arrow_" . $bouton[5] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"showallthreadtopics.php?\">" . $strings["bulletin_board"] . "</a></td></tr>";

    if ($enableHelpSupport == "true") {
        echo"<tr><td><img src=\"ico_arrow_" . $bouton[6] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"showallsupport.php?project=" . $_SESSION['projectSession'] . "\">" . $strings["support"] . "</a></td></tr>";
    }
    // if mantis bug tracker enabled
    if ($enableMantis == "true") {
        require_once("navigation.php");
        echo"<tr><td><img src=\"ico_arrow_" . $bouton[6] . ".gif\" border=\"0\" alt=\"\"></td><td><a href=\"javascript:onClick= document.login.submit();\">" . $strings["bug"] . "</a></td></tr></form>";
    } 

    echo "</table>
<br><hr>";
} 

echo "<table cellspacing=\"2\" cellpadding=\"3\" border=\"0\">
<tr><td><a href=\"home.php?changeProject=true\"><img src=\"ico_folder.gif\" border=\"0\" alt=\"\"></a></td><td><a href=\"home.php?changeProject=true\">" . $strings["my_projects"] . "</a></td></tr>";

echo "
  <tr>
    <td colspan=2>
<br>
    </td>
  </tr>
  <tr>
    <td>
      <a href=\"changepassword.php?changeProject=true\">
      <img src=\"ico_prefs.gif\" border=\"0\" alt=\"\">
      </a>
    </td>
    <td>
      <a href=\"changepassword.php?changeProject=true\">
      " . $strings["preferences"] . "
      </a>
    </td>
  </tr>
  <tr>
    <td colspan=2>
      <br>
    </td>
  </tr>
  <tr>
    <td>
      <a href=\"../general/login.php?logout=true\">
      <img src=\"ico_logout.gif\" border=\"0\" alt=\"\">
      </a>
    </td>
    <td>
      <a href=\"../general/login.php?logout=true\">
      " . $strings["logout"] . "
      </a>
    </td>
  </tr>
</table>
</td>
<td valign=\"top\" width=\"100%\">";

echo "<table cellpadding=20 cellspacing=0 border=0 width=\"100%\"><tr><td width=\"100%\">";

?>