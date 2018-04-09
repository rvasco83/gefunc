$('#funcionario_cargo').on('change', function () {
    var valor = $(this).val();

    $('#funcionario_gratificacao').prop('disabled', true);

    if (valor == 'E') {
        $('#funcionario_gratificacao').prop('disabled', false);
    }
});

$('#funcionario_status').on('change', function () {
    var valor = $(this).val();

    $('#funcionario_data_exoneracao .form-control').prop('disabled', true);

    if (valor == 'E') {
        $('#funcionario_data_exoneracao .form-control').prop('disabled', false);
    }
});
