<?php // $Revision: 1.5 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: createsearch.php,v 1.5 2004/12/15 12:25:16 pixtur Exp $
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
// test required field searchfor
if ($action == "search") {
    // if searchfor blank, $error set
    if ($searchfor == "") {
        $error = $strings["search_note"]; 
        // if searchfor not blank, redirect to searchresults
    } else {
        $searchfor = urlencode($searchfor);
        header("Location: ../search/resultssearch.php?searchfor=$searchfor&heading=$heading");
        exit;
    } 
} 



//--- header ---
$breadcrumbs[]=buildLink("../search/createsearch.php?", $strings["search"], LINK_INSIDE);
$breadcrumbs[]=$strings["search_options"];


$bodyCommand = "onLoad=\"document.searchForm.searchfor.focus()\"";
$pageSection = 'search';
require_once("../themes/" . THEME . "/header.php");

//--- content ---
$block1 = new block();

$block1->form = "search";
$block1->openForm("../search/createsearch.php?action=search");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["search"]);

$block1->openContent();
$block1->contentTitle($strings["enter_keywords"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* " . $strings["search_for"] . " :</td><td><input value=\"\" type=\"text\" name=searchfor style=\"width: 200px;\" size=\"30\" maxlength=\"64\" onBlur=\"if(this.value==' '||(this.value.length==1)){alert('Improper search parameters!');this.value='';this.focus();}\">
<select name=\"heading\">
		<option selected value=\"ALL\">" . $strings["all_content"] . "</option>
		<option value=\"notes\">" . $strings["notes"] . "</option>
		<option value=\"organizations\">" . $strings["organizations"] . "</option>
		<option value=\"projects\">" . $strings["projects"] . "</option>
		<option value=\"tasks\">" . $strings["tasks"] . "</option>
		<option value=\"discussions\">" . $strings["discussions"] . "</option>
		<option value=\"members\">" . $strings["users"] . "</option>
</select>
</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"Save\" value=\"" . $strings["search"] . "\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
