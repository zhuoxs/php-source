(function($){
	$.fn.commentImg = function(options){
		var defaults = {
			activeClass: 'current',
        	nextButton: '.next',
        	prevButton: '.prev',
			imgNavBox:'.photos-thumb',
			imgViewBox:'.photo-viewer'
		};
		var opts = $.extend({},defaults, options);

		this.each(function(){
			var _this =$(this),
				imgNav =_this.find(opts.imgNavBox).children(),
				imgViewBox =_this.find(opts.imgViewBox),
				prevBtn = _this.find(opts.prevButton),
				nextBtn = _this.find(opts.nextButton),
				src = '',
				img = new Image();
				
			function setViewImg(viewSrc){
				img.src = viewSrc;
	            img.onload = function () {
					var imageWidth = '500px';
					var imageHeight = '500px';
					imgViewBox.show(0,function(){
						$(this).css({ "max-width": imageWidth, "max-height": imageHeight }).find("img").attr('src', src);
					});
	            }	            
			}
			
			imgNav.on("click",function(){
				$(this).toggleClass(opts.activeClass).siblings().removeClass(opts.activeClass);			
				if($(this).hasClass(opts.activeClass)){
					src = $(this).attr('data-src');	
		            setViewImg(src);
				}else{
					imgViewBox.css({ "width": 0, "height": 0 }).hide();
				}
			});
			
			imgViewBox.on("click",function(){
				imgNav.removeClass(opts.activeClass);			
				$(this).css({ "width": 0, "height": 0 }).hide();
			});
			
			prevBtn.hover(function () {				
	            var index = imgNav.index(_this.find(opts.imgNavBox).children("." + opts.activeClass));	            
	            if (index < 1) {
	                $(this).css({"cursor":"default"}).children().hide();	      
	            } else {
	                $(this).css({"cursor":"pointer"}).children().show();
	            }
	        }, function () {
	            $(this).css({"cursor":"default"}).children().hide();
	        });	
	        
	        nextBtn.hover(function () {
	            var index = imgNav.index(_this.find(opts.imgNavBox).children("." + opts.activeClass));	            
	            if (index >= imgNav.length - 1) {
	                $(this).css({"cursor":"default"}).children().hide();		                
	            } else {
	                $(this).css({"cursor":"pointer"}).children().show();
	            }
	        }, function () {
	            $(this).css({"cursor":"default"}).children().hide();
	        });
	        
	        prevBtn.on("click",function (e) {
	        	e.stopPropagation();
	            var index = imgNav.index(_this.find(opts.imgNavBox).children("." + opts.activeClass));            	            
	            if (index > 0) {
	            	index--;
	            	imgNav.eq(index).toggleClass(opts.activeClass).siblings().removeClass(opts.activeClass);
                	src = imgNav.eq(index).attr('data-src');	
		            setViewImg(src);
	            }            
	            if (index <= 0) {	          
	                $(this).css({"cursor":"default"}).children().hide();
	            }
	        });
	        
	        nextBtn.on("click",function (e) {
	        	e.stopPropagation();
	            var index = imgNav.index(_this.find(opts.imgNavBox).children("." + opts.activeClass));
	            if (index < imgNav.length - 1) {
	            	index++;
	            	imgNav.eq(index).toggleClass(opts.activeClass).siblings().removeClass(opts.activeClass);
	            	src = imgNav.eq(index).attr('data-src');	
		            setViewImg(src);	
	    		}
	            if (index >= imgNav.length - 1) {
	                $(this).css({"cursor":"default"}).children().hide();
	            }
	        })
				
		})
	
	}

})(jQuery);


