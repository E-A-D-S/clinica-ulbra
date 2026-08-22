<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <title>@yield('title', 'Clínica ULBRA')</title>
  <script>try{var t=localStorage.getItem('tema');if(t)document.documentElement.setAttribute('data-theme',t);}catch(e){}</script>
  <link rel="stylesheet" href="/css/app.css">
  @yield('scriptsjs')
</head>
<body>
  <header class="topbar">
    <div class="container topbar-inner">
      <a class="brand" href="{{ route('paciente.homeScreen') }}">
        <img class="brand-logo" src="/img/ulbra.png" alt="ULBRA">
        <span>Clínica <b>ULBRA</b></span>
      </a>
      <nav class="topbar-actions">
        @auth
          @can('admin')
            <a class="btn btn-ghost btn-sm" href="{{ route('paciente.index') }}">Painel</a>
          @endcan
          <form action="/logout" method="post" style="display:inline">
            @csrf
            <button class="btn btn-ghost btn-sm" type="submit">Sair</button>
          </form>
        @else
          <a class="btn btn-ghost btn-sm" href="/login">Entrar</a>
        @endauth
        <button class="theme-toggle" type="button" onclick="alternarTema()" aria-label="Alternar tema claro e escuro" title="Alternar tema">
          <span class="theme-icon">🌙</span>
        </button>
      </nav>
    </div>
  </header>

  <main class="container main">
    @if(session()->has('paciente'))
      <div class="alert alert-success">{{ session()->get('paciente') }}</div>
    @endif
    @yield('content')
  </main>

  <footer class="footer">
    <div class="container">Clínica Escola ULBRA &middot; Sistema de gestão de pacientes</div>
  </footer>

  <!-- VLibras: tradutor de Libras (acessibilidade, widget oficial do governo) -->
  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper><div class="vw-plugin-top-wrapper"></div></div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

  <script src="/js/app.js"></script>
  <script src="/js/agePermission.js"></script>
  @yield('scripts')
</body>
</html>
