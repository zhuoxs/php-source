<div style="display:block;width:100%;overflow:hidden;">
    {:runhook('system_admin_index')}
</div>

<style>
    .panel {
        float: left;
        text-align: center;
        padding: 0;
        min-width: 152px;
        max-width: 152px;
        margin-bottom: 30px;
        background-color: #f2f2f2;
        margin: 10px 5px;
        border-radius: 10px;
        margin-right:30px;
    }

    .panel_icon {
        width: 40%;
        display: inline-block;
        padding: 22px 0;
        float: left;
        color:#fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .panel_word {
        width: 60%;
        display: inline-block;
        float: right;
        margin-top: 22px;
        
        text-align: center;
    }

    .panel_word h3{
        font-size:26px;
        display: inline-block;
        color:#333;
    }
    .panel_word p{
        color:#333;
        margin-top:5px;
    }
    .panel_word p a{
        color:#ff5722;
    }
    .col-md6{
        width:45%;
        main-width:400px;
        float: left;
        height: 300px;
        border:1px solid #c1c1c1;margin-top:50px;
        margin-left: 10px;
        padding-top:10px;
    }
</style>

<div class="layui-row layui-col-space10">
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FF5722">
            <p><i class="fa fa-film" style="font-size:30px;"></i><br/></p><p>视频</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/video/lists">{$data['videocount']}</a></h3>/部
            <p><a title="去审核" href="/admin/video/videocheck">{$data['videoshenhe']}/待审</a></p>
        </div>
    </div>
	<div>&#25042;&#20154;&#28304;&#30721;&#119;&#119;&#119;&#46;&#108;&#97;&#110;&#114;&#101;&#110;&#122;&#104;&#105;&#106;&#105;&#97;&#46;&#99;&#111;&#109;&#32;&#20840;&#31449;&#36164;&#28304;&#50;&#48;&#22359;&#20219;&#24847;&#19979;&#36733;</div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #54ade8;">
            <p><i class="fa fa-file-image-o" style="font-size:30px;"></i></p><p>图册</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/image/lists">{$data['atlascount']}</a></h3>/个
            <p><a title="去审核" href="/admin/image/imgcheck">{$data['atlasshenhe']}/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color:#FFB800">
            <p><i class="fa fa-file-text" style="font-size:30px;"></i><br/></p><p>资讯</p>
        </div>
        <div class="panel_word">
            <h3><a title="管理" href="/admin/novel/lists">{$data['novelcount']}</a></h3>/条
            <p><a title="去审核" href="/admin/novel/novelcheck">{$data['novelshenhe']}/待审</a></p>
        </div>
    </div>
    <div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #5FB878;">
            <p><i class="fa fa-users" style="font-size:30px;"></i></p><p>会员</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/member/index">{$data['membercount']}</a></h3>/个
		   <br/>
           <p><a title="去查看" href="/admin/member/index">禁用/{$data['membershenhe']}/个</a></p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #F8113C;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>支付</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/recharge/index">{$data['ordershenhey']}</a></h3>/笔成功<br/>
           <p><a title="去审核" href="/admin/recharge/index">{$data['ordershenhe']}/</a>笔失败</p>
        </div>
    </div>
	<div class="layui-col-md3 panel">
        <div class="panel_icon" style="background-color: #074AF6;">
            <p><i class="fa fa-user" style="font-size:30px;"></i></p><p>评论</p>
        </div>
        <div class="panel_word">
           <h3><a title="管理" href="/admin/comment/index">{$data['commentcount']}</a></h3>/条<br/>
           <p><a title="去审核" href="/admin/comment/index">{$data['commentshenhe']}/条待核</a></p>
        </div>
    </div>
</div>
<!-- 新增会员走势 start -->
<div id="container" class="col-md6"></div>
<div id="viewVideoMonthCharts" class="col-md6"></div>
<div id="viewAtlasMonthCharts" class="col-md6"></div>
<div id="viewNovelMonthCharts" class="col-md6"></div>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-gl/echarts-gl.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts-stat/ecStat.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/simplex.js"></script>

{if isset($data['memberMonthList'])}
<script type="text/javascript">
    function createMemberCharts(){
        var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月新增会员走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [{$data['memberMonthList']['month']}]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [{$data['memberMonthList']['count']}],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createMemberCharts,100);
</script>
{/if}

{if isset($data['viewVideoMonthList'])}
<script type="text/javascript">
    function createViewVideoCharts(){
    var dom = document.getElementById("viewVideoMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月视频消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [{$data['viewVideoMonthList']['month']}]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [{$data['viewVideoMonthList']['count']}],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewVideoCharts,1000);
</script>
{/if}

{if isset($data['viewAtlasMonthList'])}
<script type="text/javascript">
    function createViewAtlasCharts(){
    var dom = document.getElementById("viewAtlasMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月图册消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [{$data['viewAtlasMonthList']['month']}]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [{$data['viewAtlasMonthList']['count']}],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewAtlasCharts,1500);
</script>
{/if}

{if isset($data['viewNovelMonthList'])}
<script type="text/javascript">
    function createViewNovelCharts(){
    var dom = document.getElementById("viewNovelMonthCharts");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            left: 'center',
            text: '近12个月资讯消费走势',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        xAxis: {
            type: 'category',
            data: [{$data['viewNovelMonthList']['month']}]
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: [{$data['viewNovelMonthList']['count']}],
            type: 'line',
            smooth: true
        }]
    };

    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }}
    setTimeout(createViewNovelCharts,2000);
</script>
{/if}

<!-- Powered by Msvodx版系统信息 start -->
<!--<a href="/1.xls">test Download</a>-->
<div class="fr" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">产品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>产品名称</td>
            <td>YMYS009 强大而又专业的x站在线视频源码系统程序_ 代理分销试看推广应有尽有</td>
        </tr>
        <tr>
            <td>官方网站</td>
            <td><a target="_blank" rel="noreferrer">MsvodX</a></td>
        </tr>
        <tr>
            <td>联系QQ</td>
            <td><a href="http://wpa.qq.com/msgrd?v=3&uin=1919134557&site=qq&menu=yes" target="_blank" rel="noreferrer">1919134557</a></td>
        </tr>
        <tr>
            <td>联系邮箱</td>
            <td>ym@ymyuanma.com</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="fl" style="width:49%;margin-top:50px;">
    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="160">
            <col>
        </colgroup>
        <thead>
            <tr>
                <th colspan="2">系统信息</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td>系统版本</td>
                <td>开源版</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td>{$Think.const.PHP_OS} / {$_SERVER["SERVER_SOFTWARE"]}</td>
            </tr>
            <tr>
                <td>PHP/MySql版本</td>
                <td>PHP {$Think.const.PHP_VERSION} / MySql {:db()->query('select version() as version')[0]['version']}</td>
            </tr>
            <tr>
                <td>ThinkPHP版本</td>
                <td>{$Think.VERSION}</td>
            </tr>
        </tbody>
    </table>
</div>
