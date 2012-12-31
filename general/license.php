<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: license.php,v 1.7 2004/12/23 16:17:19 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = false;
require_once('../includes/library.php');
$pageSection='license';

$notLogged = true;
require_once('../themes/' . THEME . '/header.php');

$block1 = new block();
$block1->headingForm('NetOffice : License');
$block1->openContent();
$block1->contentTitle('License');
$buf="<div class=license>";
$buf.=recupFile('../docs/copying.txt');
$buf.="</div>";

$block1->contentRow('', $buf  );



$block1->closeContent();
$block1->headingForm_close();

require_once('../themes/' . THEME . '/footer.php');

?>
