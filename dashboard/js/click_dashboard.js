  $(document).ready(function () {
      $('#custom-dashboard').click(
          function () {
              $('.con-loader').css(
                  "display", "block"
              );
          }
      );
      $(".menu #custom-dashboard").click(function (event) {
          event.preventDefault();

          var selected = $(this).attr('href');
          $(".business-manager-info").html(
            '<!DOCTYPE html>'+
            '<html lang="en">'+
            '<head>'+
                '<meta charset="utf-8">'+
                '<meta name="viewport" content="width=device-width, initial-scale=1"></meta>'+
                '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">'+
                '<link rel="stylesheet" href="/resources/demos/style.css">'+
                '<script src="https://code.jquery.com/jquery-1.12.4.js"></script>'+
                '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>'+
            '</head>'+
            '<body>'+
                '<div class="calendar-section delete">'+
                    '<p>Fecha Inicial : <input type="text" id="datepicker" class="first-option" name="start-date" autofocus step="1" min="2000-12-1" max="" required></p><br>'+    
                    '<p>Fecha Final   : <input type="text" id="datepicker2" class="second-option" name="end-date" autofocus step="1" min="2000-12-1" max="" required></p>'+
                    '<input type="hidden" id="data" value="'+ selected +'">'+    
                    '<input type="button" value="VER REPORTE" id="create-dashboard">'+
                '</div>'+
                '<script src="dashboard/js/dashboard.js"></script>'+
            '</body>'+
            '</html>'
            );
          $('.con-loader').css(
              "display", "none"
          );

          // var ad = $("#ad").attr('href');
          // var page = $("#page").attr('href');

        //   $.ajax({
        //       url: "functions/click_dashboard.php",
        //       type: "get", //send it through get method
        //       data: {
        //           selected: selected,
        //       },
        //       cache: false,
        //       success: function (response) {
        //           $(".business-manager-info").html(response);
                //   $('.con-loader').css(
                //       "display", "none"
                //   );
        //       },
        //       error: function (xhr) {
        //           return false;
        //       }
        //   });
      });
  });