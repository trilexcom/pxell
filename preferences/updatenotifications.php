<?php // $Revision: 1.6 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: updatenotifications.php,v 1.6 2004/12/15 12:25:22 pixtur Exp $
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

$tmpquery = "WHERE mem.id = '" . $_SESSION['idSession'] . "'";
$userPrefs = new request();
$userPrefs->openMembers($tmpquery);
$comptUserPrefs = count($userPrefs->mem_id);

if ($comptUserPrefs == "0") {
    header("Location: ../users/listusers.php?msg=blankUser");
    exit;
} 

if ($action == "update") {
    for ($i = 0;$i < 15;$i++) {
        if ($tbl_check[$i] == "") {
            $tbl_check[$i] = "1";
        } 
    } 

    $tmpquery = "UPDATE " . $tableCollab["notifications"] . " SET taskAssignment='$tbl_check[0]',statusTaskChange='$tbl_check[1]',priorityTaskChange='$tbl_check[2]',duedateTaskChange='$tbl_check[3]',addProjectTeam='$tbl_check[4]',removeProjectTeam='$tbl_check[5]',newPost='$tbl_check[6]',newTopic='$tbl_check[7]' WHERE member = '" . $_SESSION['idSession'] . "'";
    connectSql($tmpquery);

    header("Location: ../preferences/updatenotifications.php?msg=update");
    exit;
} 

$tmpquery = "WHERE noti.member = '" . $_SESSION['idSession'] . "'";
$userAvert = new request();
$userAvert->openNotifications($tmpquery);
if ($userAvert->not_taskassignment[0] == "0") {
    $taskAssignment = "checked";
} 
if ($userAvert->not_statustaskchange[0] == "0") {
    $statusTaskChange = "checked";
} 
if ($userAvert->not_prioritytaskchange[0] == "0") {
    $priorityTaskChange = "checked";
} 
if ($userAvert->not_duedatetaskchange[0] == "0") {
    $duedateTaskChange = "checked";
} 
if ($userAvert->not_addprojectteam[0] == "0") {
    $addProjectTeam = "checked";
} 
if ($userAvert->not_removeprojectteam[0] == "0") {
    $removeProjectTeam = "checked";
} 
if ($userAvert->not_newpost[0] == "0") {
    $newPost = "checked";
} 
if ($userAvert->not_newtopic[0] == "0") {
    $newTopic = "checked";
} 

$headBonus = "<script type=\"text/JavaScript\">
<!--
function checkboxes(){
	for (var i = 0; i < document.user_avertForm.elements.length; i++) {
		var e = document.user_avertForm.elements[i];
			if (e.type=='checkbox') {
				if (document.user_avertForm.chkbox_slt.value == \"true\") {
					e.checked = true;

				} else {
					e.checked = false;
				}
			}
	}
	if (document.user_avertForm.chkbox_slt.value == \"true\" ) {
		document.user_avertForm.chkbox_slt.value = \"false\";
	} else {
		document.user_avertForm.chkbox_slt.value = \"true\";
	}

}
//-->
</script>";



//--- header ---
$breadcrumbs[]=$strings["preferences"];
$breadcrumbs[]=buildLink("../preferences/updateuser.php?", $strings["user_profile"], LINK_INSIDE) . "&nbsp; | &nbsp;" . buildLink("../preferences/updatepassword.php?", $strings["change_password"], LINK_INSIDE) . "&nbsp; | &nbsp;" . $strings["notifications"];

$pageSection = 'preferences';
require_once("../themes/" . THEME . "/header.php");

//---content -----
$block1 = new block();

$block1->form = "user_avert";
$block1->openForm("../preferences/updatenotifications.php?action=update");

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["edit_notifications"] . " : " . $userPrefs->mem_login[0]);

$block1->openContent();
$block1->contentTitle($strings["edit_notifications_info"]);

echo "<input type=\"hidden\" name=\"chkbox_slt\" value=\"true\"><tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["select_deselect"] . " :</td><td>
<a href=\"javascript:checkboxes();\" onmouseover=\"window.status = '" . $strings["select_deselect"] . "';return true;\" onmouseout=\"window.status = '';return true;\"><img name=\"all\" src=\"../themes/$block1->theme/checkbox_off_16.gif\" border=\"0\" alt=\"\"></a></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[0]\" value=\"0\" $taskAssignment></td><td>" . $strings["edit_noti_taskassignment"] . "</td>

<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[1]\" value=\"0\" $statusTaskChange></td><td>" . $strings["edit_noti_statustaskchange"] . "</tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[2]\" value=\"0\" $priorityTaskChange></td><td>" . $strings["edit_noti_prioritytaskchange"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[3]\" value=\"0\" $duedateTaskChange></td><td>" . $strings["edit_noti_duedatetaskchange"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[4]\" value=\"0\" $addProjectTeam></td><td>" . $strings["edit_noti_addprojectteam"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[5]\" value=\"0\" $removeProjectTeam></td><td>" . $strings["edit_noti_removeprojectteam"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[6]\" value=\"0\" $newPost></td><td>" . $strings["edit_noti_newpost"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"><input type=\"checkbox\" name=\"tbl_check[7]\" value=\"0\" $newTopic></td><td>" . $strings["edit_noti_newtopic"] . "</td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"submit\" name=\"Save\" value=\"" . $strings["save"] . "\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
