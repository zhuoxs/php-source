$(function () {
    require(['core'], function (core) {
        $(document).off('click', '.fui-list-angle');
        $(document).on('click', '.fui-list-angle', function (e) {
            e.preventDefault()
        });
        $(".btn-more").unbind('click').click(function () {
            $(".head-menu-mask").fadeToggle();
            $(".head-menu").fadeToggle();
            $(".fundot").removeClass('active');
            $(".funmenu").addClass('out').removeClass('in')
        });
        $(".head-menu-mask").unbind('click').click(function () {
            $(".head-menu-mask").fadeOut();
            $(".head-menu").fadeOut()
        });
        $(document).off('click', '.fundot');
        $(document).on('click', '.fundot', function () {
            $(".fundot").not(this).removeClass('active');
            $(".funmenu").not(this).addClass('out').removeClass('in');
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).next('.funmenu').removeClass('in').addClass('out')
            } else {
                $(this).addClass('active');
                $(this).next('.funmenu').removeClass('out').addClass('in')
            }
        })
    })
});