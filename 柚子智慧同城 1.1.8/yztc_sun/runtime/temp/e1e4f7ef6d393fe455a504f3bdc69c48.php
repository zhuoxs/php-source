<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cpanic/edit.html";i:1555123170;s:95:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit_table.html";i:1553823402;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layui</title>
    <link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/src/css/layui.css">
    <script src="/addons/yztc_sun/public/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/addons/yztc_sun/public/static/bower_components/layui/src/layui.js"></script>

    <link href="/addons/yztc_sun/public/static/bower_components/select2/dist/css/select2.css" rel="stylesheet" />
    <script src="/addons/yztc_sun/public/static/custom/pinyin.js"></script>

    <link href="/web/resource//css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/web/resource//css/common.css" rel="stylesheet">
    <script>

        window.sysinfo = {
            'siteroot': '<?php echo isset($_W['siteroot'])?$_W['siteroot']:''; ?>',
            'siteurl': '<?php echo isset($_W['siteurl'])?$_W['siteurl']:''; ?>',
            'attachurl': '<?php echo isset($_W['attachurl'])?$_W['attachurl']:''; ?>',
            'attachurl_local': '<?php echo isset($_W['attachurl_local'])?$_W['attachurl_local']:''; ?>',
            'attachurl_remote': '<?php echo isset($_W['attachurl_remote'])?$_W['attachurl_remote']:''; ?>',
            'cookie' : {'pre': '<?php echo isset($_W['config']['cookie']['pre'])?$_W['config']['cookie']['pre']:''; ?>'},
            'account' : <?php  echo json_encode($_W['account']) ?>
        };
    </script>
    <script src="/web/resource//js/app/util.js"></script>
    <script src="/web/resource//js/app/common.min.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        requireConfig.baseUrl = "/web/resource/js/app";
        requireConfig.paths.select2 = "/addons/yztc_sun/public/static/bower_components/select2/dist/js/select2";
        require.config(requireConfig);

        require(['select2','bootstrap'], function () {
            $.fn.select2.defaults.set("matcher",function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (data.keywords && data.keywords.indexOf(params.term) > -1 || data.text.indexOf(params.term) > -1) {
                    return data;
                }
                return null;
            });
        });
    </script>
    <style>
        body{
            min-width: 0px !important;
        }
        .select2{
            width: 100%;
        }
        .select2 .select2-selection{
            height: 38px;
            border-radius: 2px;
            /*border-color: rgb(230,230,230);*/
        }
        .select2 .select2-selection__rendered{
            line-height: 38px!important;
        }
        .select2 .select2-selection__arrow{
            height: 36px!important;
        }

        .layui-form-item .layui-form-label{
            width: 180px;
        }
        .layui-form-item .layui-input-block{
            margin-left: 210px;
        }
        /*修改表单页面样式*/
        .layui-table-view .layui-form-checkbox{
            margin-top: 0!important;
        }
        /*laytable 选中样式*/
        .layui-table-check{
            background-color: #e0f7de;
        }
        /*修改列表页面样式*/
        .tool-box{
            margin-top: 10px;
            padding: 6px;
            background: #fff;
            border: 1px #ddd solid;
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            
<link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/extend/cascader.css">
<div class="layui-form-item">
    <label class="layui-form-label">商品分类</label>
    <div class="layui-input-block">
        <select name="cat_id" id="cat_id" class="select2" lay-ignore></select>
    </div>
</div>
<?php if($_SESSION['admin']['store_id']==0): ?>
<div class="layui-form-item">
    <label class="layui-form-label">所属商家</label>
    <div class="layui-input-block">
        <select name="store_id" id="store_id" class="select2" lay-verify="required" lay-ignore></select>
    </div>
</div>
<?php endif; ?>
<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="name" lay-verify="required" placeholder="请输入名称" class="layui-input" value="<?php echo isset($info['name'])?$info['name']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" min="0" name="sort" placeholder="从小到大" class="layui-input" value="<?php echo isset($info['sort'])?$info['sort']:''; ?>">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">库存</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" min="0" name="stock" placeholder="请输入库存" class="layui-input" value="<?php echo isset($info['stock'])?$info['stock']:''; ?>">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">是否显示库存</label>
        <div class="layui-input-block">
            <input type="radio" name="is_stock" value="1" title="显示" <?php echo $info['is_stock']==1?"checked":""; ?>>
            <input type="radio" name="is_stock" value="0" title="不显示" <?php echo $info['is_stock']!=1?"checked":""; ?>>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">抢购价</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="panic_price" placeholder="请输入抢购价" class="layui-input" value="<?php echo isset($info['panic_price'])?$info['panic_price']:''; ?>" lay-verify="required" >
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">原价</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="original_price" placeholder="请输入原价" class="layui-input" value="<?php echo isset($info['original_price'])?$info['original_price']:''; ?>" lay-verify="required">
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">是否仅会员购买</label>
        <div class="layui-input-block">
            <input type="radio" name="only_vip" value="1" title="开启" <?php echo $info['only_vip']==1?"checked":""; ?>>
            <input type="radio" name="only_vip" value="0" title="关闭" <?php echo $info['only_vip']!=1?"checked":""; ?>>
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">会员价</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="vip_price" placeholder="0为0元购" class="layui-input" value="<?php echo isset($info['vip_price'])?$info['vip_price']:''; ?>">
        </div>
    </div>
</div>
<!--
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">是否开启会员免单</label>
        <div class="layui-input-block">
            <input type="radio" name="vip_free" value="1" title="开启" <?php echo $info['vip_free']==1?"checked":""; ?>>
            <input type="radio" name="vip_free" value="0" title="关闭" <?php echo $info['vip_free']!=1?"checked":""; ?>>
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">免单次数</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number"  name="free_num" class="layui-input" value="<?php echo isset($info['free_num'])?$info['free_num']:''; ?>">
        </div>
    </div>
</div>-->
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">开始时间</label>
        <div class="layui-input-block">
            <input type="text" name="start_time" id="start_time" value="<?php echo $info['start_time']; ?>"  placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">结束时间</label>
        <div class="layui-input-block">
            <input type="text" name="end_time" id="end_time" value="<?php echo isset($info['end_time'])?$info['end_time']:''; ?>"  placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">过期时间</label>
        <div class="layui-input-block">
            <input type="text" name="expire_time" id="expire_time" value="<?php echo $info['expire_time']; ?>"  placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">购买次数限制</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" min="0" name="limit_num" placeholder="0为不限制" class="layui-input" value="<?php echo isset($info['limit_num'])?$info['limit_num']:''; ?>">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">下单后未付款自动取消</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" min="1" name="cancel_order" placeholder="单位:分钟" class="layui-input" value="<?php echo isset($info['cancel_order'])?$info['cancel_order']:''; ?>" lay-verify="required" >
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">单位</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="unit" placeholder="请输入单位" class="layui-input" value="<?php echo isset($info['unit'])?$info['unit']:''; ?>" lay-verify="required">
        </div>
    </div>
    <!--<div class="layui-inline">-->
        <!--<label class="layui-form-label">重量</label>-->
        <!--<div class="layui-input-block">-->
            <!--<input autocomplete="off" type="text" name="weight" placeholder="请输入重量" class="layui-input" value="<?php echo isset($info['weight'])?$info['weight']:''; ?>">-->
        <!--</div>-->
    <!--</div>-->
</div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">总数</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" name="allnum" min="1" placeholder="请输入虚拟总数" class="layui-input" value="<?php echo isset($info['allnum'])?$info['allnum']:''; ?>">
            <div class="layui-form-mid layui-word-aux">仅显示作用，需大于总销量,以免出现已售份数大于总数</div>
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">虚拟销量</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" name="sales_num_virtual" placeholder="请输入虚拟销量" class="layui-input" value="<?php echo isset($info['sales_num_virtual'])?$info['sales_num_virtual']:''; ?>">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">虚拟浏览量</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="number" name="read_num_virtual" placeholder="请输入虚拟浏览量" class="layui-input" value="<?php echo isset($info['read_num_virtual'])?$info['read_num_virtual']:''; ?>">
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">是否支持退款</label>
        <div class="layui-input-block">
            <input type="radio" name="is_support_refund" value="1" title="支持"<?php echo $info['is_support_refund']==1?"checked":""; ?>>
            <input type="radio" name="is_support_refund" value="0" title="不支持" <?php echo $info['is_support_refund']!=1?"checked":""; ?>>
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">使用方式</label>
        <div class="layui-input-block">
            <input type="radio" name="sendtype" value="1" title="到店" checked>
            <!--<input type="radio" name="sendtype" value="2" title="物流" <?php echo $info['sendtype']!=1?"checked":""; ?>>-->
        </div>
    </div>
    <div class="layui-inline" id="postdiv">
        <label class="layui-form-label">运费模板</label>
        <div class="layui-input-block">
            <select name="postagerules_id" id="postagerules_id" class="select2" lay-ignore></select>
        </div>
    </div>
</div>

<?php if($distributionset['store_setting'] == 1 and $distributionset['level'] > 0): ?>
<div class="layui-form-item">
    <label class="layui-form-label">是否开启单独分销(备注：不想该商品参与分销，请开启单独分销，然后设置分销佣金为 0 ！)</label>
    <div class="layui-input-block">
        <input type="radio" name="distribution_open" value="1" title="开启" <?php echo $info['distribution_open']==1?"checked":""; ?>>
        <input type="radio" name="distribution_open" value="0" title="关闭" <?php echo $info['distribution_open']==0?"checked":""; ?>>
    </div>
</div>

<div class="layui-form-item commissiontype">
    <label class="layui-form-label">分销佣金类型</label>
    <div class="layui-input-block">
        <input type="radio" name="commissiontype" value="1" title="百分比" <?php echo $info['commissiontype']==1||!$info['commissiontype']?"checked":""; ?>>
        <input type="radio" name="commissiontype" value="2" title="固定金额" <?php echo $info['commissiontype']==2?"checked":""; ?>>
    </div>
</div>

<div class="layui-form-item commission">
    <div class="layui-inline">
        <label class="layui-form-label">一级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="first_money" placeholder="" class="layui-input" value="<?php echo isset($info['first_money'])?$info['first_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php if($distributionset['level'] > 1): ?>
    <div class="layui-inline">
        <label class="layui-form-label">二级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="second_money" placeholder="" class="layui-input" value="<?php echo isset($info['second_money'])?$info['second_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php endif; if($distributionset['level'] > 2): ?>
    <div class="layui-inline">
        <label class="layui-form-label">三级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="third_money" placeholder="" class="layui-input" value="<?php echo isset($info['third_money'])?$info['third_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>


<div class="layui-form-item">
    <label class="layui-form-label">封面图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('pic', isset($info['pic'])?$info['pic']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：340*340</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">轮播图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_multi_image('pics', isset($info['pics'])?$info['pics']:''); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*750</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">首页推荐图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('indexpic', isset($info['indexpic'])?$info['indexpic']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：340*340</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">海报图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('posterpic', isset($info['posterpic'])?$info['posterpic']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*1330，不上传则自动生成显示默认海报</div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商品详情</label>
    <div class="layui-input-block">
        <?php echo tpl_ueditor('details', $info['details']); ?>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">是否推荐至首页</label>
    <div class="layui-input-block">
        <input type="radio" name="is_recommend" value="1" title="是" <?php echo $info['is_recommend']==1?"checked":""; ?>>
        <input type="radio" name="is_recommend" value="0" title="否" <?php echo $info['is_recommend']!=1?"checked":""; ?>>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label"></label>
    <div class="layui-input-block">
        <div class="layui-form-mid layui-word-aux" style="color: red !important;">*阶梯购跟多规格不能同时开启</div><br>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">阶梯购</label>
    <div class="layui-input-block">
        <input type="radio" name="is_ladder" value="1" title="开启" <?php echo $info['is_ladder']==1?"checked":""; ?>>
        <input type="radio" name="is_ladder" value="0" title="关闭" <?php echo $info['is_ladder']!=1?"checked":""; ?>>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label"></label>
    <div class="layui-input-block">
        <div class="layui-form-mid layui-word-aux" style="color: red !important;">*阶梯购开启之后虚拟销量建议设置为0，阶梯购计算数量为：实际销量+虚拟销量</div>
    </div>
</div>
<div class="layui-form-item" id="ladderdiv">
    <label class="layui-form-label">阶梯购规则</label>
    <div class="layui-input-block">
        <!--工具栏-->
        <div class="tool-box">
            <div class="layui-btn-group">
                <a href="javascript:;" id="btnAdd" class="layui-btn layui-btn-primary layui-btn-sm">新增</a>
                <a href="javascript:;" id="btnBatchDelete" class="layui-btn layui-btn-danger layui-btn-sm">删除</a>
            </div>
        </div>
        <!--数据表-->
        <div class="table-box">
            <table class="layui-hide" id="laytables"></table>
        </div>
    </div>
</div>
<style>
    .choose ul{
        height: 530px;
        overflow: auto;
    }
    .choose li{
        position: relative;
    }
    .choose label{
        height: 35px;
        line-height: 35px;
        width: 100%;
        position: relative;
        color: #666;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
        padding: 0px 30px;
    }
    .choose .disabled{
        cursor: pointer;
        color: #aaa;
    }
    .choose input{
        height: 20px;
        width: 20px;
        position: absolute;
        top: 4px;
        right: 30px;
    }
</style>
<script>
    layui.use(['table','form','laydate'],function () {
        var table = layui.table;
        var form = layui.form,
            laydate = layui.laydate;
        //日期
        laydate.render({
            elem: '#start_time',
            type: 'datetime'
        });
        laydate.render({
            elem: '#end_time',
            type: 'datetime'
        });
        table.render({
            elem: '#laytables'
            , data: <?php echo (isset($info['ladder_info']) && $info['ladder_info']) ? ($info['ladder_info']):"[]" ?>
            , cols: [[
            {type: 'numbers', fixed: 'left'},
            {type: 'checkbox', fixed: 'left'},
            {field: 'panic_num', fixed: 'left', width: 250, title: '抢购人数', sort: true, edit: true},
            {field: 'panic_price', width: 250, title: '抢购价', sort: true, edit: true},
            {field: 'vip_price', width: 250, title: '会员价', sort: true, edit: true},
        ]]
            // , page: true
            , limit: 90
            // , height: 'full-420',
        });

        $('#btnAdd').click(function () {
            var data = [];
            data = layui.table.data.laytables;
            data.push({
                'panic_num':'',
                'panic_price':'',
                'vip_price':'',
            });
            table.reload('laytables', {
                data: data,
            });
        })
        //        批量删除
        $('#btnBatchDelete').click(function () {
            var data = [];
            data = layui.table.data.laytables;
            if (data.length > 0) {
                var new_data = [];
                for (var i in data) {
                    if (!data[i]['LAY_CHECKED']) {
                        new_data.push(data[i]);
                    }
                }
                table.reload('laytables', {
                    data: new_data,
                });
            } else {
                layer.msg('请选择记录');
            }
        })

        form.on('radio(type)', function(data){
            table.reload('laytable',{
                cols: [[
                    {type: 'numbers', fixed: 'left'},
                    {type: 'checkbox', fixed: 'left'},
                    {field: 'panic_num', fixed: 'left', width: 250, title: '抢购人数', sort: true, edit: true},
                    {field: 'panic_price', width: 250, title: '抢购价', sort: true, edit: true},
                    {field: 'vip_price', width: 250, title: '会员价', sort: true, edit: true},
                    // {field: 'o', fixed: 'right', width: 200, title: '操作', toolbar: '#dataTool'},
                ]]
            });
        });
    })

</script>
<div class="layui-form-item">
    <label class="layui-form-label">多规格</label>
    <div class="layui-input-block">
        <input type="radio" name="use_attr" value="1" title="开启" <?php echo $info['use_attr']==1?"checked":""; ?>>
        <input type="radio" name="use_attr" value="0" title="关闭" <?php echo $info['use_attr']!=1?"checked":""; ?>>
    </div>
</div>

<div class="attr-setting">
    <div class="layui-form-item">
        <label class="layui-form-label">规格</label>
        <div class="layui-input-block">
            <div class="input-group ">
                <span class="input-group-addon">
                    规格名称
                </span>
                <input type="text" id="group_name" value="" class="form-control" autocomplete="off">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="addGroup(this);">添加规格</button>
                </span>
            </div>
        </div>
    </div>
    <?php if(is_array($attrgroup_list) || $attrgroup_list instanceof \think\Collection || $attrgroup_list instanceof \think\Paginator): $i = 0; $__LIST__ = $attrgroup_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <div class="attr-group">
                <div class="group-title">
                    <label data-name="<?php echo $vo['name']; ?>" data-id="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></label>
                    <span class="group-del" data-id="<?php echo $vo['id']; ?>">X</span>
                </div>
                <div class="attrs">
                    <?php if(is_array($vo['attrs']) || $vo['attrs'] instanceof \think\Collection || $vo['attrs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attr): $mod = ($i % 2 );++$i;?>
                    <div class="attr-item">
                            <span class="attr-item-name" data-name="<?php echo $attr['name']; ?>" data-id="<?php echo $attr['id']; ?>">
                                <?php echo $attr['name']; ?>
                            </span>
                        <span class="attr-item-del" data-id="<?php echo $attr['id']; ?>" data-group-id="<?php echo $vo['id']; ?>">
                                X
                            </span>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="input-group attr-item">
                        <span class="input-group-addon">
                            规格值
                        </span>
                        <input type="text" value="" class="form-control" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-id="<?php echo $vo['id']; ?>" onclick="addAttr(this)">添加规格值</button>
                        </span>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; endif; else: echo "" ;endif; ?>
    <style>

        .attr-group{
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
        }
        .attr-item{
            margin-top: 10px;
            float: left;
        }
        .attr-item:not(:last-child){
            float: left;
            margin-right: 15px;
        }
        .attr-item:not(:last-child) .attr-item-name{
            background: #ddd;
            display: inline-block;
            padding: 7px 14px;
        }
        .attr-item:not(:last-child) .attr-item-del{
            border: 1px solid #eee;
            border-left: 0px;
            height: 34px;
            display: inline-block;
            line-height: 33px;
            margin-left: -4px;
            width: 25px;
            text-align: center;
            cursor: pointer;
        }
        .attr-item:not(:last-child) .attr-item-del:hover,.group-del:hover{
            background-color: #FF4C11;
            /*border: #FF4C11;*/
        }
        .group-del{
            cursor: pointer;
            background-color: #ddd;
            display: inline-block;
            border-radius: 10px;
            height: 20px;
            width: 20px;
            padding: 0 5px;
        }
    </style>
    <script>
        var attr_data = [];
        <?php if(is_array($attrgroup_list) || $attrgroup_list instanceof \think\Collection || $attrgroup_list instanceof \think\Paginator): $i = 0; $__LIST__ = $attrgroup_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        var attrs = [];
        <?php if(is_array($vo['attrs']) || $vo['attrs'] instanceof \think\Collection || $vo['attrs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attr): $mod = ($i % 2 );++$i;?>
        attrs[<?php echo $attr['id']; ?>]= '<?php echo $attr['name']; ?>';
        <?php endforeach; endif; else: echo "" ;endif; ?>
            attr_data[<?php echo $vo['id']; ?>] = {
            'name':'<?php echo $vo['name']; ?>',
            'attrs':attrs,
        };
            <?php endforeach; endif; else: echo "" ;endif; ?>
                function addGroup(e) {
                    var group_name = $("#group_name").val();
                    if (!group_name){
                        return false;
                    }
                    if($('.group-title [data-name="'+group_name+'"]').length) {
                        layer.msg('该规格已经存在',{icon: 5,anim: 6});
                        return false;
                    }
                    $.post("<?php echo adminurl('savegroupname'); ?>",{name:group_name,goods_id:$('input[name=id]').val(),goodsattrgroup_id:0},function (res) {
                        if (typeof res == 'string'){
                            res = $.parseJSON(res);
                        }
                        if (res.code == 0) {
                            var id = res.data;
                            var html = `
                        <div class="layui-form-item">
                            <label class="layui-form-label"></label>
                            <div class="layui-input-block">
                                <div class="attr-group">
                                    <div class="group-title">
                                        <label data-name="${group_name}" data-id="${id}">${group_name}</label>
                                        <span class="group-del" data-id="${id}">X</span>
                                    </div>
                                    <div class="attrs">
                                        <div class="input-group attr-item">
                                            <span class="input-group-addon">
                                                规格值
                                            </span>
                                            <input type="text" value="" class="form-control" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-id="${id}" onclick="addAttr(this)">添加规格值</button>
                                            </span>
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                            $(e).parents('.layui-form-item').after(html);
                            $("#group_name").val('');
                            attr_data[id] = {'name':group_name,'attrs':[]}
                        }else{
                            layer.msg(res.msg,{icon: 5,anim: 6});
                        }
                    })
                }

                function addAttr(e) {
                    var $input = $(e).parents('.attr-item').find('input');
                    var attr_name = $input.val();
                    if (!attr_name){
                        return false;
                    }
                    if($('.attr-item [data-name="'+attr_name+'"]',$(e).parents('.attrs')).length) {
                        layer.msg('该规格已经存在',{icon: 5,anim: 6});
                        return false;
                    }
                    var group_id = $(e).data('id');
                    $.post("<?php echo adminurl('savegroupvalue'); ?>",{name:attr_name,goodsattrgroup_id:group_id},function (res) {
                        if (typeof res == 'string') {
                            res = $.parseJSON(res);
                        }
                        if (res.code == 0) {
                            var id = res.data;

                            var html = `
                        <div class="attr-item">
                            <span class="attr-item-name" data-name="${attr_name}" data-id="${id}">
                                ${attr_name}
                            </span>
                            <span class="attr-item-del" data-id="${id}" data-group-id="${group_id}">
                                X
                            </span>
                        </div>
                        `;
                            $(e).parents('.attr-item').before(html);
                            $input.val('');
                            attr_data[group_id]['attrs'][id] = attr_name;
                        }else{
                            layer.msg(res.msg,{icon: 5,anim: 6});
                        }
                    })
                }

                $(document).on('click','.attr-item-del',function () {
                    var $this = $(this);
                    var id = $this.data('id');
                    $.post("<?php echo adminurl('deletepanicattr'); ?>",{ids:id},function (res) {
                        if (typeof res == 'string') {
                            res = $.parseJSON(res);
                        }
                        if (res.code == 0) {
                            $this.parents('.attr-item').remove();
                            var group_id = $this.data('group-id');
                            delete attr_data[group_id]['attrs'][id];
                        }else{
                            layer.msg(res.msg,{icon: 5,anim: 6});
                        }
                    })
                })
                $(document).on('click','.group-del',function () {
                    var $this = $(this);
                    var id = $this.data('id');
                    $.post("<?php echo adminurl('deletepanicattrgroup'); ?>",{ids:id},function (res) {
                        if (typeof res == 'string') {
                            res = $.parseJSON(res);
                        }
                        if (res.code == 0) {
                            $this.parents('.layui-form-item').remove();
                            delete attr_data[id];
                        }else{
                            layer.msg(res.msg,{icon: 5,anim: 6});
                        }
                    })
                })
    </script>
    <div class="layui-form-item">
        <label class="layui-form-label">规格设置</label>
        <div class="layui-input-block">
            <!--工具栏-->
            <div class="tool-box">
                <div class="layui-btn-group">
                    <a href="javascript:;" id="btnRefresh" class="layui-btn layui-btn-primary layui-btn-sm">刷新</a>
                </div>
                <div class="layui-btn-group">
                    <a href="javascript:;" id="btnBatchStock" class="layui-btn layui-btn-primary layui-btn-sm">修改库存</a>
                    <a href="javascript:;" id="btnBatchPanicPrice" class="layui-btn layui-btn-primary layui-btn-sm">修改抢购价</a>
                    <a href="javascript:;" id="btnBatchPrice" class="layui-btn layui-btn-primary layui-btn-sm">修改会员价</a>
                </div>
                <div class="layui-btn-group">
                    <a href="javascript:;" id="btnChooseImg" class="layui-btn layui-btn-primary layui-btn-sm">选择图片</a>
                </div>
            </div>
            <!--数据表-操作列-->
            <script type="text/html" id="dataTool">
                <!--<a href="javascript:;" lay-event="del" class="layui-btn layui-btn-danger layui-btn-xs">删除</a>-->
                <a href="javascript:;" lay-event="edit" class="layui-btn layui-btn-xs">编辑</a>
            </script>
            <!--数据表-->
            <div class="table-box">
                <table class="layui-hide" id="laytable"></table>
            </div>
            <script type="text/html" id="dataPic">
                {{# if(d.pic){ }}
                <img style="width:50px;" src="<?php echo $_W['attachurl']; ?>{{ d.pic }}">
                {{# } }}
            </script>
        </div>
        <script>
            $('#btnRefresh').click(function () {
                updatetable();
            });
            function updatetable() {
                layui.use(['table'],function () {
                    var table = layui.table;

                    //数据
                    var data = [{
                        "stock":0,
                        "panic_price":0,
                        "vip_price":0,
                        "code":'',
                        "pic":'',
                    }];
                    //列结构
                    var col_data = [
                        {type: 'numbers', fixed: 'left'},
                        {type: 'checkbox', fixed: 'left'},
                    ];
                    col_data.push({field: 'pic', width: 100, title: '封面图',toolbar: '#dataPic'});

                    for (var i in attr_data){
                        //规格分组名称作为一列
                        col_data.push({field: attr_data[i]['name'], width: 180, title: attr_data[i]['name'], sort: true,edit:false});
                        //一组规格
                        var attrs = attr_data[i]['attrs'];
                        var data_new = [];
                        var ids = [];
                        for (var j in data){
                            for(var a in attrs){
                                var d = JSON.parse(JSON.stringify(data[j]));
                                d['ids'] = d['ids'] || [];
                                d[attr_data[i]['name']] = attrs[a];
                                d['ids'].push(a);
                                data_new.push(d);
                            }
                        }
                        data = JSON.parse(JSON.stringify(data_new));
                    }

                    col_data.push({field: 'stock', width: 100, title: '库存',edit:true});
                    col_data.push({field: 'panic_price', width: 100, title: '抢购价',edit:true});
                    col_data.push({field: 'vip_price', width: 100, title: '会员价',edit:true});
                    // col_data.push({field: 'weight', width: 100, title: '重量',edit:true});
                    // col_data.push({field: 'code', width: 100, title: '货号',edit:true});

                    table.reload('laytable', {
                        data: data,
                        cols:[col_data],
                    });
                })
            }
            layui.use(['table','form'],function () {
                var table = layui.table;
                var form = layui.form;
                table.render({
                    elem: '#laytable'
                    , data: <?php echo json_encode($attrsetting_list ); ?>
                    , cols: [[
                    {type: 'numbers', fixed: 'left'},
                    {type: 'checkbox', fixed: 'left'},
                    {field: 'pic', width: 100, title: '封面图', toolbar: '#dataPic',edit:true},
                    <?php if(is_array($attrgroup_list) || $attrgroup_list instanceof \think\Collection || $attrgroup_list instanceof \think\Paginator): $i = 0; $__LIST__ = $attrgroup_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    {field: '<?php echo $vo['name']; ?>', width: 180, title: '<?php echo $vo['name']; ?>', sort: true},
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    {field: 'stock', width: 100, title: '库存',edit:true},
                    {field: 'panic_price', width: 100, title: '抢购价',edit:true},
                    {field: 'vip_price', width: 100, title: '会员价',edit:true},
                    // {field: 'weight', width: 100, title: '重量',edit:true},
                    // {field: 'code', width: 100, title: '货号',edit:true},
                    // {field: 'o', fixed: 'right', width: 200, title: '操作', toolbar: '#dataTool_attr'},
                ]]
                    // , page: true
                    , limit: 90
                    // , height: 'full-420',
                });

                //        批量修改会员价
                $('#btnBatchPrice').click(function () {
                    var checkdata = table.checkStatus('laytable').data;
                    var data = [];
                    data = layui.table.data.laytable;
                    var cache = layui.table.cache.laytable;
                    if (checkdata.length > 0) {
                        layer.prompt({title: '会员价'}, function (value, index, elem) {
                            var fun = function (value, value2) {
                                return value2
                            }

                            var patt = /^\d*\.{0,1}\d*$/;
                            if (patt.test(value)) {
                                fun = function (value, value2) {
                                    return parseFloat(value2).toFixed(2);
                                }
                            }
                            var patt2 = /^[\+\-\*\/]{1}\d*\.{0,1}\d*$/;
                            if (patt2.test(value)) {
                                fun = function (value, value2) {
                                    var v = eval(value + '' + value2);
                                    return parseFloat(v).toFixed(2);
                                }
                            }

                            for (var i in cache) {
                                if (cache[i]['LAY_CHECKED']) {
                                    data[cache[i]['LAY_TABLE_INDEX']]['vip_price'] = fun(data[i]['vip_price'], value);
                                }
                            }
                            table.reload('laytable', {
                                data: data,
                            });
                            layer.close(index);
                        });
                    } else {
                        layer.msg('请选择记录');
                    }
                })
                //        批量修改抢购价
                $('#btnBatchPanicPrice').click(function () {
                    var checkdata = table.checkStatus('laytable').data;
                    var data = [];
                    data = layui.table.data.laytable;
                    var cache = layui.table.cache.laytable;
                    if (checkdata.length > 0) {
                        layer.prompt({title: '抢购价'}, function (value, index, elem) {
                            var fun = function (value, value2) {
                                return value2
                            }

                            var patt = /^\d*\.{0,1}\d*$/;
                            if (patt.test(value)) {
                                fun = function (value, value2) {
                                    return parseFloat(value2).toFixed(2);
                                }
                            }
                            var patt2 = /^[\+\-\*\/]{1}\d*\.{0,1}\d*$/;
                            if (patt2.test(value)) {
                                fun = function (value, value2) {
                                    var v = eval(value + '' + value2);
                                    return parseFloat(v).toFixed(2);
                                }
                            }

                            for (var i in cache) {
                                if (cache[i]['LAY_CHECKED']) {
                                    data[cache[i]['LAY_TABLE_INDEX']]['panic_price'] = fun(data[i]['panic_price'], value);
                                }
                            }
                            table.reload('laytable', {
                                data: data,
                            });
                            layer.close(index);
                        });
                    } else {
                        layer.msg('请选择记录');
                    }
                })
                //        批量修改抢购数量
                $('#btnBatchStock').click(function () {
                    var checkdata = table.checkStatus('laytable').data;
                    var data = [];
                    data = layui.table.data.laytable;
                    var cache = layui.table.cache.laytable;
                    if (checkdata.length > 0) {
                        layer.prompt({title: '库存'}, function (value, index, elem) {
                            for (var i in cache) {
                                if (cache[i]['LAY_CHECKED']) {
                                    data[cache[i]['LAY_TABLE_INDEX']]['stock'] = value;
                                }
                            }
                            table.reload('laytable', {
                                data: data,
                            });
                            layer.close(index);
                        });
                    } else {
                        layer.msg('请选择记录');
                    }
                })
                //批量修改图片
                $('#btnChooseImg').click(function () {
                    var checkdata = table.checkStatus('laytable').data;
                    var data = [];
                    data = layui.table.data.laytable;
                    var cache = layui.table.cache.laytable;
                    if (checkdata.length > 0) {
                        require(["util"], function(util){
                            util.image('',function(url){
                                for (var i in cache) {
                                    if (cache[i]['LAY_CHECKED']) {
                                        data[cache[i]['LAY_TABLE_INDEX']]['pic'] = url.attachment;
                                    }
                                }
                                table.reload('laytable', {
                                    data: data,
                                });
                            },{'multiple':false});
                        });
                    } else {
                        layer.msg('请选择记录');
                    }
                })
            })
        </script>
    </div>

</div>

<script>
    //多规格开关
    function toggleSetting() {
        var use_attr = $('[name=use_attr]:checked').val();
        if (use_attr == 1) {
            $(".attr-setting").show();
        }else{
            $(".attr-setting").hide();
        }

    }
    toggleSetting();
    //阶梯购开关
    function ladderSetting(){
        var ladder = $('[name=is_ladder]:checked').val();
        if (ladder == 1) {
            $("#ladderdiv").show();
        }else{
            $("#ladderdiv").hide();
        }
    }
    ladderSetting();

    //物流开关
    function sendSetting(){
        var sendtype = $('[name=sendtype]:checked').val();
        if (sendtype == 2) {
            $("#postdiv").show();
        }else{
            $("#postdiv").hide();
        }
    }
    sendSetting();

    function setcommissiontypeshow(){
        var  commissiontype= $('[name=commissiontype]:checked').val();
        if(commissiontype==1){
            $('.commissiontype_1').show();
            $('.commissiontype_2').hide();
        }else if(commissiontype==2){
            $('.commissiontype_1').hide();
            $('.commissiontype_2').show();
        }else{
            $('.commissiontype_1').hide();
            $('.commissiontype_2').hide();
        }
    }
    function setdistribution_openshow(){
        var distribution_open= $('[name="distribution_open"]:checked').val();
        if(distribution_open==0){
            $('.commissiontype').hide();
            $('.commission').hide();
            $('.commission').hide();
        }else if(distribution_open==1){
            $('.commissiontype').show();
            $('.commission').show();
        }
    }
    setcommissiontypeshow();
    setdistribution_openshow();

    layui.use(['table','form'],function () {
        var table = layui.table;
        var form = layui.form;
        form.on('radio', function(data){
            if($(data.elem).is('[name=use_attr]')) {
                toggleSetting();
            }
            if($(data.elem).is('[name=is_ladder]')) {
                ladderSetting();
            }
            if($(data.elem).is('[name=sendtype]')) {
                sendSetting();
            }
            if ($(data.elem).is('[name=commissiontype]')) {
                console.log(1);
                setcommissiontypeshow();
            }
            if ($(data.elem).is('[name=distribution_open]')) {
                console.log(2);
                setdistribution_openshow();
            }
        });
        // 新增界面、保存、取消事件
        form.on('submit', function(data){
            if(!$(data.elem).is('button')){
                return false;
            }
            var data = data.field;
            data.attrs_data = JSON.stringify(attr_data);
            data.attr = JSON.stringify(table.data.laytable);
            data.ladder_info = JSON.stringify(table.data.laytables);
            if (data.is_ladder == 1) {
                var ladderCheck = table.data.laytables;
                console.log(ladderCheck);
                if (ladderCheck.length < 1) {
                    var ladderTitle = '请设置阶梯价格数据';
                    layer.msg(ladderTitle,{icon: 5,anim: 6});
                    return false;
                }
                for (var i = 0; i < ladderCheck.length; i++ ) {
                    if ((ladderCheck[i].panic_num-0) < 1) {
                        var ladderTitle = '第' + (i + 1) + '阶梯的抢购人数必须大于0';
                        layer.msg(ladderTitle,{icon: 5,anim: 6});
                        return false;
                    }
                    if ( !((ladderCheck[i].panic_price-0)>0)) {
                        var ladderTitle = '第' + (i + 1) + '阶梯的抢购价格必须大于0';
                        layer.msg(ladderTitle,{icon: 5,anim: 6});
                        return false;
                    }
                    if ( !((ladderCheck[i].vip_price-0)>0)) {
                        var ladderTitle = '第' + (i + 1) + '阶梯的会员价格必须大于0';
                        layer.msg(ladderTitle,{icon: 5,anim: 6});
                        return false;
                    }
                    if ((ladderCheck[i].vip_price-0) >= (ladderCheck[i].panic_price-0)) {
                        var ladderTitle = '第' + (i + 1) + '阶梯的会员价格必须小于抢购价格';
                        layer.msg(ladderTitle,{icon: 5,anim: 6});
                        return false;
                    }
                    if (ladderCheck.length > 1 && (ladderCheck.length - 1) > i && ((ladderCheck[i].panic_num-0) > (ladderCheck[i+1].panic_num-0))) {
                        console.log(ladderCheck.length);
                        console.log(ladderCheck.length - 1);
                        console.log(i);
                        console.log(ladderCheck[i].panic_num);
                        console.log(ladderCheck[i+1].panic_num);
                        var ladderTitle = '第' + (i + 1) + '阶梯的抢购人数不能大于或等于第' + (i+2) + '阶梯的抢购人数';
                        layer.msg(ladderTitle,{icon: 5,anim: 6});
                        return false;
                    }
                }
            }
            var panic_price=$('[name=panic_price]').val();
            var vip_price=$('[name=vip_price]').val();
            var grouper = $('[name=is_group_coupon]:checked').val();
            var use_attr = $('[name=use_attr]:checked').val();
            var ladder = $('[name=is_ladder]:checked').val();
            var is_group_coupon = $('[name=is_group_coupon]:checked').val();
            var coupon_discount=$('[name=coupon_discount]').val();
            panic_price = panic_price -0;
            vip_price = vip_price -0;
            if((vip_price)>0&&(panic_price<vip_price)){
                layer.msg('会员价不能大于抢购价',{icon: 5,anim: 6});
                return false;
            }
            if(use_attr==1 && ladder==1){
                layer.msg('阶梯购与多规格不能同时开启',{icon: 5,anim: 6});
                return false;
            }
            var url = "<?php echo adminurl('saves'); ?>";
            $.post(url,data,function(res){
                if (typeof res == 'string'){
                    res = $.parseJSON(res);
                }
                if (res.code == 0) {
                    var index=parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('保存成功',{icon: 6,anim: 6});
                    parent.layui.table.reload('laytable',{});
                }else{
                    layer.msg(res.msg,{icon: 5,anim: 6});
                }
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('select','ccategory'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['cat_id'])?$info['cat_id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#cat_id').select2({
                data: ret,
            })
        })
    })
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('selectrules','Cstore'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择商家'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['store_id'])?$info['store_id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#store_id').select2({
                data: ret,
            })
        })
    })
    require(['select2'], function () {
        $('.select2').select2();
        $.get("<?php echo adminurl('selectrules','Cpostagerules'); ?>", function (ret) {
            if (typeof ret == "string"){
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择模板'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if(obj.id == "<?php echo isset($info['postagerules_id'])?$info['postagerules_id']:''; ?>"){
                    obj.selected = true;
                }
                return obj;
            });
            $('#postagerules_id').select2({
                data: ret,
            })
        })
    })
    layui.use(['laydate'], function() {
        var laydate = layui.laydate;
        //日期
        laydate.render({
            elem: '#start_time',
            type: 'datetime'
        });
        laydate.render({
            elem: '#end_time',
            type: 'datetime'
        });
        laydate.render({
            elem: '#expire_time',
            type: 'datetime'
        });
    });



</script>

            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form','table'], function(){
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;

        //更新选中状态
        function updateCheckStyle() {
            var className = "layui-table-check";//"layui-bg-green"
            $('.layui-table .laytable-cell-checkbox .layui-form-checkbox:not(\'.layui-form-checked\')').parents('tr[data-index]').each(function (i, e) {
                var $this = $(e);
                var index = $this.data('index');
                var $table = $this.parents('.layui-table-view');
                $('tr[data-index='+index+']',$table).removeClass(className);
            });
            $('.layui-table .laytable-cell-checkbox .layui-form-checkbox.layui-form-checked').parents('tr[data-index]').each(function (i, e) {
                var $this = $(e);
                var index = $this.data('index');
                var $table = $this.parents('.layui-table-view');
                $('tr[data-index='+index+']',$table).addClass(className);
            })
        }
        //		选中样式 - 单选
        table.on('radio', function(obj){
            updateCheckStyle();
        });
        //		选中样式 - 多选
        table.on('checkbox', function(obj){
            var data = obj.data;
            updateCheckStyle();
        });

        //		选中逻辑
        //		行点击选中
        //		ctrl 多选
        //		拖拉区域选中切换
        var begin_index = 0;
        var begin_clientX = 0;
        var begin_clientY = 0;
        $(document).on('mousedown','.layui-table-body tr', function (e) {
            begin_index = $(this).data('index');
            begin_clientX = e.clientX;
            begin_clientY = e.clientY;
        })
        $(document).on('mouseup','.layui-table-body tr', function (e) {
            var $table = $(this).parents('.layui-table-view');
            var end_index = $(this).data('index');
            var end_clientX = e.clientX;
            var end_clientY = e.clientY;
            //          同一行，点击位置不同--说明是在选择文本
            if (end_index == begin_index && (end_clientX != begin_clientX || end_clientY != begin_clientY)){
                return false;
            }
            //          同一行，点击位置一样--说明是单击
            if (end_index == begin_index && end_clientX == begin_clientX && end_clientY == begin_clientY){
                //              点击的是按钮/单选框/多选框/输入框
                if ($(e.target).parents('.layui-form-switch,.laytable-cell-checkbox,.laytable-cell-radio,.layui-btn,[data-edit=true]').length || $(e.target).is('.layui-btn')){
                    return false;
                }
                $('.layui-table-body tr[data-index='+end_index+'] .layui-form-radio:last',$table).click();
            }

            if (window.getSelection){
                window.getSelection().removeAllRanges();
            }else{
                document.selection.empty();
            };

            // 如果没按住 ctrl 则清空其他选中
            if (!e.ctrlKey){
                $('tr[data-index]',$table).each(function (i, e) {
                    var $this = $(e);
                    $('.layui-form-checkbox.layui-form-checked:first',$this).click();
                })
                $('.layui-table-main .laytable-cell-checkbox .layui-form-checkbox.layui-form-checked',$table).click();
            }
            $('tr[data-index]',$table).each(function (i, e) {
                var $this = $(e);
                var index = $this.data('index');
                if ((index>= begin_index && index<= end_index) || (index<= begin_index && index>= end_index)){
                    $('.layui-form-checkbox:first',$this).click();
                }
            })
            return false;
        })

        $('#btnCancel').click(function(e){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
</body>
</html>