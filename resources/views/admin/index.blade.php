@extends('layout')
@section('title','dashboard' )
@section('content')

<div class="nav px-5 d-flex align-items-center justify-content-between">
  <a href="{{ route('paciente.home') }}"><img src="/img/ulbra.png" alt="" width="100" height="100"></a>
  <form action="{{route('paciente.index')}}" class="d-flex" role="search" method="GET">
  <input class="form-control me-2 " style="width: 500px; padding: 10px;" type="search" name="search" placeholder="Buscar" aria-label="Search">
  <button class="btn btn-warning" type="submit">Buscar</button>
  </form>
  <div class="dropdown">
      <button class="dropdown-toggle d-flex style-menu " style=" border: none; background: none;" data-bs-toggle="dropdown" aria-expanded="false">
        <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="cea-cea-store-theme-0-x-header-login__icon">
        <path d="M42 42C42 39.8988 41.5344 37.8183 40.6298 35.8771C39.7252 33.9359 38.3994 32.172 36.7279 30.6863C35.0565 29.2006 33.0722 28.022 30.8883 27.2179C28.7044 26.4139 26.3638 26 24 26C21.6362 26 19.2956 26.4139 17.1117 27.2179C14.9278 28.022 12.9435 29.2006 11.2721 30.6863C9.60062 32.172 8.27475 33.9359 7.37017 35.8771C6.46558 37.8183 6 39.8988 6 42" stroke="#212B36" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
        <circle cx="24" cy="16" r="10" stroke="#212B36" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></circle>
        </svg>
        <div>
          @guest
            <p style="font-size:15px ; margin-left:4px;">Entrar</p>
          @endguest
          @Auth
          <p style="font-size:15px ; margin-left:4px;">Bem vindo, <br> {{ Auth::user()->name }}</p>
          @endAuth
        </div>
      </button>
      <ul class="dropdown-menu">
        
        <form action="/logout" method="post">
          @csrf
          <div class=" list-group">
            @guest
              <a href="/login" class="text-black text-decoration-none"><li><button class="dropdown-item " type="button">login</button></li></a>
            @endguest
          
            <a href=" /logout" class="list-group-item list-group-item-action" onclick="event.preventDefault();
            this.closest('form').submit();"> Sair</a>
          </div>
          </ul>
        </form>
      </ul>
    </div>
</div>

<div class="text-center">
  <h1 class="py-3">dashboard/<a href="/paciente/permission">Permission</a></h1>
  <h4>Pacientes Cadastrados</h4>
</div>
<div class="px-5">
  <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">Nome</th>
          <th scope="col">idade</th>
          <th scope="col">cidade</th>
          <th scope="col">motivo</th>
          <th scope="col" class="text-center">ações</th>
  
        </tr>
      </thead>
      <tbody>
  
        @foreach($patient as $patient)
        <tr>
          <td>
            <p>{{ $patient->name }}</p>
          </td>
          <td>
            <?php
              $data = $patient->birth_date;

              // separando yyyy, mm, ddd
              list($ano, $mes, $dia) = explode('-', $data);

              // data atual
              $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
              // Descobre a unix timestamp da data de nascimento do fulano
              $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

              // cálculo
              $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            ?>
            <p>{{ $idade }}</p>
          </td>
          <td>
            <p>{{ $patient->city }}</p>
          </td>
          <td>
            <p>{{ $patient->consultation }}</p>
          </td>
          <td class="text-center">
            <form action="{{route('paciente.destroy',$patient->id)}}" method="post">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger">deletar</button>
              <a href="{{route('paciente.edit',$patient->id)}}" class="btn btn-primary">editar</a>
              <a href="{{route('paciente.view',$patient->id)}}" class="btn btn-info">Visualizar</a>
              <a href="{{route('paciente.generatePdf',$patient->id)}}" target="_blank" class="btn btn-warning">imprimir</a>
          </td>
        </tr>
        @endforeach
  
      </tbody>
    </table>
</div>

<style>
  .nav {
    background-color: #585dd6;
  }
  .style-menu {
    align-items: center;
  }
</style>
@endsection