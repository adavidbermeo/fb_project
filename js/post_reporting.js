$(document).ready(function () {
    $("#db-query input[type='submit']").click(function (event) {
        event.preventDefault();

        var db_field = $("#db_field").val();
        var field_value = $("#db_values").val();
        var parameter = $("#parameters").val();


        $.post("reporting/reporting.php", {
            db_field: db_field,
            field_value: field_value,
            parameter: parameter
        }, function (respuesta) {
            $(".business-manager-info").html(respuesta);
        });
    });
});