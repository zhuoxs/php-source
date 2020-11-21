	$(".icon_drop-down").click(function(){
			 if($(".div_display").css("display")=="none"){
               	$(".div_display").css("display","block");
               	$(".icon_drop-down").css({'background-image':'url(img/icon_drop-down.png)'});
               }else{
               	$(".div_display").css("display","none");
               	$(".icon_drop-down").css({'background-image':'url(img/icon_drop-down02.png)'});
               }
       });
       $(".icon_personal").click(function(){
       	     $(".div_model").css("display","block");
       	     $(".div_model").addClass("animation01");
       });
       $(".model_none").click(function(){
       	     $(".div_model").css("display","none");
       });
       
$(".the_eyes").click(function(){
       	     if($("#password").attr('type') == 'password'){
       	     	$("#password").attr('type','text');
       	     	$(".the_eyes").css({'background-image':'url(img/icon_open_eyes.png)'});
       	     }else{
       	     	$("#password").attr('type','password');
       	     	$(".the_eyes").css({'background-image':'url(img/icon_close_eyes.png)'});
       	     }
       });