<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
  @page { margin: 70px 55px; }
  * { font-family: "DejaVu Sans", sans-serif; }
  body { font-size: 11px; color: #111; line-height: 1.5; }
  .header { width: 100%; border-collapse: collapse; }
  .logo { width: 70px; height: 70px; }
  .inst .t1 { font-weight: bold; font-size: 12px; }
  .inst .t2 { font-size: 10px; }
  h2 { text-align: center; font-size: 13px; margin: 16px 0 6px; }
  .paciente { text-align: center; font-size: 11px; margin-bottom: 16px; color:#333; }
  .sessao { border: 1px solid #ccc; border-radius: 6px; padding: 10px 12px; margin-bottom: 10px; }
  .sessao .data { font-weight: bold; margin: 0 0 4px; }
  .sessao p { margin: 0; }
  .rodape { margin-top: 24px; text-align: center; font-size: 9px; color: #777; }
</style>
</head>
<body>

<table class="header">
  <tr>
    <td style="width: 84px;"><img class="logo" src="{{ public_path('img/ulbra.png') }}" alt="ULBRA"></td>
    <td class="inst" style="text-align: center;">
      <div class="t1">UNIVERSIDADE LUTERANA DO BRASIL</div>
      <div class="t2">Serviço Escola de Psicologia · Clínica Escola</div>
    </td>
    <td style="width: 84px;"></td>
  </tr>
</table>

<h2>HISTÓRICO DE ATENDIMENTOS</h2>
<div class="paciente">
  <strong>Paciente:</strong> {{ $patient->name }} &nbsp;·&nbsp; <strong>CPF:</strong> {{ $patient->cpf }} &nbsp;·&nbsp; <strong>RG:</strong> {{ $patient->rg }}
</div>

@if($atendimentos->count() === 0)
  <p style="text-align:center;color:#666">Nenhum atendimento registrado até o momento.</p>
@else
  @foreach($atendimentos as $at)
  <div class="sessao">
    <p class="data">{{ \Carbon\Carbon::parse($at->data_hora)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($at->data_hora)->format('H:i') }}@if($at->profissional) &nbsp;—&nbsp; {{ $at->profissional }}@endif</p>
    <p>{{ $at->anotacoes }}</p>
  </div>
  @endforeach
@endif

<p class="rodape">Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }} — Clínica Escola ULBRA. Uso restrito, sob sigilo profissional.</p>

</body>
</html>
