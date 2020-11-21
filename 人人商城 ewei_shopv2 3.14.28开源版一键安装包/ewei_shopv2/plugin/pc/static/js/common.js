$(function () {
    $('img').on('error', function () {
        $(this).attr('src', staticPath + 'images/invalid-image.png')
    })
});
