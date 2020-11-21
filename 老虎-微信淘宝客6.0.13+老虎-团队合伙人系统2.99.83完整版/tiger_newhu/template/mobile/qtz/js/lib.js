$(function(){

    $('.header-nav-list .item').each(function(){
        $(this).data('left', $(this).offset().left);
        // console.log($(this).offset().left);
    })

    var index = 0;
    $('.header-nav').on('click', function(){
        var offsetTop = $(this).offset().top.toFixed(0);
        $('body, html').animate({scrollTop: offsetTop},300)
    }).on('click', '.js-nav-item', function(){
        index = $(this).index();
        goToPage(index);
    }).on('click', '.js_nav', function(){
        if (!$(this).hasClass('open')) {
            $(this).addClass('open')
            $('.pop-bg').stop(true, true).fadeIn();
            $('.header-nav-cont').addClass('open');
            $('body').css('overflow-y', 'hidden');
            $('.slot-tabs').addClass('fix-top')
        } else {
            $('body').css('overflow-y', 'auto');
            $(this).removeClass('open')
            $('.pop-bg').stop(true, true).fadeOut();
            $('.header-nav-cont').removeClass('open');
            $('.slot-tabs').removeClass('fix-top');
        }
    });

    $('.header-nav-cont').on('click', '.js-nav-item', function(){
        $('body').css('overflow-y', 'auto');
        index = $(this).index();
        goToPage(index);
        $('.js_nav').removeClass('open')
        $('.pop-bg').stop(true, true).fadeOut();
        $('.header-nav-cont').removeClass('open');
        var offsetLeft = $('.header-nav-list .item').eq(index).data('left');
        $('.header-nav-list').animate({scrollLeft: offsetLeft},300);
    })
    $('.pop-bg').click(function  () {
        $('.header-nav-cont').removeClass('open');
        $('body').css('overflow-y', 'auto');
        $(this).stop(true, true).fadeOut();
        $('.js_nav').removeClass('open');
        $('.slot-tabs').removeClass('fix-top');
    })
    function to_top () {
        if ($(window).scrollTop()>0) {
        $(".to-top").show()
        }else{
            $(".to-top").hide()
        }
    };to_top();

    $(window).scroll(function  () {
        to_top();
    })


    $(".to-top").click(function() {
        var _id = $(this).attr('href');
        $('html,body').stop().animate({
            scrollTop: $(_id).offset().top-84
        }, 1000);
        return false;
    });

})

function goToPage(s){

    $('.js-nav-item').parent().each(function(){
        $(this).find('.js-nav-item').eq(s).addClass('active').siblings().removeClass('active');
    });

}