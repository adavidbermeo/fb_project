$(document).ready(function(){
    $("button[type='submit']").click(function(event){
        event.preventDefault();

        var search = $("#options :selected").val();
        // var datavalue = $("#search").attr('data-value');

        $.post("functions/submit.php",{
            search: search,
            // datavalue: datavalue
        }, function(respuesta){
            // $('.custom-container').append('<div class="business-manager-info"></div>')
            $(".business-manager-info").css(
                "display", "block"
            );
            $(".graphic-dashboard").css(
                "display", "none"
            )
    
            $(".business-manager-info").html(respuesta);
        });
    });
});


         
