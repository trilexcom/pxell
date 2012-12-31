<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: page.php,v 1.3 2004/11/25 13:04:24 pixtur Exp $
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




$breadcrumbs[]=buildLink("../clients/listclients.php?", $strings["organizations"], LINK_INSIDE);
$breadcrumbs[]=$strings["organizations"];
require_once("../themes/" . THEME . "/header.php");

// blocks here
require_once("../themes/" . THEME . "/footer.php");

?>
