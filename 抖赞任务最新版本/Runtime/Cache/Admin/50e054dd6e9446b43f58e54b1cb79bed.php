<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo sp_cfg('website');?></title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />

    <!--[if IE 7]>
        <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace.min.css" />
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="/tpl/Admin/Public/aceadmin/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/tpl/Admin/Public/aceadmin/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
        <script src="/tpl/Admin/Public/aceadmin/js/html5shiv.js"></script>
        <script src="/tpl/Admin/Public/aceadmin/js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" href="/tpl/Public/js/artDialog/skins/default.css" />
</head>
<body>
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    管理
</div>
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
         <a href="<?php echo U('index', $get);?>">任务列表</a>
   </li>
   <li>
        <a href="<?php echo U('handle');?>">添加任务</a>
    </li>
</ul>
<form class="form-search form-inline" method="get" action="" style="padding: 10px 0; ">
    类型：
    <div class="input-group">
        <select name="type">
            <option value="">所有类型</option>
            <?php $_result=C('TASK_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $get['type'] and $get['type'] != ''): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>

    任务等级：
    <div class="input-group">
        <select name="level">
            <option value="">所有等级</option>
            <?php if(is_array($level_list)): $i = 0; $__LIST__ = $level_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["level"]); ?>" <?php if($vo['level'] == $get['level'] and $get['level'] != ''): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>

    时间段：
    <div class="input-group">
        <input type="text" name="start_date" value="<?php echo ($get["start_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="起始日期">
        <input type="text" name="end_date" value="<?php echo ($get["end_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="截止日期">
    </div>

    <div class="input-group">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            搜索
        </button>
    </div>
</form>
<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th width="60">编号</th>
        <th>标题</th>
        <th>任务类型</th>
        <th>任务级别</th>
        <th>已领/名额</th>
        <th>截止日期</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["title"]); ?></td>
            <td><?php echo ($vo["type_name"]); ?></td>
            <td><span class="level_<?php echo ($vo["level"]); ?>"><?php echo ($vo["level_name"]); ?></span></td>
            <td><?php echo ($vo["apply_num"]); ?>/<?php echo ($vo["max_num"]); ?></td>
            <td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
            <td><?php echo (date('Y-m-d H:i',$vo["create_time"])); ?></td>
            <td>
                <a href="<?php echo U('handle',array('id'=>$vo['id'],'copy'=>1));?>" class="btn btn-default btn-xs">快速复制</a>
                <a href="<?php echo U('handle',array('id'=>$vo['id']));?>" class="btn btn-default btn-xs">编辑</a>
                <a href="<?php echo U('delete',array('id'=>$vo['id']));?>" class="btn btn-default btn-xs delete">删除</a>
            </td>
        </tr><?php endforeach; endif; ?>
</table>
<?php echo ($Page); ?>
<br><br><br>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/artDialog/artDialog.js"></script>
<script src="/tpl/Public/js/artDialog/iframeTools.js"></script>
<script src="/tpl/Public/js/bootbox.js"></script>
<script src="/tpl/Public/js/base.js"></script>

<link rel="stylesheet" href="/tpl/Public/js/datepicker/css/bootstrap-datepicker3.min.css" />
<link rel="stylesheet" href="/tpl/Public/js/datepicker/css/bootstrap-datetimepicker.min.css" />
<script src="/tpl/Public/js/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/tpl/Public/js/datepicker/js/bootstrap-timepicker.min.js"></script>

<script src="/Public/statics/layer/layer.js"></script>
<script src="/Public/statics/layer/extend/layer.ext.js"></script>

</body>
</html>