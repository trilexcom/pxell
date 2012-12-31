<?php // $Revision: 1.4 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: clientfiledetail.php,v 1.4 2004/12/22 22:16:31 madbear Exp $
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

require_once("../includes/files_types.php");

$tmpquery = "WHERE fil.id = '$id'";
$fileDetail = new request();
$fileDetail->openFiles($tmpquery);

if ($fileDetail->fil_published[0] == "1" || $fileDetail->fil_project[0] != $_SESSION['projectSession']) {
    header("Location: index.php");
} 

$type = file_info_type($fileDetail->fil_extension[0]);
$displayname = $fileDetail->fil_name[0];
// ---------------------------------------------------------------------------------------------------
// Update file code
if ($action == "update") {
    if ($maxCustom != "") {
        $maxFileSize = $maxCustom;
    } 
    if ($_FILES['upload']['size'] != 0) {
        $taille_ko = $_FILES['upload']['size'] / 1024;
    } else {
        $taille_ko = 0;
    } 
    if ($_FILES['upload']['name'] == "") {
        $error4 .= $strings["no_file"] . "<br>";
    } 
    if ($_FILES['upload']['size'] > $maxFileSize) {
        if ($maxFileSize != 0) {
            $taille_max_ko = $maxFileSize / 1024;
        } 
        $error4 .= $strings["exceed_size"] . " ($taille_max_ko $byteUnits[1])<br>";
    } 

    $upload_name = $fileDetail->fil_name[0];
    $extension = strtolower(substr(strrchr($upload_name, ".") , 1)); 
    // Add version number to the old copy's file name.
    $changename = str_replace(".", " v" . $fileDetail->fil_vc_version[0] . ".", $fileDetail->fil_name[0]); 
    // Generate paths for use further down.
    if ($fileDetail->fil_task[0] != "0") {
        $path = "files/" . $fileDetail->fil_project[0] . "/" . $fileDetail->fil_task[0] . "/$upload_name";
        $path_source = "files/" . $fileDetail->fil_project[0] . "/" . $fileDetail->fil_task[0] . "/" . $fileDetail->fil_name[0];
        $path_destination = "files/" . $fileDetail->fil_project[0] . "/" . $fileDetail->fil_task[0] . "/$changename";
    } else {
        $path = "files/" . $fileDetail->fil_project[0] . "/$upload_name";
        $path_source = "files/" . $fileDetail->fil_project[0] . "/" . $fileDetail->fil_name[0];
        $path_destination = "files/" . $fileDetail->fil_project[0] . "/$changename";
    } 

    if ($allowPhp == "false") {
        $send = "";
        if ($_FILES['upload']['name'] != "" && ($extension == "php" || $extension == "php3" || $extension == "phtml")) {
            $error4 .= $strings["no_php"] . "<br>";
            $send = "false";
        } 
    } 

    if ($_FILES['upload']['name'] != "" && $_FILES['upload']['size'] < $maxFileSize && $_FILES['upload']['size'] != 0 && $send != "false") {
        $cpy = "true";
    } 

    if ($cpy == "true") {
        // Copy old file with a new file name
        moveFile($path_source, $path_destination); 
        // Set variables from original files details.
        $cpy_project = $fileDetail->fil_project[0];
        $cpy_task = $fileDetail->fil_task[0];
        $cpy_date = $fileDetail->fil_date[0];
        $cpy_size = $fileDetail->fil_size[0];
        $cpy_extension = $fileDetail->fil_extension[0];
        $cpy_comments = $fileDetail->fil_comments[0];
        $cpy_upload = $fileDetail->fil_upload[0];
        $cpy_pusblished = $fileDetail->fil_published[0];
        $cpy_vc_parent = $fileDetail->fil_vc_parent[0];
        $cpy_id = $fileDetail->fil_id[0];
        $cpy_vc_version = $fileDetail->fil_vc_version[0]; 
        // Insert a new row for the copied file
        $comments = convertData($comments);
        $tmpquery = "INSERT INTO " . $tableCollab["files"] . "(owner,project,task,name,date,size,extension,comments,upload,published,status,vc_status,vc_version,vc_parent,phase) VALUES('" . $_SESSION['idSession'] . "','$cpy_project','$cpy_task','$changename','$cpy_date','$cpy_size','$cpy_extension','$cpy_comments','$cpy_upload','0','2','3','$cpy_vc_version','$cpy_id','0')";
        connectSql("$tmpquery");
        $tmpquery = $tableCollab["files"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
    } 
    // Insert details into Database
    if ($cpy == "true") {
        uploadFile(".", $_FILES['upload']['tmp_name'], $path); 
        // $size = file_info_size("$path");
        // $dateFile = file_info_date("$path");
        $chaine = strrev("$path");
        $tab = explode(".", $chaine);
        $extension = strtolower(strrev($tab[0]));
    } 

    $newversion = $fileDetail->fil_vc_version[0] + $change_file_version;
    if ($cpy == "true") {
        $name = "$upload_name";
        $tmpquery = "UPDATE " . $tableCollab["files"] . " SET date='$dateheure',size='$size',comments='$c',status='$statusField',vc_version='$newversion' WHERE id = '$id'";
        connectSql("$tmpquery");
        header("Location: clientfiledetail.php?id=" . $fileDetail->fil_id[0] . "&msg=addFile");
        exit;
    } 
} 
// ---------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------
// Add new revision code
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
        $error3 .= $strings["no_file"] . "<br>";
    } 
    if ($_FILES['upload']['size'] > $maxFileSize) {
        if ($maxFileSize != 0) {
            $taille_max_ko = $maxFileSize / 1024;
        } 
        $error3 .= $strings["exceed_size"] . " ($taille_max_ko $byteUnits[1])<br>";
    } 

    $upload_name = "$filename"; 
    // Add version and revision at the end of a file name but before the extension.
    $upload_name = str_replace(".", " v$oldversion r$revision.", $upload_name);

    $extension = strtolower(substr(strrchr($upload_name, ".") , 1));

    if ($allowPhp == "false") {
        $send = "";
        if ($_FILES['upload']['name'] != "" && ($extension == "php" || $extension == "php3" || $extension == "phtml")) {
            $error3 .= $strings["no_php"] . "<br>";
            $send = "false";
        } 
    } 

    if ($_FILES['upload']['name'] != "" && $_FILES['upload']['size'] < $maxFileSize && $_FILES['upload']['size'] != 0 && $send != "false") {
        $cpy = "true";
    } 
    // Insert details into Database
    if ($cpy == "true") {
        $comments = convertData($comments);
        $tmpquery = "INSERT INTO " . $tableCollab["files"] . "(owner,project,task,comments,upload,published,status,vc_status,vc_parent,phase) VALUES('" . $_SESSION['idSession'] . "','$project','$task','$c','$dateheure','0','2','0','$parent','0')";
        connectSql("$tmpquery");
        $tmpquery = $tableCollab["files"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
    } 

    if ($task != "0") {
        if ($cpy == "true") {
            uploadFile("files/$project/$task", $_FILES['upload']['tmp_name'], $upload_name);
            $size = file_info_size("../files/$project/$task/$upload_name"); 
            // $dateFile = file_info_date("../files/$project/$task/$upload_name");
            $chaine = strrev("../files/$project/$task/$upload_name");
            $tab = explode(".", $chaine);
            $extension = strtolower(strrev($tab[0]));
        } 
    } else {
        if ($cpy == "true") {
            uploadFile("files/$project", $_FILES['upload']['tmp_name'], $upload_name);
            $size = file_info_size("../files/$project/$upload_name"); 
            // $dateFile = file_info_date("../files/$project/$upload_name");
            $chaine = strrev("../files/$project/$upload_name");
            $tab = explode(".", $chaine);
            $extension = strtolower(strrev($tab[0]));
        } 
    } 

    if ($cpy == "true") {
        $name = "$upload_name";
        $tmpquery = "UPDATE " . $tableCollab["files"] . " SET name='$name',date='$dateheure',size='$size',extension='$extension',vc_version='$oldversion' WHERE id = '$num'";
        connectSql("$tmpquery");
        header("Location: clientfiledetail.php?id=$sendto&msg=addFile");
        exit;
    } 
} 
// ---------------------------------------------------------------------------------------------------
$bouton[4] = "over";
$titlePage = $strings["document"];
require_once ("include_header.php");
// TABLE 1 - FILE DETAILS TABLE.
echo "<table cellpadding=20 cellspacing=0 border=0 width=\"100%\">
 <tr>
   <td><h1 class=\"heading\">" . $strings["document"] . "</h1>
	<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"4\" cols=\"4\">
	<tr><td width=\"40%\"><table cellspacing=\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\">";

echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["type"] . " : </td><td><img src=\"../interface/icones/$type\" border=\"0\" alt=\"\"></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["name"] . " : </td><td>" . $fileDetail->fil_name[0] . "</td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["vc_version"] . " :</td><td>" . $fileDetail->fil_vc_version[0] . "</td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["ifc_last_date"] . " :</td><td>" . $fileDetail->fil_date[0] . "</td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["size"] . ":</td><td>" . convertSize($fileDetail->fil_size[0]) . "</td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["owner"] . " :</td><td><a href=\"contactdetail.php?id=" . $fileDetail->fil_mem_id[0] . "\">" . $fileDetail->fil_mem_name[0] . "</a> (<a href=\"mailto:" . $fileDetail->fil_mem_email_work[0] . "\">" . $fileDetail->fil_mem_login[0] . "</a>)</td></tr>";

if ($fileDetail->fil_comments[0] != "") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["comments"] . " :</td><td>" . nl2br($fileDetail->fil_comments[0]) . "</td></tr>";
} 

$idStatus = $fileDetail->fil_status[0];
echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["approval_tracking"] . " :</td><td><a href=\"docitemapproval.php?id=" . $fileDetail->fil_id[0] . "\">$statusFile[$idStatus]</a></td></tr>";

if ($fileDetail->fil_mem2_id[0] != "") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["approver"] . " :</td><td><a href=\"userdetail.php?id=" . $fileDetail->fil_mem2_id[0] . "\">" . $fileDetail->fil_mem2_name[0] . "</a> (<a href=\"mailto:" . $fileDetail->fil_mem2_email_work[0] . "\">" . $fileDetail->fil_mem2_login[0] . "</a>)&nbsp;</td></tr>";
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["approval_date"] . " :</td><td>" . $fileDetail->fil_date_approval[0] . "&nbsp;</td></tr>";
} 

