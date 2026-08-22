<?php

namespace App\Support;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

// Definicao central do controle de acesso (RBAC) com menor privilegio.
// Fonte unica da verdade para papeis e permissoes; usada pelo seeder e pelo login.
class Rbac
{
    // todas as permissoes granulares do sistema
    public const PERMISSOES = [
        'pacientes.cadastrar',
        'pacientes.ver',
        'pacientes.editar',
        'pacientes.imprimir',
        'pacientes.arquivar',
        'atendimentos.registrar',
        'usuarios.gerenciar',
        'auditoria.ver',
    ];

    // papeis -> permissoes (menor privilegio)
    public const MATRIZ = [
        // dono: acesso total
        'dono' => [
            'pacientes.cadastrar', 'pacientes.ver', 'pacientes.editar', 'pacientes.imprimir',
            'pacientes.arquivar', 'atendimentos.registrar', 'usuarios.gerenciar', 'auditoria.ver', 'admin',
        ],
        // tutor (professor/supervisor): tudo menos arquivar; gerencia estagiarios
        'tutor' => [
            'pacientes.cadastrar', 'pacientes.ver', 'pacientes.editar', 'pacientes.imprimir',
            'atendimentos.registrar', 'usuarios.gerenciar', 'auditoria.ver',
        ],
        // estagiario: cadastra, ve, imprime e registra atendimento (tudo auditado)
        'estagiario' => [
            'pacientes.cadastrar', 'pacientes.ver', 'pacientes.imprimir', 'atendimentos.registrar',
        ],
    ];

    public const ROTULOS = [
        'dono'       => 'Dono',
        'tutor'      => 'Tutor',
        'estagiario' => 'Estagiário',
    ];

    // cria/atualiza papeis e permissoes de forma idempotente
    public static function sincronizar(): void
    {
        foreach (self::PERMISSOES as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }
        // permissao antiga mantida por compatibilidade
        Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        foreach (self::MATRIZ as $papel => $perms) {
            $role = Role::firstOrCreate(['name' => $papel, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public static function rotulo(?string $papel): string
    {
        return self::ROTULOS[$papel] ?? (string) $papel;
    }
}
