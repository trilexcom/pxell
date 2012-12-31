<?php // $Revision: 1.1.1.1 $
                                                                                
/* vim: set expandtab ts=4 sw=4 sts=4: */
                                                                                
/***************************************************************************
 * $Id: help_zh.php,v 1.1.1.1 2004/11/02 03:30:24 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

// translator(s): Yanmiao Liu (yanmiao_liu(at)yahoo.com)
$help['setup_mkdirMethod'] = '如果打开安全模式，需要设置一个能够用文件管理创建文件夹的 FTP 账号。';
$help['setup_notifications'] = '用户邮件通知（任务指派、新帖、任务改变...）<br>需要有效的 smtp/sendmail。';
$help['setup_forcedlogin'] = '如果是 FALSE，不允许在 URL 上用登录/密码的外部链接';
$help['setup_langdefault'] = '选择登录时使用的默认语言，或留空使用自动检测浏览器语言。';
$help['setup_myprefix'] = '如果在已有数据库中有同名表，设置此值。<br><br>assignments<br>bookmarks<br>bookmarks_categories<br>calendar<br>files<br>logs<br>members<br>notes<br>notifications<br>organizations<br>phases<br>posts<br>projects<br>reports<br>sorting<br>support_posts<br>support_requests<br>tasks<br>tasks_time<br>teams<br>topics<br>updates<br><br>不使用表前缀时，请留空。';
$help['setup_loginmethod'] = '在数据库中存储密码的方法。<br>设置&quot;Crypt&quot; CVS 认证和 htaccess 认证才能工作（如果启用了 CVS 支持或 htaccess 认证）。';
$help['admin_update'] = '考虑指定更新版本的确切指令<br>1. 编辑设置（补充新参数）<br>2. 编辑数据库（更新显示的先前版本）';
$help['task_scope_creep'] = '到期日期与完成日期的天数差距（正值为黑体）';
$help['max_file_size'] = '上载文件的最大文件大小';
$help['project_disk_space'] = '项目文件的总大小';
$help['project_scope_creep'] = '到期日期与完成日期的天数差距（正值为黑体）。所有任务的总和';
$help['mycompany_logo'] = '上载公司标志。出现在头上，替换标题站点';
$help['calendar_shortname'] = '月历视图中出现的标题。必要的';
$help['user_autologout'] = '不活动后断开按秒计的时间。0 禁用';
$help['user_timezone'] = '设置 GMT 时区';
//2.4
$help['setup_clientsfilter'] = '只查看记录的用户客户的过滤器';
$help['setup_projectsfilter'] = '只查看用户在团队中的项目的过滤器';
//2.5
$help['setup_notificationMethod'] = '设置发送邮件通知的方法：用内部 php 邮件功能（需要有 smtp 服务器或在 php 参数中配置的 sendmail）或用私有的 smtp 服务器';
?>
