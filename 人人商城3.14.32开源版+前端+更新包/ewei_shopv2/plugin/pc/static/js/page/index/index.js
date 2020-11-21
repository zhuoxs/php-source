window.onload = function () {
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        // nextButton: '.swiper-button-next',
        // prevButton: '.swiper-button-prev',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });

};

$(function(){
    // //定义当前时间
    // var startTime = new Date();
    // //定义结束时间
    // var endTime = new Date("2019/5/31 10:25:00");

    //算出中间差并且已毫秒数返回; 除以1000将毫秒数转化成秒数方便运算；

    // var intDiff = parseInt($('#seckill_end_time').val());
    var intDiff = parseInt($('#seckill_end_time').val());
    timer(intDiff);
});