if ($fileDetail->fil_comments_approval[0] != "") {
    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["approval_comments"] . " :</td><td>" . nl2br($fileDetail->fil_comments_approval[0]) . "&nbsp;</td></tr>";
} 
// ------------------------------------------------------------------
$tmpquery = "WHERE fil.id = '$id' OR fil.vc_parent = '$id' AND fil.vc_status = '3' ORDER BY fil.date DESC";

$listVersions = new request();
$listVersions->openFiles($tmpquery);
$comptListVersions = count($listVersions->fil_vc_parent);

echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\">" . $strings["ifc_version_history"] . " :</td><td><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue2\"><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></td><td><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></td></tr>
	<tr class=\"odd\"><td valign=\"top\" colspan=\"2\" align=\"center\"><table width=\"550\" cellpadding=\"0\" cellspacing=\"0\" class=\"tableRevision\">";
for ($i = 0;$i < $comptListVersions;$i++) {
    // Sort odds and evens for bg color
    if ($i == "0") {
        $vclass = "new";
    } else {
        $vclass = "old";
    } 

    echo "<tr class=\"$vclass\" height=\"20\" onmouseover=\"this.style.backgroundColor='" . $highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\"><td>&nbsp;</td>

	<td>" . $strings["vc_version"] . " : " . $listVersions->fil_vc_version[$i] . "</td>
	<td>$displayname&nbsp;&nbsp;";

    if ($listVersions->fil_task[$i] != "0") {
        if (file_exists("../files/" . $listVersions->fil_project[$i] . "/" . $listVersions->fil_task[$i] . "/" . $listVersions->fil_name[$i])) {
            echo " <a href=\"clientaccessfile.php?mode=view&id=" . $listVersions->fil_id[$i] . "\">" . $strings["view"] . "</a>";
            $folder = $listVersions->fil_project[$i] . "/" . $listVersions->fil_task[$i];
            $existFile = "true";
        } 
    } else {
        if (file_exists("../files/" . $listVersions->fil_project[$i] . "/" . $listVersions->fil_name[$i])) {
            echo " <a href=\"clientaccessfile.php?mode=view&id=" . $listVersions->fil_id[$i] . "\">" . $strings["view"] . "</a>";
            $folder = $listVersions->fil_project[$i];
            $existFile = "true";
        } 
    } 
    if ($existFile == "true") {
        echo " <a href=\"clientaccessfile.php?mode=download&id=" . $listVersions->fil_id[$i] . "\">" . $strings["save"] . "</a>";
    } else {
        echo $strings["missing_file"];
    } 

    echo"</td><td>" . $strings["date"] . " : " . $listVersions->fil_date[$i] . "</td></tr>";
} 
echo"</table></td></tr><br>";
echo "</table></td></tr>
	</table>					  
  </td>
 </tr>
</table>";

