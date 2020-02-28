var data = '';
$(document).ready(function(){
    $("#s-data").click(function(){
        event.preventDefault();
        var date1 = $('.date-range').val();
        // console.log(mssg);
      $.ajax({
        type: "POST",
        url: 'showData.php',
        data: {
            date1:date1
        },
        success: function(response){
            // jQuery.noConflict();
            // console.log(response);

            $("#content").html(response);

            },
            error: function (error) {
                alert('error; ' + eval(error));
            }
        }); 
    });

});
