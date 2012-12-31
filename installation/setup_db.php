<?php // $Revision: 1.14 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: setup_db.php,v 1.14 2005/06/11 20:32:10 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

require_once('./db_var.inc.php');

// Table structure for table `assignments`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}assignments (
  id $db_mediumint_auto[$databaseType],
  task $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  assigned_to $db_mediumint[$databaseType],
  comments $db_text[$databaseType],
  assigned $db_varchar16[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `attendants`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}attendants (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  meeting $db_mediumint[$databaseType],
  member $db_mediumint[$databaseType],
  published $db_char1[$databaseType],
  attended $db_char1[$databaseType],
  authorized $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `calendar`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}calendar (
  id $db_mediumint_auto[$databaseType],
  owner $db_mediumint[$databaseType],
  subject $db_varchar155[$databaseType],
  description $db_text[$databaseType],
  shortname $db_varchar155[$databaseType],
  date_start $db_varchar10[$databaseType],
  date_end $db_varchar10[$databaseType],
  time_start $db_varchar155[$databaseType],
  time_end $db_varchar155[$databaseType],
  reminder $db_char1[$databaseType],
  recurring $db_char1[$databaseType],
  recur_day $db_char1[$databaseType],
  project $db_mediumint[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `files`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}files (
  id $db_mediumint_auto[$databaseType],
  owner $db_mediumint[$databaseType],
  project $db_mediumint[$databaseType],
  task $db_mediumint[$databaseType],
  name $db_varchar255[$databaseType],
  date $db_varchar16[$databaseType],
  size $db_varchar155[$databaseType],
  extension $db_varchar155[$databaseType],
  comments $db_varchar255[$databaseType],
  comments_approval $db_varchar255[$databaseType],
  approver $db_mediumint[$databaseType],
  date_approval $db_varchar16[$databaseType],
  upload $db_varchar16[$databaseType],
  published $db_char1[$databaseType],
  status $db_mediumint[$databaseType],
  vc_status $db_varchar255a[$databaseType],
  vc_version $db_varchar255b[$databaseType],
  vc_parent $db_int[$databaseType],
  phase $db_mediumint[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `holiday`
$SQL[] = <<<STAMP
    CREATE TABLE `{$myprefix}holiday` (
      id $db_mediumint_auto[$databaseType],
      date $db_varchar10[$databaseType],
      comments $db_text[$databaseType],
      PRIMARY KEY (id)
    )
STAMP;

// Table structure for table `logs`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}logs (
  id $db_mediumint_auto[$databaseType],
  login $db_varchar155[$databaseType],
  password $db_varchar155[$databaseType],
  ip $db_varchar155[$databaseType],
  session $db_varchar155[$databaseType],
  compt $db_mediumint[$databaseType],
  last_visite $db_varchar16[$databaseType],
  connected $db_varchar255[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `meetings`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}meetings (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  priority $db_mediumint[$databaseType],
  status $db_mediumint[$databaseType],
  name $db_varchar155[$databaseType],
  agenda $db_text[$databaseType],
  location $db_text[$databaseType],
  minutes $db_text[$databaseType],
  chairman $db_mediumint[$databaseType],
  recorder $db_mediumint[$databaseType],
  date $db_varchar10[$databaseType],
  start_time $db_varchar5[$databaseType],
  end_time $db_varchar5[$databaseType],
  reminder $db_char1default0[$databaseType],
  reminder_time1 $db_mediumint[$databaseType],
  reminder_time2 $db_mediumint[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  published $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `meetings_attachment`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}meetings_attachment (
  id $db_mediumint_auto[$databaseType],
  owner $db_mediumint[$databaseType],
  project $db_mediumint[$databaseType],
  meeting $db_mediumint[$databaseType],
  name $db_varchar255[$databaseType],
  date $db_varchar16[$databaseType],
  size $db_varchar155[$databaseType],
  extension $db_varchar155[$databaseType],
  comments $db_varchar255[$databaseType],
  comments_approval $db_varchar255[$databaseType],
  approver $db_mediumint[$databaseType],
  date_approval $db_varchar16[$databaseType],
  upload $db_varchar16[$databaseType],
  published $db_char1[$databaseType],
  status $db_mediumint[$databaseType],
  vc_status $db_varchar255a[$databaseType],
  vc_version $db_varchar255b[$databaseType],
  vc_parent $db_int[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `meetings_time`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}meetings_time (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  meeting $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  date $db_varchar16[$databaseType],
  hours $db_float[$databaseType],
  comments $db_text[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  PRIMARY KEY (id)
)
                                                                                
STAMP;

// Table structure for table `members`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}members (
  id $db_mediumint_auto[$databaseType],
  organization $db_mediumint[$databaseType],
  login $db_varchar155[$databaseType],
  password $db_varchar155[$databaseType],
  name $db_varchar155[$databaseType],
  title $db_varchar155[$databaseType],
  email_work $db_varchar155[$databaseType],
  email_home $db_varchar155[$databaseType],
  phone_work $db_varchar155[$databaseType],
  phone_home $db_varchar155[$databaseType],
  mobile $db_varchar155[$databaseType],
  fax $db_varchar155[$databaseType],
  comments $db_text[$databaseType],
  profil $db_char1[$databaseType],
  created $db_varchar16[$databaseType],
  logout_time $db_mediumint[$databaseType],
  last_page $db_varchar255[$databaseType],
  timezone $db_char3[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Dumping data for table `members`
$SQL[] = <<<STAMP
INSERT INTO {$myprefix}members(organization,login,password,name,profil,created,logout_time) VALUES('1','admin', '{$adminPwd}', 'Administrator', '0', '{$dateheure}', '0');
STAMP;

$SQL[] = <<<STAMP
INSERT INTO {$myprefix}members(organization,login,password,name,profil,created,logout_time) VALUES('1','demo', '{$demoPwd}', 'Demo user', '1', '{$dateheure}', '0');
STAMP;

// Table structure for table `notes`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}notes (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  topic $db_varchar255[$databaseType],
  subject $db_varchar155[$databaseType],
  description $db_text[$databaseType],
  date $db_varchar10[$databaseType],
  published $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `notifications`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}notifications (
  id $db_mediumint_auto[$databaseType],
  member $db_mediumint[$databaseType],
  taskAssignment $db_char1default0[$databaseType],
  removeProjectTeam $db_char1default0[$databaseType],
  addProjectTeam $db_char1default0[$databaseType],
  newTopic $db_char1default0[$databaseType],
  newPost $db_char1default0[$databaseType],
  statusTaskChange $db_char1default0[$databaseType],
  priorityTaskChange $db_char1default0[$databaseType],
  duedateTaskChange $db_char1default0[$databaseType],
  clientAddTask $db_char1default0[$databaseType],
  meetingAssignment $db_char1default0[$databaseType],
  statusMeetingChange $db_char1default0[$databaseType],
  priorityMeetingChange $db_char1default0[$databaseType],
  locationMeetingChange $db_char1default0[$databaseType],
  timeMeetingChange $db_char1default0[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Dumping data for table `notifications`
$SQL[] = <<<STAMP
INSERT INTO {$myprefix}notifications(member,taskAssignment,removeProjectTeam,addProjectTeam,newTopic,newPost,statusTaskChange,priorityTaskChange,duedateTaskChange,clientAddTask,meetingAssignment,statusMeetingChange,priorityMeetingChange,locationMeetingChange,timeMeetingChange) VALUES (1,'0','0','0','0','0','0','0','0','0','0','0','0','0','0');
STAMP;

$SQL[] = <<<STAMP
INSERT INTO {$myprefix}notifications(member,taskAssignment,removeProjectTeam,addProjectTeam,newTopic,newPost,statusTaskChange,priorityTaskChange,duedateTaskChange,clientAddTask,meetingAssignment,statusMeetingChange,priorityMeetingChange,locationMeetingChange,timeMeetingChange) VALUES (2,'0','0','0','0','0','0','0','0','0','0','0','0','0','0');
STAMP;

// Table structure for table `organizations`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}organizations (
  id $db_mediumint_auto[$databaseType],
  name $db_varchar255[$databaseType],
  address1 $db_varchar255[$databaseType],
  address2 $db_varchar255[$databaseType],
  zip_code $db_varchar155[$databaseType],
  city $db_varchar155[$databaseType],
  country $db_varchar155[$databaseType],
  phone $db_varchar155[$databaseType],
  fax $db_varchar155[$databaseType],
  url $db_varchar255[$databaseType],
  email $db_varchar155[$databaseType],
  comments $db_text[$databaseType],
  created $db_varchar16[$databaseType],
  extension_logo $db_char3[$databaseType],
  owner $db_mediumint[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Dumping data for table `organizations`
$SQL[] = <<<STAMP
INSERT INTO {$myprefix}organizations(name,created) VALUES('My Company Name', '{$dateheure}');
STAMP;

// Table structure for table `posts`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}posts (
  id $db_mediumint_auto[$databaseType],
  topic $db_mediumint[$databaseType],
  member $db_mediumint[$databaseType],
  created $db_varchar16[$databaseType],
  message $db_text[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `projects`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}projects (
  id $db_mediumint_auto[$databaseType],
  organization $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  priority $db_mediumint[$databaseType],
  status $db_mediumint[$databaseType],
  name $db_varchar155[$databaseType],
  description $db_text[$databaseType],
  url_dev $db_varchar255[$databaseType],
  url_prod $db_varchar255[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  published $db_char1[$databaseType],
  upload_max $db_varchar155[$databaseType],
  phase_set $db_mediumint[$databaseType],
  type $db_char1default0[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `reports`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}reports (
  id $db_mediumint_auto[$databaseType],
  owner $db_mediumint[$databaseType],
  name $db_varchar155[$databaseType],
  projects $db_varchar255[$databaseType],
  members $db_varchar255[$databaseType],
  priorities $db_varchar255[$databaseType],
  status $db_varchar255[$databaseType],
  date_due_start $db_varchar10[$databaseType],
  date_due_end $db_varchar10[$databaseType],
  created $db_varchar16[$databaseType],
  date_complete_start $db_varchar10[$databaseType],
  date_complete_end $db_varchar10[$databaseType],
  clients $db_varchar255[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `sorting`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}sorting (
  id $db_mediumint_auto[$databaseType],
  member $db_mediumint[$databaseType],
  home_projects $db_varchar155[$databaseType],
  home_tasks $db_varchar155[$databaseType],
  home_discussions $db_varchar155[$databaseType],
  home_reports $db_varchar155[$databaseType],
  projects $db_varchar155[$databaseType],
  organizations $db_varchar155[$databaseType],
  project_tasks $db_varchar155[$databaseType],
  discussions $db_varchar155[$databaseType],
  project_discussions $db_varchar155[$databaseType],
  users $db_varchar155[$databaseType],
  team $db_varchar155[$databaseType],
  tasks $db_varchar155[$databaseType],
  report_tasks $db_varchar155[$databaseType],
  assignment $db_varchar155[$databaseType],
  reports $db_varchar155[$databaseType],
  files $db_varchar155[$databaseType],
  organization_projects $db_varchar155[$databaseType],
  notes $db_varchar155[$databaseType],
  calendar $db_varchar155[$databaseType],
  phases $db_varchar155[$databaseType],
  support_requests $db_varchar155[$databaseType],
  bookmarks $db_varchar155[$databaseType],
  tasks_time $db_varchar155[$databaseType],
  meetings $db_varchar155[$databaseType],
  meetings_attachment $db_varchar155[$databaseType],
  meetings_time $db_varchar155[$databaseType],
  calendar_view $db_varchar155[$databaseType],
  tasks_closed $db_varchar155[$databaseType],
  milestones $db_varchar155[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Dumping data for table `sorting`
$SQL[] = <<<STAMP
INSERT INTO {$myprefix}sorting(member) VALUES (1);
STAMP;

$SQL[] = <<<STAMP
INSERT INTO {$myprefix}sorting(member) VALUES (2);
STAMP;

// Table structure for table `tasks`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}tasks (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  priority $db_mediumint[$databaseType],
  status $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  assigned_to $db_mediumint[$databaseType],
  name $db_varchar155[$databaseType],
  description $db_text[$databaseType],
  start_date $db_varchar10[$databaseType],
  due_date $db_varchar10[$databaseType],
  estimated_time $db_varchar10[$databaseType],
  actual_time $db_varchar10[$databaseType],
  comments $db_text[$databaseType],
  completion $db_mediumint[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  assigned $db_varchar16[$databaseType],
  published $db_char1[$databaseType],
  parent_phase $db_int[$databaseType],
  complete_date $db_varchar10[$databaseType],
  service $db_mediumint[$databaseType],
  milestone $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `tasks_time`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}tasks_time (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  task $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  date $db_varchar16[$databaseType],
  hours $db_float[$databaseType],
  comments $db_text[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  PRIMARY KEY (id)
)
                                                                                
STAMP;

// Table structure for table `teams`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}teams (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  member $db_mediumint[$databaseType],
  published $db_char1[$databaseType],
  authorized $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `topics`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}topics (
  id $db_mediumint_auto[$databaseType],
  project $db_mediumint[$databaseType],
  owner $db_mediumint[$databaseType],
  subject $db_varchar155[$databaseType],
  status $db_char1[$databaseType],
  last_post $db_varchar16[$databaseType],
  posts $db_smallint[$databaseType],
  published $db_char1[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `phases`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}phases (
  id $db_mediumint_auto[$databaseType],
  project_id $db_mediumint[$databaseType],
  order_num $db_mediumint[$databaseType],
  status $db_varchar10[$databaseType],
  name $db_varchar155[$databaseType],
  date_start $db_varchar10[$databaseType],
  date_end $db_varchar10[$databaseType],
  comments $db_varchar255[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `support_posts`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}support_posts (
  id $db_mediumint_auto[$databaseType],
  request_id $db_mediumint[$databaseType],
  message $db_text[$databaseType],
  date $db_varchar16[$databaseType],
  owner $db_mediumint[$databaseType],
  project $db_mediumint[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `supports_requests`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}support_requests (
  id $db_mediumint_auto[$databaseType],
  status $db_mediumint[$databaseType],
  member $db_mediumint[$databaseType],
  priority $db_mediumint[$databaseType],
  subject $db_varchar255[$databaseType],
  message $db_text[$databaseType],
  owner $db_mediumint[$databaseType],
  date_open $db_varchar16[$databaseType],
  date_close $db_varchar16[$databaseType],
  project $db_mediumint[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `updates`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}updates (
  id $db_mediumint_auto[$databaseType],
  type $db_char1[$databaseType],
  item $db_mediumint[$databaseType],
  member $db_mediumint[$databaseType],
  comments $db_text[$databaseType],
  created $db_varchar16[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `bookmarks`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}bookmarks (
  id $db_mediumint_auto[$databaseType],
  owner $db_mediumint[$databaseType],
  category $db_mediumint[$databaseType],
  name $db_varchar255[$databaseType],
  url $db_varchar255[$databaseType],
  description $db_text[$databaseType],
  shared $db_char1[$databaseType],
  home $db_char1[$databaseType],
  comments $db_char1[$databaseType],
  users $db_varchar255[$databaseType],
  created $db_varchar16[$databaseType],
  modified $db_varchar16[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `bookmarks_categories`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}bookmarks_categories (
  id $db_mediumint_auto[$databaseType],
  name $db_varchar255[$databaseType],
  description $db_text[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `services`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}services (
  id $db_mediumint_auto[$databaseType],
  name $db_varchar155[$databaseType],
  name_print $db_varchar155[$databaseType],
  hourly_rate $db_float[$databaseType],
  PRIMARY KEY (id)
)

STAMP;

// Table structure for table `sessions`
$SQL[] = <<<STAMP

CREATE TABLE {$myprefix}sessions (
  id $db_varchar32[$databaseType],
  ipaddr $db_varchar16b[$databaseType],
  session_data $db_longtext[$databaseType],
  last_access $db_int[$databaseType],
  PRIMARY KEY  (id, ipaddr),
  KEY  (last_access)
)

STAMP;

?>