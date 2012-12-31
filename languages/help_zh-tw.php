<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: help_zh-tw.php,v 1.3 2004/12/24 15:40:40 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s): Luis, Wang <wenwen_tw@yahoo.com>
$help["setup_mkdirMethod"] = "如果打開安全模式, 你必須提供一個檔案傳輸(ftp)的設定給檔案管理功能使用.";
$help["setup_notifications"] = "使用者電子郵件通知 (任務指派, 新佈告, 任務變更...)<br>需設定smtp或sendmail.";
$help["setup_forcedlogin"] = "If false, disallow external link with login/password in url";
$help["setup_langdefault"] = "選擇預設登入的語言或留白由瀏覽器自行偵測";
$help["setup_myprefix"] = "Set this value if you have tables with same name in existing database.<br><br>assignments<br>bookmarks<br>bookmarks_categories<br>calendar<br>files<br>logs<br>members<br>notes<br>notifications<br>organizations<br>phases<br>posts<br>projects<br>reports<br>sorting<br>subtasks<br>support_posts<br>support_requests<br>tasks<br>teams<br>topics<br>updates<br><br>Leave blank for not use table prefix.";
$help["setup_loginmethod"] = "Method to store passwords in database.<br>Set to &quot;Crypt&quot; in order CVS authentication and htaccess authentification to work (if CVS support and/or htaccess authentification are enabled).";
$help["admin_update"] = "Respect strictly the order indicated to update your version<br>1. Edit settings (supplement the new parameters)<br>2. Edit database (update in agreement with your preceding version)";
$help["task_scope_creep"] = "實際時間與預估時間之差(粗體表示正值)";
$help["max_file_size"] = "上傳檔案大小最大值";
$help["project_disk_space"] = "專案相關檔案所使用的磁碟空間";
$help["project_scope_creep"] = "所有任務實際時間與預估時間之差(粗體表示正值)";
$help["mycompany_logo"] = "Upload any logo of your company. Appears in header, instead of title site";
$help["calendar_shortname"] = "顯示於行事曆上的文字(必要欄位)";
$help["user_autologout"] = "Time in sec. to be disconnected after no activity. 0 to disable";
$help["user_timezone"] = "設定你的時區";
// 2.4
$help["setup_clientsfilter"] = "只顯示已登入的客戶使用者";
$help["setup_projectsfilter"] = "只顯示屬於你參與的專案";
// 2.5
$help["setup_notificationMethod"] = "Set method to send email notifications: with internal php mail function (need for having a smtp server or sendmail configured in the parameters of php) or with a personalized smtp server";

?>
