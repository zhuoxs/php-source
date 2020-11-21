function show_domain_renew_price(year) {
	var price_msg;

	if (!renewprice || renewprice[year] == undefined) {
		price_msg = '<font color=red>获取价格错误,请关闭浏览器后重试或联系管理员</font>';
	} else if (renewprice[year] <= 0) {
		price_msg = '<font color=red>当前年份被禁止,请选择其他年份续费</font>';
	} else {
		price_msg = renewprice[year] + '元';
	}
	$("#show_renew_price").html(price_msg);
}
function getRenewPrice() {
	$.ajax({
		type : 'get',
		url : '?c=domains&a=getRenewPrice',
		data : 'id=' + id,
		dataType : 'json',
		async : false,
		success : function(ret) {
			if (ret['code'] != 200) {
				return alert(ret['msg'] ? ret['msg'] : '获取价格错误');
			}
			renewprice[1] = ret['price']['oneyear'];
			renewprice[2] = ret['price']['twoyear'];
			renewprice[3] = ret['price']['threeyear'];
			renewprice[4] = ret['price']['fouryear'];
			renewprice[5] = ret['price']['fiveyear'];
			renewprice[6] = ret['price']['sixyear'];
			renewprice[7] = ret['price']['sevenyear'];
			renewprice[8] = ret['price']['eightyear'];
			renewprice[9] = ret['price']['nineyear'];
			renewprice[10] = ret['price']['tenyear'];
		}
	});
}