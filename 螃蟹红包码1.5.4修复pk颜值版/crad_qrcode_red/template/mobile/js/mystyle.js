$(document).ready(function(){
	        var scrollHeight = $('.zong').prop("scrollHeight");
				    var scroH = $('.zong').scrollTop(); //滚动高度  
			      var viewH = $('.zong').height(); //可见高度  
			      var contentH = $('.zong').get(0).scrollHeight; //内容高度  
					  var flag = 0;
					   doInter = setInterval(function () {
				         scroH = $('.zong').scrollTop(); //滚动高度  
				         console.log(flag+":"+scroH);
				         
					         flag = flag +1;
					         console.log('flag:'+flag);
 									if(scroH != 0){
				         		//跳出循环
				         		window.clearInterval(doInter);
				         	}
									if(flag == 5){
										console.log('flag = 5');
										$(".zong").animate({scrollTop:scrollHeight}, 1500);
										window.clearInterval(doInter);
									}
					}, 1000); 
	
    		/*input、textarea等输入框被输入法遮罩的解决方法*/
			var clientHeight=document.body.clientHeight;
			var focusElem=null;  //输入框的焦点
			//利用捕获事件来监听输入框等的focus
			document.body.addEventListener('focus',function(e){
			    focusElem=e.target||e.srcElement;
			},true);
			//因存在软键盘显示而屏幕大小还没改变，所以以屏幕大小改变为准
			window.addEventListener('resize',function () {
			    if (focusElem&&document.body.clientHeight<clientHeight){
			        //焦点元素滚动到可视范围底部（false为底部）
			        focusElem.scrollIntoView(true);
			    }
			});
			
			
			var u = navigator.userAgent, app = navigator.appVersion
	var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
	$(document).ready(function(){
		$("select").blur(function(){
			if (isIOS) {
				blurAdjust()
				// alert("1231321233")
			}
		});
	});
	// 解决苹果不回弹页面
	function blurAdjust(e){
		setTimeout(()=>{
			// alert("1231321233")
			if(document.activeElement.tagName == 'INPUT' || document.activeElement.tagName == 'TEXTAREA'){
				return
			}
			let result = 'pc';
			if(/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) { //判断iPhone|iPad|iPod|iOS
					result = 'ios'
			}else if(/(Android)/i.test(navigator.userAgent)) {  //判断Android
					result = 'android'
			}
			
			if( result = 'ios' ){
				document.activeElement.scrollIntoViewIfNeeded(true);
			}
		},100)
	}
			
    		
    		$(".zong").scroll(function () {  
		     var scroH = $(this).scrollTop(); //滚动高度  
		     var viewH = $(this).height(); //可见高度  
		     var contentH = $(this).get(0).scrollHeight; //内容高度  
		       
		     if(scroH == (contentH - viewH) ){  
		         $(".huadong").hide();
		     }else{
		     	$(".huadong").show();
		     }
		  
		 });  
    		
    		$i = 0;
			 function state1(){
			 	$(".huadong").animate({bottom:"7.5%",opacity:"0"},500);
			 	setTimeout(state2,500);

			 }
			function state2(){
				$(".huadong").animate({bottom:"3.5%",opacity:"1"},500);
			     setTimeout(state1,800);

			}
			state1();
    	});
    	
    	$(function(){
			 function donghua1(){
				 $(".shan").removeClass("b2"); 
				 $(".shan").addClass("b1");
				 setTimeout(donghua2,200);
			 }			function donghua2(){	   
			     $(".shan").removeClass("b1");
			     $(".shan").addClass("b2"); 
				 setTimeout(donghua1,200);	
			}
			donghua1();
			
			function hua1(){
				 $(".shan_two").removeClass("a2"); 
				 $(".shan_two").addClass("a1");
				 setTimeout(hua2,150);
			 }
			function hua2(){	   
			     $(".shan_two").removeClass("a1");
			     $(".shan_two").addClass("a2"); 
				 setTimeout(hua1,150);	
			}
			hua1();
	})