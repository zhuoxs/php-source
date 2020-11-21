<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<title>等级管理 - <?php echo sp_cfg('website');?></title>
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
<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
	<a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 首页</a>
	&gt;
	等级管理
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs">
   <li class="active">
		 <a href="#home" data-toggle="tab">等级列表</a>
   </li>
   <li>
		<a href="javascript:;" onclick="add()">添加等级</a>
	</li>
</ul>
	<div id="myTabContent" class="tab-content">
	   <div class="tab-pane fade in active" id="home">
			<table class="table table-striped table-bordered table-hover" style="margin-top: 10px;">
				<tr>
					<th>等级名称</th>
                    <th>升级金额</th>
                    <th>一推荐人返佣</th>
                    <th>二推荐人返佣</th>
                    <th>三推荐人返佣</th>
                    <th>权限描述</th>
                    <th>每日限制任务数</th>
                    <th>操作</th>
				</tr>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
						<td><?php echo ($vo["name"]); ?></td>
                        <td><?php echo ($vo["price"]); ?></td>
                        <td><?php echo ($vo["rebate_price_1"]); ?></td>
                        <td><?php echo ($vo["rebate_price_2"]); ?></td>
                        <td><?php echo ($vo["rebate_price_3"]); ?></td>
                        <td><?php echo ($vo["remark"]); ?></td><td><?php echo ($vo["day_limit_task_num"]); ?></td>
						<td><a class="btn btn-default btn-xs" href="javascript:;" data-id="<?php echo ($vo["id"]); ?>" data-name="<?php echo ($vo["name"]); ?>" data-price="<?php echo ($vo["price"]); ?>" data-rebate_price_1="<?php echo ($vo["rebate_price_1"]); ?>" 
                               data-rebate_price_2="<?php echo ($vo["rebate_price_2"]); ?>" data-rebate_price_3="<?php echo ($vo["rebate_price_3"]); ?>"  day_limit_task_num="<?php echo ($vo["day_limit_task_num"]); ?>" data-remark="<?php echo ($vo["remark"]); ?>" 
                               data-num="<?php echo ($vo["num"]); ?>" onclick="edit(this)">修改</a></td>
					</tr><?php endforeach; endif; ?>
			</table>
	   </div>
	</div>

<!-- 添加等级模态框开始 -->
<div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					添加等级
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('add');?>" method="post">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th>等级名称：</th>
                            <td>
                                <input class="form-control" type="text" name="name">
                            </td>
                        </tr>
                        <tr>
                            <th>升级金额：</th>
                            <td>
                                <input class="form-control" type="text" name="price">
                            </td>
                        </tr>
                        <tr>
                            <th>一级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_1">
                            </td>
                        </tr>
                        <tr>
                            <th>二级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_2">
                            </td>
                        </tr>
                        <tr>
                            <th>三级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_3">
                            </td>
                        </tr>
                      <tr>
                            <th>权限描述：</th>
                            <td>
                                <input class="form-control" type="text" name="remark">
                            </td>
                        </tr>
                      
                        <tr>
                            <th>每日限制任务数：</th>
                            <td>
                                <input class="form-control" type="text" name="day_limit_task_num">
                            </td>
                        </tr>
                      
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn btn-success" type="submit" value="修改">
                            </td>
                        </tr>
                    </table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 添加等级模态框结束 -->

<!-- 修改等级模态框开始 -->
<div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					修改等级
				</h4>
			</div>
			<div class="modal-body">
				<form id="bjy-form" class="form-inline" action="<?php echo U('edit');?>" method="post">
					<input type="hidden" name="id">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<tr>
							<th>等级名称：</th>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<th>升级金额：</th>
							<td>
								<input class="form-control" type="text" name="price">
							</td>
						</tr>
                        <tr>
                            <th>一级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_1">
                            </td>
                        </tr>
                        <tr>
                            <th>二级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_2">
                            </td>
                        </tr>
                        <tr>
                            <th>三级推荐人返佣：</th>
                            <td>
                                <input class="form-control" type="text" name="rebate_price_3">
                            </td>
                        </tr>
                      
                        <tr>
                            <th>每日限制任务数：</th>
                            <td>
                                <input class="form-control" type="text" name="day_limit_task_num">
                            </td>
                        </tr>
                      
                      
                        <tr>
                            <th>权限描述：</th>
                            <td>
                                <input class="form-control" type="text" name="remark">
                            </td>
                        </tr>
						<tr>
							<th></th>
							<td>
								<input class="btn btn-success" type="submit" value="修改">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 修改等级模态框结束 -->
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

<script>
// 添加等级
function add(){
    $("input[name='name']").val('');
    $("input[name='remark']").val('');
    $("input[name='price']").val('');
    $("input[name='rebate_price_1']").val('');
    $("input[name='rebate_price_2']").val('');
    $("input[name='rebate_price_3']").val('');
	$('#bjy-add').modal('show');
}

// 修改等级
function edit(obj){
	var id=$(obj).attr('data-id');
	var name=$(obj).attr('data-name');
	var remark=$(obj).attr('data-remark');
	var price=$(obj).attr('data-price');
    var rebate_price_1=$(obj).attr('data-rebate_price_1');
    var rebate_price_2=$(obj).attr('data-rebate_price_2');
    var rebate_price_3=$(obj).attr('data-rebate_price_3');
    var day_limit_task_num=$(obj).attr('day_limit_task_num');
	$("input[name='id']").val(id);
	$("input[name='name']").val(name);
	$("input[name='remark']").val(remark);
	$("input[name='price']").val(price);
    $("input[name='rebate_price_1']").val(rebate_price_1);
    $("input[name='rebate_price_2']").val(rebate_price_2);
    $("input[name='rebate_price_3']").val(rebate_price_3);
     $("input[name='day_limit_task_num']").val(day_limit_task_num);
  
	$('#bjy-edit').modal('show');
}

</script>
</body>
</html>