$(document).ready(function(){
    $("button[type='submit']").click(function(event){
        event.preventDefault();

        var search = $("#options :selected").val();
        // var datavalue = $("#search").attr('data-value');

        $.post("functions/submit.php",{
            search: search,
            // datavalue: datavalue
        }, function(respuesta){
                $(".business-manager-info").html(respuesta);
        });
    });
});


         
