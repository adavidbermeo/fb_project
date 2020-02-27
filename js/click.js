$(document).ready(function () {
    $('.search-option').click(
        function () {
            $('.con-loader').css(
                "display", "block"
            );
        }
    );
    $(".menu .search-option").click(function (event) {
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
            cache:false,
            success: function (response) {
                $('.business-manager-info').html(response).show();
                $(".business-manager-info").find("#datepicker3,#datepicker4").datepicker({
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 3,
                    showButtonPanel: true,
                    minDate: '-5y',
                    maxDate: 0
                });
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
