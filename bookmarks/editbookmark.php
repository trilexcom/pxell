<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: editbookmark.php,v 1.6 2004/12/15 12:25:18 pixtur Exp $
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

if ($id != '' && $action != 'add') {
    $tmpquery = "WHERE boo.id = '$id'";
    $bookmarkDetail = new request();
    $bookmarkDetail->openBookmarks($tmpquery);

    if ($bookmarkDetail->boo_owner[0] != $_SESSION['idSession']) {
        header('Location: ../bookmarks/listbookmarks.php?view=my&msg=bookmarkOwner');
        exit;
    } 
} 

// case update bookmark entry
if ($id != '') {
    // case update bookmark entry
    if ($action == 'update') {
        if ($piecesNew != '') {
            $users = '|' . implode('|', $piecesNew) . '|';
        } 

        if ($category_new != '') {
            $tmpquery = "WHERE boocat.name = '$category_new'";
            $listCategories = new request();
            $listCategories->openBookmarksCategories($tmpquery);
            $comptListCategories = count($listCategories->boocat_id);

            if ($comptListCategories == '0') {
                $tmpquery1 = 'INSERT INTO ' . $tableCollab['bookmarks_categories'] . "(name) VALUES('$category_new')";
                connectSql($tmpquery1);
                $tmpquery = $tableCollab['bookmarks_categories'];
                last_id($tmpquery);
                $num = $lastId[0];
                unset($lastId);
                $category = $num;
            } else {
                $category = $listCategories->boocat_id[0];
            } 
        } 

        if ($shared == '' || $users != '') {
            $shared = '0';
        } 

        if ($home == '') {
            $home = '0';
        } 

        if ($comments == '') {
            $comments = '0';
        } 

        $name = convertData($name);
        $description = convertData($description);
        $tmpquery5 = 'UPDATE ' . $tableCollab['bookmarks'] . " SET url='$url',name='$name',description='$description',modified='$dateheure',category='$category',shared='$shared',home='$home',comments='$comments',users='$users' WHERE id = '$id'";
        connectSql($tmpquery5);
        header('Location: ../bookmarks/listbookmarks.php?view=my&msg=update');
        exit;
    } 

    // set value in form
    $name = $bookmarkDetail->boo_name[0];
    $url = $bookmarkDetail->boo_url[0];
    $description = $bookmarkDetail->boo_description[0];
    $category = $bookmarkDetail->boo_category[0];
    $shared = $bookmarkDetail->boo_shared[0];

    if ($shared == '1') {
        $checkedShared = 'checked';
    } 

    $home = $bookmarkDetail->boo_home[0];

    if ($home == '1') {
        $checkedHome = 'checked';
    } 

    $comments = $bookmarkDetail->boo_comments[0];

    if ($comments == '1') {
        $checkedComments = 'checked';
    } 
} 

// case add note entry
if ($id == '') {
    $checkedShared = 'checked';
    $checkedComments = 'checked'; 
    // case add note entry
    if ($action == 'add') {
        if ($piecesNew != '') {
            $users = '|' . implode('|', $piecesNew) . '|';
        } 

        if ($category_new != '') {
            $tmpquery = "WHERE boocat.name = '$category_new'";
            $listCategories = new request();
            $listCategories->openBookmarksCategories($tmpquery);
            $comptListCategories = count($listCategories->boocat_id);

            if ($comptListCategories == '0') {
                $tmpquery1 = 'INSERT INTO ' . $tableCollab['bookmarks_categories'] . "(name) VALUES('$category_new')";
                connectSql($tmpquery1);
                $tmpquery = $tableCollab['bookmarks_categories'];
                last_id($tmpquery);
                $num = $lastId[0];
                unset($lastId);
                $category = $num;
            } else {
                $category = $listCategories->boocat_id[0];
            } 
        } 

        if ($shared == '' || $users != '') {
            $shared = '0';
        } 

        if ($home == '') {
            $home = '0';
        } 

        if ($comments == '') {
            $comments = '0';
        } 

        $name = convertData($name);
        $description = convertData($description);
        $tmpquery1 = 'INSERT INTO ' . $tableCollab['bookmarks'] . "(owner,category,name,url,description,shared,home,comments,users,created) VALUES('" . $_SESSION['idSession'] . "','$category','$name','$url','$description','$shared','$home','$comments','$users','$dateheure')";
        connectSql($tmpquery1);
        header('Location: ../bookmarks/listbookmarks.php?view=my&msg=add');
        exit;
    } 
} 


//--- header -----
$breadcrumbs[]=buildLink('../bookmarks/listbookmarks.php?view=my', $strings['bookmarks'], LINK_INSIDE);

if ($id == '') {
    $breadcrumbs[]=$strings['add_bookmark'];
} 

if ($id != '') {
    $breadcrumbs[]=buildLink('../bookmarks/viewbookmark.php?id=' . $bookmarkDetail->boo_id[0], $bookmarkDetail->boo_name[0], LINK_INSIDE);
    $breadcrumbs[]=$strings['edit_bookmark'];
} 

