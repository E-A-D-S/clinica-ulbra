<?php

namespace Database\Seeders;

use App\Models\AuthorizedUser;
use App\Models\Patient;
use App\Models\User;
use App\Support\Rbac;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Popular o banco com dados de demonstracao (todos ficticios).
     */
    public function run()
    {
        // --- Papeis e permissoes (RBAC, menor privilegio) ---
        Rbac::sincronizar();

        // --- Donos autorizados (staff real) ---
        foreach (['clinicaescolasj@gmail.com', 'eduardoeko7@gmail.com'] as $emailDono) {
            AuthorizedUser::updateOrCreate(
                ['email' => $emailDono],
                ['role' => 'dono', 'active' => true]
            );
        }

        // garante que quem ja tem conta receba o papel na hora (sem precisar relogar apos o deploy)
        foreach (AuthorizedUser::where('active', true)->get() as $autorizado) {
            $existente = User::where('email', $autorizado->email)->first();
            if ($existente) {
                $existente->syncRoles([$autorizado->role]);
                if ($autorizado->role === 'dono') {
                    $existente->givePermissionTo('admin');
                }
            }
        }

        // usuario admin de demonstracao (credenciais publicas, so pra demo)
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('senha1234'),
                'email_verified_at' => now(),
            ]
        );
        // demo enxerga tudo (papel dono), mas a escrita fica bloqueada por ser a conta publica de demo
        $admin->syncRoles(['dono']);
        $admin->givePermissionTo('admin');
        AuthorizedUser::updateOrCreate(['email' => 'admin@demo.com'], ['role' => 'dono', 'active' => true]);

        // pacientes ficticios
        $pacientes = [
            ['Ana Souza', 'Rua das Flores', '12.345.678-9', '111.222.333-44', '1990-04-12', '(51) 99999-0001', 'Solteira', 'Charqueadas'],
            ['Bruno Lima', 'Av. Brasil', '98.765.432-1', '222.333.444-55', '1985-09-30', '(51) 99999-0002', 'Casado', 'Charqueadas'],
            ['Carla Mendes', 'Rua XV de Novembro', '45.678.912-3', '333.444.555-66', '1998-01-22', '(51) 99999-0003', 'Solteira', 'Triunfo'],
            ['Diego Rocha', 'Rua do Sol', '78.912.345-6', '444.555.666-77', '1979-11-05', '(51) 99999-0004', 'Divorciado', 'Charqueadas'],
            ['Elaine Costa', 'Rua Nova', '32.165.498-7', '555.666.777-88', '2001-06-18', '(51) 99999-0005', 'Solteira', 'General Camara'],
        ];
        $atendimentosDemo = [
            ['sub' => 14, 'prof' => 'Estagiária Júlia', 'txt' => 'Sessão inicial. Paciente relatou ansiedade relacionada ao trabalho. Combinado acompanhamento semanal.'],
            ['sub' => 7,  'prof' => 'Estagiária Júlia', 'txt' => 'Segunda sessão. Trabalhadas técnicas de respiração e organização da rotina. Boa adesão.'],
        ];

        foreach ($pacientes as $p) {
            Patient::updateOrCreate(
                ['cpf' => $p[3]],
                [
                    'name' => $p[0], 'email' => strtolower(str_replace(' ', '.', $p[0])) . '@exemplo.com', 'address' => $p[1], 'rg' => $p[2],
                    'birth_date' => $p[4], 'telephone' => $p[5], 'marital_status' => $p[6], 'city' => $p[7],
                    'time_service' => 'Manha', 'consultation' => 'Consulta de rotina',
                    'house_number' => '120', 'district' => 'Centro', 'Complement' => 'Apto 2',
                    'name_father' => 'Responsavel Demo', 'address_father' => 'Rua Demo', 'city_father' => $p[7],
                    'is_demo' => true, // ficticio: visivel para a conta de demonstracao
                ]
            );
        }

        // atendimentos de demonstracao no primeiro paciente (Ana)
        $ana = Patient::where('cpf', '111.222.333-44')->first();
        if ($ana && $ana->atendimentos()->count() === 0) {
            foreach ($atendimentosDemo as $a) {
                $ana->atendimentos()->create([
                    'data_hora'    => now()->subDays($a['sub'])->setTime(14, 0),
                    'profissional' => $a['prof'],
                    'anotacoes'    => $a['txt'],
                ]);
            }
        }

        // --- Equipe ficticia (so aparece para a conta de demonstracao) ---
        $equipeDemo = [
            ['email' => 'tutora.demo@exemplo.com', 'role' => 'tutor'],
            ['email' => 'estagiaria.demo@exemplo.com', 'role' => 'estagiario'],
        ];
        foreach ($equipeDemo as $membro) {
            AuthorizedUser::updateOrCreate(
                ['email' => $membro['email']],
                ['role' => $membro['role'], 'active' => true, 'is_demo' => true]
            );
        }

        // --- Auditoria ficticia (so aparece para a conta de demonstracao) ---
        if (\App\Models\AuditLog::where('is_demo', true)->count() === 0 && $ana) {
            $logsDemo = [
                ['email' => 'estagiaria.demo@exemplo.com', 'role' => 'estagiario', 'action' => 'paciente.cadastrar', 'desc' => 'Cadastro de paciente', 'dias' => 14],
                ['email' => 'estagiaria.demo@exemplo.com', 'role' => 'estagiario', 'action' => 'atendimento.registrar', 'desc' => 'Atendimento registrado no historico', 'dias' => 14],
                ['email' => 'tutora.demo@exemplo.com', 'role' => 'tutor', 'action' => 'paciente.editar', 'desc' => 'Paciente editado', 'dias' => 6],
                ['email' => 'tutora.demo@exemplo.com', 'role' => 'tutor', 'action' => 'paciente.imprimir.historico', 'desc' => 'Impressao do historico', 'dias' => 2],
            ];
            foreach ($logsDemo as $l) {
                \App\Models\AuditLog::create([
                    'user_email'   => $l['email'],
                    'user_role'    => $l['role'],
                    'action'       => $l['action'],
                    'subject_type' => 'Patient',
                    'subject_id'   => $ana->id,
                    'description'  => $l['desc'],
                    'ip'           => '203.0.113.10',
                    'is_demo'      => true,
                    'created_at'   => now()->subDays($l['dias']),
                    'updated_at'   => now()->subDays($l['dias']),
                ]);
            }
        }
    }
}
