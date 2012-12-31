<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: createthread.php,v 1.3 2004/12/22 22:16:31 madbear Exp $
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

if ($action == "add") {
    $topicField = convertData($topicField);
    $messageField = convertData($messageField);
    $tmpquery1 = "INSERT INTO " . $tableCollab["topics"] . "(project,owner,subject,status,last_post,posts,published) VALUES('" . $_SESSION['projectSession'] . "','" . $_SESSION['idSession'] . "','$topicField','1','$dateheure','1','0')";
    connectSql("$tmpquery1");
    $tmpquery = $tableCollab["topics"];
    last_id($tmpquery);
    $num = $lastId[0];
    unset($lastId);
    autoLinks($messageField);
    $tmpquery2 = "INSERT INTO " . $tableCollab["posts"] . "(topic,member,created,message) VALUES('$num','" . $_SESSION['idSession'] . "','$dateheure','$newText')";
    connectSql("$tmpquery2");

    if ($notifications == "true") {
        $tmpquery = "WHERE pro.id = '" . $_SESSION['projectSession'] . "'";
        $projectDetail = new request();
        $projectDetail->openProjects($tmpquery);

        require_once("../topics/noti_newtopic.php");
    } 
    header("Location: showallthreadtopics.php");
} 

$bodyCommand = "onload=\"document.createThreadTopic.topicField.focus();\"";

$bouton[5] = "over";
$titlePage = $strings["create_topic"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"post\" action=\"../projects_site/createthread.php?project=" . $_SESSION['projectSession'] . "&amp;action=add&amp;id=$id\" name=\"createThreadTopic\" enctype=\"application/x-www-form-urlencoded\">";

echo "<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\">
<tr><th colspan=\"2\">" . $strings["create_topic"] . "</th></tr>
<tr><th>*&nbsp;" . $strings["topic"] . " :</th><td><input size=\"35\" value=\"$topicField\" name=\"topicField\" type=\"text\"></td></tr>
<tr><th colspan=\"2\">" . $strings["enter_message"] . "</th></tr>
<tr><th>*&nbsp;" . $strings["message"] . " :</th><td colspan=\"2\"><textarea rows=\"3\" name=\"messageField\" cols=\"43\"></textarea></td></tr>
<tr><th>&nbsp;</th><td colspan=\"2\"><input name=\"submit\" type=\"submit\" value=\"" . $strings["save"] . "\"></td></tr>
</table>
</form>";

require_once ("include_footer.php");

?>
