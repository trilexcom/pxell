<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: error.php,v 1.6 2004/12/15 12:25:20 pixtur Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

require_once('../includes/settings.php');

$pageSection='login';
$blank = 'true';
require_once('../themes/' . THEME . '/block.class.php');
require_once('../themes/' . THEME . '/header.php');

// language detection
if ($langDefault == '') {
    if (isset($HTTP_ACCEPT_LANGUAGE)) {
        $plng = split(',', $HTTP_ACCEPT_LANGUAGE);
        if (count($plng) > 0) {
            while (list($k, $v) = each($plng)) {
                $k = split(';', $v, 1);
                $k = split('-', $k[0]);
                if (@file_exists('../languages/lang_' . $k[0] . '.php')) {
                    $langDefault = $k[0];
                    break;
                }
                $langDefault = 'en';
            }
        } else {
            $langDefault = 'en';
        }
    } else {
        $langDefault = 'en';
    }
}

require_once('../languages/lang_' . $langDefault . '.php');


$block1 = new block();
$block1->headingForm('NetOffice : Error');

$block1->openContent();

if ($_GET['type'] == 'myserver') {
    if ($databaseType == 'mysql') {
        $block1->contentTitle('MySQL Error');
    }
    $block1->contentRow('', $strings['error_server']);
}

if ($_GET['type'] == 'mydatabase') {
    if ($databaseType == 'mysql') {
        $block1->contentTitle('MySQL Error');
    }
    $block1->contentRow('', $strings['error_database']);
}

if ($_GET['type'] == 'phpversion') {
    $block1->contentTitle('PHP Version Error');
    $block1->contentRow('', $strings['error_phpversion']);
}

$block1->closeContent();
$block1->headingForm_close();

$footerDev = false;
require_once('../themes/' . THEME . '/footer.php');

?>
