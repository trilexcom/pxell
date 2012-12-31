<?php // $Revision: 1.1.1.1 $
/* vim: set expandtab ts=4 sw=4 sts=4: */

/**
 * $Id: lang_pt-br.php,v 1.1.1.1 2004/11/02 03:30:23 madbear Exp $
 * 
 * Copyright (c) 2003 by the NetOffice developers
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */
// translator(s): Felipe Fonseca <http://hipercortex.tk>
$setCharset = "ISO-8859-1";

$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$dayNameArray = array(1 => "Segunda", 2 => "Ter�a", 3 => "Quarta", 4 => "Quinta", 5 => "Sexta", 6 => "S�bado", 7 => "Domingo");

$monthNameArray = array(1 => "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

$status = array(0 => "Finalizado pelo Cliente", 1 => "Finalizado", 2 => "N�o Iniciado", 3 => "Aberto", 4 => "Suspenso");

$profil = array(0 => "Administrador", 1 => "Gerente do Projeto", 2 => "Usu�rio", 3 => "Usu�rio do Cliente", 4 => "Disabled", 5 => "Project Manager Administrator");

$priority = array(0 => "Nenhuma", 1 => "Muito Baixa", 2 => "Baixa", 3 => "M�dia", 4 => "Alta", 5 => "M�xima");

$statusTopic = array(0 => "Fechado", 1 => "Aberto");
$statusTopicBis = array(0 => "Sim", 1 => "N�o");

$statusPublish = array(0 => "Sim", 1 => "N�o");

$statusFile = array(0 => "Aprovado", 1 => "Aprovado com altera��es", 2 => "Necessita Aprova��o", 3 => "N�o necessita aprova��o", 4 => "N�o Aprovado");

$phaseStatus = array(0 => "N�o iniciada", 1 => "Aberta", 2 => "Completa", 3 => "Suspensa");

$requestStatus = array(0 => "Novo", 1 => "Aberto", 2 => "Completo");

$strings["please_login"] = "Por favor identifique-se";
$strings["requirements"] = "Requisitos do Sistema";
$strings["license"] = "Licen�a";
$strings["login"] = "Identifica��o";
$strings["no_items"] = "N�o h� itens para mostrar";
$strings["logout"] = "Sair";
$strings["preferences"] = "Prefer�ncias";
$strings["my_tasks"] = "Minhas Tarefas";
$strings["edit_task"] = "Editar Tarefas";
$strings["copy_task"] = "Copiar Tarefas";
$strings["add_task"] = "Adicionar Tarefas";
$strings["delete_tasks"] = "Apagar Tarefas";
$strings["assignment_history"] = "Hist�rico de Delega��es";
$strings["assigned_on"] = "Delegado Em";
$strings["assigned_by"] = "Delegado Por";
$strings["to"] = "Para";
$strings["comment"] = "Coment�rio";
$strings["task_assigned"] = "Tarefa delegada a ";
$strings["task_unassigned"] = "Tarefa n�o delegada";
$strings["edit_multiple_tasks"] = "Editar M�ltiplas Tarefas";
$strings["tasks_selected"] = "tarefas selecionadas. Escolher novos valores para estas tarefas, ou selecionar [Sem Altera��es] para reter valores atuais.";
$strings["assignment_comment"] = "Coment�rio da delega��o";
$strings["no_change"] = "[Sem Altera��es]";
$strings["my_discussions"] = "Meus Debates";
$strings["discussions"] = "Debates";
$strings["delete_discussions"] = "Apagar Debates";
$strings["delete_discussions_note"] = "Nota: Debates n�o podem ser reabertos, uma vez apagados.";
$strings["topic"] = "T�pico";
$strings["posts"] = "envios";
$strings["latest_post"] = "�ltimo item enviado";
$strings["my_reports"] = "Meus Relat�rios";
$strings["reports"] = "Relat�rios";
$strings["create_report"] = "Criar Relat�rio";
$strings["report_intro"] = "Selecione os par�metros da sua tarefa aqui e guarde a pesquisa na p�gina de resultados depois de executar o seu relat�rio.";
$strings["admin_intro"] = "Configura��o e par�metros do Projeto.";
$strings["copy_of"] = "Copia de ";
$strings["add"] = "Adicionar";
$strings["delete"] = "Apagar";
$strings["remove"] = "Remover";
$strings["copy"] = "Copiar";
$strings["view"] = "Ver";
$strings["edit"] = "Editar";
$strings["update"] = "Atualizar";
$strings["details"] = "Detalhes";
$strings["none"] = "Nenhuma";
$strings["close"] = "Fechar";
$strings["new"] = "Nova";
$strings["select_all"] = "Selecionar Todos";
$strings["unassigned"] = "N�o Delegada";
$strings["administrator"] = "Administrador";
$strings["my_projects"] = "Meus Projetos";
$strings["project"] = "Projeto";
$strings["active"] = "Ativo";
$strings["inactive"] = "Inativo";
$strings["project_id"] = "ID Projeto";
$strings["edit_project"] = "Editar Projeto";
$strings["copy_project"] = "Copiar Projeto";
$strings["add_project"] = "Adicionar Projeto";
$strings["clients"] = "Clientes";
$strings["organization"] = "Organiza��o Cliente";
$strings["client_projects"] = "Projetos do Cliente";
$strings["client_users"] = "Usu�rios do Cliente";
$strings["edit_organization"] = "Editar Organiza��o Cliente";
$strings["add_organization"] = "Adicionar Organiza��o Cliente";
$strings["organizations"] = "Organiza��es Cliente";
$strings["info"] = "Info";
$strings["status"] = "Estado";
$strings["owner"] = "Dono";
$strings["home"] = "In�cio";
$strings["projects"] = "Projetos";
$strings["files"] = "Arquivos";
$strings["search"] = "Procurar";
$strings["admin"] = "Administra��o";
$strings["user"] = "Usu�rio";
$strings["project_manager"] = "Gerente do Projeto";
$strings["due"] = "Finalizado";
$strings["task"] = "Tarefa";
$strings["tasks"] = "Tarefas";
$strings["team"] = "Equipe";
$strings["add_team"] = "Adicionar Membros de Equipe";
$strings["team_members"] = "Membros de Equipe";
$strings["full_name"] = "Nome Completo";
$strings["title"] = "T�tulo";
$strings["user_name"] = "Nome de Usu�rio";
$strings["work_phone"] = "Telefone Trabalho";
$strings["priority"] = "Prioridade";
$strings["name"] = "Nome";
$strings["id"] = "ID";
$strings["description"] = "Descri��o";
$strings["phone"] = "Telefone";
$strings["url"] = "URL";
$strings["address"] = "Endere�o";
$strings["comments"] = "Coment�rios";
$strings["created"] = "Criado";
$strings["assigned"] = "Delegado";
$strings["modified"] = "Modificado";
$strings["assigned_to"] = "Delegado a";
$strings["due_date"] = "Data de Finaliza��o";
$strings["estimated_time"] = "Tempo Estimado";
$strings["atual_time"] = "Tempo Real";
$strings["delete_following"] = "Apagar o seguinte?";
$strings["cancel"] = "Cancelar";
$strings["and"] = "e";
$strings["administration"] = "Administra��o";
$strings["user_management"] = "Gerenciamento Usu�rio";
$strings["system_information"] = "Informa��o Sistema";
$strings["product_information"] = "Informa��o Produto";
$strings["system_properties"] = "Propriedades Sistema";
$strings["create"] = "Criar";
$strings["report_save"] = "Guarde este relat�rio na sua homepage para voltar a utiliz�-lo.";
$strings["report_name"] = "Nome Relat�rio";
$strings["save"] = "Salvar";
$strings["matches"] = "Iguais";
$strings["match"] = "Igual";
$strings["report_results"] = "Resultados Relat�rio";
$strings["success"] = "Sucesso";
$strings["addition_succeeded"] = "Adicionado com sucesso";
$strings["deletion_succeeded"] = "Apagado com sucesso";
$strings["report_created"] = "Criado relat�rio";
$strings["deleted_reports"] = "Relat�rios Apagados";
$strings["modification_succeeded"] = "Modifica��es feitas";
$strings["errors"] = "Erros encontrados!";
$strings["blank_user"] = "O usu�rio n�o p�de ser encontrado.";
$strings["blank_organization"] = "O organiza��o do cliente n�o p�de ser localizada.";
$strings["blank_project"] = "O projeto n�o p�de ser localizado.";
$strings["user_profile"] = "Perfil Usu�rio";
$strings["change_password"] = "Mudar Senha";
$strings["change_password_user"] = "Mudar a senha do usu�rio.";
$strings["old_password_error"] = "A senha antiga digitada est� incorreta. Por favor insira novamente a senha antiga.";
$strings["new_password_error"] = "As duas senhas digitadas n�o s�o iguais. Por favor insira novamente a sua nova senha.";
$strings["notifications"] = "Notifica��es";
$strings["change_password_intro"] = "Insira a sua antiga senha e depois insira e confirme a sua nova senha.";
$strings["old_password"] = "Antiga Senha";
$strings["password"] = "Senha";
$strings["new_password"] = "Nova Senha";
$strings["confirm_password"] = "Confirme Senha";
$strings["email"] = "E-Mail";
$strings["home_phone"] = "Telefone Casa";
$strings["mobile_phone"] = "Telefone Celular";
$strings["fax"] = "Fax";
$strings["permissions"] = "Permiss�es";
$strings["administrator_permissions"] = "Permiss�es de Administrador";
$strings["project_manager_permissions"] = "Permiss�es Gestor de Projeto";
$strings["user_permissions"] = "Permiss�es de Usu�rio";
$strings["account_created"] = "Conta Criada";
$strings["edit_user"] = "Editar Usu�rio";
$strings["edit_user_details"] = "Editar os detalhes do usu�rio.";
$strings["change_user_password"] = "Mudar a senha do usu�rio.";
$strings["select_permissions"] = "Selecionar permiss�es para este usu�rio";
$strings["add_user"] = "Adicionar Usu�rio";
$strings["enter_user_details"] = "Introduzir detalhes para a conta do usu�rio.";
$strings["enter_password"] = "Introduza a senha do usu�rio.";
$strings["success_logout"] = "Saiu com sucesso. Pode voltar a entrar introduzindo o nome de usu�rio e a senha em baixo.";
$strings["invalid_login"] = "O nome de usu�rio e/ou senha digitados s�o inv�lidos. Por favor insira novamente os seus dados.";
$strings["profile"] = "Perfil";
$strings["user_details"] = "Detalhes da Conta de Usu�rio.";
$strings["edit_user_account"] = "Edite a informa��o da sua conta.";
$strings["no_permissions"] = "Voc� n�o tem permiss�o para realizar esta opera��o.";
$strings["discussion"] = "Debate";
$strings["retired"] = "Reformado";
$strings["last_post"] = "�ltima mensagem";
$strings["post_reply"] = "Resposta � mensagem";
$strings["posted_by"] = "Mensagem enviada por";
$strings["when"] = "Quando";
$strings["post_to_discussion"] = "Enviar para debate";
$strings["message"] = "Mensagem";
$strings["delete_reports"] = "Apagar Relat�rios";
$strings["delete_projects"] = "apagar Projetos";
$strings["delete_organizations"] = "Apagar Organiza��es Cliente";
$strings["delete_organizations_note"] = "Nota: Isto vai apagar todos os usu�rios de clientes para estas organiza��es de clientes, e dissociar todos os projetos abertos para estas organiza��es clientes.";
$strings["delete_messages"] = "Apagar Mensagens";
$strings["attention"] = "Aten��o";
$strings["delete_teamownermix"] = "Removido com sucesso, mas o dono do projeto n�o pode ser removido da equipe do projeto.";
$strings["delete_teamowner"] = "Voc� n�o pode remover o dono do projeto de equipe do projeto.";
$strings["enter_keywords"] = "Introduza as palavras-chave";
$strings["search_options"] = "Palavras-chave e Op��es de Busca";
$strings["search_note"] = "Voc� tem de introduzir a informa��o no campo de Procura Por.";
$strings["search_results"] = "Resultados da Procura";
$strings["users"] = "Usu�rios";
$strings["search_for"] = "Procura Por";
$strings["results_for_keywords"] = "Resultados de Procura por Palavras-Chave";
$strings["add_discussion"] = "Adicionar Debate";
$strings["delete_users"] = "Apagar Conta de usu�rio";
$strings["reassignment_user"] = "Redelega��o de Projeto e Tarefas";
$strings["there"] = "Existem";
$strings["owned_by"] = "Pertencem aos usu�rios acima.";
$strings["reassign_to"] = "Antes de apagar usu�rios, redelegar estas a";
$strings["no_files"] = "Sem arquivos relacionados";
$strings["published"] = "Publicado";
$strings["project_site"] = "Site do Projeto";
$strings["approval_tracking"] = "Hist�rico de Aprova��es";
$strings["size"] = "Tamanho";
$strings["add_project_site"] = "Adicionar ao Site do Projeto";
$strings["remove_project_site"] = "Remover do Site do Projeto";
$strings["more_search"] = "Mais op��es de Procura";
$strings["results_with"] = "Procurar Resultados Com";
$strings["search_topics"] = "T�picos de Procura";
$strings["search_properties"] = "Propriedades de Procura";
$strings["date_restrictions"] = "Restri��es de Datas";
$strings["case_sensitive"] = "Sens�vel � caixa";
$strings["yes"] = "Sim";
$strings["no"] = "N�o";
$strings["sort_by"] = "Organizar Por";
$strings["type"] = "Tipo";
$strings["date"] = "Data";
$strings["all_words"] = "todas as palavras";
$strings["any_words"] = "qualquer das palavras";
$strings["exact_match"] = "exatamente igual";
$strings["all_dates"] = "Todas as datas";
$strings["between_dates"] = "Entre as datas";
$strings["all_content"] = "Todo o conte�do";
$strings["all_properties"] = "Todas as propriedades";
$strings["no_results_search"] = "A procura n�o obteve resultados.";
$strings["no_results_report"] = "O relat�rio n�o obteve resultados.";
$strings["schema_date"] = "AAAA/MM/DD";
$strings["hours"] = "horas";
$strings["choice"] = "Escolha";
$strings["missing_file"] = "Arquivo em falta!";
$strings["project_site_deleted"] = "O Site do Projeto foi apagado com sucesso.";
$strings["add_user_project_site"] = "O usu�rio recebeu autoriza��o para aceder ao Site do Projeto.";
$strings["remove_user_project_site"] = "As permiss�es de usu�rio foram removidas.";
$strings["add_project_site_success"] = "A coloca��o do Site do Projeto foi feita.";
$strings["remove_project_site_success"] = "A remo��o do Site do Projeto foi feita.";
$strings["add_file_success"] = "Ligado 1 item de conte�do.";
$strings["delete_file_success"] = "Arquivo removido com sucesso.";
$strings["update_comment_file"] = "O coment�rio ao arquivo foi atualizado com sucesso.";
$strings["session_false"] = "Erro na Sess�o";
$strings["logs"] = "Registros";
$strings["logout_time"] = "Sair automaticamente";

$strings["noti_foot1"] = "Esta notifica��o foi gerada pelo PhpCollab.";
$strings["noti_foot2"] = "Para ver sua P�gina Principal do PhpCollab, visite:";
$strings["noti_taskassignment1"] = "Nova Tarefa:";
$strings["noti_taskassignment2"] = "Uma tarefa foi delegada a voc�:";
$strings["noti_moreinfo"] = "Para mais informa��es visite:";
$strings["noti_prioritytaskchange1"] = "Prioridade da Tarefa Alterada:";
$strings["noti_prioritytaskchange2"] = "A prioridade da seguinte tarefa foi alterada:";
$strings["noti_statustaskchange1"] = "Status da Tarefa Alterado:";
$strings["noti_statustaskchange2"] = "O status da seguinte tarefa foi alterado:";
$strings["login_username"] = "Voc� deve digitar um nome de usu�rio.";
$strings["login_password"] = "Por favor, digite sua senha.";
$strings["login_clientuser"] = "Esta � uma conta de usu�rio de cliente. Voc� n�o pode acessar o PhpCollab com uma conta de usu�rio de cliente.";
$strings["user_already_exists"] = "J� existe um usu�rio com este nome. Por favor, escolha uma varia��o desse nome de usu�rio.";
$strings["noti_duedatetaskchange1"] = "Data final da Tarefa alterada.";
$strings["noti_duedatetaskchange2"] = "A data final da seguinte tarefa foi alterada:";
$strings["company"] = "Companhia";
$strings["show_all"] = "Mostrar Tudo";
$strings["information"] = "Informa��o";
$strings["delete_message"] = "Apagar esta mensagem";
$strings["project_team"] = "Equipe do Projeto";
$strings["document_list"] = "Lista de Documentos";
$strings["bulletin_board"] = "Quadro de Avisos";
$strings["bulletin_board_topic"] = "T�pico do Quadro de Avisos";
$strings["create_topic"] = "Cria um Novo T�pico";
$strings["topic_form"] = "Formul�rio de T�pico";
$strings["enter_message"] = "Digite sua Mensagem";
$strings["upload_file"] = "Enviar um Arquivo";
$strings["upload_form"] = "Enviar um Formul�rio";
$strings["upload"] = "Enviar";
$strings["document"] = "Documento";
$strings["approval_comments"] = "Coment�rios de Aprova��o";
$strings["client_tasks"] = "Tarefas do Cliente";
$strings["team_tasks"] = "Tarefas da Equipe";
$strings["team_member_details"] = "Detalhes do Membro da Equipe";
$strings["client_task_details"] = "Detalhes da Tarefa do Cliente";
$strings["team_task_details"] = "Detalhes da Tarefa da Equipe";
$strings["language"] = "Idioma";
$strings["welcome"] = "Bem-vindo";
$strings["your_projectsite"] = "ao Seu Site de Projeto";
$strings["contact_projectsite"] = "Se voc� tem quaisquer quest�es sobre a extranet ou sobre as informa��es encontradas aqui, por favor entre em contato com o gerente de projeto";
$strings["company_details"] = "Detalhes da Companhia";
$strings["database"] = "Backup e Restaura��o do database";
$strings["company_info"] = "Editar as informa��es de sua companhia";
$strings["create_projectsite"] = "Criar Site do Projeto";
$strings["projectsite_url"] = "URL do Site do Projeto";
$strings["design_template"] = "Modelo de Design";
$strings["preview_design_template"] = "Pr�-Visualizar Modelo de Design";
$strings["delete_projectsite"] = "Apagar o Site do Projeto";
$strings["add_file"] = "Adicionar Arquivo";
$strings["linked_content"] = "Conte�do Anexo";
$strings["edit_file"] = "Editar detalhes do arquivo";
$strings["permitted_client"] = "Usu�rios do Cliente Permitidos";
$strings["grant_client"] = "Dar permiss�o para ver o site do projeto";
$strings["add_client_user"] = "Adicionar Usu�rio do Cliente";
$strings["edit_client_user"] = "Editar Usu�rio do Cliente";
$strings["client_user"] = "Usu�rio do Cliente";
$strings["client_change_status"] = "Mude seu status abaixo quando voc� tiver completado a tarefa";
$strings["project_status"] = "Status do Projeto";
$strings["view_projectsite"] = "Ver Site do Projeto";
$strings["enter_login"] = "Digite seu nome de usu�rio para receber uma nova senha";
$strings["send"] = "Enviar";
$strings["no_login"] = "Nome de usu�rio n�o encontrado no banco de dados";
$strings["email_pwd"] = "Senha enviada";
$strings["no_email"] = "Usu�rio sem e-mail cadastrado";
$strings["forgot_pwd"] = "Esqueceu a senha ?";
$strings["project_owner"] = "Voc� somente pode fazer altera��es em seus pr�prios projetos.";
$strings["connected"] = "Conectado";
$strings["session"] = "Sess�o";
$strings["last_visit"] = "�ltima Visita";
$strings["compteur"] = "Contador";
$strings["ip"] = "IP";
$strings["task_owner"] = "Voc� n�o � um membro da equipe deste projeto";
$strings["export"] = "Exportar";
$strings["browse_cvs"] = "Navegar no CVS";
$strings["repository"] = "Repositorio CVS";
$strings["reassignment_clientuser"] = "Reatribui��o de Tarefa";
$strings["organization_already_exists"] = "Este nome j� est� em uso no sistema. Por favor, escolha outro.";
$strings["blank_organization_field"] = "Voc� deve entrar com o nome da organiza��o cliente.";
$strings["blank_fields"] = "campos obrigat�rios";
$strings["projectsite_login_fails"] = "Imposs�vel confirmar combina��o usu�rio e senha.";
$strings["start_date"] = "Data de in�cio";
$strings["completion"] = "Finaliza��o";
$strings["update_available"] = "Uma nova vers�o do PhpCollab est� dispon�vel!";
$strings["version_current"] = "Voc� est� usando a vers�o";
$strings["version_latest"] = "A �ltima vers�o �";
$strings["sourceforge_link"] = "Ver o site do projeto no SourceForge";
$strings["demo_mode"] = "Modo demonstrativo. A��o n�o dispon�vel.";
$strings["setup_erase"] = "Apague o arquivo setup.php!!";
$strings["no_file"] = "Nenhum arquivo selecionado";
$strings["exceed_size"] = "Ultrapassou tamanho m�ximo de arquivos";
$strings["no_php"] = "Arquivos PHP n�o s�o permitidos";
$strings["approval_date"] = "Data de Aprova��o";
$strings["approver"] = "Aprovador";
$strings["error_database"] = "Erro ao conectar ao banco de dados";
$strings["error_server"] = "Erro ao conectar ao servidor";
$strings["version_control"] = "Controle de Vers�o";
$strings["vc_status"] = "Status";
$strings["vc_last_in"] = "Data da �ltima modifica��o";
$strings["ifa_comments"] = "Coment�rios de Aprova��o";
$strings["ifa_command"] = "Mudar status da aprova��o";
$strings["vc_version"] = "Vers�o";
$strings["ifc_revisions"] = "An�lise dos Colegas";
$strings["ifc_revision_of"] = "An�lise da vers�o";
$strings["ifc_add_revision"] = "Adicionar An�lise";
$strings["ifc_update_file"] = "Atualizar arquivo";
$strings["ifc_last_date"] = "Data da �ltima modifica��o";
$strings["ifc_version_history"] = "Hist�rico da Vers�o";
$strings["ifc_delete_file"] = "Apagar o arquivo e todas as vers�es e revis�es";
$strings["ifc_delete_version"] = "Apagar Vers�o Selecionada";
$strings["ifc_delete_review"] = "Apager An�lise Selecionada";
$strings["ifc_no_revisions"] = "Atualmente n�o h� revis�es para este documento";
$strings["unlink_files"] = "Remover links dos arquivos";
$strings["remove_team"] = "Remover Membros da Equipe";
$strings["remove_team_info"] = "Remover estes usu�rios da equipe de projeto?";
$strings["remove_team_client"] = "Remover permiss�o para ver o site do projeto";
$strings["note"] = "Anota��o";
$strings["notes"] = "Anota��es";
$strings["subject"] = "Assunto";
$strings["delete_note"] = "Apagar Anota��es";
$strings["add_note"] = "Adicionar Anota��o";
$strings["edit_note"] = "Editar Anota��o";
$strings["version_increm"] = "Selecione a mudan�a de vers�o para aplicar:";
$strings["url_dev"] = "URL do Site em Desenvolvimento";
$strings["url_prod"] = "URL do Site de Produ��o";
$strings["note_owner"] = "Voc� pode alterar somente suas pr�prias anota��es";
$strings["alpha_only"] = "Somente caracteres alfanum�ricos na identifica��o";
$strings["edit_notifications"] = "Editar Notifica��es por E-mail";
$strings["edit_notifications_info"] = "Selecione os eventos sobre os quais quer receber notifica��es por e-mail.";
$strings["select_deselect"] = "Selecionar/Deselecionar Tudo";
$strings["noti_addprojectteam1"] = "Adicionado � equipe do projeto:";
$strings["noti_addprojectteam2"] = "Voc� foi adicionado � equipe do projeto por: ";
$strings["noti_removeprojectteam1"] = "Removido da equipe do projeto: ";
$strings["noti_removeprojectteam2"] = "Voc� foi removido da equipe do projeto por: ";
$strings["noti_newpost1"] = "Nova postagem :";
$strings["noti_newpost2"] = "Uma nova mensagem foi postada ao seguinte debate :";
$strings["edit_noti_taskassignment"] = "Eu fui designado a uma nova tarefa.";
$strings["edit_noti_statustaskchange"] = "O status de uma de minhas tarefas mudou.";
$strings["edit_noti_prioritytaskchange"] = "A prioridade de uma de minhas tarefas mudou.";
$strings["edit_noti_duedatetaskchange"] = "A data final de uma de minhas tarefas mudou.";
$strings["edit_noti_addprojectteam"] = "Eu fui adicionado a uma equipe de projeto.";
$strings["edit_noti_removeprojectteam"] = "Eu fui removido de uma equipe de projeto.";
$strings["edit_noti_newpost"] = "Uma nova mensagem foi enviada a um debate.";
$strings["add_optional"] = "Adicionar um opcional";
$strings["assignment_comment_info"] = "Adicionar coment�rios sobre a delega��o desta tarefa";
$strings["my_notes"] = "Minhas Anota��es";
$strings["edit_settings"] = "Editar configura��es";
$strings["max_upload"] = "Tamanho m�ximo de arquivo";
$strings["project_folder_size"] = "Tamanho do diret�rio do projeto";
$strings["calendar"] = "Calend�rio";
$strings["date_start"] = "Data Inicial";
$strings["date_end"] = "Data Final";
$strings["time_start"] = "Hora Inicial";
$strings["time_end"] = "Hora Final";
$strings["calendar_reminder"] = "Lembrete";
$strings["shortname"] = "Abrevia��o";
$strings["calendar_recurring"] = "Evento repete toda semana neste dia";
$strings["edit_database"] = "Editar database";
$strings["noti_newtopic1"] = "Novo debate: ";
$strings["noti_newtopic2"] = "Um novo debate foi adicionado ao seguinte projeto: ";
$strings["edit_noti_newtopic"] = "Um novo t�pico de debate foi criado.";
$strings["today"] = "Hoje";
$strings["previous"] = "Anterior";
$strings["next"] = "Pr�ximo";
$strings["help"] = "Ajuda";
$strings["complete_date"] = "Complete date";
$strings["scope_creep"] = "Scope creep";
$strings["days"] = "Dias";
$strings["logo"] = "Logo";
$strings["remember_password"] = "Lembrar da senha";
$strings["client_add_task_note"] = "Lembrete: a tarefa inclu�da est� registrada na base de dados e aparece aqui, mas somente se delegada a um membro da equipe";
$strings["noti_clientaddtask1"] = "Tarefa adicionada pelo cliente :";
$strings["noti_clientaddtask2"] = "Nova tarefa aficionada pelo cliente a partir do site do seguinte projeto :";
$strings["phase"] = "Fase";
$strings["phases"] = "Fases";
$strings["phase_id"] = "ID da Fase";
$strings["current_phase"] = "Fase(s) ativa(s)";
$strings["total_tasks"] = "Total de tarefas";
$strings["uncomplete_tasks"] = "Tarefas incompletas";
$strings["no_current_phase"] = "Nenhuma fase ativa atualmente";
$strings["true"] = "Sim";
$strings["false"] = "N�o";
$strings["enable_phases"] = "Habilitar Fases";
$strings["phase_enabled"] = "Fase habilitada";
$strings["order"] = "Order";
$strings["options"] = "Op��es";
$strings["support"] = "Suporte";
$strings["support_request"] = "Pedido de suporte";
$strings["support_requests"] = "Pedidos de suporte";
$strings["support_id"] = "ID do pedido";
$strings["my_support_request"] = "Meus pedidos de suporte";
$strings["introduction"] = "Introdu��o";
$strings["submit"] = "Enviar";
$strings["support_management"] = "Gerenciamento de Suporte";
$strings["date_open"] = "Data de abertura";

$strings["date_close"] = "Data de encerramento";
$strings["add_support_request"] = "Adicionar pedido de suporte";
$strings["add_support_response"] = "Adicionar resposta de suporte";
$strings["respond"] = "Responder";
$strings["delete_support_request"] = "Pedido de suporte exclu�do";
$strings["delete_request"] = "Excluir pedido de suporte";
$strings["delete_support_post"] = "Excluir envio de suporte";
$strings["new_requests"] = "Novos pedidos";
$strings["open_requests"] = "Pedidos abertos";
$strings["closed_requests"] = "Pedidos completos";
$strings["manage_new_requests"] = "Gerenciar novos pedidos";
$strings["manage_open_requests"] = "Gerenciar pedidos abertos";
$strings["manage_closed_requests"] = "Gerenciar pedidos completos";
$strings["responses"] = "Respostas";
$strings["edit_status"] = "Editar Status";
$strings["noti_support_request_new2"] = "Voc� enviou um pedido de suporte a respeito de: ";
$strings["noti_support_post2"] = "Uma nova resposta foi adicionada ao seu pedido de suporte. Por favor, verifique os detalhes abaixo.";
$strings["noti_support_status2"] = "O seu pedido de suporte foi atualizado. Por favor, verifique os detalhes abaixo.";
$strings["noti_support_team_new2"] = "Um novo pedido de suporte foi adicionado ao projeto: ";
// 2.0
$strings["delete_subtasks"] = "Delete subtasks";
$strings["add_subtask"] = "Add subtask";
$strings["edit_subtask"] = "Edit subtask";
$strings["subtask"] = "Subtask";
$strings["subtasks"] = "Subtasks";
$strings["show_details"] = "Show details";
$strings["updates_task"] = "Task update history";
$strings["updates_subtask"] = "Subtask update history";
// 2.1
$strings["go_projects_site"] = "Go to projects site";
$strings["bookmark"] = "Bookmark";
$strings["bookmarks"] = "Bookmarks";
$strings["bookmark_category"] = "Category";
$strings["bookmark_category_new"] = "New category";
$strings["bookmarks_all"] = "All";
$strings["bookmarks_my"] = "My Bookmarks";
$strings["my"] = "My";
$strings["bookmarks_private"] = "Private";
$strings["shared"] = "Shared";
$strings["private"] = "Private";
$strings["add_bookmark"] = "Add bookmark";
$strings["edit_bookmark"] = "Edit bookmark";
$strings["delete_bookmarks"] = "Delete bookmarks";
$strings["team_subtask_details"] = "Team Subtask Details";
$strings["client_subtask_details"] = "Client Subtask Details";
$strings["client_change_status_subtask"] = "Change your status below when you have completed this subtask";
$strings["disabled_permissions"] = "Disabled account";
$strings["user_timezone"] = "Timezone (GMT)";
// 2.2
$strings["project_manager_administrator_permissions"] = "Project Manager Administrator";
$strings["bug"] = "Bug Tracking";
// 2.3
$strings["report"] = "Report";
$strings["license"] = "License";
// 2.4
$strings["settings_notwritable"] = "Settings.php file is not writable";

?>