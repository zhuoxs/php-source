  var slide_max = 5;//大图数  v3-b 12
  var adv_max = 5;//小图组数
  var pic_max = 3;//组内小图数  
  var slide_obj = {};
  var upload_obj = {};
  var adv_obj = {};
  var adv_upload_obj = {};
$(function(){
    $('#slide_color').colorpicker({showOn:'both'});//初始化切换大图背景颜色控件
    $('#slide_color').parent().css("width",'');
    $('#slide_color').parent().addClass("color");
	$(".type-file-file-shop").change(function() {//初始化图片上传控件
		$(this).prevAll(".type-file-text-shop").val($(this).val());
	});
	$("#homepageFocusTab .tab-base li a").click(function() {//切换
	    var pic_form = $(this).attr("form");
	    $('.tab-content').hide();
	    $("#homepageFocusTab .tab-base li a").removeClass("current");
	    $('#'+pic_form).show();
	    $(this).addClass("current");
	});

	$(".ncap-channel-category").sortable({ items: 'dl' });
	$(".ncap-channel-category ul").sortable({ items: 'li' });

	slide_obj = $("#upload_slide_form");//初始化焦点大图区数据
    upload_obj = $("#upload_slide");
	slide_obj.find("ul").sortable({ items: 'li' });

	adv_obj = $("#upload_adv_form");//初始化三张联动区数据
	adv_obj.find(".focus-trigeminy").sortable({ items: 'div[focus_id]' });
	adv_obj.find("ul").sortable({ items: 'li' });
    adv_upload_obj = $("#upload_adv");
    $("dl[select_class_id]").each(function() {
        var gc_id = $(this).attr("select_class_id");
        upload_gc(gc_id);
    });
});
function update_data(id) {//更新
	var get_text = $.ajax({
		type: "POST",
		url: 'index.php?act=web_channel&op=code_update',
		data: $("#"+id+"_form").serialize(),
		async: false
		}).responseText;
	return get_text;
}

