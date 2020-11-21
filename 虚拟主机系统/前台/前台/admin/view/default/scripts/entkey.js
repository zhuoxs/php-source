function rand_entkey()
{
	var count = document.getElementById('count').value;
	var price = document.getElementById('price').value;
	var agent_user = document.getElementById('agent_user').value;
	var module = document.getElementById('module').value;
	
	if (count== undefined || count== '' || isNaN(count)) {
		return alert("生成个数不能为空");
	}
	if (price ==undefined || price == '' || isNaN(price)) {
		return alert("金额不能为空");
	}
	$.ajax({
		type:'get',
		url :'?c=entkey&a=entkeyAdd',
		data:'count=' + count + "&price=" + price + '&agent_user=' + agent_user + '&module=' + module,
		dataType:'json',
		success:function(ret) {
			if (ret['code'] != 200) {
				return alert(ret['msg']? ret['msg']:'生成失败');
			}
			alert("生成" + count + "个,价格为" + price + " 的key成功");
			window.location.reload();
		}
	});
}
function show_key(status)
{
	var url = hrefurl;
	window.location = url + '&status=' + status;
	
}
function edit_status(status,id)
{
	if (status==undefined || id==undefined) {
		return;
	}
	$.ajax({
		type:'post',
		url :'?c=entkey&a=entkeyChangeStatus',
		data:'id='+ id + '&status=' + status,
		dataType:'json',
		success:function(ret) {
			if (ret['code'] != 200) {
				return alert(ret['msg'] ? ret['msg'] :"修改状态失败");
			}
			window.location = window.location;
		}
	});
}
function entkey_del(id)
{
	if (!confirm("确定要删除?")) {
		return;
	}
	verificationAjax('?c=entkey&a=entkeyDel','id='+id);
}
function piao_rand_entkey()
{
	var modules;
	$.ajax({
		type : 'get',
		url : '?c=entkey&a=getModules',
		data : null,
		dataType : 'json',
		async : false,
		success : function(ret) {
			if (ret['code'] == 200) {
				modules = ret['modules'];
			}
		}
	});
	var str = '<form name=form2 action=javascript:rand_entkey() method=post>';
	str += '<div class=piao_div1>生成数量:</div><div class=piao_div2><input name=count id=count size=16></div>';
	str += '<div class=piao_div1>价格(元):</div><div class=piao_div2><input name=price id=price size=16></div>';
	str += '<div class=piao_div1>代理用户:</div><div class=piao_div2><input name=agent_user id=agent_user size=16></div>';
	if (modules != undefined) {
		str += '<div class=piao_div1>模&nbsp;&nbsp;&nbsp;&nbsp;块:</div><div class=piao_div2><select name=module id=module>';
		for ( var i in modules) {
			var mod = modules[i];
			for ( var j in mod) {
				str += '<option value=' + mod[j] + '>' + mod[j]
						+ '</option>';
			}

		}
		str += '</select></div>';
	}
	str += '<div class=piao_div1>&nbsp;</div><div class=piao_div2><input type=submit value=提交><input type=button onclick=close_piao(\'msg\') value=关闭></div>';
	str += '</form>';
	var msg = document.getElementById('msg');
	var msg_div = document.getElementById('msg_div');
	msg_div.innerHTML = '';
	msg_div.style.height = '150px';
	msg.style.height = msg_div.style.height + 30;
	msg_div.innerHTML = str;
	msg.style.top = 100;
	msg.style.left = 200;
	msg.style.display = 'block';
}
function entkey_update_piao(id)
{
	if (id==undefined) {
		return;
	}	
	$.ajax({
		type:'get',
		url :'?c=entkey&a=entkeyGet',
		data:'id=' + id,
		dataType:'json',
		success:function(ret) {
			if (ret['code'] != 200) {
				return alert(ret['msg'] ? ret['msg'] :'获取数据错误'+ret['code']);
			}
			var entkey = ret['ret'];
			if (entkey==undefined)	{
				return alert("获取数据错误");
			}
			var try_time = entkey['try_time'] ? entkey['try_time'] : '';
			var user = entkey['user'] ? entkey['user'] : '';
			var str = "<form action=javascript:entkey_update("+id+") method='post'>";
				str += "<div class=piao_div1>k  e   y:</div><div class=piao_div2><input name='randkey' id='randkey' value='" + entkey['randkey']+"'></div>";
				str += "<div class=piao_div1>价    格:</div><div class=piao_div2><input name='price' id='price2' value='" + entkey['price']+"'></div>";
				str += "<div class=piao_div1>价    格:</div><div class=piao_div2><input name='agent_user' id='agent_user' value='" + entkey['agent_user']+"'></div>";
				str += "<div class=piao_div1>生成时间:</div><div class=piao_div2><input name='add_time' id='add_time' value='" + entkey['add_time']+"'></div>";
				str += "<div class=piao_div1>用户  名:</div><div class=piao_div2><input name='user' id='user' value='" + user +"'></div>";
				str += "<div class=piao_div1>领取时间:</div><div class=piao_div2><input name='try_time' id='try_time' value='" + try_time+"'></div>";
				str += "<div class=piao_div1>状    态:(1为已使用)</div><div class=piao_div2><input name='status' id='status' value='" + entkey['status']+"'></div>";
				str += "<div class=piao_div1>&nbsp;</div><div class=piao_div2><input type='submit' value='提交'><input type='button' onclick=close_piao('msg') value='关闭窗口'></div>";
				str += "</from>";
			var msg = document.getElementById('msg');
			var msg_div = document.getElementById('msg_div');
			msg_div.innerHTML = '';
			msg_div.style.height = '220px';
			var b = document.body;
			var b_w = b.scrollWidth;
			//var b_h = b.scrollHeight;
			
			msg.style.left = (b_w - (msg.style.width ? parseInt(msg.style.width) : 600))/2;
			msg.style.top = 80;
			msg.style.height = msg_div.style.height + 40;
			msg_div.innerHTML = str;
			msg.style.display = 'block';
		}
	
	});
}
function close_piao(id)
{
	document.getElementById(id).style.display = 'none';
}

function entkey_update(id)
{
	if (id==undefined) {
		return;
	}
	var randkey = $("#randkey").val();
	var price = $("#price2").val();
	var addtime = $("#add_time").val();
	var trytime = $("#try_time").val();
	var user = $("#user").val();
	var status= $("#status").val();
	var agent_user = $("#agent_user").val();
	$.ajax({
		type:'post',
		url:'?c=entkey&a=entkeyUpdate',
		data:'id=' + id + "&randkey=" + randkey + '&add_time=' + addtime + '&try_time=' + trytime + '&user=' + user + '&status=' + status + '&price=' + price + '&agent_user=' + agent_user,
		dataType:'json',
		success:function(ret) {
			if (ret['code']!=200) {
				return alert(ret['msg'] ? ret['msg'] : '修改失败');
			}
			window.location.reload();
		}
		
	});
}