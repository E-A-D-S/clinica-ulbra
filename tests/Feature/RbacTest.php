<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use App\Support\Rbac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private function usuario(string $role, string $email): User
    {
        Rbac::sincronizar();
        $u = User::create([
            'name' => $role,
            'email' => $email,
            'password' => bcrypt('senha1234'),
            'email_verified_at' => now(),
        ]);
        $u->syncRoles([$role]);
        return $u->fresh();
    }

    private function paciente(array $over = []): Patient
    {
        return Patient::create(array_merge([
            'name' => 'Paciente Teste', 'email' => 'p@t.com', 'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro', 'telephone' => '5199999', 'rg' => uniqid(), 'cpf' => uniqid(),
            'address' => 'Rua', 'Complement' => 'x', 'house_number' => '1', 'city' => 'C',
            'district' => 'D', 'time_service' => 'Manha', 'consultation' => 'rotina',
        ], $over));
    }

    public function test_visitante_sem_login_vai_para_login(): void
    {
        Rbac::sincronizar();
        $this->get('/paciente')->assertRedirect('/login');
    }

    public function test_estagiario_nao_edita_nao_arquiva_nao_gerencia(): void
    {
        $u = $this->usuario('estagiario', 'estag@t.com');
        $p = $this->paciente();

        $this->actingAs($u)->get('/paciente')->assertOk();            // pode ver a lista
        $this->actingAs($u)->get('/paciente/view/' . $p->id)->assertOk();
        $this->actingAs($u)->get('/paciente/edit/' . $p->id)->assertForbidden();   // nao edita
        $this->actingAs($u)->delete('/paciente/' . $p->id)->assertForbidden();     // nao arquiva
        $this->actingAs($u)->get('/paciente/usuarios')->assertForbidden();         // nao gerencia
        $this->actingAs($u)->get('/paciente/auditoria')->assertForbidden();        // nao ve auditoria
    }

    public function test_tutor_edita_gerencia_mas_nao_arquiva(): void
    {
        $u = $this->usuario('tutor', 'tutor@t.com');
        $p = $this->paciente();

        $this->actingAs($u)->get('/paciente/edit/' . $p->id)->assertOk();          // edita
        $this->actingAs($u)->get('/paciente/usuarios')->assertOk();                // gerencia
        $this->actingAs($u)->get('/paciente/auditoria')->assertOk();               // ve auditoria
        $this->actingAs($u)->delete('/paciente/' . $p->id)->assertForbidden();     // NAO arquiva
    }

    public function test_dono_faz_tudo(): void
    {
        $u = $this->usuario('dono', 'dono@t.com');
        $p = $this->paciente();

        $this->actingAs($u)->get('/paciente/edit/' . $p->id)->assertOk();
        $this->actingAs($u)->get('/paciente/usuarios')->assertOk();
        $this->actingAs($u)->get('/paciente/arquivados')->assertOk();
        $this->actingAs($u)->delete('/paciente/' . $p->id)->assertRedirect();      // arquiva (redirect apos sucesso)
        $this->assertSoftDeleted('patients', ['id' => $p->id]);
    }

    public function test_conta_demo_nao_escreve(): void
    {
        $u = $this->usuario('dono', 'admin@demo.com'); // demo tem papel dono, mas e so-leitura
        $p = $this->paciente();

        $this->actingAs($u)->delete('/paciente/' . $p->id)->assertRedirect();      // volta com aviso
        $this->assertDatabaseHas('patients', ['id' => $p->id, 'deleted_at' => null]); // NAO arquivou
    }

    public function test_conta_demo_so_ve_dados_ficticios(): void
    {
        $demo = $this->usuario('dono', 'admin@demo.com');
        $real = $this->paciente(['name' => 'Cliente Real Sigiloso', 'is_demo' => false]);
        $fake = $this->paciente(['name' => 'Paciente Ficticio', 'is_demo' => true]);

        $resp = $this->actingAs($demo)->get('/paciente');
        $resp->assertOk();
        $resp->assertDontSee('Cliente Real Sigiloso'); // nao vaza cliente real
        $resp->assertSee('Paciente Ficticio');         // ve o ficticio

        // nao acessa a ficha/impressao do cliente real
        $this->actingAs($demo)->get('/paciente/view/' . $real->id)->assertRedirect('/paciente');
        $this->actingAs($demo)->get('/paciente/generatePdf/' . $real->id)->assertNotFound();
        // acessa a do ficticio
        $this->actingAs($demo)->get('/paciente/view/' . $fake->id)->assertOk();
    }

    public function test_tutor_so_gerencia_proprios_estagiarios(): void
    {
        $tutorA = $this->usuario('tutor', 'tutorA@t.com');
        $tutorB = $this->usuario('tutor', 'tutorB@t.com');

        // tutorA cria um estagiario
        $this->actingAs($tutorA)->post('/paciente/usuarios', [
            'email' => 'estagA@t.com', 'role' => 'estagiario',
        ])->assertRedirect();

        $reg = \App\Models\AuthorizedUser::where('email', 'estaga@t.com')->first();
        $this->assertNotNull($reg);
        $this->assertEquals('estagiario', $reg->role);

        // tutorB NAO pode remover o estagiario de tutorA
        $this->actingAs($tutorB)->delete('/paciente/usuarios/' . $reg->id)->assertRedirect();
        $this->assertDatabaseHas('authorized_users', ['email' => 'estaga@t.com']); // continua la
    }
}
