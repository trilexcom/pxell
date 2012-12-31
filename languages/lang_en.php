<?php // $Revision: 1.15 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: lang_en.php,v 1.15 2005/06/11 16:19:50 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s): St�phane Dion <contact@sdion.net>
//                Luis, Wang <wenwen_tw@yahoo.com>
$topicNote = array(1 => 'Phone Conversation',
    2 => 'Conference Notes',
    3 => 'General Notes'
    );

$phaseArraySets = array(
    // Define the names of your phase sets
    'sets' => array(1 => 'Website', 2 => 'Application'), 
    // List the individual items within each phase set.
    // Website Set
    1 => array(0 => 'Concept', 1 => 'Planning', 2 => 'Development',
        3 => 'Testing', 4 => 'Rollout', 5 => 'Maintenance'), 
    // Application Set
    2 => array(0 => 'Concept', 1 => 'Planning', 2 => 'Development',
        3 => 'Testing', 4 => 'Rollout', 5 => 'Maintenance')
    );

$autoLogoutOptions = array(
    0 => 'Disabled',
    300 => '5 minutes',
    600 => '10 minutes',
    900 => '15 minutes',
    1800 => '30 minutes',
    2700 => '45 minutes',
    3600 => '60 minutes'
    );

$startPageOptions = array(
    'general/home.php' => 'Home page',
    'calendar/viewcalendar.php' => 'Calendar',
    'bookmarks/listbookmarks.php?view=my' => 'My Bookmarks',
    'reports/createreport.php?typeReports=custom' => 'Reports',
    );

$setCharset = 'ISO-8859-1';

$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$dayNameArray = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');

$monthNameArray = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$status = array(0 => 'Client Completed', 1 => 'Completed', 2 => 'Not Started', 3 => 'Open', 4 => 'Suspended', 5 => 'Proposed', 6 => 'Canceled');

$profil = array(0 => 'Administrator', 1 => 'Project Manager', 2 => 'User', 3 => 'Client User', 4 => 'Disabled', 5 => 'Project Manager Administrator');

$priority = array(0 => 'None', 1 => 'Very low', 2 => 'Low', 3 => 'Medium', 4 => 'High', 5 => 'Very high');

$statusTopic = array(0 => 'Closed', 1 => 'Open');
$statusTopicBis = array(0 => 'Yes', 1 => 'No');

$statusPublish = array(0 => 'Yes', 1 => 'No');

$statusFile = array(0 => 'Approved', 1 => 'Approved With Changes', 2 => 'Needs Approval', 3 => 'No Approvals Needed', 4 => 'Not Approved');

$phaseStatus = array(0 => 'Not started', 1 => 'Open', 2 => 'Complete', 3 => 'Suspended');

$requestStatus = array(0 => 'New', 1 => 'Open', 2 => 'Complete');

//$projectType = array(0 => 'Free project', 1 => 'Fee project');
$projectType = array(0 => 'Internal project', 1 => 'External project', 2 => 'Research', 3 => 'Administration', 4 => 'Training');

