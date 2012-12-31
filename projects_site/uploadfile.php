<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: uploadfile.php,v 1.4 2004/12/22 22:16:31 madbear Exp $
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
    if ($maxCustom != "") {
        $maxFileSize = $maxCustom;
    } 
    if ($_FILES['upload']['size'] != 0) {
        $taille_ko = $_FILES['upload']['size'] / 1024;
    } else {
        $taille_ko = 0;
    } 

    if ($_FILES['upload']['name'] == "") {
        $error .= $strings["no_file"] . "<br>";
    } 

    if ($_FILES['upload']['size'] > $maxFileSize) {
        if ($maxFileSize != 0) {
            $taille_max_ko = $maxFileSize / 1024;
        } 
        $error .= $strings["exceed_size"] . " ($taille_max_ko $byteUnits[1])<br>";
    } 

    $extension = strtolower(substr(strrchr($_FILES['upload']['name'], ".") , 1));

    if ($allowPhp == "false") {
        $send = "";
        if ($_FILES['upload']['name'] != "" && ($extension == "php" || $extension == "php3" || $extension == "phtml")) {
            $error .= $strings["no_php"] . "<br>";
            $send = "false";
        } 
    } 

    if ($_FILES['upload']['name'] != "" && $_FILES['upload']['size'] < $maxFileSize && $_FILES['upload']['size'] != 0 && $send != "false") {
        $cpy = "true";
    } 
    if ($cpy == "true") {
        $commentsField = convertData($commentsField);
        $tmpquery = "INSERT INTO " . $tableCollab["files"] . "(owner,project,task,comments,upload,published,status,vc_version,vc_parent,phase) VALUES('" . $_SESSION['idSession'] . "','" . $_SESSION['projectSession'] . "','0','$commentsField','$dateheure','0','2','0.0','0','0')";
        connectSql("$tmpquery");
        $tmpquery = $tableCollab["files"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
        uploadFile("files/$project", $_FILES['upload']['tmp_name'], "$num--" . $_FILES['upload']['name']);
        $size = file_info_size("../files/" . $project . "/" . $num . "--" . $_FILES['upload']['name']); 
        // $dateFile = file_info_date("files/".$project."/".$num."--".$_FILES['upload']['name']);
        $chaine = strrev("../files/" . $project . "/" . $num . "--" . $_FILES['upload']['name']);
        $tab = explode(".", $chaine);
        $extension = strtolower(strrev($tab[0]));
        $name = $num . "--" . $_FILES['upload']['name'];
        $tmpquery = "UPDATE " . $tableCollab["files"] . " SET name='$name',date='$dateheure',size='$size',extension='$extension' WHERE id = '$num'";
        connectSql("$tmpquery");
        header('Location: doclists.php');
        exit;
    } 
} 

$bouton[4] = "over";
$titlePage = $strings["upload_file"];
require_once ("include_header.php");

echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/uploadfile.php?action=add&amp;project=" . $_SESSION['projectSession'] . "&amp;task=$task#filedetailsAnchor\" name=\"feeedback\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\"><input type=\"hidden\" name=\"maxCustom\" value=\"" . $projectDetail->pro_upload_max[0] . "\">";

echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\"><tr><th colspan=\"2\">" . $strings["upload_form"] . "</th></tr>
<tr><th>" . $strings["comments"] . " :</th><td><textarea cols=\"60\" name=\"commentsField\" rows=\"6\">$commentsField</textarea></td></tr>
<tr><th>" . $strings["upload"] . " :</th><td><input size=\"35\" value=\"\" name=\"upload\" type=\"file\"></td></tr>
<tr><th>&nbsp;</th><td><input name=\"submit\" type=\"submit\" value=\"" . $strings["save"] . "\"><br><br>$error</td></tr></table>
</form>";

require_once ("include_footer.php");

?>
