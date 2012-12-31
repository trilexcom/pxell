<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: systemrequirements.php,v 1.6 2004/12/17 00:55:21 madbear Exp $
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

$pageSection='requirements';

$notLogged = true;
require_once('../themes/' . THEME . '/header.php');


$block1 = new block();
$block1->headingForm('NetOffice : ' . $strings['requirements']);

$block1->openContent();
$block1->contentTitle($strings['requirements']);

$block1->contentRow('ALL', '- Cookie and JavaScript Support must be enabled');
$block1->contentRow('Windows', '- FireFox >= 1.x<br/>- Internet Explorer >= 5.x<br/>');
$block1->contentRow('Macintosh', '- FireFox >= 1.x<br/>- Internet Explorer >= 5.x<br/>');
$block1->contentRow('Linux', '- FireFox >= 1.x');

$block1->closeContent();
$block1->headingForm_close();


require_once('../themes/' . THEME . '/footer.php');

?>