$strings['home_of']= 'Home of';
$strings['please_login'] = 'Please log in';
$strings['requirements'] = 'System Requirements';
$strings['login'] = 'Log In';
$strings['no_items'] = 'No items to display';
$strings['logout'] = 'Log Out';
$strings['preferences'] = 'Preferences';
$strings['my_tasks'] = 'My open Tasks';
$strings['tasks_closed'] = 'Task closed';
$strings['tasks_open'] = 'Task open';
$strings['edit_task'] = 'Edit Task';
$strings['copy_task'] = 'Copy Task';
$strings['add_task'] = 'Add Task';
$strings['delete_tasks'] = 'Delete Tasks';
$strings['assignment_history'] = 'Assignment History';
$strings['assigned_on'] = 'Assigned On';
$strings['assigned_by'] = 'Assigned By';
$strings['to'] = 'To';
$strings['comment'] = 'Comment';
$strings['task_assigned'] = 'Task assigned to ';
$strings['task_unassigned'] = 'Task assigned to Unassigned (Unassigned)';
$strings['edit_multiple_tasks'] = 'Edit Multiple Tasks';
$strings['tasks_selected'] = 'tasks selected. Choose new values for these tasks, or select [No Change] to retain current values.';
$strings['assignment_comment'] = 'Assignment Comment';
$strings['no_change'] = '[No Change]';
$strings['my_discussions'] = 'My Discussions';
$strings['discussions'] = 'Discussions';
$strings['delete_discussions'] = 'Delete Discussions';
$strings['delete_discussions_note'] = 'Note: Discussions cannot be reopened once they are deleted.';
$strings['topic'] = 'Topic';
$strings['posts'] = 'Posts';
$strings['latest_post'] = 'Latest Post';
$strings['my_reports'] = 'My Reports';
$strings['reports'] = 'Reports';
$strings['create_report'] = 'Create Report';
$strings['report_intro'] = 'Select your task reporting parameters here and save the query on the results page after running your report.';
$strings['admin_intro'] = 'Project settings and configuration.';
$strings['copy_of'] = 'Copy of ';
$strings['add'] = 'Add';
$strings['delete'] = 'Delete';
$strings['remove'] = 'Remove';
$strings['copy'] = 'Copy';
$strings['view'] = 'View';
$strings['edit'] = 'Edit';
$strings['update'] = 'Update';
$strings['details'] = 'Details';
$strings['none'] = 'None';
$strings['close'] = 'Close';
$strings['new'] = 'New';
$strings['select_all'] = 'Select All';
$strings['unassigned'] = 'Unassigned';
$strings['administrator'] = 'Administrator';
$strings['my_projects'] = 'My Projects';
$strings['project'] = 'Project';
$strings['active'] = 'Active';
$strings['inactive'] = 'Inactive';
$strings['project_id'] = 'Project ID';
$strings['edit_project'] = 'Edit Project';
$strings['copy_project'] = 'Copy Project';
$strings['add_project'] = 'Add Project';
$strings['clients'] = 'Clients';
$strings['organization'] = 'Client Organization';
$strings['client_projects'] = 'Client Projects';
$strings['client_users'] = 'Client Users';
$strings['edit_organization'] = 'Edit Client Organization';
$strings['add_organization'] = 'Add Client Organization';
$strings['organizations'] = 'Client Organizations';
$strings['info'] = 'Info';
$strings['status'] = 'Status';
$strings['owner'] = 'Owner';
$strings['home'] = 'Home';
$strings['projects'] = 'Projects';
$strings['files'] = 'Files';
$strings['search'] = 'Search';
$strings['admin'] = 'Admin';
$strings['user'] = 'User';
$strings['project_manager'] = 'Project Manager';
$strings['due'] = 'Due';
$strings['task'] = 'Task';
$strings['tasks'] = 'Tasks';
$strings['team'] = 'Team';
$strings['add_team'] = 'Add Team Members';
$strings['team_members'] = 'Team Members';
$strings['full_name'] = 'Full name';
$strings['title'] = 'Title';
$strings['user_name'] = 'User Name';
$strings['work_phone'] = 'Work Phone';
$strings['priority'] = 'Priority';
$strings['name'] = 'Name';
$strings['id'] = 'ID';
$strings['description'] = 'Description';
$strings['phone'] = 'Phone';
$strings['url'] = 'URL';
$strings['address'] = 'Address';
$strings['comments'] = 'Comments';
$strings['created'] = 'Created';
$strings['assigned'] = 'Assigned';
$strings['modified'] = 'Modified';
$strings['assigned_to'] = 'Assigned to';
$strings['due_date'] = 'Due Date';
$strings['estimated_time'] = 'Estimated Time';
$strings['actual_time'] = 'Actual Time';
$strings['delete_following'] = 'Delete the following?';
$strings['cancel'] = 'Cancel';
$strings['and'] = 'and';
$strings['administration'] = 'Administration';
$strings['user_management'] = 'User Management';
$strings['system_information'] = 'System Information';
$strings['product_information'] = 'Product Information';
$strings['system_properties'] = 'System Properties';
$strings['create'] = 'Create';
$strings['report_save'] = 'Save this report query to your homepage so you can run the query again.';
$strings['report_name'] = 'Report Name';
$strings['save'] = 'Save';
$strings['matches'] = 'Matches';
$strings['match'] = 'Match';
$strings['report_results'] = 'Report Results';
$strings['success'] = 'Success';
$strings['addition_succeeded'] = 'Addition succeeded';
$strings['deletion_succeeded'] = 'Deletion succeeded';
$strings['report_created'] = 'Created report';
$strings['deleted_reports'] = 'Deleted reports';
$strings['modification_succeeded'] = 'Modification succeeded';
$strings['errors'] = 'Errors found!';
$strings['blank_user'] = 'The user cannot be found.';
$strings['blank_organization'] = 'The client organization cannot be located.';
$strings['blank_project'] = 'The project cannot be located.';
$strings['user_profile'] = 'User Profile';
$strings['change_password'] = 'Change Password';
$strings['change_password_user'] = 'Change the user\'s password.';
$strings['old_password_error'] = 'The old password you entered is incorrect. Please re-enter the old password.';
$strings['new_password_error'] = 'The two passwords you entered did not match. Please re-enter your new password.';
$strings['notifications'] = 'Notifications';
$strings['change_password_intro'] = 'Enter your old password then enter and confirm your new password.';
$strings['old_password'] = 'Old Password';
$strings['password'] = 'Password';
$strings['new_password'] = 'New Password';
$strings['confirm_password'] = 'Confirm Password';
$strings['email'] = 'E-Mail';
$strings['home_phone'] = 'Home Phone';
$strings['mobile_phone'] = 'Mobile Phone';
$strings['fax'] = 'Fax';
$strings['permissions'] = 'Permissions';
$strings['administrator_permissions'] = 'Administrator Permissions';
$strings['project_manager_permissions'] = 'Project Manager Permissions';
$strings['user_permissions'] = 'User Permissions';
$strings['account_created'] = 'Account Created';
$strings['edit_user'] = 'Edit User';
$strings['edit_user_details'] = 'Edit the user account details.';
$strings['change_user_password'] = 'Change the user\'s password.';
$strings['select_permissions'] = 'Select permissions for this user';
$strings['add_user'] = 'Add User';
$strings['enter_user_details'] = 'Enter details for the user account you are creating.';
$strings['enter_password'] = 'Enter the user\'s password.';
$strings['success_logout'] = 'You have successfully logged out. You can log back in by typing your user name and password below.';
$strings['invalid_login'] = 'The user name and/or password you entered is invalid. Please re-enter your login information.';
$strings['profile'] = 'Profile';
$strings['user_details'] = 'User account details.';
$strings['edit_user_account'] = 'Edit your account information.';
$strings['no_permissions'] = 'You do not have sufficient permissions to perform that action.';
$strings['discussion'] = 'Discussion';
$strings['retired'] = 'Retired';
$strings['last_post'] = 'Last Post';
$strings['post_reply'] = 'Post Reply';
$strings['posted_by'] = 'Posted By';
$strings['when'] = 'When';
$strings['post_to_discussion'] = 'Post to Discussion';
$strings['message'] = 'Message';
$strings['delete_reports'] = 'Delete Reports';
$strings['delete_projects'] = 'Delete Projects';
$strings['delete_organizations'] = 'Delete Client Organizations';
$strings['delete_organizations_note'] = 'Note: This will delete all client users for these client organizations, and disassociate all open projects from these client organizations.';
$strings['delete_messages'] = 'Delete Messages';
$strings['attention'] = 'Attention';
$strings['delete_teamownermix'] = 'Removal successful, but the project owner cannot be removed from the project team.';
$strings['delete_teamowner'] = 'You cannot remove the project owner from the project team.';
$strings['enter_keywords'] = 'Enter keywords';
$strings['search_options'] = 'Keyword and Search Options';
$strings['search_note'] = 'You must enter information in the Search for field.';
$strings['search_results'] = 'Search Results';
$strings['users'] = 'Users';
$strings['search_for'] = 'Search for';
$strings['results_for_keywords'] = 'Search results for keywords';
$strings['add_discussion'] = 'Add Discussion';
$strings['delete_users'] = 'Delete User Accounts';
$strings['reassignment_user'] = 'Project and Task Reassignment';
$strings['there'] = 'There are';
$strings['owned_by'] = 'owned by the users above.';
$strings['reassign_to'] = 'Before deleting users, reassign these to';
$strings['no_files'] = 'No files linked';
$strings['published'] = 'Published';
$strings['project_site'] = 'Project Site';
$strings['approval_tracking'] = 'Approval Tracking';
$strings['size'] = 'Size';
$strings['add_project_site'] = 'Add to Project Site';
$strings['remove_project_site'] = 'Remove from Project Site';
$strings['more_search'] = 'More search options';
$strings['results_with'] = 'Find Results With';
$strings['search_topics'] = 'Search Topics';
$strings['search_properties'] = 'Search Properties';
$strings['date_restrictions'] = 'Date Restrictions';
$strings['case_sensitive'] = 'Case Sensitive';
$strings['yes'] = 'Yes';
$strings['no'] = 'No';
$strings['sort_by'] = 'Sort by';
$strings['type'] = 'Type';
$strings['date'] = 'Date';
$strings['all_words'] = 'all of the words';
$strings['any_words'] = 'any of the words';
$strings['exact_match'] = 'exact match';
$strings['all_dates'] = 'All dates';
$strings['between_dates'] = 'Between dates';
$strings['all_content'] = 'All content';
$strings['all_properties'] = 'All properties';
$strings['no_results_search'] = 'The search returned no results.';
$strings['no_results_report'] = 'The report returned no results.';
$strings['schema_date'] = 'YYYY/MM/DD';
$strings['hours'] = 'hours';
$strings['choice'] = 'Choice';
$strings['missing_file'] = 'Missing file !';
$strings['project_site_deleted'] = 'The project site was successfully deleted.';
$strings['add_user_project_site'] = 'The user was successfully granted permission to access the Project Site.';
$strings['remove_user_project_site'] = 'User permission was successfully removed.';
$strings['add_project_site_success'] = 'The addition to the project site succeeded.';
$strings['remove_project_site_success'] = 'The removal from the project site succeeded.';
$strings['add_file_success'] = 'Linked 1 content item.';
$strings['delete_file_success'] = 'Unlinking succeeded.';
$strings['update_comment_file'] = 'The file comment was updated successfully.';
$strings['session_false'] = 'Session error';
$strings['logs'] = 'Logs';
$strings['logout_time'] = 'Auto Log Out';
$strings['noti_foot1'] = 'This notification was generated by NetOffice.';
$strings['noti_foot2'] = 'To view your NetOffice Home Page, visit:';
$strings['noti_taskassignment1'] = 'New task:';
$strings['noti_taskassignment2'] = 'A task has been assigned to you:';
$strings['noti_moreinfo'] = 'For more information, please visit:';
$strings['noti_prioritytaskchange1'] = 'Task priority changed:';
$strings['noti_prioritytaskchange2'] = 'The priority of the following task has changed:';
$strings['noti_statustaskchange1'] = 'Task status changed:';
$strings['noti_statustaskchange2'] = 'The status of the following task has changed:';
$strings['login_username'] = 'You must enter a user name.';
$strings['login_password'] = 'Please enter a password.';
$strings['login_clientuser'] = 'This is a client user account. You cannot access NetOffice with a client user account.';
$strings['user_already_exists'] = 'There is already a user with this name. Please choose a variation of the user\'s name.';
$strings['noti_duedatetaskchange1'] = 'Task due date changed:';
$strings['noti_duedatetaskchange2'] = 'The due date of the following task has changed:';
$strings['company'] = 'Company';
$strings['show_all'] = 'Show All';
$strings['information'] = 'Information';
$strings['delete_message'] = 'Delete this message';
$strings['project_team'] = 'Project Team';
$strings['document_list'] = 'Document List';
$strings['bulletin_board'] = 'Bulletin Board';
$strings['bulletin_board_topic'] = 'Bulletin Board Topic';
$strings['create_topic'] = 'Create a New Topic';
$strings['topic_form'] = 'Topic Form';
$strings['enter_message'] = 'Enter your message';
$strings['upload_file'] = 'Upload a File';
$strings['upload_form'] = 'Upload Form';
$strings['upload'] = 'Upload';
$strings['document'] = 'Document';
$strings['approval_comments'] = 'Approval Comments';
$strings['client_tasks'] = 'Client Tasks';
$strings['team_tasks'] = 'Team Tasks';
$strings['team_member_details'] = 'Project Team Member Details';
$strings['client_task_details'] = 'Client Task Details';
$strings['team_task_details'] = 'Team Task Details';
$strings['language'] = 'Language';
$strings['welcome'] = 'Welcome';
$strings['your_projectsite'] = 'to Your Project Site';
$strings['contact_projectsite'] = 'If you have any questions about the extranet or the information found here, please contact the project lead';
$strings['company_details'] = 'Company Details';
$strings['database'] = 'Backup and restore database';
$strings['company_info'] = 'Edit your company informations';
$strings['create_projectsite'] = 'Create Project Site';
$strings['projectsite_url'] = 'Project Site URL';
$strings['design_template'] = 'Design Template';
$strings['preview_design_template'] = 'Preview Template Design';
$strings['delete_projectsite'] = 'Delete Project Site';
$strings['add_file'] = 'Add File';
$strings['linked_content'] = 'Linked Content';
$strings['edit_file'] = 'Edit file details';
$strings['permitted_client'] = 'Permitted Client Users';
$strings['grant_client'] = 'Grant Permission to View Project Site';
$strings['add_client_user'] = 'Add Client User';
$strings['edit_client_user'] = 'Edit Client User';
$strings['client_user'] = 'Client User';
$strings['client_change_status'] = 'Change your status below when you have completed this task';
$strings['project_status'] = 'Project Status';
$strings['view_projectsite'] = 'View Project Site';
$strings['enter_login'] = 'Enter your login to receive new password';
$strings['send'] = 'Send';
$strings['no_login'] = 'Login not found in database';
$strings['email_pwd'] = 'Password sent';
$strings['no_email'] = 'User without email';
$strings['forgot_pwd'] = 'Forgot password ?';
$strings['project_owner'] = 'You can make changes only on your own projects.';
$strings['connected'] = 'Connected';
$strings['session'] = 'Session';
$strings['last_visit'] = 'Last visit';
$strings['compteur'] = 'Count';
$strings['ip'] = 'Ip';
$strings['task_owner'] = 'You are not a team member in this project';
$strings['export'] = 'Export';
$strings['browse_cvs'] = 'Browse CVS';
$strings['repository'] = 'CVS Repository';
$strings['reassignment_clientuser'] = 'Task Reassignment';
$strings['organization_already_exists'] = 'That name is already in use in the system. Please choose another.';
$strings['blank_organization_field'] = 'You must enter the client organization name.';
$strings['blank_fields'] = 'mandatory fiels';
$strings['projectsite_login_fails'] = 'We are unable to confirm the user name and password combination.';
$strings['start_date'] = 'Start date';
$strings['completion'] = 'Completion';
$strings['update_available'] = 'An update is available!';
$strings['version_current'] = 'You are currently using version';
$strings['version_latest'] = 'The latest version is';
$strings['sourceforge_link'] = 'See project page on Sourceforge';
$strings['demo_mode'] = 'Demo mode. Action not allowed.';
$strings['setup_erase'] = 'Erase the file setup.php!!';
$strings['no_file'] = 'No file selected';
$strings['exceed_size'] = 'Exceed max file size';
$strings['no_php'] = 'Php file not allowed';
$strings['approval_date'] = 'Approval date';
$strings['approver'] = 'Approver';
$strings['error_database'] = 'Can\'t connect to database';
$strings['error_server'] = 'Can\'t connect to server';
$strings['version_control'] = 'Version Control';
$strings['vc_status'] = 'Status';
$strings['vc_last_in'] = 'Date last modified';
$strings['ifa_comments'] = 'Approval comments';
$strings['ifa_command'] = 'Change approval status';
$strings['vc_version'] = 'Version';
$strings['ifc_revisions'] = 'Peer Reviews';
$strings['ifc_revision_of'] = 'Review of version';
$strings['ifc_add_revision'] = 'Add Peer Review';
$strings['ifc_update_file'] = 'Update file';
$strings['ifc_last_date'] = 'Date last modified';
$strings['ifc_version_history'] = 'Version History';
$strings['ifc_delete_file'] = 'Delete file and all child versions & reviews';
$strings['ifc_delete_version'] = 'Delete Selected Version';
$strings['ifc_delete_review'] = 'Delete Selected Review';
$strings['ifc_no_revisions'] = 'There are currently no revisions of this document';
$strings['unlink_files'] = 'Unlink Files';
$strings['remove_team'] = 'Remove Team Members';
$strings['remove_team_info'] = 'Remove these users from the project team?';
$strings['remove_team_client'] = 'Remove Permission to View Project Site';
$strings['note'] = 'Note';
$strings['notes'] = 'Notes';
$strings['subject'] = 'Subject';
$strings['delete_note'] = 'Delete Notes Entries';
$strings['add_note'] = 'Add Note Entry';
$strings['edit_note'] = 'Edit Note Entry';
$strings['version_increm'] = 'Select the version change to apply:';
$strings['url_dev'] = 'Development site url';
$strings['url_prod'] = 'Final site url';
$strings['note_owner'] = 'You can make changes only on your own notes.';
$strings['alpha_only'] = 'Alpha-numeric only in login';
$strings['edit_notifications'] = 'Edit E-mail Notifications';
$strings['edit_notifications_info'] = 'Select events for which you wish to receive E-mail notification.';
$strings['select_deselect'] = 'Select/Deselect All';
$strings['noti_addprojectteam1'] = 'Added to project team :';
$strings['noti_addprojectteam2'] = 'You have been added to the project team for :';
$strings['noti_removeprojectteam1'] = 'Removed from project team :';
$strings['noti_removeprojectteam2'] = 'You have been removed from the project team for :';
$strings['noti_newpost1'] = 'New post :';
$strings['noti_newpost2'] = 'A post was added to the following discussion :';
$strings['edit_noti_taskassignment'] = 'I am assigned to a new task.';
$strings['edit_noti_statustaskchange'] = 'The status of one of my tasks changes.';
$strings['edit_noti_prioritytaskchange'] = 'The priority of one of my tasks changes.';
$strings['edit_noti_duedatetaskchange'] = 'The due date of one of my tasks changes.';
$strings['edit_noti_addprojectteam'] = 'I am added to a project team.';
$strings['edit_noti_removeprojectteam'] = 'I am removed from a project team.';
$strings['edit_noti_newpost'] = 'A new post is made to a discussion.';
$strings['add_optional'] = 'Add an optional';
$strings['assignment_comment_info'] = 'Add comments about the assignment of this task';
$strings['my_notes'] = 'My Notes';
$strings['edit_settings'] = 'Edit settings';
$strings['max_upload'] = 'Max file size';
$strings['project_folder_size'] = 'Project folder size';
$strings['calendar'] = 'Calendar';
$strings['date_start'] = 'Start date';
$strings['date_end'] = 'End date';
$strings['time_start'] = 'Start time';
$strings['time_end'] = 'End time';
$strings['calendar_reminder'] = 'Reminder';
$strings['shortname'] = 'Short name';
$strings['calendar_recurring'] = 'Event recurs every week on this day';
$strings['edit_database'] = 'Edit database';
$strings['noti_newtopic1'] = 'New discussion :';
$strings['noti_newtopic2'] = 'A new discussion was added to the following project :';
$strings['edit_noti_newtopic'] = 'A new discussion topic was created.';
$strings['today'] = 'Today';
$strings['previous'] = 'Previous';
$strings['next'] = 'Next';
$strings['help'] = 'Help';
$strings['complete_date'] = 'Complete date';
$strings['scope_creep'] = 'Scope creep';
$strings['days'] = 'Days';
$strings['logo'] = 'Logo';
$strings['remember_password'] = 'Remember Password';
$strings['client_add_task_note'] = 'Note: The entered task is registered into the database, but it will only appear when it has been assigned to a team member.';
$strings['noti_clientaddtask1'] = 'Task added by client :';
$strings['noti_clientaddtask2'] = 'A new task was added by client from project site to the following project :';
$strings['phase'] = 'Phase';
$strings['phases'] = 'Phases';
$strings['phase_id'] = 'Phase ID';
$strings['current_phase'] = 'Active phase(s)';
$strings['edit_phase'] = 'Edit Phase';
$strings['total_tasks'] = 'Total Tasks';
$strings['uncomplete_tasks'] = 'Uncompleted Tasks';
$strings['no_current_phase'] = 'No phase is currently active';
$strings['true'] = 'True';
$strings['false'] = 'False';
$strings['enable_phases'] = 'Enable Phases';
$strings['phase_enabled'] = 'Phase Enabled';
$strings['order'] = 'Order';
$strings['options'] = 'Options';
$strings['support'] = 'Support';
$strings['support_request'] = 'Support Request';
$strings['support_requests'] = 'Support Requests';
$strings['support_id'] = 'Request ID';
$strings['my_support_request'] = 'My Support Requests';
$strings['introduction'] = 'Introduction';
$strings['submit'] = 'Submit';
$strings['support_management'] = 'Support Management';
$strings['date_open'] = 'Date Opened';
$strings['date_close'] = 'Date Closed';
$strings['add_support_request'] = 'Add Support Request';
$strings['add_support_response'] = 'Add Support Response';
$strings['respond'] = 'Respond';
$strings['delete_support_request'] = 'Support request deleted';
$strings['delete_request'] = 'Delete support request';
$strings['delete_support_post'] = 'Delete support post';
$strings['new_requests'] = 'New requests';
$strings['open_requests'] = 'Open requests';
$strings['closed_requests'] = 'Complete requests';
$strings['manage_new_requests'] = 'Manage new requests';
$strings['manage_open_requests'] = 'Manage open requests';
$strings['manage_closed_requests'] = 'Manage complete requests';
$strings['responses'] = 'Responses';
$strings['edit_status'] = 'Edit Status';
$strings['noti_support_request_new2'] = 'You have submited a support request regarding: ';
$strings['noti_support_post2'] = 'A new response has been added to your support request. Please review the details below.';
$strings['noti_support_status2'] = 'Your support request has been updated. Please review the details below.';
$strings['noti_support_team_new2'] = 'A new support request has been added to project: ';
// 2.0
$strings['delete_subtasks'] = 'Delete subtasks';
$strings['add_subtask'] = 'Add subtask';
$strings['edit_subtask'] = 'Edit subtask';
$strings['subtask'] = 'Subtask';
$strings['subtasks'] = 'Subtasks';
$strings['show_details'] = 'Show details';
$strings['updates_task'] = 'Task update history';
$strings['updates_subtask'] = 'Subtask update history';
// 2.1
$strings['go_projects_site'] = 'Go to projects site';
$strings['bookmark'] = 'Bookmark';
$strings['bookmarks'] = 'Bookmarks';
$strings['bookmark_category'] = 'Category';
$strings['bookmark_category_new'] = 'New category';
$strings['bookmarks_all'] = 'All';
$strings['bookmarks_my'] = 'My Bookmarks';
$strings['my'] = 'My';
$strings['bookmarks_private'] = 'Private';
$strings['shared'] = 'Shared';
$strings['private'] = 'Private';
$strings['add_bookmark'] = 'Add bookmark';
$strings['edit_bookmark'] = 'Edit bookmark';
$strings['delete_bookmarks'] = 'Delete bookmarks';
$strings['team_subtask_details'] = 'Team Subtask Details';
$strings['client_subtask_details'] = 'Client Subtask Details';
$strings['client_change_status_subtask'] = 'Change your status below when you have completed this subtask';
$strings['disabled_permissions'] = 'Disabled account';
$strings['user_timezone'] = 'Timezone (GMT)';
// 2.2
$strings['project_manager_administrator_permissions'] = 'Project Manager Administrator';
$strings['bug'] = 'Bug Tracking';
// 2.3
$strings['report'] = 'Report';
$strings['license'] = 'License';
// 2.4
$strings['settings_notwritable'] = 'Settings.php file is not writable';
// 2.5
$strings['name_print'] = 'Name printed';
$strings['calculation'] = 'Calculation';
$strings['items'] = 'Items';
$strings['position'] = 'Position';
$strings['completed'] = 'Completed';
$strings['service'] = 'Service';
$strings['service_management'] = 'Service management';
$strings['hourly_rate'] = 'Hourly rate';
$strings['add_service'] = 'Add service';
$strings['edit_service'] = 'Edit service';
$strings['delete_services'] = 'Delete services';
$strings['worked_hours'] = 'Worked hours';
$strings["loghours"] = 'Log Hours';
$strings["logtime"] = 'Log Time';
$strings["loggedby"] = 'Logged by';
$strings["error_required"] = 'is required';
$strings["error_numerical"] = 'must be numerical';
$strings["hours_updated"] = 'Task Hours Updated';
$strings['add_task_time'] = 'Add Task Time';
$strings['edit_task_time'] = 'Edit Task Time';
$strings['delete_task_time'] = 'Delete Task Time';
$strings['task_time'] = 'Task Time';
// 2.5.1
$strings["email_users"] = "Email Users";
$strings["email_following"] = "Email Following";
$strings["email_sent"] = "Your email was successfully sent.";
$strings['all'] = 'All';
$strings['custom_reports'] = 'Custom Reports';
$strings['custom_report_intro'] = 'Choose the custom report below based on its description that best fits your reporting needs.';
$strings['completed_task_report'] = 'Completed Task';
$strings['completed_task_report_desc'] = 'This report provides a listing of the
tasks completed during the previous month.';
$strings['time_report'] = 'Time Report';
$strings['time_report_desc'] = 'This report provides a listing of the hours logged by employee for each project for the previous month and allows you the opportunity to export that information.';
$strings['overdue_tasks'] = 'Overdue Tasks';
$strings['overdue_tasks_desc'] = 'This report displays a listing of the overview tasks within all the projects.';
$strings['project_snapshot'] = 'Project Snapshot';
$strings['project_snapshot_desc'] = 'This report provides for the user signed on a overview look at the projects where they are deemed as the owner and the tasks associated with the project.';
$strings['pending_tasks'] = 'Pending Tasks';
$strings['pending_tasks_desc'] = 'This report provides an enterprise view of the projects tasks that have been entered for the projects.';
$strings['pm_report'] = 'PM Report';
$strings['pm_report_desc'] = 'This report displays the projects assigned by resource and those projects not yet assigned.';
$strings['project_phasestatus'] = 'Project Phase Status';
$strings['project_phasestatus_desc'] = 'Shows a basic overview of all active projects and their phases';
$strings['resource_usage'] = 'Resource Usage';
$strings['resource_usage_desc'] = 'This report summarizes total time logged for projects and organizations.';
// 2.5.2
$strings['install_erase'] = 'Remove the installation directory and its contents!!';
$strings['error_phpversion'] = 'Your PHP version must be greater than or equal to 4.1.0 to run NetOffice!';
$strings['display_options'] = 'Display Options';
$strings['member_items'] = "Member Items";
$strings['project_totals'] = "Project Totals";
$strings['organization_totals'] = "Organization Totals";
$strings['member_totals'] = "Member Totals";
$strings['member_period_totals'] = "Member Period Totals";
// 2.5.3
$strings['project_breakdown'] = "Project Breakdown";
$strings['project_breakdown_desc'] = "Project list itemizing owner, status, and partner";
$strings['start_page'] = 'Start on';
$strings['task_id'] = 'Task ID';
// 2.x
$dayHourArray = array(
    0 => "0",
    1 => "8",
    2 => "8",
    3 => "8",
    4 => "8",
    5 => "8",
    6 => "0",
    7 => "0"
    );
