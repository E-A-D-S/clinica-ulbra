@extends('layout')
@section('titles','pdf' )
@section('content')
<div style="display: flex; margin-top:-50px;">
    <img src="https://static.wixstatic.com/media/0aad82_fc6ea6c310e34f679f36449f7a2cbf50~mv2.jpg/v1/fill/w_1000,h_1000,al_c,q_85/ULBRA.jpg" width="100px" height="100px"/>
    <div style="margin-left:20px ; margin-top: -70px; text-align:center;">
        <strong style="font-size:12px;">UNIVERSIDADE LUTERANA DO BRASIL</strong>
        <p style="height:0px;  margin-top:10px; font-size: 11px;">COMUNIDADE EVANGÉLICA SÃO PAULO</p>
        <p style="height:0px; font-size: 11px;">Autorizada pelo Decreto n°95623-D.O.U de 13-1-88</p>
        <p style="height:2px ;  margin-top:25px; font-size: 12px ;">CONTRATO DE ATENDIMENTO</p>
    </div>
</div>
<div style="margin-top: 15px; font-size:11px;">
    <p style="font-size:11px ;">O presente CONTRATO DE ATENDIMENTO consiste das normas que regem a prestação de serviço do SERVIÇO ESCOLA DE PSICOLOGIA, doravante denominado CONTRATADO, e das obrigações das pessoas, doravante CONTRATANTE, que forem beneficiadas pelo atendimento, que se processará após adesão ao presente e consentimento livre e esclarecido do indivíduo ou por seus representantes legais.</p>
    <p style="height:2px ;">DA IDENTIFICAÇÃO DAS PARTES CONTRATANTES</p>
    <p style="height:5px ;">PESSOA BENEFICIADA – PACIENTE (CONTRATANTE): <spam style=" border-bottom: 1px solid black; width: 400px; display: inline-block; height:10px;"> {{ $data->name }} </spam>, </p>
    <p style="height:5px ;">estado civil: <spam style="border-bottom: 1px solid black; width: 200px; display: inline-block; height:10px;"> {{ $data->marital_status }} </spam>, carteira de identidade (RG) nº <spam style="border-bottom: 1px solid black; width: 240px; display: inline-block; height:10px;"> {{ $data->rg }} </spam>
    ,residente à </p> 
    <p style="height:5px ;">Rua <spam style="border-bottom: 1px solid black; width: 200px; display: inline-block; height:10px;"> {{ $data->address }} </spam>,nº<spam style="border-bottom: 1px solid black; width: 200px; display: inline-block; height:10px;"> {{ $data->house_number }} </spam>,complemento:<spam style="border-bottom: 1px solid black; width: 190px; display: inline-block; height:10px;"> {{ $data->Complement }} </spam>,</p>
    <p style="height:5px ;">bairro: <spam style="border-bottom: 1px solid black; width: 250px; display: inline-block; height:10px;"> {{ $data->district }} </spam>,na cidade de <spam style="border-bottom: 1px solid black; width: 285px; display: inline-block; height:10px;"> {{ $data->city }} </spam>/RS. Neste ato</p>
    <p style="height:5px ; word-spacing: 40px;">o (a) menor do dezoito anos está devidamente assistido/representado por </p>
    <p style="height:5px ;"> <spam style="border-bottom: 1px solid black; width: 490px; display: inline-block; height:10px;"> {{ $data->name_father }} </spam>, representante legal do Contratante, residente no </p>
    <p style="height:5px ;">endereço supramencionado ou <spam style="border-bottom: 1px solid black; width: 494px; display: inline-block; height:10px;">  {{ $data->address_father }} </spam>, na cidade de</p>
    <p style="height:5px ;"> <spam style="border-bottom: 1px solid black; width: 200px; display: inline-block; height:10px;"> {{ $data->city_father }} </spam>/RS.</p>
    <p style="height:5px ;">SERVIÇO DE PSICOLOGIA (CONTRATADO): Pertencente à Universidade Luterana do Brasil, que compreende a Clinica Escola de Psicologia. Sito à Rua Ramiro Barcelos, n. 45, bairro centro, na cidade de São Jerônimo /RS.</p>
    <p style="margin-top:40px ; height:5px ;">DO OBJETO DO PRESENTE CONTRATO</p>
    <p style="height:5px ;">>Cláusula 1º- O Serviço Escola de Psicologia compreende a Clinica Escola, onde ocorrem os atendimentos e serviços prestados por estagiários, com a devida supervisão dos professores habilitados para o exercício legal da profissão, podendo esses procedimentos serem observados por alunos da ULBRA nas práticas de ensino e estágios curriculares.</p>
    <p style="margin-top:60px ; height:5px ;">DA DESCRIÇÃO DO ATENDIMENTO A SER REALIZADO</p>
    <p style="height:10px ;">>Cláusula 2º - Em conformidade com a rotina de cada serviço disponibilizado, o paciente (Contratante) passará por uma avaliação que NÃO IMPLICARÁ em atendimento.</p>
    <p style="height:10px ;">>Cláusula 3º - O Contratante tem ciência a partir do presente contrato, que PODERÁ ocorrer a TROCA DE ESTÁGIARIO, devido a rotatividade comum de uma clinica escola.</p>
    <p style="height:10px ;">>Cláusula 4º - Os atendimentos ocorrerão conforme disponibilidade e rotina do serviço, respeitando sempre a necessidade do indivíduo e garantindo o bem-estar do mesmo.</p>
    <p style="height:0px ;">>Cláusula 5º - O número de atendimentos será determinado pelos professores, conforme a necessidade de cada caso e disponibilidade do serviço.</p>
    <p style="height:10px ;">>Cláusula 6º - O tempo de permanência será determinado pelos professores de acordo com o tratamento necessário ao paciente, podendo ser renovado conforme a reavaliação ao final de cada período.</p>
    <p style="height:10px ;">>Cláusula 7º - O paciente (Contratante) se COMPROMETE A COMPARECER nos dias definidos para os atendimentos, sendo que o não comparecimento DEVERÁ ser justificado.</p>
    <p style="height:10px ;">>Cláusula 8º - Os atendimentos não implicam em qualquer forma de pagamento.</p>
    <p style="margin-top:20px ;  height:5px ;">DA RESCISÃO DO PRESENTE CONTRATO</p>
    <p  style="height:40px ;">Cláusula 9º - Caso o paciente (Contratante) não comparecer ao atendimento sem a devida justificativa, mencionada na Cláusula 7º do presente instrumento, por 3 (três) vezes consecutivas ou ainda incorrer na prática das faltas freqüentes (embora não consecutivas ou justificadas), TERÁ seu atendimento automaticamente INTERROMPIDO.
