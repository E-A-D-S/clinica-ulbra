@extends('layout')
@section('title','Auditoria')
@section('content')

<div class="section-head">
  <div>
    <h1>Auditoria</h1>
    <p class="muted">Registro de ações da equipe &middot; <a class="link" href="{{ route('paciente.index') }}">Voltar ao painel</a></p>
  </div>
</div>

@php
  $rotulosAcao = [
    'paciente.cadastrar' => 'Cadastrou paciente',
    'paciente.editar' => 'Editou paciente',
    'paciente.arquivar' => 'Arquivou paciente',
    'paciente.restaurar' => 'Restaurou paciente',
    'atendimento.registrar' => 'Registrou atendimento',
    'paciente.imprimir.ficha' => 'Imprimiu ficha/contrato',
    'paciente.imprimir.historico' => 'Imprimiu histórico',
    'usuario.autorizar' => 'Liberou acesso',
    'usuario.status' => 'Alterou status de acesso',
    'usuario.remover' => 'Removeu acesso',
  ];
@endphp

@if(count($logs) === 0)
  <div class="card"><p class="muted" style="margin:0">Nenhum registro de auditoria ainda.</p></div>
@else
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr><th>Data e hora</th><th>Quem</th><th>Ação</th><th>Detalhe</th><th>IP</th></tr>
    </thead>
    <tbody>
      @foreach($logs as $log)
      <tr>
        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
        <td>
          {{ $log->user_email ?: '—' }}
          @if($log->user_role)<br><span class="tag">{{ \App\Support\Rbac::rotulo($log->user_role) }}</span>@endif
        </td>
        <td>{{ $rotulosAcao[$log->action] ?? $log->action }}</td>
        <td class="muted">{{ $log->description }}@if($log->subject_id) (paciente #{{ $log->subject_id }})@endif</td>
        <td class="muted">{{ $log->ip }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<p class="muted" style="margin-top:12px">Mostrando os {{ count($logs) }} registros mais recentes.</p>
@endif

@endsection
