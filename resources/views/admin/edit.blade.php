@extends('layout')
@section('title','Editar · '.$patient->name)
@section('content')

<div class="section-head">
  <div>
    <h1>Editar paciente</h1>
    <p class="muted">{{ $patient->name }}</p>
  </div>
  <a class="btn btn-ghost" href="{{ route('paciente.index') }}">Voltar</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $erro)
      <div>{{ $erro }}</div>
    @endforeach
  </div>
@endif

<div class="card">
  <form action="{{ route('paciente.update',$patient->id) }}" method="post">
    @csrf
    @method('put')

    <div class="form-grid">
      <div class="field"><label>Nome completo</label><input class="input" name="name" value="{{ old('name',$patient->name) }}" required></div>
      <div class="field"><label>Data de nascimento</label><input class="input" type="date" name="birth_date" value="{{ old('birth_date',$patient->birth_date) }}" required></div>
      <div class="field"><label>Estado civil</label><input class="input" name="marital_status" value="{{ old('marital_status',$patient->marital_status) }}"></div>
    </div>

    <div class="form-grid">
      <div class="field"><label>Telefone</label><input class="input" name="telephone" value="{{ old('telephone',$patient->telephone) }}" data-mask="(00) 00000-0000" required></div>
      <div class="field"><label>RG</label><input class="input" name="rg" value="{{ old('rg',$patient->rg) }}" data-mask="00.000.000-0" required></div>
      <div class="field"><label>CPF</label><input class="input" name="cpf" value="{{ old('cpf',$patient->cpf) }}" data-mask="000.000.000-00" required></div>
    </div>

    <div class="form-grid">
      <div class="field"><label>Endereço</label><input class="input" name="address" value="{{ old('address',$patient->address) }}" required></div>
      <div class="field"><label>Complemento</label><input class="input" name="Complement" value="{{ old('Complement',$patient->Complement) }}" required></div>
      <div class="field"><label>Número</label><input class="input" name="house_number" value="{{ old('house_number',$patient->house_number) }}" required></div>
      <div class="field"><label>Cidade</label><input class="input" name="city" value="{{ old('city',$patient->city) }}" required></div>
      <div class="field"><label>Bairro</label><input class="input" name="district" value="{{ old('district',$patient->district) }}" required></div>
    </div>

    <div class="form-grid">
      <div class="field"><label>Horário de preferência</label><input class="input" name="time_service" value="{{ old('time_service',$patient->time_service) }}" data-mask="00:00" required></div>
    </div>

    <div class="field"><label>Motivo da consulta</label><textarea class="input" name="consultation" required>{{ old('consultation',$patient->consultation) }}</textarea></div>

    <div class="form-grid">
      <div class="field"><label>Nome do responsável</label><input class="input" name="name_father" value="{{ old('name_father',$patient->name_father) }}"></div>
      <div class="field"><label>Endereço do responsável</label><input class="input" name="address_father" value="{{ old('address_father',$patient->address_father) }}"></div>
      <div class="field"><label>Cidade do responsável</label><input class="input" name="city_father" value="{{ old('city_father',$patient->city_father) }}"></div>
    </div>

    <div style="margin-top:8px">
      <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </div>
  </form>
</div>

@endsection
