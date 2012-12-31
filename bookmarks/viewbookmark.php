<?php // $Revision: 1.7 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: viewbookmark.php,v 1.7 2004/12/17 10:56:29 pixtur Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = true;
require_once('../includes/library.php');

if ($action == 'publish') {
    if ($addToSite == 'true') {
        $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='0' WHERE id = '$id'";
        connectSql($tmpquery1);
        $msg = 'addToSite';
    } 

    if ($removeToSite == 'true') {
        $tmpquery1 = 'UPDATE ' . $tableCollab['notes'] . " SET published='1' WHERE id = '$id'";
        connectSql($tmpquery1);
        $msg = 'removeToSite';
    } 
} 

$tmpquery = "WHERE boo.id = '$id'";
$bookmarkDetail = new request();
$bookmarkDetail->openBookmarks($tmpquery);

if ($bookmarkDetail->boo_users[0] != '') {
    $pieces = explode('|', $bookmarkDetail->boo_users[0]);
    $comptPieces = count($pieces);
    $private = 'false';

    for ($i = 0;$i < $comptPieces;$i++) {
        if ($_SESSION['idSession'] == $pieces[$i]) {
            $private = 'true';
        } 
    } 
} 

if (($bookmarkDetail->boo_users[0] == '' && $bookmarkDetail->boo_owner[0] != $_SESSION['idSession'] && $bookmarkDetail->boo_shared[0] == '0') || ($private == 'false' && $bookmarkDetail->boo_owner[0] != $_SESSION['idSession'])) {
    header('Location: ../bookmarks/listbookmarks.php?view=my&msg=bookmarkOwner');
    exit;
} 



//--- header ---
$breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=' . $view, $strings['bookmarks'], LINK_INSIDE);
$breadcrumbs[]=$bookmarkDetail->boo_name[0];

$pageSection = 'bookmarks';
require_once('../themes/' . THEME . '/header.php');


//--- content ---
$block1 = new block();
$block1->form = 'tdD';
$block1->openForm('../bookmarks/viewbookmark.php#' . $block1->form . 'Anchor');
$block1->heading($strings['bookmark'] . ' : ' . $bookmarkDetail->boo_name[0]);

if ($bookmarkDetail->boo_owner[0] == $_SESSION['idSession']) {
    $block1->openPaletteIcon();
    $block1->paletteIcon(0, 'remove', $strings['delete']);

    /*if ($sitePublish == "true") {
		$block1->paletteIcon(2,"add_projectsite",$strings["add_project_site"]);
		$block1->paletteIcon(3,"remove_projectsite",$strings["remove_project_site"]);
	}*/

    $block1->paletteIcon(4, 'edit', $strings['edit']);
    $block1->closePaletteIcon();
}
else {
	$block1->heading_close();
}

$block1->openContent();
$block1->contentTitle($strings['info']);

$block1->contentRow($strings['name'], $bookmarkDetail->boo_name[0]);
$block1->contentRow($strings['url'], buildLink($bookmarkDetail->boo_url[0], $bookmarkDetail->boo_url[0], LINK_OUT));
$block1->contentRow($strings['description'], nl2br($bookmarkDetail->boo_description[0]));

$block1->closeContent();
$block1->block_close();
$block1->closeForm();

if ($bookmarkDetail->boo_owner[0] == $_SESSION['idSession']) {
    $block1->openPaletteScript();
    $block1->paletteScript(0, 'remove', '../bookmarks/deletebookmarks.php?id=' . $bookmarkDetail->boo_id[0], 'true,true,false', $strings['delete']);
    /*if ($sitePublish == "true") {
		$block1->paletteScript(2,"add_projectsite","../bookmarks/viewbookmark.php?addToSite=true&id=".$noteDetail->note_id[0]."&action=publish","true,true,true",$strings["add_project_site"]);
		$block1->paletteScript(3,"remove_projectsite","../bookmarks/viewbookmark.php?removeToSite=true&id=".$noteDetail->note_id[0]."&action=publish","true,true,true",$strings["remove_project_site"]);
	}*/
    $block1->paletteScript(4, 'edit', '../bookmarks/editbookmark.php?id=' . $bookmarkDetail->boo_id[0], 'true,true,false', $strings['edit']);
    $block1->closePaletteScript('', '');
}


require_once('../themes/' . THEME . '/footer.php');

?>