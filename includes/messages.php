<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: messages.php,v 1.3 2004/12/06 06:15:45 luiswang Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

switch ($msg) {
    case demo:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["demo_mode"] . " " . buildLink($urlContact, $strings["sourceforge_link"], LINK_OUT);
        break;

    case permissiondenied:
        $msgLabel = $strings["no_permissions"];
        break;

    case logout:
        $msgLabel = $strings["success_logout"];
        break;

    case noteOwner:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["note_owner"];
        break;

    case taskOwner:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["task_owner"];
        break;

    case projectOwner:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["project_owner"];
        break;

    case email_pwd:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["email_pwd"];
        break;

    case deleteTopic:
        $msgLabel = "<b>" . $strings["success"] . "</b> : $num of $num discussions were deleted.";
        break;

    case closeTopic:
        $msgLabel = "<b>" . $strings["success"] . "</b> : $num of $num discussions were closed.";
        break;

    case createProjectSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : The project site \"" . $projectDetail->pro_name[0] . "\" was successfully created.";
        break;

    case removeProjectSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["project_site_deleted"];
        break;

    case addClientToSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["add_user_project_site"];
        break;

    case removeClientToSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["remove_user_project_site"];
        break;

    case deleteTeamOwnerMix:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["delete_teamownermix"];
        break;

    case deleteTeamOwner:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["delete_teamowner"];
        break;

    case addToSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["add_project_site_success"];
        break;

    case removeToSite:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["remove_project_site_success"];
        break;

    case updateFile:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["update_comment_file"];
        break;

    case addFile:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["add_file_success"];
        break;

    case deleteFile:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["delete_file_success"];
        break;

    case add:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["addition_succeeded"];
        break;

    case delete:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["deletion_succeeded"];
        break;

    case addReport:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["report_created"];
        break;

    case deleteReport:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["deleted_reports"];
        break;

    case addAssignment:
        $tmpquery = $tableCollab["assignments"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["addition_succeeded"] . " " . $strings["add_optional"] . " " . buildLink("assignmentcomment.php?task=" . $taskDetail->tas_id[0] . "&amp;id=$num", "<b>" . $strings["assignment_comment"] . "</b>", LINK_INSIDE);
        break;

    case updateAssignment:
        $tmpquery = $tableCollab["assignments"];
        last_id($tmpquery);
        $num = $lastId[0];
        unset($lastId);
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["modification_succeeded"] . " " . $strings["add_optional"] . " " . buildLink("assignmentcomment.php?task=" . $taskDetail->tas_id[0] . "&amp;id=$num", "<b>" . $strings["assignment_comment"] . "</b>", LINK_INSIDE);
        break;

    case update:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["modification_succeeded"];
        break;

    case blankUser:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["blank_user"];
        break;

    case blankClient:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["blank_organization"];
        break;

    case blankProject:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["blank_project"];
        break;

    case settingsNotwritable:
        $msgLabel = "<b>" . $strings["attention"] . "</b> : " . $strings["settings_notwritable"];
        break;

    case email:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["email_sent"];
        break;

    case emailpwd:
        $msgLabel = '<b>' . $strings['success'] . '</b> : ' . $strings['email_pwd'];
        break;

    case addMeeting:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["addition_succeeded"];
        break;

    case updateAttendants:
        $msgLabel = "<b>" . $strings["success"] . "</b> : " . $strings["attendants_modification_succeeded"];
        break;
} 

?>
