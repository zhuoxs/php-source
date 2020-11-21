
var app = getApp();
import util from '../../../../resource/js/xx_util.js';
import { baseModel, bossModel } from '../../../../resource/apis/index.js'
var echarts = require('../../../../templates/ec-canvas/echarts');
Page({
  data: {
    tabList: [{ status: 'toSetTab', name: '雷达能力图' }, { status: 'toSetTab', name: '数据分析' }, { status: 'toSetTab', name: '客户互动' }, { status: 'toSetTab', name: 'TA的跟进' }], 
    currentIndex: 0,
    setCount: ['汇总', '昨天', '近7天', '近30天'],
    count: 0,
    is_more: 1,
    currentRadarTime:'',
    viewList: {
      page: 1,
      total_page: '',
      list: [],
      refresh: false,
      loading: false,
    },
    followList: {
      page: 1,
      total_page: '',
      list: [],
      refresh: false,
      loading: false,
    },
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
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    let { id } = options;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData,
        staff_id: id
      }, function () { 
        that.toGetStaffNumber();
        var currPage = getCurrentPages(); 
        var prevPage = currPage[currPage.length - 2].__viewData__;
        let staff_ai_data = prevPage.staff_ai_data;
        let max = prevPage.aiList.max; 

        let tmp_title = staff_ai_data.info.name;
        if(!tmp_title){
          tmp_title = staff_ai_data.nickName;
        }

        console.log(staff_ai_data)
        wx.setNavigationBarTitle({
          title: tmp_title + '员工'
        })
        that.setData({
          staff_ai_data,
          max
        },function(){
          that.init_echart(staff_ai_data.value_2, 1)
        })
      })
    })
  },
  onReady: function () {
    // console.log("页面渲染完成") 
  },
  onShow: function () {
    // 页面显示  
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")  
    let that = this;
    let { currentIndex } = that.data;
    app.globalData.configInfo = false;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        wx.showNavigationBarLoading();
        if(currentIndex == 0){ 
          that.toGetStaffNumber(); 
        } else if(currentIndex == 1){
          that.setData({
            is_more: 1,
          }, function () {
            that.toGetStaffEchart();
          }) 
        } else if(currentIndex == 2){
          that.setData({ 
            'viewList.refresh': true,
            'viewList.page': 1,
          }, function () {
            that.toGetStaffView();
          })
        } else if(currentIndex == 3){
          that.setData({ 
            'followList.refresh': true,
            'followList.page': 1,
          }, function () {
            that.toGetStaffFollow();
          })
        } 
      })
    })
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")
    let that = this; 
    let { currentIndex, viewList, followList } = that.data; 
    if(currentIndex == 2){
      if (viewList.page != viewList.total_page && !viewList.loading) {
        that.setData({
          'viewList.page': parseInt(viewList.page) + 1,
          'viewList.loading': false
        }, function () {
          that.toGetStaffView();
        })
      }
    } else if(currentIndex == 3){
      if (followList.page != followList.total_page && !followList.loading) {
        that.setData({
          'followList.page': parseInt(followList.page) + 1,
          'followList.loading': false
        }, function () {
          that.toGetStaffFollow();
        })
      }
    }
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  toGetStaffNumber:function(){
    let that = this;
    let { staff_id } = that.data;
    let paramObj = { 
      staff_id: staff_id
    }
    bossModel.getStaffNumber(paramObj).then((d) => {
      util.hideAll();
      let staff_info = d.data;
      that.setData({
        staff_info
      })
    })
  },
  toGetStaffEchart:function(){
    let that = this;
    let { staff_id, is_more, count } = that.data;
    let paramObj = {
      is_more: is_more,
      type: count,
      staff_id: staff_id
    }
    if(is_more == 1){
      util.showLoading();
    }
    bossModel.getStaffEchart(paramObj).then((d) => {
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
        let { nine, dealRate, interest, activity, activityBarGraph } = d.data;
        let tmpCountData = [
          { data: dealRate, type: 2 }, 
          { data: interest, type: 3 },
          { data: activity, type: 4 },
          { data: activityBarGraph, type: 5 },
        ]
        for(let i in nine){ 
          if(!nine[i]){
            nine[i] = 0
          }
        }
        that.setData({
          nine, dealRate, interest, activity, activityBarGraph,tmpCountData
        }, function () { 
          for (let i in tmpCountData) {
            that.init_echart(tmpCountData[i].data, tmpCountData[i].type)
          }
        })
      }
    })
  },
  toGetStaffView:function(){
    let that = this;
    let { staff_id, viewList, currentRadarTime} = that.data;
    let paramObj = {
      page: viewList.page, 
      staff_id: staff_id, 
    }
    if(!viewList.refresh){
      util.showLoading();
    }
    bossModel.getStaffView(paramObj).then((d) => {
      util.hideAll(); 
      let oldlist = viewList;
      let newlist = d.data; 
      //如果刷新,则不加载老数据
      if (!viewList.refresh) { 
        newlist.list = [...oldlist.list, ...newlist.list]; 
      }

      
      let tmpData = newlist.list;
      let date = new app.util.date();
      for (let i in tmpData) {
        if (tmpData[i].create_time) {
          tmpData[i].create_time1 = date.dateToStr('YY/MM/DD', date.longToDate(tmpData[i].create_time * 1000));
          tmpData[i].create_time2 = date.dateToStr('HH:mm', date.longToDate(tmpData[i].create_time * 1000));
        }

        if (tmpData[i].sign == 'praise') {
          if (tmpData[i].type == 2) {
            // console.log("查看名片")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，TA正在了解你'
            }
            if (tmpData[i].count == 2 || tmpData[i].count == 3 || tmpData[i].count == 4) {
              tmpData[i].countText = '，你成功的吸引了TA'
            } 
            if (tmpData[i].count > 4) {
              tmpData[i].countText = '，高意向客户立刻主动沟通'
            }
          }
        }

        if (tmpData[i].sign == 'view') {
          if (tmpData[i].type == 1) {
            // console.log("查看商城列表"")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，尽快把握商机'
            }
            if (tmpData[i].count == 2) {
              tmpData[i].countText = '，潜在购买客户'
            } 
            if (tmpData[i].count == 3) {
              tmpData[i].countText = '，高意向客户成交在望'
            }
            if (tmpData[i].count > 3) {
              tmpData[i].countText = '，购买欲望强烈'
            } 
          }
          if (tmpData[i].type == 3 || tmpData[i].type == 6) {
            // console.log("查看动态列表"")
            if (tmpData[i].count == 2) {
              tmpData[i].countText = '，赶快主动沟通'
            } 
            if (tmpData[i].count > 2) {
              tmpData[i].countText = '，高意向客户成交在望'
            } 
          }
          if (tmpData[i].type == 6) {
            // console.log("查看公司官网")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，看来TA对公司感兴趣'
            }  
          }
        }
        if(!currentRadarTime){
          currentRadarTime = tmpData[0].create_time1;
        }
        if(currentRadarTime == tmpData[i].create_time1){
          tmpData[i].showTime = 1
        }
        if(i>0){
          if(tmpData[i].create_time1 != tmpData[i-1].create_time1){
            currentRadarTime = tmpData[i].create_time1;
            tmpData[i].showTime = 1;
          } else {
            tmpData[i].showTime = 0;
          }
        }
      } 
      
      that.setData({
        viewList: newlist, 
        'viewList.page':viewList.page,
        'viewList.refresh': false, 
      })
    }) 
  },
  toGetStaffFollow:function(){
    let that = this;
    let { staff_id, followList, currentRadarTime} = that.data;
    let paramObj = {
      page: followList.page, 
      staff_id: staff_id, 
    }
    if(!followList.refresh){
      util.showLoading();
    }
    bossModel.getStaffFollow(paramObj).then((d) => {
      util.hideAll(); 
      let oldlist = followList;
      let newlist = d.data; 
      //如果刷新,则不加载老数据
      if (!followList.refresh) { 
        newlist.list = [...oldlist.list, ...newlist.list]; 
      }

      
      let tmpData = newlist.list;
      let date = new app.util.date();
      for (let i in tmpData) {
        if (tmpData[i].create_time) {
          tmpData[i].create_time1 = date.dateToStr('YY/MM/DD', date.longToDate(tmpData[i].create_time * 1000));
          tmpData[i].create_time2 = date.dateToStr('HH:mm', date.longToDate(tmpData[i].create_time * 1000));
        }

        if (tmpData[i].sign == 'praise') {
          if (tmpData[i].type == 2) {
            // console.log("查看名片")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，TA正在了解你'
            }
            if (tmpData[i].count == 2 || tmpData[i].count == 3 || tmpData[i].count == 4) {
              tmpData[i].countText = '，你成功的吸引了TA'
            } 
            if (tmpData[i].count > 4) {
              tmpData[i].countText = '，高意向客户立刻主动沟通'
            }
          }
        }

        if (tmpData[i].sign == 'view') {
          if (tmpData[i].type == 1) {
            // console.log("查看商城列表"")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，尽快把握商机'
            }
            if (tmpData[i].count == 2) {
              tmpData[i].countText = '，潜在购买客户'
            } 
            if (tmpData[i].count == 3) {
              tmpData[i].countText = '，高意向客户成交在望'
            }
            if (tmpData[i].count > 3) {
              tmpData[i].countText = '，购买欲望强烈'
            } 
          }
          if (tmpData[i].type == 3 || tmpData[i].type == 6) {
            // console.log("查看动态列表"")
            if (tmpData[i].count == 2) {
              tmpData[i].countText = '，赶快主动沟通'
            } 
            if (tmpData[i].count > 2) {
              tmpData[i].countText = '，高意向客户成交在望'
            } 
          }
          if (tmpData[i].type == 6) {
            // console.log("查看公司官网")
            if (tmpData[i].count == 1) {
              tmpData[i].countText = '，看来TA对公司感兴趣'
            }  
          }
        }
        if(!currentRadarTime){
          currentRadarTime = tmpData[0].create_time1;
        }
        if(currentRadarTime == tmpData[i].create_time1){
          tmpData[i].showTime = 1
        }
        if(i>0){
          if(tmpData[i].create_time1 != tmpData[i-1].create_time1){
            currentRadarTime = tmpData[i].create_time1;
            tmpData[i].showTime = 1;
          } else {
            tmpData[i].showTime = 0;
          }
        }
      } 

      that.setData({
        followList: newlist, 
        'followList.page':followList.page,
        'followList.refresh': false, 
      })
    }) 
  },
  init_echart: function (tmpData, type) {
    var that = this; 
    that.selectComponent('#mychart' + type).init(function (canvas, width, height) {
      const barChart = echarts.init(canvas, null, {
        width: width,
        height: height
      }); 
      if (type == 1) {
        barChart.setOption(that.geRadarOption(tmpData));
      } else if (type == 2) {
        barChart.setOption(that.getFunnelOption(tmpData));
      } else if (type == 3) {
        barChart.setOption(that.getPieOption(tmpData, type));
      } else if (type == 4) {
        barChart.setOption(that.geLineOption(tmpData, type));
      } else if (type == 5) {
        barChart.setOption(that.geCategoryOption(tmpData, type));
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
  geRadarOption: function (tmpData) {
    var that = this; 
    let tmp_indicator = [];
    let tmp_series_data = [];
    let tmp_max = that.data.max; 
    for(let i in tmpData){ 
      tmp_indicator.push({text:tmpData[i].titlle,max: parseFloat(tmp_max[i])})
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
              radius: 80 
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
  geLineOption: function (tmpData) {
    var that = this;
    var tmpDateOption = []; 
    var tmpNumberOption = [];
    for (let i in tmpData) {
      tmpDateOption.push(tmpData[i].date); 
      tmpNumberOption.push(tmpData[i].number);
    }
 
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
  },
  toJump: function (e) {
    let that = this;
    let {status,index,type} = util.getData(e);
    if(status == 'toJumpUrl'){
      util.goUrl(e);
    } else if(status == 'toCount'){ 
      that.setData({
        count: index,
        is_more:0
      },function(){
        that.toGetStaffEchart();
      })
    }
  },
  formSubmit: function (e) {
    let that = this;
    let formId = e.detail.formId;
    let {status,index,type} = util.getFromData(e); 
    if (status == 'toSetTab') {
      that.setData({
        currentIndex: index
      },function(){
        if(index == 0){
          let {staff_ai_data} = that.data; 
          that.init_echart(staff_ai_data.value_2, 1)  
        } else if(index == 1){
          let tmpCountData = that.data.tmpCountData;
          if(!tmpCountData){
            that.setData({
              is_more: 1,
            },function(){
              that.toGetStaffEchart();
            })
          } else {
            for (let i in tmpCountData) {
              that.init_echart(tmpCountData[i].data, tmpCountData[i].type)
            }
          } 
        } else if(index == 2){
          that.setData({
            'viewList.page': 1,
            'viewList.refresh': true,
          },function(){
            that.toGetStaffView();
          })
        } else if(index == 3){
          that.setData({
            'followList.page': 1,
            'followList.refresh': true
          },function(){
            that.toGetStaffFollow();
          })
        }
      })
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
})