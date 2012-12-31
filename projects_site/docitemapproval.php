<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: docitemapproval.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
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

if ($action == "update") {
    $commentField = convertData($commentField);
    $tmpquery1 = "UPDATE " . $tableCollab["files"] . " SET comments_approval='$commentField',date_approval='$dateheure',approver='" . $_SESSION['idSession'] . "',status='$statusField' WHERE id = '$id'";
    connectSql("$tmpquery1");
    $msg = "updateFile";
    header("Location: doclists.php");
    exit;
} 

$tmpquery = "WHERE fil.id = '$id'";
$fileDetail = new request();
$fileDetail->openFiles($tmpquery);

if ($fileDetail->fil_published[0] == "1" || $fileDetail->fil_project[0] != $_SESSION['projectSession']) {
    header("Location: index.php");
    exit;
} 

$bouton[4] = "over";
$titlePage = $strings["approval_tracking"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"post\" action=\"../projects_site/docitemapproval.php?action=update\" name=\"documentitemapproval\" enctype=\"application/x-www-form-urlencoded\">";

echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\">
<tr><th colspan=\"2\">" . $strings["approval_tracking"] . " :</th></tr>
<tr><th>" . $strings["document"] . " :</th><td><a href=\"clientfiledetail.php?id=" . $fileDetail->fil_id[0] . "\">" . $fileDetail->fil_name[0] . "</a></td></tr>
<tr><th>" . $strings["status"] . " :</th><td><select name=\"statusField\">";

$comptSta = count($statusFile);

for ($i = 0;$i < $comptSta;$i++) {
    if ($fileDetail->fil_status[0] == $i) {
        echo "<option value=\"$i\" selected>$statusFile[$i]</option>";
    } else {
        echo "<option value=\"$i\">$statusFile[$i]</option>";
    } 
} 

echo "</select></td></tr>
<tr><th>" . $strings["comments"] . " :</th><td><textarea rows=\"3\" name=\"commentField\" cols=\"43\">" . $fileDetail->fil_comments_approval[0] . "</textarea></td></tr>
<tr><th>&nbsp;</th><td><input name=\"submit\" type=\"submit\" value=\"" . $strings["save"] . "\"></td></tr>
</table>
<input name=\"id\" type=\"hidden\" value=\"$id\">
</form>";

require_once ("include_footer.php");

?>
