@extends('layout')
@section('title','Entrar · Clínica ULBRA')
@section('content')

<div class="auth-wrap">
  <div class="card auth-card">
    <div class="auth-head">
      <img class="auth-logo" src="/img/ulbra.png" alt="ULBRA">
      <h1>Entrar</h1>
      <p class="muted">Acesse o painel da Clínica Escola</p>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $erro)
          <div>{{ $erro }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="field">
        <label for="email">E-mail</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="field">
        <label for="password">Senha</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="current-password">
      </div>

      <div class="field-row">
        <label class="check"><input type="checkbox" name="remember"> Lembrar de mim</label>
        <a class="link" href="{{ route('password.request') }}">Esqueceu a senha?</a>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>

    <div style="display:flex;align-items:center;gap:10px;margin:16px 0;color:var(--muted);font-size:.85rem">
      <span style="flex:1;height:1px;background:var(--border)"></span>ou<span style="flex:1;height:1px;background:var(--border)"></span>
    </div>
    <a class="btn btn-ghost btn-block" href="{{ route('google.redirect') }}">Entrar com Google</a>

    <div class="demo-hint">
      <b>Acesso de demonstração</b><br>
      admin@demo.com &middot; senha1234
    </div>
  </div>
</div>

@endsection