//分类相关
function get_goods_class(){//查询子分类
	var gc_id = $("#gc_parent_id").val();
	if (gc_id>0) {
		if($("dl[select_class_id='"+gc_id+"']").size()>0) return;//避免重复
		$.get('index.php?act=web_channel&op=get_category_list&id='+gc_id, function(data){
		  $(".ncap-channel-category").append(data);
		  $(".ncap-channel-category").sortable({ items: 'dl' });
		  $(".ncap-channel-category ul").sortable({ items: 'li' });
		  upload_gc(gc_id);
		});
	}
}
function del_gc_parent(gc_id){//删除已选分类
	$("dl[select_class_id='"+gc_id+"']").remove();
	$("#upload_"+gc_id).remove();
}
function del_goods_class(gc_id){//删除子分类
	$("li[gc_id='"+gc_id+"']").remove();
}
function upload_gc(gc_id) {//分类图片
    var obj = $("#upload_category");
    obj.find("input[name='gc_id']").val(gc_id);
    var gc_obj = $("#upload_category").clone(true);
    gc_obj.attr("target","upload_"+gc_id);
    gc_obj.attr("id","upload_category_"+gc_id);
    gc_obj.insertBefore("#form_"+gc_id);
    $("#upload_0").after('<iframe style="display:none;" src="" name="upload_'+gc_id+'" id="upload_'+gc_id+'"></iframe>');
    gc_obj = $("#upload_category_"+gc_id);
    gc_obj.show();
    gc_obj.find("input").change(function() {
        gc_obj.submit();
    });
}
function update_pic(gc_id,pic) {//更新图片
    var obj = $("dl[select_class_id='"+gc_id+"']");
    obj.find("span[select_id='"+gc_id+"']").html('<img src="'+UPLOAD_SITE_URL+'/'+pic+'"/>');
    obj.find("input[name*='[gc_pic]']").val(pic);
    update_channel_category();
}
function update_channel_category() {//更新
	var get_text = update_data("upload_category");
	if (get_text=='1') {
	    $('#upload_category_form .web-save-succ').show();
	    setTimeout("$('#upload_category_form .web-save-succ').hide()",2000);
	}
}
//焦点区切换大图上传
function add_slide() {//增加图片
	for (var i = 1; i <= slide_max; i++) {//防止数组下标重复
		if (slide_obj.find("li[slide_id='"+i+"']").size()==0) {//编号不存在时添加
    	    var text_input = '';
    	    var text_type = '图片调用';
    	    text_input += '<input name="channel_slide['+i+'][pic_id]" value="'+i+'" type="hidden">';
    	    text_input += '<input name="channel_slide['+i+'][pic_name]" value="" type="hidden">';
    	    text_input += '<input name="channel_slide['+i+'][pic_url]" value="" type="hidden">';
    	    text_input += '<input name="channel_slide['+i+'][color]" value="" type="hidden">';
    	    text_input += '<input name="channel_slide['+i+'][pic_img]" value="" type="hidden">';
			var add_html = '';
			add_html = '<li slide_id="'+i+'" title="可上下拖拽更改显示顺序"><div class="title"><h4></h4><a class="ncap-btn-mini del" href="JavaScript:del_slide('+i+
			');"><i class="fa fa-trash"></i>删除</a></div><div class="focus-thumb" onclick="select_slide('+i+');" title="点击编辑选中区域内容"><img src="'+ADMIN_TEMPLATES_URL
			+'/images/picture.gif" /></div>'+text_input+'</li>';
			slide_obj.find("ul").append(add_html);
			select_slide(i);
			break;
		}
    }
}
function screen_pic(pic_id,pic_img) {//更新图片
	if (pic_img!='') {
	    var color = slide_obj.find("input[name='slide_pic[color]']").val();
	    var pic_name = slide_obj.find("input[name='slide_pic[pic_name]']").val();
	    var pic_url = slide_obj.find("input[name='slide_pic[pic_url]']").val();
	    var obj = slide_obj.find("li[slide_id='"+pic_id+"']");
	    obj.find("img").attr("src",UPLOAD_SITE_URL+'/'+pic_img);
	    obj.find("img").attr("title",pic_name);
        obj.find("input[name='channel_slide["+pic_id+"][pic_name]']").val(pic_name);
        obj.find("input[name='channel_slide["+pic_id+"][pic_url]']").val(pic_url);
        obj.find("input[name='channel_slide["+pic_id+"][color]']").val(color);
        obj.find("input[name='channel_slide["+pic_id+"][pic_img]']").val(pic_img);
	    obj.find(".focus-thumb").css("background-color",color);
	}
	slide_obj.find('.web-save-succ').show();
	setTimeout("slide_obj.find('.web-save-succ').hide()",2000);
}
function select_slide(pic_id) {//选中图片
    var obj = slide_obj.find("li[slide_id='"+pic_id+"']");
    var ap = obj.attr("ap");
    slide_obj.find("li").removeClass("selected");
    obj.addClass("selected");
    var pic_name = obj.find("input[name='channel_slide["+pic_id+"][pic_name]']").val();
    var pic_url = obj.find("input[name='channel_slide["+pic_id+"][pic_url]']").val();
    var color = obj.find("input[name='channel_slide["+pic_id+"][color]']").val();
    $("input[name='slide_id']").val(pic_id);
    $("input[name='slide_pic[pic_name]']").val(pic_name);
    $("input[name='slide_pic[pic_url]']").val(pic_url);
    $("input[name='slide_pic[color]']").val(color);
    upload_obj.find(".type-file-file").val('');
    upload_obj.find(".type-file-text").val('');
    upload_obj.show();
    upload_obj.find('.evo-pointer').css("background-color",color);
}
function del_slide(pic_id) {//删除图片
    if (slide_obj.find("li").size()<2) {
         return;//保留一个
    }
	slide_obj.find("li[slide_id='"+pic_id+"']").remove();
	var slide_id = slide_obj.find("input[name='slide_id']").val();
	if (pic_id==slide_id) {
    	slide_obj.find("input[name='key']").val('');
    	upload_obj.hide();
	}
}

