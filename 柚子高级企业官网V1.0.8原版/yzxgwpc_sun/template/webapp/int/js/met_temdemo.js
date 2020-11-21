/**
 * 演示站处理
 * @type {[type]}
 */
function metTemDemo(){
	var useragent=navigator.userAgent,
		useragent_tlc=useragent.toLowerCase(),
		device_type = /iPad/.test(useragent) ? 't' : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(useragent) ? 'm' : 'd';
	if(device_type!='m' && location.href.indexOf('metinfo.cn')>=0 && !parent.document.getElementById('met-demo-iframe')){
		document.domain='metinfo.cn';// 定义相同域名
		// 网站参数
		var MSTR=document.querySelector('meta[name=generator]').getAttribute('data-variable');
	    if(MSTR && MSTR.indexOf(',')>=0) MSTR=MSTR.split(',');
	    if(MSTR && MSTR.indexOf('|')>=0) MSTR=MSTR.split('|');
	    if(MSTR){
	    	var M=new Array();
	    	M['weburl']=MSTR[0];
			M['lang']=MSTR[1];
			M['classnow']=parseInt(MSTR[2]);
			M['id']=parseInt(MSTR[3]);
			M['module']=parseInt(MSTR[4]);
			M['tem']=MSTR[0]+'templates/'+MSTR[5]+'/';
	    }
		// M['weburl']='https://show.metinfo.cn/muban/res013/323/';
		M['metinfo_url']='https://www.metinfo.cn/';
		// 添加class
		function addClass(obj, cls) {
			if(typeof obj.length == 'undefined') obj=[obj];
			for (var i = 0; i < obj.length; i++) {
				var obj_class = obj[i].className, //获取 class 内容.
					blank = (obj_class != '') ? ' ' : ''; //判断获取到的 class 是否为空, 如果不为空在前面加个'空格'.
				added = obj_class + blank + cls; //组合原来的 class 和需要添加的 class.
				obj[i].className = added; //替换原来的 class.
			}
		}
		// 移除class
		function removeClass(obj, cls) {
			if(typeof obj.length == 'undefined') obj=[obj];
			for (var i = 0; i < obj.length; i++) {
				var obj_class = ' ' + obj[i].className + ' '; //获取 class 内容, 并在首尾各加一个空格. ex) 'abc    bcd' -> ' abc    bcd '
				obj_class = obj_class.replace(/(\s+)/gi, ' '), //将多余的空字符替换成一个空格. ex) ' abc    bcd ' -> ' abc bcd '
				// 删除class
				obj_class=obj_class.split(' ');
				var obj_class_new='';
				for (var s = 0; s < obj_class.length; s++) {
					if(obj_class[s] && obj_class[s]!=cls) obj_class_new+=obj_class[s]+' ';
				}
				removed = obj_class_new.replace(/(^\s+)|(\s+$)/g, ''); //去掉首尾空格. ex) 'bcd ' -> 'bcd'
				obj[i].className = removed; //替换原来的 class.
			}
		}
		// 判断是否有class
		function hasClass(obj, cls) {
			var obj_class = obj.className, //获取 class 内容.
				obj_class_lst = obj_class.split(/\s+/); //通过split空字符将cls转换成数组.
			x = 0;
			for (x in obj_class_lst) {
				if (obj_class_lst[x] == cls) { //循环数组, 判断是否包含cls
					return true;
				}
			}
			return false;
		}
		// 获取指定名称的cookie的值
		function getCookie(name) {
		    var cookie_str = document.cookie.split(";");
		    for (var i = 0; i < cookie_str.length; i++) {
		        cookie_str[i]=cookie_str[i].trim();
		        var index = cookie_str[i].indexOf("="),
		            cookie_name = cookie_str[i].substring(0, index);
		        if (cookie_name == name) {
		            var temp = cookie_str[i].substring(index + 1);
		            return decodeURIComponent(temp);
		        }
		    }
		}
		function closest(el, selector) {
			var matchesSelector = el.matches || el.webkitMatchesSelector || el.mozMatchesSelector || el.msMatchesSelector;
			while (el) {
				if (matchesSelector.call(el, selector)) break;
				el = el.parentElement;
			}
			return el;
		}
		setTimeout(function(){
			// 判断页面是否有固定定位元素
			var demo_iframe=1,
			objs=document.all;
			for (var i = 0; i < objs.length; i++) {
				var style=window.getComputedStyle(objs[i]);
				if(style.position=='fixed' && parseInt(style.top)<50){
					demo_iframe='iframe-min';
					break;
				}
			}
			if(demo_iframe==1) document.getElementsByTagName('html')[0].style.paddingTop='50px';
			// 所有处理
			var demoFun=function(id){
				var $iframe_css=document.createElement("style"),
					iframe_css='.demo-iframe-load{width: 100%;height: 50px;position: fixed;left: 0;top: 0;z-index: 9999998;background:#000;text-align:center;font-size:16px;color:#999;line-height:50px;}\n.demo-iframe{width: 100%;height: 50px;position: fixed;left: 0;top: 0;z-index: 9999999;display:none;}';
				if(demo_iframe=='iframe-min'){// 有固定定位元素则导航最小化
					iframe_css+='.demo-iframe-load{width:163px;}\n.demo-iframe{-webkit-transition: all .5s;-o-transition: all .5s;transition: all .5s;}\n.demo-iframe.iframe-min{left: -100% !important;-webkit-transform: translate(163px,0);-ms-transform: translate(163px,0);-o-transform: translate(163px,0);transform: translate(163px,0);}';
				}
				$iframe_css.innerHTML=iframe_css;
				document.head.appendChild($iframe_css);
				// 插入iframe加载提示
				var $demo_iframe_load=document.createElement("div");
				$demo_iframe_load.innerHTML='演示工具加载中...';
				$demo_iframe_load.setAttribute('class','demo-iframe-load');
				document.body.appendChild($demo_iframe_load);
				// 插入头部iframe
				var demo_url=M['metinfo_url']+'product/showproduct.php?lang=cn&id='+id+'&demo=1&demo_iframe='+demo_iframe,
					$demo_iframe=document.createElement("iframe");
				$demo_iframe.setAttribute('src',demo_url);
				$demo_iframe.setAttribute('frameborder',0);
				$demo_iframe.setAttribute('class','demo-iframe '+demo_iframe);
				document.body.appendChild($demo_iframe);
				// iframe加载完处理方法
				$demo_iframe.onload=function(){
					$demo_iframe.style.display='block';
					$demo_iframe_load.parentNode.removeChild($demo_iframe_load);
					var demo_iframe_window=$demo_iframe.contentWindow,
						demo_iframe_document=demo_iframe_window.document,
						$shop_buy=demo_iframe_window.document.getElementsByClassName('shop-btn')[0],
						$met_demo_head=demo_iframe_window.document.getElementsByClassName('met-demo-head')[0],
						$showmore_demo_head=demo_iframe_window.document.getElementsByClassName('showmore-demo-head')[0],
						$hide_demo_head=demo_iframe_window.document.getElementsByClassName('hide-demo-head')[0],
						$close_demo_head=demo_iframe_window.document.getElementsByClassName('close-demo-head')[0],
						$demo_option_btn=demo_iframe_window.document.getElementsByClassName('demo-option')[0].getElementsByClassName('btn'),
						$html=document.getElementsByTagName('html')[0],
						$demo_iframe_body=demo_iframe_window.document.body,
						// $showmeqia=demo_iframe_window.document.getElementsByClassName('showmeqia')[0],
						$shop_favaorite=demo_iframe_window.document.getElementsByClassName('shop-favaorite')[0],
						body_outside=function(dom){
							if(closest(dom.target,'.met-demo-head') || closest(dom.target,'.webui-popover') || closest(dom.target,'#MEIQIA-PANEL-HOLDER') || closest(dom.target,'#shop-fashion-option') || closest(dom.target,'.alertify-logs')){
								return true;
							}else{
								return false;
							}
						};
					// var meqiahide=setInterval(function(){
					// 	var $meqia=demo_iframe_window.document.getElementById('MEIQIA-PANEL-HOLDER');
					// 	if($meqia){
					// 		$meqia.style.zIndex='-1';
					// 		$meqia.style.visibility='hidden';
					// 		clearInterval(meqiahide);
					// 	}
					// },20)
					$met_demo_head.onmouseover=function(){
						$demo_iframe.style.height='100%';
					};
					$demo_iframe_body.addEventListener('mouseover',function(e){
						var $meqia=demo_iframe_window.document.getElementById('MEIQIA-PANEL-HOLDER'),
							$modal_backdrop=demo_iframe_window.document.getElementsByClassName('modal-backdrop')[0],
							$alertify=demo_iframe_window.document.getElementsByClassName('alertify-logs')[0];
			            if(!body_outside(e)/* && (!$meqia.style.zIndex || parseInt($meqia.style.zIndex)<0)*/ && typeof $modal_backdrop =='undefined' && (typeof $alertify =='undefined' || !$alertify.innerHTML)){
			            	$demo_iframe_body.style.background='transparent';
			            	$demo_iframe.style.height='50px';
			            }
			        });
			  		$demo_iframe_body.addEventListener('click',function(e){
						if(!body_outside(e)) {
							var $meqia=demo_iframe_window.document.getElementById('MEIQIA-PANEL-HOLDER'),
								$alertify=demo_iframe_window.document.getElementsByClassName('alertify-logs')[0];
							$demo_iframe_body.style.background='transparent';
							$demo_iframe.style.height='50px';
							// $meqia.style.zIndex='-1';
							// $meqia.style.visibility='hidden';
							if(typeof $alertify !='undefined') $alertify.innerHTML='';
						}
					});
					function bgmask(){
						$demo_iframe_body.style.background='rgba(0,0,0,.5)';
					}
					// $showmeqia.addEventListener('click',bgmask);
					$shop_favaorite.addEventListener('click',bgmask);
					// 关闭导航
					$close_demo_head.addEventListener('click',function() {
						if(demo_iframe==1){
							$html.style.transition='padding-top .5s';
							$html.style.paddingTop='0';
						}
						setTimeout(function(){
							$demo_iframe.parentNode.removeChild($demo_iframe);
						},500)
					});
					if(demo_iframe=='iframe-min'){
						// 导航展开
						$demo_iframe.onmouseover=function(){
							removeClass($met_demo_head,'padding-0');
							removeClass($demo_option_btn,'hide');
							removeClass($hide_demo_head,'hide');
							addClass($showmore_demo_head,'hide');
							removeClass($demo_iframe,'iframe-min');
						};
						// 导航收起
						$hide_demo_head.onclick=function(event) {
							addClass($demo_iframe,'iframe-min');
							addClass($met_demo_head,'padding-0');
							addClass($demo_option_btn,'hide');
							addClass($hide_demo_head,'hide');
							removeClass($showmore_demo_head,'hide');
							removeClass($shop_buy,'hide');
							setTimeout(function(){
								$demo_iframe.style.height='50px';
							},50)
						};
					}
				};
			}
			// 执行处理
			var demo_info=getCookie('demo_info'),
				ajaxok=false;
			if(demo_info){// 如果是从官网模板详情页点击弹出演示站
				demo_info=demo_info.split('|');
				if(demo_info[0].indexOf(M['weburl'])>=0 || M['weburl'].indexOf(demo_info[0])>=0){
					demoFun(demo_info[1]);
				}else{
					ajaxok=true;
				}
			}else{
				ajaxok=true;
			}
			if(ajaxok){// 根据演示站地址从官网请求产品详情页数据
				function ajax(params) {
					params = params || {};
					params.data = params.data || {};
					var json = params.jsonp ? jsonp(params) : json(params);
					// jsonp请求
					function jsonp(params) {
						//创建script标签并加入到页面中
						var callbackName = params.jsonp;
						var head = document.getElementsByTagName('head')[0];
						// 设置传递给后台的回调参数名
						params.data['callback'] = callbackName;
						var data = formatParams(params.data);
						var script = document.createElement('script');
						head.appendChild(script);

						//创建jsonp回调函数
						window[callbackName] = function(json) {
							head.removeChild(script);
							clearTimeout(script.timer);
							window[callbackName] = null;
							params.success && params.success(json);
						};
						//发送请求
						params.url+=params.url.indexOf('?')>=0?'&':'?';
						script.src = params.url + data;
						//为了得知此次请求是否成功，设置超时处理
						if (params.time) {
							script.timer = setTimeout(function() {
								window[callbackName] = null;
								head.removeChild(script);
								params.error && params.error({
									message: '超时'
								});
							}, time);
						}
					};
					//格式化参数
					function formatParams(data) {
						var arr = [];
						for (var name in data) {
							arr.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
						};
						// 添加一个随机数，防止缓存
						arr.push('v=' + random());
						return arr.join('&');
					}
					// 获取随机数
					function random() {
						return Math.floor(Math.random() * 10000 + 500);
					}
				}
				ajax({
					url: M['metinfo_url']+'shop/cart.php?lang=cn&a=doget_product_by_demourl',
					jsonp: 'jsonpCallback',
					cache: false,
					data: {demourl: M['weburl']},
					success:function(data){
						demoFun(data.listid);
						if(!data.listid) console.log('没有找到对应产品详情页');
					}
				});
			}
		},50)
	}
}
metTemDemo();