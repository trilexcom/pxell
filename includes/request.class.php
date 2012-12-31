<?php // $Revision: 1.14 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: request.class.php,v 1.14 2005/06/11 20:32:09 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

class request {
    // constructor
    function request()
    {
    } 
    
    function connectClass()
    {
        global $strings, $MY_DBH, $databaseType;

        if ($databaseType == 'mysql') {
            $MY_DBH = openDatabase();
        } 
    } 
    
    function query($sql)
    {
        global $MY_DBH, $databaseType, $comptRequest;

        $comptRequest = $comptRequest + 1;

        if ($databaseType == 'mysql') {
            $this->index = mysql_query($sql, $MY_DBH);
        } 
    } 

    function fetch()
    {
        global $row, $databaseType;

        if ($databaseType == 'mysql') {
            @$row = mysql_fetch_row($this->index);

            if (mysql_errno() != 0) {
                echo '<font color=red><b>' . mysql_error() . '</b></font><br>';
            } 
        } 

        return $row;
    } 

    function close()
    {
        global $MY_DBH, $databaseType;
        if ($databaseType == "mysql") {
            @mysql_free_result($this->index);
            @mysql_close($MY_DBH);
        } 
    } 
    // results sorting
    function openSorting($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["sorting"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->sor_id[] = ($row[0]);
            $this->sor_member[] = ($row[1]);
            $this->sor_home_projects[] = ($row[2]);
            $this->sor_home_tasks[] = ($row[3]);
            $this->sor_home_discussions[] = ($row[4]);
            $this->sor_home_reports[] = ($row[5]);
            $this->sor_projects[] = ($row[6]);
            $this->sor_organizations[] = ($row[7]);
            $this->sor_project_tasks[] = ($row[8]);
            $this->sor_discussions[] = ($row[9]);
            $this->sor_project_discussions[] = ($row[10]);
            $this->sor_users[] = ($row[11]);
            $this->sor_team[] = ($row[12]);
            $this->sor_tasks[] = ($row[13]);
            $this->sor_report_tasks[] = ($row[14]);
            $this->sor_assignment[] = ($row[15]);
            $this->sor_reports[] = ($row[16]);
            $this->sor_files[] = ($row[17]);
            $this->sor_organization_projects[] = ($row[18]);
            $this->sor_notes[] = ($row[19]);
            $this->sor_calendar[] = ($row[20]);
            $this->sor_phases[] = ($row[21]);
            $this->sor_support_requests[] = ($row[22]);
            $this->sor_bookmarks[] = ($row[23]);
            $this->sor_tasks_time[] = ($row[24]);
            $this->sor_meetings[] = ($row[25]);
            $this->sor_meetings_attachment[] = ($row[26]);
            $this->sor_meetings_time[] = ($row[27]);
            $this->sor_calendar_view[] = ($row[28]);
            $this->sor_tasks_closed[] = ($row[29]);
            $this->sor_milestones[] = ($row[30]);
        } 
        $this->close();
    } 
    // results calendar
    function openCalendar($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["calendar"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->cal_id[] = ($row[0]);
            $this->cal_owner[] = ($row[1]);
            $this->cal_subject[] = ($row[2]);
            $this->cal_description[] = ($row[3]);
            $this->cal_shortname[] = ($row[4]);
            $this->cal_date_start[] = ($row[5]);
            $this->cal_date_end[] = ($row[6]);
            $this->cal_time_start[] = ($row[7]);
            $this->cal_time_end[] = ($row[8]);
            $this->cal_reminder[] = ($row[9]);
            $this->cal_recurring[] = ($row[10]);
            $this->cal_recur_day[] = ($row[11]);
            $this->cal_project[] = ($row[12]);
            $this->cal_mem_email_work[] = ($row[13]);
        } 
        $this->close();
    } 
    // results notes
    function openNotes($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["notes"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->note_id[] = ($row[0]);
            $this->note_project[] = ($row[1]);
            $this->note_owner[] = ($row[2]);
            $this->note_topic[] = ($row[3]);
            $this->note_subject[] = ($row[4]);
            $this->note_description[] = ($row[5]);
            $this->note_date[] = ($row[6]);
            $this->note_published[] = ($row[7]);
            $this->note_mem_id[] = ($row[8]);
            $this->note_mem_login[] = ($row[9]);
            $this->note_mem_name[] = ($row[10]);
            $this->note_mem_email_work[] = ($row[11]);
        } 
        $this->close();
    } 

