$('#age').keyup(function(){
    var data = $(this).val();
    var idade = data.split('-').reverse().join('/');
    function calcIdade(data) {
        var d = new Date,
            ano_atual = d.getFullYear(),
            mes_atual = d.getMonth() + 1,
            dia_atual = d.getDate(),
            split = data.split('/'),
            novadata = split[1] + "/" +split[0]+"/"+split[2],
            data_americana = new Date(novadata),
            vAno = data_americana.getFullYear(),
            vMes = data_americana.getMonth() + 1,
            vDia = data_americana.getDate(),
            ano_aniversario = +vAno,
            mes_aniversario = +vMes,
            dia_aniversario = +vDia,
            quantos_anos = ano_atual - ano_aniversario;
        if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
            quantos_anos--;
        }
        return quantos_anos < 0 ? 0 : quantos_anos;
    }
    
    if(calcIdade(idade) >= 18){
        $('.popup').css('display', 'none');
        let dados = document.getElementById('input1');
        dados.removeAttribute('required', 'required');
        let dados2 = document.getElementById('input2');
        dados2.removeAttribute('required', 'required');
        let dados3 = document.getElementById('input3');
        dados3.removeAttribute('required', 'required');
    } else if(calcIdade(idade) < 18){
        $('.popup').css('display', 'flex');
        let dados1 = document.getElementById('input1');
        dados1.setAttribute('required', 'required');
        let dados2 = document.getElementById('input2');
        dados2.setAttribute('required', 'required');
        let dados3 = document.getElementById('input3');
        dados3.setAttribute('required', 'required');
    }
});
