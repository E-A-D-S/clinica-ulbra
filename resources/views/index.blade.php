@extends('layout')
@section('title','Cadastro de paciente · Clínica ULBRA')
@section('content')

<div class="form-page">
  <div class="card">
    <div class="form-head">
      <h1>Cadastro de paciente</h1>
      <p class="muted">Preencha seus dados para solicitar atendimento na Clínica Escola.</p>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $erro)
          <div>{{ $erro }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('paciente.store') }}" method="post">
      @csrf
      {{-- honeypot anti-spam: humano nao ve nem preenche --}}
      <input type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;height:0;width:0;opacity:0">

      <div class="form-grid">
        <div class="field"><label>Nome completo *</label><input class="input" name="name" value="{{ old('name') }}" required></div>
        <div class="field"><label>Data de nascimento *</label><input class="input" type="date" name="birth_date" value="{{ old('birth_date') }}" required></div>
        <div class="field"><label>Estado civil</label><input class="input" name="marital_status" value="{{ old('marital_status') }}"></div>
      </div>

      <div class="form-grid">
        <div class="field"><label>Telefone *</label><input class="input" name="telephone" value="{{ old('telephone') }}" data-mask="(00) 00000-0000" placeholder="(00) 00000-0000" required></div>
        <div class="field"><label>RG *</label><input class="input" name="rg" value="{{ old('rg') }}" data-mask="00.000.000-0" placeholder="00.000.000-0" required></div>
        <div class="field"><label>CPF *</label><input class="input" name="cpf" value="{{ old('cpf') }}" data-mask="000.000.000-00" placeholder="000.000.000-00" required></div>
      </div>

      <div class="form-grid">
        <div class="field"><label>Endereço *</label><input class="input" name="address" value="{{ old('address') }}" required></div>
        <div class="field"><label>Complemento *</label><input class="input" name="Complement" value="{{ old('Complement') }}" required></div>
        <div class="field"><label>Número *</label><input class="input" name="house_number" value="{{ old('house_number') }}" required></div>
        <div class="field"><label>Cidade *</label><input class="input" name="city" value="{{ old('city') }}" required></div>
        <div class="field"><label>Bairro *</label><input class="input" name="district" value="{{ old('district') }}" required></div>
      </div>

      <div class="form-grid">
        <div class="field"><label>Horário de preferência *</label><input class="input" name="time_service" value="{{ old('time_service') }}" data-mask="00:00" placeholder="14:00" required></div>
      </div>

      <div class="field"><label>Motivo da consulta *</label><textarea class="input" name="consultation" required>{{ old('consultation') }}</textarea></div>

      <details class="resp-details">
        <summary>Responsável (para menores de idade)</summary>
        <div class="form-grid" style="margin-top:12px">
          <div class="field"><label>Nome do responsável</label><input class="input" name="name_father" value="{{ old('name_father') }}"></div>
          <div class="field"><label>Endereço do responsável</label><input class="input" name="address_father" value="{{ old('address_father') }}"></div>
          <div class="field"><label>Cidade do responsável</label><input class="input" name="city_father" value="{{ old('city_father') }}"></div>
        </div>
      </details>

      <div class="lgpd-box">
        <p class="lgpd-title">Proteção de dados (LGPD)</p>
        <p>Os dados informados serão usados exclusivamente pela <b>Clínica Escola de Psicologia da ULBRA</b> para o agendamento e a realização do seu atendimento, ficando sob sigilo profissional. Você pode solicitar a qualquer momento a correção ou a remoção do seu cadastro da lista de atendimento. Por obrigação legal de guarda de prontuário (Resolução CFP 001/2009), o histórico clínico é mantido em arquivo, com acesso restrito.</p>
        <label class="check">
          <input type="checkbox" name="consentimento" value="1" required>
          <span>Li e concordo com o uso dos meus dados conforme descrito acima.</span>
        </label>
      </div>

      <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
        <button type="submit" class="btn btn-primary">Enviar cadastro</button>
        <a href="{{ route('paciente.homeScreen') }}" class="btn btn-ghost">Voltar</a>
      </div>
    </form>
  </div>
</div>

@endsection
