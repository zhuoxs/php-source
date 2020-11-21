function del_user(username)
{
	if (!confirm("确定要删除?")) {
		return;
	}
	verificationAjax('?c=user&a=del','username='+username);
}
var ddlog = null;
var operating_string = null;
function piao_add_money(username)
{
	var html = '<form action="javascript:;" method="post">';
	html += '充值金额:<input name="money" id="addmoney">&nbsp;元';
	//html += '<input name="operating_string" id="addmoneyoperating_string" type="hidden">';
	html += '<input type=button value="确定" onclick=add_money("'+username+'")>';
	html += '</form>';
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
		operating_string = str;
	}
	var dialog = art.dialog({id:'id222',content:html,icon:'',title:'给'+username+'充值'});
	ddlog = dialog;
}
function add_money(username)
{
	var money = $("#addmoney").val();
	$.ajax({url:'?c=user&a=editMoney&username='+username,type:'get',data:'money='+money+'&operating_string='+operating_string,dataType:'json',success:function(ret){
		if (ddlog != null) {
			ddlog.close();
		}
		if (ret['code'] != 200) {
			art.dialog({id:'id22',content:'给'+username+'充值失败',time:2,icon:'error'});
		}else {
			art.dialog({id:'id22',content:'给'+username+'充值成功',time:2,icon:'succeed'});
			setTimeout(function(){
				window.location = window.location;
			},2000);
		}
	}
		
	});
}