var data = '';
$(document).ready(function () {
     $('#custom-dashboard').click(
         function () {
             $('.con-loader').css(
                 "display", "block"
             );
         }
     );
    $(".menu #custom-dashboard").one('click', function (event){
        event.preventDefault();

        var selected = $(this).attr('href');

        var result1;
        var result2;
        var canvas = ['page_views_per_date', 'adClicks_per_date', 'impressions_per_age', 'adClicks_per_age']; //, 'impressions_per_age', 'adClicks_per_date','adClicks_per_age'
        var likes_evolution = 'likes_evolution';
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
                success: function (response) {
                    $('.con-loader').css(
                        "display", "none"
                    );
                     $(dashboard).css(
                         "display", "block"
                     );

                    data = JSON.parse(response);
                    selector.css(
                        "display", "none"
                    );
                    dashboard.append('<div class="dash-section"><h1><i class="fas fa-signal fb-icon"></i> Dashboad System FB API </h1><div><br>');

                    $.each(canvas, function (index, value) {
                        dashboard.append('<div class="graphics"><canvas id="' + value + '"</canvas></div>');
                    });
                    dashboard.append('<div class="graphic-likes"><canvas id="' + likes_evolution + '"</canvas></div>');

                    var page_views_value = [];
                    var page_views_label = [];

                    var ad_clicksDate_value = [];
                    var ad_clicksDate_label = [];

                    var page_impressions_value = [];
                    var page_impressions_label = [];

                    var ad_cliksAge_value = [];
                    var ad_cliksAge_label = [];

                    var likes_evolution_value = [];
                    var likes_evolution_label = [];


                    // for (var i = 0; i < 5; i++) {
                    if(data['page_graphic']){
                        $.each(data['page_graphic']['page_views_per_date'], function (index, value) {
                            page_views_value.push(value);
                            page_views_label.push(data['page_graphic']['end_time'][index]);
                        });
                    }
                        

                    var ctx = $("#page_views_per_date");
                    var page_views_chart = {
                        labels: page_views_label,
                        datasets: [{
                            label: 'Page Views',
                            backgroundColor: 'rgba(91, 164, 22, 0.4)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: page_views_value

                        }]
                    };
                    var pageViewsGraph = new Chart(ctx, {
                        type: 'line',
                        options: {
                            title: {
                                display: true,
                                text: 'PAGINAS VISTAS POR FECHA'
                            }
                        },
                        data: page_views_chart
                    });

                    /* Ad Clicks per Date */

                    for (var i = 0; i< data['ad_graphic']['ad_clicks_per_date'].length; i++) {
                        if ((data['ad_graphic']['ad_clicks_per_date'][i])) {
                            ad_clicksDate_value.push(data['ad_graphic']['ad_clicks_per_date'][i]['clicks']);
                            ad_clicksDate_label.push(data['ad_graphic']['ad_clicks_per_date'][i]['fecha']);
                        }
                        // console.log(field_value2);
                    }

                    var ctx2 = $('#adClicks_per_date');
                    var ad_clicks_chart = {
                        labels: ad_clicksDate_label,
                        datasets: [{
                            label: 'Ad Clicks',
                            backgroundColor: 'rgba(105, 132, 255, 0.4)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: ad_clicksDate_value

                        }]
                    };
                    var adClicksGraph = new Chart(ctx2, {
                        type: 'line',
                        options: {
                            title: {
                                display: true,
                                text: 'CLICS EN ANUNCIOS POR FECHA'
                            }
                        },
                        data: ad_clicks_chart
                    });

                    /* Page Impressions Per Age */ 

                        for (var i = 0; i < data['page_graphic']['page_impressions_per_age'].length; i++) {
                            if ((data['page_graphic']['page_impressions_per_age'][i])) {
                                page_impressions_value.push(data['page_graphic']['page_impressions_per_age'][i]['value']);
                                page_impressions_label.push(data['page_graphic']['page_impressions_per_age'][i]['key']);
                            }
                            // console.log(field_value2);
                        }


                    var ctx3 = $("#impressions_per_age");
                    var impressions_per_age_chart = {
                        labels: page_impressions_label,
                        datasets: [{
                            label: 'Impressions',
                            backgroundColor: 'rgba(178, 5, 230, 0.4)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: page_impressions_value

                        }]
                    };
                    var impressionsPerAgeGraph = new Chart(ctx3, {
                        type: 'line',
                        options: {
                            title: {
                                display: true,
                                text: 'IMPRESIONES DE PÁGINA POR EDAD'
                            }
                        },
                        data: impressions_per_age_chart
                    });

                    /**
                     * 
                     * Ad Clicks per Age
                     *
                     */

                    for (var i = 0; i < data['ad_graphic']['ad_clicks_per_age'].length; i++) {
                        if ((data['ad_graphic']['ad_clicks_per_age'][i])) {
                            ad_cliksAge_value.push(data['ad_graphic']['ad_clicks_per_age'][i].value);
                            ad_cliksAge_label.push(data['ad_graphic']['ad_clicks_per_age'][i].key);
                        }
                    }

                    var ctx4 = $("#adClicks_per_age");
                    var ad_cliksAge_chart = {
                        labels: ad_cliksAge_label,
                        datasets: [{
                            label: 'Ad Clicks',
                            backgroundColor: '#ff4040',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: ad_cliksAge_value
                        }]
                    };
                    var adCliksAgeGraph = new Chart(ctx4, {
                        type: 'bar',
                        options: {
                            title: {
                                display: true,
                                text: 'CLICS EN ANUNCIOS POR EDAD'
                            }
                        },
                        data: ad_cliksAge_chart
                    });

                    /***
                     * Likes Evolution Graphic
                     */

                    for (var i = 0; i < data['page_graphic']['posts_like_per_day'].length; i++) {
                        if ((data['page_graphic']['posts_like_per_day'][i])) {
                            likes_evolution_value.push(data['page_graphic']['posts_like_per_day'][i]);
                            likes_evolution_label.push(data['page_graphic']['end_time'][i]);
                        }
                    }

                    var ctx5 = $("#likes_evolution");
                    var likes_evolution_chart = {
                        labels: likes_evolution_label,
                        datasets: [{
                            label: 'Ad Clicks per Age',
                            backgroundColor: 'rgba(70,137,80,0.4)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: likes_evolution_value
                        }]
                    };
                    var likesEvolutionGraph = new Chart(ctx5, {
                        type: 'line',
                        options: {
                            title: {
                                display: true,
                                text: 'EVOLUCIÓN DEL "ME GUSTA"'
                            }
                        },
                        data: likes_evolution_chart
                    });

                    // $.each(ad_shares, function (index, value) {
                    //     ad_shares_count = ad_shares_count + Number(value);
                    // });
                    // //  console.log(ad_shares_count);

                    // var ctx6 = $("#shares");
                    // var shares_chart = {
                    //     labels: ['Diciembre'],
                    //     datasets: [{
                    //         label: '#Count',
                    //         backgroundColor: 'rgba(70,137,80,0.4)',
                    //         borderColor: 'rgba(200, 200, 200, 0.75)',
                    //         hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                    //         hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    //         data: [ad_shares_count]
                    //     }]
                    // };
                    // var sharesGraph = new Chart(ctx6, {
                    //     type: 'line',
                    //     options: {
                    //         title: {
                    //             display: true,
                    //             text: 'Shares Graphic'
                    //         }
                    //     },
                    //     data: shares_chart
                    // });
                },
                error: function (xhr) {
                    return false;
                }
            }),
            $.ajax({
                //Seconds Request
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
        ).then(function () {

            dashboard.append(result2);
        });
    });
});