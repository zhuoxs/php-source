<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"/www/wwwroot/testxt.com/application/admin/view/vod/info.html";i:1551055660;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/head.html";i:1522628860;s:65:"/www/wwwroot/testxt.com/application/admin/view/public/editor.html";i:1544100010;s:63:"/www/wwwroot/testxt.com/application/admin/view/public/foot.html";i:1526021730;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?> - 苹果CMS</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin_style.css">
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <script type="text/javascript" src="/static/layui/layui.js"></script>
    <script>
        var ROOT_PATH="",ADMIN_PATH="<?php echo $_SERVER['SCRIPT_NAME']; ?>", MAC_VERSION='v10';
    </script>
</head>
<body>
<script type="text/javascript" src="/static/js/jquery.jscolor.js"></script>
<?php 
$editor=$GLOBALS['config']['app']['editor'];
$ue_old= ROOT_PATH . 'static/ueditor/' ;
$ue_new= ROOT_PATH . 'static/editor/'. $editor ;
if( (!file_exists($ue_new) && file_exists($ue_old)) || $editor=='' ){
    $editor = 'ueditor';
}
 if($editor == 'ueditor'): ?>
<script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.serverUrl = "<?php echo url('upload/upload'); ?>?from=ueditor&flag=vod_editor&input=upfile";
    var EDITOR = UE;
</script>
<?php elseif($editor == 'umeditor'): ?>
<link rel="stylesheet" href="/static/editor/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/static/editor/umeditor/umeditor.config.js"></script>
<script type="text/javascript" src="/static/editor/umeditor/umeditor.min.js"></script>
<script type="text/javascript">
    window.UMEDITOR_CONFIG.imageUrl = "<?php echo url('upload/upload'); ?>?from=umeditor&flag=vod_editor&input=upfile";
    var EDITOR = UM;
</script>
<?php elseif($editor == 'kindeditor'): ?>
<script type="text/javascript" src="/static/editor/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript">
    var EDITOR = KindEditor;
</script>
<?php elseif($editor == 'ckeditor'): ?>
<script type="text/javascript" src="/static/editor/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var EDITOR = CKEDITOR;
</script>
<?php endif; ?>
<script>
    var editor = "<?php echo $editor; ?>";
    function editor_getEditor(obj)
    {
        var res;
        switch(editor){
            case "kindeditor":
                res = KindEditor.create('#'+obj, { uploadJson:"<?php echo url('upload/upload'); ?>?from=kindeditor&flag=vod_editor&input=imgFile" , allowFileManager : false });
                break;
            case "ckeditor":
                res = CKEDITOR.replace(obj,{filebrowserImageUploadUrl:"<?php echo url('upload/upload'); ?>?from=ckeditor&flag=vod_editor&input=upload"});
                break;
            default:
                res = EDITOR.getEditor(obj);
                break;
        }
        return res;
    }
    function editor_setContent(obj,html) {
        var res;
        switch(editor){
            case "kindeditor":
                res = obj.html(html);
                break;
            case "ckeditor":
                res = obj.setData(html);
                break;
            default:
                res = obj.setContent(html);
                break;
        }
        return res;
    }
    function editor_getContent(obj) {
        var res;
        switch(editor){
            case "kindeditor":
                res = obj.html();
                break;
            case "ckeditor":
                res = obj.getData();
                break;
            default:
                res = obj.getContent();
                break;
        }
        return res;
    }
