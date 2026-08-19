<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\model_has_permission;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

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

    public function store(Request $request)
    {
        if (config('app.demo')) {
            return back()->with('paciente', 'Modo demonstracao: os cadastros nao sao salvos nesta versao publica.');
        }

        // honeypot anti-spam: campo escondido que so bot preenche
        if ($request->filled('website')) {
            return back();
        }

        // consentimento LGPD obrigatorio
        $request->validate(['consentimento' => 'accepted'], [
            'consentimento.accepted' => 'E necessario concordar com o uso dos dados para continuar.',
        ]);

        // validacao server-side de todos os campos
        $dados = $request->validate($this->regras());

        $patient = Patient::create($dados);

        $data = [
            'name'         => $patient->name,
            'birth_date'   => $patient->birth_date,
            'time_service' => $patient->time_service,
            'consultation' => $patient->consultation,
        ];
        Mail::to(config('mail.from.address'))->send(new SendMail($data));

        return redirect()->route('paciente.home')->with('paciente', 'Cadastro feito com sucesso!');
    }

    public function destroy($id)
    {
        if (config('app.demo')) {
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
        if (config('app.demo')) {
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
        if (config('app.demo')) {
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
        if (config('app.demo')) {
            return back()->with('paciente', 'Modo demonstracao: acoes estao desabilitadas.');
        }
        Patient::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('paciente.index')->with('paciente', 'Paciente restaurado com sucesso.');
    }
}
