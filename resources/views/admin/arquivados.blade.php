@extends('layout')
@section('title','Arquivados · Clínica ULBRA')
@section('content')

<div class="section-head">
  <div>
    <h1>Pacientes arquivados</h1>
    <p class="muted">Registros mantidos por obrigação legal de guarda de prontuário (Resolução CFP 001/2009). Podem ser restaurados, nunca são apagados.</p>
  </div>
  <a class="btn btn-ghost" href="{{ route('paciente.index') }}">Voltar ao painel</a>
</div>

@if(count($patient) === 0)
  <div class="card"><p class="muted" style="margin:0">Nenhum paciente arquivado.</p></div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>Nome</th><th>Idade</th><th>Cidade</th><th>Arquivado em</th><th>Ações</th></tr>
    </thead>
    <tbody>
      @foreach($patient as $p)
      <tr>
        <td>{{ $p->name }}</td>
        <td>{{ \Carbon\Carbon::parse($p->birth_date)->age }}</td>
        <td>{{ $p->city }}</td>
        <td>{{ \Carbon\Carbon::parse($p->deleted_at)->format('d/m/Y') }}</td>
        <td>
          <div class="row-actions">
            <a class="btn btn-soft btn-sm" href="{{ route('paciente.generatePdf',$p->id) }}" target="_blank">Imprimir</a>
            <form action="{{ route('paciente.restaurar',$p->id) }}" method="post" style="display:inline">
              @csrf
              @method('put')
              <button type="submit" class="btn btn-primary btn-sm">Restaurar</button>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@endsection
