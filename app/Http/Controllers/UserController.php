<?php

namespace App\Http\Controllers;

use App\Mail\CadastroPaciente;
use App\Models\AuditLog;
use App\Models\AuthorizedUser;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\User;
use App\Support\Rbac;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function home()
    {
        return view('index');
    }

    function homeScreen()
    {
        return view('homeScreen');
    }

    // registra uma acao na trilha de auditoria
    private function registrarAuditoria(string $action, ?Patient $patient = null, ?string $descricao = null): void
    {
        $u = Auth::user();
        AuditLog::create([
            'user_id'      => $u?->id,
            'user_email'   => $u?->email,
            'user_role'    => $u ? ($u->getRoleNames()->first()) : null,
            'action'       => $action,
            'subject_type' => $patient ? 'Patient' : null,
            'subject_id'   => $patient?->id,
            'description'  => $descricao,
            'ip'           => request()->ip(),
        ]);
    }

    public function index()
    {
        $search = request('search');
        if ($search) {
            $patient = Patient::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $patient = Patient::all();
        }
        return view('admin.index', compact('patient'));
    }

    // regras de validacao reaproveitadas no cadastro e na edicao
    private function regras()
    {
        return [
            'name'           => 'required|string|max:120',
            'email'          => 'nullable|email|max:120',
            'birth_date'     => 'required|date',
            'marital_status' => 'nullable|string|max:40',
            'telephone'      => 'required|string|max:20',
            'rg'             => 'required|string|max:20',
            'cpf'            => 'required|string|max:20',
            'address'        => 'required|string|max:150',
            'Complement'     => 'required|string|max:60',
            'house_number'   => 'required|string|max:15',
            'city'           => 'required|string|max:80',
            'district'       => 'required|string|max:80',
            'time_service'   => 'required|string|max:40',
            'consultation'   => 'required|string|max:500',
            'name_father'    => 'nullable|string|max:120',
            'address_father' => 'nullable|string|max:150',
            'city_father'    => 'nullable|string|max:80',
        ];
    }

    // Bloqueia escrita APENAS para a conta publica de demonstracao (admin@demo.com),
    // para os dados de exemplo ficarem intactos. A equipe real tem acesso normal.
    private function demoBloqueado(): bool
    {
        return optional(Auth::user())->email === 'admin@demo.com';
    }

    public function store(Request $request)
    {
        // Obs.: o cadastro publico fica LIBERADO mesmo em modo demo (pra confirmar por e-mail);
        // apenas as acoes do admin (editar/arquivar/permissao) ficam bloqueadas na demo.

        // honeypot anti-spam: campo escondido que so bot preenche
        if ($request->filled('website')) {
            return back();
        }

        // consentimento LGPD + e-mail obrigatorios no cadastro publico
        $request->validate([
            'consentimento' => 'accepted',
            'email'         => 'required|email|max:120',
        ], [
            'consentimento.accepted' => 'E necessario concordar com o uso dos dados para continuar.',
            'email.required'         => 'Informe um e-mail para receber a confirmacao do cadastro.',
        ]);

        // validacao server-side de todos os campos
        $dados = $request->validate($this->regras());

        $patient = Patient::create($dados);
        $this->registrarAuditoria('paciente.cadastrar', $patient, 'Cadastro de paciente');

        // e-mails: aviso ao admin/clinica + confirmacao ao paciente.
        // Envolto em try/catch: se o envio falhar, o cadastro nao quebra nem vaza erro.
        try {
            Mail::to(config('mail.from.address'))
                ->send(new CadastroPaciente($patient, 'Novo paciente cadastrado', 'emails.admin-novo'));

            if ($patient->email) {
                Mail::to($patient->email)
                    ->send(new CadastroPaciente($patient, 'Cadastro recebido - Clinica Escola ULBRA', 'emails.confirmacao'));
            }
        } catch (\Throwable $e) {
            Log::warning('Falha ao enviar e-mail de cadastro: ' . $e->getMessage());
        }

        return redirect()->route('paciente.home')->with('paciente', 'Cadastro feito com sucesso! Enviamos uma confirmacao para o seu e-mail.');
    }

    public function destroy($id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('paciente.index');
        }
        // soft delete: o registro sai da lista ativa mas fica guardado (prontuario)
        $patient->delete();
        $this->registrarAuditoria('paciente.arquivar', $patient, 'Paciente arquivado');
        return redirect()->route('paciente.index')->with('paciente', 'Paciente arquivado. O historico continua guardado.');
    }

    public function edit($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('paciente.index');
        }
        return view('admin.edit', compact('patient'));
    }

    public function view($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return redirect()->route('paciente.index');
        }
        return view('admin.view', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: edicoes estao desabilitadas.');
        }
        $patient = Patient::findOrFail($id);

        // validacao + atualizacao so dos campos previstos (sem mass assignment)
        $dados = $request->validate($this->regras());
        $patient->update($dados);
        $this->registrarAuditoria('paciente.editar', $patient, 'Paciente editado');

        return redirect()->route('paciente.index')->with('paciente', 'Paciente atualizado com sucesso!');
    }

    public function generatePdf($id)
    {
        // withTrashed: permite imprimir o contrato tambem de paciente arquivado
        $data = Patient::withTrashed()->findOrFail($id);
        $this->registrarAuditoria('paciente.imprimir.ficha', $data, 'Impressao da ficha/contrato');
        $pdf = Pdf::loadView('pdf.dicePatient', compact('data'));
        return $pdf->stream('dicePatient.pdf');
    }

    // --- Gestao de equipe (RBAC) ---

    private function usuarioEhDono(): bool
    {
        return (bool) optional(Auth::user())->hasRole('dono');
    }

    // aplica (ou remove) o papel no usuario ja existente, se houver
    private function aplicarPapelNoUsuario(string $email, ?string $role): void
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return;
        }
        if ($role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            $user->syncRoles([$role]);
            if ($role === 'dono') {
                $user->givePermissionTo('admin'); // compatibilidade
            }
        } else {
            $user->syncRoles([]); // sem papel = sem acesso ao painel
        }
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function usuarios()
    {
        if ($this->usuarioEhDono()) {
            $autorizados = AuthorizedUser::orderBy('role')->orderBy('email')->get();
        } else {
            // tutor ve apenas os estagiarios que ele mesmo convidou
            $autorizados = AuthorizedUser::where('invited_by', Auth::id())->orderBy('email')->get();
        }
        $ehDono = $this->usuarioEhDono();
        return view('admin.usuarios', compact('autorizados', 'ehDono'));
    }

    public function usuariosStore(Request $request)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }

        $dados = $request->validate([
            'email' => 'required|email|max:120',
            'role'  => 'required|in:tutor,estagiario',
        ], [
            'email.required' => 'Informe o e-mail da pessoa.',
            'role.in'        => 'Papel invalido.',
        ]);

        $email = strtolower(trim($dados['email']));

        // menor privilegio: tutor so pode criar estagiario
        $role = $this->usuarioEhDono() ? $dados['role'] : 'estagiario';

        // nao permite recriar/alterar um dono principal por aqui
        if (in_array($email, $this->adminsAutorizados(), true)) {
            return back()->with('paciente', 'Este e-mail e um dono do sistema e nao pode ser alterado aqui.');
        }

        AuthorizedUser::updateOrCreate(
            ['email' => $email],
            ['role' => $role, 'active' => true, 'invited_by' => Auth::id()]
        );
        $this->aplicarPapelNoUsuario($email, $role);
        $this->registrarAuditoria('usuario.autorizar', null, "Autorizou {$email} como {$role}");

        return redirect()->route('paciente.usuarios')->with('paciente', 'Acesso liberado para ' . $email . ' (' . Rbac::rotulo($role) . ').');
    }

    // valida se o usuario atual pode gerenciar aquele registro
    private function podeGerenciar(AuthorizedUser $alvo): bool
    {
        if (in_array($alvo->email, $this->adminsAutorizados(), true)) {
            return false; // dono principal e protegido
        }
        if ($this->usuarioEhDono()) {
            return true;
        }
        // tutor: so os estagiarios que ele convidou
        return $alvo->role === 'estagiario' && (int) $alvo->invited_by === (int) Auth::id();
    }

    public function usuariosToggle($id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        $alvo = AuthorizedUser::findOrFail($id);
        if (!$this->podeGerenciar($alvo)) {
            return back()->with('paciente', 'Voce nao tem permissao para alterar este acesso.');
        }
        $alvo->active = !$alvo->active;
        $alvo->save();
        // reflete no usuario: ativo recebe o papel, inativo perde o acesso
        $this->aplicarPapelNoUsuario($alvo->email, $alvo->active ? $alvo->role : null);
        $this->registrarAuditoria('usuario.status', null, ($alvo->active ? 'Ativou' : 'Desativou') . " o acesso de {$alvo->email}");

        return back()->with('paciente', 'Acesso ' . ($alvo->active ? 'ativado' : 'desativado') . ' para ' . $alvo->email . '.');
    }

    public function usuariosDestroy($id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        $alvo = AuthorizedUser::findOrFail($id);
        if (!$this->podeGerenciar($alvo)) {
            return back()->with('paciente', 'Voce nao tem permissao para remover este acesso.');
        }
        $email = $alvo->email;
        $this->aplicarPapelNoUsuario($email, null); // remove o acesso do usuario
        $alvo->delete();
        $this->registrarAuditoria('usuario.remover', null, "Removeu o acesso de {$email}");

        return back()->with('paciente', 'Acesso removido para ' . $email . '.');
    }

    public function auditoria()
    {
        if ($this->usuarioEhDono()) {
            $logs = AuditLog::orderByDesc('created_at')->limit(300)->get();
        } else {
            // tutor: seus proprios registros + os dos estagiarios que convidou
            $emailsEstagiarios = AuthorizedUser::where('invited_by', Auth::id())->pluck('email')->toArray();
            $emailsEstagiarios[] = Auth::user()->email;
            $logs = AuditLog::whereIn('user_email', $emailsEstagiarios)->orderByDesc('created_at')->limit(300)->get();
        }
        return view('admin.auditoria', compact('logs'));
    }

    // Pacientes arquivados (soft-deleted). NUNCA excluimos de fato: guarda legal de prontuario.
    public function arquivados()
    {
        $patient = Patient::onlyTrashed()->get();
        return view('admin.arquivados', compact('patient'));
    }

    public function restaurar($id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->restore();
        $this->registrarAuditoria('paciente.restaurar', $patient, 'Paciente restaurado');
        return redirect()->route('paciente.index')->with('paciente', 'Paciente restaurado com sucesso.');
    }

    // --- Historico de atendimentos ---
    public function storeAtendimento(Request $request, $id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        $patient = Patient::findOrFail($id);
        $dados = $request->validate([
            'data_hora'    => 'required|date',
            'profissional' => 'nullable|string|max:120',
            'anotacoes'    => 'required|string|max:5000',
        ]);
        $patient->atendimentos()->create($dados);
        $this->registrarAuditoria('atendimento.registrar', $patient, 'Atendimento registrado no historico');
        return redirect()->route('paciente.view', $patient->id)->with('paciente', 'Atendimento registrado no historico.');
    }

    public function historicoPdf($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $atendimentos = $patient->atendimentos()->get();
        $this->registrarAuditoria('paciente.imprimir.historico', $patient, 'Impressao do historico');
        $pdf = Pdf::loadView('pdf.historico', compact('patient', 'atendimentos'));
        return $pdf->stream('historico-' . $patient->id . '.pdf');
    }

    // --- Login com Google (OAuth via Socialite) ---
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // e-mails autorizados como admin (staff da clinica)
    private function adminsAutorizados()
    {
        return ['clinicaescolasj@gmail.com', 'eduardoeko7@gmail.com'];
    }

    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect('/login')->withErrors(['email' => 'Nao foi possivel entrar com o Google. Tente novamente.']);
        }

        // normaliza o e-mail (minusculo + sem espacos) pra casar de forma confiavel
        $email = strtolower(trim($googleUser->getEmail()));

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $googleUser->getName() ?: 'Usuario Google',
                'password' => bcrypt(Str::random(40)),
                'email_verified_at' => now(),
            ]
        );

        // define o papel a partir da lista de autorizados (dono/tutor/estagiario)
        $autorizado = AuthorizedUser::where('email', $email)->where('active', true)->first();
        $role = $autorizado->role ?? null;

        // seguranca: o dono principal e sempre dono, mesmo que a tabela falhe
        if (in_array($email, $this->adminsAutorizados(), true)) {
            $role = 'dono';
        }

        if ($role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            $user->syncRoles([$role]);
            if ($role === 'dono') {
                $user->givePermissionTo('admin'); // compatibilidade
            }
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        } else {
            $user->syncRoles([]); // sem autorizacao = sem acesso ao painel
        }

        Auth::login($user, true);

        return redirect($role ? route('paciente.index') : route('paciente.homeScreen'));
    }
}
