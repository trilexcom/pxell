<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: header.php,v 1.1.1.1 2004/11/02 03:30:20 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

if ($use_compression == 1) ob_start("ob_gzhandler");

$themepath = "modules/themes/" . $themes_list->get_dir($userdata['theme']) . "/";
require_once($themepath . "index.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title><?php echo $sitename;
?></title>
	<link href="<?php echo $themepath;
?>style.css" rel="stylesheet" type="text/css">
</head>
<?php
$theme->header();

?>
