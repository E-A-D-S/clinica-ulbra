<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="responsible" style="padding-left: 100px; padding-right:100px;" >
    <div style="display: flex; justify-content:space-around;">    
        <img src="https://static.wixstatic.com/media/0aad82_fc6ea6c310e34f679f36449f7a2cbf50~mv2.jpg/v1/fill/w_1000,h_1000,al_c,q_85/ULBRA.jpg" width="150px" height="150px"/>
        <div>
            <strong style="font-size: 16px ">UNIVERSIDADE LUTERANA DO BRASIL</strong>
            <p>COMUNIDADE EVANGÉLICA SÃO PAULO</p>
        </div>   
    </div>
    <h1>Dados basico do paciente</h1>
    <div class="mb-3 w-50">
        <label class="form-label"> Nome Completo </label>
        <input type="text" name="name" placeholder="Ex. Eduardo da costa" value="{{ $data['name'] }}" class="form-control" disabled>
    </div>
  
    <div class="mb-3 w-25 mx-2">
        <label  class="form-label"> Data de Nascimento </label>
        <input type="date" name="birth_date" placeholder="Ex. 10/10/2020"  value="{{ $data['birth_date'] }}" id="idade" class="form-control" disabled>
    </div>
    <div class="mb-3">
      <label  class="form-label"> horário para atendimento </label>
      <input type="string" name="time_service" placeholder="Ex. 14:00" value="{{ $data['time_service'] }}" id="hora" class="form-control" disabled>
    </div>

    <div class="mb-3">
      <label  class="form-label"> Motivo da Consulta </label>
      <div class="mb-3">
        <input type="text" value="{{ $data['consultation'] }}" disabled>
      </div>
    </div>
</div>
</body>
</html>
