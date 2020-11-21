
$(function() {

	function getemtname(i){
	
		switch(i)
		{
			default:{return '';}
			case 1:{return '[笑哈哈]';}
			case 2:{return '[江南style]';}
			case 3:{return '[得意地笑]';}
			case 4:{return '[转圈]';}
			case 5:{return '[泪流满面]';}
			case 6:{return '[doge]';}
			case 7:{return '[BOBO爱你]';}
			case 8:{return '[lt赞]';}
			case 9:{return '[lt切克闹]';}
			case 10:{return '[ppb鼓掌]';}
			case 11:{return '[moc转圈]';}
			case 12:{return '[din推撞]';}
			case 13:{return '[草泥马]';}
			case 14:{return '[神马]';}
			case 15:{return '[浮云]';}
			case 16:{return '[给力]';}
			case 17:{return '[围观]';}
			case 18:{return '[威武]';}
			case 19:{return '[熊猫]';}
			case 20:{return '[兔子]';}
			case 21:{return '[奥特曼]';}
			case 22:{return '[囧]';}
			case 23:{return '[互粉]';}
			case 24:{return '[礼物]';}
			case 25:{return '[微笑]';}
			case 26:{return '[嘻嘻]';}
			case 27:{return '[哈哈]';}
			case 28:{return '[可爱]';}
			case 29:{return '[可怜]';}
			case 30:{return '[挖鼻]';}
			case 31:{return '[吃惊]';}
			case 32:{return '[害羞]';}
			case 33:{return '[挤眼]';}
			case 34:{return '[闭嘴]';}
			case 35:{return '[鄙视]';}
			case 36:{return '[爱你]';}
			case 37:{return '[泪]';}
			case 38:{return '[偷笑]';}
			case 39:{return '[亲亲]';}
			case 40:{return '[生病]';}
			case 41:{return '[太开心]';}
			case 42:{return '[白眼]';}
			case 43:{return '[右哼哼]';}
			case 44:{return '[左哼哼]';}
			case 45:{return '[嘘]';}
			case 46:{return '[衰]';}
			case 47:{return '[吐]';}
			case 48:{return '[委屈]';}
			case 49:{return '[抱抱]';}
			case 50:{return '[拜拜]';}
			case 51:{return '[疑问]';}
			case 52:{return '[阴险]';}
			case 53:{return '[钱]';}
			case 54:{return '[酷]';}
			case 55:{return '[色]';}
			case 56:{return '[ok]';}
			case 57:{return '[good]';}
			case 58:{return '[耶]';}
			case 59:{return '[赞]';}
			case 60:{return '[弱]';}
			
		}

	}
	

	$.fn.facebox = function(options) {
		var defaults = {
		Event : "click", //响应事件		
		divid : "publishbox", //表单ID（textarea外层ID）
		textid : "content" //文本框ID
		};
		var options = $.extend(defaults,options);
		var $btn = $(this);//取得触发事件的ID
		
		//创建表情框
		var faceimg = '';
	    for(i=0;i<60;i++){   //通过循环创建60个表情，可扩展
		 faceimg+='<li><a href="javascript:void(0)"><img src="/addons/tiger_newhu/template/mobile/user/images/face/'+(i+1)+'.gif" face="'+getemtname(i+1)+'"/></a></li>';
		 };
		$("#"+options.divid).prepend("<div id='FaceBox'><span class='Corner'></span><div class='Content'><h3><span>常用表情</span><a class='close' title='关闭'></a></h3><ul>"+faceimg+"</ul></div></div>");
	    $('#FaceBox').css("display",'none');//创建完成后先将其隐藏
		//创建表情框结束
		
		var $facepic = $("#FaceBox li img");
		//BTN触发事件，显示或隐藏表情层
		$btn.on(options.Event,function(e) {
			if($('#FaceBox').is(":hidden")){
			$('#FaceBox').show(360);
			$btn.addClass('in');
			}else{
			$('#FaceBox').hide(360);
			$btn.removeClass('in');
				}
			});
		//插入表情
		$facepic.off().click(function(){
		     $('#FaceBox').hide(360);
			 //$("#"+options.textid).focus();
			 //$("#"+options.textid).val($("#"+options.textid).val()+$(this).attr("face"));
			 $("#"+options.textid).off().insertContent($(this).attr("face"));
			 $btn.removeClass('in');
			});			
		//关闭表情层
		$('#FaceBox h3 a.close').click(function() {
			$('#FaceBox').hide(360);
			 $btn.removeClass('in');
			});	
		//当鼠标移开时，隐藏表情层，如果不需要，可注释掉
		 $('#FaceBox').mouseleave(function(){
			 $('#FaceBox').hide(560);
			 $btn.removeClass('in');
			 });

  };  
  
  //  光标定位插件
	$.fn.extend({  
		insertContent : function(myValue, t) {  
			var $t = $(this)[0];  
			if (document.selection) {  
				this.focus();  
				var sel = document.selection.createRange();  
				sel.text = myValue;  
				this.focus();  
				sel.moveStart('character', -l);  
				var wee = sel.text.length;  
				if (arguments.length == 2) {  
				var l = $t.value.length;  
				sel.moveEnd("character", wee + t);  
				t <= 0 ? sel.moveStart("character", wee - 2 * t	- myValue.length) : sel.moveStart("character", wee - t - myValue.length);  
				sel.select();  
				}  
			} else if ($t.selectionStart || $t.selectionStart == '0') {  
				var startPos = $t.selectionStart;  
				var endPos = $t.selectionEnd;  
				var scrollTop = $t.scrollTop;  
				$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos,$t.value.length);  
				this.focus();  
				$t.selectionStart = startPos + myValue.length;  
				$t.selectionEnd = startPos + myValue.length;  
				$t.scrollTop = scrollTop;  
				if (arguments.length == 2) { 
					$t.setSelectionRange(startPos - t,$t.selectionEnd + t);  
					this.focus(); 
				}  
			} else {                              
				this.value += myValue;                              
				this.focus();  
			}  
		}  
	});
 
	//表情解析
	$.fn.extend({
		replaceface : function(faces){

			var s = '<img class="faceimg" src="/addons/tiger_newhu/template/mobile/user/images/face/';
			var e = '.gif">';
			faces=faces.replace(/\[笑哈哈\]/g,s + 1 + e);
			faces=faces.replace(/\[江南style\]/g,s + 2 + e);
			faces=faces.replace(/\[得意地笑\]/g,s + 3 + e);
			faces=faces.replace(/\[转圈\]/g,s + 4 + e);
			faces=faces.replace(/\[泪流满面\]/g,s + 5 + e);
			faces=faces.replace(/\[doge\]/g,s + 6 + e);
			faces=faces.replace(/\[BOBO爱你\]/g,s + 7 + e);
			faces=faces.replace(/\[lt赞\]/g,s + 8 + e);
			faces=faces.replace(/\[lt切克闹\]/g,s + 9 + e);
			faces=faces.replace(/\[ppb鼓掌\]/g,s + 10 + e);
			faces=faces.replace(/\[moc转圈\]/g,s + 11 + e);
			faces=faces.replace(/\[din推撞\]/g,s + 12 + e);
			faces=faces.replace(/\[草泥马\]/g,s + 13 + e);
			faces=faces.replace(/\[神马\]/g,s + 14 + e);
			faces=faces.replace(/\[浮云\]/g,s + 15 + e);
			faces=faces.replace(/\[给力\]/g,s + 16 + e);
			faces=faces.replace(/\[围观\]/g,s + 17 + e);
			faces=faces.replace(/\[威武\]/g,s + 18 + e);
			faces=faces.replace(/\[熊猫\]/g,s + 19 + e);
			faces=faces.replace(/\[兔子\]/g,s + 20 + e);
			faces=faces.replace(/\[奥特曼\]/g,s + 21 + e);
			faces=faces.replace(/\[囧\]/g,s + 22 + e);
			faces=faces.replace(/\[互粉\]/g,s + 23 + e);
			faces=faces.replace(/\[礼物\]/g,s + 24 + e);
			faces=faces.replace(/\[微笑\]/g,s + 25 + e);
			faces=faces.replace(/\[嘻嘻\]/g,s + 26 + e);
			faces=faces.replace(/\[哈哈\]/g,s + 27 + e);
			faces=faces.replace(/\[可爱\]/g,s + 28 + e);
			faces=faces.replace(/\[可怜\]/g,s + 29 + e);
			faces=faces.replace(/\[挖鼻\]/g,s + 30 + e);
			faces=faces.replace(/\[吃惊\]/g,s + 31 + e);
			faces=faces.replace(/\[害羞\]/g,s + 32 + e);
			faces=faces.replace(/\[挤眼\]/g,s + 33 + e);
			faces=faces.replace(/\[闭嘴\]/g,s + 34 + e);
			faces=faces.replace(/\[鄙视\]/g,s + 35 + e);
			faces=faces.replace(/\[爱你\]/g,s + 36 + e);
			faces=faces.replace(/\[泪\]/g,s + 37 + e);
			faces=faces.replace(/\[偷笑\]/g,s + 38 + e);
			faces=faces.replace(/\[亲亲\]/g,s + 39 + e);
			faces=faces.replace(/\[生病\]/g,s + 40 + e);
			faces=faces.replace(/\[太开心\]/g,s + 41 + e);
			faces=faces.replace(/\[白眼\]/g,s + 42 + e);
			faces=faces.replace(/\[右哼哼\]/g,s + 43 + e);
			faces=faces.replace(/\[左哼哼\]/g,s + 44 + e);
			faces=faces.replace(/\[嘘\]/g,s + 45 + e);
			faces=faces.replace(/\[衰\]/g,s + 46 + e);
			faces=faces.replace(/\[吐\]/g,s + 47 + e);
			faces=faces.replace(/\[委屈\]/g,s + 48 + e);
			faces=faces.replace(/\[抱抱\]/g,s + 49 + e);
			faces=faces.replace(/\[拜拜\]/g,s + 50 + e);
			faces=faces.replace(/\[疑问\]/g,s + 51 + e);
			faces=faces.replace(/\[阴险\]/g,s + 52 + e);
			faces=faces.replace(/\[钱\]/g,s + 53 + e);
			faces=faces.replace(/\[酷\]/g,s + 54 + e);
			faces=faces.replace(/\[色\]/g,s + 55 + e);
			faces=faces.replace(/\[ok\]/g,s + 56 + e);
			faces=faces.replace(/\[good\]/g,s + 57 + e);
			faces=faces.replace(/\[耶\]/g,s + 58 + e);
			faces=faces.replace(/\[赞\]/g,s + 59 + e);
			faces=faces.replace(/\[弱\]/g,s + 60 + e);
			
			$(this).html(faces);
		}
	});
	  
  
});
