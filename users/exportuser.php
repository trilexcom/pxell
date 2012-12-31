<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: exportuser.php,v 1.1.1.1 2004/11/02 03:30:21 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$checkSession = false;
require_once("../includes/library.php");

require_once("../includes/vcard.class.php");

$tmpquery = "WHERE mem.id = '$id'";
$userDetail = new request();
$userDetail->openMembers($tmpquery);

$v = new vCard();

$v->setPhoneNumber($userDetail->mem_phone_work[0]);

$v->setName($userDetail->mem_name[0]);

$v->setTitle($userDetail->mem_title[0]);

$v->setOrganization($userDetail->mem_org_name[0]);

$v->setEmail($userDetail->mem_email_work[0]);

$v->setPhoneNumber($userDetail->mem_phone_work[0], "WORK;VOICE");

$v->setPhoneNumber($userDetail->mem_phone_home[0], "HOME;VOICE");

$v->setPhoneNumber($userDetail->mem_mobile[0], "CELL;VOICE");

$v->setPhoneNumber($userDetail->mem_fax[0], "WORK;FAX");

$output = $v->getVCard();
$filename = $v->getFileName();

Header("Content-Disposition: attachment; filename=$filename");
Header("Content-Length: " . strlen($output));
Header("Connection: close");
Header("Content-Type: text/x-vCard; name=$filename");

echo $output;

?>
