var data = '';
$(document).ready(function () {
    $(".menu #custom-dashboard").click(function (event) {
        event.preventDefault();

        var selected = $(this).attr('href');

        var result1;
        var result2;

        //$(".business-manager-info").html('<div id="chart-container"><canvas id="mycanvas"></canvas></div>');
        $.when($.ajax({
            url: "dashboard/getGraphics.php",
            type: "POST", //send it through get method
            data: {
                selected: selected,
            },
            success: function (response) {
                 result1 = response;

                data = JSON.parse(response);
                
                var valores = [];
                var label = [];

                console.log(data);
                // Click for Campaign
                for (var i = 0; i < 5; i++) {
                    
                    if ((data['campaign_graphic'][i]) > 0) {
                        valores.push(data['campaign_graphic'][i]['clicks']);
                        label.push(data['campaign_graphic'][i]['campaign_id'] + " / " + data['campaign_graphic'][i]['campaign_name']);
                    }
    
                }
                    var chartdata = {
                        labels: label,
                        datasets: [{
                            label: 'Clicks',
                            backgroundColor: 'blue',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: valores

                        }]
                    };
                var ctx = $("#customCanvas");
                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    options: {
                        title: {
                            display: true,
                            text: 'GRAPHIC SYSTEM'
                        }
                    },
                    data: chartdata
                });
            },
            error: function (xhr) {
                    return false;
                }
            }),
             $.ajax({ //Seconds Request
                 url: "dashboard/getTable.php",
                 type: "POST",
                 data: {
                     selected: selected,
                 },
                 cache: false,
                 success: function (response) {
                    result2 = response;
                 },
                 error: function (xhr) {
                     return false;
                 }
             })
            ).then(function(){
                $('#result1').html('<canvas id="mycanvas">'+ result1 + '</canvas>');
                $('#result2').html(result2);
            });
        });
    });
