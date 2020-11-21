  //指定图标的配置和数据
option = {
    title : {
        text: '财务总览',
    },
    tooltip : {
        trigger: 'axis'
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        
        {
            name:'成交量',
            type:'line',
            smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'}}},
            data:[30, 182, 434, 791, 390, 30, 10,30, 182, 434, 791, 390, 30, 10,30, 182, 434, 791, 390, 30, 10,30, 182, 434, 791, 390, 30, 10,30.20]
        },
        {
            name:'成交额',
            type:'line',
            smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'}}},
            data:[1320, 1132, 601, 234, 120, 90, 20,1320, 1132, 601, 234, 120, 90, 20,1320, 1132, 601, 234, 120, 90, 20,1320, 1132, 601, 234, 120, 90, 20,23,56]
        }
    ]
};
      
        //初始化echarts实例
        
        var myChart = echarts.init(document.getElementById('chartmain'),'macarons');
        //使用制定的配置项和数据显示图表
        myChart.setOption(option);