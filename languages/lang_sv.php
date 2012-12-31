<?php // $Revision: 1.1.1.1 $
                                                                                
/* vim: set expandtab ts=4 sw=4 sts=4: */
                                                                                
/***************************************************************************
 * $Id: lang_sv.php,v 1.1.1.1 2004/11/02 03:30:22 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

//translator(s): Patrik Pada <patrik.pada@hssmedia.fi> & Andreas Pada <apada@abo.fi>
$topicNote = array(
    1 => 'Telefonkonversation',
    2 => 'Konferensnoteringar',
    3 => 'Anteckningar'
  );
                                                                                
$phaseArraySets = array(
    #Define the names of your phase sets
    'sets' => array(1 => 'Webbsidor', 2 => 'Applikationer'),
      #List the individual items within each phase set.
      #Website Set
      1 => array(0 => 'Koncept', 1 => 'Planering', 2 => 'Utveckling',
                 3 => 'Testning', 4 => 'Lansering',  5 => 'Underhåll'),
      #Application Set
      2 => array(0 => 'Koncept', 1 => 'Planering', 2 => 'Utveckling',
                 3 => 'Testning', 4 => 'Lansering',  5 => 'Underhåll')
  );

$autoLogoutOptions = array(
           0 => 'Av',
         300 => '5 minuter',
         600 => '10 minuter',
         900 => '15 minuter',
        1800 => '30 minuter',
        2700 => '45 minuter',
        3600 => '60 minuter'
    );

$setCharset = 'ISO-8859-1';

$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$dayNameArray = array(1 =>'Måndag', 2 =>'Tisdag', 3 =>'Onsdag', 4 =>'Torsdag', 5 =>'Fredag', 6 =>'Lördag', 7 =>'Söndag');

$monthNameArray = array(1=> 'Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'); 

$status = array(0 => 'Klar för kund', 1 => 'Klar', 2 => 'Ej påbörjad', 3 => 'Pågående', 4 => 'Uppehåll');

$profil = array(0 => 'Administratör', 1 => 'Projektledare', 2 => 'Användare', 3 => 'Kund Användare', 4 => 'Av', 5 => 'Projektledare Administratör');

$priority = array(0 => 'Ingen', 1 => 'Väldigt låg', 2 => 'Låg', 3 => 'Medium', 4 => 'Hög', 5 => 'Väldigt hög');

$statusTopic = array(0 => 'Stängd', 1 => 'Öppen');
$statusTopicBis = array(0 => 'Ja', 1 => 'Nej');

$statusPublish = array(0 => 'Ja', 1 => 'Nej');

$statusFile = array(0 => 'Godkänd', 1 => 'Godkänd med ändringar', 2 => 'För godkännande', 3 => 'Behöver ej godkännas', 4 => 'Ej godkänd');

$phaseStatus = array(0 => 'Ej påbörjad', 1 => 'Pågående', 2 => 'Klar', 3 => 'Uppehåll');

$requestStatus = array(0 => 'Ny', 1 => 'Pågående', 2 => 'Klar');

$projectType = array(0 => 'Kostnadsfritt projekt', 1 => 'Avgiftsbelagt projekt');

$strings['please_login'] = 'Vänligen logga in';
$strings['requirements'] = 'Systembehov';
$strings['login'] = 'Logga in';
$strings['no_items'] = 'Inga händelser';
$strings['logout'] = 'Logga ut';
$strings['preferences'] = 'Inställningar';
$strings['my_tasks'] = 'Mina uppgifter';
$strings['edit_task'] = 'Ändra uppgifter';
$strings['copy_task'] = 'Kopiera uppgift';
$strings['add_task'] = 'Lägg till uppgift';
$strings['delete_tasks'] = 'Radera uppgift';
$strings['assignment_history'] = 'Delegeringar';
$strings['assigned_on'] = 'Delegerad';
$strings['assigned_by'] = 'Delegerad av';
$strings['to'] = 'Till';
$strings['comment'] = 'Kommentar';
$strings['task_assigned'] = 'Uppgiften delegerad till ';
$strings['task_unassigned'] = 'Uppgiften delegerad till Ingen (Unassigned)';
$strings['edit_multiple_tasks'] = 'Ändra fler uppgifter';
$strings['tasks_selected'] = 'uppgifter valda. Välj nytt värde för dessa uppgifter, eller välj [Inga ändringar] för att behålla gamla värden.';
$strings['assignment_comment'] = 'Kommentar till delegeringen';
$strings['no_change'] = '[Inga ändringar]';
$strings['my_discussions'] = 'Mina diskussioner';
$strings['discussions'] = 'Diskussioner';
$strings['delete_discussions'] = 'Radera diskussioner';
$strings['delete_discussions_note'] = 'Notera: Diskussioner kan inte öppnas på nytt efter att ha blivit raderade.';
$strings['topic'] = 'Ämne';
$strings['posts'] = 'Inlägg';
$strings['latest_post'] = 'Senaste inlägg';
$strings['my_reports'] = 'Mina rapporter';
$strings['reports'] = 'Rapporter';
$strings['create_report'] = 'Skapa rapport';
$strings['report_intro'] = 'Select your task reporting parameters here and save the query on the results page after running your report.';
$strings['admin_intro'] = 'Projektets inställningar och konfiguration.';
$strings['copy_of'] = 'Kopia av ';
$strings['add'] = 'Lägg till';
$strings['delete'] = 'Radera';
$strings['remove'] = 'Ta bort';
$strings['copy'] = 'Kopiera';
$strings['view'] = 'Visa';
$strings['edit'] = 'Ändra';
$strings['update'] = 'Uppdatera';
$strings['details'] = 'Detaljer';
$strings['none'] = 'Ingen';
$strings['close'] = 'Stäng';
$strings['new'] = 'Ny';
$strings['select_all'] = 'Markera allt';
$strings['unassigned'] = 'Ej tilldelad';
$strings['administrator'] = 'Administratör';
$strings['my_projects'] = 'Mina projekt';
$strings['project'] = 'Projekt';
$strings['active'] = 'Aktiva';
$strings['inactive'] = 'Ej aktiv';
$strings['project_id'] = 'Projekt ID';
$strings['edit_project'] = 'Ändra projekt';
$strings['copy_project'] = 'Kopiera projekt';
$strings['add_project'] = 'Lägg till projekt';
$strings['clients'] = 'Kunder';
$strings['organization'] = 'Kundorganisation';
$strings['client_projects'] = 'Kundprojekt';
$strings['client_users'] = 'Kundanvändare';
$strings['edit_organization'] = 'Ändra kundorganisation';
$strings['add_organization'] = 'Lägg till kundorganisation';
$strings['organizations'] = 'Kundorganisationer';
$strings['info'] = 'Information';
$strings['status'] = 'Status';
$strings['owner'] = 'Ägare';
$strings['home'] = 'Hem';
$strings['projects'] = 'Projekt';
$strings['files'] = 'Filer';
$strings['search'] = 'Sök';
$strings['admin'] = 'Admin';
$strings['user'] = 'Användare';
$strings['project_manager'] = 'Projektledare';
$strings['due'] = 'Deadline';
$strings['task'] = 'Uppgift';
$strings['tasks'] = 'Uppgifter';
$strings['team'] = 'Arbetsgrupp';
$strings['add_team'] = 'Lägg till gruppmedlemmar';
$strings['team_members'] = 'Gruppmedlemmar';
$strings['full_name'] = 'Fullständigt namn';
$strings['title'] = 'Titel';
$strings['user_name'] = 'Användarnamn';
$strings['work_phone'] = 'Telefon jobb';
$strings['priority'] = 'Prioritet';
$strings['name'] = 'Namn';
$strings['id'] = 'ID';
$strings['description'] = 'Beskrivning';
$strings['phone'] = 'Telefon';
$strings['url'] = 'URL';
$strings['address'] = 'Adress';
$strings['comments'] = 'Kommentarer';
$strings['created'] = 'Skapat';
$strings['assigned'] = 'Delegerat';
$strings['modified'] = 'Ändrat';
$strings['assigned_to'] = 'Delegerat till';
$strings['due_date'] = 'Deadline datum';
$strings['estimated_time'] = 'Estimerad Tid';
$strings['actual_time'] = 'Verklig tid';
$strings['delete_following'] = 'Radera följande?';
$strings['cancel'] = 'Ångra';
$strings['and'] = 'och';
$strings['administration'] = 'Administration';
$strings['user_management'] = 'Hantera användare';
$strings['system_information'] = 'Systeminformation';
$strings['product_information'] = 'Produktinformation';
$strings['system_properties'] = 'Systemegenskapers';
$strings['create'] = 'Skapa';
$strings['report_save'] = 'Save this report query to your homepage so you can run the query again.';
$strings['report_name'] = 'Rapportens namn';
$strings['save'] = 'Spara';
$strings['matches'] = 'Träffar';
$strings['match'] = 'Träff';
$strings['report_results'] = 'Rapportens resultat';
$strings['success'] = 'Lyckades';
$strings['addition_succeeded'] = 'Inmatningen lyckades';
$strings['deletion_succeeded'] = 'Raderingen lyckades';
$strings['report_created'] = 'Skapad rapport';
$strings['deleted_reports'] = 'Raderade rapporter';
$strings['modification_succeeded'] = 'Ändringen lyckades';
$strings['errors'] = 'Fel uppstod!';
$strings['blank_user'] = 'Användaren kan ej hittas.';
$strings['blank_organization'] = 'Kundorganisationen kan ej hittas.';
$strings['blank_project'] = 'Projektet kan ej hittas.';
$strings['user_profile'] = 'Användarprofil';
$strings['change_password'] = 'Ändra lösenord';
$strings['change_password_user'] = 'Ändra användarens lösenord.';
$strings['old_password_error'] = 'Gamla lösenordet är fel. Vänligen fyll i ditt gamla lösenord på nytt.';
$strings['new_password_error'] = 'De två lösenord du angav stämmer inte överens. Fänligen fyll i ditt nya lösenord på nytt.';
$strings['notifications'] = 'Meddelanden';
$strings['change_password_intro'] = 'Ange ditt gamla lösenord samt ditt nya lösenord med bekräftelse.';
$strings['old_password'] = 'Gammalt lösenord';
$strings['password'] = 'Lösenord';
$strings['new_password'] = 'Nytt lösenord';
$strings['confirm_password'] = 'Bekräfta lösenord';
$strings['email'] = 'E-Post';
$strings['home_phone'] = 'Telefon hem';
$strings['mobile_phone'] = 'Telefon GSM';
$strings['fax'] = 'Fax';
$strings['permissions'] = 'Permissions';
$strings['administrator_permissions'] = 'Administrator Permissions';
$strings['project_manager_permissions'] = 'Project Manager Permissions';
$strings['user_permissions'] = 'User Permissions';
$strings['account_created'] = 'Konto skapades';
$strings['edit_user'] = 'Ändra användare';
$strings['edit_user_details'] = 'Ändra användarkontots detaljer.';
$strings['change_user_password'] = 'Ändra användarens lösenord.';
$strings['select_permissions'] = 'Välj tillträde för denna användare';
$strings['add_user'] = 'Lägg till användare';
$strings['enter_user_details'] = 'Ange detaljer för det konto som du skapar.';
$strings['enter_password'] = 'Ange användarens lösenord.';
$strings['success_logout'] = 'Du har loggat ut. Du kan logga in igen genom att ange användarnamn och lösen nedan.';
$strings['invalid_login'] = 'Användarnamnet och/eller lösenordet är felaktigt. Vänligen försök logga in på nytt.';
$strings['profile'] = 'Profil';
$strings['user_details'] = 'Användarens kontodetaljer.';
$strings['edit_user_account'] = 'Ändra dina kontodetaljer.';
$strings['no_permissions'] = 'Du har inte tillträde till denna funktion.';
$strings['discussion'] = 'Diskussion';
$strings['retired'] = 'Retired';
$strings['last_post'] = 'Senaste inlägg';
$strings['post_reply'] = 'Skriv inlägg';
$strings['posted_by'] = 'Skribent';
$strings['when'] = 'När';
$strings['post_to_discussion'] = 'Skriv inlägg till diskussion';
$strings['message'] = 'Meddelande';
$strings['delete_reports'] = 'Radera rapporter';
$strings['delete_projects'] = 'Radera projekt';
$strings['delete_organizations'] = 'Radera kundorganisationer';
$strings['delete_organizations_note'] = 'Notera: This will delete all client users for these client organizations, and disassociate all open projects from these client organizations.';
$strings['delete_messages'] = 'Radera meddelanden';
$strings['attention'] = 'Observera';
$strings['delete_teamownermix'] = 'Raderingen lyckades, men projektets skapare kan inte raderas från arbetsgruppen.';
$strings['delete_teamowner'] = 'Projektets skapare kan inte raderas från arbetsgruppen.';
$strings['enter_keywords'] = 'Ange nyckelord';
$strings['search_options'] = 'Nyckelord och sökinställningar';
$strings['search_note'] = 'Du måste ange något i sökfältet.';
$strings['search_results'] = 'Sökresultat';
$strings['users'] = 'Användare';
$strings['search_for'] = 'Sök efter';
$strings['results_for_keywords'] = 'Sökresultat med nyckeolrd';
$strings['add_discussion'] = 'Lägg till diskussion';
$strings['delete_users'] = 'Radera användarkonto';
$strings['reassignment_user'] = 'Omdelegering av Projekt och Arbetsuppgifter';
$strings['there'] = 'Det finns';
$strings['owned_by'] = 'ägs av ovanstående användare.';
$strings['reassign_to'] = 'Före radering, omdelegera dessa till';
$strings['no_files'] = 'Inga filer länkade';
$strings['published'] = 'Publicerat';
$strings['project_site'] = 'Publicerad projektsida';
$strings['approval_tracking'] = 'Uppföljning av godkännande';
$strings['size'] = 'Storlek';
$strings['add_project_site'] = 'Lägg till publicerade projektsidan';
$strings['remove_project_site'] = 'Radera från publicerade projektsidan';
$strings['more_search'] = 'Mera sökfunktioner';
$strings['results_with'] = 'Hitta resultat med';
$strings['search_topics'] = 'Sökrubriker';
$strings['search_properties'] = 'Sökfunktioner';
$strings['date_restrictions'] = 'Datumavgränsningar';
$strings['case_sensitive'] = 'Case Sensitive';
$strings['yes'] = 'Ja';
$strings['no'] = 'Nej';
$strings['sort_by'] = 'Sortera efter';
$strings['type'] = 'Typ';
$strings['date'] = 'Datum';
$strings['all_words'] = 'alla ord';
$strings['any_words'] = 'något av orden';
$strings['exact_match'] = 'exakt träff';
$strings['all_dates'] = 'Alla datum';
$strings['between_dates'] = 'Mellan följande datum';
$strings['all_content'] = 'Allt innehåll';
$strings['all_properties'] = 'Alla egenskaper';
$strings['no_results_search'] = 'Sökningen gav inga träffar.';
$strings['no_results_report'] = 'Rapporten gav inga träffar.';
$strings['schema_date'] = 'YYYY/MM/DD';
$strings['hours'] = 'timmar';
$strings['choice'] = 'Val';
$strings['missing_file'] = 'Fil saknas !';
$strings['project_site_deleted'] = 'Publicerade projektsidan raderades.';
$strings['add_user_project_site'] = 'Användaren har fått tillgång till den publicerade projektsidan.';
$strings['remove_user_project_site'] = 'Avnändarens tillträde har fråntagits.';
$strings['add_project_site_success'] = 'Tillägget till den publicerade projektsidan har lyckats.';
$strings['remove_project_site_success'] = 'Raderingen från den publicerade projektsidan har lyckats.';
$strings['add_file_success'] = '1 fil har lagts till.';
$strings['delete_file_success'] = 'Filen har raderats.';
$strings['update_comment_file'] = 'Kommentar till materialet har lagts till.';
$strings['session_false'] = 'Sessionsfel';
$strings['logs'] = 'Loggar';
$strings['logout_time'] = 'Automatisk Logout';
$strings['noti_foot1'] = 'Detta meddelande genererades av NetOffice.';
$strings['noti_foot2'] = 'Gå till NetOffice, besök:';
$strings['noti_taskassignment1'] = 'Ny arbetsuppgift:';
$strings['noti_taskassignment2'] = 'Du har blivit delegerad en arbetsuppgift:';
$strings['noti_moreinfo'] = 'För ytterligare information, gå till:';
$strings['noti_prioritytaskchange1'] = 'Prioritetsändring av arbete:';
$strings['noti_prioritytaskchange2'] = 'Prioriteten på följande arbetsuppgift har ändrats:';
$strings['noti_statustaskchange1'] = 'Arbetsuppgiftens status har ändrats:';
$strings['noti_statustaskchange2'] = 'Status på följande arbetsuppgift har ändrats:';
$strings['login_username'] = 'Du måste ange ett användarnamn.';
$strings['login_password'] = 'Vänligen ange lösenord.';
$strings['login_clientuser'] = 'Detta är ett kundkonto. Du kan inte logga in till NetOffice med ett kundkonto.';
$strings['user_already_exists'] = 'Detta användarnamn finns redan. Vänligen välj ett annat användarnamn.';
$strings['noti_duedatetaskchange1'] = 'Arbetsuppgiftens deadline har ändrats:';
$strings['noti_duedatetaskchange2'] = 'Följande arbetsuppgift har en ny deadline:';
$strings['company'] = 'FÖretag';
$strings['show_all'] = 'Visa alla';
$strings['information'] = 'Information';
$strings['delete_message'] = 'Radera detta meddelande';
$strings['project_team'] = 'Arbetsgrupp';
$strings['document_list'] = 'Lista över dokument';
$strings['bulletin_board'] = 'Anslagstavla';
$strings['bulletin_board_topic'] = 'Anslagstavlerubrik';
$strings['create_topic'] = 'Skapa en ny rubrik';
$strings['topic_form'] = 'Rubrikformulär';
$strings['enter_message'] = 'Skriv ditt meddelande';
$strings['upload_file'] = 'Ladda upp en fil';
$strings['upload_form'] = 'Uppladdningsformulär';
$strings['upload'] = 'Ladda upp';
$strings['document'] = 'Dokument';
$strings['approval_comments'] = 'Kommentarer till godkännande';
$strings['client_tasks'] = 'Kundens arbetsuppgifter';
$strings['team_tasks'] = 'Arbetsgruppens uppgifter';
$strings['team_member_details'] = 'Detaljer om arbetsgruppens medlem';
$strings['client_task_details'] = 'Detaljer om kundens arbetsuppgift';
$strings['team_task_details'] = 'Detaljer om arbetsgruppens uppgifter';
$strings['language'] = 'Språk';
$strings['welcome'] = 'Välkommen';
$strings['your_projectsite'] = 'till din publicerade projektsida';
$strings['contact_projectsite'] = 'Om du har frågor angående detta extranet eller den information som här finns, vänligen kontakta projektledaren';
$strings['company_details'] = 'Företagets uppgifter';
$strings['database'] = 'Säkerhetskopiera eller återställ databasen';
$strings['company_info'] = 'Ändra företagsinfo';
$strings['create_projectsite'] = 'Skapa publicerad projektsida';
$strings['projectsite_url'] = 'Projektsidans URL';
$strings['design_template'] = 'Malldesign';
$strings['preview_design_template'] = 'Förhandsgranska malldesignen';
$strings['delete_projectsite'] = 'Radera den publicerade projektsidan';
$strings['add_file'] = 'Lägg till fil';
$strings['linked_content'] = 'Länkat material';
$strings['edit_file'] = 'Ändra filens detaljer';
$strings['permitted_client'] = 'Tillåtna kundanvändare';
$strings['grant_client'] = 'Ge tillåtelse att se publicerade projektsidan';
$strings['add_client_user'] = 'Lägg till kundanvändare';
$strings['edit_client_user'] = 'Ändra kundanvändare';
$strings['client_user'] = 'Kundanvändare';
$strings['client_change_status'] = 'Ändra ditt status nedan när uppgiften är utförd';
$strings['project_status'] = 'Projektets status';
$strings['view_projectsite'] = 'Visa publicerade projektsidan';
$strings['enter_login'] = 'Skriv in ditt användarnamn för att få ett nytt lösenord';
$strings['send'] = 'Skicka';
$strings['no_login'] = 'Användarnamnet fanns inte i databasen';
$strings['email_pwd'] = 'Lösenordet skickades';
$strings['no_email'] = 'Användare utan epostkonto';
$strings['forgot_pwd'] = 'Glömt ditt lösenord?';
$strings['project_owner'] = 'Du kan endast göra ändringar i egna projekt.';
$strings['connected'] = 'Inloggad';
$strings['session'] = 'Session';
$strings['last_visit'] = 'Senaste besök';
$strings['compteur'] = 'Antal';
$strings['ip'] = 'Ip';
$strings['task_owner'] = 'Du är inte medlem i arbetsgruppen för detta projekt';
$strings['export'] = 'Exportera';
$strings['browse_cvs'] = 'Browse CVS';
$strings['repository'] = 'CVS Repository';
$strings['reassignment_clientuser'] = 'Omdelegering av arbetsuppgift';
$strings['organization_already_exists'] = 'Namnet är redan i bruk. Vänligen välj ett annat namn.';
$strings['blank_organization_field'] = 'Du måste ange kundorganisationens namn.';
$strings['blank_fields'] = 'obligatoriska fält';
$strings['projectsite_login_fails'] = 'Användarnamn och lösenord finns inte.';
$strings['start_date'] = 'Startdatum';
$strings['completion'] = 'Klart';
$strings['update_available'] = 'En uppdatering finns!';
$strings['version_current'] = 'Du använder nu version';
$strings['version_latest'] = 'Senaste version är';
$strings['sourceforge_link'] = 'Gå till projektets hemsida på sourceforge';
$strings['demo_mode'] = 'Demo. Åtgärd ej tillåten.';
$strings['setup_erase'] = 'Radera filen setup.php!!';
$strings['no_file'] = 'Inga filer valda';
$strings['exceed_size'] = 'Överskred maximalt tillåtna filstorlek';
$strings['no_php'] = 'Php-filer ej tillåtna';
$strings['approval_date'] = 'Datum för godkännande';
$strings['approver'] = 'Godkänt av';
$strings['error_database'] = 'Kan ej ansluta till databasen';
$strings['error_server'] = 'Kan ej ansluta till server';
$strings['version_control'] = 'Versionkontroll';
$strings['vc_status'] = 'Status';
$strings['vc_last_in'] = 'Senast ändrad';
$strings['ifa_comments'] = 'Kommentar till godkännande';
$strings['ifa_command'] = 'Ändra status för godkännande';
$strings['vc_version'] = 'Version';
$strings['ifc_revisions'] = 'Inbördes utvärderingar';
$strings['ifc_revision_of'] = 'Utvärdering av version';
$strings['ifc_add_revision'] = 'Lägg till en inbördes utvärdering';
$strings['ifc_update_file'] = 'Uppdatera filen';
$strings['ifc_last_date'] = 'Senaste korrigeringsdatum';
$strings['ifc_version_history'] = 'Historia';
$strings['ifc_delete_file'] = 'Delete file and all child versions & reviews';
$strings['ifc_delete_version'] = 'Radera merkerad version';
$strings['ifc_delete_review'] = 'Radera markerad utvärdering';
$strings['ifc_no_revisions'] = 'Det finns inga omarbetade versioner av detta dokument';
$strings['unlink_files'] = 'Avlänka filer';
$strings['remove_team'] = 'Ta bort gruppmedlemmar';
$strings['remove_team_info'] = 'Ta bort följande personer från arbetsgruppen?';
$strings['remove_team_client'] = 'Ta bort tillträde till den publicerade projektsidan';
$strings['note'] = 'Anteckning';
$strings['notes'] = 'Anteckningar';
$strings['subject'] = 'Rubrik';
$strings['delete_note'] = 'Radera anteckningar';
$strings['add_note'] = 'Lägg till anteckning';
$strings['edit_note'] = 'Ändra anteckning';
$strings['version_increm'] = 'Select the version change to apply:';
$strings['url_dev'] = 'Url under utvecklingen';
$strings['url_prod'] = 'Slutlig url';
$strings['note_owner'] = 'Du kan endast ändra egna anteckningar.';
$strings['alpha_only'] = 'Endast alfanumerisk login tillåts';
$strings['edit_notifications'] = 'Ändra e-postmeddelanden';
$strings['edit_notifications_info'] = 'Välj vilka händelser du vill bli underrättad om per epost.';
$strings['select_deselect'] = 'Markera/Avmarkera allt';
$strings['noti_addprojectteam1'] = 'Medlem i arbetsgrupp :';
$strings['noti_addprojectteam2'] = 'Du har lagts till i följande arbetsgrupp :';
$strings['noti_removeprojectteam1'] = 'Borttagen ur arbetsgrupp :';
$strings['noti_removeprojectteam2'] = 'Du har tagits bort ur följande arbetsgrupp :';
$strings['noti_newpost1'] = 'Nytt inlägg :';
$strings['noti_newpost2'] = 'Ett inlägg har lagts till i följande diskussion :';
$strings['edit_noti_taskassignment'] = 'Jag är delegerad en ny arbetsuppgift.';
$strings['edit_noti_statustaskchange'] = 'En av mina uppgifters status ändras.';
$strings['edit_noti_prioritytaskchange'] = 'Prioriteringsändring till en av mina uppgifter.';
$strings['edit_noti_duedatetaskchange'] = 'Ändringar i deadline för mina uppgifter.';
$strings['edit_noti_addprojectteam'] = 'Jag läggs till i en arbetsgrupp.';
$strings['edit_noti_removeprojectteam'] = 'Jag tas bort ur en arbetsgrupp.';
$strings['edit_noti_newpost'] = 'Ett nytt inlägg läggs till en diskussion.';
$strings['add_optional'] = 'Lägg till en valfri';
$strings['assignment_comment_info'] = 'Kommentera delegeringen av denna uppgift';
$strings['my_notes'] = 'Mina anteckningar';
$strings['edit_settings'] = 'Ändra inställningar';
$strings['max_upload'] = 'Max filstorlek';
$strings['project_folder_size'] = 'Projektets mappstorlek';
$strings['calendar'] = 'Kalender';
$strings['date_start'] = 'Startdatum';
$strings['date_end'] = 'Slutdatum';
$strings['time_start'] = 'Starttid';
$strings['time_end'] = 'Sluttid';
$strings['calendar_reminder'] = 'Påminnelse';
$strings['shortname'] = 'Kort namn';
$strings['calendar_recurring'] = 'Händelsen upprepas varje vecka.';
$strings['edit_database'] = 'Ändra databasen';
$strings['noti_newtopic1'] = 'Ny diskussion :';
$strings['noti_newtopic2'] = 'En ny diskussion har lagts till följande projekt :';
$strings['edit_noti_newtopic'] = 'Ny diskussionsrubrik.';
$strings['today'] = 'Idag';
$strings['previous'] = 'Föregående';
$strings['next'] = 'Nästa';
$strings['help'] = 'Hjälp';
$strings['complete_date'] = 'Fullständigt datum';
$strings['scope_creep'] = 'Scope creep';
$strings['days'] = 'Dagar';
$strings['logo'] = 'Logo';
$strings['remember_password'] = 'Kom ihåg lösenord';
$strings['client_add_task_note'] = 'Notera: Den inmatade uppgiften registerades i database, men syns bara om den är knuten till en medlem i arbetsgruppen!';
$strings['noti_clientaddtask1'] = 'Arbetsuppgift från kund :';
$strings['noti_clientaddtask2'] = 'En ny uppgift har lagts till av en kundanvändare från publicerade projektsidan :';
$strings['phase'] = 'Fas';
$strings['phases'] = 'Faser';
$strings['phase_id'] = 'Fas ID';
$strings['current_phase'] = 'Pågående fas(er)';
$strings['total_tasks'] = 'Alla arbetsuppgifter';
$strings['uncomplete_tasks'] = 'Ofärdiga uppgifter';
$strings['no_current_phase'] = 'Ingen fas pågår just nu';
$strings['true'] = 'Sant';
$strings['false'] = 'Falskt';
$strings['enable_phases'] = 'Använd faser';
$strings['phase_enabled'] = 'Faser används';
$strings['order'] = 'Beställning';
$strings['options'] = 'Egenskaper';
$strings['support'] = 'Support';
$strings['support_request'] = 'Support förfrågan';
$strings['support_requests'] = 'Support förfrågningar';
$strings['support_id'] = 'Förfrågan ID';
$strings['my_support_request'] = 'Mina supportförfrågningar';
$strings['introduction'] = 'Instroduktion';
$strings['submit'] = 'Skicka';
$strings['support_management'] = 'Supportledning';
$strings['date_open'] = 'Öppningsdatum';
$strings['date_close'] = 'Stängningsdatum';
$strings['add_support_request'] = 'Lägg till supportförfrågan';
$strings['add_support_response'] = 'Lägg till supportsvar';
$strings['respond'] = 'Svara';
$strings['delete_support_request'] = 'Supportförfrågan raderad';
$strings['delete_request'] = 'Radera supportförfrågan';
$strings['delete_support_post'] = 'Radera supportsvar';
$strings['new_requests'] = 'Nya förfrågningar';
$strings['open_requests'] = 'Öppna förfrågningar';
$strings['closed_requests'] = 'Avslutade förfrågningar';
$strings['manage_new_requests'] = 'Hantera nya förfrågningar';
$strings['manage_open_requests'] = 'Hantera öppna förfrågningar';
$strings['manage_closed_requests'] = 'Hantera avslutade förfrågningar';
$strings['responses'] = 'Svar';
$strings['edit_status'] = 'Ändra status';
$strings['noti_support_request_new2'] = 'Du har skickat en supportförfrågning angående: ';
$strings['noti_support_post2'] = 'Ett svar har lagts till din supportförfrågan. Vänligen se nedanstående detaljer.';
$strings['noti_support_status2'] = 'Din supportförfrågan har uppdaterats. Vänligen se nedanstående detaljer.';
$strings['noti_support_team_new2'] = 'En ny supportförfrågan har lagts till projektet : ';
//2.0
$strings['delete_subtasks'] = 'Ta bort underuppgift';
$strings['add_subtask'] = 'Lägg till underuppgift';
$strings['edit_subtask'] = 'Ändra underuppgift';
$strings['subtask'] = 'Underuppgift';
$strings['subtasks'] = 'Underuppgifter';
$strings['show_details'] = 'Visa detaljer';
$strings['updates_task'] = 'Logg över uppgiftsuppdateringar';
$strings['updates_subtask'] = 'Logg över underuppgiftsuppdateringar';
//2.1
$strings['go_projects_site'] = 'Gå till projektplatsen';
$strings['bookmark'] = 'Bokmärke';
$strings['bookmarks'] = 'Bokmärken';
$strings['bookmark_category'] = 'Kategori';
$strings['bookmark_category_new'] = 'Ny kategori';
$strings['bookmarks_all'] = 'Alla';
$strings['bookmarks_my'] = 'Mina bokmärken';
$strings['my'] = 'Mina';
$strings['bookmarks_private'] = 'Privat';
$strings['shared'] = 'Utdelad';
$strings['private'] = 'Privat';
$strings['add_bookmark'] = 'Lägg till bokmärke';
$strings['edit_bookmark'] = 'Ändra bokmärken';
$strings['delete_bookmarks'] = 'Ta bort bokmärken';
$strings['team_subtask_details'] = 'Underuppgiftsdetaljer (grupp)';
$strings['client_subtask_details'] = 'Underuppgiftsdetaljer (kund)';
$strings['client_change_status_subtask'] = 'Ändra din status nedan när du har avklarad denna underuppgift';
$strings['disabled_permissions'] = 'Avstängt konto';
$strings['user_timezone'] = 'Tidszon (GMT)';
//2.2
$strings['project_manager_administrator_permissions'] = 'Projektledar administratör';
$strings['bug'] = 'Feluppföljning';
//2.3
$strings['report'] = 'Rapport';
$strings['license'] = 'Licens';
//2.4
$strings['settings_notwritable'] = 'Kan inte skriva till Settings.php';
//2.5
$strings['name_print'] = 'Utskrivet namn';
$strings['calculation'] = 'Kalkylering';
$strings['items'] = 'Artiklar';
$strings['position'] = 'Position';
$strings['completed'] = 'Avklarat';
$strings['service'] = 'Kundtjänst';
$strings['service_management'] = 'Kundtjänst administration';
$strings['hourly_rate'] = 'Timlön';
$strings['add_service'] = 'Lägg till kundtjänst';
$strings['edit_service'] = 'Ändra kundtjänst';
$strings['delete_services'] = 'Ta bort kundtjänster';
$strings['worked_hours'] = 'Antal arbetstimmar';
$strings["loghours"] = 'Tidsbokföring';
$strings["logtime"] = 'Tidpunkt';
$strings["loggedby"] = 'Skrivet av';
$strings["error_required"] = 'är obligatoriskt';
$strings["error_numerical"] = 'måste vara numeriskt';
$strings["hours_updated"] = 'Uppgiftstimmar uppdaterade';
$strings['add_task_time'] = 'Lägg till uppgiftstid';
$strings['edit_task_time'] = 'Ändra uppgiftstid';
$strings['delete_task_time'] = 'Ta bort uppgiftstid';
$strings['task_time'] = 'Uppgiftstid';
//2.5.1
$strings["email_users"] = "Skicka E-post till användare";
$strings["email_following"] = "Skicka E-post till följande";
$strings["email_sent"] = "E-post meddelande sänt.";
$strings['all'] = 'Alla';
$strings['custom_reports'] = 'Specialrapporter';
$strings['custom_report_intro'] = 'Välj den rapport som passar bäst baserat på deras beskrivningar.';
$strings['completed_task_report'] = 'Avklarade uppgifter';
$strings['completed_task_report_desc'] = 'Denna rapport visar alla avklarade arbetsuppgifter under föregående månad.';
$strings['time_report'] = 'Tidsrapport';
$strings['time_report_desc'] = 'Denna rapport visar alla arbetstimmar som angetts per användare för varje projekt under föregående månad samt ger dig möjlighet att exportera informationen.';
$strings['overdue_tasks'] = 'Försenade uppgifter';
$strings['overdue_tasks_desc'] = 'Denna rapport listar alla försenade uppgifter inom alla projekt.';
$strings['project_snapshot'] = 'Projektöversikt';
$strings['project_snapshot_desc'] = 'Denna rapport ger den inloggade användaren en överblick över projektet och de tillhörande uppgifterna.';
$strings['pending_tasks'] = 'Väntande uppgifter';
$strings['pending_tasks_desc'] = 'Denna rapport ger en överblick över de arbetsuppgifter som är införda för alla projekt.';
$strings['pm_report'] = 'PM Rapport';
$strings['pm_report_desc'] = 'Denna rapport visar de projekt som är tilldelade enligt tillgång och de som ännu inte är tilldelade.';
$strings['project_phasestatus'] = 'Projektets fas';
$strings['project_phasestatus_desc'] = 'Visa enkel översikt över alla aktiva projekt och deras faser';
$strings['resource_usage_detail'] = 'Denna rapport summerar den totala tiden som angetts för alla projekt och organisationer.';
//2.5.2
$strings['install_erase'] = 'Ta bort katalogen installation och dess innehåll!!';
$strings['error_phpversion'] = 'NetOffice kräver PHP version 4.1.0 eller nyare!';
?>