<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/index/home.html";i:1553823366;}*/ ?>
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
    <link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">
    <script src="/web/resource//js/app/util.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        // requireConfig.baseUrl = "/web/resource/js/app";
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
            overflow: auto!important;
        }
        /*数据块*/
        .data-block{
            text-align: center;
            padding: 10px 0;
        }
        .data-block .data-num{
            font-size: 2.25rem;
            line-height: 40px;
        }

        /*带图数据块*/
        .data-block.layui-row{
            height: 147px;
            border-right: 2px solid #f6f6f6;
            padding-top: 37px;
        }
        .data-block img{
            margin-top: 10px;
            margin-left: 60px;
        }

        /*用户*/
        .user-block{
            font-size: 0.8em;
        }
        .user-block img{
            width: 80px;
        }
    </style>
</head>
<body class="layui-layout-body" style="background-color: #f2f2f2">
<div class="layui-layout layui-layout-admin">
    <div class="layui-fluid" style="padding: 15px;">
        <div class="layui-row layui-col-space15">
            <?php if(!$_SESSION['admin']['store_id']): ?>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">
                        <div class="layui-tab layui-tab-brief">
                            用户信息
                        </div>
                    </div>
                    <div class="layui-card-body">
                        <div class="layui-row">
                            <div class="layui-col-md3 layui-col-sm3 data-block">
                                <div class="data-num"><?php echo $user['today_count']; ?></div>
                                <div class="data-lavel">今日</div>
                            </div>
                            <div class="layui-col-md3 layui-col-sm3 data-block">
                                <div class="data-num"><?php echo $user['yesterday_count']; ?></div>
                                <div class="data-lavel">昨日</div>
                            </div>
                            <div class="layui-col-md3 layui-col-sm3 data-block">
                                <div class="data-num"><?php echo $user['month_count']; ?></div>
                                <div class="data-lavel">本月</div>
                            </div>
                            <div class="layui-col-md3 layui-col-sm3 data-block">
                                <div class="data-num"><?php echo $user['count']; ?></div>
                                <div class="data-lavel">总数</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="layui-col-md8">
                <div class="layui-card">
                    <div class="layui-row">
                        <div class="layui-col-md4 layui-col-sm4">
                            <div class="data-block layui-row">
                                <div class="layui-col-md4 layui-col-sm4">
                                    <img src="/addons/yztc_sun/public/static/images/paying.png">
                                </div>
                                <div class="layui-col-md8 layui-col-sm8">
                                    <div class="data-num"><?php echo $order['wait_pay']; ?></div>
                                    <div class="data-lavel">待付款</div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4 layui-col-sm4">
                            <div class="data-block layui-row">
                                <div class="layui-col-md4 layui-col-sm4">
                                    <img src="/addons/yztc_sun/public/static/images/sending.png">
                                </div>
                                <div class="layui-col-md8 layui-col-sm8">
                                    <div class="data-num"><?php echo $order['wait_use']; ?></div>
                                    <div class="data-lavel">待使用</div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-md4 layui-col-sm4">
                            <div class="data-block layui-row">
                                <div class="layui-col-md4 layui-col-sm4">
                                    <img src="/addons/yztc_sun/public/static/images/aftersale.png">
                                </div>
                                <div class="layui-col-md8 layui-col-sm8">
                                    <div class="data-num"><?php echo $order['after_sale']; ?></div>
                                    <div class="data-lavel">售后/退款</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">
                        <div class="layui-tab layui-tab-brief" lay-filter="saledata">
                            销售数据
                            <ul class="layui-tab-title pull-right">
                                <li class="layui-this">今日</li>
                                <li>昨日</li>
                                <li>本月</li>
                                <li>上月</li>
                                <li>今年</li>
                            </ul>
                        </div>
                    </div>
                    <div class="layui-card-body">
                        <div class="layui-row">
                            <div class="layui-col-md4 layui-col-sm4 data-block">
                                <div class="data-num" id="salenum">0</div>
                                <div class="data-lavel">成交量（件）</div>
                            </div>
                            <div class="layui-col-md4 layui-col-sm4 data-block">
                                <div class="data-num" id="salemoney">0</div>
                                <div class="data-lavel">成交额（元）</div>
                            </div>
                            <div class="layui-col-md4 layui-col-sm4 data-block">
                                <div class="data-num" id="avesalemoney">0</div>
                                <div class="data-lavel">订单平均消费（元）</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    layui.use('element', function(){
        var element = layui.element;
        //监听Tab切换，以改变地址hash值
        // element.on('tab(test1)', function(e){
        //     console.log(e);
        // });

        //销售数据
        function getSaleData(type) {
            $.ajax({
                url: "<?php echo adminurl('saleData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {type: type},
                success: function (res) {
                    if(res.code== 0){
                        $('#salenum').html(res.data.salenum);
                        $('#salemoney').html(res.data.salemoney);
                        $('#avesalemoney').html(res.data.avesalemoney);
                    }
                }
            })
        }
        getSaleData(1);
        element.on('tab(saledata)', function(e){
            getSaleData(e.index+1);
        });
        //商品销售排行
        function getSaleOrder(type) {
            $.ajax({
                url: "<?php echo adminurl('goodsSale'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {type: type},
                success: function (res) {
                    if(res.code== 0){
                        var str = '';
                        for (var i in res.data) {
                            var num= i-0+1;
                            str +=  '<tr>' +
                                '<td>' + num + '</td>' +
                                '<td>' + res.data[i].gname + '</td>' +
                                '<td>' + res.data[i].salenum + '</td>' +
                                '<tr>'
                        }
                        $('#goodsale').html(str);
                    }
                }
            })
        }
        getSaleOrder(1)
        element.on('tab(saleorder)', function(e){
            getSaleOrder(e.index+1);
        });
    });
</script>
</body>
</html>