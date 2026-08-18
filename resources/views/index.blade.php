@extends('layout')
@section('scriptsjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function() {
  $('#cpf').mask('000.000.000-00');
  $('#rg').mask('00.000.000-0');
  $('#phone').mask('(00) 00000-0000');
  $('#hora').mask('00:00 horas');
})
</script>
@endsection
@section('title','home' )
@section('content')

  <div class="nav px-5 d-flex align-items-center justify-content-between">
    <a href="{{ route('paciente.home') }}"><img src="/img/ulbra.png" alt="" width="100" height="100"></a>
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
            @can('admin')
              <a href="{{ route('paciente.index') }}" class="text-black text-decoration-none"><li><button class="dropdown-item" type="button">admin</button></li></a>
            @endcan
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
  @if(session()->has('paciente'))
    <div class="alert alert-success text-center">
      <strong>{{session()->get('paciente')}}</strong>

    </div>
  @endif
  <div class="text-center py-3">
    <h1>Formulario</h1>
  </div>

<div class="px-5 mb-5">
  <form action="/paciente/store" method="post" style="display: flex; flex-direction:column;">
    @csrf
    {{-- honeypot anti-spam: humano nao ve nem preenche este campo --}}
    <input type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;height:0;width:0;opacity:0">
    <div class="d-flex">
      <div class="mb-3 w-50">
        <label class="form-label"> Nome Completo*</label>
        <input type="text" name="name" placeholder="Ex. Eduardo da costa" class="form-control" required>
      </div>
  
      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> Data de Nascimento*</label>
        <input type="date" name="birth_date" id="age" placeholder="Ex. 10/10/2020" id="idade" class="form-control" required>
      </div>

      <div  class="mb-3 w-25 ms-2">
        <label  class="form-label"> Estado civil</label>
        <input type="text" name="marital_status" placeholder="Ex. solteiro" class="form-control">
      </div>
    </div>
    <div class="popup permission" >
      <div  class="mb-3 w-50">
        <label  class="form-label"> Responsável </label>
        <input id="input1" type="text" name="name_father" placeholder="Ex. Seu Pai" class="form-control" >
      </div>
  
      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> Endereco do Responsável </label>
        <input id="input2" type="text" name="address_father" placeholder="Ex. Rua candelaria" class="form-control">
      </div>
  
      <div  class="mb-3 w-25">
        <label  class="form-label"> Cidade do Responsável </label>
        <input id="input3" type="text" name="city_father" placeholder="Ex. Rio do sul" class="form-control" >
      </div>
    </div>

    <div class="d-flex">
      <div class="mb-3 w-25">
        <label  class="form-label"> Telefone*</label>
        <input type="text" name="telephone" placeholder="Ex: (00) 00000-0000" id="phone" class="form-control" required>
      </div>

      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> RG*</label>
        <input type="text" name="rg" placeholder="Ex: 43.234.343-6" id="rg" class="form-control" required>
      </div>

      <div class="mb-3 w-25">
        <label  class="form-label"> CPF*</label>
        <input type="text" name="cpf" placeholder="Ex: 234.543.123.09" id="cpf" class="form-control" required>
      </div>

    </div>

    <div class="d-flex">
      <div class="mb-3 w-25">
        <label  class="form-label"> Endereco*</label>
        <input type="text" name="address" placeholder="Ex. Rua candelaria " class="form-control" required>
      </div>
  
      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> complemento*</label>
        <input type="text" name="Complement" placeholder="Ex. casa 1 " class="form-control" required>
      </div>

      <div class="mb-3 w-25">
        <label  class="form-label"> Numero da casa*</label>
        <input type="text" name="house_number" placeholder="Ex. 14" class="form-control" required>
      </div>

      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> Cidade*</label>
        <input type="text" name="city" placeholder="Ex. Rio branco" class="form-control" required>
      </div>

      <div class="mb-3 w-25">
        <label  class="form-label"> Bairro*</label>
        <input type="text" name="district" placeholder="Ex. lagoinha" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label  class="form-label"> horário para atendimento*</label>
      <input type="string" name="time_service" placeholder="Ex. 14:00" id="hora" class="form-control" required>
    </div>

    <div class="mb-3">
      <label  class="form-label"> Motivo da Consulta*</label>
      <textarea name="consultation" class="form-control" placeholder="Ex. Ansiedade" required></textarea>
    </div>

    <button type="submit" class="btn btn-dark"> Enviar</button>

  </form>
</div>

<style>
.nav {
  background-color: #585dd6;
}
.dropdown-toggle::after {
  display: none;
}
.permission {
  display: none;
}
.style-menu {
  align-items: center;
}
</style>
@endsection