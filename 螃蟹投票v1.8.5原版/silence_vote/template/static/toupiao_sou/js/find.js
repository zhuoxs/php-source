$(function(){
	
	/*顶部nav*/
	var swiper = new Swiper('.nav-container', {
        slidesPerView: 'auto',
        paginationClickable: true
    });
    $(".nav-ul .swiper-slide").click(function(){
    	$(this).addClass("active-li").siblings().removeClass("active-li");
    });
    
    
    
    
    /*瀑布流初始化设置*/
	var $grid = $('.grid').masonry({
		itemSelector : '.grid-item',
		gutter:10
    });
    // layout Masonry after each image loads
	$grid.imagesLoaded().done( function() {
		console.log('uuuu===');
	  $grid.masonry('layout');
	});
	   var pageIndex = 0 ; var dataFall = [];
	   var totalItem = 10;
	   $(window).scroll(function(){
	   	$grid.masonry('layout');
                var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();  
                if(scrollTop + windowHeight == scrollHeight){
                        $.ajax({
	               		dataType:"json",
				        type:'get',
				        url:'./article.json',
			            success:function(result){
			            	dataFall = result.result.article;
			            	setTimeout(function(){
			            		appendFall();
			            	},500)
			            },
			            error:function(e){
			            	console.log('请求失败')
			            }
			            
	                   })
                	
                }
                
         })  
 

        
        function appendFall(){
          $.each(dataFall, function(index ,value) {
          	var dataLength = dataFall.length;
          	$grid.imagesLoaded().done( function() {
	        $grid.masonry('layout');
	           });
	      var detailUrl;
      	  var $griDiv = $('<div class="grid-item item">');
      	  var $img = $("<img class='item-img'>");
      	  $img.attr('src',value.articlePic).appendTo($griDiv);
      	  var $section = $('<section class="section-p">');
      	  $section.appendTo($griDiv);
      	  var $p1 = $("<p class='title-p'>");
      	  $p1.html(value.title).appendTo($section);
      	  var $p2 = $("<p class='name-p'>");
      	  $p2.html(value.name).appendTo($section);
      	  var $p3 = $("<p class='price-p'>");
      	  $p3.html(value.commentCount).appendTo($section);
      	  var $items = $griDiv;
		  $items.imagesLoaded().done(function(){
				 $grid.masonry('layout');
	             $grid.append( $items ).masonry('appended', $items);
			})
           });
        }
    
    
    
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
})
