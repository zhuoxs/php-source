/**
 * Input框里的灰色提示，使用前先引入jquery 
 * <br>使用方法：&lt;input type=&quot;text&quot; tipMsg=&quot;您的用户名&quot;&nbsp;&nbsp; /&gt;
 * 
 * @return
 */
(function($){
    $.fn.inputTipText = function(options) {
        var defaults={
            pwd :'',        // 需要把type修改为password的id多个用,隔开
        };
        var options = $.extend({},defaults,options);
        var pwds = options.pwd.split(",");
        
        var contains = function (element) {
              
              for (var i = 0; i < pwds.length; i++) {
                  if (pwds[i] == element) {
                      return true;
                  }
              }
              return false;
        }
        
    	return $(this).each(function(){
    		if($(this).val() == ""){
    			var oldVal=$(this).attr("tipMsg");
        		if($(this).val()==""){
        		    $(this).attr("value",oldVal);
                    if (contains($(this).attr('id'))) {
                        try{$(this)[0].type = 'text';}catch(e){$(this).val("");}
                    }
        		}
        		$(this)
        		   .css({"color":"#BBB"})     //灰色
        		   .focus(function(){
        		       if($(this).val() != oldVal){
        		           if (contains($(this).attr('id'))) {
        		               try{$(this)[0].type = 'password';}catch(e){$(this).val("");}
        		           }
                           $(this).css({"color":"#000"});
        		       }else{
                           $(this).val("").css({"color":"#BBB"});
                           if (contains($(this).attr('id'))) {
                               try{$(this)[0].type = 'password';}catch(e){$(this).val("");}
                           }
        		       }
        		       $(this).parents('dl:first').addClass('focus');

        		   })
        		   .blur(function(){
        		       if($(this).val()==""){
        		           $(this).val(oldVal).css({"color":"#BBB"})
                           if (contains($(this).attr('id'))) {
                               try{$(this)[0].type = 'text';}catch(e){$(this).val("");}
                           }
        		       } else {
                           if($(this).val() != oldVal){
                               if (contains($(this).attr('id'))) {
                                   try{$(this)[0].type = 'password';}catch(e){$(this).val("");}
                               }
                           }else{
                               if (contains($(this).attr('id'))) {
                                   try{$(this)[0].type = 'text';}catch(e){$(this).val("");}
                               }
                           }
        		       }
        		       $(this).parents('dl:first').removeClass('focus');
        		   })
        		   .keydown(function(){$(this).css({"color":"#000"})});
    		}
    	});
    }

})(jQuery);