var column = 1;
var row = 1;
var column2=1;
var row2 =1;
$(document).ready(function(){
	$(function(){
	    $('#btntext').bind('input propertychange', function() {
	        $('#btnval').html($(this).val());
	    });
	})
	var wheight = $(window).height();
	$('.seatalert').css('height',wheight)
	$('.seat_btn_del').click(function(){
		$('.seatalert').hide()
	})
})
$(window).resize(function(){
	var wheight = $(window).height();
	$('.seatalert').css('height',wheight)
})
var addcolumn = function(){
	column ++;
	column2++
	var addcolumn = '<div class="mb15 clearfix"><input oninput="change1('+column2+')" class="edit_seat_input fl" type="text" name="" id="column'+column2+'" value="xxx" /><div class="edit_seat_del ml10 fl" name="'+column+'" onclick="delcolumn(this,'+column+')">删除</div></div>'
	$('#column').append(addcolumn)
	for(var i=1;i<=row;i++){
		var addtd1 = '<td  name="'+column+'"><span class="tbTitleSelect" id="c'+i+column+'" onclick="changepic('+i+column+')" data="1">可选</span></td>';
		$('#show_content_table tr').eq(i).append(addtd1)
	}
//	var addtd1 = '<td name="'+column+'"><img src="/addons/sudu8_page_plugin_travel/template/img/seat2.png"/></td>';
	var addtd2 = '<td name="'+column+'"><div class="tbTitle" id="columnval'+column2+'">xxx</div></td>'
	$('#show_content_table tr:first-child').append(addtd2);
//	$('#show_content_table tr').not('#show_content_table tr:first-child').append(addtd1);
}
var change1 =function (column){
	var val = $('#column'+column).val()
	$('#columnval'+column).html(val);
	console.log(val)
}
var addrow = function(){
	row++;
	row2++
	var addrow = '<div class="mb15 clearfix"><input class="edit_seat_input fl" oninput="change2('+row2+')" type="text" name="" id="row'+row2+'" value="xxx" /><div class="edit_seat_del ml10 fl" name="'+row+'" onclick="delrow(this,'+row+')">删除</div></div>'
	$('#row').append(addrow)
	var addtr = '<tr name="'+row+'"><td><div class="tbTitle" id="rowval'+row2+'">xxx</div></td>'
	
	for (var i=1;i<=column;i++) {
		addtr += '<td name="'+i+'"><span class="tbTitleSelect" id="c'+row+i+'" onclick="changepic('+row+i+')" data="1">可选</span></td>'
	}
	addtr += '</tr>';
	$('#show_content_table').append(addtr);
}
var change2 =function (row){
	var val = $('#row'+row).val()
	$('#rowval'+row).html(val)
}
var delcolumn =function(e,a){
	if(column==1){
		alert('至少有一个横排')
	}else{
		e.parentNode.remove()
		column--
		$('#show_content_table td[name="'+a+'"]').remove()
	}
}
var delrow = function(e,a){
	if(row==1){
		alert('至少有一个竖排')
	}else{
		e.parentNode.remove()
		row--
		$('#show_content_table tr[name="'+a+'"]').remove()
	}
}
var changepic = function(a){
	var data = $('#c'+a).attr('data');
	if(data==1){
		$('#c'+a).text('禁用');
		$('#c'+a).addClass('selected');
		$('#c'+a).attr('data','2');
	}else{
		$('#c'+a).text('可选');
		$('#c'+a).removeClass('selected');
		$('#c'+a).attr('data','1');
	}
}
