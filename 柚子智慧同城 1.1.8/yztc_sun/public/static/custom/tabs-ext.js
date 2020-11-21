var tabs = tabs || {
	addTab : function(name, url, canclose){
		if(!$('.tabs-area').length){
			return false;
		}
		canclose = canclose || canclose == undefined;
		//判断是否已经存在
        var id = tabs.code(url);
        var $a = $("a[href='#"+id+"']");
        
        if($a.length){
        	try{
	            var iframe = $('iframe','#'+id)[0];
	            var oldurl = iframe.contentWindow.location.href;

	            if(oldurl.indexOf(url.replace('./','')) < 0){
	            	iframe.contentWindow.location.href = url;
	            }
        	}catch(e){

        	}
            $a.click();
            $a.parent()[0].scrollIntoView();
            return true;
        }

        var str = name;
        if (canclose) {
        	str += '<button type="button" class="close"><span aria-hidden="true">&times;</span></button>';
        }

        //添加页面
        var $nav_tabs = $('.tabs-area .nav-tabs');
        if(!$nav_tabs.length){
        	$('.tabs-area').append($('<ul class="nav nav-tabs" role="tablist"></ul>'));
        	$nav_tabs = $('.tabs-area .nav-tabs');
        }
        var $active = $('.active a',$nav_tabs);
        var id_active = $active.attr('href');

        var $li = $("<li><a href='#"+id+"' data-previd='"+id_active+"' data-toggle='tab'>"+str+"</a></li>");
        $nav_tabs.append($li);

        var $tab_content = $('.tab-content');
        if(!$tab_content.length){
        	$('.tabs-area').append($('<div class="tab-content">'));
        	$tab_content = $('.tab-content');
        }
        var $div = $("<div class='tab-pane' id='"+id+"'> <iframe src='"+url+"'></iframe> </div>");
        $('.tabs-area .tab-content').append($div);

        $("a[href='#"+id+"']").click()[0].scrollIntoView();
        return true;
	},
	delTab : function(id){
		var $a = $("a[href='"+id+"']");
		if ($a.parent().is('.active')) {
			var previd = $a.attr('data-previd');
	        var $prev_a = $("a[href='"+previd+"']");
	        if(!$prev_a.length){
	            $prev_a = $a.parent().next().find('a');
	        }
	        if(!$prev_a.length){
	            $prev_a = $a.parent().prev().find('a');
	        }
	        $prev_a.click();
		}
        
        $a.parent().remove();
        $(id).remove();
	},
	code : function(data){
	   if(data == '') return '';
	   var str =''; 
	   for(var i=0;i<data.length;i++)
	   {
	      str+=parseInt(data[i].charCodeAt(0),10).toString(16);
	   }
	   return str;
	}
};


$(document).on('click','.nav-tabs .close',function () {
	tabs.delTab($(this).parent().attr('href'));
});
$(document).on('click','a[target=blank]',function(){
	var href = $(this).attr('href');
	if (!href || href == 'javascript:;'){
		return ;
	}
	return !window.top.tabs.addTab($(this).text(),href);
	
});

// 添加滚动
  $('.scroll-left').click(function(event) {
    var $lis = $('.myscroll>li',$(this).parent());
    var $li = null;
    var left = $(this).offset().left+$(this).width();
    $lis.each(function(index, el) {
    	if ($(el).offset().left < left) {
    		$li = $(el);
    	}
    });
    if(!$li) return false;
    var $scroll = $(this).parent().find('.myscroll');
    $scroll.scrollLeft($scroll.scrollLeft()+ $li.offset().left - left);
  });
  $('.scroll-right').click(function(event) {
    var $lis = $('.myscroll>li',$(this).parent());
    var $li = null;
    var left = $(this).offset().left;
    $lis.each(function(index, el) {
    	if ($(el).offset().left+$(el).width() > left+2) {
    		var $scroll = $lis.parent();
		    $scroll.scrollLeft($scroll.scrollLeft()+ $(el).offset().left+$(el).width() - left);
		    console.log($scroll.scrollLeft()+ $(el).offset().left+$(el).width() - left);
		    return false;
    	}
    });
  });