@extends('layout')
@section('title','Paciente · '.$patient->name)
@section('content')

<div class="section-head">
  <div>
    <h1>{{ $patient->name }}</h1>
    <p class="muted">Ficha do paciente</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a class="btn btn-primary" href="{{ route('paciente.generatePdf',$patient->id) }}" target="_blank">Imprimir contrato</a>
    <a class="btn btn-ghost" href="{{ route('paciente.index') }}">Voltar</a>
  </div>
</div>

<div class="card">
  <div class="detail-grid">
    <div><span class="dt-label">Idade</span><span class="dt-val">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} anos</span></div>
    <div><span class="dt-label">Nascimento</span><span class="dt-val">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}</span></div>
    <div><span class="dt-label">Estado civil</span><span class="dt-val">{{ $patient->marital_status ?: '—' }}</span></div>
    <div><span class="dt-label">Telefone</span><span class="dt-val">{{ $patient->telephone }}</span></div>
    <div><span class="dt-label">RG</span><span class="dt-val">{{ $patient->rg }}</span></div>
    <div><span class="dt-label">CPF</span><span class="dt-val">{{ $patient->cpf }}</span></div>
    <div><span class="dt-label">Endereço</span><span class="dt-val">{{ $patient->address }}, {{ $patient->house_number }} &middot; {{ $patient->district }}</span></div>
    <div><span class="dt-label">Cidade</span><span class="dt-val">{{ $patient->city }}</span></div>
    <div><span class="dt-label">Horário de preferência</span><span class="dt-val">{{ $patient->time_service }}</span></div>
    @if(\Carbon\Carbon::parse($patient->birth_date)->age < 18)
      <div><span class="dt-label">Responsável</span><span class="dt-val">{{ $patient->name_father ?: '—' }}</span></div>
    @endif
  </div>

  <div style="margin-top:20px">
    <span class="dt-label">Motivo da consulta</span>
    <p style="margin:6px 0 0">{{ $patient->consultation }}</p>
  </div>
</div>

@endsection
