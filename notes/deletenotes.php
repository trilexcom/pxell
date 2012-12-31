<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: deletenotes.php,v 1.4 2004/12/15 12:25:19 pixtur Exp $
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

if ($action == "delete") {
    $id = str_replace("**", ",", $id);
    $tmpquery1 = "DELETE FROM " . $tableCollab["notes"] . " WHERE id IN($id)";
    connectSql("$tmpquery1");
    header("Location: ../projects/viewproject.php?id=$project&msg=delete");
    exit;
} 

//--- header ---
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=$strings["delete_note"];

require_once("../themes/" . THEME . "/header.php");


//--- content ---
$block1 = new block();
$block1->form = "saP";
$block1->openForm("../notes/deletenotes.php?project=$project&amp;action=delete&amp;id=$id");

$block1->headingForm($strings["delete_note"]);

$block1->openContent();
$block1->contentTitle($strings["delete_following"]);

$id = str_replace("**", ",", $id);
$tmpquery = "WHERE note.id IN($id) ORDER BY note.subject";
$listNotes = new request();
$listNotes->openNotes($tmpquery);
$comptListNotes = count($listNotes->note_id);

for ($i = 0;$i < $comptListNotes;$i++) {
    $block1->contentRow("#" . $listNotes->note_id[$i], $listNotes->note_subject[$i]);
} 

$block1->contentRow("", "<input type=\"submit\" name=\"delete\" value=\"" . $strings["delete"] . "\"> <input type=\"button\" name=\"cancel\" value=\"" . $strings["cancel"] . "\" onClick=\"history.back();\">");

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
