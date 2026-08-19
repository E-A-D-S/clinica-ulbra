<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
  @page { margin: 70px 55px; }
  * { font-family: "DejaVu Sans", sans-serif; }
  body { font-size: 10.5px; color: #111; line-height: 1.5; }
  .header { width: 100%; border-collapse: collapse; }
  .header td { vertical-align: middle; }
  .logo { width: 78px; height: 78px; }
  .inst .t1 { font-weight: bold; font-size: 12px; }
  .inst .t2 { font-size: 10px; }
  h2 { text-align: center; font-size: 12.5px; margin: 16px 0 12px; }
  .sec { font-weight: bold; margin: 13px 0 5px; }
  p { margin: 5px 0; }
  .fill { border-bottom: 1px solid #000; display: inline-block; min-width: 110px; padding: 0 4px; line-height: 1.1; }
  ul { margin: 6px 0 6px 18px; padding: 0; }
  li { margin-bottom: 5px; }
  .sign { margin-top: 44px; text-align: center; }
  .assinaturas { width: 100%; margin-top: 54px; text-align: center; }
  .page-break { page-break-before: always; }
</style>
</head>
<body>

<table class="header">
  <tr>
    <td style="width: 90px;"><img class="logo" src="{{ public_path('img/ulbra.png') }}" alt="ULBRA"></td>
    <td class="inst" style="text-align: center;">
      <div class="t1">UNIVERSIDADE LUTERANA DO BRASIL</div>
      <div class="t2">COMUNIDADE EVANGÉLICA SÃO PAULO</div>
      <div class="t2">Autorizada pelo Decreto n°95623-D.O.U de 13-1-88</div>
    </td>
    <td style="width: 90px;"></td>
  </tr>
</table>

<h2>CONTRATO DE ATENDIMENTO</h2>

<p>O presente CONTRATO DE ATENDIMENTO consiste das normas que regem a prestação de serviço do SERVIÇO ESCOLA DE PSICOLOGIA, doravante denominado CONTRATADO, e das obrigações das pessoas, doravante CONTRATANTE, que forem beneficiadas pelo atendimento, que se processará após adesão ao presente e consentimento livre e esclarecido do indivíduo ou por seus representantes legais.</p>

<div class="sec">DA IDENTIFICAÇÃO DAS PARTES CONTRATANTES</div>
<p>PESSOA BENEFICIADA – PACIENTE (CONTRATANTE): <span class="fill" style="min-width:220px">{{ $data->name }}</span>, estado civil: <span class="fill">{{ $data->marital_status }}</span>, carteira de identidade (RG) nº <span class="fill">{{ $data->rg }}</span>, residente à Rua <span class="fill">{{ $data->address }}</span>, nº <span class="fill" style="min-width:50px">{{ $data->house_number }}</span>, complemento: <span class="fill">{{ $data->Complement }}</span>, bairro: <span class="fill">{{ $data->district }}</span>, na cidade de <span class="fill">{{ $data->city }}</span>/RS.</p>
<p>Neste ato, o(a) menor de dezoito anos está devidamente assistido/representado por <span class="fill" style="min-width:220px">{{ $data->name_father }}</span>, representante legal do Contratante, residente no endereço supramencionado ou <span class="fill">{{ $data->address_father }}</span>, na cidade de <span class="fill">{{ $data->city_father }}</span>/RS.</p>
<p>SERVIÇO DE PSICOLOGIA (CONTRATADO): Pertencente à Universidade Luterana do Brasil, que compreende a Clínica Escola de Psicologia. Sito à Rua Ramiro Barcelos, n. 45, bairro centro, na cidade de São Jerônimo/RS.</p>

<div class="sec">DO OBJETO DO PRESENTE CONTRATO</div>
<p>Cláusula 1ª - O Serviço Escola de Psicologia compreende a Clínica Escola, onde ocorrem os atendimentos e serviços prestados por estagiários, com a devida supervisão dos professores habilitados para o exercício legal da profissão, podendo esses procedimentos serem observados por alunos da ULBRA nas práticas de ensino e estágios curriculares.</p>

<div class="sec">DA DESCRIÇÃO DO ATENDIMENTO A SER REALIZADO</div>
<p>Cláusula 2ª - Em conformidade com a rotina de cada serviço disponibilizado, o paciente (Contratante) passará por uma avaliação que NÃO IMPLICARÁ em atendimento.</p>
<p>Cláusula 3ª - O Contratante tem ciência, a partir do presente contrato, de que PODERÁ ocorrer a TROCA DE ESTAGIÁRIO, devido à rotatividade comum de uma clínica escola.</p>
<p>Cláusula 4ª - Os atendimentos ocorrerão conforme disponibilidade e rotina do serviço, respeitando sempre a necessidade do indivíduo e garantindo o bem-estar do mesmo.</p>
<p>Cláusula 5ª - O número de atendimentos será determinado pelos professores, conforme a necessidade de cada caso e disponibilidade do serviço.</p>
<p>Cláusula 6ª - O tempo de permanência será determinado pelos professores de acordo com o tratamento necessário ao paciente, podendo ser renovado conforme a reavaliação ao final de cada período.</p>
<p>Cláusula 7ª - O paciente (Contratante) se COMPROMETE A COMPARECER nos dias definidos para os atendimentos, sendo que o não comparecimento DEVERÁ ser justificado.</p>
<p>Cláusula 8ª - Os atendimentos não implicam em qualquer forma de pagamento.</p>

<div class="sec">DA RESCISÃO DO PRESENTE CONTRATO</div>
<p>Cláusula 9ª - Caso o paciente (Contratante) não compareça ao atendimento sem a devida justificativa, mencionada na Cláusula 7ª do presente instrumento, por 3 (três) vezes consecutivas, ou ainda incorra na prática de faltas frequentes (embora não consecutivas ou justificadas), TERÁ seu atendimento automaticamente INTERROMPIDO. Parágrafo único: O paciente (Contratante) que tiver seu tratamento interrompido pela cláusula acima poderá retornar ao tratamento conforme disponibilidade do serviço, sendo obrigatória a reavaliação do tratamento.</p>
<p>Cláusula 10ª - O paciente (Contratante) pode, a qualquer momento, desistir do atendimento.</p>

<div class="sec">TERMO DE CONSENTIMENTO INFORMADO</div>
<p>Eu, <span class="fill" style="min-width:220px">{{ $data->name }}</span>, abaixo assinado, portador da cédula de identidade sob o nº <span class="fill">{{ $data->rg }}</span>, aceito que o modelo de atendimento seja realizado conforme estabelece o presente contrato. Esta instituição assegura a confidencialidade e a privacidade, bem como a proteção da imagem, garantindo a não utilização das informações em prejuízo da pessoa ou grupo.</p>
<p>As informações obtidas com estes procedimentos, registradas em prontuário, e aquelas obtidas através de exames ou imagens poderão ser utilizadas como material didático em aulas, seminários e eventos científicos, salvaguardando a identificação do paciente.</p>

<div class="sign">
  <p>________________________________________________</p>
  <p>Assinatura do Paciente ou Responsável Legal</p>
  <p style="margin-top: 26px;">São Jerônimo, _____ de ____________________ de 20____</p>
</div>

<div class="page-break"></div>

<table class="header">
  <tr>
    <td class="inst" style="text-align: right; padding-right: 18px;">
      <div class="t1">UNIVERSIDADE LUTERANA DO BRASIL</div>
      <div class="t2">Curso de Psicologia</div>
      <div class="t2">Serviço Escola de Psicologia</div>
    </td>
    <td style="width: 90px;"><img class="logo" src="{{ public_path('img/ulbra.png') }}" alt="ULBRA"></td>
  </tr>
</table>

<h2>TERMO DE COMPROMISSO</h2>

<p>Eu, <span class="fill" style="min-width:240px">{{ $data->name }}</span>, portador do RG nº <span class="fill">{{ $data->rg }}</span>, responsável por <span class="fill" style="min-width:180px"></span>, comprometo-me com o Serviço Escola de Psicologia e com o(a) estagiário(a) <span class="fill" style="min-width:240px"></span> e alego estar ciente de que:</p>

<ul>
  <li>Os atendimentos serão realizados por estagiários(as), em final de curso, orientados(as) por um(a) psicólogo(a) supervisor(a).</li>
  <li>As sessões terão duração de 50 minutos, quando individual, e 90 minutos, quando grupal.</li>
  <li>As informações cedidas durante o processo de atendimento serão mantidas sob sigilo, conforme o código de ética profissional.</li>
  <li>Autorizo, para fins de pesquisa, o uso de informações coletadas durante as sessões de tratamento, desde que estas não me identifiquem.</li>
  <li>Não poderei faltar mais que três vezes consecutivas ou cinco alternadas, sob risco de perder o direito de utilizar o serviço, firmando meu desligamento.</li>
  <li>Entrarei em contato com o serviço desmarcando o atendimento quando não puder comparecer, com um dia de antecedência.</li>
</ul>

<p>Os atendimentos serão:</p>
<p>(&nbsp;&nbsp;&nbsp;) semanais, sempre nas ___________________________.</p>
<p>(&nbsp;&nbsp;&nbsp;) quinzenais, sempre nas _________________________.</p>
<p>(&nbsp;&nbsp;&nbsp;) mensais, sempre nas ___________________________.</p>

<table class="assinaturas">
  <tr>
    <td style="width:50%; padding-top:30px;">____________________________<br>Estagiário(a)</td>
    <td style="width:50%; padding-top:30px;">____________________________<br>Paciente/Responsável</td>
  </tr>
  <tr>
    <td style="padding-top:44px;">____________________________<br>Supervisor(a)</td>
    <td style="padding-top:44px;">Data ____/____/____</td>
  </tr>
</table>

</body>
</html>
