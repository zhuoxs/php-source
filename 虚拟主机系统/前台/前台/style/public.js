function close_piao(piaodivid,piaoid)
{
	piaoid = piaoid ? piaoid : 'msg';
	document.getElementById(piaodivid).innerHTML = '';
	document.getElementById(piaoid).style.display = 'none';
}
function go_to(url)
{
	window.location = url;
}
function show_msg(msg)
{
	var div = document.getElementById('show_msg');
	if (!div) {
		return;
	}
	div.style.top = 60;
	div.style.right = 15;
	div.style.width = 200;
	div.style.height = 50;
	div.innerHTML = msg;
	div.style.display = 'block';
	setTimeout(close_showmsg,1000);
}

function close_showmsg()
{
	$("#show_msg").fadeOut(1000);
	
}
/**
 * @param msg
 */
function success_msg(msg)
{
	art.dialog({id:'success',time:2,content:msg,icon:'succeed'});
}
/**
 * @param msg
 */
function error_msg(msg)
{
	art.dialog({id:'error',time:2,content:msg,icon:'error'});
}
/**
 * @param msg
 */
function warning_msg(msg)
{
	art.dialog({id:'warning',time:2,content:msg,icon:'warning'});
}
/**
 * 2013.5.3
 * @param url
 */
function create_cache(url)
{
	var dlog = art.dialog({id:'id22',title:'提示',content:'正在生成缓存,请等待......',icon: 'face-smile',lock:true});
	$.ajax({url:url,dataType:'json',success:function(ret){
		dlog=null;
		if (ret['code'] != 200) {
			var dlog = art.dialog({id:'id22',title:'两秒后关闭',icon: 'error'});
			dlog.content('执行失败,原因:' + ret['msg'] ? ret['msg'] : '');
			dlog.time(3);
		}else {
			var dlog = art.dialog({id:'id22',title:'两秒后关闭',icon: 'succeed'});
			dlog.content('执行成功');
			dlog.time(2);
		}
	}});
}
/**
 * 从后台获取是否开启了管理员操作验证
 * @returns {Number}
 * 20130514
 */
function isVerification()
{
	var isverification = 0;
	jQuery.ajax({
		url : '?c=setting&a=isVerification',
		dataType : 'json',
		async : false,
		success : function(ret) {
			if (ret['code'] == 200) {
				isverification = 1;
			}
		}
	});
	return isverification;
}
/**
 * 管理员操作解锁
 * @param locationurl
 */
function adminVerification(locationurl)
{
	var isverification = isVerification();
	if (isverification==1) {
		str = prompt('请输入管理密钥');
		if (str == null) {
			return;
		}
		if (jQuery.trim(str) == '') {
			alert("管理密钥不能为空");
			return;
		}
		jQuery.ajax({url:'?c=setting&a=adminVerification',type:'get',data:'operating_string='+str,dataType:'json', success:function(ret){
			if (ret['code'] != 200) {
				art.dialog({id:'id22',content:ret['msg'] ? ret['msg'] : '解锁失败',icon:'error',time:2});
			}else {
				art.dialog({id:'id22',content:'解锁成功',time:2,icon:'succeed'});
				setTimeout(function(){
					window.location = locationurl ? locationurl : window.location;
				},2000);
			}
		}
		});
	}
	art.dialog({id:'id22',content:'已解锁',time:2,icon:'succeed'});
}
/**
 * @param url
 * @returns
 * 加载js文件
 */
function loadscript(url) 
{
    var script = document.createElement("script");
    script.type = 'text/javascript';
    script.src = url;
    document.body.appendChild(script);
}
/**
 * 2013.5.1
 * @param url
 * @param data
 */
function verificationAjax(url,data,locationurl)
{
	var isverification = isVerification();
	var str = '';
	if (isverification == 1) {
		str = prompt('该操作需要管理密钥验证,请输入管理密钥');
		if (str == null) {
			return;
		}
		if (jQuery.trim(str) == '') {
			alert("管理密钥不能为空");
			return;
		}
	} 
	jQuery.ajax({
		url : url + '&operating_string='+ str+'&ajax=1',
		type:'get',
		data:data,
		dataType : 'json',
		success : function(ret) {
			if (ret['code'] != 200) {
				var msg = ret['msg'] ? ret['msg'] : '操作失败';
				art.dialog({id:'id22',content:msg});
				//alert(ret['msg'] ? ret['msg'] : '操作失败');
				return;
			}
			window.location = locationurl ? locationurl : window.location;
		}
	});
}