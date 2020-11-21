	function hosting_del(id) 
	{
		if (!confirm("确定要删除?")) {
			return;
		}
		verificationAjax('?c=hosting&a=del','id='+id);
	}
	function search_submit()
	{
		var key = $('#search_key').val();
		var value = $('#search_value').val();
		if (key== '' || value == '') {
			return;
		}
		window.location = action + '&' + key + '=' + value;
	}
	function change_status(hostid,status)
	{
		var des = status==0 ? '开通' : '暂停';
		if (confirm("确定要" + des + "该产品吗?")=== false) {
			return ;
		}
		if (hostid == undefined || status == undefined) {
			return;
		}
		$.ajax({
			type:'get',
			url :'?c=hosting&a=changeStatus',
			data:'id=' + hostid + '&status=' + status,
			dataType:'json',
			success:function(ret) {
				if (ret['code'] != 200) {
					return alert(ret['msg'] ? ret['msg'] : des + '产品失败');
				}
				window.location = window.location;
			}
		});
	}
	function show_productname()
	{
		$.ajax({
			type:'get',
			url :'?c=nproduct&a=getList',
			data:null,
			dataType:'json',
			async:false,
			success:function(ret) {
				if (ret) {
					$(".hosting_product_id").each(function(){
						var pid = $(this).text();
						for (var i in ret) {
							if (pid==ret[i]['id']) {
								$(this).text(ret[i]['name']);
							}
						}
					});
				}
			}
		});
	}