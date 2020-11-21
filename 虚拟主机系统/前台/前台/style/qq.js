$(document).ready(function() {
	piao_qq_div();

});
function piao_qq_div() {
	$.ajax({
		type : 'get',
		url : '?c=public&a=getQq',
		data : null,
		async : false,
		dataType : 'json',
		success : function(ret) {
			if (ret['count'] < 1) {
				return;
			}
			var qqs = ret['qqs'];
			var str = "<div id='qq' class='piao_qq'>";
			for ( var j in qqs) {
				var qq = qqs[j];
				var name = j==0 ? "客服部" : j==1 ? "客服经理" : "技术部";
					str += "<p class='qq_name'><b>" + name + "</b></p>";
				for ( var i in qq) {
						str += "<p><img src='/style/qq.jpg'>";
						str += "<a href='javascript:show_qq("
								+ qq[i] + ")'><font color='red' size='2'>QQ:" + qq[i] + "</font></a>";
					str += "</P>";
				}
			}
			str += " </div>";
			$("#show_qq").html(str);
			document.getElementById('show_qq').style.display = 'block';
		}

	});

}
function show_qq(qq) {
	var url = "http://wpa.qq.com/msgrd?v=3&uin=" + qq + "&site=qq&menu=yes";
	window.location = url;
}