$taskPredecessorTypes = array(
    "FF" => "Finish to Finish",
    "FS" => "Finish to Start",
    "SF" => "Start to Finish",
    "SS" => "Start to Start"
    );
$timestampArray = array(
    "06:00" => "AM 06:00",
    "06:30" => "AM 06:30",
    "07:00" => "AM 07:00",
    "07:30" => "AM 07:30",
    "08:00" => "AM 08:00",
    "08:30" => "AM 08:30",
    "09:00" => "AM 09:00",
    "09:30" => "AM 09:30",
    "10:00" => "AM 10:00",
    "10:30" => "AM 10:30",
    "11:00" => "AM 11:00",
    "11:30" => "AM 11:30",
    "12:00" => "PM 12:00",
    "12:30" => "PM 12:30",
    "13:00" => "PM 01:00",
    "13:30" => "PM 01:30",
    "14:00" => "PM 02:00",
    "14:30" => "PM 02:30",
    "15:00" => "PM 03:00",
    "15:30" => "PM 03:30",
    "16:00" => "PM 04:00",
    "16:30" => "PM 04:30",
    "17:00" => "PM 05:00",
    "17:30" => "PM 05:30",
    "18:00" => "PM 06:00",
    "18:30" => "PM 06:30",
    "19:00" => "PM 07:00",
    "19:30" => "PM 07:30",
    "20:00" => "PM 08:00",
    "20:30" => "PM 08:30",
    "21:00" => "PM 09:00"
    );
