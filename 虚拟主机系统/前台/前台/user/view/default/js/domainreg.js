function check_register()
{
	if (reg.email.value == '') {
		return alert("邮箱地址不能为空");
	}
	if (reg.phonenumber.value == '') {
		return alert("联系电话不能为空");
	}
	if (reg.city.value == '') {
		return alert('城市不能为空');
	}
	if (reg.firstname.value == '') {
		return alert('英文名称不能为空');
	}
	if (reg.lastname.value == '') {
		return alert('英文姓不能为空');
	}
	if (extension == 'org') {
		if (reg.companyname.value == '') {
			return alert('单位名称不能为空');
		}
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
function show_price(year)
{
	var price_msg;
	if (!price || price[year] ==undefined) {
		price_msg = '<font color=red>获取价格错误,请关闭浏览器后重试或联系管理员</font>';
	}else if(price[year] <=0) {
		price_msg = '<font color=red>当前年份被禁止,请选择其他年份注册</font>';
	}else {
		price_msg = price[year] + '元';
	}
	$("#show_domain_reg_price").html(price_msg);
}
function getRegPrice(extension)
{
	$.ajax({
		type:'get',
		url:'?c=domains&a=getRegPrice',
		data:'extension=' + extension,
		dataType:'json',
		async:false,
		success:function(ret) {
			if (ret['code'] != 200) {
				return false;
			}
			price[1] = ret['price']['oneyear'];
			price[2] = ret['price']['twoyear'];
			price[3] = ret['price']['threeyear'];
			price[4] = ret['price']['fouryear'];
			price[5] = ret['price']['fiveyear'];
			price[6] = ret['price']['sixyear'];
			price[7] = ret['price']['sevenyear'];
			price[8] = ret['price']['eightyear'];
			price[9] = ret['price']['nineyear'];
			price[10] = ret['price']['tenyear'];
		}
	});
}