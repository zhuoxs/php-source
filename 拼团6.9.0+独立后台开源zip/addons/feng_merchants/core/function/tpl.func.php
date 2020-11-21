<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * 拼团商城公共方法
 */
 function wl_tpl_form_field_date($name, $value = '', $withtime = false) {
	$html = '';
	if (!defined('TPL_INIT_DATATIMEPICKER')) {
		$html = <<<EOF
<script type="text/javascript">
require(['datetimepicker'], function(){
	$(function(){
		$(".datetimepicker").each(function(){
			var option = {
				changeYear : true,
				changeMonth : true,
				timeFormat : 'HH:mm:ss',
				dateFormat : 'yy-mm-dd',
				stepHour : 1,
				stepMinute : 1,
				stepSecond : 1
			}
			if($(this).data('datetimepicker') == 'datetime'){
				$(this).datetimepicker(option);
			} else {
				$(this).datepicker(option);
			}
		});
	});
});
</script>
EOF;
		define('TPL_INIT_DATATIMEPICKER', true);
	}
	if ($withtime) {
		$withtime = 'data-datetimepicker="datetime"';
		$placeholder = '请选择日期时间';
		$value = $value ? date('Y-m-d H:i:s', $value) : '';
	} else {
		$withtime = '';
		$placeholder = '请选择日期';
		$value = $value ? date('Y-m-d', $value) :'';
	};

	$html .= <<<EOF
<div class="btn btn-default date-time-picker clearfix" style="width: 100%;">
	<input type="text" {$withtime} style="z-index:1000;position:relative;" readonly="readonly" name="{$name}" value="{$value}" placeholder="{$placeholder}" class="datetimepicker form-control pull-left"/>
	<i class="fa fa-calendar pull-right" onclick="$(this).prev().datetimepicker('show');"></i>
	<i class="fa fa-times pull-right" onclick="$(this).parent().find('input').val('').blur();"></i>
</div>
EOF;
	return $html;
}
function wl_tpl_form_field_image($name, $attachment = '', $options = array()) {
	global $_W;
	
	load()->model('attachment');
	
	if (empty($options) || !is_array($options)) {
		$options = array();
	}
	$options['direct'] = true;
	$options['multiple'] = false;
	$options['type'] = 'image';
	
	$jsoptions = json_encode($options);
	
	$s = '';
	
	if (!defined('TPL_INIT_IMAGE')) {
		$nopic = IMAGE_NOPIC_SMALL;
		$s = <<<EOF
<style>
	.tpl-single-image {margin-top:.5em;}
	.tpl-single-image .thumbnail{position:relative; width:80px; height:80px; line-height:80px; background:url({$nopic}) center center no-repeat; background-size:contain; margin-right:.5em; cursor: pointer; }
	.tpl-single-image .thumbnail i{position:absolute; display:block; width:20px; height:20px; line-height:20px; text-align:center; top: -5px; right: -5px; font-size:14px; z-index:10; cursor:pointer; color:#FFF; background:#888; border-radius:100%;}
	.tpl-single-image .thumbnail span{display:block; width:100%; position:absolute; bottom:0; left:0; height:25px; line-height:25px; color:#FFF; background:rgba(51,51,51,0.5); text-align:center; border-bottom-left-radius:4px; border-bottom-right-radius:4px; z-index:10; cursor:pointer;}
	.tpl-single-image .thumbnail i,.thumbnail span.change-image{display:none;}
	.tpl-single-image .thumbnail:hover i,.thumbnail:hover span.change-image{display:block;}
	.tpl-single-image .thumbnail i:hover{background:#000;}
	.tpl-single-image .add-image {position : relative; width: 80px; height: 80px; line-height:80px; border:1px solid #ddd; cursor:pointer; border-radius:4px;}
	.tpl-single-image .add-image > i {color:#008000; margin-right:5px;}
</style>
<script type="text/javascript">
	function deleteSingleImage(elm){
		$(elm)
			.prev().val("")
			.parent().hide().css("backgroundImage", "url({$nopic})")
			.next().show();
	}
	function addSingleImage(elm, option){
		require(['uploader'], function(uploader) {
			uploader.init(function(attachment){
				if (attachment) {
					$(elm).hide()
						.prev().css("background-image", "url("+attachment.url+")").show()
						.find("input").val(attachment.attachment);
				}
			}, option);
		});
	}
	function changeSingleImage(elm, option){
		require(['uploader'], function(uploader) {
			uploader.init(function(attachment){
				if (attachment) {
					$(elm)
						.prev().prev().val(attachment.attachment)
						.parent().css("background-image", "url("+attachment.url+")").show();
				}
			}, option);
		});
	}
</script>
EOF;
		define('TPL_INIT_IMAGE', true);
	}
	
	$s .= '
<div class="tpl-single-image clearfix">
	<div class="thumbnail pull-left" style="'.(!empty($attachment) ? 'background-image: url('.tomedia($attachment).');':'display: none;').'">
		<input type="hidden" name="' . $name . '" value="' . $attachment . '">
		<i class="fa fa-times" onclick="deleteSingleImage(this)" title="删除图片" ></i>
		<span class="change-image" onclick=\'changeSingleImage(this, '.$jsoptions.')\' title="更换新图">更换</span>
	</div>
	<div class="text-center pull-left add-image" onclick=\'addSingleImage(this, '.$jsoptions.')\' '.(!empty($attachment) ? 'style="display: none;"':'').'>
		<i class="fa fa-plus-circle"></i><span>加图</span>
	</div>
</div>
';
	return $s;
}


function wl_tpl_form_field_multi_image($name, $attachments = array(), $options = array()) {
	
	load()->model('attachment');
	
	if (empty($options) || !is_array($options)) {
		$options = array();
	}
	$options['direct'] = false;
	$options['multiple'] = true;
	$options['type'] = 'image';
	
	$jsoptions = json_encode($options);
	
	$s = '';
	if (!defined('TPL_INIT_MULTI_IMAGE')) {
		$nopic = IMAGE_NOPIC_SMALL;
		$s .= <<<EOF
<style>
	.tpl-multi-image {margin-top:.5em;}
	.tpl-multi-image .thumbnail{position:relative; width:80px; height:80px; line-height:80px; background:url({$nopic}) center center no-repeat; background-size:contain; margin-right:.5em; cursor:move;}
	.tpl-multi-image .thumbnail i{position:absolute; top: -5px; right: -5px; display:inline-block; width:20px; height:20px; line-height:20px; font-size:14px; text-align:center; z-index:10; cursor:pointer; color:#FFF; background:#888; border-radius:100%;}
	.tpl-multi-image .thumbnail span{display:block; width:100%; position:absolute; bottom:0; left:0; height:25px; line-height:25px; color:#FFF; background:rgba(51,51,51,0.5); text-align:center; border-bottom-left-radius:4px; border-bottom-right-radius:4px; z-index:10; cursor:pointer;}
	.tpl-multi-image .thumbnail i,.thumbnail span.change-image{display:none;}
	.tpl-multi-image .thumbnail:hover i,.thumbnail:hover span.change-image{display:block;}
	.tpl-multi-image .thumbnail i:hover{background:#000;}
	.tpl-multi-image .add-image {position : relative; width: 80px; height: 80px; line-height:80px; border:1px solid #ddd; cursor:pointer; border-radius:4px;}
	.tpl-multi-image .add-image > i {color:#008000; margin-right:5px;}
</style>
<script type="text/javascript">
	function uploadMultiImage(elm, option) {
		var name = $(elm).data("name");
		require(['uploader'], function(uploader) {
			uploader.init(function(attachments){
				$.each(attachments, function(index, attachment){
					var append =
						'<div class="thumbnail pull-left" style="background-image: url(' + attachment.url +');">'+
						'	<input type="hidden" name="'+name+'[]" value="' + attachment.attachment + '">'+
						'	<i class="fa fa-times" onclick="deleteMultiImage(this)" title="删除图片" ></i>'+
						'	<span class="change-image" onclick=\'changeMultiImage(this, {$jsoptions})\' title="更换新图">更换</span>'+
						'</div>';
					$(elm).before(append);
					
					sortimg();
				});
			}, option);
		});
	}
	function changeMultiImage(elm, option) {
		require(['uploader'], function(uploader) {
			uploader.init(function(attachment){
console.log(attachment);
				if(attachment){
					$(elm).prev().prev().val(attachment.attachment).parent().css("background-image", "url("+ util.tomedia(attachment.attachment)+")").show();
				}
			}, $.extend({}, option, {multiple:false,type:"image",direct:true}));
		});
	}
	function deleteMultiImage(elm){
		$(elm).parent().remove();
	}
	function sortimg() {
		require(["jquery.ui"], function($){
			$( ".tpl-multi-image" ).sortable({
				axis: "x",
				revert: false,
				cancel: ".add-image",
				scroll: true,
				delay : 0,
			});
		});
	}
	sortimg();
</script>
EOF;
		
		define('TPL_INIT_MULTI_IMAGE', true);
	}

	$s .= 
'<div class="input-group tpl-multi-image">';
	if (is_array($attachments) && count($attachments)>0) {
		foreach ($attachments as $attachment) {
			$url = tomedia($attachment);
			$s.=<<<EOF
	<div class="thumbnail pull-left" style="background-image: url({$url});">
		<input type="hidden" name="{$name}[]" value="{$attachment}">
		<i class="fa fa-times" onclick="deleteMultiImage(this)" title="删除图片" ></i>
		<span class="change-image" onclick='changeMultiImage(this, {$jsoptions})' title="更换新图">更换</span>
	</div>
EOF;
		}
	}
	$s .= <<<EOF
	<div class="text-center pull-left add-image" onclick='uploadMultiImage(this, $jsoptions)' data-name="$name">
		<i class="fa fa-plus-circle"></i><span>加图</span>
	</div>
</div>
EOF;

	return $s;
}
function wl_tpl_form_field_category_2level($name, $parents, $children, $parentid, $childid){
	$html = '
<script type="text/javascript">
	window._'.$name.' = '.json_encode($children).';
</script>';
	if (!defined('TPL_INIT_CATEGORY')) {
		$html .= '
<script type="text/javascript">
	function renderCategory(obj, name){
		var index = obj.options[obj.selectedIndex].value;
		$selectChild = $(\'#\'+name+\'_child\');
		var html = \'<option value="0">请选择二级分类</option>\';
		if (!window[\'_\'+name] || !window[\'_\'+name][index]) {
			$selectChild.html(html);
			return false;
		}
		for(var i=0; i< window[\'_\'+name][index].length; i++){
			html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';
		}
		$selectChild.html(html);
	}
</script>
';
		define('TPL_INIT_CATEGORY', true);
	}
	
	$html .= 
'<div class="row row-fix tpl-category-container">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<select class="form-control tpl-category-parent" id="'.$name.'_parent" name="'.$name.'[parentid]" onchange="renderCategory(this,\''.$name.'\')">
			<option value="0">请选择一级分类</option>';
	$ops = '';
	if (!empty($parents)) {
		foreach ($parents as $row) {
			$html .= '
				<option value="'.$row['id'].'" '.(($row['id'] == $parentid) ? 'selected="selected"' : '').'>'.$row['name'].'</option>';
		}
	}
	
	$html .='
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<select class="form-control tpl-category-child" id="'.$name.'_child" name="'.$name.'[childid]">
			<option value="0">请选择二级分类</option>';
			if (!empty($parentid) && !empty($children[$parentid])){
				foreach ($children[$parentid] as $row) {
					$html .= '
			<option value="'.$row['id'].'"'.(($row['id'] == $childid)? 'selected="selected"':'').'>'.$row['name'].'</option>';
				}
			}
	$html .='
		</select>
	</div>
</div>
';
	return $html;
}
