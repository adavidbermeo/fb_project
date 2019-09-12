$(document).ready(function () {
    $("td button").click(function (event) {
        event.preventDefault();

        var btnId = $(this).attr('id');
        // var ad = $("#ad").attr('href');
        // var page = $("#page").attr('href');

        $.ajax({
            url: "preview/preview.php",
            type: "post", //send it through get method
            data: {
                btnId: btnId,
            },
            success: function (response) {
                $(".popup").html(response);
            },
            error: function (xhr) {
                return false;
            }
        });
    });
});