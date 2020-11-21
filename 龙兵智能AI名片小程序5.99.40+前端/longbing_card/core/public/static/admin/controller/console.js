/**

 @Name：layuiAdmin 主页控制台
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL

 */

layui.define(function(exports){

  //区块轮播切换
  layui.use(['admin', 'carousel'], function(){
    var $ = layui.$
        ,admin = layui.admin
        ,carousel = layui.carousel
        ,element = layui.element
        ,device = layui.device();

    //轮播切换
    $('.layadmin-carousel').each(function(){
      var othis = $(this);
      carousel.render({
        elem: this
        ,width: '100%'
        ,arrow: 'none'
        ,interval: othis.data('interval')
        ,autoplay: othis.data('autoplay') === true
        ,trigger: (device.ios || device.android) ? 'click' : 'hover'
        ,anim: othis.data('anim')
      });
    });

    element.render('progress');

  });

  var data_first_seven=[];
  var day_first_seven=[];

  var open_seven=[];
  var view_seven=[];

  /*
   下面通过 layui.use 分段加载不同的模块，实现不同区域的同时渲染，从而保证视图的快速呈现
   */
  //数据概览
  layui.use(['carousel', 'echarts'], function(){

    var $ = layui.$
        ,carousel = layui.carousel
        ,admin = layui.admin
        ,echarts = layui.echarts;

    var echartsApp = [], options = [
          //新增的用户量
          {
            title: {
              text: '最近一周新增创建名片用户量',
              x: 'center',
              textStyle: {
                fontSize: 14
              }
            },
            tooltip : { //提示框
              trigger: 'axis',
              formatter: "{b}<br>新增用户：{c}"
            },
            xAxis : [{ //X轴（包括今天往前七天）['11-07', '11-08', '11-09', '11-10', '11-11', '11-12', '11-13']
              type : 'category',
              data : day_first_seven
            }],
            yAxis : [{  //Y轴
              type : 'value',
              axisLabel : {
                formatter: '{value} 个'
              }
            }],
            series : [{ //内容  （每天的新增用户）[200, 300, 400, 610, 150, 270, 380],
              type: 'line',
              data: data_first_seven
            }]
          },
         //其他数据访问量
          {
            tooltip : {
              trigger: 'axis'
            },
            calculable : true,
            legend: {
              data:['小程序打开次数','小程序访问人数']
            },
            xAxis : [
              {
                type : 'category',
                data : day_first_seven//['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
              }
            ],
            yAxis : [
              {
                type : 'value',
                name : '打开次数',
                axisLabel : {
                  formatter: '{value} 万'
                }
              },
              {
                type : 'value',
                name : '访问人数',
                axisLabel : {
                  formatter: '{value} 万'
                }
              }
            ],
            series : [
              {
                name:'小程序打开次数',
                type:'line',
                data:open_seven//[900, 850, 950, 1000, 1100, 1050, 1000, 1150, 1250, 1370, 1250, 1100]
              },
              {
                name:'小程序访问人数',
                type:'line',
                yAxisIndex: 1,
                data:view_seven//[850, 850, 800, 950, 1000, 950, 950, 1150, 1100, 1240, 1000, 950]
              }
            ]
          }

        ]
        ,elemDataView = $('#LAY-index-dataview').children('div')
        ,renderDataView =function(index){
          admin.req({
            type:'POST',
            url: config.url+'mingpian_index/newUserData'//数据接口
            ,data:{},
            done:function(res){
              //console.log(res.data.data_first_seven,res.data.day_first_seven);
              //定义两个变量
              data_first_seven=res.data.data_first_seven;
              day_first_seven=res.data.day_first_seven;
              open_seven=res.data.open_seven;
              view_seven=res.data.view_seven;
              //重新赋值
              options[0]['xAxis'][0]['data']=day_first_seven;
              options[0]['series'][0]['data']=data_first_seven;
              options[1]['xAxis'][0]['data']=day_first_seven;
              options[1]['series'][0]['data']=open_seven;
              options[1]['series'][1]['data']=view_seven;
              //渲染
              echartsApp[index] = echarts.init(elemDataView[index], layui.echartsTheme);
              echartsApp[index].setOption(options[index]);
              window.onresize = echartsApp[index].resize;
            }
          });
        };

    //没找到DOM，终止执行
    if(!elemDataView[0]) return;


    renderDataView(0);

    //监听数据概览轮播
    var carouselIndex = 0;
    carousel.on('change(LAY-index-dataview)', function(obj){
      renderDataView(carouselIndex = obj.index);
    });

    //监听侧边伸缩
    layui.admin.on('side', function(){
      setTimeout(function(){
        renderDataView(carouselIndex);
      }, 300);
    });

    //监听路由
    layui.admin.on('hash(tab)', function(){
      layui.router().path.join('') || renderDataView(carouselIndex);
    });
  });
  //最新订单
  layui.use('table', function(){
    var $ = layui.$
        ,table = layui.table;

    table.render({
      elem: '#LAY-index-topSearch'
      ,url: config.url+'mingpian_order/newest'//最新的十条订单
      ,cols: [[
        {type: 'numbers', fixed: 'left'}
        ,{field: 'user_name', title: '用户名'}
        ,{field: 'money', title: '金额(元)', sort: true
          ,templet: function(d){
            return d.money/100;;
          }
        }
        ,{field: 'type',title: '类型', sort: true
          ,templet: function(d){
            if(d.type==1){
              return '加入VIP';
            }else if(d.type==2){
              return '购买模板';
            } else if(d.type==3){
              return '加入合伙人';
            }else if(d.type==4){
              return '信息置顶';
            }
          }
        }
        ,{field: 'status', title: '状态', sort: true
          ,templet: function(d){
            if(d.status==1){
              return '成功';
            }
            if(d.status==0){
              return '<span style="color: red">失败</span>';
            }
          }
        }
        ,{field: 'create_time', width:200, title: '时间', sort: true
        }
      ]]
      ,skin: 'line'
    });

    /*新增用户*/
    table.render({
      elem: '#LAY-index-newest-user'
      ,url: config.url+'mingpian_card/newest&type=1'//最新的创建名片用户
      ,cols: [[
        {type: 'numbers', fixed: 'left'}
        ,{field: 'name', title: '用户名'}
        ,{field: 'update_time', width:200,title: '加入时间', sort: true,
          template: function(item){
            console.log(item)
            if(!item.create_time){
              return  item.update_time;
            }else{
              return  item.create_time;
            }
          }
        }
      ]]
      ,skin: 'line'
    });
    /*新增VIP*/
    table.render({
      elem: '#LAY-index-newest-vip'
      ,url: config.url+'mingpian_card/newest&type=2'//最新的vip
      ,cols: [[
        {type: 'numbers', fixed: 'left'}
        ,{field: 'name', title: '用户名'}
        ,{field: 'update_time', width:200,title: '加入时间', sort: true}
      ]]
      ,skin: 'line'
    });



    //今日热贴
    table.render({
      elem: '#LAY-index-topCard'
      ,url: 'https://weixin.so313.com/addons/longbing_multi/core/public/static/json/console/top-card.js' //模拟接口
      ,page: true
      ,cellMinWidth: 120
      ,cols: [[
        {type: 'numbers', fixed: 'left'}
        ,{field: 'title', title: '标题', minWidth: 300, templet: '<div><a href="{{ d.href }}" target="_blank" class="layui-table-link">{{ d.title }}</div>'}
        ,{field: 'username', title: '发帖者'}
        ,{field: 'channel', title: '类别'}
        ,{field: 'crt', title: '点击率', sort: true}
      ]]
      ,skin: 'line'
    });
  });

  exports('console', {})
});