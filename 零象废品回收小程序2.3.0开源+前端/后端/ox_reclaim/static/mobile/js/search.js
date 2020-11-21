$(document).ready(function(){
	$("#area").cityPicker({
		title: "请选择地区",
		showDistrict: false,
	});
	$('#search').click(function(){
		keyword=$('#keyword').val();
		code=$('#area').attr('data-code');
		info_type=$('input[name="info_type"]:checked').val();
		base.redirect('index.html?area_code='+code+'&keyword='+keyword+'&info_type='+info_type);
	});
});