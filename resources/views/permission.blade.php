@extends('layout')
@section('title','Permissões · Clínica ULBRA')
@section('content')

<div class="section-head">
  <div>
    <h1>Permissões</h1>
    <p class="muted">Painel administrativo &middot; <a class="link" href="{{ route('paciente.index') }}">Voltar aos pacientes</a></p>
  </div>
</div>

<div class="alert" style="background:var(--surface-2);border-color:var(--border);color:var(--muted)">
  <b>Observação:</b> permissão <b>1 = administrador</b>; permissão <b>2 = usuário comum</b>.
</div>

<h2 style="font-size:1.15rem;margin:24px 0 10px">Permissões atribuídas</h2>
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>Permissão</th><th>ID do usuário</th><th>Ações</th></tr>
    </thead>
    <tbody>
      @foreach($permission as $perm)
      <tr>
        <td>{{ $perm->permission_id }}</td>
        <td>{{ $perm->model_id }}</td>
        <td><a class="btn btn-soft btn-sm" href="{{ route('paciente.permission.edit',$perm->model_id) }}">Editar</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<h2 style="font-size:1.15rem;margin:28px 0 10px">Usuários cadastrados</h2>
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>ID</th><th>Nome</th><th>E-mail</th></tr>
    </thead>
    <tbody>
      @foreach($user as $u)
      <tr><td>{{ $u->id }}</td><td>{{ $u->name }}</td><td>{{ $u->email }}</td></tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
