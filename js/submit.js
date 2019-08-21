$(document).ready(function(){
    $("button[type='submit'").click(function(event){
        event.preventDefault();

        var search = $("#search").val();

        $.post("functions/submit.php",{
            search: search
        }, function(respuesta){
                $(".business-manager-info").html(respuesta);
        });
    });
});