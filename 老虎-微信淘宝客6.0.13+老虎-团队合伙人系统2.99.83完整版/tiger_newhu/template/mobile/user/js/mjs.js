















//返回顶部
$(".xxxxxxxxx").click(function(){
		$('html, body').animate({scrollTop:0}, 600);
});

//
var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: true,
        autoplay: 3000,
        autoplayDisableOnInteraction: false
    });