<?php // $Revision: 1.1.1.1 $
                                                                                
/* vim: set expandtab ts=4 sw=4 sts=4: */
                                                                                
/***************************************************************************
 * $Id: lang_zh.php,v 1.1.1.1 2004/11/02 03:30:22 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

//translator(s): Yanmiao Liu (yanmiao_liu(at)yahoo.com)
$topicNote = array(
    1 => '电话对话',
    2 => '会议备注',
    3 => '一般备注'
  );
                                                                                
$phaseArraySets = array(
    #Define the names of your phase sets
    'sets' => array(1 => '网站', 2 => '应用程序'),
      #List the individual items within each phase set.
      #Website Set
      1 => array(0 => '概念', 1 => '计划', 2 => '开发',
                 3 => '测试', 4 => '公布',  5 => '维护'),
      #Application Set
      2 => array(0 => '概念', 1 => '计划', 2 => '开发',
                 3 => '测试', 4 => '公布',  5 => '维护')
  );

$autoLogoutOptions = array(
           0 => '禁用',
         300 => '5 分钟',
         600 => '10 分钟',
         900 => '15 分钟',
        1800 => '30 分钟',
        2700 => '45 分钟',
        3600 => '60 分钟'
    );

$setCharset = 'GB2312';

$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$dayNameArray = array(1 =>'星期一', 2 =>'星期二', 3 =>'星期三', 4 =>'星期四', 5 =>'星期五', 6 =>'星期六', 7 =>'星期日');

$monthNameArray = array(1=> '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'); 

$status = array(0 => '客户完成', 1 => '完成', 2 => '未开始', 3 => '开放', 4 => '暂停');

$profil = array(0 => '管理员', 1 => '项目经理', 2 => '用户', 3 => '客户用户', 4 => '禁用', 5 => '项目经理管理员');

$priority = array(0 => '无', 1 => '很低', 2 => '低', 3 => '中', 4 => '高', 5 => '很高');

$statusTopic = array(0 => '关闭', 1 => '开放');
$statusTopicBis = array(0 => '是', 1 => '否');

$statusPublish = array(0 => '是', 1 => '否');

$statusFile = array(0 => '已经认可', 1 => '认可但有更改', 2 => '等待认可', 3 => '无需认可', 4 => '未被认可');

$phaseStatus = array(0 => '未开始', 1 => '开放', 2 => '完成', 3 => '暂停');

$requestStatus = array(0 => '新建', 1 => '开放', 2 => '完成');

$projectType = array(0 => '免费项目', 1 => '收费项目');

$strings['please_login'] = '敬请登录';
$strings['requirements'] = '系统需求';
$strings['login'] = '登录';
$strings['no_items'] = '无相关条目显示';
$strings['logout'] = '退出';
$strings['preferences'] = '参数设定';
$strings['my_tasks'] = '我的任务';
$strings['edit_task'] = '编辑任务';
$strings['copy_task'] = '复制任务';
$strings['add_task'] = '添加任务';
$strings['delete_tasks'] = '删除任务';
$strings['assignment_history'] = '工作分配历史记录';
$strings['assigned_on'] = '分配于';
$strings['assigned_by'] = '分配者为';
$strings['to'] = '前往';
$strings['comment'] = '意见';
$strings['task_assigned'] = '任务分配给';
$strings['task_unassigned'] = '任务未被分配到成员（未分配）';
$strings['edit_multiple_tasks'] = '编辑多个任务';
$strings['tasks_selected'] = '任务被选定。为这些任务选择新的参数，或者选择[无变动]以保持原有状态。';
$strings['assignment_comment'] = '分配意见';
$strings['no_change'] = '[无变动]';
$strings['my_discussions'] = '我的讨论';
$strings['discussions'] = '讨论';
$strings['delete_discussions'] = '删除讨论';
$strings['delete_discussions_note'] = '小心：讨论一旦被删除不能再次打开。';
$strings['topic'] = '话题';
$strings['posts'] = '帖子';
$strings['latest_post'] = '最新帖子';
$strings['my_reports'] = '我的报告';
$strings['reports'] = '报告';
$strings['create_report'] = '创建报告';
$strings['report_intro'] = '在此选择您的任务报告参数并在运行之后在结果页面保存此查询。';
$strings['admin_intro'] = '项目设定和配置。';
$strings['copy_of'] = '副本';
$strings['add'] = '添加';
$strings['delete'] = '删除';
$strings['remove'] = '移除';
$strings['copy'] = '复制';
$strings['view'] = '查看';
$strings['edit'] = '编辑';
$strings['update'] = '更新';
$strings['details'] = '详细';
$strings['none'] = '无';
$strings['close'] = '关闭';
$strings['new'] = '新建';
$strings['select_all'] = '选择全部';
$strings['unassigned'] = '未分配';
$strings['administrator'] = '管理员';
$strings['my_projects'] = '我的项目';
$strings['project'] = '项目';
$strings['active'] = '正活跃';
$strings['inactive'] = '非活跃';
$strings['project_id'] = '项目编号';
$strings['edit_project'] = '编辑项目';
$strings['copy_project'] = '复制项目';
$strings['add_project'] = '添加项目';
$strings['clients'] = '客户';
$strings['organization'] = '客户组织';
$strings['client_projects'] = '客户项目';
$strings['client_users'] = '客户访问者';
$strings['edit_organization'] = '编辑客户组织';
$strings['add_organization'] = '添加客户组织';
$strings['organizations'] = '客户组织';
$strings['info'] = '信息';
$strings['status'] = '状态';
$strings['owner'] = '所有者';
$strings['home'] = '主页';
$strings['projects'] = '项目';
$strings['files'] = '文件';
$strings['search'] = '搜索';
$strings['admin'] = '管理';
$strings['user'] = '用户';
$strings['project_manager'] = '项目经理';
$strings['due'] = '到期';
$strings['task'] = '任务';
$strings['tasks'] = '任务';
$strings['team'] = '团队';
$strings['add_team'] = '添加团队成员';
$strings['team_members'] = '团队成员';
$strings['full_name'] = '全名';
$strings['title'] = '称呼';
$strings['user_name'] = '用户名称';
$strings['work_phone'] = '工作电话';
$strings['priority'] = '优先级';
$strings['name'] = '名称';
$strings['id'] = '编号';
$strings['description'] = '描述';
$strings['phone'] = '电话';
$strings['url'] = '网址';
$strings['address'] = '地址';
$strings['comments'] = '注释';
$strings['created'] = '被创建';
$strings['assigned'] = '被分配';
$strings['modified'] = '被更改';
$strings['assigned_to'] = '分配给';
$strings['due_date'] = '到期日期';
$strings['estimated_time'] = '估计时间';
$strings['actual_time'] = '实际时间';
$strings['delete_following'] = '确认删除？';
$strings['cancel'] = '取消';
$strings['and'] = '和';
$strings['administration'] = '管理';
$strings['user_management'] = '用户管理';
$strings['system_information'] = '系统信息';
$strings['product_information'] = '产品信息';
$strings['system_properties'] = '系统属性';
$strings['create'] = '创建';
$strings['report_save'] = '将此报告查询保存至您的主页以便下次执行。';
$strings['report_name'] = '报告名称';
$strings['save'] = '保存';
$strings['matches'] = '匹配';
$strings['match'] = '匹配';
$strings['report_results'] = '报告结果';
$strings['success'] = '成功';
$strings['addition_succeeded'] = '添加成功';
$strings['deletion_succeeded'] = '删除成功';
$strings['report_created'] = '已创建报告';
$strings['deleted_reports'] = '已删除报告';
$strings['modification_succeeded'] = '更改成功';
$strings['errors'] = '出错！';
$strings['blank_user'] = '该用户不存在。';
$strings['blank_organization'] = '该客户组织不存在。';
$strings['blank_project'] = '该项目不存在。';
$strings['user_profile'] = '用户资料';
$strings['change_password'] = '更改密码';
$strings['change_password_user'] = '更改该用户的密码。';
$strings['old_password_error'] = '您输入的旧密码不正确。请重新输入。';
$strings['new_password_error'] = '您输入的两个密码不匹配。请重新输入。';
$strings['notifications'] = '通知';
$strings['change_password_intro'] = '输入您的旧密码，然后输入并再次输入确认您的新密码。';
$strings['old_password'] = '旧密码';
$strings['password'] = '密码';
$strings['new_password'] = '新密码';
$strings['confirm_password'] = '确认密码';
$strings['email'] = '电子邮件';
$strings['home_phone'] = '家庭电话';
$strings['mobile_phone'] = '移动电话';
$strings['fax'] = '传真';
$strings['permissions'] = '权限';
$strings['administrator_permissions'] = '管理员权限';
$strings['project_manager_permissions'] = '项目经理权限';
$strings['user_permissions'] = '普通成员权限';
$strings['account_created'] = '账号被创建';
$strings['edit_user'] = '编辑用户';
$strings['edit_user_details'] = '编辑详细用户信息。';
$strings['change_user_password'] = '更改该用户的密码。';
$strings['select_permissions'] = '为该用户选择选择权限';
$strings['add_user'] = '添加用户';
$strings['enter_user_details'] = '输入您添加的用户详细信息。';
$strings['enter_password'] = '输入该用户的密码。';
$strings['success_logout'] = '您已经成功退出。您可以通过输入登录名和密码重新登录系统。';
$strings['invalid_login'] = '您输入的登录名或密码错误。请重新输入您的登录信息。';
$strings['profile'] = '资料';
$strings['user_details'] = '详细用户信息。';
$strings['edit_user_account'] = '编辑您的用户信息。';
$strings['no_permissions'] = '您没有足够的权限完成此操作。';
$strings['discussion'] = '讨论';
$strings['retired'] = '退休';
$strings['last_post'] = '最后帖子';
$strings['post_reply'] = '张贴回复';
$strings['posted_by'] = '张贴者为';
$strings['when'] = '当时';
$strings['post_to_discussion'] = '张贴到讨论';
$strings['message'] = '消息';
$strings['delete_reports'] = '删除报告';
$strings['delete_projects'] = '删除项目';
$strings['delete_organizations'] = '删除客户组织';
$strings['delete_organizations_note'] = '小心：属于这些客户组织的客户访问者帐号将均被删除，同时属于这些客户组织的项目也将被取消关联。';
$strings['delete_messages'] = '删除消息';
$strings['attention'] = '注意';
$strings['delete_teamownermix'] = '删除成功，但是项目拥有者不能从项目中删除。';
$strings['delete_teamowner'] = '您不能将项目拥有者从项目中删除。';
$strings['enter_keywords'] = '输入关键字';
$strings['search_options'] = '关键字和搜索条件';
$strings['search_note'] = '您必须填写搜索条件栏。';
$strings['search_results'] = '搜索结果';
$strings['users'] = '用户';
$strings['search_for'] = '搜索';
$strings['results_for_keywords'] = '根据关键字搜索结果';
$strings['add_discussion'] = '添加讨论';
$strings['delete_users'] = '删除用户账号';
$strings['reassignment_user'] = '项目和任务的重新分配';
$strings['there'] = '存在';
$strings['owned_by'] = '由以上用户拥有。';
$strings['reassign_to'] = '在删除用户之前，将这些委派给';
$strings['no_files'] = '无关联文件';
$strings['published'] = '发布';
$strings['project_site'] = '项目网站';
$strings['approval_tracking'] = '认可追踪';
$strings['size'] = '大小';
$strings['add_project_site'] = '添加到项目网站';
$strings['remove_project_site'] = '从项目网站中删除';
$strings['more_search'] = '更多搜索选项';
$strings['results_with'] = '查找到结果';
$strings['search_topics'] = '搜索话题';
$strings['search_properties'] = '搜索属性';
$strings['date_restrictions'] = '日期限制';
$strings['case_sensitive'] = '大小写敏感';
$strings['yes'] = '是';
$strings['no'] = '否';
$strings['sort_by'] = '分类标准为';
$strings['type'] = '类型';
$strings['date'] = '日期';
$strings['all_words'] = '所有单词';
$strings['any_words'] = '任何单词';
$strings['exact_match'] = '确切匹配';
$strings['all_dates'] = '所有时间';
$strings['between_dates'] = '日期区域';
$strings['all_content'] = '所有内容';
$strings['all_properties'] = '所有属性';
$strings['no_results_search'] = '该搜索未返回任何结果。';
$strings['no_results_report'] = '该报告未返回任何结果。';
$strings['schema_date'] = 'YYYY/MM/DD';
$strings['hours'] = '小时';
$strings['choice'] = '选择';
$strings['missing_file'] = '缺少文件！';
$strings['project_site_deleted'] = '项目网站被成功删除。';
$strings['add_user_project_site'] = '该用户已被成功授予权限以访问项目网站。';
$strings['remove_user_project_site'] = '用户权限已被成功删除。';
$strings['add_project_site_success'] = '对于项目网站的内容添加成功。';
$strings['remove_project_site_success'] = '对于项目网站的内容删除成功。';
$strings['add_file_success'] = '链接一个文档。';
$strings['delete_file_success'] = '删除文件成功。';
$strings['update_comment_file'] = '文件内容已经成功更新。';
$strings['session_false'] = '会话错误';
$strings['logs'] = '系统日志';
$strings['logout_time'] = '自动退出';
$strings['noti_foot1'] = '该通知由 NetOffice 生成。';
$strings['noti_foot2'] = '查看您的 NetOffice 主页，请访问：';
$strings['noti_taskassignment1'] = '新任务：';
$strings['noti_taskassignment2'] = '一个任务被分配给您：';
$strings['noti_moreinfo'] = '获得更多信息，请访问：';
$strings['noti_prioritytaskchange1'] = '任务优先级更改：';
$strings['noti_prioritytaskchange2'] = '下列任务的优先级已经被更改：';
$strings['noti_statustaskchange1'] = '任务状态更改：';
$strings['noti_statustaskchange2'] = '下列任务的状态已经被更改：';
$strings['login_username'] = '您必须输入一个用户名。';
$strings['login_password'] = '请输入密码。';
$strings['login_clientuser'] = '您正在以客户访问者身份登录。您不能以客户访问者身份进入 NetOffice 系统。';
$strings['user_already_exists'] = '已经有同名用户存在。请根据该用户的名字重新选择登录名。';
$strings['noti_duedatetaskchange1'] = '任务到期时间更改：';
$strings['noti_duedatetaskchange2'] = '下列任务的到期时间已经被更改：';
$strings['company'] = '公司';
$strings['show_all'] = '显示全部';
$strings['information'] = '信息';
$strings['delete_message'] = '删除此条消息';
$strings['project_team'] = '项目团队';
$strings['document_list'] = '文档列表';
$strings['bulletin_board'] = '公告板';
$strings['bulletin_board_topic'] = '公告板话题';
$strings['create_topic'] = '创建新话题';
$strings['topic_form'] = '话题表单';
$strings['enter_message'] = '输入您的消息';
$strings['upload_file'] = '上传文件';
$strings['upload_form'] = '上传表单';
$strings['upload'] = '上传';
$strings['document'] = '文档';
$strings['approval_comments'] = '被认可的意见';
$strings['client_tasks'] = '客户任务';
$strings['team_tasks'] = '团队任务';
$strings['team_member_details'] = '详细项目团队成员信息';
$strings['client_task_details'] = '详细客户任务信息';
$strings['team_task_details'] = '详细团队任务信息';
$strings['language'] = '语言';
$strings['welcome'] = '欢迎';
$strings['your_projectsite'] = '去往您的项目网站';
$strings['contact_projectsite'] = '如果您有任何有关网络或者系统信息的疑问，请联系项目负责人';
$strings['company_details'] = '详细公司信息';
$strings['database'] = '备份和恢复数据库';
$strings['company_info'] = '编辑您的公司信息';
$strings['create_projectsite'] = '创建项目站点';
$strings['projectsite_url'] = '项目网站网址';
$strings['design_template'] = '设计模板';
$strings['preview_design_template'] = '预览模板设计';
$strings['delete_projectsite'] = '删除项目网站';
$strings['add_file'] = '添加文件';
$strings['linked_content'] = '相关文档';
$strings['edit_file'] = '编辑详细文件信息';
$strings['permitted_client'] = '被许可的客户访问者';
$strings['grant_client'] = '授予查看项目网站的权利';
$strings['add_client_user'] = '添加客户用户';
$strings['edit_client_user'] = '编辑客户用户';
$strings['client_user'] = '客户用户';
$strings['client_change_status'] = '在您完成任务之后更改您的状态';
$strings['project_status'] = '项目状态';
$strings['view_projectsite'] = '查看项目网站';
$strings['enter_login'] = '输入您的登录名以取回密码';
$strings['send'] = '发送';
$strings['no_login'] = '数据库中无该登录名';
$strings['email_pwd'] = '密码已经发送';
$strings['no_email'] = '无电子邮件地址用户';
$strings['forgot_pwd'] = '忘记了密码？';
$strings['project_owner'] = '您只能对自己的项目进行改动。';
$strings['connected'] = '已连接';
$strings['session'] = '会话';
$strings['last_visit'] = '上次访问';
$strings['compteur'] = '总计';
$strings['ip'] = 'IP 地址';
$strings['task_owner'] = '您不是该项目组的成员';
$strings['export'] = '导出';
$strings['browse_cvs'] = '浏览 CVS';
$strings['repository'] = 'CVS 代码库';
$strings['reassignment_clientuser'] = '任务再分配';
$strings['organization_already_exists'] = '该名称已被该系统使用。请使用其他名称。';
$strings['blank_organization_field'] = '您必须输入用户组织的名称。';
$strings['blank_fields'] = '必填条目';
$strings['projectsite_login_fails'] = '用户名称/密码对不正确。';
$strings['start_date'] = '开始日期';
$strings['completion'] = '完成';
$strings['update_available'] = '已有最近的更新！';
$strings['version_current'] = '您正在使用的版本是';
$strings['version_latest'] = '最新版本是';
$strings['sourceforge_link'] = '参阅 SourceForge 中的项目主页';
$strings['demo_mode'] = '演示模式。不允许实际操作。';
$strings['setup_erase'] = '删除文件 setup.php！！';
$strings['no_file'] = '无文件被选择';
$strings['exceed_size'] = '超出允许的最大文件容量';
$strings['no_php'] = '不允许 PHP 文件';
$strings['approval_date'] = '认可日期';
$strings['approver'] = '认可者';
$strings['error_database'] = '不能连接到数据库';
$strings['error_server'] = '不能连接到服务器';
$strings['version_control'] = '版本控制';
$strings['vc_status'] = '状态';
$strings['vc_last_in'] = '最后修改时间';
$strings['ifa_comments'] = '认可内容';
$strings['ifa_command'] = '改变认可状态';
$strings['vc_version'] = '版本';
$strings['ifc_revisions'] = '增加并行版本';
$strings['ifc_revision_of'] = '版本评论';
$strings['ifc_add_revision'] = '增加并行版本';
$strings['ifc_update_file'] = '文件更新';
$strings['ifc_last_date'] = '最后修改时间';
$strings['ifc_version_history'] = '版本变更历史';
$strings['ifc_delete_file'] = '删除文件和其全部子版本';
$strings['ifc_delete_version'] = '删除选定的文件版本';
$strings['ifc_delete_review'] = '删除选择的评论';
$strings['ifc_no_revisions'] = '当前此文档没有修订版本';
$strings['unlink_files'] = '删除文件';
$strings['remove_team'] = '删除团队成员';
$strings['remove_team_info'] = '把这些成员从团队中删除吗？';
$strings['remove_team_client'] = '去掉项目站点的查看权限';
$strings['note'] = '备注';
$strings['notes'] = '备注';
$strings['subject'] = '主题';
$strings['delete_note'] = '删除备注记录';
$strings['add_note'] = '增加一个备注';
$strings['edit_note'] = '编辑一个备注';
$strings['version_increm'] = '选择一个版本改变进行应用：';
$strings['url_dev'] = '开发中的站点链接';
$strings['url_prod'] = '最终站点链接';
$strings['note_owner'] = '您只能对自己增加的备注进行修改。';
$strings['alpha_only'] = '登录时只允许字母和数字字符';
$strings['edit_notifications'] = '编辑电子邮件通知';
$strings['edit_notifications_info'] = '选择您希望接受电子邮件通知的事件。';
$strings['select_deselect'] = '选择全部/取消选择全部';
$strings['noti_addprojectteam1'] = '添加到一个团队：';
$strings['noti_addprojectteam2'] = '您已经被添加到下面的项目团队中：';
$strings['noti_removeprojectteam1'] = '从项目团对中删除：';
$strings['noti_removeprojectteam2'] = '您已经从下面的项目团队中删除：';
$strings['noti_newpost1'] = '新的文章：';
$strings['noti_newpost2'] = '一篇新文章已经被加入到讨论中：';
$strings['edit_noti_taskassignment'] = '我已经被指定了一个新任务。';
$strings['edit_noti_statustaskchange'] = '我的一个任务的完成状态已经修改。';
$strings['edit_noti_prioritytaskchange'] = '我的一个任务的紧急度已经修改。';
$strings['edit_noti_duedatetaskchange'] = '我的一个任务的到期时间已经修改。';
$strings['edit_noti_addprojectteam'] = '我被添加到一个新的团队中。';
$strings['edit_noti_removeprojectteam'] = '我已经从一个项目团队中删除。';
$strings['edit_noti_newpost'] = '一篇新文章已经建立到下面的讨论中。';
$strings['add_optional'] = '添加选项';
$strings['assignment_comment_info'] = '为指派该任务添加备注';
$strings['my_notes'] = '我的便条';
$strings['edit_settings'] = '编辑设置';
$strings['max_upload'] = '最大文件大小';
$strings['project_folder_size'] = '项目文件夹大小';
$strings['calendar'] = '日历';
$strings['date_start'] = '开始日期';
$strings['date_end'] = '结束日期';
$strings['time_start'] = '开始时间';
$strings['time_end'] = '结束时间';
$strings['calendar_reminder'] = '提醒';
$strings['shortname'] = '简称';
$strings['calendar_recurring'] = '事件将在每周的这一天重复出现。';
$strings['edit_database'] = '编辑数据库';
$strings['noti_newtopic1'] = '新的讨论：';
$strings['noti_newtopic2'] = '新的讨论被添加到以下的项目：';
$strings['edit_noti_newtopic'] = '新的讨论话题被创建。';
$strings['today'] = '今天';
$strings['previous'] = '上月';
$strings['next'] = '下月';
$strings['help'] = '帮助';
$strings['complete_date'] = '完成日期';
$strings['scope_creep'] = '时间范围';
$strings['days'] = '天';
$strings['logo'] = '标志';
$strings['remember_password'] = '记住密码';
$strings['client_add_task_note'] = '注意：输入的任务已被加入数据库，但只有被分配给某一团队成员之后才会再次出现！';
$strings['noti_clientaddtask1'] = '任务被以下用户添加：';
$strings['noti_clientaddtask2'] = '新的任务被客户由项目网站添加到以下项目：';
$strings['phase'] = '阶段';
$strings['phases'] = '阶段';
$strings['phase_id'] = '阶段编号';
$strings['current_phase'] = '活跃的阶段';
$strings['total_tasks'] = '所有任务';
$strings['uncomplete_tasks'] = '未完成任务';
$strings['no_current_phase'] = '无当前活跃的阶段';
$strings['true'] = '真';
$strings['false'] = '假';
$strings['enable_phases'] = '激活阶段';
$strings['phase_enabled'] = '阶段被激活';
$strings['order'] = '订单';
$strings['options'] = '选项';
$strings['support'] = '支持';
$strings['support_request'] = '支持请求';
$strings['support_requests'] = '支持请求';
$strings['support_id'] = '请求编号';
$strings['my_support_request'] = '我的支持请求';
$strings['introduction'] = '介绍';
$strings['submit'] = '提交';
$strings['support_management'] = '支持管理';
$strings['date_open'] = '开放日期';
$strings['date_close'] = '关闭日期';
$strings['add_support_request'] = '添加支持请求';
$strings['add_support_response'] = '添加支持反馈';
$strings['respond'] = '反馈';
$strings['delete_support_request'] = '支持请求被删除';
$strings['delete_request'] = '删除支持请求';
$strings['delete_support_post'] = '删除支持帖子';
$strings['new_requests'] = '新的请求';
$strings['open_requests'] = '开放请求';
$strings['closed_requests'] = '完成请求';
$strings['manage_new_requests'] = '管理新请求';
$strings['manage_open_requests'] = '管理开发请求';
$strings['manage_closed_requests'] = '管理完成请求';
$strings['responses'] = '反馈';
$strings['edit_status'] = '编辑状态';
$strings['noti_support_request_new2'] = '您已经发布了支持请求，关于：';
$strings['noti_support_post2'] = '新的反馈被添加到您的支持请求。请复查以下的详细信息。';
$strings['noti_support_status2'] = '您的支持请求被更新。请复查以下的详细信息。';
$strings['noti_support_team_new2'] = '新的支持请求被添加到项目：';
//2.0
$strings['delete_subtasks'] = '删除子任务';
$strings['add_subtask'] = '添加子任务';
$strings['edit_subtask'] = '编辑子任务';
$strings['subtask'] = '子任务';
$strings['subtasks'] = '子任务';
$strings['show_details'] = '显示详细';
$strings['updates_task'] = '任务更新历史';
$strings['updates_subtask'] = '子任务更新历史';
//2.1
$strings['go_projects_site'] = '转到项目网站';
$strings['bookmark'] = '书签';
$strings['bookmarks'] = '书签';
$strings['bookmark_category'] = '类别';
$strings['bookmark_category_new'] = '新类别';
$strings['bookmarks_all'] = '所有';
$strings['bookmarks_my'] = '我的书签';
$strings['my'] = '我的';
$strings['bookmarks_private'] = '私人';
$strings['shared'] = '共享';
$strings['private'] = '私人';
$strings['add_bookmark'] = '添加书签';
$strings['edit_bookmark'] = '编辑书签';
$strings['delete_bookmarks'] = '删除书签';
$strings['team_subtask_details'] = '团队子任务细节';
$strings['client_subtask_details'] = '客户子任务细节';
$strings['client_change_status_subtask'] = '完成此项子任务后改变下面的状态';
$strings['disabled_permissions'] = '禁用账号';
$strings['user_timezone'] = '时区 (GMT)';
//2.2
$strings['project_manager_administrator_permissions'] = '项目经理管理员';
$strings['bug'] = '缺陷追踪';
//2.3
$strings['report'] = '报告';
$strings['license'] = '许可';
//2.4
$strings['settings_notwritable'] = 'Settings.php 文件不可写';
//2.5
$strings['name_print'] = '打印名称';
$strings['calculation'] = '计算';
$strings['items'] = '条目';
$strings['position'] = '位置';
$strings['completed'] = '完成';
$strings['service'] = '服务';
$strings['service_management'] = '服务管理';
$strings['hourly_rate'] = '小时费用';
$strings['add_service'] = '添加服务';
$strings['edit_service'] = '编辑服务';
$strings['delete_services'] = '删除服务';
$strings['worked_hours'] = '工作小时';
$strings['loghours'] = '记录小时';
$strings['logtime'] = '记录时间';
$strings['loggedby'] = '记录者';
$strings['error_required'] = '被需要';
$strings['error_numerical'] = '必须是数字';
$strings['hours_updated'] = '任务小时数已经更新';
$strings['add_task_time'] = '添加任务时间';
$strings['edit_task_time'] = '编辑任务时间';
$strings['delete_task_time'] = '删除任务时间';
$strings['task_time'] = '任务时间';
//2.5.1
$strings['email_users'] = '电子邮件用户';
$strings['email_following'] = '后续电子邮件';
$strings['email_sent'] = '您的邮件已经成功发送。';
$strings['all'] = '所有';
$strings['custom_reports'] = '客户报告';
$strings['custom_report_intro'] = '选择下面的基于其最适合您报告需求描述的客户报告。';
$strings['completed_task_report'] = '完成的任务';
$strings['completed_task_report_desc'] = '此报告提供上个月完成的任务列表。';
$strings['time_report'] = '时间报告';
$strings['time_report_desc'] = '此报告提供上个月每个项目雇员记录的小时数列表，并且可以导出此信息。';
$strings['overdue_tasks'] = '超期任务';
$strings['overdue_tasks_desc'] = '此报告显示所有项目中的任务概览列表。';
$strings['project_snapshot'] = '项目快照';
$strings['project_snapshot_desc'] = '此报告为登录用户提供项目概览，此时登录用户被认为是拥有者，以及与项目相关的任务。';
$strings['pending_tasks'] = '暂停任务';
$strings['pending_tasks_desc'] = '此报告提供已经纳入项目的项目任务的企业视图。';
$strings['pm_report'] = '项目经理报告';
$strings['pm_report_desc'] = '此报告显示按资源指派的项目和那些还没有指派的项目。';
$strings['project_phasestatus'] = '项目阶段状态';
$strings['project_phasestatus_desc'] = '显示所有活动项目的基本概览及其阶段';
$strings['resource_usage_detail'] = '此报告总结项目和组织记录的总时间。';
//2.5.2
$strings['install_erase'] = '删除安装目录及其内容！！';
$strings['error_phpversion'] = '您的 PHP 版本必须大于或等于 4.1.0 才能运行 NetOffice！';
$strings['display_options'] = '显示选项';
$strings['member_items'] = '成员条目';
$strings['project_totals'] = '项目总和';
$strings['organization_totals'] = '组织总和';
$strings['member_totals'] = '成员总和';
$strings['member_period_totals'] = '成员期间总和';
// 2.5.3
$strings['project_breakdown'] = '项目故障';
$strings['project_breakdown_desc'] = '项目列表划分条目的拥有者、状态和伙伴';
$strings['start_page'] = '开始于';
$strings['task_id'] = '任务编号';
?>