if ($peerReview == "true") {
    // Table 2 - LIST OF REVIEWS TABLE.
    echo "<table cellpadding=20 cellspacing=0 border=0 width=\"100%\">
 <tr>
   <td><h1 class=\"heading\">" . $strings["ifc_revisions"] . "</h1>
	<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\">
	<tr height=\"15\"><th width=\"100%\" class=\"ModuleColumnHeaderSort\"><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></th></tr>
	<tr><td width=\"40%\"><table cellpadding =\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\">";

    echo"<tr class=\"odd\"><td align=\"center\"><br>";

    $tmpquery = "WHERE fil.vc_parent = '$id' AND fil.vc_status != '3' ORDER BY fil.date";
    $listReviews = new request();
    $listReviews->openFiles($tmpquery);
    $comptListReviews = count($listReviews->fil_vc_parent);
    for ($i = 0;$i < $comptListReviews;$i++) {
        // Sort odds and evens for bg color
        if (!($i % 2)) {
            $class = "odd";
            $highlightOff = $oddColor;
        } else {
            $class = "odd";
            $highlightOff = $oddColor;
        } 
        // Calculate a revision number for display for each listing
        $displayrev = $i + 1;

        echo "<table width=\"550\" cellpadding=\"0\" cellspacing=\"0\" class=\"tableRevision\" onmouseover=\"this.style.backgroundColor='" . $highlightOn . "'\" onmouseout=\"this.style.backgroundColor='" . $highlightOff . "'\">
	<tr class=\"reviewHeader\" height=\"25\"><td>";
        echo"&nbsp;</td>
	<td colspan=\"3\">$displayname&nbsp;&nbsp;";
        if ($listReviews->fil_task[$i] != "0") {
            if (file_exists("../files/" . $listReviews->fil_project[$i] . "/" . $listReviews->fil_task[$i] . "/$listReviews->fil_name[$i]")) {
                echo "<a href=\"clientaccessfile.php?mode=view&id=" . $listReviews->fil_id[$i] . "\">" . $strings["view"] . "</a>";
                $folder = $listReviews->fil_project[$i] . "/" . $listReviews->fil_task[$i];
                $existFile = "true";
            } 
        } else {
            if (file_exists("../files/" . $listReviews->fil_project[$i] . "/" . $listReviews->fil_name[$i])) {
                echo "<a href=\"clientaccessfile.php?mode=view&id=" . $listReviews->fil_id[$i] . "\">" . $strings["view"] . "</a>";
                $folder = $listReviews->fil_project[$i];
                $existFile = "true";
            } 
        } 
        if ($existFile == "true") {
            echo " <a href=\"clientaccessfile.php?mode=download&id=" . $listReviews->fil_id[$i] . "\">" . $strings["save"] . "</a>";
        } else {
            echo $strings["missing_file"];
        } 
        echo"</td><td align=\"right\">Revision: $displayrev&nbsp;&nbsp;</td></tr>
	<tr height=\"30\"><td>&nbsp;</td><td>" . $strings["ifc_revision_of"] . " : " . $listReviews->fil_vc_version[$i] . "</td><td width=\"150\">" . $strings["owner"] . " : " . $listReviews->fil_mem_name[$i] . "</td><td>" . $strings["date"] . " : " . $listReviews->fil_date[$i] . "</td></tr>
	<tr><td>&nbsp;</td><td colspan=\"4\">" . $strings["comments"] . " : " . $listReviews->fil_comments[$i] . "</td></tr>
	</table><br>";
    } 
    if ($i == 0) {
        echo"<tr class=\"odd\"><td></td><td>" . $strings["ifc_no_revisions"] . "</td></tr>";
    } 
    echo "</table></td></tr>
	</table>					  
  </td>
 </tr>
</table>";
    // Table 3 - ADD REVIEW TABLE.
    echo "<table cellpadding=20 cellspacing=0 border=0 width=\"100%\">

 <tr>
   <td><h1 class=\"heading\">" . $strings["ifc_add_revision"] . "</h1>
	<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\">
	<tr height=\"15\"><th width=\"100%\" class=\"ModuleColumnHeaderSort\"><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></th></tr>
	<tr><td width=\"40%\" class=\"$class\"><table cellspacing=\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\">";

    echo "<a name=\"filedetailsAnchor\"></a>";
    echo "<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/clientfiledetail.php?action=add&amp;id=" . $fileDetail->fil_id[0] . "#filedetailsAnchor\" name=\"filedetailsForm\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\"><input type=\"hidden\" name=\"maxCustom\" value=\"" . $projectDetail->pro_upload_max[0] . "\">"; 
    // Add one to the number of current revisions
    $revision = $displayrev + 1;

    echo "<input value=\"" . $fileDetail->fil_id[0] . "\" name=\"sendto\" type=\"hidden\">
	<input value=\"" . $fileDetail->fil_id[0] . "\" name=\"parent\" type=\"hidden\">
	<input value=\"$revision\" name=\"revision\" type=\"hidden\">
	<input value=\"" . $fileDetail->fil_vc_version[0] . "\" name=\"oldversion\" type=\"hidden\">
	<input value=\"" . $fileDetail->fil_project[0] . "\" name=\"project\" type=\"hidden\">
	<input value=\"" . $fileDetail->fil_task[0] . "\" name=\"task\" type=\"hidden\">
	<input value=\"" . $fileDetail->fil_name[0] . "\" name=\"filename\" type=\"hidden\">
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* " . $strings["upload"] . " :</td><td><input size=\"44\" style=\"width: 400px\" name=\"upload\" type=\"FILE\"></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["comments"] . " :</td><td><textarea rows=\"3\" style=\"width: 400px; height: 50px;\" name=\"c\" cols=\"43\">$c</textarea></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["save"] . "\"><br><br>$error3</td></tr></form>";
    echo "</table></td></tr>
	</table>					  
  </td>
 </tr>
</table>";
} 
// Table 4
if ($fileDetail->fil_owner[0] == $_SESSION['idSession']) {
    echo "<table cellpadding=20 cellspacing=0 border=0 width=\"100%\">
 <tr>
   <td><h1 class=\"heading\">" . $strings["ifc_update_file"] . "</h1>
	<table cellspacing=\"0\" width=\"90%\" border=\"0\" cellpadding=\"3\" cols=\"4\">
	<tr height=\"15\"><th width=\"100%\" class=\"ModuleColumnHeaderSort\"><img src=\"../themes/" . THEME . "/spacer.gif\" width=\"1\" height=\"1\" border=\"0\"></th></tr>
	<tr><td width=\"40%\" class=\"$class\">
<form accept-charset=\"UNKNOWN\" method=\"POST\" action=\"../projects_site/clientfiledetail.php?action=update&amp;id=" . $fileDetail->fil_id[0] . "#filedetailsAnchor\" name=\"filedetailsForm\" enctype=\"multipart/form-data\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\"><input type=\"hidden\" name=\"maxCustom\" value=\"" . $projectDetail->pro_upload_max[0] . "\">
<table cellpadding =\"0\" width=\"100%\" border=\"0\" cellpadding=\"0\">";

    echo "<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\"></td><td class=\"odd\">" . $strings["version_increm"] . "<br>
	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	<tr><td align=\"right\">0.01</td><td width=\"30\" align=\"right\"><input name=\"change_file_version\" type=\"radio\" value=\"0.01\"></td></tr>
	<tr><td align=\"right\">0.1</td><td width=\"30\" align=\"right\"><input name=\"change_file_version\" type=\"radio\" value=\"0.1\" checked></td></tr>
	<tr><td align=\"right\">1.0</td><td width=\"30\" align=\"right\"><input name=\"change_file_version\" type=\"radio\" value=\"1.0\"></td></tr>
	</table>
	</td></tr>";

    echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["status"] . " :</td><td><select name=\"statusField\">";
    $comptSta = count($statusFile);

    for ($i = 0;$i < $comptSta;$i++) {
        if ($fileDetail->fil_status[0] == $i) {
            echo "<option value=\"$i\" selected>$statusFile[$i]</option>";
        } else {
            echo "<option value=\"$i\">$statusFile[$i]</option>";
        } 
    } 
    echo"</select></td></tr>";
    echo"<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">* " . $strings["upload"] . " :</td><td><input size=\"44\" style=\"width: 400px\" name=\"upload\" type=\"FILE\"></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">" . $strings["comments"] . " :</td><td><textarea rows=\"3\" style=\"width: 400px; height: 50px;\" name=\"c\" cols=\"43\">$c</textarea></td></tr>
	<tr class=\"odd\"><td valign=\"top\" class=\"leftvalue\">&nbsp;</td><td><input type=\"SUBMIT\" value=\"" . $strings["ifc_update_file"] . "\"><br><br>$error4</td></tr></form>";
    echo "</table></td></tr>
	</table>					  
  </td>
 </tr>

</table>";
} 

require_once ("include_footer.php");

?>
