var data = '';
var ad_shares = [];
var ad_comments = [];
$(document).ready(function () {

    $(".menu #custom-dashboard").one('click',function (event) {
        event.preventDefault();

        var selected = $(this).attr('href');
        
        var result1;
        var result2;
        var canvas = ['campaignCanvas', 'adCanvas', 'ageGender', 'fansCity', 'comments','shares'];
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

                selector.css(
                    "display","none"
                );
                // if(data[]){

                // }
                $.each(canvas ,function (index, value) {
                    dashboard.append('<div class="graphics"><canvas id="'+ value +'"</canvas></div>');
                });
                
                data = JSON.parse(response);
                
                // console.log(data);
                
                var camp_value = [];
                var camp_label = [];

                var ad_value = [];
                var ad_label = [];

                var agender_value = [];
                var agender_label = [];
                
                var fcity_value = [];
                var fcity_label = [];

                // var ad_comments = [];
                // var ad_shares = [];
                var ad_comment_count = 0;
                var ad_shares_count = 0;
                
                for (var i = 0; i < 5; i++) {
                    if ((data['ad_graphic'][i])) {
                        ad_value.push(data['ad_graphic'][i]['total_reactions']);
                        ad_label.push(data['ad_graphic'][i]['ad_ids'] + " / " + data['ad_graphic'][i]['ad_name']);
                    }
                }
                for(var i=0; i<data['ad_graphic'].length; i++){
                    ad_comments.push(data['ad_graphic'][i]['comments']);
                    ad_shares.push(data['ad_graphic'][i]['shares']);
                }
                console.log(ad_comments);
                 
                var ctx = $("#adCanvas");  
                var ad_chart = {
                    labels: ad_label,
                    datasets: [{
                        label: 'Post Reactions',
                        backgroundColor: 'rgba(91, 164, 22, 0.4)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: ad_value

                    }]
                };
                 var adGraph = new Chart(ctx, {
                     type: 'horizontalBar',
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
                        backgroundColor: 'rgba(105, 132, 255, 0.4)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: camp_value

                    }]
                };
                var campaignGraph = new Chart(ctx2, {
                    type: 'line',
                    options: {
                        title: {
                            display: true,
                            text: 'CLICKS PER CAMPAIGN'
                        }
                    },
                    data: campaign_chart
                });

                //Age Gender 

                    for (var i = 0; i < data['fans_age_gender'].length; i++) {

                        if ((data['fans_age_gender'][i])) {
                            agender_value.push(data['fans_age_gender'][i].value);
                            agender_label.push(data['fans_age_gender'][i].key);
                        }
                    }

                var ctx3 = $("#ageGender");
                var agender_chart = {
                    labels: agender_label,
                    datasets: [{
                        label: '#People',
                        backgroundColor: 'rgba(178, 5, 230, 0.4)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: agender_value

                    }]
                };
                var agenderGraph = new Chart(ctx3, {
                    type: 'bar',
                    options: {
                        title: {
                            display: true,
                            text: 'AGE GENDER'
                        }
                    },
                    data: agender_chart
                });

                /**
                 * 
                 * Fans City or Location
                 *
                 */
                
                    for (var i = 0; i < data['fans_city'].length; i++) {
                        if ((data['fans_city'][i])) {
                            fcity_value.push(data['fans_city'][i].value);
                            fcity_label.push(data['fans_city'][i].key);
                        }
                    }

                  var ctx4 = $("#fansCity");
                  randomColor();
                  var fcity_chart = {
                      labels: fcity_label,
                      datasets: [{
                          label: '#People',
                          backgroundColor: randomColor({
                              count: data['fans_city'].length,
                              hue: 'blue'
                          }),
                          borderColor: 'rgba(200, 200, 200, 0.75)',
                          hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                          hoverBorderColor: 'rgba(200, 200, 200, 1)',
                          data: fcity_value

                      }]
                  };
                  var fCityGraph = new Chart(ctx4, {
                      type: 'doughnut',
                      options: {
                          title: {
                              display: true,
                              text: 'Fans City'
                          }
                      },
                      data: fcity_chart
                  });
                  /***
                   * Comments and Shares Dashboard
                   */
                  
                  $.each(ad_comments, function(index,value){
                      ad_comment_count = ad_comment_count + Number(value);
                  });
                //   console.log(ad_comment_count);

                 var ctx5 = $("#comments");
                 var comments_chart = {
                     labels: ['Diciembre'],
                     datasets: [{
                         label: '#Count',
                         backgroundColor: 'rgba(70,137,80,0.4)',
                         borderColor: 'rgba(200, 200, 200, 0.75)',
                         hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                         hoverBorderColor: 'rgba(200, 200, 200, 1)',
                         data: [ad_comment_count]
                     }]
                 };
                 var commentsGraph = new Chart(ctx5, {
                     type: 'line',
                     options: {
                         title: {
                             display: true,
                             text: 'Comments Graphic'
                         }
                     },
                     data: comments_chart
                 });

                 $.each(ad_shares, function (index, value) {
                     ad_shares_count = ad_shares_count + Number(value);
                 });
                //  console.log(ad_shares_count);

                   var ctx6 = $("#shares");
                   var shares_chart = {
                       labels: ['Diciembre'],
                       datasets: [{
                           label: '#Count',
                           backgroundColor: 'rgba(70,137,80,0.4)',
                           borderColor: 'rgba(200, 200, 200, 0.75)',
                           hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                           hoverBorderColor: 'rgba(200, 200, 200, 1)',
                           data: [ad_shares_count]
                       }]
                   };
                   var sharesGraph = new Chart(ctx6, {
                       type: 'line',
                       options: {
                           title: {
                               display: true,
                               text: 'Shares Graphic'
                           }
                       },
                       data: shares_chart
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

                dashboard.append(result2);
            });
        });
    });
