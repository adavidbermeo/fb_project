var data = '';
$(document).ready(function(){
    $("#show-calendar").click(function(){
        event.preventDefault();
        var mssg = $('#show-calendar').val();
        // console.log(mssg);
      $.ajax({
        type: "POST",
        url: 'clickMeArray.php',
        data: {
            mssg:mssg
        },
        success: function(response){
            // jQuery.noConflict();
            // console.log(response);
            data = JSON.parse(response);

            $("#content").html(
                '<input type="text" name="daterange" value="12/01/2019 - 12/31/2019"/>'
            );
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            });

            table = 
            '<table id="custom-table">'+
              '<thead>'+
                  '<tr>'+
                      '<th>Name</th>'+
                      '<th>Lastname</th>'+
                      '<th>Age</th>'+
                      '<th>mssg</th>'+
                  '</tr>'+
              '</thead>'+
              '<tbody>'+
              '</tbody>'+
            '</table>';

            $("#content").append(table);

            $.each(data['name'], function(index,value){
                var rowIndex = $('#custom-table').dataTable().fnAddData([
                    data['name'][index],
                    data['last_name'][index],
                    data['age'][index],
                    data['mssg'][index]
                ]);
                var row = $('#custom-table').dataTable().fnGetNodes(rowIndex);
                $(row).attr('id', data['name'][index]);
            });
             /* Multiple modal */
                   
             $('#exampleModalCenter').modal({
                backdrop: 'static',
                keyboard: false,
                show: false,
            });

            $(document).on("click", ".ad-mdal", function () {

                var ClickedButton = $(this).attr("href");

                // You can make an ajax call here if you want. 
                // Get the data and append it to a modal body.


                $(".modal-body").html("<img src='" + result2['ad_insights']['bimg'][ClickedButton] + "'></img>");
                $('#exampleModalCenter').modal('show');
            });

            },
            error: function (error) {
                alert('error; ' + eval(error));
            }
        }); 
    });

});
