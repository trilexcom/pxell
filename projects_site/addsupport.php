<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addsupport.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
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
$userDetail = new request();
$userDetail->openMembers($tmpquery);

$tmpquery = "WHERE sr.member = '" . $_SESSION['idSession'] . "'";
$listRequests = new request();
$listRequests->openSupportRequests($tmpquery);
$comptListRequests = count($listRequests->sr_id);

if ($action == "add") {
    $sub = convertData($sub);
    $mes = convertData($mes);

    $tmpquery1 = "INSERT INTO " . $tableCollab["support_requests"] . "(member,priority,subject,message,date_open,project,status) VALUES('$user','$pr','$sub','$mes','$dateheure','$project','0')";
    connectSql($tmpquery1);
    $tmpquery = $tableCollab["support_requests"];
    last_id($tmpquery);
    $num = $lastId[0];
    unset($lastId);

    if ($notifications == "true") {
        require_once("../support/noti_newrequest.php");
    } 

    header("Location: suprequestdetail.php?id=$num");
    exit;
} 

$bouton[6] = "over";
$titlePage = $strings["support"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/addsupport.php?action=add&amp;project=" . $_SESSION['projectSession'] . "#filedetailsAnchor\" name=\"addsupport\" enctype=\"multipart/form-data\">";

echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\">
<tr><th colspan=\"2\">" . $strings["add_support_request"] . "</th></tr>
<tr><th>" . $strings["priority"] . " :</th><td><select name=\"pr\">";

$comptPri = count($priority);
for ($i = 0;$i < $comptPri;$i++) {
    if ($i != 0) {
        echo "<option value=\"$i\">$priority[$i]</option>";
    } 
} 
echo "</select></td></tr>
<tr><th>" . $strings["subject"] . "</th><td><input size=\"32\" value=\"$sub\" style=\"width: 250px\" name=\"sub\" maxlength=\"32\" type=\"TEXT\"></td></tr>
<tr><th>" . $strings["message"] . "</th><td><textarea rows=\"3\" style=\"width: 400px; height: 200px;\" name=\"mes\" cols=\"43\">$mes</textarea></td></tr>
<input type=\"hidden\" name=\"user\" value=\"" . $_SESSION['idSession'] . "\">
<tr><th>&nbsp;</th><td><input type=\"SUBMIT\" value=\"" . $strings["submit"] . "\"></td></tr>
</table>
</form>";

require_once ("include_footer.php");

?>
