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
                var valores2 = [];
                var valores3 = [];

                var label = [];
                var tamano = data.length;
                var color = data[(tamano-1)]['Bcolor'];

                console.log(data);
                for (var i = 0; i < (data.length-1); i++){
                    switch(data[tamano-1]['tabla']){
                        case 'ad':
                            if ((data[i]['interactions']) > 0) {
                                valores.push(data[i]['interactions']);
                                valores2.push(data[i]['post_clicks']);
                                label.push(data[i]['ad_ids'] + " / " + data[i]['ad_name']);
                            }
                        break;
                        case 'campaign':
                        if ( (data[i]['impressions'])>0 ) {
                            valores.push(data[i]['impressions']);
                            valores2.push(data[i]['clicks']);
                            valores3.push(data[i]['reach']);
                            label.push(data[i]['campaign_id'] + " / " + data[i]['campaign_name']);
                        }
                        break;
                        case 'page':
                            if ((data[i]['total_new_likes']) > 0) {
                                valores.push(data[i]['total_new_likes']);
                                valores2.push(data[i]['people_paid_like']);
                                valores3.push(data[i]['people_unpaid_like']);
                                label.push(data[i]['id_page'] + " / " + data[i]['page_name']);
                            }
                        break;
                    }
                }
                switch(data[tamano-1]['tabla']){
                    case 'ad':
                        var chartdata = {
                            labels: label,
                            datasets: [{
                                label: 'Interacciones',
                                backgroundColor: color,
                                borderColor: 'rgba(200, 200, 200, 0.75)',
                                hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                                data: valores
                            
                            },{
                                label: 'Post Clicks',
                                backgroundColor: 'rgba(31, 102, 156, 0.71)',
                                borderColor: 'rgba(31, 102, 156, 0.71)',
                                hoverBackgroundColor: 'rgba(31, 102, 156, 0.91)',
                                hoverBorderColor: 'rgba(31, 102, 156, 0.71)',
                                data: valores2
                            }]    
                        };
                    break;
                    case 'campaign':
                        var chartdata = {
                            labels: label,
                            datasets: [{
                                label: 'Impresiones',
                                backgroundColor: 'rgba(255, 99, 0, 0.5)',
                                borderColor: 'rgba(255, 99, 0, 0.5)',
                                hoverBackgroundColor: 'rgba(255, 99, 0, 0.7)',
                                hoverBorderColor: 'rgba(255, 99, 0, 0.7)',
                                data: valores
                            }, {
                                label: 'Reach',
                                backgroundColor: 'rgba(59, 57, 255, 0.3)',
                                borderColor: 'rgba(59, 57, 255, 0.3)',
                                hoverBackgroundColor: 'rgba(59, 57, 255, 0.6)',
                                hoverBorderColor: 'rgba(59, 57, 255, 0.6)',
                                data: valores3
                            },{
                                label: 'Clicks',
                                backgroundColor: color,
                                borderColor: 'rgba(200, 200, 200, 0.75)',
                                hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                                data: valores2
                            }]
                        };
                    break;
                    case 'page':
                        var chartdata = {
                            labels: label,
                            datasets: [{
                                label: 'Total New Likes',
                                backgroundColor: 'rgba(59, 198, 255, 0.8)',
                                borderColor: 'rgba(59, 198, 255, 0.8)',
                                hoverBackgroundColor: 'rgba(59, 198, 255, 0.5)',
                                hoverBorderColor: 'rgba(59, 198, 255, 0.5)',
                                data: valores
                            },{
                                label: 'People Paid Like',
                                backgroundColor: 'rgba(231, 169, 0, 0.3)',
                                borderColor: 'rgba(231, 169, 0, 0.3)',
                                hoverBackgroundColor: 'rgba(231, 169, 0, 0.6)',
                                hoverBorderColor: 'rgba(231, 169, 0, 0.6)',
                                data: valores2
                            },{
                                label: 'People Unpaid Like',
                                backgroundColor: color,
                                borderColor: 'rgba(200, 200, 200, 0.75)',
                                hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                                hoverBorderColor: 'rgba(200, 200, 200, 1)',
                                data: valores3
                            }]
                        };
                    break;
                }

                var ctx = $("#mycanvas");

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
         });
     });
});