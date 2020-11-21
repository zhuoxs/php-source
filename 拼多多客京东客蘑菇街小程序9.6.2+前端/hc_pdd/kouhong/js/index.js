var hg=null;function addClass(element,new_name){if(!element||!new_name)return false;if(element.className){var old_class_name=element.className;element.className=old_class_name+" "+new_name;}else{element.className=new_name;}
return true;}
function removeClass(element,class_name){if(!element||!class_name)return false;if(!element.className)return false;var all_names=element.className.split(" ");for(var i=0;i<all_names.length;i++){if(all_names[i]===class_name){all_names.splice(i,1);element.className="";for(var j=0;j<all_names.length;j++){element.className+=" ";element.className+=all_names[j];}
return true;}}}
var orderId=null;$(function(){$(".close").on("click",function(){if(window.isH5){window.history.go(-1);}else{wx.miniProgram.navigateBack();}})
document.getElementById("levelSwitchBox").addEventListener("webkitAnimationEnd",function(){$("#levelSwitchBox").css("display","none")
$("#levelSwitchBoxMain").attr("src",window.levels_mains[1])
$("#levelSwitchBox").removeClass("hidden")})
$("#levelSwitchBox").addClass("hidden")
if(!hg){createHg(false)}});function playAudioInWechat(obj){if(window.WeixinJSBridge){WeixinJSBridge.invoke('getNetworkType',{},function(e){obj.currentTime=0;obj.play();console.log(22,obj);},false);}else{document.addEventListener("WeixinJSBridgeReady",function(){WeixinJSBridge.invoke('getNetworkType',{},function(e){obj.currentTime=0;obj.play();});console.log(22,obj);},false);}
console.log(22,obj);}
function createHg(GAMEMODE){hg=new HardestGame(document.getElementById("gameStage"),GAMEMODE);hg.levelSuccessHandle=function(){if(hg.level<4){playAudioInWechat($("#success_audio").get(0));document.getElementById("currentLevel").getElementsByTagName("span")[0].innerHTML=hg.level;
var time=4;var interval=setInterval(function(){time--;if(time<=0){clearInterval(interval);hg.gameContinue(true);}},1000);}else{var level=hg.level-1
var audio=document.getElementById('back_music');audio.pause();playAudioInWechat($("#gameSuccess_audio").get(0));$("#app").addClass("blur")
$("#gameSuccessBox").css("display","block")

var ua = window.navigator.userAgent.toLowerCase();
if(ua.match(/MicroMessenger/i) == 'micromessenger'){
	wx.miniProgram.getEnv(function(res){if(!res.miniprogram){
		var cookieurl=$.cookie("ajaxurl")
		function getdescookie(strcookie,matchcookie){ 
			 var getMatchCookie;  var arrCookie=strcookie.split(";"); 
			 for(var i=0;i<arrCookie.length;i++){     
				var arr=arrCookie[i].split("=");
				console.log(arr)
		        getMatchCookie=arr.join("=");  
			}
		  return getMatchCookie;}
		 
			var resultCookie=getdescookie(cookieurl);console.log(resultCookie)
			var hahjson={'orderid':$.cookie("orderId"),'result':2,'level':level}
			var orderResult=Base.encode(JSON.stringify(hahjson));
			$.ajax({type:"POST",
				url:resultCookie,
				data:{orderResult:orderResult},
				dataType:"json",
				success:function(data){
					console.log("data",data)
					 
				},fail(res){
					console.log(res)
					 
				}
			});
		}
	});
}else{
	var cookieurl=$.cookie("ajaxurl")
		function getdescookie(strcookie,matchcookie){ 
			 var getMatchCookie;  var arrCookie=strcookie.split(";"); 
			 for(var i=0;i<arrCookie.length;i++){     
				var arr=arrCookie[i].split("=");
				console.log(arr)
		        getMatchCookie=arr.join("=");  
			}
		  return getMatchCookie;}
		 
			var resultCookie=getdescookie(cookieurl);console.log(resultCookie)
			var hahjson={'orderid':$.cookie("orderId"),'result':2,'level':level}
			var orderResult=Base.encode(JSON.stringify(hahjson));
			$.ajax({type:"POST",
				url:resultCookie,
				data:{orderResult:orderResult},
				dataType:"json",
				success:function(data){
					console.log("data",data)
					 
				},fail(res){
					console.log(res)
				}
			});
}
$("#gameSuccessBoxBtn").on("click",function(){
	if(window.isH5){
		window.history.go(-1);
	}else{
		 var ua = window.navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i) == 'micromessenger'){
				wx.miniProgram.getEnv(function(res){
					if(res.miniprogram){
						let info={game_id:game_id,openid:openid,orderId:orderId,level:level,results:2,};
						let json=JSON.stringify(info);
						wx.miniProgram.postMessage({
							data:json
						});
					}else{
						window.history.go(-1);
					}});
            }else{
                window.history.go(-1);
            }
		setTimeout(function(){wx.miniProgram.redirectTo({url:'../my/my?address='+0+'&orderId='+orderId});},2000)}})}}
