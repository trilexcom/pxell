<?php // $Revision: 1.14 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: header.php,v 1.14 2005/05/21 01:56:06 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
/*
 todo (pixtur 2004-11-11)
 - highlight the current $pageSection if defined

*/

//--- page header ---
echo "$setDoctype
$setCopyright
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$setCharset\">
<title>$setTitle</title>
<meta name=\"robots\" content=\"none\">
<meta name=\"description\" content=\"$setDescription\">
<meta name=\"keywords\" content=\"$setKeywords\">
<script type=\"text/Javascript\">
<!--
var gBrowserOK = true;
var gOSOK = true;
var gCookiesOK = true;
var gFlashOK = true;
// -->
</script>
<script type=\"text/javascript\" src=\"../javascript/general.js\"></script>
<script type=\"text/JavaScript\" src=\"../javascript/overlib/overlib.js\"></script>
<script type=\"text/JavaScript\" src=\"../javascript/jscalendar/calendar.js\"></script>
<script type=\"text/JavaScript\" src=\"../javascript/jscalendar/lang/calendar-{$lang}.js\"></script>
<script type=\"text/JavaScript\" src=\"../javascript/jscalendar/calendar-setup.js\"></script>
<link rel=\"stylesheet\" href=\"../themes/" . THEME . "/stylesheet.css\" type=\"text/css\">
<link rel=\"stylesheet\" href=\"../themes/" . THEME . "/calendar/theme.css\" type=\"text/css\">
$headBonus
</head>
<body bgcolor=\"../themes/" . THEME . "/bg_main.gif\" $bodyCommand>";


{

	//--- >> div for mouse-over scripts ---
	echo "<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:1000;\"></div>\n\n";

	//--- pageheader ----
	echo("<table id=pageHeader><tr>");

	//--- client logo ---
	echo("<td>");
	if (!$blank  && $version >= "2.0") {
	    $tmpquery = "WHERE org.id = '1'";
	    $clientHeader = new request();
	    $clientHeader->openOrganizations($tmpquery);
	}
	if (#$blank != "true"
		#&& $version >= "2.0"
		file_exists("../logos_clients/1.". $clientHeader->org_extension_logo[0])
	){
	    #echo "<p id=\"header\">";
	    #echo "<img src=\"../logos_clients/." . $clientHeader->org_extension_logo[0] . "\" border=\"0\" alt=\"" . $clientHeader->org_name[0] . "\">";
	  	echo "<img src=\"../logos_clients/1.". $clientHeader->org_extension_logo[0] ."\" border=\"0\" alt=\"" . $clientHeader->org_name[0] . "\">";
	    #echo "</p>\n\n";
	}
	else {
	    echo('<img src="../themes/deepblue/img/logo_netoffice.gif">');
	}
	echo("</td>");

    //--- account ---
	echo('<td  rowspan="2" id="account">');

    if (!$blank && !$notLogged) {
        echo(
        	#$strings["user"].":".
        	"<nobr><b>" . $_SESSION['nameSession'] . "</b><br>"
        	.'<a href="../general/login.php?logout=true">'. $strings["logout"].'</a><br>'
        	.'<a href="../projects_site/home.php?changeProject=true">'. $strings["go_projects_site"] .'</a>'
			."</nobr>");
    }
    echo("</td>");


	echo("</tr>");
	echo("<tr>");



	//--- topNavigation / sections---
	echo("<td id=navigation><nobr>");
	$sections_shown=array();
	$blockHeader= new block();
    if (defined("INSTALL")) {
        // upgrading, no tabs
    } else {
        if ($notLogged == true) {
        	array_push($sections_shown, 'login','requirements','license');
        }
        else {
        	array_push($sections_shown, 'home','projects','clients', 'reports', 'search', 'calendar', 'bookmarks', 'preferences');

    		//--- admin? ---
            if ($_SESSION['profilSession'] == "0") {
            	array_push($sections_shown, 'admin');
    		}
    	}
    }

	foreach($sections_shown as $nth_section) {
        //--- throw exception if undefined -----
		/*if(!isset($headerSections[$nth_section])) {
			//echo("WARNING: themes/deepblue.php/header.php:  undefined section!: {$nth_section}<br>");
			continue;
		}*/
		//--- current section ---
		if($nth_section == $pageSection) {
			$blockHeader->itemNavigationCurrent($headerSections[$nth_section],  $strings[$nth_section]);
		}
		else {
			$blockHeader->itemNavigation($headerSections[$nth_section],  $strings[$nth_section]);
		}
	}
	echo("</nobr></td>");

    echo("</tr></table>");
}


//--- breadcrumbs ----
{
	if(isset($breadcrumbs) && count($breadcrumbs)) {
        echo "<div id=\"breadcrumbs\">";
        foreach($breadcrumbs as $crump) {
        	echo '<img src="../themes/'. THEME. '/brdcmb_carrat.gif" alt="" align="absmiddle"> '.$crump;
		}
        echo "</div>\n\n";
	}
}


//--- message ----
{
	if ($msg != '') {
    	require_once('../includes/messages.php');
    	$template->messagebox($msgLabel);
	}
}

//--- page Title --------
if(isset($pageTitle) && $pageTitle!='') {
	echo '<div class="pageTitle">'.$pageTitle.'</div>';
}
else {
	echo '<br>';
}



?>
