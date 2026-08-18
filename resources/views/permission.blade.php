@extends('layout')
@section('title','permission' )
@section('content')
<div class="nav px-5 d-flex align-items-center justify-content-between">
  <a href="{{ route('paciente.home') }}"><img src="/img/ulbra.png" alt="" width="100" height="100"></a>
  <a href="{{ route('paciente.index') }}" class="text-white">Voltar</a>
</div>

<div class="text-center">
  <h1 class="py-3"><a href="/paciente">dashboard</a>/Permission</h1>
</div>
<h4 style="margin-left:80px ; margin-top: 50px;">OBS: usuarios com permission_id igual a 1 são admim e se for 2 são usuarios normal.. </h4>
<div class="px-5">
  <table class="table table-dark table-striped">
      <thead>
        <tr>
  
          <th scope="col">permission_id (numeros das pemissões como esta no obs acima)</th>
          <th scope="col">model_id (E o id do usuario cadastrado) </th>
          <th scope="col" class="text-center">ações</th>
  
        </tr>
      </thead>
      <tbody>
  
        @foreach($permission as $permission)
        <tr>
          <td>
            <p>{{ $permission->permission_id }}</p>
          </td>
          <td>
            <p>{{ $permission->model_id }}</p>
          </td>
          <td class="text-center">
           <a href="{{route('paciente.permission.edit',$permission->model_id)}}" class="btn btn-primary">editar</a>
          </td>
        </tr>
        @endforeach
  
      </tbody>
    </table>
</div>
<div class="text-center">
  <h1 class="py-3">Usuarios cadastrados</h1>
</div>
<div class="px-5">
  <table class="table table-dark table-striped">
      <thead>
        <tr>
  
          <th scope="col">id</th>
          <th scope="col">name</th>
          <th scope="col" class="text-center">E-mail</th>
  
        </tr>
      </thead>
      <tbody>
  
        @foreach($user as $user)
        <tr>
          <td>
            <p>{{ $user->id }}</p>
          </td>
          <td>
            <p>{{ $user->name }}</p>
          </td>
          <td class="text-center">
           <p>{{ $user->email }}</p>
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
</style>
@endsection