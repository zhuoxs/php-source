if (typeof Object.assign != 'function') {
	Object.defineProperty(Object, "assign", {
		value: function assign(target, varArgs) { 
			'use strict';
			if (target == null) { 
				throw new TypeError('Cannot convert undefined or null to object');
			}
			var to = Object(target);
			for (var index = 1; index < arguments.length; index++) {
				var nextSource = arguments[index];
				if (nextSource != null) { 
					for (var nextKey in nextSource) {
						if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
							to[nextKey] = nextSource[nextKey];
						}
					}
				}
			}
			return to;
		},
		writable: true,
		configurable: true
	});
}
var base={
	init:function(){
		document.domain = base.domain;
	},
	ready:null,
	domain:'xbdbld.com',
	url:'http://weixin.xbdbld.com/',
	apiurl:'http://api.xbdbld.com/api.php',
	loginurl:'http://weixin.xbdbld.com/profile.html',
	home:'http://weixin.xbdbld.com/index.html',
	memberurl:'http://weixin.xbdbld.com/member.html',
	counter:1,
	back:function(){
		history.go(-1);
	},
	gohome:function(){
		document.location.href=base.home;
	},
	gologin:function(){
		document.location.href=base.loginurl;
	},
	redirect:function(url){
		document.location.href=url;
	},
	tool:{
		strlen:function(str){
			var len = 0;  
			for (var i=0; i<str.length; i++) {  
				if (str.charCodeAt(i)>127 || str.charCodeAt(i)==94) {  
					len += 2;  
			    } else {  
			       len ++;  
			    }  
			}  
			return len;  
		}
	},
	cookie:{
		get:function(c_name){
			if (document.cookie.length>0){
					c_start=document.cookie.indexOf(cname + "=");
				if (c_start!=-1){ 
					c_start=c_start + c_name.length+1; 
					c_end=document.cookie.indexOf(";",c_start);
					if (c_end==-1){
						c_end=document.cookie.length;
					}
					return unescape(document.cookie.substring(c_start,c_end));
				} 
			}
			return "";
		},
		set:function(c_name,value){
			document.cookie=c_name+ '=' +escape(value)+';path=/';
		}
	},
	query:{
		get:function(name){
			try{
				var params=document.location.href.split('?')[1].split('&');
				for(var i=0;i<params.length;i++){
					var temp=params[i].split('=');
					if(temp[0]==name){
						return temp[1];
					}
				}
				return false;
			}
			catch(e){
				return false;
			}
		},
		url:function(url){
			return document.location.href.split('#')[0];
		}
	},
	storage:{
		get:function(c_name){
			if(typeof sessionStorage=='undefined'){
				return base.cookie.get(c_name);
			}
			return sessionStorage[c_name];
		},
		set:function(c_name,value){
			if(typeof sessionStorage=='undefined'){
				return base.cookie.set(c_name,value);
			}
			return sessionStorage[c_name]=value;
		}
	},
	initlogin:function(login){
		//如果没有微信授权，需要先授权
		if(!base.storage.get('openid')){
			var code=base.query.get('code');
			if(code){
				base.request('api.weixin.user',{code:code},function(data){
					//console.log(data);
					//alert('123');
					if(data.newcode){
						var url=document.location.href.split('?')[0];
						if(base.query.get('id')){
							url=url+'?id='+base.query.get('id');
						}
						document.location.replace(url);
						return false;
					}
					if(data.error){
						alert(data.error);
						return false;
					}
					if(data.openid){
						base.storage.set('openid',data.openid);
						if(data.profile){
							base.storage.set('profile',1);
							if(login){
								if(base.storage.get('referer')){
									//base.redirect(base.storage.get('referer'));
									window.location.href=base.storage.get('referer');
								}
								else{
									base.gohome();
								}
							}
							base.initweixin();
						}
						else{
							if(!login){
								base.gologin();
							}
						}
					}
				});
			}
			else{
				base.storage.set('referer',document.location.href.split('#')[0]);
				base.request('api.weixin.authurl',{detail:1,url:document.location.href.split('#')[0]},function(data){
					document.location.replace(data.url);
				});
			}
		}
		else{
			//已经填写资料开始初始化，如果是资料页就进行跳转主页
			if(base.storage.get('profile')){
				if(login){
					if(base.storage.get('referer')){
						base.redirect(base.storage.get('referer'));
					}
					else{
						base.gohome();
					}
				}
			}
			else{
				if(!login){
					base.gologin();
				}		
			}
			base.initweixin();
		}
	},
	share:{
		title:'起重汇订单宝-采购好帮手',
		desc:'每天24小时推送终端客户订单信息和业务员采购信息!业务经理和供应商的采购新神器、生意好助手！',
		pic:'http://public.xbdbld.com/logo.jpg',
		url:'http://weixin.xbdbld.com/index.html',
	},
	initshare:function(){
		wx.onMenuShareTimeline({
		    title: base.share.title, 
		    link: base.share.url, 
		    imgUrl: base.share.pic, 
		});
		wx.onMenuShareAppMessage({
			title: base.share.title, 
		    link: base.share.url, 
		    imgUrl: base.share.pic, 
		    desc:base.share.desc,  
		});
		wx.onMenuShareQQ({
			title: base.share.title, 
		    link: base.share.url, 
		    imgUrl: base.share.pic, 
		    desc:base.share.desc,   
		});
		wx.onMenuShareWeibo({
			title: base.share.title, 
		    link: base.share.url, 
		    imgUrl: base.share.pic, 
		    desc:base.share.desc,  
		});
		wx.onMenuShareQZone({
			title: base.share.title, 
		    link: base.share.url, 
		    imgUrl: base.share.pic, 
		    desc:base.share.desc, 
		});
	},
	initweixin:function(){
		base.request('api.weixin.init',{url:base.query.url()},function(res){
			if(res.data){
				wx.config({
				    appId: res.data.appId,
				    timestamp: res.data.timestamp,
				    nonceStr: res.data.nonceStr,
				    signature: res.data.signature,
				    jsApiList: ['chooseWXPay','previewImage','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone','chooseImage','uploadImage']
				});
				wx.ready(function(){
					base.initshare();
					$('body').show();
					if(base.ready){

						base.ready();
					}
				});
				wx.error(function(){
					$.alert('系统错误');
				});
				
			}
			else{
				$.alert('系统错误');
			}
		});
	},
	inittabs:function(index){
		var tabs=[];
		tabs.push({title:'询盘商机',href:'http://weixin.xbdbld.com/index.html',img:'http://weixin.xbdbld.com/img/tap/s0.png?v=2.0',activeimg:'http://weixin.xbdbld.com/img/tap/s1.png',index:'home'});
        tabs.push({title:'设置商机',href:'http://weixin.xbdbld.com/messagetype.html',img:'http://weixin.xbdbld.com/img/tap/f0.png?v=2.0',activeimg:'http://weixin.xbdbld.com/img/tap/f1.png',index:'messagetype'});
        tabs.push({title:'发布商机',href:'http://weixin.xbdbld.com/publish.html',img:'http://weixin.xbdbld.com/img/tap/m0.png?v=2.0',activeimg:'http://weixin.xbdbld.com/img/tap/m1.png',index:'publish'});
		tabs.push({title:'会员中心',href:'http://weixin.xbdbld.com/member.html',img:'http://weixin.xbdbld.com/img/tap/h0.png?v=2.0',activeimg:'http://weixin.xbdbld.com/img/tap/h1.png',index:'member'});
		var html=[];
		html.push('<div class="weui-tabbar">');
		for(var i=0;i<tabs.length;i++){
			html.push('<a href="'+(index==tabs[i].index?'javascript:void(0)':tabs[i].href)+'" class="weui-tabbar__item '+(index==tabs[i].index?'weui-bar__item--on':'')+'"><div class="weui-tabbar__icon"><img src="'+(index==tabs[i].index?tabs[i].activeimg:tabs[i].img)+'" alt=""></div><p class="weui-tabbar__label">'+tabs[i].title+'</p></a>');
		}
		html.push('</div>');
		$('body').append(html.join(''));
	},
	getsid:function(){
		if(base.storage.get('sid')){
			return base.storage.get('sid');
		}
		else{
			return base.createsid();
		}
	},
	createsid:function(){
		var datas=[0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		var nums=[];
		for(var i=0;i<32;i++){
			nums.push(datas[Math.floor(Math.random()*37)]);
		}
		base.storage.set('sid',nums.join(''));
		return base.storage.get('sid');
	},
	/*
		主要使用方法
		@command 接口名称
		@param 传递的参数
		@callback 请求成功回调函数 
		@ignore 接口如果返回需要登陆，自动跳转登陆页，如无需跳转，则传递true

	*/
	request:function(command,param,callback,ignore){
		param.command=command;
		param.s=base.getsid();
		$.post(base.apiurl,param,function(data){
			var data=JSON.parse(data);
			if(data.needlogin&&!ignore){
				document.location.replace(base.loginurl);
				return false;
			}
			if(callback){
				callback(data);
			}
		});
	},
	/*
		@name input file 控件ID
		@param 附带传递的值

	*/
	ifupload:function(name,param,callback){
		param.command='api.public.upload';
		param.isiframe=1;
		param.s=base.getsid();
		$.ajaxFileUpload({
            url: base.apiurl,
            secureuri: false,
            fileElementId: name,
            dataType: 'json',
            data:param,
            success: function (data, status){
            	if(data.needlogin){
					document.location.replace(base.loginurl);
					return false;
				}
            	if(callback){
            		callback(data);
            	}
            }
        });
	},
	/*
		上传图片HTML5方案

	 */
	upload:function(param,callback){
		var fd = new FormData();
        fd.append("command",'api.public.upload');
        fd.append("s",base.getsid());
        //alert($(param.id).get(0).files[0].size);
        if($(param.id).get(0).files[0].size>2000000){
        	$.alert('文件不能超过2M');
        	return false;
        }
        fd.append('file',$(param.id).get(0).files[0]);
        $.ajax({
            url: base.apiurl,
            type: "POST",
            processData: false,
            contentType: false,
            data: fd,
            success: function (data) {
            	var data=JSON.parse(data);
            	if(data.needlogin){
					document.location.replace(base.loginurl);
					return false;
				}
                if(callback){
                	callback(data);
                }
            },
            error:function(){
            	$.alert('上传失败');
            }
        });
	},
	/*
	检查是否登陆，其他动作可放在callback中进行
	 */
	check_login:function(callback){
		base.request('api.account.checklogin',{},function(response){
			if(callback){
				callback(response);
			}
		},true);
	},
	validate:{
		isemail:function(value){
			if(!value){
				return false;
			}
			return /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(value);
		},
		ismobile:function(value){
			if(!value){
				return false;
			}
			return /^((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1})|(19[0-9]{1})|(14[0-9]{1}))+\d{8}$/.test(value);
		}
	},
	toast:function(msg,callback){
		$.toast(msg, "text",function(){
			if(callback){
				callback();
			}
		});
	},
	lock:false,
	loadingindex:null,
	loading:function(msg){
		$.showLoading(msg);
	},
	closeloading:function(){
		$.hideLoading();
	}
};
//base.init();