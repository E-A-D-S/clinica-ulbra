<?php

namespace App\Http\Controllers;

use App\Mail\CadastroPaciente;
use App\Models\model_has_permission;
use Illuminate\Support\Facades\Log;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Permission;

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

    function permission()
    {
        $permission = model_has_permission::all();
        $user = User::all();
        return view('permission', compact('permission', 'user'));
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

        return redirect()->route('paciente.index')->with('paciente', 'Paciente atualizado com sucesso!');
    }

    public function generatePdf($id)
    {
        // withTrashed: permite imprimir o contrato tambem de paciente arquivado
        $data = Patient::withTrashed()->findOrFail($id);
        $pdf = Pdf::loadView('pdf.dicePatient', compact('data'));
        return $pdf->stream('dicePatient.pdf');
    }

    public function permissionEdit($id)
    {
        $data = model_has_permission::where('model_id', $id)->get();
        return view('permissionEdit', compact('data'));
    }

    public function permissionUpdate(Request $request, $id)
    {
        if ($this->demoBloqueado()) {
            return back()->with('paciente', 'Modo demonstracao: alteracoes de permissao estao desabilitadas.');
        }

        // so o campo permission_id pode ser alterado, e precisa existir de verdade
        $dados = $request->validate([
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);
        model_has_permission::where('model_id', $id)->update(['permission_id' => $dados['permission_id']]);

        return redirect()->route('paciente.permission')->with('paciente', 'Permissao atualizada com sucesso!');
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
        Patient::onlyTrashed()->findOrFail($id)->restore();
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
        return redirect()->route('paciente.view', $patient->id)->with('paciente', 'Atendimento registrado no historico.');
    }

    public function historicoPdf($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $atendimentos = $patient->atendimentos()->get();
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

        // concede admin apenas a e-mails autorizados (staff da clinica)
        $isAdmin = in_array($email, $this->adminsAutorizados(), true);
        if ($isAdmin) {
            $perm = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            $user->givePermissionTo($perm); // idempotente: nao duplica se ja tiver
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        Auth::login($user, true);

        return redirect($isAdmin ? route('paciente.index') : route('paciente.homeScreen'));
    }
}