</script>
<div class="page-container p10">
    <div class="showpic" style="display:none;"><img class="showpic_img" width="120" height="160"></div>
    
    <form class="layui-form layui-form-pane" method="post" action="">
        <input type="hidden" name="vod_id" value="<?php echo $info['vod_id']; ?>">

        <div class="layui-tab">
            <ul class="layui-tab-title ">
                <li class="layui-this">基本信息</a></li>
                <li>其他信息</li>
                <?php if(!(empty($info['vod_id']) || (($info['vod_id'] instanceof \think\Collection || $info['vod_id'] instanceof \think\Paginator ) && $info['vod_id']->isEmpty()))): ?>
                <li>角色信息</li>
                <?php endif; ?>
            </ul>
            <div class="layui-tab-content">

                <div class="layui-tab-item layui-show">
                    
                <div class="layui-form-item">
                    <label class="layui-form-label">参数：</label>
                    <div class="layui-input-inline w150">
                            <select name="type_id" lay-filter="type_id">
                                <option value="">请选择分类</option>
                                <?php if(is_array($type_tree) || $type_tree instanceof \think\Collection || $type_tree instanceof \think\Paginator): $i = 0; $__LIST__ = $type_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['type_mid'] == 1): ?>
                                    <option value="<?php echo $vo['type_id']; ?>" <?php if($info['type_id'] == $vo['type_id']): ?>selected<?php endif; ?>><?php echo $vo['type_name']; ?></option>
                                    <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $ch['type_id']; ?>" <?php if($info['type_id'] == $ch['type_id']): ?>selected<?php endif; ?>>&nbsp;|&nbsp;&nbsp;&nbsp;|—<?php echo $ch['type_name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                    </div>

                    <div class="layui-input-inline w150">
                            <select name="vod_level">
                                <option value="0">请选择推荐</option>
                                <option value="9" <?php if($info['vod_level'] == 9): ?>selected<?php endif; ?>>推荐9-幻灯</option>
                                <option value="1" <?php if($info['vod_level'] == 1): ?>selected<?php endif; ?>>推荐1</option>
                                <option value="2" <?php if($info['vod_level'] == 2): ?>selected<?php endif; ?>>推荐2</option>
                                <option value="3" <?php if($info['vod_level'] == 3): ?>selected<?php endif; ?>>推荐3</option>
                                <option value="4" <?php if($info['vod_level'] == 4): ?>selected<?php endif; ?>>推荐4</option>
                                <option value="5" <?php if($info['vod_level'] == 5): ?>selected<?php endif; ?>>推荐5</option>
                                <option value="6" <?php if($info['vod_level'] == 6): ?>selected<?php endif; ?>>推荐6</option>
                                <option value="7" <?php if($info['vod_level'] == 7): ?>selected<?php endif; ?>>推荐7</option>
                                <option value="8" <?php if($info['vod_level'] == 8): ?>selected<?php endif; ?>>推荐8</option>
                            </select>
                    </div>
                    <div class="layui-input-inline w120">
                            <select name="vod_status">
                                <option value="1" >已审核</option>
                                <option value="0" <?php if($info['vod_status'] == '0'): ?>selected<?php endif; ?>>未审核</option>
                            </select>
                    </div>
                    <div class="layui-input-inline w120">
                        <select name="vod_lock">
                            <option value="0">未锁</option>
                            <option value="1" <?php if($info['vod_lock'] == 1): ?>selected<?php endif; ?>>锁定</option>
                        </select>
                    </div>
                    <div class="layui-input-inline w120">
                        <select name="vod_isend">
                            <option value="1" <?php if($info['vod_isend'] == 1): ?>selected<?php endif; ?>>已完结</option>
                            <option value="0" <?php if($info['vod_isend'] == 0): ?>selected<?php endif; ?>>未完结</option>
                        </select>
                    </div>
                    <div class="layui-input-inline w120">
                        <select name="vod_copyright">
                            <option value="0" <?php if($info['vod_copyright'] == '0'): ?>selected<?php endif; ?>>关闭版权处理</option>
                            <option value="1" <?php if($info['vod_copyright'] == '1'): ?>selected<?php endif; ?>>开启版权处理</option>
                        </select>
                    </div>
                    <div class="layui-input-inline w110">
                        <input type="checkbox" name="uptime" title="更新时间" value="1" checked class="layui-checkbox checkbox-ids" lay-skin="primary">
                    </div>
                </div>

                <div class="layui-form-item ">
                    <label class="layui-form-label">标题：</label>
                    <div class="layui-input-inline w500">
                        <input type="text" class="layui-input" value="<?php echo $info['vod_name']; ?>" placeholder="请输入" name="vod_name" id="vod_name">
                    </div>
                    <label class="layui-form-label">副标：</label>
                    <div class="layui-input-inline ">
                        <input type="text" class="layui-input" value="<?php echo $info['vod_sub']; ?>" placeholder="" name="vod_sub" id="vod_sub">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">别名：</label>
                    <div class="layui-input-inline w500">
                        <input type="text" class="layui-input" value="<?php echo $info['vod_en']; ?>" placeholder="" name="vod_en">
                    </div>
                    <label class="layui-form-label">首字母：</label>
                    <div class="layui-input-inline w70">
                        <input type="text" class="layui-input" value="<?php echo $info['vod_letter']; ?>" placeholder="" name="vod_letter">
                    </div>
                    <label class="layui-form-label">高亮：</label>
                    <div class="layui-input-inline w70">
                        <input type="text" class="layui-input color" value="<?php echo $info['vod_color']; ?>" placeholder="" name="vod_color">
                    </div>
                </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">TAG：</label>
                        <div class="layui-input-inline w500  ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_tag']; ?>" placeholder=""  name="vod_tag" id="vod_tag">
                        </div>
                        <div class="layui-input-inline w120">
                            <input type="checkbox" name="uptag" title="自动生成" value="1" class="layui-checkbox checkbox-ids" lay-skin="primary">
                        </div>


                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">备注：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_remarks']; ?>" placeholder="" name="vod_remarks" id="vod_remarks">
                        </div>
                        <label class="layui-form-label">幕后：</label>
                        <div class="layui-input-inline ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_behind']; ?>" placeholder="" name="vod_behind" id="vod_behind">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">总集数：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_total']; ?>" placeholder="" name="vod_total" id="vod_total">
                        </div>
                        <label class="layui-form-label">连载数：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_serial']; ?>" placeholder="" name="vod_serial" id="vod_serial">
                        </div>
                        <label class="layui-form-label">上映日期：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_pubdate']; ?>" placeholder="" name="vod_pubdate" id="vod_pubdate">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">主演：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_actor']; ?>" placeholder="" name="vod_actor" id="vod_actor">
                        </div>
                        <label class="layui-form-label">导演：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_director']; ?>" placeholder="" name="vod_director" id="vod_director">
                        </div>
                        <label class="layui-form-label">编剧：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_writer']; ?>" placeholder="" name="vod_writer" id="vod_writer">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">电视频道：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_tv']; ?>" placeholder="" name="vod_tv">
                        </div>
                        <label class="layui-form-label">节目周期：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_weekday']; ?>" placeholder="" name="vod_weekday">
                        </div>
                        <label class="layui-form-label">视频时长：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_duration']; ?>" placeholder="" name="vod_duration" id="vod_duration">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">豆瓣评分：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_douban_score']; ?>" placeholder="豆瓣网评分值" name="vod_douban_score" id="vod_douban_score">
                        </div>
                        <label class="layui-form-label">豆瓣ID：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_douban_id']; ?>" placeholder="" name="vod_douban_id" id="vod_douban_id">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn" id="btn_douban">查询数据</button>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">关联视频：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_rel_vod']; ?>" placeholder="如“变形金刚”1、2、3部ID分别为11,12,13或将每部都填“变形金刚”" name="vod_rel_vod">
                        </div>
                        <div class="layui-input-inline ">
                            <a class="layui-btn j-iframe" data-href="<?php echo url('vod/data'); ?>?select=1&input=vod_rel_vod" href="javascript:;" title="查询数据">查询数据</a>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">关联文章：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_rel_art']; ?>" placeholder="如“变形金刚资讯”1、2、3部ID分别为11,12,13或将每部都填“变形金刚资讯”" name="vod_rel_art">
                        </div>
                        <div class="layui-input-inline ">
                            <a class="layui-btn j-iframe" data-href="<?php echo url('art/data'); ?>?select=1&input=vod_rel_art" href="javascript:;" title="查询数据">查询数据</a>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">扩展分类：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_class']; ?>" placeholder="" id="vod_class" name="vod_class">
                        </div>
                        <div class="layui-input-inline w500 vod_class_label">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">上映年代：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_year']; ?>" placeholder="" id="vod_year" name="vod_year">
                        </div>
                        <div class="layui-input-inline w500 vod_year_label">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">发行地区：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_area']; ?>" placeholder="" id="vod_area" name="vod_area">
                        </div>
                        <div class="layui-input-inline w500 vod_area_label">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">对白语言：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_lang']; ?>" placeholder="" id="vod_lang" name="vod_lang">
                        </div>
                        <div class="layui-input-inline w500 vod_lang_label">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">影片版本：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_version']; ?>" placeholder="" id="vod_version" name="vod_version">
                        </div>
                        <div class="layui-input-inline w500 vod_version_label">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">资源类别：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_state']; ?>" placeholder="" id="vod_state" name="vod_state">
                        </div>
                        <div class="layui-input-inline w500 vod_state_label">

                        </div>
                    </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">图片：</label>
                    <div class="layui-input-inline w500 upload">
                        <input type="text" class="layui-input upload-input" style="max-width:100%;" value="<?php echo $info['vod_pic']; ?>" placeholder="" id="vod_pic" name="vod_pic">
                    </div>
                    <div class="layui-input-inline ">
                        <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:1,thumb_class:'upload-thumb'}}" id="upload1">上传图片</button>
                    </div>
                </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">缩略图：</label>
                        <div class="layui-input-inline w500 upload">
                            <input type="text" class="layui-input upload-input upload-thumb" style="max-width:100%;" value="<?php echo $info['vod_pic_thumb']; ?>" placeholder="" id="vod_pic_thumb" name="vod_pic_thumb">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:0,thumb_class:'upload-thumb'}}" id="upload2">上传图片</button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">海报图：</label>
                        <div class="layui-input-inline w500 upload">
                            <input type="text" class="layui-input upload-input" style="max-width:100%;" value="<?php echo $info['vod_pic_slide']; ?>" placeholder="" id="vod_pic_slide" name="vod_pic_slide">
                        </div>
                        <div class="layui-input-inline ">
                            <button type="button" class="layui-btn layui-upload" lay-data="{data:{thumb:0,thumb_class:'upload-thumb'}}" id="upload3">上传图片</button>
                        </div>
                    </div>
                <div class="layui-form-item">
                        <label class="layui-form-label">简介：</label>
                    <div class="layui-input-block">
                        <textarea name="vod_blurb" cols="" rows="3" class="layui-textarea"  placeholder="不填写将自动从第一页详情里获取前100个字" style="height:40px;"><?php echo $info['vod_blurb']; ?></textarea>
                    </div>
                </div>


                    <script>
                        var players_arr_len = <?php echo count($vod_play_list); ?>;
                        var downers_arr_len = <?php echo count($vod_down_list); ?>;
                    </script>

                    <div id="player_list" class="contents">
                        <?php if(is_array($vod_play_list) || $vod_play_list instanceof \think\Collection || $vod_play_list instanceof \think\Paginator): $i = 0; $__LIST__ = $vod_play_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <div class="layui-form-item" data-i="<?php echo $key; ?>">
                        <label class="layui-form-label">播放<?php echo $key; ?>：</label>
                            <div class="layui-input-inline w150"><select name="vod_play_from[]"><option value="no">请选择播放器.</option><?php if(is_array($player_list) || $player_list instanceof \think\Collection || $player_list instanceof \think\Paginator): $i = 0; $__LIST__ = $player_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;if($vo1['status'] == '1'): ?><option value="<?php echo $vo1['from']; ?>" <?php if($vo1['from'] == $vo['from']): ?> selected <?php endif; ?>><?php echo $vo1['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?></select></div>
                            <div class="layui-input-inline w150"><select name="vod_play_server[]"><option value="no">请选择服务器组.</option><?php if(is_array($server_list) || $server_list instanceof \think\Collection || $server_list instanceof \think\Paginator): $i = 0; $__LIST__ = $server_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;if($vo2['status'] == '1'): ?><option value="<?php echo $vo2['from']; ?>" <?php if($vo2['from'] == $vo['server']): ?> selected <?php endif; ?>><?php echo $vo2['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?></select></div>
                            <div class="layui-input-inline w150"><input type="text" name="vod_play_note[]" class="layui-input" value="<?php echo $vo['note']; ?>" placeholder="备注信息"></div>
                            <div class="layui-input-inline w400 p10"><a href="javascript:void(0)" class="j-editor-clear">清空</a>&nbsp;<a href="javascript:void(0)" class="j-editor-remove">删除</a>&nbsp;<a href="javascript:void(0)" class="j-editor-up">上移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-down">下移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-xz">校正</a>&nbsp;<a href="javascript:void(0)" class="j-editor-order">倒序</a>&nbsp;<a href="javascript:void(0)" class="j-editor-dn">去前缀</a>&nbsp;<a href="javascript:void(0)" class="j-editor-upload">上传</a><br></div>
                            <div class="p10 m20"> </div>
                            <div class="layui-input-block "><textarea id="vod_play_url<?php echo $key; ?>" name="vod_play_url[]" type="text/plain" style="width:100%;height:150px"><?php echo mac_str_correct($vo['url'],'#',chr(13)); ?></textarea></div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="layui-form-item">
                        <label class=""><button class="layui-btn radius j-player-add" type="button">添加一组播放</button></label>
                        <div class="layui-input-block">

                        </div>
                    </div>

                    <hr class="layui-bg-gray">


                    <div id="downer_list" class="contents">
                        <?php if(is_array($vod_down_list) || $vod_down_list instanceof \think\Collection || $vod_down_list instanceof \think\Paginator): $i = 0; $__LIST__ = $vod_down_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <div class="layui-form-item" data-i="<?php echo $key; ?>">
                            <label class="layui-form-label">下载<?php echo $key; ?>：</label>
                            <div class="layui-input-inline w150"><select name="vod_down_from[]"><option value="no">请选择下载器.</option><?php if(is_array($downer_list) || $downer_list instanceof \think\Collection || $downer_list instanceof \think\Paginator): $i = 0; $__LIST__ = $downer_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;if($vo1['status'] == '1'): ?><option value="<?php echo $vo1['from']; ?>" <?php if($vo1['from'] == $vo['from']): ?> selected <?php endif; ?>><?php echo $vo1['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?></select></div>
                            <div class="layui-input-inline w150"><select name="vod_down_server[]"><option value="no">请选择服务器组.</option><?php if(is_array($server_list) || $server_list instanceof \think\Collection || $server_list instanceof \think\Paginator): $i = 0; $__LIST__ = $server_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;if($vo2['status'] == '1'): ?><option value="<?php echo $vo2['from']; ?>" <?php if($vo2['from'] == $vo['server']): ?> selected <?php endif; ?>><?php echo $vo2['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?></select></div>
                            <div class="layui-input-inline w150"><input type="text" name="vod_down_note[]" class="layui-input" value="<?php echo $vo['note']; ?>" placeholder="备注信息"></div>
                            <div class="layui-input-inline w400 p10"><a href="javascript:void(0)" class="j-editor-clear">清空</a>&nbsp;<a href="javascript:void(0)" class="j-editor-remove">删除</a>&nbsp;<a href="javascript:void(0)" class="j-editor-up">上移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-down">下移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-xz">校正</a>&nbsp;<a href="javascript:void(0)" class="j-editor-order">倒序</a>&nbsp;<a href="javascript:void(0)" class="j-editor-dn">去前缀</a>&nbsp;<a href="javascript:void(0)" class="j-editor-upload">上传</a><br></div>
                            <div class="p10"> </div>
                            <div class="layui-input-block"><textarea id="vod_down_url<?php echo $key; ?>" name="vod_down_url[]" type="text/plain" style="width:100%;height:150px"><?php echo mac_str_correct($vo['url'],'#',chr(13)); ?></textarea></div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="layui-form-item">
                        <label class=""><button class="layui-btn radius j-downer-add" type="button">添加一组下载</button></label>
                        <div class="layui-input-block">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">详细介绍：</label>
                        <div class="layui-input-block">
                            <textarea id="vod_content" name="vod_content" type="text/plain" style="width:99%;height:250px"><?php echo mac_url_content_img($info['vod_content']); ?></textarea>
                        </div>
                    </div>
        </div>

                <div class="layui-tab-item">
                        <div class="layui-form-item">
                            <label class="layui-form-label">顶数量：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_up']; ?>" placeholder="" id="vod_up" name="vod_up">
                            </div>
                            <label class="layui-form-label">踩数量：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_down']; ?>" placeholder="" id="vod_down" name="vod_down">
                            </div>
                            <button class="layui-btn" type="button" id="btn_rnd">随机生成</button>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">总人气：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_hits']; ?>" placeholder="" id="vod_hits" name="vod_hits">
                            </div>
                            <label class="layui-form-label">月人气：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_hits_month']; ?>" placeholder="" id="vod_hits_month" name="vod_hits_month" >
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">周人气：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_hits_week']; ?>" placeholder="" id="vod_hits_week" name="vod_hits_week">
                            </div>
                            <label class="layui-form-label">日人气：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input " value="<?php echo $info['vod_hits_day']; ?>" placeholder="" id="vod_hits_day" name="vod_hits_day">
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">平均分：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_score']; ?>" placeholder="" id="vod_score" name="vod_score">
                            </div>
                            <label class="layui-form-label">总评分：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_score_all']; ?>" placeholder="" id="vod_score_all" name="vod_score_all">
                            </div>
                            <label class="layui-form-label">总评次：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_score_num']; ?>" placeholder="" id="vod_score_num" name="vod_score_num">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">整数据积分：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_points']; ?>" placeholder="" name="vod_points">
                            </div>
                            <label class="layui-form-label">点播积分：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_points_play']; ?>" placeholder="" name="vod_points_play">
                            </div>
                            <label class="layui-form-label">下载积分：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_points_down']; ?>" placeholder="" name="vod_points_down">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">编辑人：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_author']; ?>" placeholder="" name="vod_author" id="vod_author">
                            </div>
                            <label class="layui-form-label">独立模板：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_tpl']; ?>" placeholder="" name="vod_tpl">
                            </div>
                            <label class="layui-form-label">跳转URL：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_jumpurl']; ?>" placeholder="" name="vod_jumpurl" id="vod_jumpurl">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">内容页密码：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_pwd']; ?>" placeholder="非静态模式下可用" name="vod_pwd">
                            </div>
                            <label class="layui-form-label">密码链接：</label>
                            <div class="layui-input-inline ">
                                <input type="text" class="layui-input" value="<?php echo $info['vod_pwd_url']; ?>" placeholder="" name="vod_pwd_url">
                            </div>
                        </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">播放页密码：</label>
                        <div class="layui-input-inline ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_pwd_play']; ?>" placeholder="" name="vod_pwd_play">
                        </div>
                        <label class="layui-form-label">密码链接：</label>
                        <div class="layui-input-inline ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_pwd_play_url']; ?>" placeholder="" name="vod_pwd_play_url">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">下载页密码：</label>
                        <div class="layui-input-inline ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_pwd_down']; ?>" placeholder="" name="vod_pwd_down">
                        </div>
                        <label class="layui-form-label">密码链接：</label>
                        <div class="layui-input-inline ">
                            <input type="text" class="layui-input" value="<?php echo $info['vod_pwd_down_url']; ?>" placeholder="" name="vod_pwd_down_url">
                        </div>
                    </div>

                    </div>

                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label class="layui-form-label">采集网址：</label>
                        <div class="layui-input-inline w500">
                            <input type="text" class="layui-input" value="" placeholder="" id="role_cj" name="role_cj">
                        </div>
                        <button class="layui-btn" type="button" id="btn_role_cj">点击采集</button>
                    </div>

                    <?php if(!(empty($info['vod_id']) || (($info['vod_id'] instanceof \think\Collection || $info['vod_id'] instanceof \think\Paginator ) && $info['vod_id']->isEmpty()))): ?>
                    <iframe src="<?php echo url('role/data'); ?>?select=1&tab=vod&rid=<?php echo $info['vod_id']; ?>" marginwidth="0" marginheight="0" style="width:100%;height:600px;"></iframe>
                    <?php endif; ?>
                </div>
            </div>
        </div>

                <div class="layui-form-item center">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit" data-child="">保 存</button>
                        <button class="layui-btn layui-btn-warm" type="reset">还 原</button>
                    </div>
                </div>
    </form>

</div>
<script type="text/javascript" src="/static/js/admin_common.js"></script>

<script type="text/javascript">
    ue = editor_getEditor('vod_content');
    var player_select='<?php if(is_array($player_list) || $player_list instanceof \think\Collection || $player_list instanceof \think\Paginator): $i = 0; $__LIST__ = $player_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['status'] == '1'): ?><option value="<?php echo $vo['from']; ?>"><?php echo $vo['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>';
    var downer_select='<?php if(is_array($downer_list) || $downer_list instanceof \think\Collection || $downer_list instanceof \think\Paginator): $i = 0; $__LIST__ = $downer_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['status'] == '1'): ?><option value="<?php echo $vo['from']; ?>"><?php echo $vo['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>';
    var server_select='<?php if(is_array($server_list) || $server_list instanceof \think\Collection || $server_list instanceof \think\Paginator): $i = 0; $__LIST__ = $server_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['status'] == '1'): ?><option value="<?php echo $vo['from']; ?>"><?php echo $vo['show']; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>';

    layui.use(['form','upload', 'layer'], function () {
        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery
                , upload = layui.upload;;

        // 验证
        form.verify({
            vod_name: function (value) {
                if (value == "") {
                    return "请输入专题名称";
                }
            }
        });

        $(document).on("click", ".extend", function(){
            $id = $(this).attr('data-id');
            if($id == 'vod_class' || $id == 'vod_keywords'){
                $val = $("input[id='"+$id+"']").val();
                if($val!=''){
                    $val = $val+',';
                }
                if($val.indexOf($(this).text())>-1){
                    return;
                }
                $("input[id='"+$id+"']").val($val+$(this).text());
            }else{
                $("input[id='"+$id+"']").val($(this).text());
            }
        });


        form.on('select(type_id)', function(data){
            getExtend(data.value);
        });


        upload.render({
            elem: '.layui-upload'
            ,url: "<?php echo url('upload/upload'); ?>?flag=vod"
            ,method: 'post'
            ,before: function(input) {
                layer.msg('文件上传中...', {time:3000000});
            },done: function(res, index, upload) {
                var obj = this.item;
                if (res.code == 0) {
                    layer.msg(res.msg);
                    return false;
                }
                layer.closeAll();
                var input = $(obj).parent().parent().find('.upload-input');
                if ($(obj).attr('lay-type') == 'image') {
                    input.siblings('img').attr('src', res.data.file).show();
                }
                input.val(res.data.file);

                if(res.data.thumb_class !=''){
                    $('.'+ res.data.thumb_class).val(res.data.thumb[0].file);
                }
            }
        });
        upload.render({
            elem: '.j-editor-upload'
            , url: "<?php echo url('upload/upload'); ?>?flag=vod_file"
            , method: 'post'
            , exts: 'mp4|mp3|mkv|torrent|zip|txt|rar'
            , before: function (input) {
                layer.msg('文件上传中...', {time: 3000000});
            }, done: function (res, index, upload) {
                var obj = this.item;
                if (res.code == 0) {
                    layer.msg(res.msg);
                    return false;
                }
                layer.closeAll();
                var txt = $(obj).parent().parent().find('textarea').val();
                if (txt != '') {
                    txt += "\r\n";
                }
                $(obj).parent().parent().find('textarea').val(txt + res.data.file);
            }
        });

        function initUpload(flag) {

            layui.each($('#'+ flag +'er_list').find('.j-editor-upload').last(), function(index, elem){
                upload.render({
                    elem: elem
                    , url: "<?php echo url('upload/upload'); ?>?flag=vod_file"
                    , method: 'post'
                    , exts: 'mp4|mp3|mkv|torrent|zip|txt|rar'
                    , before: function (input) {
                        layer.msg('文件上传中...', {time: 3000000});
                    }, done: function (res, index, upload) {
                        var obj = this.item;
                        if (res.code == 0) {
                            layer.msg(res.msg);
                            return false;
                        }
                        layer.closeAll();
                        var txt = $(obj).parent().parent().find('textarea').val();
                        if (txt != '') {
                            txt += "\r\n";
                        }
                        $(obj).parent().parent().find('textarea').val(txt + res.data.file);
                    }
                });
            });


        }



        $('.upload-input').hover(function (e){
            var e = window.event || e;
            var imgsrc = $(this).val();
            if(imgsrc.trim()==""){ return; }
            var left = e.clientX+document.body.scrollLeft+20;
            var top = e.clientY+document.body.scrollTop+20;
            $(".showpic").css({left:left,top:top,display:""});
            if(imgsrc.indexOf('://')<0){ imgsrc = ROOT_PATH  + '/' + imgsrc;	} else{ imgsrc = imgsrc.replace('mac:','http:'); }
            $(".showpic_img").attr("src", imgsrc);
        },function (e){
            $(".showpic").css("display","none");
        });


        $("#btn_rnd").click(function(){
            $("#vod_hits").val( rndNum(5000,9999) );
            $("#vod_hits_month").val( rndNum(1000,4999) );
            $("#vod_hits_week").val( rndNum(300,999) );
            $("#vod_hits_day").val( rndNum(1,299) );
            $("#vod_up").val( rndNum(1,999) );
            $("#vod_down").val( rndNum(1,999) );
            $("#vod_score").val( rndNum(10) );
            $("#vod_score_all").val( rndNum(1000) );
            $("#vod_score_num").val( rndNum(100) );
        });

        var is_load=0;
        $('#btn_douban').click(function(){
            var id = $('#vod_douban_id').val();
            var that=$(this);

            if(id == '' || id < 10000){
                alert('请先填写该影片对应的豆瓣的ID');
                return;
            }
            if(is_load==1){
                return;
            }
            is_load=1;
            that.text('读取中...');
            $.ajax({
                type: 'post',
                dataType: "jsonp",
                jsonp: "callback",
                jsonpCallback:"douban",
                timeout: 5000,
                url: '//api.maccms.com/douban/?callback=douban&id=' + id,
                error: function(){
                    alert('请求解析服务器失败');
                },
                complete:function(){
                    is_load=0;
                    that.text('查询数据');
                },
                success:function(r){
                    if(r.code>1){
                        alert(r.msg);
                    }
                    else{
                        if(r.data.vod_total){
                            $('#vod_total').val(r.data.vod_total);
                        }
                        if(r.data.vod_serial){
                            $('#vod_continu').val(r.data.vod_serial);
                        }
                        if(r.data.vod_isend){
                            $('#vod_isend').val(r.data.vod_isend);
                        }
                        if(r.data.vod_name){
                            $('#vod_name').val(r.data.vod_name);
                        }
                        if(r.data.vod_sub){
                            $('#vod_sub').val(r.data.vod_sub);
                        }
                        if(r.data.vod_pic){
                            $('#vod_pic').val(r.data.vod_pic);
                        }
                        if(r.data.vod_year){
                            $('#vod_year').val(r.data.vod_year);
                        }
                        if(r.data.vod_lang){
                            $('#vod_lang').val(r.data.vod_lang);
                        }
                        if(r.data.vod_area){
                            $('#vod_area').val(r.data.vod_area);
                        }
                        if(r.data.vod_state){
                            $('#vod_state').val(r.data.vod_state);
                        }
                        if(r.data.vod_class){
                            $('#vod_type').val(r.data.vod_class);
                        }
                        if(r.data.vod_tag){
                            $('#vod_tag').val(r.data.vod_tag);
                        }
                        if(r.data.vod_actor){
                            $('#vod_actor').val(r.data.vod_actor);
                        }
                        if(r.data.vod_director){
                            $('#vod_director').val(r.data.vod_director);
                        }
                        if(r.data.vod_pubdate){
                            $('#vod_pubdate').val(r.data.vod_pubdate);
                        }
                        if(r.data.vod_writer){
                            $('#vod_writer').val(r.data.vod_writer);
                        }
                        if(r.data.vod_score){
                            $('#vod_score').val(r.data.vod_score);
                        }
                        if(r.data.vod_score_num){
                            $('#vod_score_num').val(r.data.vod_score_num);
                        }
                        if(r.data.vod_score_all){
                            $('#vod_score_all').val(r.data.vod_score_all);
                        }
                        if(r.data.vod_douban_score){
                            $('#vod_douban_score').val(r.data.vod_douban_score);
                        }
                        if(r.data.vod_duration){
                            $('#vod_duration').val(r.data.vod_duration);
                        }
                        if(r.data.vod_content){
                            ue.setContent(r.data.vod_content);
                        }
                        if(r.data.vod_class){
                            $('#vod_class').val(r.data.vod_class);
                        }
                        if(r.data.vod_reurl) {
                            $('#vod_reurl').val(r.data.vod_reurl);
                        }
                        if(r.data.vod_author) {
                            $('#vod_author').val(r.data.vod_author);
                        }
                    }
                }
            });
        });


        $('.contents').on('click','.j-editor-clear',function(){
            $(this).parent().parent().find('textarea').val('');
        });
        $('.contents').on('click','.j-editor-remove',function(){
            var datai = $(this).parent().parent().attr('data-i');
            $(this).parent().parent().remove();
        });
        $('.contents').on('click','.j-editor-up',function(){
            var current = $(this).parent().parent();
            var current_index = current.index();
            var current_i = current.attr('data-i');
            var prev = current.prev();
            var prev_i = prev.attr('data-i');
            if(current_index>0){
                current.insertBefore(prev);
            }
        });
        $('.contents').on('click','.j-editor-down',function(){
            var current = $(this).parent().parent();
            var current_index = current.index();
            var current_i = current.attr('data-i');
            var next = current.next();
            var next_i = next.attr('data-i');

            if(next.length>0){
                current.insertAfter(next);
            }
        });

        $('.contents').on('click','.j-editor-xz',function(){
            var arr1,s1,s2,urlarr,urlarrcount;
            s1 = $(this).parent().parent().find('textarea').val(); s2="";
            if (s1.length==0){return false;}
            s1 = s1.replaceAll("\r","");
            arr1 = s1.split("\n");
            arr1len = arr1.length;
            for(j=0;j<arr1len;j++){
                if(arr1[j].length>0){
                    urlarr = arr1[j].split('$'); urlarrcount = urlarr.length-1;
                    if(urlarrcount==0){
                        arr1[j]= getPatName(j,arr1len,arr1[j]) + '$' + arr1[j];
                    }
                    s2+=arr1[j]+"\r\n";
                }
            }
            $(this).parent().parent().find('textarea').val(s2.trim()) ;
        });
        $('.contents').on('click','.j-editor-order',function(){
            var arr1,s1,s2,urlarr,urlarrcount;
            s1 = $(this).parent().parent().find('textarea').val(); s2="";
            if (s1.length==0){return false;}
            s1 = s1.replaceAll("\r","");
            arr1=s1.split("\n");
            for(j=arr1.length-1;j>=0;j--){
                if(arr1[j].length>0){
                    s2+=arr1[j]+"\r\n";
                }
            }
            $(this).parent().parent().find('textarea').val(s2.trim()) ;
        });
        $('.contents').on('click','.j-editor-dn',function(){
            var arr1,s1,s2,urlarr,urlarrcount;
            s1 = $(this).parent().parent().find('textarea').val(); s2="";
            if (s1.length==0){return false;}
            s1 = s1.replaceAll("\r","");
            arr1=s1.split("\n");
            for(j=0;j<arr1.length;j++){
                if(arr1[j].length>0){
                    urlarr = arr1[j].split('$'); urlarrcount = urlarr.length-1;
                    if(urlarrcount==0){
                        arr1[j] = arr1[j];
                    }
                    else{
                        arr1[j] = urlarr[1];
                    }
                    s2+=arr1[j]+"\r\n";
                }
            }
            $(this).parent().parent().find('textarea').val(s2.trim()) ;
        });

        $('.j-player-add').on('click',function(){
            players_arr_len++;
            var tpl='<div class="layui-form-item" data-i="'+players_arr_len+'"><label class="layui-form-label">播放'+(players_arr_len)+'：</label><div class="layui-input-inline w150"><select name="vod_play_from[]"><option value="no">请选择播放器.</option>'+player_select+'</select></div><div class="layui-input-inline w150"><select name="vod_play_server[]" ><option value="no">请选择服务器组.</option>'+server_select+'</select></div><div class="layui-input-inline w150"><input type="text" name="vod_play_note[]" class="layui-input" placeholder="备注信息" ></div><div class="layui-input-inline w400 p10"><a href="javascript:void(0)" class="j-editor-clear">清空</a>&nbsp;<a href="javascript:void(0)" class="j-editor-remove">删除</a>&nbsp;<a href="javascript:void(0)" class="j-editor-up">上移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-down">下移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-xz">校正</a>&nbsp;<a href="javascript:void(0)" class="j-editor-order">倒序</a>&nbsp;<a href="javascript:void(0)" class="j-editor-dn">去前缀</a>&nbsp;<a href="javascript:void(0)" class="j-editor-upload">上传</a></div><div class="p10 m20"></div><div class="layui-input-block"><textarea id="vod_content'+(players_arr_len)+'" name="vod_play_url[]" class="layui-textarea " style="width:99%;height:250px"></textarea></div></div>';
            $("#player_list").append(tpl);

            form.render('select');
            initUpload('play');
        });
        $('.j-downer-add').on('click',function(){
            downers_arr_len++;
            var tpl='<div class="layui-form-item" data-i="'+downers_arr_len+'"><label class="layui-form-label">下载'+(downers_arr_len)+'：</label><div class="layui-input-inline w150"><select name="vod_down_from[]"><option value="no">请选择下载器.</option>'+downer_select+'</select></div><div class="layui-input-inline w150"><select name="vod_down_server[]" ><option value="no">请选择服务器组.</option>'+server_select+'</select></div><div class="layui-input-inline w150"><input type="text" name="vod_down_note[]" class="layui-input" placeholder="备注信息"></div><div class="layui-input-inline w400 p10"><a href="javascript:void(0)" class="j-editor-clear">清空</a>&nbsp;<a href="javascript:void(0)" class="j-editor-remove">删除</a>&nbsp;<a href="javascript:void(0)" class="j-editor-up">上移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-down">下移</a>&nbsp;<a href="javascript:void(0)" class="j-editor-xz">校正</a>&nbsp;<a href="javascript:void(0)" class="j-editor-order">倒序</a>&nbsp;<a href="javascript:void(0)" class="j-editor-dn">去前缀</a>&nbsp;<a href="javascript:void(0)" class="j-editor-upload">上传</a></div><div class="p10 m20"></div><div class="layui-input-block"><textarea id="vod_content'+(downers_arr_len)+'" name="vod_down_url[]" class="layui-textarea" style="width:99%;height:250px"></textarea></div></div>';
            $("#downer_list").append(tpl);

            form.render('select');
            initUpload('down');
        });

        if(players_arr_len==0 && downers_arr_len==0) {
            $('.j-player-add').click();
        }
    });

    function getExtend(id){
        $.post("<?php echo url('type/extend'); ?>", {id:id}, function(res) {

            if (res.code == 1) {
                $.each(res.data, function(key, value){
                    $('.vod_'+key+"_label").html('');
                    if(value != ''){
                        $.each(value, function(key2, value2){
                            $(".vod_"+key+"_label").append('<a class="layui-btn layui-btn-xs extend" href="javascript:;" data-id="vod_'+key+'">'+value2+'</a>');
                        });
                    }
                });
            }
        });
    }

    function FindNote(s){
        var res="";
        if (s.indexOf("DVD")>0){
            res="DVD";
        }
        else if (s.indexOf("TS")>0 || s.indexOf("TC")>0 || s.indexOf("抢先版")>0) {
            res="抢先版";
        }
        else if (s.indexOf("HD")>0){
            res="HD";
        }
        else if (s.indexOf("BD")>0){
            res="BD";
        }
        else if (s.indexOf("蓝光高清")>0){
            res="蓝光高清";
        }
        else if (s.indexOf("高清")>0){
            res="高清";
        }
        else if (s.indexOf("VCD")>0){
            res="VCD";
        }

        if (s.indexOf("国粤语")>0){
            res +="国粤语";
        }
        else if (s.indexOf("国语")>0){
            res +="国语";
        }
        else if (s.indexOf("粤语")>0){
            res +="粤语";
        }
        else if (s.indexOf("台语")>0){
            res +="台语";
        }
        else if (s.indexOf("英语")>0){
            res +="英语";
        }
        else if (s.indexOf("中文字幕")>0){
            res +="中文字幕";
        }
        return res;
    }

    function getPatName(n,l,s){
        var res="";
        var rc=false;
        if(s.indexOf("qvod:")>-1 || s.indexOf("bdhd:")>-1 || s.indexOf("cool:")>-1){
            var arr = s.split('|');
            if(arr.length>=2){
                res = arr[2].replace(/[^0-9]/ig,"");
                rc=true;

                if(res!=""){
                    if(res.length>3){
                        res += "期";
                    }
                    else if(l==1){
                        res = "全集";
                    }
                    else{
                        res = '第' + res + '集';
                    }

                }
                else{
                    res = FindNote(s);
                    if (s==""){
                        if (l==1){
                            res="全集";
                        }
                        else{
                            rc=false;
                        }
                    }
                }
            }
        }
        if(!rc){
            res = '第' + (n<9 ? '0' : '') + (n+1) + '集';
        }
        return res;
    }

    <?php if($info['vod_id'] > 0): ?>
    setTimeout(function () {
        getExtend('<?php echo $info['type_id']; ?>')
    },1000);
    <?php endif; ?>
    
</script>

</body>
</html>