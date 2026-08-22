@extends('layout')
@section('title','Paciente · '.$patient->name)
@section('content')

<div class="section-head">
  <div>
    <h1>{{ $patient->name }}</h1>
    <p class="muted">Ficha do paciente</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    @can('pacientes.imprimir')
    <a class="btn btn-primary" href="{{ route('paciente.generatePdf',$patient->id) }}" target="_blank">Imprimir contrato</a>
    <a class="btn btn-soft" href="{{ route('paciente.historico',$patient->id) }}" target="_blank">Imprimir histórico</a>
    @endcan
    <a class="btn btn-ghost" href="{{ route('paciente.index') }}">Voltar</a>
  </div>
</div>

<div class="card">
  <div class="detail-grid">
    <div><span class="dt-label">Idade</span><span class="dt-val">{{ \Carbon\Carbon::parse($patient->birth_date)->age }} anos</span></div>
    <div><span class="dt-label">Nascimento</span><span class="dt-val">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}</span></div>
    <div><span class="dt-label">Estado civil</span><span class="dt-val">{{ $patient->marital_status ?: '—' }}</span></div>
    <div><span class="dt-label">E-mail</span><span class="dt-val">{{ $patient->email ?: '—' }}</span></div>
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

<div class="section-head" style="margin-top:34px">
  <h2 style="margin:0">Histórico de atendimentos</h2>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $erro)<div>{{ $erro }}</div>@endforeach
  </div>
@endif

@can('atendimentos.registrar')
@if(optional(auth()->user())->email !== 'admin@demo.com')
<div class="card" style="margin-bottom:18px">
  <form action="{{ route('paciente.atendimento.store',$patient->id) }}" method="post">
    @csrf
    <div class="form-grid">
      <div class="field"><label>Data e hora *</label><input class="input" type="datetime-local" name="data_hora" value="{{ old('data_hora') }}" required></div>
      <div class="field"><label>Profissional / estagiário</label><input class="input" name="profissional" value="{{ old('profissional') }}"></div>
    </div>
    <div class="field"><label>Anotações da sessão *</label><textarea class="input" name="anotacoes" required>{{ old('anotacoes') }}</textarea></div>
    <button type="submit" class="btn btn-primary">Registrar atendimento</button>
  </form>
</div>
@endif
@endcan

@if($patient->atendimentos->count() === 0)
  <div class="card"><p class="muted" style="margin:0">Nenhum atendimento registrado ainda.</p></div>
@else
  @foreach($patient->atendimentos as $at)
  <div class="card" style="margin-bottom:12px">
    <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px">
      <b>{{ \Carbon\Carbon::parse($at->data_hora)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($at->data_hora)->format('H:i') }}</b>
      @if($at->profissional)<span class="muted">{{ $at->profissional }}</span>@endif
    </div>
    <p style="margin:8px 0 0;white-space:pre-line">{{ $at->anotacoes }}</p>
  </div>
  @endforeach
@endif

@endsection
