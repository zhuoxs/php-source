define([], function () {
    var modal = {};
    modal.init = function () {
        $('.card-item').click(function () {
            var name = $(this).attr('id');
            $('.card_style').val(name);
            $(this).addClass('active').siblings().removeClass('active');
        })
    };
    return modal;
});