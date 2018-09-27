$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function playGames() {
    $.ajax({
        url: 'games/play',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var msg = JSON.parse(xhr.responseText);
            alertify.error(msg.message);
        }
    });
}