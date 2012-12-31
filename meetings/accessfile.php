<?php // $Revision: 1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: accessfile.php,v 1.1 2004/12/06 06:15:46 luiswang Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

$tmpquery = "WHERE mat.id = '$id'";
$fileDetail = new request();
$fileDetail->openMeetingsAttachment($tmpquery);

// serve the requested file
require_once('../meetings/download.php');

?>
