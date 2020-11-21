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

</head>
<body>
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    用户列表
</div>
<ul id="myTab" class="nav nav-tabs">
    <li <?php if($get['level'] == ''): ?>class="active"<?php endif; ?> ><a href="<?php echo U('index');?>">全部（<?php echo ($member_count); ?>）</a></li>
    <?php if(is_array($member_level_count)): $i = 0; $__LIST__ = $member_level_count;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if($get['level'] == $vo[level] and $get['level'] != '' and $get['level'] != 'unregistered'): ?>class="active"<?php endif; ?> ><a href="<?php echo U('index',array('level'=>$vo['level']));?>"><?php echo ($vo["name"]); ?>（<?php echo ($vo["count"]); ?>）</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

<form id="form_1" class="form-search form-inline" method="get" action="" style="padding: 10px 0; ">



    会员ID：
    <div class="input-group">
        <input type="text" name="id" value="<?php echo ($get["id"]); ?>" class="input-sm search-query" placeholder="会员ID">
    </div>
    &nbsp;&nbsp;
    关键词：
    <div class="input-group">
        <input type="hidden" name="keytype" value="username,nickname,phone" />
        <input type="text" name="keywords" value="<?php echo ($get["keywords"]); ?>" class="input-sm search-query" placeholder="账号/昵称/手机号">
    </div>
    &nbsp;&nbsp;
    关注时间：
    <div class="input-group">
        <input type="text" name="start_date" value="<?php echo ($get["start_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="起始日期">
        -
        <input type="text" name="end_date" value="<?php echo ($get["end_date"]); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="截止日期">
    </div>

    <?php if(intval($get['is_area']) == 1): ?>地区：<?php echo W('Area/index',array($get['province'],$get['city'],$get['area'],'selectArea')); endif; ?>

    <div class="input-group">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            搜索
        </button>
    </div>
</form>


<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th width="60">会员ID</th>
        <th>头像</th>
        <th>账号</th>
        <th>姓名</th>
        <th>电话</th>
        <th>会员等级</th>
        <th>余额</th>
        <th>累计奖励</th>
        <th>关注时间</th>
        <th>销售团队</th>
        <th>操作</th>
    </tr>
    <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php if($vo['head_img'] != ''): ?><img src="<?php echo ($vo["head_img"]); ?>" style="height: 50px; -webkit-border-radius: 50%; -moz-border-radius: 50%; border-radius: 50%;" /><?php endif; ?></td>
            <td><?php echo ($vo["username"]); ?></td>
            <td><?php echo ($vo["nickname"]); ?></td>
            <td><?php echo ($vo["phone"]); ?></td>
            <td>
                <span class="level_<?php echo ($vo["level"]); ?>"> <?php echo ($vo["level_name"]); ?></span>
            </td>
            <td><?php echo ($vo["price"]); ?>元</td>
            <td><?php echo ($vo["total_price"]); ?>元</td>
            <td>
                <?php echo (date("Y-m-d H:s", $vo["create_time"])); ?>
            </td>
            <td>
                <a href="<?php echo U('team_show',array('id'=>$vo['id']));?>" class="link layer-dialog" title="<?php echo ($vo["username"]); ?>的团队"><?php echo ($vo["team_num"]); ?>人</a>
            </td>
            <td>
                <a href="javascript:;" class="btn btn-default btn-xs" data-id="<?php echo ($vo["id"]); ?>" data-username="<?php echo ($vo["username"]); ?>" onclick="set_pid(this)">调整团队</a>
                <a href="javascript:;" class="btn btn-default btn-xs" data-id="<?php echo ($vo["id"]); ?>" data-username="<?php echo ($vo["username"]); ?>" onclick="recharge(this)">线下充值VIP</a>
                <a href="javascript:;" class="btn btn-default btn-xs" data-id="<?php echo ($vo["id"]); ?>" data-username="<?php echo ($vo["username"]); ?>" onclick="chongzhi(this)">余额充值</a>
                <a href="<?php echo U('Pay/price_log',array('member_id'=>$vo['id']));?>" class="btn btn-default btn-xs layer-dialog" title="资金明细：<?php echo ($vo["nickname"]); ?>">资金明细</a>
                <a href="<?php echo U('handle',array('id'=>$vo['id'],'role'=>1));?>" class="btn btn-default btn-xs layer-dialog" title="详细信息：<?php echo ($vo["nickname"]); ?>">详细信息</a>

             <!--   | &nbsp;<a href="javascript:;" class="btn btn-default btn-xs" data-id="<?php echo ($vo["id"]); ?>" data-nickname="<?php echo ($vo["nickname"]); ?>" onclick="edit(this)">发送消息</a>-->
            </td>
        </tr><?php endforeach; endif; ?>
