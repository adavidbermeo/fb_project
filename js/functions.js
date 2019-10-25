/* Custom General Functions */
// Pop Up Function
function openDialog() {
    $('#overlay').show(3000);
    $('#popup').css('display', 'block');
    $('#popup').animate({
        'left': '30%'
    }, 300);
}

function closeDialog(id) {
    $('#' + id).css('position', 'absolute');
    $('#' + id).animate({
        'left': '-100%'
    }, 500, function () {
        $('#' + id).css('position', 'fixed');
        $('#' + id).css('left', '100%');
        $('#overlay').fadeOut('fast');
    });
}

// Custom Search
        
    