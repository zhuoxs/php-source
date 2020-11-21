
$(".mengban").click(function(){
		$('.con1f').slideUp();
        $('.mengban').slideUp();
		$('.con1 li:last-child').css('background','url(images/xiajiantou.png) center center no-repeat');
});














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
	
	window.onload=function(){
var mySwiper2 = new Swiper('#swiper-container2',{
freeMode : true,
	  slidesPerView : 'auto',
	  freeModeSticky : true ,
})}
<!--
var demo = document.getElementById('demo');
var demo1 = document.getElementById('demo1');
var demo2 = document.getElementById('demo2');
var speed=50;    //滚动速度值，值越大速度越慢
var nnnddd=2000/demo1.offsetHeight;
for(i=0;i<nnnddd;i++){demo1.innerHTML+=demo1.innerHTML}
demo2.innerHTML = demo1.innerHTML    //克隆demo2为demo1
function Marquee(){
    if(demo2.offsetTop-demo.scrollTop<=0)    //当滚动至demo1与demo2交界时
        demo.scrollTop-=demo1.offsetHeight    //demo跳到最顶端
    else{
        demo.scrollTop++
    }
}
var MyMar = setInterval(Marquee,speed);        //设置定时器
demo.onmouseover = function(){clearInterval(MyMar)}    //鼠标经过时清除定时器达到滚动停止的目的
demo.onmouseout = function(){MyMar = setInterval(Marquee,speed)}    //鼠标移开时重设定时器
-->