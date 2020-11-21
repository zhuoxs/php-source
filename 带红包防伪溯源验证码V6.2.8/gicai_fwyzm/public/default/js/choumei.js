// JavaScript Document
 var mySwiper = new Swiper('.swiper-container',{
	  slidesPerView : 'auto',
	  centeredSlides : true,
	  watchSlidesProgress: true,
	  pagination : '.swiper-pagination',
	  paginationClickable: true,
      paginationBulletRender: function (index, className) {
		  switch (index) {
  case 0: name='洗';break;
  case 1: name='剪';break;
  case 2: name='烫';break;
  case 3: name='染';break;
  case 4: name='护';break;
  case 5: name='套';break;
  default: name='';
}

      return '<span class="' + className + '"><i>' + name + '</i></span>';
      },
	  onProgress: function(swiper){
        for (var i = 0; i < swiper.slides.length; i++){
          var slide = swiper.slides[i];
          var progress = slide.progress;
		  scale = 1 - Math.min(Math.abs(progress * 0.2), 1);
        
         es = slide.style;
		 es.opacity = 1 - Math.min(Math.abs(progress/2),1);
				es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = 'translate3d(0px,0,'+(-Math.abs(progress*150))+'px)';

        }
      },

     onSetTransition: function(swiper, speed) {
      	for (var i = 0; i < swiper.slides.length; i++) {
				es = swiper.slides[i].style;
				es.webkitTransitionDuration = es.MsTransitionDuration = es.msTransitionDuration = es.MozTransitionDuration = es.OTransitionDuration = es.transitionDuration = speed + 'ms';
		}

      }
  });