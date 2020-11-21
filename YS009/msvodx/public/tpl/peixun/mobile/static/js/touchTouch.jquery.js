(function(){
	
	$.fn.touchTouch = function(){

	var overlay = $('<div class="galleryOverlay">'),
		slider = $('<div class="gallerySlider">'),
		prevArrow = $('<a class="prevArrow"></a>'),
		nextArrow = $('<a class="nextArrow"></a>'),
		pageSpan = $('<div class="pagelimit"></div'),
		close=$('<div class="closed"></div'),
		overlayVisible = false;
		
		var placeholders = $([]),
			pl1=[],
			index = 0,
			items = this;
		overlay.hide().appendTo('body');
		slider.appendTo(overlay);
		pageSpan.appendTo(overlay);
		items.each(function(){
			placeholders = placeholders.add($('<div class="placeholder">'));
		
		});
	
		slider.append(placeholders).on('click',function(e){
			hideOverlay();			
		});
        
		$('body').on('touchstart', '.gallerySlider img', function(e){
			
			var touch = e.originalEvent,
				startX = touch.changedTouches[0].pageX;
	
			slider.on('touchmove',function(e){
				
				e.preventDefault();
				
				touch = e.originalEvent.touches[0] ||
						e.originalEvent.changedTouches[0];
				
				if(touch.pageX - startX > 10){
					slider.off('touchmove');
					showPrevious();
				}
				else if (touch.pageX - startX < -10){
					slider.off('touchmove');
					showNext();
				}
				 
			});

			return false;
			
			
		}).on('touchend',function(){
			slider.off('touchmove');
		});
		
	
		items.on('click', function(e){
			e.preventDefault();
			
			index = items.index(this);
			showOverlay(index);
			showImage(index);
			
			calcPages(items,index);
			preload(index+1);
			
			preload(index-1);
			offsetSlider1(index);
			$(document).data("overlayVisible",true);
			e.cancelBubble = true;
		});
		
		function calcPages(items,index){
			pageSpan.text((index+1)+"/"+items.length);
		}
		if ( !("ontouchstart" in window) ){
			overlay.append(prevArrow).append(nextArrow);
			
			prevArrow.click(function(e){
				e.preventDefault();
				showPrevious();
			});
			
			nextArrow.click(function(e){
				e.preventDefault();
				showNext();
			});
		}
		
		$(window).bind('keydown', function(e){
		
			if (e.keyCode == 37){
				showPrevious();
			}
			else if (e.keyCode==39){
				showNext();
			}
	
		});
		
		
		function showOverlay(index){
			
			if (overlayVisible){
				return false;
			}
			
			overlay.show();
			
			setTimeout(function(){
				overlay.addClass('visible');
			}, 100);
	
			offsetSlider1(index);
			
			overlayVisible = true;
		}
	
		function hideOverlay(){
			
			if(!overlayVisible){
				return false;
			}
			
			overlay.hide().removeClass('visible');
			overlayVisible = false;
			$(document).data("overlayVisible",overlayVisible);
		}
	
		function offsetSlider(index){
			slider.stop(true).animate({left:(-index*100)+'%'},500);
		}

		function offsetSlider1(index){
			// slider.stop(true).animate({left:(-index*100)+'%'},500);
			slider.css('left',(-index*100)+'%');
		}
	
		function preload(index){
			setTimeout(function(){
				showImage(index);
			}, 1000);
		}
		
		function showImage(index){
	
			if(index < 0 || index >= items.length){
				return false;
			}
			
			loadImage(items.eq(index).attr('href'), function(){
				placeholders.eq(index).html(this);
			});
		}
		
		function loadImage(src, callback){
			var img = $('<img>').on('load', function(){
				callback.call(img);
			});
			
			img.attr('src',src);
		}
		
		function showNext(){
			if(index+1 < items.length){
				index++;
				offsetSlider(index);
				preload(index+1);
				calcPages(items,index);
			}
			// return false;
		}
		
		function showPrevious(){
			
			if(index>0){
				index--;
				offsetSlider(index);
				preload(index-1);
				calcPages(items,index);
			}
		}
	};
	
})(jQuery);