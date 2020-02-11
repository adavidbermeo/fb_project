$(document).ready(function(){
    $("#send-data").click(function (event) {
        // event.preventDefault();

        var start_date = $("#start-date").val();
        var end_date = $("#end-date").val();
        var data = $("#data").val();

        $.post("functions/call_to_class.php",
        {
            start_date: start_date,
            end_date: end_date,
            data: data
            // datavalue: datavalue
        }, function(respuesta){
            $(".business-manager-info").css(
                "display",
            "block"
            );
            $(".graphic-dashboard").css(
                "display",
            "none"
            )
    
            $(".business-manager-info").html(respuesta);
        });
    });
});


