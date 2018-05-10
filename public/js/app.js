$('#funcionario_cargo').on('change', function () {
    var valor = $(this).val();
    var status = $('#funcionario_status').val();

    controlaExibicaoCamposFuncionario(valor, status);

});

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

