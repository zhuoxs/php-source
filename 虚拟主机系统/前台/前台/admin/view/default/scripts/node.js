var isverification = 0;
function del_node(name) {
	if (!confirm("该操作将影响到所有开设到该主机上的产品,确定要删除?")) {
		return;
	}
	verificationAjax('?c=nodes&a=del','name='+name);
}