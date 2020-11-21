  DialogManager.close = function(id) {
	__DIALOG_WRAPPER__[id].hide();
	ScreenLocker.unlock();
  } 
  DialogManager.show = function(id) {
	if (__DIALOG_WRAPPER__[id]) {
		__DIALOG_WRAPPER__[id].show('center');
		ScreenLocker.lock();
		return true;
	}
	return false;
  }
  var recommend_max = 4;//推荐数   v3- b12
  var goods_max = 8;//商品数
  var recommend_show = 1;//当前选择的商品推荐
  var titles = new Array();
  titles["recommend_list"] = '商品推荐';
  titles["channel_tit"] = '标题设置';
  titles["upload_channel_act"] = '活动图片';
  titles["upload_adv_a"] = '广告图片1';
  titles["upload_adv_b"] = '广告图片2';
  titles["upload_adv_c"] = '广告图片3';

$(function(){
    //自定义滚定条
    $('.middle').perfectScrollbar();
    //随Y轴滚动固定层定位
    $('.middle').waypoint(function(event, direction) {
    	$(this).parent().toggleClass('sticky', direction === "down");
            event.stopPropagation();
    });
    $(".middle").sortable({
        items: 'dl',
        update: function(event, ui) {//推荐拖动排序保存
            $("#recommend_input_list").html('');
            $(".middle dl").each(function(){
                var recommend_id = $(this).attr("recommend_id");
                $("#recommend_input_list").append('<input type="hidden" name="recommend_list['+recommend_id+']" value="">');
            });
            update_data("recommend_list");//更新数据
        }
    });
});
function show_dialog(id) {//弹出框
	if(DialogManager.show(id)) return;
	var d = DialogManager.create(id);//不存在时初始化(执行一次)
	var dialog_html = $("#"+id+"_dialog").html();
	$("#"+id+"_dialog").remove();
	d.setTitle(titles[id]);
	d.setContents('<div id="'+id+'_dialog" class="'+id+'_dialog">'+dialog_html+'</div>');
	d.setWidth(640);
	d.show('center',1);
	update_dialog(id);
}
function replace_url(url) {//去当前网址
	return url.replace(UPLOAD_SITE_URL+"/", '');
}
function update_data(id) {//更新
	var get_text = $.ajax({
		type: "POST",
		url: 'index.php?act=web_channel&op=code_update',
		data: $("#"+id+"_form").serialize(),
		async: false
		}).responseText;
	return get_text;
}
function update_dialog(id) {//初始化数据
	switch (id) {
		case "recommend_list":
			gcategoryInit("recommend_gcategory");
			$("#recommend_list_form dl dd ul").sortable({ items: 'li' });
			break;
		default:
			$("#"+id+"_dialog tr.odd").click(function() {
				$(this).next("tr").toggle();
				$(this).find(".title").toggleClass("ac");
				$(this).find(".arrow").toggleClass("up");
			});
			$("#"+id+"_dialog .type-file-file-shop").change(function() {//初始化图片上传控件
				$("#"+id+"_dialog .type-file-text-shop").val($(this).val());
			});
			break;
	}
}
//标题设置
function update_channel_tit() {
	var get_text = update_data("channel_tit");
	if (get_text=='1') {
	    var tit_title = $.trim($('#tit_title').val());
	    $("#channel_tit").html('<h2>'+tit_title+'</h2>');
	    DialogManager.close("channel_tit");
    }
}

