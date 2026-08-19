@extends('layout')
@section('title','Criar conta · Clínica ULBRA')
@section('content')

<div class="auth-wrap">
  <div class="card auth-card">
    <div class="auth-head">
      <img class="auth-logo" src="/img/ulbra.png" alt="ULBRA">
      <h1>Criar conta</h1>
      <p class="muted">Cadastro de acesso ao sistema</p>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $erro)
          <div>{{ $erro }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="field"><label for="name">Nome</label>
        <input class="input" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"></div>

      <div class="field"><label for="email">E-mail</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required></div>

      <div class="field"><label for="password">Senha</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="new-password"></div>

      <div class="field"><label for="password_confirmation">Confirmar senha</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <label class="check" style="margin-bottom:16px">
          <input type="checkbox" name="terms" id="terms" required>
          <span>Concordo com os <a class="link" target="_blank" href="{{ route('terms.show') }}">Termos de Serviço</a> e a <a class="link" target="_blank" href="{{ route('policy.show') }}">Política de Privacidade</a></span>
        </label>
      @endif

      <button type="submit" class="btn btn-primary btn-block">Criar conta</button>
    </form>

    <p class="auth-alt">Já tem conta? <a class="link" href="{{ route('login') }}">Entrar</a></p>
  </div>
</div>

@endsection
