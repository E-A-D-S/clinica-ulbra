@extends('layout')
@section('title','Painel · Pacientes')
@section('content')

<div class="section-head">
  <div>
    <h1>Pacientes cadastrados</h1>
    <p class="muted">Painel administrativo &middot; <a class="link" href="{{ route('paciente.permission') }}">Permissões</a></p>
  </div>
  <form class="search-form" action="{{ route('paciente.index') }}" method="GET" role="search">
    <input class="input" type="search" name="search" value="{{ request('search') }}" placeholder="Buscar por nome">
    <button class="btn btn-primary" type="submit">Buscar</button>
  </form>
</div>

@if(count($patient) === 0)
  <div class="card"><p class="muted" style="margin:0">Nenhum paciente encontrado.</p></div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Cidade</th>
        <th>Motivo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($patient as $p)
      <tr>
        <td>{{ $p->name }}</td>
        <td>{{ \Carbon\Carbon::parse($p->birth_date)->age }}</td>
        <td>{{ $p->city }}</td>
        <td>{{ $p->consultation }}</td>
        <td>
          <div class="row-actions">
            <a class="btn btn-soft btn-sm" href="{{ route('paciente.view',$p->id) }}">Ver</a>
            <a class="btn btn-soft btn-sm" href="{{ route('paciente.edit',$p->id) }}">Editar</a>
            <a class="btn btn-soft btn-sm" href="{{ route('paciente.generatePdf',$p->id) }}" target="_blank">Imprimir</a>
            <form action="{{ route('paciente.destroy',$p->id) }}" method="post" onsubmit="return confirm('Excluir este paciente?')" style="display:inline">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
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
