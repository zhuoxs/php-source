function domains_del(id)
{
	if (!confirm("确定要删除?")) {
		return;
	}
	verificationAjax('?c=domains&a=del','id='+id);
}