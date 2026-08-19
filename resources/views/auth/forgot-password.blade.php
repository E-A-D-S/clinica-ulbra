@extends('layout')
@section('title','Recuperar senha · Clínica ULBRA')
@section('content')

<div class="auth-wrap">
  <div class="card auth-card">
    <div class="auth-head">
      <img class="auth-logo" src="/img/ulbra.png" alt="ULBRA">
      <h1>Recuperar senha</h1>
      <p class="muted">Informe seu e-mail e enviaremos um link para você criar uma nova senha.</p>
    </div>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $erro)<div>{{ $erro }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="field"><label for="email">E-mail</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus></div>
      <button type="submit" class="btn btn-primary btn-block">Enviar link de recuperação</button>
    </form>

    <p class="auth-alt"><a class="link" href="{{ route('login') }}">Voltar ao login</a></p>
  </div>
</div>

@endsection
