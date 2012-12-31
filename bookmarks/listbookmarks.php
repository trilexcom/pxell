<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: listbookmarks.php,v 1.6 2004/12/15 12:25:18 pixtur Exp $
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


$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);


//--- header ---
$breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=all', $strings['bookmarks'], LINK_INSIDE);

if ($view == 'all') {
    $breadcrumbs[]=$strings['bookmarks_all'] . ' | ' . buildLink('../bookmarks/listbookmarks.php?view=my', $strings['my'], LINK_INSIDE) . ' | ' . buildLink('../bookmarks/listbookmarks.php?view=private', $strings['bookmarks_private'], LINK_INSIDE);
}
else if ($view == 'my') {
    $breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=all', $strings['bookmarks_all'], LINK_INSIDE) . ' | ' . $strings['my'] . ' | ' . buildLink('../bookmarks/listbookmarks.php?view=private', $strings['bookmarks_private'], LINK_INSIDE);
}
else if ($view == 'private') {
    $breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=all', $strings['bookmarks_all'], LINK_INSIDE) . ' | ' . buildLink('../bookmarks/listbookmarks.php?view=my', $strings['my'], LINK_INSIDE) . ' | ' . $strings['bookmarks_private'];
}

$pageSection = 'bookmarks';
require_once('../themes/' . THEME . '/header.php');

//--- content -----
$block1 = new block();
$block1->form = 'saJ';
$block1->openForm('../bookmarks/listbookmarks.php?view=' . $view . '&amp;project=' . $project . '#' . $block1->form . 'Anchor');
$block1->heading($strings['bookmarks']);
$block1->openPaletteIcon();
$block1->paletteIcon(0, 'add', $strings['add']);

if ($view == 'my') {
    $block1->paletteIcon(1, 'remove', $strings['delete']);
}

/*if ($sitePublish == "true") {
	$block1->paletteIcon(3,"add_projectsite",$strings["add_project_site"]);
	$block1->paletteIcon(4,"remove_projectsite",$strings["remove_project_site"]);
}*/

$block1->paletteIcon(5, 'info', $strings['view']);

if ($view == 'my') {
    $block1->paletteIcon(6, 'edit', $strings['edit']);
}

$block1->closePaletteIcon();

if ($view == 'my') {
    $block1->sorting('bookmarks', $sortingUser->sor_bookmarks[0], 'boo.name ASC', $sortingFields = array(0 => 'boo.name', 1 => 'boo.category', 2 => 'boo.shared'));
} else {
    $block1->sorting('bookmarks', $sortingUser->sor_bookmarks[0], 'boo.name ASC', $sortingFields = array(0 => 'boo.name', 1 => 'boo.category', 2 => 'mem.login'));
}

if ($view == 'my') {
    $tmpquery = "WHERE boo.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block1->sortingValue";
} else if ($view == 'private') {
    $tmpquery = "WHERE boo.users LIKE '%|" . $_SESSION['idSession'] . "|%' ORDER BY $block1->sortingValue";
} else {
    $tmpquery = "WHERE boo.shared = '1' OR boo.owner = '" . $_SESSION['idSession'] . "' ORDER BY $block1->sortingValue";
}

$listBookmarks = new request();
$listBookmarks->openBookmarks($tmpquery);

$comptListBookmarks = count($listBookmarks->boo_id);

if ($comptListBookmarks != '0') {
    $block1->openResults();

    if ($view == 'my') {
        $block1->labels($labels = array(0 => $strings['name'], 1 => $strings['bookmark_category'], 2 => $strings['shared']), 'false');
    } else {
        $block1->labels($labels = array(0 => $strings['name'], 1 => $strings['bookmark_category'], 2 => $strings['owner']), 'false');
    }

    for ($i = 0;$i < $comptListBookmarks;$i++) {
        $block1->openRow($listBookmarks->boo_id[$i]);
        $block1->checkboxRow($listBookmarks->boo_id[$i]);
        $block1->cellRow(
			buildLink('../bookmarks/viewbookmark.php?view=' . $view . '&amp;id=' . $listBookmarks->boo_id[$i],$listBookmarks->boo_name[$i], LINK_INSIDE)
			.' '
			.buildLink($listBookmarks->boo_url[$i], '(' . $strings['url'] . ')', LINK_OUT)
		);
        $block1->cellRow($listBookmarks->boo_boocat_name[$i]);

        if ($view == 'my') {
            if ($listBookmarks->boo_shared[$i] == '1') {
                $printShared = $strings['yes'];
            } else {
                $printShared = $strings['no'];
            }

            $block1->cellRow($printShared);
        } else {
            $block1->cellRow(buildLink($listBookmarks->boo_mem_email_work[$i], $listBookmarks->boo_mem_login[$i], LINK_MAIL));
        }

        $block1->closeRow();
    }

    $block1->closeResults();
}
else {
    $block1->noresults();
}

$block1->closeFormResults();

$block1->openPaletteScript();
$block1->paletteScript(0, 'add', '../bookmarks/editbookmark.php?', 'true,false,false', $strings['add']);

if ($view == 'my') {
    $block1->paletteScript(1, 'remove', '../bookmarks/deletebookmarks.php?', 'false,true,true', $strings['delete']);
}

/*$if ($sitePublish == "true") {
		$block1->paletteScript(3,"add_projectsite","../bookmarks/listbookmarks.php?addToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["add_project_site"]);
		$block1->paletteScript(4,"remove_projectsite","../bookmarks/listbookmarks.php?removeToSite=true&project=".$projectDetail->pro_id[0]."&action=publish","false,true,true",$strings["remove_project_site"]);
	}*/

$block1->paletteScript(5, 'info', '../bookmarks/viewbookmark.php?', 'false,true,false', $strings['view']);

if ($view == 'my') {
    $block1->paletteScript(6, 'edit', '../bookmarks/editbookmark.php?', 'false,true,false', $strings['edit']);
}

$block1->closePaletteScript($comptListBookmarks, $listBookmarks->boo_id);

require_once('../themes/' . THEME . '/footer.php');

?>