$reminderTimeArray = array(
    "0"     => "--",
    "5"     => "5 minutes",
    "15"    => "15 minutes",
    "30"    => "30 minutes",
    "60"    => "1 hour",
    "120"   => "2 hours",
    "180"   => "3 hours",
    "360"   => "6 hours",
    "720"   => "12 hours",
    "1440"  => "1 day",
    "2880"  => "2 days",
    "4320"  => "3 days",
    "5760"  => "4 days",
    "7200"  => "5 days",
    "8640"  => "6 days",
    "10080" => "1 week",
    "11520" => "8 days",
    "12960" => "9 days",
    "14400" => "10 days",
    "15840" => "11 days",
    "17280" => "12 days",
    "18720" => "13 days",
    "20160" => "2 weeks",
    );
$milestoneis = array(0 => 'Yes', 1 => 'No');
$strings['hours_logged'] = 'Hours Logged';
$strings['hours_logged_from'] = 'from';
$strings['hours_logged_to'] = 'to';
$strings['hours_total'] = 'Total';
$strings['ru_detail'] = 'Resource Usage Detail';
$strings['ru_detail_from'] = 'from';
$strings['ru_detail_to'] = 'to';
$strings['ru_total_project'] = 'Total project hours';
$strings['ru_total_org'] = 'Total for organization';
$strings['ru_total_mem'] = 'Total for members';
$strings['ru_subtotal'] = 'Subtotal';
$strings['meetings'] = 'Meetings';
$strings['meeting'] = 'Meeting';
$strings['edit_meeting'] = 'Edit Meeting';
$strings['copy_meeting'] = 'Copy Meeting';
$strings['add_meeting'] = 'Add Meeting';
$strings['delete_meetings'] = 'Delete Meeting';
$strings['me_agenda'] = 'Agenda';
$strings['me_location'] = 'Location';
$strings['me_minutes'] = 'Minutes';
$strings['me_chairman'] = 'Chairman';
$strings['me_recorder'] = 'Recorder';
$strings['attendants'] = 'Attendants';
$strings['select_all_but_clients'] = 'Select All but Clients';
$strings['start_time'] = 'Start Time';
$strings['end_time'] = 'End Time';
$strings['meeting_id'] = 'Meeting ID';
$strings['updates_meeting'] = 'Meeting update history';
$strings['add_meeting_time'] = 'Add Meeting Time';
$strings['edit_meeting_time'] = 'Edit Meeting Time';
$strings['delete_meeting_time'] = 'Delete Meeting Time';
$strings['meeting_time'] = 'Meeting Time';
$strings['edit_noti_meetingassignment'] = 'I am assigned to a new meeting.';
$strings['edit_noti_statusmeetingchange'] = 'The status of one of my meetings changes.';
$strings['edit_noti_prioritymeetingchange'] = 'The priority of one of my meetings changes.';
$strings['edit_noti_locationmeetingchange'] = 'The location of one of my meetings changes.';
$strings['edit_noti_timemeetingchange'] = 'The date/time of one of my meetings changes.';
$strings['edit_noti_checklogtime'] = 'Remind me to log time.';
$strings['edit_noti_todolist'] = 'Show me today todo list.';
$strings['noti_meetingassignment1'] = 'New meeting:';
$strings['noti_meetingassignment2'] = 'A meeting has been assigned to you:';
$strings['noti_prioritymeetingchange1'] = 'Meeting priority changed:';
$strings['noti_prioritymeetingchange2'] = 'The priority of the following meeting has changed:';
$strings['noti_statusmeetingchange1'] = 'Meeting status changed:';
$strings['noti_statusmeetingchange2'] = 'The status of the following meeting has changed:';
$strings['noti_locationmeetingchange1'] = 'Meeting location changed:';
$strings['noti_locationmeetingchange2'] = 'The location of the following meeting has changed:';
$strings['noti_timemeetingchange1'] = 'Meeting time changed:';
$strings['noti_timemeetingchange2'] = 'The time of the following meeting has changed:';
$strings['noti_checklogtime1'] = 'Log time missing:';
$strings['noti_checklogtime2'] = 'The logtime of the following days was not fully logged:';
$strings['noti_todolist1'] = 'To Do List:';
$strings['noti_todolist2'] = 'The followings are today\'s todo list:';
$strings['noti_todolist3'] = 'OverDue List:';
$strings['noti_todolist4'] = 'Task List:';
$strings['noti_todolist5'] = 'Meeting List:';
$strings['noti_todolist6'] = 'Reminder List:';
$strings['noti_todolist7'] = 'The followings are today\'s reminder List:';
$strings['noti_todolist8'] = 'Reminder List:';
$strings['noti_orphan1'] = 'Orphan Task List:';
$strings['noti_orphan2'] = 'The following tasks are assigned to invalid users, please re-assign:';
$strings['attendants_modification_succeeded'] = 'Attendants modification succeeded';
$strings['cal_personal'] = 'Personal';
$strings['holidays'] = 'Holidays';
$strings['edit_holidays'] = 'Edit Holidays';
$strings['delete_holidays'] = 'Delete Holidays';
$strings['new_holiday'] = 'New Holiday';
$strings['fixed_duration'] = 'Fixed Duration';
$strings['milestone'] = 'Milestone';
$strings['interdependency_failed'] = 'Task interdependency conflict, update failed';
$strings['hour'] = 'hour';
$strings['duration'] = 'Duration';
$strings['task_dependencies'] = 'Task Dependencies';
$strings['lag'] = 'Lag';
$strings['predecessor'] = 'Predecessor';
$strings['add_predecessor'] = 'Add Task Predecessor';
$strings['edit_predecessor'] = 'Edit Task Predecessor';
$strings['delete_predecessors'] = 'Delete Task Predecessors';
$strings['add_predecessor_success'] = 'The addition to the task succeeded.';
$strings['delete_predecessor_success'] = 'The predecessor was successfully deleted.';
$strings['no_possible_tasks'] = 'There are no possible tasks.';
$strings['lack_of_dates'] = 'Start date and due date needed.';
$strings['ftok_error'] = 'Mutex lock failed, contact system administrator immediately!!';
$strings['sem_get_error'] = 'Mutex lock failed, contact system administrator immediately!!';
$strings['sem_acquire_error'] = 'Transaction failed, try again later';
$strings['calendar_reminder_time1'] = 'Send a reminder';
$strings['calendar_reminder_time2'] = 'before and';
$strings['calendar_reminder_time3'] = 'before the event';
$strings["send_reminder1"] = "Personal Reminder List:";
$strings["send_reminder2"] = "The followings are personal reminder list:";
$strings["send_reminder3"] = "Project Reminder List:";
$strings["send_reminder4"] = "The followings are ";
$strings["send_reminder5"] = " project reminder list:";
$strings["send_reminder6"] = "Meeting Reminder:";
$strings['meeting_reminder'] = 'Reminder';
$strings['meeting_reminder_time1'] = 'Send a reminder';
$strings['meeting_reminder_time2'] = 'before and';
$strings['meeting_reminder_time3'] = 'before the meeting';
$strings['my_meetings'] = 'My Meetings';
$strings['day'] = 'Day';
$strings['ical_url'] = 'iCal url';

// 2.6
$strings['reporthours'] = 'Hours Logged';
$strings['reportscompleted'] = 'Completed Tasks';
$strings['reportsoverdue'] = 'Overdue Tasks';
$strings['reportsusage'] = 'Resource Usage Detail';
$strings['reports_from'] = 'from';
$strings['reports_to'] = 'to';
$strings['total'] = 'Total';

?>
