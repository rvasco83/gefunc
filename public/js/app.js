$('#funcionario_cargo').on('change', function () {
    var valor = $(this).val();
    var status = $('#funcionario_status').val();

    controlaExibicaoCamposFuncionario(valor, status);

});

$("#funcionario_identidade").mask('000.000.000-0');

$("#funcionario_salario_base").mask('#.##0,00', {reverse: true});

//$("#funcionario_gratificacao").mask('000.000.000.000.000,00', {reverse: true});

//$("#funcionario_desconto").mask('000.000.000.000.000,00', {reverse: true});

function controlaExibicaoCamposFuncionario(cargo, status) {
    var funcionarioExonerado = false;

    if (status == 'E'){
        funcionarioExonerado = true;
    }

    $('#funcionario_salario_base').prop('readonly', funcionarioExonerado);
    $('#funcionario_desconto').prop('readonly', funcionarioExonerado);
    $('#funcionario_gratificacao').prop('readonly', funcionarioExonerado);

    $('#funcionario_data_exoneracao').prop('disabled', !funcionarioExonerado);

    $('#funcionario_gratificacao').prop('disabled', true);

    if (cargo == 'E') {
        $('#funcionario_gratificacao').prop('disabled', false);
    }
}

$('#funcionario_status').on('change', function () {
    var status = $(this).val();
    var cargo = $('#funcionario_cargo').val();

    controlaExibicaoCamposFuncionario(cargo, status);

});