//焦点区切换小图上传
function add_adv() {//增加
	for (var i = 1; i <= adv_max; i++) {//防止数组下标重复
		if (adv_obj.find("div[focus_id='"+i+"']").size()==0) {//编号不存在时添加
			var add_html = '';
			var text_type = '图片调用';
			add_html = '<div focus_id="'+i+'" class="focus-trigeminy-group" title="可上下拖拽更改显示顺序"><div class="title"><h4></h4>'+
			'<a class="ncap-btn-mini del" href="JavaScript:del_adv('+i+');"><i class="fa fa-trash"></i>删除</a></div><ul></ul></div>';
			adv_obj.find("#add_list").before(add_html);
			for (var pic_id = 1; pic_id <= pic_max; pic_id++) {
			    var text_append = '';
			    text_append += '<li pic_id="'+pic_id+'" onclick="select_adv('+i+',this);" title="可左右拖拽更改图片排列顺序">';
				text_append += '<div class="focus-thumb">';
			    text_append += '<img title="" src="'+ADMIN_TEMPLATES_URL+'/images/picture.gif"/>';
				text_append += '</div>';
        	    text_append += '<input name="channel_adv['+i+'][pic_list]['+pic_id+'][pic_id]" value="'+pic_id+'" type="hidden">';
        	    text_append += '<input name="channel_adv['+i+'][pic_list]['+pic_id+'][pic_name]" value="" type="hidden">';
        	    text_append += '<input name="channel_adv['+i+'][pic_list]['+pic_id+'][pic_url]" value="" type="hidden">';
        	    text_append += '<input name="channel_adv['+i+'][pic_list]['+pic_id+'][pic_img]" value="" type="hidden">';
			    text_append += '</li>';
			    adv_obj.find("div[focus_id='"+i+"'] ul").append(text_append);
			}
			adv_obj.find("div ul").sortable({ items: 'li' });
			adv_obj.find("div[focus_id='"+i+"'] li[pic_id='1']").trigger("click");//默认选中第一个图片
			break;
		}
	}
}
function select_adv(focus_id,pic) {//选中图片
    var obj = $(pic);
    var pic_id = obj.attr("pic_id");
    var list = obj.attr("list");
    adv_obj.find("li").removeClass("selected");
    obj.addClass("selected");
    var pic_name = obj.find("input[name*='[pic_name]']").val();
    var pic_url = obj.find("input[name*='[pic_url]']").val();

    adv_obj.find("input[name='slide_id']").val(focus_id);
    adv_obj.find("input[name='pic_id']").val(pic_id);
    adv_obj.find("input[name='focus_pic[pic_name]']").val(pic_name);
    adv_obj.find("input[name='focus_pic[pic_url]']").val(pic_url);
    adv_obj.find(".type-file-file").val('');
    adv_obj.find(".type-file-text").val('');
    adv_upload_obj.show();
}
function focus_pic(pic_id,pic_img) {//更新图片
	if (pic_img!='') {
	    var focus_id = adv_obj.find("input[name='slide_id']").val();
	    var pic_name = adv_obj.find("input[name='focus_pic[pic_name]']").val();
	    var pic_url = adv_obj.find("input[name='focus_pic[pic_url]']").val();
	    var obj = adv_obj.find("div[focus_id='"+focus_id+"'] li[pic_id='"+pic_id+"']");
	    obj.find("img").attr("src",UPLOAD_SITE_URL+'/'+pic_img);
	    obj.find("img").attr("title",pic_name);
        obj.find("input[name*='[pic_name]']").val(pic_name);
        obj.find("input[name*='[pic_url]']").val(pic_url);
        obj.find("input[name*='[pic_img]']").val(pic_img);
    }
	adv_obj.find('.web-save-succ').show();
	setTimeout("adv_obj.find('.web-save-succ').hide()",2000);
}
function del_adv(focus_id) {//删除切换组
    if (adv_obj.find("div[focus_id]").size()<2) {
         return;//保留一个
    }
	adv_obj.find("div[focus_id='"+focus_id+"']").remove();
	var slide_id = adv_obj.find("input[name='slide_id']").val();
	if (focus_id==slide_id) {
    	adv_obj.find("input[name='slide_id']").val('');
    	adv_upload_obj.hide();
	}
}