//商品推荐相关
function show_recommend_dialog(id) {//弹出框
	recommend_show = id;
	$("div[select_recommend_id]").hide();
	$("div[select_recommend_id='"+id+"']").show();
	show_dialog('recommend_list');
}
function get_recommend_goods() {//查询商品
	var gc_id = 0;
	$('#recommend_gcategory > select').each(function() {
		if ($(this).val()>0) gc_id = $(this).val();
	});
	var goods_name = $.trim($('#recommend_goods_name').val());
	if (gc_id>0 || goods_name!='') {
		$("#show_recommend_goods_list").load('index.php?act=web_channel&op=recommend_list&'+$.param({'id':gc_id,'goods_name':goods_name }));
	}
}
function del_recommend(id) {//删除商品推荐
    if ($(".middle dl").size()<2) {
         return;//保留一个
    }
	if(confirm('您确定要删除吗?')) {
		$(".middle dl[recommend_id='"+id+"']").remove();
		$("input[name='recommend_list["+id+"]']").remove();
		$("div[select_recommend_id='"+id+"']").remove();
		update_data("recommend_list");//更新数据
	}
}
function add_recommend() {//增加商品推荐
	for (var i = 1; i <= recommend_max; i++) {//防止数组下标重复
		if ($(".middle dl[recommend_id='"+i+"']").size()==0) {//编号不存在时添加
			var add_html = '';
			var del_append = '';
			del_append = '<a href="JavaScript:del_recommend('+i+');"><i class="fa fa-trash"></i>删除</a>';//删除
			add_html = '<dl recommend_id="'+i+'"><dt><h4>商品推荐</h4>'+del_append+
    			'<a href="JavaScript:show_recommend_dialog('+i+');"><i class="fa fa-shopping-cart"></i>商品块</a></dt>'+
    			'<dd><ul class="goods-list"><li><span><i class="icon-gift"></i></span></li><li><span><i class="icon-gift"></i></span></li><li><span><i class="icon-gift"></i></span></li>'+
    			'<li><span><i class="icon-gift"></i></span></li><li><span><i class="icon-gift"></i></span></li><li><span><i class="icon-gift"></i></span></li>'+
    			'<li><span><i class="icon-gift"></i></span></li><li><span><i class="icon-gift"></i></span></li></ul></dd></dl>';
			$("#btn_add_list").before(add_html);
			$("#add_recommend_list").before('<div class="ncap-form-default" select_recommend_id="'+i+'"><dl class="row"><dt class="tit">商品推荐模块标题名称</dt>'+
    			'<dd class="opt"><input name="recommend_list['+i+'][recommend][name]" value="商品推荐" type="text" class="input-txt">'+
    			'<p class="notic">修改该区域中部推荐商品模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏</p></dd></dl></div>'+
    			'<div class="ncap-form-all" select_recommend_id="'+i+'"><dl class="row"><dt class="tit">推荐商品</dt><dd class="opt"><ul class="dialog-goodslist-s1 goods-list">'+
    			'</ul></dd></dl></div>');
			$("#recommend_list_form dl dd ul").sortable({ items: 'li' });
			break;
		}
	}
}
function select_recommend_goods(goods_id) {//商品选择
	var id = recommend_show;
	var obj = $("div[select_recommend_id='"+id+"']");
	if(obj.find("img[select_goods_id='"+goods_id+"']").size()>0) return;//避免重复
	if(obj.find("img[select_goods_id]").size()>=goods_max) return;
	var goods = $("#show_recommend_goods_list img[goods_id='"+goods_id+"']");
	var text_append = '';
	var goods_pic = goods.attr("src");
	var goods_name = goods.attr("title");
	var goods_price = goods.attr("goods_price");
	var market_price = goods.attr("market_price");
	text_append += '<div ondblclick="del_recommend_goods('+goods_id+');" class="goods-pic">';
	text_append += '<span class="ac-ico" onclick="del_recommend_goods('+goods_id+');"></span>';
	text_append += '<span class="thumb size-72x72">';
	text_append += '<i></i>';
  	text_append += '<img select_goods_id="'+goods_id+'" title="'+goods_name+'" goods_name="'+goods_name+'" src="'+goods_pic+'" onload="javascript:DrawImage(this,72,72);" />';
	text_append += '</span></div>';
	text_append += '<div class="goods-name">';
	text_append += '<a href="'+SHOP_SITE_URL+'/index.php?act=goods&goods_id='+goods_id+'" target="_blank">';
  	text_append += goods_name+'</a>';
	text_append += '</div>';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_id]" value="'+goods_id+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][market_price]" value="'+market_price+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_name]" value="'+goods_name+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_price]" value="'+goods_price+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_pic]" value="'+replace_url(goods_pic)+'" type="hidden">';
	obj.find("ul").append('<li id="select_recommend_'+id+'_goods_'+goods_id+'">'+text_append+'</li>');
}
function del_recommend_goods(goods_id) {//删除已选商品
	var id = recommend_show;
	var obj = $("div[select_recommend_id='"+id+"']");
	obj.find("img[select_goods_id='"+goods_id+"']").parent().parent().parent().remove();
}
function update_recommend() {//更新
    var id = recommend_show;
	var get_text = update_data("recommend_list");
	if (get_text=='1') {
      var obj = $("div[select_recommend_id='"+id+"']");
      var text_append = '';
      var recommend_name = obj.find("dd input.input-txt").val();
      $(".middle dl[recommend_id='"+id+"'] dt h4").html(recommend_name);
      obj.find("img").each(function() {
      	var goods = $(this);
      	var goods_pic = goods.attr("src");
      	var goods_name = goods.attr("goods_name");
      	text_append += '<li><span><a href="javascript:void(0);"><img title="'+goods_name+'" src="'+goods_pic+'"/></span></a></li>';
      });
	  $("dl[recommend_id='"+id+"'] dd ul").html('');
	  $(".middle dl[recommend_id='"+id+"'] dd").html('<ul class="goods-list">'+text_append+'</ul>');
	  DialogManager.close("recommend_list");
	}
}

//图片上传
function update_pic(id,pic) {//更新图片
	var obj = $("#picture_"+id);
	obj.html('<img src="'+UPLOAD_SITE_URL+'/'+pic+'" />');
	DialogManager.close("upload_"+id);
}