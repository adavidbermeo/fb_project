$(document).ready(function () {
    $("td a").click(function (event) {
        event.preventDefault();
        var selected = $(this).attr('href');
        // var ad = $("#ad").attr('href');
        // var page = $("#page").attr('href');

        $.ajax({
            url: "preview/ads_preview.php",
            type: "get", //send it through get method
            data: {
                selected: selected,
            },
            success: function (response) {
                $("#ad-preview").html(response);
            },
            error: function (xhr) {
                return false;
            }
        });
    });
});
