@extends('layout')
@section('title','permission' )
@section('content')
<div class="nav px-5 d-flex align-items-center justify-content-between">
  <a href="{{ route('paciente.home') }}"><img src="/img/ulbra.png" alt="" width="100" height="100"></a>
  <a href="{{ route('paciente.index') }}" class="text-white">Voltar</a>
</div>
@foreach($data as $data)
<div class="text-center py-3">
  <h1>id do usuario: {{ $data->model_id }} </h1>
</div>
<div class="px-5 mb-5">
  <form action="{{route('paciente.permission.update', $data->model_id)}}"  method="post" style="display:flex; flex-direction:column;">
    @csrf
    @method('put')
    <div class="d-flex">
      <div class="mb-3 w-50">
        <label class="form-label"> id da permission </label>
        <input type="text" name="permission_id"  value="{{ $data->permission_id }}" class="form-control">
      </div>
  
      <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> id do usuario </label>
        <input type="text" name="model_id"   value="{{ $data->model_id }}" id="idade" class="form-control" disabled>
      </div>
    <button type="submit" class="btn btn-dark">Salvar</button>

  </form>
</div>
@endforeach
<style>
  .nav {
    background-color: #585dd6;
  }
</style>
@endsection