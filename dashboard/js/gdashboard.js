$(document).ready(function () {
    $(".menu #custom-dashboard").click(function (event) {
        event.preventDefault();

        var data = $(this).attr('href');

        //$(".business-manager-info").html('<div id="chart-container"><canvas id="mycanvas"></canvas></div>');
        $.ajax({
            url: "dashboard/account_dashboard.php",
            type: "POST", //send it through get method
            data: {
                data: data,
            },
            success: function (response) {
                //console.log(response);
                    $(".business-manager-info").html(response);
            },
        });
    });
});
