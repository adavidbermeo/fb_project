$(document).ready(function () {
     $('.search-option').click(
         function () {
            $('.con-loader').css(
                "display", "block"
            );
         }
     );
    $(".buttons a").click(function (event) {
        event.preventDefault();

        var selected = $(this).attr('href');
        // var ad = $("#ad").attr('href');
        // var page = $("#page").attr('href');

        $.ajax({
            url: "functions/click.php",
            type: "get", //send it through get method
            data: {
                selected: selected,
            },
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
