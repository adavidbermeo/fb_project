$(document).ready(function () {
    $("#enviado").click(function (event) {
        event.preventDefault();

        var db_field = $("#db_field").val();
        var field_value = $("#db_values").val();
        var parameter = $("#parameters").val();

        $.ajax({
            url: "reporting/reporting.php",
            type: "POST", //send it through get method
            data: {
                db_field,
                field_value,
                parameter,
            },
            success: function (response) {
                $(".business-manager-info").html(response);
            },
            error: function (xhr) {
                return false;
            }
        });
    });
});
