<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: addfile.php,v 1.3 2004/12/15 12:25:11 pixtur Exp $
 * 
 * Copyright (c) 2004 by the NetOffice developers
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
    $extension_len = strlen($extension) + 1;
    $filename_len = strlen($_FILES['upload']['name']);
    $filename_prefix = substr($_FILES['upload']['name'], 0, $filename_len - $extension_len);

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
        $match = strstr($versionFile, ".");
        if ($match == "") {
            $versionFile = $versionFile . ".0";
        } 

        if ($versionFile == "") {
            $versionFile = "0.0";
        } 
        $c = convertData($c);
        $tmpquery = "INSERT INTO " . $tableCollab["meetings_attachment"] . "(owner,project,meeting,comments,upload,published,status,vc_version,vc_parent) VALUES('" . $_SESSION['idSession'] . "','$project','$meeting','$c','$dateheure','1','$statusField','$versionFile','0')";
        connectSql("$tmpquery");
        $tmpquery = $tableCollab["meetings_attachment"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
    } 

    if ($cpy == "true") {
        uploadFile("files/$project/meetings/$meeting", $_FILES['upload']['tmp_name'], $filename_prefix . "--$num." . $extension);
        $size = file_info_size("../files/" . $project . "/meetings/" . $meeting . "/" . $filename_prefix . "--$num." . $extension);
        $chaine = strrev("../files/" . $project . "/meetings/" . $meeting . "/" . $filename_prefix . "--$num." . $extension);
        $tab = explode(".", $chaine);
        $extension = strtolower(strrev($tab[0]));
    } 
    if ($cpy == "true") {
        $name = $filename_prefix . "--$num." . $extension;
        $tmpquery = "UPDATE " . $tableCollab["meetings_attachment"] . " SET name='$name',date='$dateheure',size='$size',extension='$extension' WHERE id = '$num'";
        connectSql("$tmpquery");
        header("Location: ../meetings/viewfile.php?id=$num&msg=addFile");
        exit;
    } 
} 

$tmpquery = "WHERE pro.id = '$project'";
$projectDetail = new request();
$projectDetail->openProjects($tmpquery);

$tmpquery = "WHERE mee.id = '$meeting'";
$meetingDetail = new request();
$meetingDetail->openMeetings($tmpquery);

$teamMember = "false";
$tmpquery = "WHERE tea.project = '$project' AND tea.member = '" . $_SESSION['idSession'] . "'";
$memberTest = new request();
$memberTest->openTeams($tmpquery);
$comptMemberTest = count($memberTest->tea_id);
if ($comptMemberTest == "0") {
    $teamMember = "false";
} else {
    $teamMember = "true";
} 

if ($teamMember == "false" && $projectsFilter == "true") {
    header('Location: ../general/permissiondenied.php');
    exit;
} 

//--- header ----------------------------------------------------------------------------------
$breadcrumbs[]=buildLink("../projects/listprojects.php?", $strings["projects"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../projects/viewproject.php?id=$project", $projectDetail->pro_name[0], LINK_INSIDE);
$breadcrumbs[]=buildLink("../meetings/listmeetings.php?$project=$project", $strings["meetings"], LINK_INSIDE);
$breadcrumbs[]=buildLink("../tasks/viewmeeting.php?id=$meeting", $meetingDetail->mee_name[0], LINK_INSIDE);
$breadcrumbs[]=$strings["add_file"];

require_once("../themes/" . THEME . "/header.php");

//--- content ---------------------------------------------------------------------------------
$block1 = new block();

$block1->form = "filedetails";

echo "<a name=\"filedetailsAnchor\"></a>";

echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../meetings/addfile.php?action=add&amp;project=$project&amp;meeting=$meeting\" name=\"filedetailsForm\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\"><input type=\"hidden\" name=\"maxCustom\" value=\"" . $projectDetail->pro_upload_max[0] . "\">";

if ($error != "") {
    $block1->headingError($strings["errors"]);
    $block1->contentError($error);
} 

$block1->headingForm($strings["add_file"]);

$block1->openContent();
$block1->contentTitle($strings["details"]);

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"statusField\">";
$comptSta = count($statusFile);

for ($i = 0;$i < $comptSta;$i++) {
    if ($i == "2") {
        echo "<option value=\"$i\" selected>$statusFile[$i]</option>";
    } else {
        echo "<option value=\"$i\">$statusFile[$i]</option>";
    } 
} 
echo"</select></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* " . $strings["upload"] . " :</td><td><input size=\"44\" style=\"width: 400px\" name=\"upload\" type=\"FILE\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["comments"] . " :</td><td><textarea rows=\"3\" style=\"width: 400px; height: 50px;\" name=\"c\" cols=\"43\">$c</textarea></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["vc_version"] . " :</td><td><input size=\"44\" style=\"width: 400px\" name=\"versionFile\" type=\"text\" value=\"0.0\"></td></tr>
<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"></td></tr>";

$block1->closeContent();
$block1->headingForm_close();
$block1->closeForm();

require_once("../themes/" . THEME . "/footer.php");

?>
