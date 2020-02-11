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
        // var ad = $("#ad").attr('href');
        // var page = $("#page").attr('href');

        $.ajax({
            url: "functions/click_dashboard.php",
            type: "get", //send it through get method
            data: {
                selected: selected,
            },
            cache: false,
            success: function (response) {
                $(".business-manager-info").html(response);
                $('.con-loader').css(
                    "display", "none"
                );
            },
            error: function (xhr) {
                return false;
            }
        });
    });
});
