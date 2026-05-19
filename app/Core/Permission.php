<?php

namespace App\Core;

final class Permission
{
    // Tickets
    public const OPEN_TICKET = 'abrir_chamado';
    public const VIEW_MY_TICKETS = 'ver_meus_chamados';
    public const VIEW_ALL_TICKETS = 'ver_todos_chamados';
    public const COMMENT_TICKET = 'comentar_chamado';
    public const ATTACH_FILE_TICKET = 'anexar_arquivo_chamado';
    public const CONFIRM_RESOLUTION = 'confirmar_resolucao';
    public const REOPEN_TICKET = 'reabrir_chamado';
    public const ASSIGN_TICKET = 'atribuir_chamado';
    public const TAKE_TICKET = 'assumir_chamado';
    public const EDIT_TICKET = 'editar_chamado';
    public const CLOSE_TICKET = 'fechar_chamado';
    public const ARCHIVE_TICKET = 'arquivar_chamado';
    public const DELETE_TICKET = 'excluir_chamado';
    public const VIEW_TICKET_HISTORY = 'ver_historico_chamado';
    public const VIEW_MY_ASSIGNED_TICKETS = 'ver_chamados_atribuidos_a_mim';

    // Comments
    public const EDIT_OWN_COMMENT = 'editar_proprio_comentario';
    public const DELETE_OWN_COMMENT = 'excluir_proprio_comentario';
    public const DELETE_ANY_COMMENT = 'excluir_qualquer_comentario';

    // Attachments
    public const DELETE_OWN_ATTACHMENT = 'excluir_proprio_anexo';
    public const DELETE_ANY_ATTACHMENT = 'excluir_qualquer_anexo';
    public const DOWNLOAD_ATTACHMENT = 'baixar_anexo';

    // Dashboard
    public const VIEW_REQUESTER_DASHBOARD = 'ver_dashboard_solicitante';
    public const VIEW_TECHNICIAN_DASHBOARD = 'ver_dashboard_tecnico';
    public const VIEW_MANAGER_DASHBOARD = 'ver_dashboard_gestor';

    // Reports
    public const VIEW_REPORTS = 'ver_relatorios';
    public const EXPORT_REPORTS = 'exportar_relatorios';

    // Users
    public const VIEW_USERS = 'ver_usuarios';
    public const CREATE_USER = 'criar_usuario';
    public const EDIT_USER = 'editar_usuario';
    public const TOGGLE_USER_STATUS = 'ativar_inativar_usuario';
    public const DELETE_USER = 'excluir_usuario';
    public const RESET_USER_PASSWORD = 'redefinir_senha_usuario';
    public const VIEW_USER_LAST_ACCESS = 'ver_ultimo_acesso_usuario';

    // Roles
    public const VIEW_ROLES = 'ver_perfis';
    public const CREATE_ROLE = 'criar_perfil';
    public const EDIT_ROLE = 'editar_perfil';
    public const DELETE_ROLE = 'excluir_perfil';
    public const MANAGE_ROLE_PERMISSIONS = 'gerenciar_permissoes_perfil';

    // Departments
    public const VIEW_DEPARTMENTS = 'ver_departamentos';
    public const CREATE_DEPARTMENT = 'criar_departamento';
    public const EDIT_DEPARTMENT = 'editar_departamento';
    public const DELETE_DEPARTMENT = 'excluir_departamento';
    public const LINK_USER_DEPARTMENT = 'vincular_usuario_departamento';
    public const UNLINK_USER_DEPARTMENT = 'desvincular_usuario_departamento';

    // Categories
    public const VIEW_CATEGORIES = 'ver_categorias';
    public const CREATE_CATEGORY = 'criar_categoria';
    public const EDIT_CATEGORY = 'editar_categoria';
    public const DELETE_CATEGORY = 'excluir_categoria';

    // Own profile
    public const EDIT_OWN_PROFILE = 'editar_proprio_perfil';
    public const CHANGE_OWN_PASSWORD = 'alterar_propria_senha';

    // System
    public const VIEW_SYSTEM_LOG = 'ver_log_sistema';
    public const MANAGE_SESSIONS = 'gerenciar_sessoes';

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}