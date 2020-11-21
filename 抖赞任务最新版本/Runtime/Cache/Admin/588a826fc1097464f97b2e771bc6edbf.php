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
    <style>
        h3.title {
            line-height: 28px;
            margin-bottom: 12px;
            margin-top: 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #CCC;
            color: #478FCA!important;
            border-bottom-color: #d5e3ef;
            font-size: 16px;
            font-weight: 400;
        }
    </style>
</head>
<body class="no-skin">
<div class="page-header">
    <h1>
        <span style="font-size: 16px;">仪表板</span>
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            overview &amp; stats
        </small>
    </h1>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="infobox infobox-blue infobox-small infobox-dark">
                <div class="infobox-progress" style="text-align: center;font-size: 30px;">
                    <a href="<?php echo U('TaskApply/index',array('status'=>1));?>" style="color: #fff;"><?php echo ($total_sh["task_apply"]); ?></a>
                </div>
                <div class="infobox-data">
                    <a href="<?php echo U('TaskApply/index',array('status'=>1));?>" style="color: #fff;">
                    <div class="infobox-content">任务</div>
                    <div class="infobox-content">待审核</div>
                    </a>
                </div>
            </div>

            <div class="infobox infobox-green infobox-small infobox-dark">
                <div class="infobox-progress" style="text-align: center;font-size: 30px;">
                    <a href="<?php echo U('Pay/tixian',array('status'=>0));?>" style="color: #fff;"><?php echo ($total_sh["tixian"]); ?></a>
                </div>
                <div class="infobox-data">
                    <a href="<?php echo U('Pay/tixian',array('status'=>0));?>" style="color: #fff;">
                    <div class="infobox-content">提现</div>
                    <div class="infobox-content">待审核</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <h4 class="header smaller lighter blue">统计数据</h4>
            <div class="infobox-container" style="text-align: left;">
                <div class="infobox infobox-green">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_num["pay"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">平台充值总额</div>
                    </div>

                    <span class="label label-xlg label-success arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">总收入</span>
                </div>

                <div class="infobox infobox-red">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_num["tixian"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">已返佣金</div>
                    </div>
                    <span class="label label-xlg label-danger arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">已提现</span>
                </div>

                <div class="infobox infobox-blue2">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_num["member_price"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">用户账户余额总额</div>
                    </div>
                    <span class="label label-xlg label-info arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">未提现</span>
                </div>
                <div class="infobox infobox-blue">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_num["member"]); ?>人</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">整站会员数量</div>
                    </div>

                    <span class="label label-xlg label-default arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">会员数</span>
                </div>

                <div class="infobox infobox-pink">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_num["task"]); ?>件</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">总任务数量</div>
                    </div>
                    <span class="label label-xlg label-purple arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">任务数</span>
                </div>

                <div class="infobox infobox-orange2">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_num["task_apply"]); ?>次</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">完成人/次</div>
                    </div>
                    <span class="label label-xlg label-warning arrowed-in-right" style="position:absolute;right: 10px;top: 10px;">完成任务</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5">
            <h4 class="header smaller lighter blue">近期收入</h4>
            <div class="infobox-container" style="text-align: left;">
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_price["price_1"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均￥<?php echo ($total_price["avg_1"]); ?></div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">昨日收入</span>
                </div>
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_price["price_2"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均￥<?php echo ($total_price["avg_2"]); ?></div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">最近7日</span>
                </div>
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number">￥<?php echo ($total_price["price_3"]); ?></span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均￥<?php echo ($total_price["avg_3"]); ?></div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">最近30日</span>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <h4 class="header smaller lighter blue">近期完成任务</h4>
            <div class="infobox-container" style="text-align: left;">
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_task["num_1"]); ?>件</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均<?php echo ($total_task["avg_1"]); ?>件</div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">昨日</span>
                </div>
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_task["num_2"]); ?>件</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均<?php echo ($total_task["avg_2"]); ?>件</div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">最近7日</span>
                </div>
                <div class="infobox ">
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php echo ($total_task["num_3"]); ?>件</span>
                        <div class="infobox-content" style="color: #aaa;font-size: 12px;">日均<?php echo ($total_task["avg_3"]); ?>件</div>
                    </div>
                    <span class="label label-default" style="position:absolute;right: 10px;top: 10px;">最近30日</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 150px;">
        <div class="col-sm-11">
            <h4 class="header smaller lighter blue">
                收入线形图
            </h4>
            <form id="form_1" class="form-search form-inline" method="get" action="" style="text-align: right;float: left">
                <div class="input-group">
                    <input type="text" name="start_date" value="<?php echo ($start_date); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="起始日期">
                    -
                    <input type="text" name="end_date" value="<?php echo ($end_date); ?>" class="input-sm search-query date-picker" data-date-format="yyyy-mm-dd" placeholder="截止日期">
                </div>
                <div class="input-group">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                    </button>
                </div>
            </form>
            <div id="chart_1" style="width:100%;height: 400px;"></div>
        </div>
    </div>

</div><!-- /.page-content -->

<script src="/tpl/Public/js/echarts.js"></script>
<script>
    var chart_1 = echarts.init(document.getElementById('chart_1'));
    chart_1.title = '多 Y 轴示例';
    var colors = ['#5793f3', '#d14a61', '#675bba'];
    option = {
        title: {
            text: ''
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['金额','笔数']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: <?php echo ($days_sale["date_str"]); ?>
        },
        yAxis: [
            {
                type: 'value',
                name: '金额',
                min: 0,
                max: <?php echo ($days_sale["max_price"]); ?>,
                position: 'left',
                axisLine: {
                    lineStyle: {
                        color: colors[0]
                    }
                },
                axisLabel: {
                    formatter: '￥{value}',
                    fontSize:"12"
                }
            },

            {
                type: 'value',
                name: '笔数',
                min: 0,
                max: <?php echo ($days_sale["max_number"]); ?>,
                position: 'right',
                axisLine: {
                    lineStyle: {
                        color: colors[1]
                    }
                },
                axisLabel: {
                    formatter: '{value}笔',
                    fontSize:"12"
                }
            }
        ],
        series: [
            {
                name:'金额',
                type:'line',
                stack: '',
                data:<?php echo ($days_sale["price_str"]); ?>
            },
            {
                name:'笔数',
                type:'line',
                stack: '',
                yAxisIndex: 1,
                data:<?php echo ($days_sale["number_str"]); ?>
            }
        ]
    };
    chart_1.setOption(option);

</script>

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