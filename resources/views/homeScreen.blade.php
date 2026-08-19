@extends('layout')
@section('title','Clínica Escola ULBRA')
@section('content')

<section class="home-hero">
  <span class="badge">Atendimento psicológico gratuito</span>
  <h1>Clínica Escola de Psicologia</h1>
  <p class="muted home-lead">Atendimento realizado por estagiários de Psicologia em reta final do curso, supervisionados por professores. Para crianças, adolescentes e adultos, na ULBRA de São Jerônimo.</p>
  <a class="btn btn-primary" href="{{ route('paciente.home') }}">Fazer meu cadastro</a>
</section>

<div class="home-cards">
  <div class="card">
    <h3>Clínica Escola</h3>
    <p class="muted">Espaço de atendimento psicológico criado em 2010, hoje dentro da própria Universidade. Os atendimentos são feitos por estagiários supervisionados por professores capacitados e são <b>totalmente gratuitos</b>. Funcionamento: segunda a sexta-feira, das 13h às 22h.</p>
  </div>
  <div class="card">
    <h3>SISAM</h3>
    <p class="muted">Serviço de Intervenção em Saúde Mental, criado em 2019, ligado ao Serviço Escola de Psicologia. Atua na prevenção e promoção da saúde mental na Região Carbonífera, com grupos, visitas, palestras e campanhas.</p>
  </div>
</div>

<div class="card home-contact">
  <div>
    <b>Contato</b>
    <p class="muted">WhatsApp: (51) 99952-8583 &middot; Atendimento apenas em período letivo.</p>
  </div>
  <a class="btn btn-soft" href="{{ route('paciente.home') }}">Ir para o cadastro</a>
</div>

@endsection
