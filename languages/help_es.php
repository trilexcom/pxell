<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: help_es.php,v 1.1.1.1 2004/11/02 03:30:22 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s):
$help["setup_mkdirMethod"] = "Si safe-mode esta activado, usted necesita crear una cuenta FTP que esté autorizada para crear carpetas con administración de archivos.";
$help["setup_notifications"] = "Notificaciones vía correo electrónico (Asignación de tareas, nuevos temas, cambios en tareas...)<br>Se requiere smtp/sendmail valido.";
$help["setup_forcedlogin"] = "Si es falso, deshabilita que se autorice la entrada desde un url que contenga el login/password incluido.";
$help["setup_langdefault"] = "Escoja el idioma que se seleccionará como predeterminado en el momento de logearse, o deje en blanco para que sea autodetectado por el navegador.";
$help["setup_myprefix"] = "Ingrese este valor si usted tiene tablas en la base de datos con el mismo nombre.<br><br>assignments<br>bookmarks<br>bookmarks_categories<br>calendar<br>files<br>logs<br>members<br>notes<br>notifications<br>organizations<br>phases<br>posts<br>projects<br>reports<br>sorting<br>subtasks<br>support_posts<br>support_requests<br>tasks<br>teams<br>topics<br>updates<br><br>Deje en blanco si no quiere utilizar un prefijo.";
$help["setup_loginmethod"] = "Método para almacenar passwords en la base de datos.<br>Seleccione &quot;Crypt&quot; si quiere que la autenticación por el método CVS y htaccess funcionen (Si autenticación y/o htaccess están activados).";
$help["admin_update"] = "Respetar estrictamente el orden indicado para actualizar su versión<br>1. Edite sus preferencias (sustituya con los nuevos parámetros)<br>2. Edite la base de datos (actualice de acuerdo con su versión anterior)";
$help["task_scope_creep"] = "Diferencia en días entre los la fecha de entrega y la fecha de completada (Negrilla si es positiva)";
$help["max_file_size"] = "Máximo peso de un archivo permitido para ser publicado";
$help["project_disk_space"] = "Peso total de los archivos publicados en el proyecto";
$help["project_scope_creep"] = "Diferencia en días entre los la fecha de entrega y la fecha de completada (Negrilla si es positiva). Total para todas las tareas.";
$help["mycompany_logo"] = "Publique el logo de su compañía. Aparece en el encabezado, en vez de el título en texto";
$help["calendar_shortname"] = "Título que aparece en la vista del calendario mensual. Obligatorio";
$help["user_autologout"] = "Tiempo, en segundos para ser desconetado del sistema si no hay actividad (Time Out). 0 para desactivar esta opción.";
$help["user_timezone"] = "Seleccione su zona de tiempo global (GMT)";
// 2.4
$help["setup_clientsfilter"] = "Filter to see only logged user clients";
$help["setup_projectsfilter"] = "Filter to see only the project when the user are in the team";
// 2.5
$help["setup_notificationMethod"] = "Set method to send email notifications: with internal php mail function (need for having a smtp server or sendmail configured in the parameters of php) or with a personalized smtp server";

?>
