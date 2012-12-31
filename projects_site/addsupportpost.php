<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addsupportpost.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
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

$tmpquery = "WHERE sr.id = '$id'";
$requestDetail = new request();
$requestDetail->openSupportRequests($tmpquery);

if ($requestDetail->sr_project[0] != $_SESSION['projectSession'] || $requestDetail->sr_user[0] != $_SESSION['idSession']) {
    header("Location: index.php");
    exit;
} 

if ($action == "add") {
    $mes = convertData($mes);

    $tmpquery1 = "INSERT INTO " . $tableCollab["support_posts"] . "(request_id,message,date,owner,project) VALUES('$id','$mes','$dateheure','" . $_SESSION['idSession'] . "','" . $requestDetail->sr_project[0] . "')";
    connectSql("$tmpquery1");
    $tmpquery = $tableCollab["support_posts"];
    last_id($tmpquery);
    $num = $lastId[0];
    unset($lastId);

    if ($notifications == "true") {
        if ($mes != "") {
            require_once("../support/noti_newpost.php");
        } 
    } 

    header("Location: suprequestdetail.php?id=$id");
    exit;
} 

$bouton[6] = "over";
$titlePage = $strings["support"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/addsupportpost.php?id=$id&amp;action=add&amp;project=" . $_SESSION['projectSession'] . "#filedetailsAnchor\" name=\"addsupport\" enctype=\"multipart/form-data\">";

echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\">
<tr><th colspan=\"2\">" . $strings["add_support_response"] . "</th></tr>
<tr><th>" . $strings["message"] . "</th><td><textarea rows=\"3\" style=\"width: 400px; height: 200px;\" name=\"mes\" cols=\"43\">$mes</textarea></td></tr>
<input type=\"hidden\" name=\"user\" value=\"" . $_SESSION['idSession'] . "\">";

echo "<tr><th>&nbsp;</th><td><input type=\"SUBMIT\" value=\"" . $strings["submit"] . "\"></td></tr>
</table>
</form>";

require_once ("include_footer.php");

?>
