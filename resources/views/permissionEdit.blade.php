@extends('layout')
@section('title','Editar permissão · Clínica ULBRA')
@section('content')

<div class="section-head">
  <div>
    <h1>Editar permissão</h1>
    <p class="muted"><a class="link" href="{{ route('paciente.permission') }}">Voltar às permissões</a></p>
  </div>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $erro)<div>{{ $erro }}</div>@endforeach
  </div>
@endif

@foreach($data as $item)
<div class="card" style="margin-bottom:14px">
  <form action="{{ route('paciente.permission.update', $item->model_id) }}" method="post">
    @csrf
    @method('put')
    <p class="muted" style="margin-top:0">Usuário ID <b>{{ $item->model_id }}</b></p>
    <div class="form-grid">
      <div class="field">
        <label>Permissão (1 = administrador, 2 = usuário comum)</label>
        <input class="input" type="number" name="permission_id" value="{{ $item->permission_id }}" min="1" required>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
@endforeach

@endsection
