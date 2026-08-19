<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Popular o banco com dados de demonstracao (todos ficticios).
     */
    public function run()
    {
        // permissao de admin
        $adminPerm = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // usuario admin de demonstracao (credenciais publicas, so pra demo)
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('senha1234'),
                'email_verified_at' => now(),
            ]
        );
        $admin->givePermissionTo($adminPerm);

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
    }
}
