var data = '';
$(document).ready(function () {
    $(".graphicSystem").click(function (event) {
         event.preventDefault();

         var selected = $(this).attr('href');

        //$(".business-manager-info").html('<div id="chart-container"><canvas id="mycanvas"></canvas></div>');

         $.ajax({
             url: "graphics/data.php",
             type: "POST", //send it through get method
             data: {
                selected: selected,
             },
             success: function (response) {
                //console.log(response);
                $(".business-manager-info").html('<div id="chart-container"><canvas id="mycanvas"></canvas></div>');
                data = JSON.parse(response);

                var valores = [];
                var label = [];
                var tamano = data.length;
                var color = data[(tamano-1)]['Bcolor'];

                console.log(tamano);
                for (var i = 0; i < (data.length-1); i++) {
                    switch(data[tamano-1]['tabla']){
                        case 'ad':
                            valores.push(data[i]['interactions']);
                            label.push(data[i]['ad_ids'] + " / " + data[i]['ad_name']);
                        break;

                    }
                    
                }
                var chartdata = {
                    labels: label,
                    datasets: [{
                        label: 'Interacciones',
                        backgroundColor: color,
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: valores
                    }]
                };

                var ctx = $("#mycanvas");

                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata
                });
                // $('#chart-container').css(
                //     "display", "block"
                // );
             },
             error: function (xhr) {
                 return false;
             }
         });
     });
});