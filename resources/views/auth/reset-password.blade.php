@extends('layout')
@section('title','Redefinir senha · Clínica ULBRA')
@section('content')

<div class="auth-wrap">
  <div class="card auth-card">
    <div class="auth-head">
      <img class="auth-logo" src="/img/ulbra.png" alt="ULBRA">
      <h1>Redefinir senha</h1>
      <p class="muted">Escolha uma nova senha para sua conta.</p>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $erro)<div>{{ $erro }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="field"><label for="email">E-mail</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus></div>

      <div class="field"><label for="password">Nova senha</label>
        <input class="input" id="password" type="password" name="password" required autocomplete="new-password"></div>

      <div class="field"><label for="password_confirmation">Confirmar nova senha</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>

      <button type="submit" class="btn btn-primary btn-block">Redefinir senha</button>
    </form>
  </div>
</div>

@endsection
