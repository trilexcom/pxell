<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: index.php,v 1.2 2004/12/12 20:31:54 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

if (file_exists('installation/setup.php') && 
   (!file_exists('includes/settings.php') or filesize('includes/settings.php') <= 1024)) {
    header('Location: installation/setup.php');
    exit;
}

$checkSession = false;
require_once('includes/library.php');

// case session fails
if (isset($_GET['session']) && $_GET['session'] == 'false') {
    header('Location: ' . $base_uri . 'general/login.php?session=false');
} else {
    // default case
    header('Location: ' . $base_uri . 'general/login.php');
}

?>
