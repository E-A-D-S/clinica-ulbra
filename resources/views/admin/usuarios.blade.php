@extends('layout')
@section('title','Equipe · Acessos')
@section('content')

<div class="section-head">
  <div>
    <h1>Equipe</h1>
    <p class="muted">Gestão de acessos por papel &middot; <a class="link" href="{{ route('paciente.index') }}">Voltar ao painel</a></p>
  </div>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $erro)<div>{{ $erro }}</div>@endforeach
  </div>
@endif

<div class="card" style="margin-bottom:18px">
  <h2 style="margin:0 0 12px">Liberar novo acesso</h2>
  <p class="muted" style="margin:0 0 14px">
    Informe o e-mail e o papel. A pessoa entra com o Google nesse e-mail e já recebe o acesso.
    @unless($ehDono)<br>Como tutor, você pode liberar acesso de <b>estagiário</b>.@endunless
  </p>
  <form action="{{ route('paciente.usuarios.store') }}" method="post">
    @csrf
    <div class="form-grid">
      <div class="field">
        <label for="email">E-mail (conta Google)</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="pessoa@gmail.com">
      </div>
      <div class="field">
        <label for="role">Papel</label>
        <select class="input" id="role" name="role" required>
          @if($ehDono)<option value="tutor">Tutor (professor/supervisor)</option>@endif
          <option value="estagiario">Estagiário</option>
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Liberar acesso</button>
  </form>
</div>

@if(count($autorizados) === 0)
  <div class="card"><p class="muted" style="margin:0">Nenhum acesso liberado ainda.</p></div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>E-mail</th><th>Papel</th><th>Status</th><th>Ações</th></tr>
    </thead>
    <tbody>
      @foreach($autorizados as $a)
      <tr>
        <td>{{ $a->email }}</td>
        <td><span class="tag">{{ \App\Support\Rbac::rotulo($a->role) }}</span></td>
        <td>
          @if($a->active)
            <span style="color:var(--ok,#16a34a)">Ativo</span>
          @else
            <span class="muted">Inativo</span>
          @endif
        </td>
        <td>
          @if(in_array($a->email, ['clinicaescolasj@gmail.com','eduardoeko7@gmail.com'], true))
            <span class="muted">Dono principal (protegido)</span>
          @else
          <div class="row-actions">
            <form action="{{ route('paciente.usuarios.toggle',$a->id) }}" method="post" style="display:inline">
              @csrf @method('put')
              <button type="submit" class="btn btn-soft btn-sm">{{ $a->active ? 'Desativar' : 'Ativar' }}</button>
            </form>
            <form action="{{ route('paciente.usuarios.destroy',$a->id) }}" method="post" onsubmit="return confirm('Remover o acesso de {{ $a->email }}?')" style="display:inline">
              @csrf @method('delete')
              <button type="submit" class="btn btn-soft btn-sm">Remover</button>
            </form>
          </div>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@endsection
