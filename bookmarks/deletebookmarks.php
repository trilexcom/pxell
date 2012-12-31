<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletebookmarks.php,v 1.5 2004/12/15 12:25:17 pixtur Exp $
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

if ($action == 'delete') {
    $id = str_replace('**', ',', $id);
    $tmpquery1 = 'DELETE FROM ' . $tableCollab['bookmarks'] . ' WHERE id IN(' . $id . ')';
    connectSql($tmpquery1);
    header('Location: ../bookmarks/listbookmarks.php?view=my&msg=delete');
    exit;
} 



//--- header ---
$breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=all', $strings['bookmarks'], LINK_INSIDE);
$breadcrumbs[]=$strings['delete_bookmarks'];

$pageSection = 'bookmarks';
require_once('../themes/' . THEME . '/header.php');

//--- content ------
$block1 = new block();
$block1->form = 'saP';
$block1->openForm('../bookmarks/deletebookmarks.php?action=delete&amp;id=' . $id);

$block1->headingForm($strings['delete_bookmarks']);

$block1->openContent();
$block1->contentTitle($strings['delete_following']);

$id = str_replace('**', ',', $id);
$tmpquery = 'WHERE boo.id IN(' . $id . ') ORDER BY boo.name';
$listBookmarks = new request();
$listBookmarks->openBookmarks($tmpquery);
$comptListBookmarks = count($listBookmarks->boo_id);

for ($i = 0;$i < $comptListBookmarks;$i++) {
    $block1->contentRow('#' . $listBookmarks->boo_id[$i], $listBookmarks->boo_name[$i]);
} 

$block1->contentRow('', '<input type="submit" name="delete" value="' . $strings['delete'] . '"> <input type="button" name="cancel" value="' . $strings['cancel'] . '" onClick="history.back();">');

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
