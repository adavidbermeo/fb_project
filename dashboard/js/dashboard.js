var data = '';
var result2 = '';
$(document).ready(function () {
    
    $('#create-dashboard').click(
        function () {
            $('.con-loader').css(
                "display", "block"
            );
        }
    );
    $("#create-dashboard").click(function (event) {
        event.preventDefault();

        var selected = $("#data").val();
        var start_time = $(".first-option").val();
        var end_time = $(".second-option").val();
        var coloR = [];

        // var result1;
        var canvas = ['page_views_per_date', 'adClicks_per_date', 'impressions_per_age', 'adClicks_per_age']; //, 'impressions_per_age', 'adClicks_per_date','adClicks_per_age'
        var likes_evolution = 'likes_evolution';
        var selector = $(".business-manager-info");
        var dashboard = $(".graphic-dashboard");

        var dynamicColors = function () {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            var a = 0.4;
            return "rgb(" + r + "," + g + "," + b + "," + a + ")";
        };

        for (var i in selected) {
            coloR.push(dynamicColors());
        }

        // Campaign Graphics

        $.when(
            $.ajax({
                url: "dashboard/getGraphics.php",
                type: "POST", //send it through get method
                data: {
                    selected: selected,
                    start_time: start_time,
                    end_time: end_time
                },
                cache: false,
                success: function (response) {
                    $(".delete").remove();
                    $(dashboard).html('');
                    $(dashboard).html(
                        '<div class="calendar-section">'+
                            '<p>Fecha Inicial : <input type="date" id="date1" class="first-option" name="start-date" autofocus step="1" min="2000-12-1" max="" value="" required=""></p><br>'+    
                            '<p>Fecha Final   : <input type="date" id="date2" class="second-option" name="end-date" autofocus step="1" min="2000-12-1" max="" value="" required=""></p>'+
                            '<input type="hidden" id="data" value="'+ selected +'">'+    
                            '<input type="button" value="VER REPORTE" id="create-dashboard">'+
                        '</div><script src="dashboard/js/dashboard.js"></script>');

                    $(dashboard).css(
                        "display", "block"
                    );

                    data = JSON.parse(response);
                    selector.css(
                        "display", "none"
                    );
                    dashboard.append('<div class="dash-section"><h1><i class="fas fa-signal fb-icon"></i> Reporte Estadistico General - Facebook Business </h1><div><br>');

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

                    var ctve_likes_evolution_value = [];
                    var ctve_likes_evolution_label = [];


                    // for (var i = 0; i < 5; i++) {
                    if (data['page_graphic']) {
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

                    for (var i = 0; i < data['ad_graphic']['ad_clicks_per_date'].length; i++) {
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
                            backgroundColor: coloR,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: page_impressions_value

                        }]
                    };
                    var impressionsPerAgeGraph = new Chart(ctx3, {
                        type: 'pie',
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
                            backgroundColor: coloR,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: ad_cliksAge_value
                        }]
                    };
                    var adCliksAgeGraph = new Chart(ctx4, {
                        type: 'pie',
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
                    for (var i = 0; i < data['page_graphic']['ctve_posts_like_per_day'].length; i++) {
                        if ((data['page_graphic']['ctve_posts_like_per_day'][i])) {
                            ctve_likes_evolution_value.push(data['page_graphic']['ctve_posts_like_per_day'][i]);
                            ctve_likes_evolution_label.push(data['page_graphic']['ctve_end_time'][i]);
                        }
                    }

                    var ctx5 = $("#likes_evolution");
                    var likes_evolution_chart = {
                        labels: likes_evolution_label,
                        datasets: [{
                            label: 'Me gusta',
                            backgroundColor: 'rgba(70,137,80,0.4)',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: likes_evolution_value
                        },{
                            label: 'Me gusta (Pasado)',
                            backgroundColor: '#ff6836',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: ctve_likes_evolution_value
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
                    start_time: start_time,
                    end_time: end_time
                },
                cache: false,
                success: function (response) {
                    result2 = JSON.parse(response);
                    var mssgMayor = 'mayor que el periodo anterior';
                    var mssgMenor = 'menor que el periodo anterior';
                    console.log(result2);

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
                    
                     $(document).on("click", ".post-mdal", function () {

                         var ClickedImg = $(this).attr("href");

                         // You can make an ajax call here if you want. 
                         // Get the data and append it to a modal body.


                        $(".modal-body").html("<img src='" + result2['post_insights']['bimg'][ClickedImg] + "'></img>");
                        $('#redirect').html('See Post');
                        $('#redirect').attr('href', 'https://www.facebook.com/'+ result2['post_insights']['id_page'] +'/posts/'+ result2['post_insights']['post_ids'][ClickedImg]);
                        $('#exampleModalCenter').modal('show');

                     });

                    /* Vision General de la pagina */
                    var texto = '<div class="dash-section">' +
                        '<h3><i class="fab fa-facebook fb-icon" ></i> Visión general de la página </h3>' +
                        '<table id="page-overview" class="overview-table">' +
                        '<tr>' +
                            '<th>Impresiones de Pagina</th>' +
                            '<th>Interaccion de Usuarios</th>' +
                            '<th>Me gusta (Pagina)</th>' +
                        '</tr>' +
                        '<tr>';
                        var fields = {
                            'page_impressions':'ctve_page_impressions', 
                            'page_post_engagements':'ctve_page_post_engagements',
                            'page_fans':'ctve_page_fans'
                        };
                          $.each(fields, function (index, value) {
                                if ((result2['page_insights'][value]) >= 0) {

                                    texto += '<td>' + number_format(result2['page_insights'][index], 0, ',', '.') + '<br>' +
                                        number_format(result2['page_insights'][value], 2, ',', '.') + '% ' + mssgMayor +
                                        '</td>';
                                }else {
                                    texto += '<td>' + number_format(result2['page_insights'][index], 0, ',', '.') + '<br>' +
                                        number_format(result2['page_insights'][value], 2, ',', '.') +'% '+ mssgMenor +
                                        '</td>';
                                }
                          });
                
                       texto += '</tr>' +
                        '<tr>' +
                            '<th>Nuevos Me Gusta (pagina)</th>' +
                            '<th>Paginas Vistas</th>' +
                            '<th>Impresiones de Publicaciones</th>' +
                        '</tr>' +
                        '<tr>';
                        
                        var fields = {
                            'total_new_likes': 'ctve_total_new_likes',
                            'page_views_total': 'ctve_page_views_total',
                            'page_posts_impressions': 'ctve_page_posts_impressions'
                        };
                        $.each(fields, function (index, value) {
                            if ((result2['page_insights'][value]) >= 0) {

                                texto += '<td>' + number_format(result2['page_insights'][index], 0, ',', '.') + '<br>' +
                                    number_format(result2['page_insights'][value], 2, ',', '.') + '% ' + mssgMayor +
                                    '</td>';
                            } else {
                                texto += '<td>' + number_format(result2['page_insights'][index], 0, ',', '.') + '<br>' +
                                    number_format(result2['page_insights'][value], 2, ',', '.') + '% ' + mssgMenor +
                                    '</td>';
                            }
                        });

                        texto += '</tr>' +
                        '</table>'+
                        '</div>';

                    dashboard.append(texto);

                    /* Vision general de los anuncios */
                    texto = 
                    '<div class="dash-section">' +
                            '<h3><i class="fas fa-ad fb-icon "></i> Visión general de los anuncios</h3>' +
                        '<table class="overview-table">' +
                            '<tr>' +
                                '<th>Clics</th>' +
                                '<th>CTR %</th>' +
                                '<th>Alcance</th>' +
                            '</tr>' +
                        '<tr>';
                         var fields = {
                             'total_clicks': 'ctve_total_clicks',
                             'total_ctr': 'ctve_total_ctr',
                             'total_reach': 'ctve_total_reach'
                         };
                         $.each(fields, function (index, value) {
                             if ((result2['ad_insights'][value]) >= 0) {

                                 texto += '<td>' + number_format(result2['ad_insights'][index], 0, ',', '.') + '<br>' +
                                     number_format(result2['ad_insights'][value], 2, ',', '.') + '% ' + mssgMayor +
                                     '</td>';
                             } else {
                                 texto += '<td>' + number_format(result2['ad_insights'][index], 0, ',', '.') + '<br>' +
                                     number_format(result2['ad_insights'][value], 2, ',', '.') + '% ' + mssgMenor +
                                     '</td>';
                             }
                         });
                    texto +=
                        '</tr>' +
                        '<tr>' +
                            '<th>Impresiones</th>' +
                            '<th>Gastado</th>' +
                            '<th>CPM Medio</th>' +
                        '</tr>' +
                        '<tr>';
                        var fields = {
                            'total_impressions': 'ctve_total_impressions',
                            'total_spend': 'ctve_total_spend',
                            'total_cpm': 'ctve_total_cpm'
                        };
                        $.each(fields, function (index, value) {
                            if ((result2['ad_insights'][value]) >= 0) {

                                texto += '<td>' + number_format(result2['ad_insights'][index], 0, ',', '.') + '<br>' +
                                    number_format(result2['ad_insights'][value], 2, ',', '.') + '% ' + mssgMayor +
                                    '</td>';
                            } else {
                                texto += '<td>' + number_format(result2['ad_insights'][index], 0, ',', '.') + '<br>' +
                                    number_format(result2['ad_insights'][value], 2, ',', '.') + '% ' + mssgMenor +
                                    '</td>';
                            }
                        });
                    
                    texto +=
                        '</tr>' +
                        '</table' +
                        '</div>';

                        dashboard.append(texto);
                    // /* Rendimiento de la pagina por fecha */

                    // dashboard.append(
                    //     '<div class="dash-section">' +
                    //     '<h3> <i class="fas fa-ad fb-icon"></i> Rendimiento de la pagina por fecha </h3>' +
                    //     '<table id="page-performance" class="dash-fanscity-table">' +
                    //     '<thead>' +
                    //     '<tr>' +
                    //     '<th class="dark-blue"><h4> Ciudad </h4></th>' +
                    //     '<th class="age-gender"> Me gusta </th>' +
                    //     '<th class="age-gender"> Alcance de la pagina </th>' +
                    //     '</tr>' +
                    //     '</thead>' +
                    //     '<tbody>' +
                    //     '</tbody>' +
                    //     '</table>' +
                    //     '</div>');

                    // $.each(result2['page_insights'].fans_city_keys, function (index, value) {

                    //     var rowIndex = $('#page-performance').dataTable().fnAddData([
                    //         value,
                    //         number_format(result2['page_insights']['fans_city'][value], 0, ',', '.'),
                    //         number_format(result2['page_insights']['total_reach'][index], 0, ',', '.')
                    //     ]);

                    //     var row = $('#page-performance').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', value);

                    // });

                    // $('#page-performance').DataTable({
                    //      pageLength: 5,
                    //      lengthMenu: [
                    //          [5, 10, 20, -1],
                    //          [5, 10, 20, 'Todos']
                    //      ]
                    //  })

                    /* Principales Publicaciones */
                    // dashboard.append(
                    //     '<div class="dash-section">' +
                    //     '<h3> <i class="fas fa-ad fb-icon"></i> Principales Publicaciones </h3>' +
                    //     '<table id="main-publications" class="overview-table">' +
                    //     '<thead>' +
                    //     '<tr>' +
                    //         '<th>Publicaciones</th>' +
                    //         '<th>Impresiones de la publicación</th>' +
                    //         '<th>Impresiones pagas de la publicación</th>' +
                    //         '<th>Impresiones organicas de la publicación</th>' +
                    //         '<th>Comentarios</th>' +
                    //         '<th>Compartidos</th>' +
                    //         '<th>Interacciones con la publicación</th>' +
                    //     '</tr>' +
                    //     '</thead>' +
                    //     '<tbody>' +
                    //     '</tbody>' +
                    //     '</table>' +
                    //     '</div>');
                    // $.each(result2['post_insights']['ad_ids'], function (index, value) {
                    //     var rowIndex = $('#main-publications').dataTable().fnAddData([
                    //         '<a href="' + index + '" class="btn btn-primary post-mdal" data-toggle="modal" data-target="#exampleModalCenter"><img class="dash-img" src="' + result2['post_insights']['ad_image'][index] + '"></img></a>',
                    //         number_format(result2['post_insights']['total_impressions'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['impressions_paid'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['impressions_organic'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['comments'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['shares'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['interactions'][index], 0, ',', '.')
                    //     ]);

                    //     var row = $('#main-publications').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', result2['post_insights']['total_impressions'][index]);
                    // });
                    // $('#main-publications').dataTable({
                    //     "pageLength": 5
                    // });

                    /* Reacciones de publicaciones */
                    // dashboard.append(
                    //     '<div class="dash-section">' +
                    //     '<h3> <i class="fas fa-puzzle-piece fb-icon"></i> Reaccciones de Publicaciones </h3>' +
                    //     '<table id="post-reactions" class="overview-table">' +
                    //     '<thead>' +
                    //     '<tr>' +
                    //     '<th> Publicaciones </th>' +
                    //     '<th> Reacciones Totales </th>' +
                    //     '<th class="csize"><i class="far fa-thumbs-up fa-2x"></i></th>' +
                    //     '<th class="csize"><i class="fas fa-heart fa-2x"></i></th>' +
                    //     '<th class="csize"><i class="far fa-surprise fa-2x"></i></th>' +
                    //     '<th class="csize"><i class="far fa-laugh-squint fa-2x"></i></th>' +
                    //     '<th class="csize"><i class="fas fa-sad-tear fa-2x"></i></th>' +
                    //     '<th class="csize"><i class="far fa-angry fa-2x"></i></th>' +
                    //     '</tr>' +
                    //     '</thead>' +
                    //     '<tbody>' +
                    //     '</tbody>' +
                    //     '</table>' +
                    //     '</div>');

                    // $.each(result2['post_insights']['ad_ids'], function (index, value) {
                    //     var rowIndex = $('#post-reactions').dataTable().fnAddData([
                    //         '<a href="' + index + '" class="btn btn-primary post-mdal" data-toggle="modal" data-target="#exampleModalCenter"><img class="dash-img" src="' + result2['post_insights']['ad_image'][index] + '"></img></a>',
                    //         number_format(result2['post_insights']['total_reactions'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['likes'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['love'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['wow'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['haha'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['sorry'][index], 0, ',', '.'),
                    //         number_format(result2['post_insights']['anger'][index], 0, ',', '.')
                    //     ]);

                    //     var row = $('#post-reactions').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', result2['post_insights']['total_reactions'][index]);
                    // });


                    /* Principales Conjuntos de Anuncios en Facebook */
                    // dashboard.append(
                    //     '<div class="dash-section">' +
                    //     '<h3> <i class="fas fa-puzzle-piece fb-icon"></i> Principales Conjuntos de Anuncios en Facebook </h3>' +
                    //     '<table id="adset-dashboard" class="overview-table">' +
                    //     '<thead>' +
                    //     '<tr>' +
                    //     '<th> Conjunto de Anuncios </th>' +
                    //     '<th> Clics </th>' +
                    //     '<th> CTR % </th>' +
                    //     '<th> Alcance </th>' +
                    //     '<th> Impresiones </th>' +
                    //     '<th> Gastado </th>' +
                    //     '<th> CPM </th>' +
                    //     '</tr>' +
                    //     '</thead>' +
                    //     '<tbody>' +
                    //     '</tbody>' +
                    //     '</table>' +
                    //     '</div>');

                    // $.each(result2['adset_insights']['adset_id'], function (index, value) {
                    //     var rowIndex = $('#adset-dashboard').dataTable().fnAddData([
                    //         result2['adset_insights']['adset_name'][index],
                    //         number_format(result2['adset_insights']['clicks'][index], 0, ',', '.'),
                    //         number_format(result2['adset_insights']['ctr'][index], 2, ',', '.'),
                    //         number_format(result2['adset_insights']['reach'][index], 0, ',', '.'),
                    //         number_format(result2['adset_insights']['impressions'][index], 0, ',', '.'),
                    //         number_format(result2['adset_insights']['spend'][index], 0, ',', '.'),
                    //         number_format(result2['adset_insights']['cpm'][index], 0, ',', '.')
                    //     ]);

                    //     var row = $('#adset-dashboard').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', result2['adset_insights']['adset_name'][index]);
                    // });

                    /* Principales Anuncios en Facebook */
                    // dashboard.append(
                    //     '<div class="dash-section">' +
                    //     '<h3> <i class="fas fa-puzzle-piece fb-icon"></i> Principales Anuncios en Facebook </h3>' +
                    //     '<pre>' +
                    //     '<table id="ads-dashboard" class="overview-table">' +
                    //     '<thead>' +
                    //     '<tr>' +
                    //     '<th> Ads </th>' +
                    //     '<th> Ad name </th>' +
                    //     '<th> Clicks </th>' +
                    //     '<th> CTR % </th>' +
                    //     '<th> Alcance </th>' +
                    //     '<th> Impresiones </th>' +
                    //     '<th> Gastado </th>' +
                    //     '<th> CPM Medio </th>' +
                    //     '</tr>' +
                    //     '</thead>' +
                    //     '<tbody>' +
                    //     '</tbody>' +
                    //     '</table>' +
                    //     '</pre>' +
                    //     '</div>');

                    // $.each(result2['ad_insights']['ad_ids'], function (index, value) {
                    //     var rowIndex = $('#ads-dashboard').dataTable().fnAddData([
                    //         '<a href="' + index + '" class="btn btn-primary ad-mdal" data-toggle="modal" data-target="#exampleModalCenter"><img class="dash-img" src="' + result2['ad_insights']['ad_image'][index] + '"></img></a>',
                    //         result2['ad_insights']['ad_name'][index],
                    //         number_format(result2['ad_insights']['clicks'][index], 0, ',', '.'),
                    //         number_format(result2['ad_insights']['ctr'][index], 2, ',', '.'),
                    //         number_format(result2['ad_insights']['reach'][index], 0, ',', '.'),
                    //         number_format(result2['ad_insights']['impressions'][index], 0, ',', '.'),
                    //         number_format(result2['ad_insights']['spend'][index], 0, ',', '.'),
                    //         number_format(result2['ad_insights']['cpm'][index], 0, ',', '.')
                    //     ]);
                    //     $('.btn btn-primary').click(function (event) {
                    //         var slected = $(this).attr('href');
                    //         console.log(slected);
                    //         $('.modal-body').html('<img class="dash-img" src="' + result2['ad_insights']['ad_image'][slected] + '">');
                    //     });
                    //     var row = $('#ads-dashboard').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', result2['ad_insights']['ad_name'][index]);
                    // });


                    // for (var i in data) {
                    //     data[i].nombre_extension = '<center>' + data[i].nombre_extension + '</center>';
                    //     var rowIndex = $('#dataTable').dataTable().fnAddData([
                    //         data[i].id_archivo,
                    //         data[i].nombre_archivo,
                    //         data[i].nombre_extension,
                    //         data[i].fecha_consulta
                    //     ]);
                    //     var row = $('#dataTable').dataTable().fnGetNodes(rowIndex);
                    //     $(row).attr('id', data[i].id_archivo);
                    // }

                },
                error: function (xhr) {
                    return false;
                }
            })
        ).then(function () {
             $('.con-loader').css(
                 "display", "none"
             );
            // dashboard.append(result2);
        });
    });
});