Parágrafo único: O paciente (Contratante) que tiver seu tratamento interrompido pela cláusula acima, poderá retornar ao tratamento conforme disponibilidade do serviço, sendo obrigatório a reavaliação do tratamento.
    </p>
    <p>Cláusula 10º - O paciente (Contratante) pode HÁ QUALQUER momento desistir do atendimento.</p>
    <p style="height:5px ;">TERMO DE CONSENTIMENTO INFORMADO</p>
    <p style="height:0px ;">Eu, <spam style="border-bottom: 1px solid black; width: 410px; display: inline-block; height:10px;"> {{ $data->name }} </spam>, abaixo assinado, portador da cédula de identidade sob o</p>
    <p style="height:0px ;">nº <spam style="border-bottom: 1px solid black; width: 350px; display: inline-block; height:10px;"> {{ $data->rg }} </spam>, aceito que o modelo de atendimento seja realizado conforme estabelece o</p>
    <p style="height:10px ;">presente contrato. Esta instituição assegura a confidenciabilidade e a privacidade, bem como a proteção da imagem, garantindo a não utilização das informações em prejuízo da pessoa ou grupo.</p>
    <p>As informações obtidas com estes procedimentos, registrados em prontuário e aquelas obtida através de exames ou imagens poderão ser utilizadas como material didático em aulas, seminários e eventos científicos, salvaguardando a identificação do paciente.</p>
    <div style="margin-left: 400px ; text-align:center;">
        <p style="height:0px ;">________________________________________________</p>
        <p style="height:0px ;">Assinatura do Paciente ou Responsável Legal</p>
        <p style="margin-top: 40px;">São Jerônimo,_____ de ____________________de 20____</p>
    </div>
 </div>

    <div class="mt-5">
        <div style="display: flex;">
            <img style="margin-left: 500px;" src="https://static.wixstatic.com/media/0aad82_fc6ea6c310e34f679f36449f7a2cbf50~mv2.jpg/v1/fill/w_1000,h_1000,al_c,q_85/ULBRA.jpg" width="100px" height="100px"/>
            <div class="text-center font-weight-bold" style="font-weight: 700;">
                <p> UNIVERSIDADE LUTERANA DO BRASIL </p> 
                <p>Curso de Psicologia</p> 
                <p>Serviço Escola de Psicologia</p> 
        
                <p>TERMO DE COMPROMISSO</p> 
            </div>
        </div>
        <div class="px-5" style="margin-top: 50px;">
            <div style="font-weight: 500;">
                <p>Eu,<spam style=" border-bottom: 1px solid black; width: 500px; display: inline-block; height:15px;"> {{ $data->name }} </spam>, </p> 
                <p>portador do RG nº<spam style=" border-bottom: 1px solid black; width: 380px; display: inline-block; height:15px;"> {{ $data->rg }} </spam>, responsável</p> 
                <p>por__________________________, comprometo-me com o Serviço Escola de</p> 
                <p>Psicologia e com o(a) estagiário(a)_____________________________________ e</p> 
                <p>alego estar ciente de que:</p>
            </div>
            <ul>
                <li>Os atendimentos serão realizados por estagiários(as), em final de curso orientados(as) por um psicólogo(a) supervisor(a).</li>
                <li>As sessões terão duração de 50 minutos, quando for individual e 90 minutos quando for grupal.</li>
                <li>As informações cedidas durante o processo de atendimento serão mantidas sob sigilo conforme o código de ética profissional.</li>
                <li>Autorizo, para fins de pesquisa o uso de informações coletadas durante as sessões de tratamento, desde que estas não me identifiquem.</li>
                <li>Não poderei faltar mais que três vezes consecutivas ou cinco alternadas, mediante risco de perder o direito de utilizar o serviço, firmando meu desligamento.</li>
                <li>Entrarei em contato com o serviço desmarcando o atendimento quando não puder comparecer, com um dia de antecedência.</li>
                <li>Os atendimentos serão:</li>
            </ul>
            <p>(    ) semanais, sempre nas___________________________.</p>
            <p>(    ) quinzenais, sempre nas _________________________.</p>
            <p>(    ) mensais, sempre nas ___________________________.</p>
            <div style="margin-left: 70px; margin-top: 30px;">
                <p>Estagiário(a)</p>                                                           
                <p style="margin-top: -100px; margin-left: 300px;">Paciente/Responsável</p>
            </div>
        </div>
           
        
        <div style="margin-left: 120px; margin-top: 30px;">
           <p style="display: inline-block ; width: 300px;">Supervisor(a)</p> 					
           <span>Data ____/____/____</span> 
        </div>
    </div>
@endsection