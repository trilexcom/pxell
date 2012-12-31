<?php // $Revision: 1.3 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: db_var.inc.php,v 1.3 2004/12/06 22:14:51 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

$db_smallint['mysql'] = "smallint(5) unsigned NOT NULL default '0'";
$db_mediumint_auto['mysql'] = 'mediumint(8) unsigned NOT NULL auto_increment';
$db_bigint_auto['mysql'] = 'bigint(20) unsigned NOT NULL auto_increment';
$db_mediumint['mysql'] = "mediumint(8) unsigned NOT NULL default '0'";
$db_int['mysql'] = "int(10) unsigned NOT NULL default '0'";
$db_float['mysql'] = "float(10,2) NOT NULL default '0.00'";
$db_char1['mysql'] = "char(1) NOT NULL default ''";
$db_char1default0['mysql'] = "char(1) NOT NULL default '0'";
$db_char2['mysql'] = "char(2) NOT NULL default ''";
$db_char3['mysql'] = "char(3) NOT NULL default ''";
$db_varchar5['mysql'] = 'varchar(5)';
$db_varchar10['mysql'] = 'varchar(10)';
$db_varchar16['mysql'] = 'varchar(16)';
$db_varchar16b['mysql'] = 'varchar(16) NOT NULL';
$db_varchar32['mysql'] = 'varchar(32) NOT NULL';
$db_varchar155['mysql'] = 'varchar(155)';
$db_varchar255['mysql'] = 'varchar(255)';
$db_varchar255a['mysql'] = "varchar(255) NOT NULL default '0'";
$db_varchar255b['mysql'] = "varchar(255) NOT NULL default '0.0'";
$db_text['mysql'] = 'text';
$db_longtext['mysql'] = 'longtext';

?>
