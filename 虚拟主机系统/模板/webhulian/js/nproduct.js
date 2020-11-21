//丢弃
function show(url) 
{ 
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function check_register()
{
	if(reg.name.value.length<3){
		alert('用户名长度最小为3个字母');
		return false;
	}
	if(reg.passwd.value.length<5){
		alert('密码长度最小要6位');
		return false;
	}
	if(reg.passwd.value.length>16){
		alert('密码长度最长16位');
		return false;
	}
	if(reg.passwd.value!=reg.passwd2.value){
		alert('两次密码不对');
		return false;
	}
	piao_msg();
	
	reg.submit();
}
function piao_msg()
{
	$("#msg").html("正在购买中.请等待.......");
	$("#msg").css("top",'200px');
	
	$("#msg").css('display','block');
	
}
function check_name()
{
	var name = $("#name").val();
	if (name == '') {
		return alert("名称不能为空");
	}
	$.ajax({
		type:'get',
		url :'?c=hosting&a=checkName',
		data:{name:name,nodename:nodename,pid:product_id},
		dataType:'json',
		success:function(ret) {
			if (ret['code'] == 200) {
				return alert("可用");
			}
			return alert(ret['msg'] ? ret['msg'] :'不可用');
		}
		
	});
	
}