</table>
<?php echo ($Page); ?>

<br><br><br>
<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="apply-edit_set_pid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel_set_pid">
                    调整团队关系
                </h4>
            </div>
            <div class="modal-body">
                <form id="bjy-form_set_pid" class="form-inline" action="<?php echo U('set_pid');?>" method="post">
                    <input type="hidden" name="member_id">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th>账号：</th>
                            <td>
                                <input class="form-control" type="text" name="username" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>调整到上级ID：</th>
                            <td>
                                <input class="form-control" type="text" name="pid">
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn btn-success" type="submit" value="确定">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 修改菜单模态框结束 -->


<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="apply-recharge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel_recharge">
                    会员充值
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" action="<?php echo U('recharge');?>" method="post">
                    <input type="hidden" name="member_id">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th>账号：</th>
                            <td>
                                <input class="form-control" type="text" name="username" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>充值等级：</th>
                            <td>
                                <?php if(is_array($member_level)): $i = 0; $__LIST__ = $member_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label style="display: block">
                                        <input type="radio" name="level" value="<?php echo ($key); ?>" style="height: inherit"> <?php echo ($vo["name"]); ?> (￥<?php echo ($vo["price"]); ?>)
                                    </label><?php endforeach; endif; else: echo "" ;endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn btn-success" type="submit" value="确定">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 修改菜单模态框结束 -->


<!-- 修改菜单模态框开始 -->
<div class="modal fade" id="chongzhi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    充值
                </h4>
            </div>
            <div class="modal-body">
                <form id="form_chongzhi" class="form-inline" action="<?php echo U('chongzhi');?>" method="post">
                    <input type="hidden" name="member_id">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th>账号：</th>
                            <td>
                                <input class="form-control" type="text" name="username" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>充值金额：</th>
                            <td>
                                <input class="form-control" type="number" name="price">
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn btn-success" type="submit" value="确定">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 修改菜单模态框结束 -->
</body>
</html>

<script>
    function set_pid(obj){
        var id=$(obj).attr('data-id');
        var username=$(obj).attr('data-username');
        $("input[name='member_id']").val(id);
        $("input[name='username']").val(username);
        $('#apply-edit_set_pid').modal('show');
    }



    function recharge(obj){
        var id=$(obj).attr('data-id');
        var username=$(obj).attr('data-username');
        $("input[name='member_id']").val(id);
        $("input[name='username']").val(username);
        $('#apply-recharge').modal('show');
    }

    function chongzhi(obj){
        var id=$(obj).attr('data-id');
        var username=$(obj).attr('data-username');
        $("input[name='member_id']").val(id);
        $("input[name='username']").val(username);
        $('#chongzhi_modal').modal('show');
    }

    $(function(){
        $('#send_smg').click(function(){
            var id = $('#id').val();
            var msg = $('#msg').val();
            var url = "<?php echo U('Notice/add');?>";
            $.post(url, {member_id:id,msg:msg},function(data){
                if( data.status == 1 ) {
                    alert('发送成功');
                    $('#apply-edit').modal('hide');
                } else {
                    alert(data.info);
                }
            },'json')
        })


        $('#is_area').click(function(){
            $('#form_1').submit();
        })
    })

</script>