    // results logs
    function openLogs($querymore, $start = '', $rows = '')
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;

        $this->connectClass();
        $sql = $initrequest['logs'];
        $sql .= ' ' . $querymore;

        if ($databaseType == 'mysql' && $start != '') {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->log_id[] = $row[0];
            $this->log_login[] = $row[1];
            $this->log_password[] = $row[2];
            $this->log_ip[] = $row[3];
            $this->log_session[] = $row[4];
            $this->log_compt[] = $row[5];
            $this->log_last_visite[] = $row[6];
            $this->log_connected[] = $row[7];
            $this->log_mem_profil[] = $row[8];
        } 

        $this->close();
    } 

    // results notifications
    function openNotifications($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["notifications"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->not_id[] = ($row[0]);
            $this->not_member[] = ($row[1]);
            $this->not_taskassignment[] = ($row[2]);
            $this->not_removeprojectteam[] = ($row[3]);
            $this->not_addprojectteam[] = ($row[4]);
            $this->not_newtopic[] = ($row[5]);
            $this->not_newpost[] = ($row[6]);
            $this->not_statustaskchange[] = ($row[7]);
            $this->not_prioritytaskchange[] = ($row[8]);
            $this->not_duedatetaskchange[] = ($row[9]);
            $this->not_clientaddtask[] = ($row[10]);
            $this->not_meetingassignment[] = ($row[11]);
            $this->not_statusmeetingchange[] = ($row[12]);
            $this->not_prioritymeetingchange[] = ($row[13]);
            $this->not_locationmeetingchange[] = ($row[14]);
            $this->not_timemeetingchange[] = ($row[15]);
            $this->not_mem_id[] = ($row[16]);
            $this->not_mem_login[] = ($row[17]);
            $this->not_mem_name[] = ($row[18]);
            $this->not_mem_email_work[] = ($row[19]);
            $this->not_mem_organization[] = ($row[20]);
            $this->not_mem_profil[] = ($row[21]);
        } 
        $this->close();
    } 
    // results members
    function openMembers($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        global $sql;
        $sql = $initrequest["members"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->mem_id[] = ($row[0]);
            $this->mem_organization[] = ($row[1]);
            $this->mem_login[] = ($row[2]);
            $this->mem_password[] = ($row[3]);
            $this->mem_name[] = ($row[4]);
            $this->mem_title[] = ($row[5]);
            $this->mem_email_work[] = ($row[6]);
            $this->mem_email_home[] = ($row[7]);
            $this->mem_phone_work[] = ($row[8]);
            $this->mem_phone_home[] = ($row[9]);
            $this->mem_mobile[] = ($row[10]);
            $this->mem_fax[] = ($row[11]);
            $this->mem_comments[] = ($row[12]);
            $this->mem_profil[] = ($row[13]);
            $this->mem_created[] = ($row[14]);
            $this->mem_logout_time[] = ($row[15]);
            $this->mem_last_page[] = ($row[16]);
            $this->mem_timezone[] = ($row[17]);
            $this->mem_org_name[] = ($row[18]);
            $this->mem_log_connected[] = ($row[19]);
        } 
        $this->close();
    } 
    // results projects
    function openProjects($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;

        $this->connectClass();
        $sql = $initrequest["projects"];
        $sql .= " " . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->pro_id[] = ($row[0]);
            $this->pro_organization[] = ($row[1]);
            $this->pro_owner[] = ($row[2]);
            $this->pro_priority[] = ($row[3]);
            $this->pro_status[] = ($row[4]);
            $this->pro_name[] = ($row[5]);
            $this->pro_description[] = ($row[6]);
            $this->pro_url_dev[] = ($row[7]);
            $this->pro_url_prod[] = ($row[8]);
            $this->pro_created[] = ($row[9]);
            $this->pro_modified[] = ($row[10]);
            $this->pro_published[] = ($row[11]);
            $this->pro_upload_max[] = ($row[12]);
            $this->pro_phase_set[] = ($row[13]);
            $this->pro_type[] = ($row[14]);
            $this->pro_org_id[] = ($row[15]);
            $this->pro_org_name[] = ($row[16]);
            $this->pro_mem_id[] = ($row[17]);
            $this->pro_mem_login[] = ($row[18]);
            $this->pro_mem_name[] = ($row[19]);
            $this->pro_mem_email_work[] = ($row[20]);
        } 

        $this->close();
    } 
    // results files
    function openFiles($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        global $sql;
        $sql = $initrequest["files"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->fil_id[] = ($row[0]);
            $this->fil_owner[] = ($row[1]);
            $this->fil_project[] = ($row[2]);
            $this->fil_task[] = ($row[3]);
            $this->fil_name[] = ($row[4]);
            $this->fil_date[] = ($row[5]);
            $this->fil_size[] = ($row[6]);
            $this->fil_extension[] = ($row[7]);
            $this->fil_comments[] = ($row[8]);
            $this->fil_comments_approval[] = ($row[9]);
            $this->fil_approver[] = ($row[10]);
            $this->fil_date_approval[] = ($row[11]);
            $this->fil_upload[] = ($row[12]);
            $this->fil_published[] = ($row[13]);
            $this->fil_status[] = ($row[14]);
            $this->fil_vc_status[] = ($row[15]);
            $this->fil_vc_version[] = ($row[16]);
            $this->fil_vc_parent[] = ($row[17]);
            $this->fil_phase[] = ($row[18]);
            $this->fil_mem_id[] = ($row[19]);
            $this->fil_mem_login[] = ($row[20]);
            $this->fil_mem_name[] = ($row[21]);
            $this->fil_mem_email_work[] = ($row[22]);
            $this->fil_mem2_id[] = ($row[23]);
            $this->fil_mem2_login[] = ($row[24]);
            $this->fil_mem2_name[] = ($row[25]);
            $this->fil_mem2_email_work[] = ($row[26]);
        } 
        $this->close();
    } 
    // results organizations
    function openOrganizations($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["organizations"];
        $sql .= ' ' . $querymore;
        if (($databaseType == "mysql") && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->org_id[] = ($row[0]);
            $this->org_name[] = ($row[1]);
            $this->org_address1[] = ($row[2]);
            $this->org_address2[] = ($row[3]);
            $this->org_zip_code[] = ($row[4]);
            $this->org_city[] = ($row[5]);
            $this->org_country[] = ($row[6]);
            $this->org_phone[] = ($row[7]);
            $this->org_fax[] = ($row[8]);
            $this->org_url[] = ($row[9]);
            $this->org_email[] = ($row[10]);
            $this->org_comments[] = ($row[11]);
            $this->org_created[] = ($row[12]);
            $this->org_extension_logo[] = ($row[13]);
            $this->org_owner[] = ($row[14]);
            $this->org_mem_id[] = ($row[15]);
            $this->org_mem_login[] = ($row[16]);
            $this->org_mem_name[] = ($row[17]);
            $this->org_mem_email_work[] = ($row[18]);
        } 
        $this->close();
    } 
    // results topics
    function openTopics($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["topics"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->top_id[] = ($row[0]);
            $this->top_project[] = ($row[1]);
            $this->top_owner[] = ($row[2]);
            $this->top_subject[] = ($row[3]);
            $this->top_status[] = ($row[4]);
            $this->top_last_post[] = ($row[5]);
            $this->top_posts[] = ($row[6]);
            $this->top_published[] = ($row[7]);
            $this->top_mem_id[] = ($row[8]);
            $this->top_mem_login[] = ($row[9]);
            $this->top_mem_name[] = ($row[10]);
            $this->top_mem_email_work[] = ($row[11]);
            $this->top_pro_id[] = ($row[12]);
            $this->top_pro_name[] = ($row[13]);
        } 
        $this->close();
    } 
    // results posts
    function openPosts($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["posts"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->pos_id[] = ($row[0]);
            $this->pos_topic[] = ($row[1]);
            $this->pos_member[] = ($row[2]);
            $this->pos_created[] = ($row[3]);
            $this->pos_message[] = ($row[4]);
            $this->pos_mem_id[] = ($row[5]);
            $this->pos_mem_login[] = ($row[6]);
            $this->pos_mem_name[] = ($row[7]);
            $this->pos_mem_email_work[] = ($row[8]);
        } 
        $this->close();
    } 
    // results assignments
    function openAssignments($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["assignments"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->ass_id[] = ($row[0]);
            $this->ass_task[] = ($row[1]);
            $this->ass_owner[] = ($row[2]);
            $this->ass_assigned_to[] = ($row[3]);
            $this->ass_comments[] = ($row[4]);
            $this->ass_assigned[] = ($row[5]);
            $this->ass_mem1_id[] = ($row[6]);
            $this->ass_mem1_login[] = ($row[7]);
            $this->ass_mem1_name[] = ($row[8]);
            $this->ass_mem1_email_work[] = ($row[9]);
            $this->ass_mem2_id[] = ($row[10]);
            $this->ass_mem2_login[] = ($row[11]);
            $this->ass_mem2_name[] = ($row[12]);
            $this->ass_mem2_email_work[] = ($row[13]);
        } 
        $this->close();
    } 
    // results reports
    function openReports($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["reports"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->rep_id[] = ($row[0]);
            $this->rep_owner[] = ($row[1]);
            $this->rep_name[] = ($row[2]);
            $this->rep_projects[] = ($row[3]);
            $this->rep_members[] = ($row[4]);
            $this->rep_priorities[] = ($row[5]);
            $this->rep_status[] = ($row[6]);
            $this->rep_date_due_start[] = ($row[7]);
            $this->rep_date_due_end[] = ($row[8]);
            $this->rep_created[] = ($row[9]);
            $this->rep_date_complete_start[] = ($row[10]);
            $this->rep_date_complete_end[] = ($row[11]);
            $this->rep_clients[] = ($row[12]);
        } 
        $this->close();
    } 
    // results teams
    function openTeams($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["teams"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->tea_id[] = ($row["0"]);
            $this->tea_project[] = ($row["1"]);
            $this->tea_member[] = ($row["2"]);
            $this->tea_published[] = ($row["3"]);
            $this->tea_authorized[] = ($row["4"]);
            $this->tea_mem_id[] = ($row[5]);
            $this->tea_mem_login[] = ($row[6]);
            $this->tea_mem_name[] = ($row[7]);
            $this->tea_mem_email_work[] = ($row[8]);
            $this->tea_mem_title[] = ($row[9]);
            $this->tea_mem_phone_work[] = ($row[10]);
            $this->tea_org_name[] = ($row[11]);
            $this->tea_pro_id[] = ($row[12]);
            $this->tea_pro_name[] = ($row[13]);
            $this->tea_pro_priority[] = ($row[14]);
            $this->tea_pro_status[] = ($row[15]);
            $this->tea_pro_published[] = ($row[16]);
            $this->tea_org2_name[] = ($row[17]);
            $this->tea_mem2_login[] = ($row[18]);
            $this->tea_mem2_email_work[] = ($row[19]);
            $this->tea_org2_id[] = ($row[20]);
            $this->tea_log_connected[] = ($row[21]);
            $this->tea_mem_profil[] = ($row[22]);
            $this->tea_mem_password[] = ($row[23]);
        } 
        $this->close();
    } 
    // results tasks
    function openTasks($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;

        $this->connectClass();
        $sql = $initrequest["tasks"];
        $sql .= ' ' . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->tas_id[] = ($row[0]);
            $this->tas_project[] = ($row[1]);
            $this->tas_priority[] = ($row[2]);
            $this->tas_status[] = ($row[3]);
            $this->tas_owner[] = ($row[4]);
            $this->tas_assigned_to[] = ($row[5]);
            $this->tas_name[] = ($row[6]);
            $this->tas_description[] = ($row[7]);
            $this->tas_start_date[] = ($row[8]);
            $this->tas_due_date[] = ($row[9]);
            $this->tas_estimated_time[] = ($row[10]);
            $this->tas_actual_time[] = ($row[11]);
            $this->tas_comments[] = ($row[12]);
            $this->tas_completion[] = ($row[13]);
            $this->tas_created[] = ($row[14]);
            $this->tas_modified[] = ($row[15]);
            $this->tas_assigned[] = ($row[16]);
            $this->tas_published[] = ($row[17]);
            $this->tas_parent_phase[] = ($row[18]);
            $this->tas_complete_date[] = ($row[19]);
            $this->tas_service[] = ($row[20]);
            $this->tas_milestone[] = ($row[21]);
            $this->tas_mem_id[] = ($row[22]);
            $this->tas_mem_name[] = ($row[23]);
            $this->tas_mem_login[] = ($row[24]);
            $this->tas_mem_email_work[] = ($row[25]);
            $this->tas_mem2_id[] = ($row[26]);
            $this->tas_mem2_name[] = ($row[27]);
            $this->tas_mem2_login[] = ($row[28]);
            $this->tas_mem2_email_work[] = ($row[29]);
            $this->tas_mem_organization[] = ($row[30]);
            $this->tas_pro_name[] = ($row[31]);
            $this->tas_org_id[] = ($row[32]);
        } 

        $this->close();
    } 
    // results tasks_time
    function openTaskTime($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;

        $this->connectClass();
        $sql = $initrequest["tasks_time"];
        $sql .= ' ' . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->tim_id[] = ($row[0]);
            $this->tim_project[] = ($row[1]);
            $this->tim_task[] = ($row[2]);
            $this->tim_owner[] = ($row[3]);
            $this->tim_date[] = ($row[4]);
            $this->tim_hours[] = ($row[5]);
            $this->tim_comments[] = ($row[6]);
            $this->tim_created[] = ($row[7]);
            $this->tim_modified[] = ($row[8]);
            $this->tim_mem_name[] = ($row[9]);
            $this->tim_pro_name[] = ($row[10]);
            $this->tim_pro_type[] = ($row[11]);
            $this->tim_org_name[] = ($row[12]);
            $this->tim_svc_nam[] = ($row[13]);
        } 

        $this->close();
    } 
    // results phases
    function openPhases($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["phases"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->pha_id[] = ($row[0]);
            $this->pha_project_id[] = ($row[1]);
            $this->pha_order_num[] = ($row[2]);
            $this->pha_status[] = ($row[3]);
            $this->pha_name[] = ($row[4]);
            $this->pha_date_start[] = ($row[5]);
            $this->pha_date_end[] = ($row[6]);
            $this->pha_comments[] = ($row[7]);
        } 
        $this->close();
    } 
    // results updates
    function openUpdates($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["updates"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->upd_id[] = ($row[0]);
            $this->upd_type[] = ($row[1]);
            $this->upd_item[] = ($row[2]);
            $this->upd_member[] = ($row[3]);
            $this->upd_comments[] = ($row[4]);
            $this->upd_created[] = ($row[5]);
            $this->upd_mem_id[] = ($row[6]);
            $this->upd_mem_name[] = ($row[7]);
            $this->upd_mem_login[] = ($row[8]);
            $this->upd_mem_email_work[] = ($row[9]);
        } 
        $this->close();
    } 
    // results support requests
    function openSupportRequests($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["support_requests"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->sr_id[] = ($row[0]);
            $this->sr_status[] = ($row[1]);
            $this->sr_user[] = ($row[2]);
            $this->sr_priority[] = ($row[3]);
            $this->sr_subject[] = ($row[4]);
            $this->sr_message[] = ($row[5]);
            $this->sr_owner[] = ($row[6]);
            $this->sr_date_open[] = ($row[7]);
            $this->sr_date_close[] = ($row[8]);
            $this->sr_project[] = ($row[9]);
            $this->sr_pro_name[] = ($row[10]);
            $this->sr_mem_name[] = ($row[11]);
            $this->sr_mem_email_work[] = ($row[12]);
        } 
        $this->close();
    } 
    // results support posts
    function openSupportPosts($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["support_posts"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->sp_id[] = ($row[0]);
            $this->sp_request_id[] = ($row[1]);
            $this->sp_message[] = ($row[2]);
            $this->sp_date[] = ($row[3]);
            $this->sp_owner[] = ($row[4]);
            $this->sp_project[] = ($row[5]);
            $this->sp_mem_name[] = ($row[6]);
            $this->sp_mem_email_work[] = ($row[7]);
        } 
        $this->close();
    } 
    // results bookmarks
    function openBookmarks($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["bookmarks"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->boo_id[] = ($row[0]);
            $this->boo_owner[] = ($row[1]);
            $this->boo_category[] = ($row[2]);
            $this->boo_name[] = ($row[3]);
            $this->boo_url[] = ($row[4]);
            $this->boo_description[] = ($row[5]);
            $this->boo_shared[] = ($row[6]);
            $this->boo_home[] = ($row[7]);
            $this->boo_comments[] = ($row[8]);
            $this->boo_users[] = ($row[9]);
            $this->boo_created[] = ($row[10]);
            $this->boo_modified[] = ($row[11]);
            $this->boo_mem_login[] = ($row[12]);
            $this->boo_mem_email_work[] = ($row[13]);
            $this->boo_boocat_name[] = ($row[14]);
        } 
        $this->close();
    } 
    // results bookmarks_categories
    function openBookmarksCategories($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest["bookmarks_categories"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->boocat_id[] = ($row[0]);
            $this->boocat_name[] = ($row[1]);
            $this->boocat_description[] = ($row[2]);
        } 
        $this->close();
    } 
    // results services
    function openServices($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest['services'];
        $sql .= ' ' . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->serv_id[] = ($row[0]);
            $this->serv_name[] = ($row[1]);
            $this->serv_name_print[] = ($row[2]);
            $this->serv_hourly_rate[] = ($row[3]);
        } 

        $this->close();
    } 
    // results meetings
    function openMeetings($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $res, $row, $databaseType, $initrequest;
        
        $this->connectClass();
        $sql = $initrequest["meetings"];
        $sql .= ' ' . $querymore;
        
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        
        while ($this->fetch()) {
            $this->mee_id[] = ($row[0]);
            $this->mee_project[] = ($row[1]);
            $this->mee_priority[] = ($row[2]);
            $this->mee_status[] = ($row[3]);
            $this->mee_name[] = ($row[4]);
            $this->mee_agenda[] = ($row[5]);
            $this->mee_location[] = ($row[6]);
            $this->mee_minutes[] = ($row[7]);
            $this->mee_chairman[] = ($row[8]);
            $this->mee_recorder[] = ($row[9]);
            $this->mee_date[] = ($row[10]);
            $this->mee_start_time[] = ($row[11]);
            $this->mee_end_time[] = ($row[12]);
            $this->mee_reminder[] = ($row[13]);
            $this->mee_reminder_time1[] = ($row[14]);
            $this->mee_reminder_time2[] = ($row[15]);
            $this->mee_created[] = ($row[16]);
            $this->mee_modified[] = ($row[17]);
            $this->mee_published[] = ($row[18]);
            $this->mee_pro_name[] = ($row[19]);
            $this->mee_org_id[] = ($row[20]);
            $this->mee_chairman_name[] = ($row[21]);
            $this->mee_recorder_name[] = ($row[22]);
            $this->mee_chairman_login[] = ($row[23]);
            $this->mee_recorder_login[] = ($row[24]);
            $this->mee_chairman_email[] = ($row[25]);
            $this->mee_recorder_email[] = ($row[26]);
        } 
        $this->close();
    } 
    // results attendants
    function openAttendants($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $res, $row, $databaseType, $initrequest;
        
        $this->connectClass();
        $sql = $initrequest["attendants"];
        $sql .= ' ' . $querymore;
        
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        
        while ($this->fetch()) {
            $this->att_id[] = ($row["0"]);
            $this->att_project[] = ($row["1"]);
            $this->att_meeting[] = ($row["2"]);
            $this->att_member[] = ($row["3"]);
            $this->att_published[] = ($row["4"]);
            $this->att_attended[] = ($row["5"]);
            $this->att_authorized[] = ($row["6"]);
            $this->att_mem_id[] = ($row[7]);
            $this->att_mem_login[] = ($row[8]);
            $this->att_mem_name[] = ($row[9]);
            $this->att_mem_email_work[] = ($row[10]);
            $this->att_mem_title[] = ($row[11]);
            $this->att_mem_phone_work[] = ($row[12]);
            $this->att_mee_id[] = ($row[13]);
            $this->att_mee_name[] = ($row[14]);
            $this->att_mee_agenda[] = ($row[15]);
            $this->att_mee_location[] = ($row[16]);
            $this->att_mee_date[] = ($row[17]);
            $this->att_mee_priority[] = ($row[18]);
            $this->att_mee_status[] = ($row[19]);
            $this->att_mee_start_time[] = ($row[20]);
            $this->att_mee_end_time[] = ($row[21]);
            $this->att_mee_published[] = ($row[22]);
            $this->att_org_name[] = ($row[23]);
            $this->att_pro_id[] = ($row[24]);
            $this->att_pro_name[] = ($row[25]);
            $this->att_pro_priority[] = ($row[26]);
            $this->att_pro_status[] = ($row[27]);
            $this->att_pro_published[] = ($row[28]);
            $this->att_org2_name[] = ($row[29]);
            $this->att_mem2_login[] = ($row[30]);
            $this->att_mem2_email_work[] = ($row[31]);
            $this->att_org2_id[] = ($row[32]);
            $this->att_log_connected[] = ($row[33]);
            $this->att_mem_profil[] = ($row[34]);
            $this->att_mem_password[] = ($row[35]);
        } 
        $this->close();
    } 
    // results meetings attachment
    function openMeetingsAttachment($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $res, $row, $databaseType, $initrequest;
        $this->connectClass();
        global $sql;
        $sql = $initrequest["meetings_attachment"];
        $sql .= ' ' . $querymore;
        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);
        while ($this->fetch()) {
            $this->mat_id[] = ($row[0]);
            $this->mat_owner[] = ($row[1]);
            $this->mat_project[] = ($row[2]);
            $this->mat_meeting[] = ($row[3]);
            $this->mat_name[] = ($row[4]);
            $this->mat_date[] = ($row[5]);
            $this->mat_size[] = ($row[6]);
            $this->mat_extension[] = ($row[7]);
            $this->mat_comments[] = ($row[8]);
            $this->mat_comments_approval[] = ($row[9]);
            $this->mat_approver[] = ($row[10]);
            $this->mat_date_approval[] = ($row[11]);
            $this->mat_upload[] = ($row[12]);
            $this->mat_published[] = ($row[13]);
            $this->mat_status[] = ($row[14]);
            $this->mat_vc_status[] = ($row[15]);
            $this->mat_vc_version[] = ($row[16]);
            $this->mat_vc_parent[] = ($row[17]);
            $this->mat_phase[] = ($row[18]);
            $this->mat_mem_id[] = ($row[19]);
            $this->mat_mem_login[] = ($row[20]);
            $this->mat_mem_name[] = ($row[21]);
            $this->mat_mem_email_work[] = ($row[22]);
            $this->mat_mem2_id[] = ($row[23]);
            $this->mat_mem2_login[] = ($row[24]);
            $this->mat_mem2_name[] = ($row[25]);
            $this->mat_mem2_email_work[] = ($row[26]);
        } 
        $this->close();
    } 
    // results meetings_time
    function openMeetingTime($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $res, $row, $databaseType, $initrequest;

        $this->connectClass();
        $sql = $initrequest["meetings_time"];
        $sql .= ' ' . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        } 

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->mti_id[] = ($row[0]);
            $this->mti_owner[] = ($row[1]);
            $this->mti_project[] = ($row[2]);
            $this->mti_meeting[] = ($row[3]);
            $this->mti_date[] = ($row[4]);
            $this->mti_hours[] = ($row[5]);
            $this->mti_comments[] = ($row[6]);
            $this->mti_created[] = ($row[7]);
            $this->mti_modified[] = ($row[8]);
            $this->mti_mem_name[] = ($row[9]);
            $this->mti_meeting_name[] = ($row[10]);
            $this->mti_pro_name[] = ($row[11]);
            $this->mti_pro_type[] = ($row[12]);
            $this->mti_org_name[] = ($row[13]);
        } 

        $this->close();
    }
    // get member time of day
    function getMemberTimeOfDay($id, $date1)
    {
        global $tableCollab, $strings, $res, $row;
        $this->connectClass();
        $sql = 'SELECT SUM(hours) FROM ' . $tableCollab['tasks_time'] . " WHERE owner='$id' AND date='$date1'";
        $index = $this->query($sql);
        $val = $this->fetch();
        $this->close();

        if (!$val[0]) {
            $val[0] = 0;
        }

        $rc = $val[0];

        $this->connectClass();
        $sql = 'SELECT SUM(hours) FROM ' . $tableCollab['meetings_time'] . " WHERE owner='$id' AND date='$date1'";
        $index = $this->query($sql);
        $val = $this->fetch();
        $this->close();
                                                                                
        if (!$val[0]) {
            $val[0] = 0;
        }

        $val[0] += $rc;

        return($val[0]);
    }
    // get meeting time
    function getMeetingTime($id = null)
    {
        global $tableCollab, $strings, $res, $row;
        $this->connectClass();
        $sql = 'SELECT SUM(hours) FROM ' . $tableCollab['meetings_time'] . " WHERE meeting='$id'";
        $index = $this->query($sql);
        $val = $this->fetch();
        $this->close();
        if (!$val[0]) {
            $val[0] = 0;
        } 
        return($val[0]);
    }
    // get task time
    function getTaskTime($id = null)
    {
        global $tableCollab, $strings, $MY_DBH, $row;
        $this->connectClass();
        $sql = 'SELECT SUM(hours) FROM ' . $tableCollab['tasks_time'] . " WHERE task='$id'";
        $index = $this->query($sql);
        $val = $this->fetch();
        $this->close();
        if (!$val[0]) {
            $val[0] = 0;
        } 
        return($val[0]);
    } 
    // get project actual time
    function getProjectTime($id = null)
    {
        global $tableCollab, $strings, $MY_DBH, $row;
        $this->connectClass();
        $sql = 'SELECT SUM(tim.hours) FROM ' . $tableCollab['tasks_time'] . ' tim, ' . $tableCollab['tasks'] . " tas WHERE tas.project='$id' AND tas.id = tim.task";
        $index = $this->query($sql);
        $val = $this->fetch();

        if (!$val[0]) {
            $val[0] = 0;
        } 

        $rc = $val[0];

        $sql = 'SELECT SUM(mti.hours) FROM ' . $tableCollab['meetings_time'] . ' mti, ' . $tableCollab['meetings'] . " mee WHERE mee.project='$id' AND mee.id = mti.meeting";
        $index = $this->query($sql);
        $val = $this->fetch();

        $this->close();

        if (!$val[0]) {
            $val[0] = 0;
        } 

        $val[0] += $rc;

        return($val[0]);
    } 

    // results holiday
    function openHoliday($querymore, $start = "", $rows = "")
    {
        global $tableCollab, $strings, $MY_DBH, $row, $databaseType, $initrequest;
        $this->connectClass();
        $sql = $initrequest['holiday'];
        $sql .= ' ' . $querymore;

        if ($databaseType == "mysql" && $start != "") {
            $sql .= " LIMIT $start,$rows";
        }

        $index = $this->query($sql);

        while ($this->fetch()) {
            $this->hol_id[] = ($row[0]);
            $this->hol_date[] = ($row[1]);
            $this->hol_comments[] = ($row[2]);
        }

        $this->close();
    }
} 

?>