hg.gameOverHandle=function(){clearInterval(timeboxInterval);hg=null;if(hg){delete hg;}
var audio=document.getElementById('back_music');audio.pause();playAudioInWechat($("#gameFail_audio").get(0));$("#gameOverBox").css("display","block");var level=this.level;

var ua = window.navigator.userAgent.toLowerCase();
if(ua.match(/MicroMessenger/i) == 'micromessenger'){
	wx.miniProgram.getEnv(function(res){
	if(!res.miniprogram){
		var cookieurl=$.cookie("ajaxurl")
function getdescookie(strcookie,matchcookie){ 
	 var getMatchCookie;  var arrCookie=strcookie.split(";");  for(var i=0;i<arrCookie.length;i++){     var arr=arrCookie[i].split("=");console.log(arr)
        getMatchCookie=arr.join("=");  }
  return getMatchCookie;}
 
var resultCookie=getdescookie(cookieurl);console.log(resultCookie)
var hahjson1={'orderid':$.cookie("orderId"),'result':1,'level':level}
console.log(hahjson1)
var orderResult1=Base.encode(JSON.stringify(hahjson1));$.ajax({type:"POST",url:resultCookie,data:{
	orderResult:orderResult1},dataType:"json",success:function(data){
		console.log("data",data)
		 
	}});
}});
}else{
		var cookieurl=$.cookie("ajaxurl")
	function getdescookie(strcookie,matchcookie){ 
		 var getMatchCookie;  var arrCookie=strcookie.split(";");  for(var i=0;i<arrCookie.length;i++){     var arr=arrCookie[i].split("=");console.log(arr)
	        getMatchCookie=arr.join("=");  }
	  return getMatchCookie;}
	 
	var resultCookie=getdescookie(cookieurl);console.log(resultCookie)
	var hahjson1={'orderid':$.cookie("orderId"),'result':1,'level':level}
	console.log(hahjson1)
	var orderResult1=Base.encode(JSON.stringify(hahjson1));$.ajax({type:"POST",url:resultCookie,data:{
		orderResult:orderResult1},dataType:"json",success:function(data){
			console.log("data",data)
			 
		}});
}

$("#app").addClass("blur");$("#gameOverBoxBtn").on("click",function(){
	if(window.isH5){
		window.history.go(-1);
	}else{

		var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
				
				wx.miniProgram.getEnv(function(res){
			if(res.miniprogram){
				var info={game_id:game_id,openid:openid,orderId:orderId,level:level,results:1,};
				var json=JSON.stringify(info);
				wx.miniProgram.postMessage({data:json});}else{
					window.history.go(-1);}});
            }else{
                window.history.go(-1);
            }

		setTimeout(function(){wx.miniProgram.navigateBack();},1000)}})}
hg.init();hg.canvas.parentNode.style.width=hg.canvas.width+"px";hg.canvas.parentNode.style.height=hg.canvas.height+"px";hg.gameStart();document.getElementById("currentLevel").getElementsByTagName("span")[0].innerHTML=hg.level;return true;}