$bodyCommand = 'onLoad="document.booForm.name.focus();"';
$pageSection = 'bookmarks';
require_once('../themes/' . THEME . '/header.php');


//----- content ------
$block1 = new block();

if ($id == '') {
    $block1->form = 'boo';
    $block1->openForm('../bookmarks/editbookmark.php?action=add#' . $block1->form . 'Anchor');
} 

if ($id != '') {
    $block1->form = 'boo';
    $block1->openForm('../bookmarks/editbookmark.php?id=' . $id . '&amp;action=update#' . $block1->form . 'Anchor');
} 

if ($error != '') {
    $block1->headingError($strings['errors']);
    $block1->contentError($error);
} 

if ($id == '') {
    $block1->headingForm($strings['add_bookmark']);
} 
else {
    $block1->headingForm($strings['edit_bookmark'] . ' : ' . $bookmarkDetail->boo_name[0]);
} 

$block1->openContent();
$block1->contentTitle($strings['details']);

echo '
  <tr class="odd">
    <td valign="top" class="leftvalue">' . $strings['bookmark_category'] . ' :</td>
    <td><select name="category">
      <option value="0">-</option>';

$tmpquery = 'ORDER BY boocat.name';
$listCategories = new request();
$listCategories->openBookmarksCategories($tmpquery);
$comptListCategories = count($listCategories->boocat_id);

for ($i = 0;$i < $comptListCategories;$i++) {
    if ($listCategories->boocat_id[$i] == $bookmarkDetail->boo_category[0]) {
        echo '<option value="' . $listCategories->boocat_id[$i] . '" selected>' . $listCategories->boocat_name[$i] . '</option>';
    } else {
        echo '<option value="' . $listCategories->boocat_id[$i] . '">' . $listCategories->boocat_name[$i] . '</option>';
    } 
} 

echo '</select>
    </td>
  </tr>
  <tr class="odd">
<td valign="top" class="leftvalue">' . $strings["bookmark_category_new"] . ' :</td>
<td><input size="44" value="' . $category_new . '" style="width: 400px" name="category_new" type="TEXT"></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["name"] . ' :</td>
<td><input size="44" value="' . $name . '" style="width: 400px" name="name" type="TEXT"></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["url"] . ' :</td>
<td><input size="44" value="' . $url . '" style="width: 400px" name="url" type="TEXT"></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["description"] . ' :</td>
<td><textarea rows="10" style="width: 400px; height: 160px;" name="description" cols="47">' . $description . '</textarea></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["shared"] . ' :</td>
<td><input size="32" value="1" name="shared" type="checkbox" ' . $checkedShared . '></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["home"] . ' :</td>
<td><input size="32" value="1" name="home" type="checkbox" ' . $checkedHome . '></td>
</tr>
<tr class="odd">
<td valign="top" class="leftvalue">' . $strings["comments"] . ' :</td>
<td><input size="32" value="1" name="comments" type="checkbox" ' . $checkedComments . '></td>
</tr>';

if ($demoMode == true) {
    $tmpquery = "WHERE mem.id != '" . $_SESSION['idSession'] . "' AND mem.profil != '3' ORDER BY mem.login";
} else {
    $tmpquery = "WHERE mem.id != '" . $_SESSION['idSession'] . "' AND mem.profil != '3' AND mem.id != '2' ORDER BY mem.login";
} 

$listUsers = new request();
$listUsers->openMembers($tmpquery);
$comptListUsers = count($listUsers->mem_id);

$oldCaptured = $bookmarkDetail->boo_users[0];

if ($bookmarkDetail->boo_users[0] != "") {
    $listCaptured = explode('|', $bookmarkDetail->boo_users[0]);
    $comptListCaptured = count($listCaptured);
} 

if ($comptListUsers != '0') {
    echo '<tr class="odd"><td valign="top" class="leftvalue">' . $strings['private'] . ' :</td><td><select name="piecesNew[]" multiple size=10>'; 
    // $oldCaptured = '';
    for($i = 0; $i < $comptListUsers; $i++) {
        $selected[$i] = '';

        for($j = 0; $j < $comptListCaptured; $j++) {
            if ($listUsers->mem_id[$i] == $listCaptured[$j]) {
                $selected[$i] = 'selected'; 
                // $oldCaptured .= $listCaptured[$j].':';
                break;
            } else {
                $selected[$i] = '';
            } 
        } 

        echo '<option value=' . $listUsers->mem_id[$i] . ' ' . $selected[$i] . '>' . $listUsers->mem_login[$i] . '</option>';
    } 

    echo '</select></td></tr><input type="hidden" name="oldCaptured" value="' . $oldCaptured . '">';
} 

echo '<tr class="odd"><td valign="top" class="leftvalue">&nbsp;</td><td><input type="SUBMIT" value="' . $strings['save'] . '"></td></tr>';

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once('../themes/' . THEME . '/footer.php');

?>
