var app = getApp();
import util from '../../../resource/js/xx_util.js';
import { baseModel, bossModel } from '../../../resource/apis/index.js'
var echarts = require('../../../templates/ec-canvas/echarts');

Page({
  data: {
    tabBarList : [{ status: 'toTabBar', type:'toOverview', name: '总览' }, { status: 'toTabBar', type:'toRank', name: '销售排行' }, { status: 'toTabBar', type:'toAnalysis', name: 'AI分析' }],
    currentTabBar: 'toOverview', 
    tabList: [],
    tmp_Index : [{ status: 'toSetTab', name: '汇总' }, { status: 'toSetTab', name: '昨天' }, { status: 'toSetTab', name: '近7天' }, { status: 'toSetTab', name: '近30天' }],
    tmp_Rank : [{ status: 'toSetTab', name: '客户人数' }, { status: 'toSetTab', name: '订单量' }, { status: 'toSetTab', name: '互动频率' }, { status: 'toSetTab', name: '成交率区间' }],
    currentIndex: 0,
    currentRank: 0,
    is_more: 1,
    setCount: ['近7天', '近15天', '近30天'],
    count1: 0,
    count2: 0,
    count3: 0,
    count4: 0,
    setRank1: [],
    setRank2:[],
    tmp_rank1:['客户总数','新增客户'],
    tmp_rank2:['总跟进数','总成交数'],
    tmp_rank3:['昨天', '近7天', '近15天' , '近30天' , '全部'],
    tmp_rank4: ['1%-50%', '50%-100%', '全部'],
    rank1: [0, 4],
    rank2: 4,
    rank3: [0, 4],
    rank4: 2,
    nine: {
      new_client: 0,
      view_client: 0,
      mark_client: 0,
      chat_client: 0,
      sale_money: 0,
      sale_order: 0,
      share_count: 0,
      save_count: 0,
      thumbs_count: 0,
    },
    dataList:{
      page:1,
      total_page:'',
      total_count:'',
      list:[]
    },
    refresh:false,
    refreshAI:false,
    loading:false,
    loadingAI:false,
    aiList: {
      com: {},
      list: [],
      max: {},
      page:1,
      total_page:''
    }
  },
  onLoad: function () {
    util.showLoading();
    var that = this; 
    wx.hideShareMenu();
    let {tmp_Index,tmp_Rank,tabList,currentTabBar} = that.data;
    let tmp_title;
    if(currentTabBar == 'toOverview'){
      tabList = tmp_Index;
      tmp_title = 'Boss雷达';
    } else if(currentTabBar == 'toRank'){
      tabList = tmp_Rank;
      tmp_title = '销售排行';
    } else if(currentTabBar == 'toAnalysis'){ 
      tmp_title = 'AI分析';
    }
    wx.setNavigationBarTitle({
      title: tmp_title
    })
    getApp().getConfigInfo(false,false).then(() => {
      let tmp_userid = wx.getStorageSync("userid");
      if(tmp_userid){
        app.globalData.userid = tmp_userid;
        app.globalData.to_uid = tmp_userid;
      }
      that.setData({
        globalData: app.globalData,
        tabList
      }, function () {
        if(that.data.currentTabBar == 'toOverview'){
          that.toGetOverview();
        }
      })
    })
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    let {currentTabBar,currentRank} = that.data;
    app.globalData.configInfo = false;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        if(currentTabBar == 'toOverview'){
          that.setData({
            is_more:1,
          },function(){
            wx.showNavigationBarLoading();
            that.toGetOverview();
          })
        } else if(currentTabBar == 'toRank'){
          that.setData({
            refresh: false, 
          }, function () {
            wx.showNavigationBarLoading();
            if(currentRank == 0){
              that.toGetRankClients();
            } else if(currentRank == 1){
              that.toGetRankOrder();
            } else if(currentRank == 2){
              that.toGetRankInteraction();
            } else if(currentRank == 3){
              that.toGetRankRate();
            }
          })
        } else if(currentTabBar == 'toAnalysis'){
          that.setData({ 
            refreshAI:false, 
          },function(){
            that.toGetAI();
          })
        }
      })
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
    let that = this;
    let { loading, currentTabBar, currentRank} = that.data;
    if(currentTabBar == 'toRank'){
      let { page, total_page } = that.data.dataList;
      if (page != total_page && !loading) {
        that.setData({
          'dataList.page': parseInt(page) + 1,
          loading: false
        },function(){ 
          if(currentRank == 0){
            that.toGetRankClients();
          } else if(currentRank == 1){
            that.toGetRankOrder();
          } else if(currentRank == 2){
            that.toGetRankInteraction();
          } else if(currentRank == 3){
            that.toGetRankRate();
          }
        })
      }
    } else if(currentTabBar == 'toAnalysis'){ 
      let { loadingAI } = that.data;
      let { page, total_page } = that.data.aiList; 
      if (page != total_page && !loadingAI) { 
        that.setData({
          'aiList.page': parseInt(page) + 1,
          loadingAI: false
        },function(){
          that.toGetAI();
        }) 
      }
    }
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  toGetOverview: function () {
    var that = this;
    let { is_more, currentIndex } = that.data;
    let paramObj = {
      is_more: is_more,
      type: currentIndex
    }
    if(is_more == 1){
      util.showLoading();
    }
    bossModel.getOverview(paramObj).then((d) => {
      util.hideAll();
      if (is_more == 0) {
        let { nine } = d.data;
        for(let i in nine){ 
          if(!nine[i]){
            nine[i] = 0
          }
        }
        that.setData({
          nine
        })
      }
      if (is_more == 1) {
        let { nine, dealRate, orderMoney, newClient, askClient, markClient, interest, activity, activityBarGraph } = d.data;
        let tmpCountData = [
          { data: dealRate, type: 1 },
          { data: orderMoney, type: 2 },
          { data: newClient, type: 3 },
          { data: askClient, type: 4 },
          { data: markClient, type: 5 },
          { data: interest, type: 6 },
          { data: activity, type: 7 },
          { data: activityBarGraph, type: 8 },
        ]
        for(let i in nine){ 
          if(!nine[i]){
            nine[i] = 0
          }
        }
        that.setData({
          nine, dealRate, orderMoney, newClient, askClient, markClient, interest, activity, activityBarGraph,tmpCountData
        }, function () {
          for (let i in tmpCountData) {
            that.init_echart(tmpCountData[i].data, tmpCountData[i].type)
          }
        })
      }

    })
  },
  toGetRankClients: function () {
    var that = this;
    let {rank1,refresh,dataList} = that.data;
    let paramObj = {
      page: dataList.page,
      sign: rank1[0]*1 + 1,
      type: rank1[1]*1 + 1
    }
    if (!refresh) {
      util.showLoading();
    }
    bossModel.getRankClients(paramObj).then((d) => {
      util.hideAll(); 
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }   
      that.setData({
        dataList: newlist,
        refresh: false,
        loading: false
      })
    })
  },
  toGetRankOrder: function () {
    var that = this;
    let {rank2,refresh,dataList} = that.data;
    let paramObj = { 
      page: dataList.page,
      type: rank2*1 + 1
    }
    bossModel.getRankOrder(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }   
      that.setData({
        dataList: newlist,
        refresh: false,
        loading: false
      })

    })
  },
  toGetRankInteraction: function () {
    var that = this;
    let {rank3,refresh,dataList} = that.data;
    let paramObj = {
      page: dataList.page,
      sign: rank3[0]*1 + 1,
      type: rank3[1]*1 + 1
    }
    bossModel.getRankInteraction(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }   
      that.setData({
        dataList: newlist,
        refresh: false,
        loading: false
      })
    })
  },
  toGetRankRate: function () {
    var that = this;
    let {rank4,refresh,dataList} = that.data;
    let paramObj = { 
      page: dataList.page,
      type: rank4*1 + 1
    }
    bossModel.getRankRate(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }   
      that.setData({
        dataList: newlist,
        refresh: false,
        loading: false
      })

    })
  },
  toGetAI: function () {
    var that = this;
    let {refreshAI,aiList} = that.data;  
    let paramObj = {
      page: aiList.page
    }
    if (!refreshAI) {
      util.showLoading();
    }
    bossModel.getAi(paramObj).then((d) => {
      util.hideAll(); 
      let oldlist = aiList;
      let newlist = d.data;  
      //如果刷新,则不加载老数据
      if (!refreshAI) {
        newlist.com = [...oldlist.com, ...newlist.com];
        newlist.list = [...oldlist.list, ...newlist.list];
        newlist.max = [...oldlist.max, ...newlist.max];
      }   
      that.setData({
        aiList: newlist,
        refreshAI: false,
        'aiList.page':aiList.page
      },function(){
        let tmp_data_value = that.data.aiList.list;
        for(let i in tmp_data_value){
          that.init_echart(tmp_data_value[i].value_2, 9 + i*1)
        }
      })
    })
  },
  pickerSelected: function (e) {
    let that = this;
    let status = util.getData(e).status;
    let tmp_val = e.detail.value;
    let {rank1,rank2,rank3,rank4,currentRank} = that.data;
    // debugger;
    if(currentRank == 0){
      if (status == 'toRank1') {
        rank1[0] = tmp_val;
      }
      if (status == 'toRank2') {
        rank1[1] = tmp_val;
      }
      that.setData({
        rank1,
        dataList:{
          page:1,
          total_page:'',
          total_count:'',
          list:[]
        }, 
      },function(){
        that.toGetRankClients();
      })
    } else if(currentRank == 1){
      if (status == 'toRank3') {
        rank2 = tmp_val;
        that.setData({
          rank2,
          dataList:{
            page:1,
            total_page:'',
            total_count:'',
            list:[]
          }, 
        },function(){
          that.toGetRankOrder();
        })
      }
    } else if(currentRank == 2){
      if (status == 'toRank1') { 
        rank3[0] = tmp_val;
      }
      if (status == 'toRank2') {
        rank3[1] = tmp_val;
      }
      that.setData({
        rank3,
        dataList:{
          page:1,
          total_page:'',
          total_count:'',
          list:[]
        }, 
      },function(){
        that.toGetRankInteraction();
      }) 
    } else if(currentRank == 3){
      if (status == 'toRank3') {
        rank4 = tmp_val;
        that.setData({
          rank4,
          dataList:{
            page:1,
            total_page:'',
            total_count:'',
            list:[]
          }, 
        },function(){
          that.toGetRankRate();
        })
      }
    }
  },
  init_echart: function (tmpData, type) {
    var that = this;
    that.selectComponent('#mychart' + type).init(function (canvas, width, height) {
      const barChart = echarts.init(canvas, null, {
        width: width,
        height: height
      });
      if (type == 1) {
        barChart.setOption(that.getFunnelOption(tmpData));
      } else if (type == 6) {
        barChart.setOption(that.getPieOption(tmpData, type));
      } else if (type == 8) {
        barChart.setOption(that.geCategoryOption(tmpData, type));
      } else if (type >= 9) {
        barChart.setOption(that.geRadarOption(tmpData, type));
      } else {
        barChart.setOption(that.geLineOption(tmpData, type));
      }
      return barChart;
    })
  },
  getFunnelOption: function (tmpData) {
    var that = this;
    return {
      legend: {
        data: ['总用户数' + tmpData.client, '跟进数量' + tmpData.mark_client, '成交数量' + tmpData.deal_client],
        bottom: '0',
      },
      color: ["#91c7ae", "#d48265", "#c23531"],
      calculable: true,
      funnelAlign: 'left',
      series: [
        {
          name: '漏斗图',
          type: 'funnel',
          top: '10',
          bottom: '45',
          left: '20%',
          min: 40,
          max: 100,
          minSize: '40%',
          maxSize: '100%',
          width: '60%',
          sort: 'descending',
          legendHoverLink: true,
          gap: 2,
          label: {
            normal: {
              show: true,
              position: 'inside'
            },
            emphasis: {
              textStyle: {
                fontSize: 16
              }
            }
          },
          data: [
            {
              value: 100,
              name: '总用户数' + tmpData.client
            },
            {
              value: 80,
              name: '跟进数量' + tmpData.mark_client
            },
            {
              value: 60,
              name: '成交数量' + tmpData.deal_client
            },
          ]
        }
      ]
    }

  },
  getPieOption: function (tmpData) {
    var that = this;
    let tmp_legend = [];
    let tmp_data = [
      { value: tmpData.compony.number, name: tmpData.compony.rate + '%'},
      { value: tmpData.staff.number, name:  tmpData.staff.rate + '%'},
      { value: tmpData.goods.number, name:  tmpData.goods.rate + '%'}
    ]
    return {
      legend: {  
        bottom: 0,
        left: 'center', 
        data: tmp_legend
      },
      color:['#91c7ae','#d48265','#c23531'],
      series: [ 
          {
              name:'访问来源',
              type:'pie',
              radius: ['60%', '80%'], 
              center: ['50%', '60%'],
              data: tmp_data
          }
      ] 
    }
  },
  geCategoryOption: function (tmpData) {
    var that = this;
    let tmp_data_text = [];
    let tmp_data_number = [];
    for(let i in tmpData){
      tmp_data_text.push(tmpData[i].title)
      tmp_data_number.push(tmpData[i].number)
    }
    return {
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
      },
      color:["#91c7ae"],
      legend: {
        data: ['']
      },
      grid: {
        top:20,
        left: '3%',
        right: '5%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: {
        type: 'value',
        boundaryGap: [0, 0.01]
      },
      yAxis: [{
          type: 'category',
          data: tmp_data_text,
          axisLabel: {
              interval: 0,
              rotate: 0
          },
          splitLine: {
              show: false
          }
      }], 
      series: [
        {
        type: 'bar', 
        label: {
            normal: {
                position: 'right',
                show: true
            }
        }, 
          data: tmp_data_number
        },
      ]
    }
  },
  geRadarOption: function (tmpData, type) {
    var that = this; 
    let tmp_indicator = [];
    let tmp_series_data = [];
    let tmp_max = that.data.aiList.max;
    let tmp_radius = 50;
    if(type == 9){
      tmp_radius = 80;
    }
    if(type == 10 || type == 11){
      tmp_radius = 65;
    }
    for(let i in tmpData){
      if(type>9){
        tmp_indicator.push({text:'',max: parseFloat(tmp_max[i])})
      } else {
        tmp_indicator.push({text:tmpData[i].titlle,max: parseFloat(tmp_max[i])})
      }
      tmp_series_data.push(parseFloat(tmpData[i].value))
    }  
    return {
      legend: {
          x: 'center',
          data:['']
      },
      radar: [
          {
              indicator: tmp_indicator,
              center: ['50%','50%'],
              radius: tmp_radius
              // center: ['50%','60%'],
              // radius: 80
          }, 
      ],
      series: [
          { 
              type: 'radar',
              tooltip: {
                  trigger: 'item'
              }, 
              itemStyle: {normal: {areaStyle: {type: 'default'}}},
              data: [{value:tmp_series_data}]
          },  
      ]
    } 
  },
  geLineOption: function (tmpData, type) {
    var that = this;
    var tmpDateOption = [];
    var tmpOrderOption = [];
    var tmpMoneyOption = [];
    var tmpNumberOption = [];
    for (let i in tmpData) {
      tmpDateOption.push(tmpData[i].date);
      tmpOrderOption.push(tmpData[i].order_number);
      tmpMoneyOption.push(tmpData[i].money_number);
      tmpNumberOption.push(tmpData[i].number);
    }

    if (type == 2) {
      return {
        legend: {
          data: ['商城订单量', '交易金额']
        },
        color: ["#1774dc", "#e93636"], 
        grid: {
          top: '40',
          left: '3%',
          right: '5%',
          bottom: '10',
          containLabel: true
        },
        xAxis: [
          {
            type: 'category',
            boundaryGap: false,
            data: tmpDateOption
          }
        ],
        yAxis: [
          {
            type: 'value'
          }
        ],
        series: [
          {
            name: '商城订单量',
            type: 'line',
            stack: '总量',
            areaStyle: {},
            data: tmpOrderOption
          },
          {
            name: '交易金额',
            type: 'line',
            stack: '总量',
            areaStyle: {},
            data: tmpMoneyOption
          },
        ]
      }
    } else {
      return {
        legend: {
          data: []
        },
        color: ["#1774dc"], 
        grid: {
          top: '10',
          left: '3%',
          right: '5%',
          bottom: '10',
          containLabel: true
        },
        xAxis: [
          {
            type: 'category',
            boundaryGap: false,
            data: tmpDateOption
          }
        ],
        yAxis: [
          {
            type: 'value'
          }
        ],
        series: [
          {
            name: '',
            type: 'line',
            stack: '',
            areaStyle: {},
            data: tmpNumberOption
          },
        ]
      }
    }
  },
  toJump: function (e) {
    let that = this;
    let {status,index,type} = util.getData(e);
    let { orderMoney, newClient, askClient, markClient } = that.data;
    let tmpCountData = [];
    let tmpCurr; 
    let {rank1,rank2,rank3,rank4,currentRank} = that.data;
    if(status == 'toChangeRank'){ 
      if(currentRank == 0){ 
        if (type == 'toRank1') {
          rank1[0] = index;
        }
        if (type == 'toRank2') {
          rank1[1] = index;
        }
        that.setData({
          rank1,
          dataList:{
            page:1,
            total_page:'',
            total_count:'',
            list:[]
          }, 
        },function(){
          that.toGetRankClients();
        })
      } else if(currentRank == 1){
        if (type == 'toRank1') {
          rank2 = index;
          that.setData({
            rank2,
            dataList:{
              page:1,
              total_page:'',
              total_count:'',
              list:[]
            }, 
          },function(){
            that.toGetRankOrder();
          })
        }
      } else if(currentRank == 2){
        if (type == 'toRank1') { 
          rank3[0] = index;
        }
        if (type == 'toRank2') {
          rank3[1] = index;
        } 
        that.setData({
          rank3,
          dataList:{
            page:1,
            total_page:'',
            total_count:'',
            list:[]
          }, 
        },function(){
          that.toGetRankInteraction();
        }) 
      } else if(currentRank == 3){
        if (type == 'toRank1') {
          rank4 = index;
          that.setData({
            rank4,
            dataList:{
              page:1,
              total_page:'',
              total_count:'',
              list:[]
            }, 
          },function(){
            that.toGetRankRate();
          })
        }
      }
    } else if(status == 'toCount1' || status == 'toCount2' || status == 'toCount3' || status == 'toCount4'){
      if (index == 0) {
        tmpCurr = 23
      } else if (index == 1) {
        tmpCurr = 15
      } else if (index == 2) {
        tmpCurr = 0
      } 
      if (status == 'toCount1') {
        that.setData({
          count1: index
        })
      }
      if (status == 'toCount2') {
        that.setData({
          count2: index
        })
      }
      if (status == 'toCount3') {
        that.setData({
          count3: index
        })
      }
      if (status == 'toCount4') {
        that.setData({
          count4: index
        })
      }
      for (let i = tmpCurr; i < 30; i++) {
        if (type == 2) {
          tmpCountData.push(orderMoney[i])
        }
        if (type == 3) {
          tmpCountData.push(newClient[i])
        }
        if (type == 4) {
          tmpCountData.push(askClient[i])
        }
        if (type == 5) {
          tmpCountData.push(markClient[i])
        }
      }
      that.init_echart(tmpCountData, type);
    } else if(status == 'toJumpUrl'){
      if(type == 'currStaff'){
        let tmp_data = that.data.aiList.list;
        let staff_ai_data = tmp_data[index];
        staff_ai_data.rank = index*1 + 1;
        that.setData({
          staff_ai_data
        },function(){
          util.goUrl(e);
        })
      } else {
        util.goUrl(e);
      }
    }
  },
  formSubmit: function (e) {
    let that = this;
    let formId = e.detail.formId;
    let {status,index,type} = util.getFromData(e);
    let {is_more,tmp_Index,tmp_Rank,tabList,currentTabBar} = that.data;
    let tmp_title;
    if (status == 'toTabBar') {
      tmp_title = 'Boss雷达';
      currentTabBar = type;
      if(type == 'toOverview'){
        tabList = tmp_Index;
        is_more = 0;
        that.setData({
          tabList,
          is_more,
          currentTabBar,
        },function(){
          if(that.data.currentTabBar == 'toOverview'){
            let tmpCountData = that.data.tmpCountData;
            if(!tmpCountData){
              that.setData({
                is_more: 1,
              },function(){
                that.toGetOverview();
              })
            } else {
              for (let i in tmpCountData) {
                that.init_echart(tmpCountData[i].data, tmpCountData[i].type)
              }
            }
          }
        })
      } else if(type == 'toRank'){
        tmp_title = '销售排行';
        let {setRank1,setRank2,tmp_rank1,tmp_rank2,tmp_rank3,tmp_rank4,currentRank} = that.data;
        if(currentRank == 0){
          setRank1 = [tmp_rank1,tmp_rank3];
        } else if(currentRank == 1){
          setRank2 = tmp_rank3;
        } else if(currentRank == 2){
          setRank1 = [tmp_rank2,tmp_rank3];
        } else if(currentRank == 1){
          setRank2 = tmp_rank4;
        }
        tabList = tmp_Rank;
        that.setData({
          currentTabBar,
          tabList,
          setRank1,
          setRank2,
        },function(){ 
            if(currentRank == 0){
              that.toGetRankClients();
            } else if(currentRank == 1){
              that.toGetRankOrder();
            } else if(currentRank == 2){
              that.toGetRankInteraction();
            } else if(currentRank == 3){
              that.toGetRankRate();
            } 
        })
      } else if(currentTabBar == 'toAnalysis'){ 
        tmp_title = 'AI分析';
        that.setData({
          currentTabBar,
          aiList: {
            com: {},
            list: [],
            max: {},
            page:1,
            total_page:''
          },
          refreshAI:false,
          loadingAI:false
        },function(){
          that.toGetAI();
        })
      }
      wx.setNavigationBarTitle({
        title: tmp_title
      }) 
    } else if (status == 'toSetTab') {
      let currentTabBar = that.data.currentTabBar;
      if(currentTabBar == 'toOverview'){
        that.setData({
          currentIndex: index, 
          is_more: 0,
        },function(){
          that.toGetOverview();
        })
      } else if(currentTabBar == 'toRank'){
        console.log(index,"currentTabBar == 'toRank'")
        let {setRank1,setRank2,tmp_rank1,tmp_rank2,tmp_rank3,tmp_rank4} = that.data;
        if(index == 0){
          setRank1 = [tmp_rank1,tmp_rank3];
        } else if(index == 1){
          setRank2 = tmp_rank3;
        } else if(index == 2){
          setRank1 = [tmp_rank2,tmp_rank3];
        } else if(index == 3){
          setRank2 = tmp_rank4;
        }
        that.setData({
          currentRank: index,
          setRank1,
          setRank2
        },function(){
          if(index == 0){ 
            that.toGetRankClients();
          } 
          if(index == 1){ 
            that.toGetRankOrder();
          } 
          if(index == 2){ 
            that.toGetRankInteraction();
          } 
          if(index == 3){ 
            that.toGetRankRate();
          }
        })
      }
    } else if(status == 'toJumpUrl'){
      util.goUrl(e,true);
    }
    that.toSaveFormIds(formId);
  },
  toSaveFormIds: function (formId) {
    var that = this;
    let paramObj = {
      formId: formId
    }
    bossModel.getFormId(paramObj).then((d) => {
      util.hideAll();
    })
  },

});