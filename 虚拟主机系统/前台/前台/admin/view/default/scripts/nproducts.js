function nproduct_del(id)
{
	if (!confirm("确定要删除?")) {
		return;
	}
	verificationAjax('?c=nproduct&a=del','id='+id);
}
function show_groupname()
{
	$.ajax({
		type:'get',
		url :'?c=productgroup&a=getList',
		data:null,
		dataType:'json',
		async:false,
		success:function(ret) {
			if (ret) {
				$(".product_groupid").each(function(){
					var pid = $(this).text();
					for (var i in ret) {
						if (pid==ret[i]['group_id']) {
							$(this).text(ret[i]['group_name']);
						}
					}
				});
			}
		}
	});
}