var data = '';
$(document).ready(function () {
    $("#graphics").remove();
    $(".menu #custom-dashboard").one('click',function (event) {
        event.preventDefault();

        var selected = $(this).attr('href');
        
        var result1;
        var result2;
        var canvas = ['campaignCanvas','adCanvas'];
        var selector = $(".business-manager-info");
        var dashboard = $(".graphic-dashboard");
        
        // Campaign Graphics

        $.when(
            $.ajax({
            url: "dashboard/getGraphics.php",
            type: "POST", //send it through get method
            data: {
                selected: selected,
            },
            cache: false,
            success: function (response){
                result1 = response;
                console.log(result1);

                selector.css(
                    "display","none"
                );

                // $.each(canvas ,function (index, value) {
                //     dashboard.append('<div class="graphics"><canvas id="'+ value +'"</canvas></div>');
                // });
                
                data = JSON.parse(response);
                
                var camp_value = [];
                var camp_label = [];
                var ad_value = [];
                var ad_label = [];

                 // Post Reactions
                 for (var i = 0; i < 5; i++) {
                    if ((data['ad_graphic'][i])) {
                        ad_value.push(data['ad_graphic'][i]['total_reactions']);
                        ad_label.push(data['ad_graphic'][i]['ad_ids'] + " / " + data['ad_graphic'][i]['ad_name']);
                    }
                 }
                 
                var ctx = $("#adCanvas");  
                var ad_chart = {
                    labels: ad_label,
                    datasets: [{
                        label: 'Post Reactions',
                        backgroundColor: 'yellow',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: ad_value

                    }]
                };
                 var adGraph = new Chart(ctx, {
                     type: 'bar',
                     options: {
                         title: {
                             display: true,
                             text: 'POST REACTIONS'
                         }
                     },
                     data: ad_chart
                 });

                // Click per campaign

                for (var i = 0; i < 5; i++) {
                    if ((data['campaign_graphic'][i])) {
                        camp_value.push(data['campaign_graphic'][i]['clicks']);
                        camp_label.push(data['campaign_graphic'][i]['campaign_id'] + " / " + data['campaign_graphic'][i]['campaign_name']);
                    }
                }
                
                var ctx2 = $('#campaignCanvas');
                var campaign_chart = {
                    labels: camp_label,
                    datasets: [{
                        label: 'Clicks',
                        backgroundColor: 'blue',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: camp_value

                    }]
                };
                var campaignGraph = new Chart(ctx2, {
                    type: 'bar',
                    options: {
                        title: {
                            display: true,
                            text: 'CLICKS PER CAMPAIGN'
                        }
                    },
                    data: campaign_chart
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

                // dashboard.append(result2);
            });
        });
    });
