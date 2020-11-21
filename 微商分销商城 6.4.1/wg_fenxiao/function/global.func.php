<?php

/*
 * 公用方法，已自动加载
 */
function form_field_multi_image($name, $value = array(), $options = array()) {
    global $_W;
    $options['multiple'] = true;
    $options['direct'] = false;
    $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
    if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
        if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
            exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
        }
    }
    $brief = intval($options['brief']);
    $s = '';
    if (!defined('TPL_INIT_MULTI_IMAGE')) {
        $s = '
<style>
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
.multi-img-details .multi-item em {
    position: absolute;
    top: 0;
    right: -14px;
}
.multi-img-details .multi-item {
    max-width: 100%;
    max-height: 150px;
    height: auto;
    margin-top: 15px;
}
.input-pic-desc {
    display: inline-block;
    padding: 6px 12px;
    margin-left: 10px;
    height: 64px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    white-space: nowrap;
    vertical-align: middle;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
<script type="text/javascript">
	function uploadMultiImage(elm, brief) {
		var name = $(elm).next().val();
		util.image( "", function(urls){
			$.each(urls, function(idx, url){
                if(brief) {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><textarea name="\'+name+\'_brief[]" value="" class="input-pic-desc" placeholder="图片介绍"></textarea><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                } else {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                }
				});
		}, ' . json_encode($options) . ');
	}
	function deleteMultiImage(elm){
		$(elm).parent().remove();
	}
</script>';
        define('TPL_INIT_MULTI_IMAGE', true);
    }

    $s .= <<<EOF
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="uploadMultiImage(this,{$brief});">选择图片</button>
		<input type="hidden" value="{$name}" />
	</span>
</div>
<div class="input-group multi-img-details">
EOF;
    if (is_array($value) && count($value) > 0) {
        foreach ($value as $row) {
            $s .= '
<div class="multi-item">
	<img src="' . $row['url'] . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="' . $name . '[]" value="' . $row['url'] . '" >';
            if($options['brief']) {
                $s .= '<textarea name="' . $name . '_brief[]" class="input-pic-desc" placeholder="图片介绍">' . $row['brief'] . '</textarea>';
            }
            $s.='<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
        }
    }
    $s .= '</div>';

    return $s;
}


function form_field_image($name, $value = '', $default = '', $options = array()) {
    global $_W;
    if (empty($default)) {
        $default = './resource/images/nopic.jpg';
    }
    $val = $default;
    if (!empty($value)) {
        $val = $value;
    }
    if (!empty($options['global'])) {
        $options['global'] = true;
    } else {
        $options['global'] = false;
    }
    if (empty($options['class_extra'])) {
        $options['class_extra'] = '';
    }
    if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
        if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
            exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
        }
    }
    $options['direct'] = true;
    $options['multiple'] = false;
    if (isset($options['thumb'])) {
        $options['thumb'] = !empty($options['thumb']);
    }
    $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
    $s = '';
    if (!defined('TPL_INIT_IMAGE')) {
        $s = '
		<script type="text/javascript">
			function showImageDialog(elm, opts, options) {
				require(["util"], function(util){
					var btn = $(elm);
					var ipt = btn.parent().prev();
					var val = ipt.val();
					var img = ipt.parent().next().children();
					options = '.str_replace('"', '\'', json_encode($options)).';
					util.image(val, function(url){
						if(url.url){
							if(img.length > 0){
								img.get(0).src = url.url;
							}
							ipt.val(url.url);
							ipt.attr("filename",url.filename);
							ipt.attr("url",url.url);
						}
						if(url.media_id){
							if(img.length > 0){
								img.get(0).src = "";
							}
							ipt.val(url.media_id);
						}
					}, options);
				});
			}
			function deleteImage(elm){
				$(elm).prev().attr("src", "./resource/images/nopic.jpg");
				$(elm).parent().prev().find("input").val("");
			}
		</script>';
        define('TPL_INIT_IMAGE', true);
    }

    $s .= '
		<div class="input-group ' . $options['class_extra'] . '">
			<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
			</span>
		</div>
		<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
			<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
			<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
		</div>';
    return $s;
}

function formatArrImage($im) {
    global $_W;
    if(substr($im,0,1) == '/'){
        return $im;
    } elseif(strpos($im,'http') === false && $im) {
        return $_W['attachurl'] . $im;
    } else {
        return $im;
    }
}
