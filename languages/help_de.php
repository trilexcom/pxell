<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: help_de.php,v 1.1.1.1 2004/11/02 03:30:24 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s): Wolfram Lamm
$help['setup_mkdirMethod'] = 'Wenn der PHP safe-mode eingeschaltet ist, darf kein Verzeichnis angelegt werden, dann muss ein FTP Account eingerichtet werden.';
$help['setup_notifications'] = 'E-mail Benachrichtigungen bei Aenderungen ein/ausschalten<br>Funktionierendes smtp/sendmail muss vorhanden sein.';
$help['setup_forcedlogin'] = 'Login mut User ID und Password in der URL ein-/ausschalten.';
$help['setup_langdefault'] = 'Standardsprache beim Login waehlen. Wenn nicht ausgefuellt wird versucht diese aus dem Browser zu ermitteln..';
$help['setup_myprefix'] = 'Nur notwendig wenn bereits Tabellen mit gleichem Namen in der Datenbank enthalten sind.<br><br>Benutzte Namen:<br><br>assignments<br>bookmarks<br>bookmarks_categories<br>calendar<br>files<br>logs<br>members<br>notes<br>notifications<br>organizations<br>phases<br>posts<br>projects<br>reports<br>sorting<br>subtasks<br>support_posts<br>support_requests<br>tasks<br>teams<br>topics<br>updates';
$help['setup_loginmethod'] = 'Wie sollen Passwords in der Datenbank gespeichert werden?<br>';
$help['admin_update'] = 'Unbedingt die Reihenfolge beim Versionsupdate einhalten.<br>1. Einstellungen &auml;ndern<br>2. Datenbank &auml;ndern';
$help['task_scope_creep'] = 'Tage bis zur Faelligkeit (Fett bei Ueberschreitung)';
$help['max_file_size'] = 'Maximale Dateigr&ouml;&szlig; f&uuml;r Uploads';
$help['project_disk_space'] = 'Aktueller Speicherverbrauch des Projekts.';
$help['project_scope_creep'] = 'Differenz in Tagen zwischen Faeliigkeit und Fertigstellung (Fett bei Ueberschreitung). Summe aller Aufgaben.';
$help['mycompany_logo'] = 'Beliebiges Firmenlogo uploaden, es erscheint dann im Kopf jeder Seite.';
$help['calendar_shortname'] = 'Dieser Text wird im Kalender angezeigt (Pflichtfeld)';
$help['user_autologout'] = 'Nach wievielen Sekunden Inaktivit&auml;t soll die Verbindung getrennt werden? (0 = Nie)';
$help['user_timezone'] = 'GMT Zeitzone einstellen';
// 2.4
$help['setup_clientsfilter'] = 'Filter to see only logged user clients';
$help['setup_projectsfilter'] = 'Filter to see only the project when the user are in the team';
// 2.5
$help['setup_notificationMethod'] = 'Set method to send email notifications: with internal php mail function (need for having a smtp server or sendmail configured in the parameters of php) or with a personalized smtp server';

?>
