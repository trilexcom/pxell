<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: help_it.php,v 1.1.1.1 2004/11/02 03:30:22 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s): Francesco Fullone <fullone@csr.unibo.it>
$help["setup_mkdirMethod"] = "Se il safe-mode è abilitato (On), devi configurare un account Ftp per poter creare cartelle con la gestione dei file.";
$help["setup_notifications"] = "Notifica agli usenti tramite e-mail (assegnazione task, nuove discussioni, modifiche ai task...)<br>E' necessario un server smtp/sendmail funzionante.";
$help["setup_forcedlogin"] = "Se falso, blocca i link esterno contententi login/password nell'url";
$help["setup_langdefault"] = "Sceglie il linguaggio che sarà automaticamente selezionato in fase di login se lasciato in bianco sarà attivato l'auto_detect del linguaggio del browser.";
$help["setup_myprefix"] = "Assegna questo valore se hai tabelle con lo stesso nome nel database.<br><br>assignments<br>bookmarks<br>bookmarks_categories<br>calendar<br>files<br>logs<br>members<br>notes<br>notifications<br>organizations<br>phases<br>posts<br>projects<br>reports<br>sorting<br>subtasks<br>support_posts<br>support_requests<br>tasks<br>teams<br>topics<br>updates<br><br>Lascialo in bianco per non usare il prefisso sulle tabelle.";
$help["setup_loginmethod"] = "Metodo per memorizzare le passwords nel database.<br>Seleziona &quot;Crypt&quot; per abilitare le autenticazioni su CVS e htaccess  (se il supporto CVS e/o l'autenticazione htaccess sono abilitati).";
$help["admin_update"] = "Rispetta l'ordine indicato per aggiornare la tua versione<br>1. Modifica configurazione (aggiungi i nuovi parametri)<br>2. Modifica il database (aggiorna in accordo con la tua precedente versione)";
$help["task_scope_creep"] = "Differenza in giorni tra la data di scadenza e quella di completamento (grassetto se positivo)";
$help["max_file_size"] = "Grandezza massima dei file da caricare";
$help["project_disk_space"] = "Spazio massimo consentito per i files per il progetto";
$help["project_scope_creep"] = "Differenza in giorni tra la data di scadenza e quella di completamento (grassetto se positivo). Totale per tutti i tasks";
$help["mycompany_logo"] = "Carica un logo per la tua azienda. Apparirà nell'intestazione, sostituendo il titolo del sito";
$help["calendar_shortname"] = "Etichetta che apparirà nella visualizzazione mensile del calendario. Obbligatorio";
$help["user_autologout"] = "Tempo in sec. prima di essere disconnesso dopo nessuna attività. 0 per disabilitare";
$help["user_timezone"] = "Configura il tuo fuso orario (GMT)";
// 2.4
$help["setup_clientsfilter"] = "Filtra per vedere solo i clienti autenticati";
$help["setup_projectsfilter"] = "Filtra per vedere solo il progetto quando l'utente è nel gruppo di lavoro";
// 2.5
$help["setup_notificationMethod"] = "Seleziona il metodo per inviare tramite email le notifiche: tramite le funzioni mail incluse nel php (necessitano di un server smtp o sendmail configurato nei parametri del php) o tramite un smtp server personale";

?>
