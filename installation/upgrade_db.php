<?php // $Revision: 1.12 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: upgrade_db.php,v 1.12 2005/06/11 20:32:10 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

require_once('./db_var.inc.php');

// update to 2.5.2
if (version_compare($version, '2.5.2', '<')) {
    $SQL[] = <<<STAMP
    DROP TABLE IF EXISTS `{$tablePrefix}sessions`
STAMP;

    $SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}sessions` (
        id $db_varchar32[$databaseType],
        ipaddr $db_varchar16b[$databaseType],
        session_data $db_longtext[$databaseType],
        last_access $db_int[$databaseType],
        PRIMARY KEY  (id, ipaddr),
        KEY  (last_access)
    )
STAMP;
}

// update to 2.5.3
if (version_compare($version, '2.5.2', '<=')) {
    $SQL[] = <<<STAMP
    UPDATE `{$tablePrefix}members` SET last_page='' WHERE 1
STAMP;
}

// no updates for 2.5.3-pl1

// update to 2.6.0 beta 1
if (version_compare($version, '2.6.0b1', '<')) {
$SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}attendants` (
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

// Table structure for table `holiday`
$SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}holiday` (
      id $db_mediumint_auto[$databaseType],
      date $db_varchar10[$databaseType],
      comments $db_text[$databaseType],
      PRIMARY KEY (id)
    )
STAMP;

$SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}meetings` (
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

$SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}meetings_attachment` (
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

$SQL[] = <<<STAMP
    CREATE TABLE `{$tablePrefix}meetings_time` (
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

$SQL[] = <<<STAMP
    ALTER TABLE `{$tablePrefix}sorting` ADD (
        meetings $db_varchar155[$databaseType],
        meetings_attachment $db_varchar155[$databaseType],
        meetings_time $db_varchar155[$databaseType]
    )
STAMP;
}

// update to 2.6.0 beta 2
if (version_compare($version, '2.6.0b2', '<')) {
$SQL[] = <<<STAMP
    ALTER TABLE `{$tablePrefix}sorting` ADD (
        calendar_view $db_varchar155[$databaseType],
        tasks_closed $db_varchar155[$databaseType],
        milestones $db_varchar155[$databaseType]
    )
STAMP;

$SQL[] = <<<STAMP
    ALTER TABLE `{$tablePrefix}calendar` ADD (
        project $db_mediumint[$databaseType]
    )
STAMP;

$SQL[] = <<<STAMP
    ALTER TABLE `{$tablePrefix}notifications` ADD (
        meetingAssignment $db_char1default0[$databaseType],
        statusMeetingChange $db_char1default0[$databaseType],
        priorityMeetingChange $db_char1default0[$databaseType],
        locationMeetingChange $db_char1default0[$databaseType],
        timeMeetingChange $db_char1default0[$databaseType]
    )
STAMP;

$SQL[] = <<<STAMP
    ALTER TABLE `{$tablePrefix}tasks` ADD (
        milestone $db_char1[$databaseType]
    )
STAMP;
}

?>