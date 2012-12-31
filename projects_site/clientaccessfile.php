<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: clientaccessfile.php,v 1.2 2004/12/22 22:16:31 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

error_reporting(E_ALL);

$checkSession = true;
require_once('../includes/library.php'); // starts session and writes session cache headers

$tmpquery = "WHERE fil.id = '$id'";
$fileDetail = new request();
$fileDetail->openFiles($tmpquery);

// test if file is published and part of the current project
if ($fileDetail->fil_published[0] == "1" || $fileDetail->fil_project[0] != $_SESSION['projectSession']) {
    header('Location: index.php');
    exit;
} 

// serve the requested file
require_once('../includes/download.php');

?>
