
var app = getApp()
var echarts = require('../../../templates/ec-canvas/echarts');
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    setCount: [{ name: "今日" }, { name: "近7天" }, { name: "近30天" }, { name: "本月" }],
    count: 2,
    classify: 2,
    interaction: 2,
    opengid: '',
    orderType: 'time',
    showAddUseSec: false,
    groupPeople: {},
    groupRandData: [],
    setFunnelOption: {
      legend: [],
      data: [],
    },
    setPieOption: {
      legend: [],
      data: [],
    },
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    app.util.showLoading(1);
    var that = this;
    wx.hideShareMenu();
    
    if (options.opengid) {
      that.setData({
        opengid: options.opengid
      })
    }
    
    wx.hideShareMenu();
    that.getGroupPeople();
    that.getTurnoverRate();
    that.getInteraction();
    that.getGroupRank();

    that.barComponent = that.selectComponent('#mychart');
    that.barComponent2 = that.selectComponent('#mychart2');
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
    var that = this;
    that.getTurnoverRate();
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
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    that.getGroupPeople();
    that.getTurnoverRate();
    that.getInteraction();
    that.getGroupRank();
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")  
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  pickerSelected: function (e) {
    let that = this;
    let status = e.currentTarget.dataset.status;
    if (status == 'count') {
      that.setData({
        count: e.detail.value
      })
      that.getTurnoverRate();
    } else if (status == 'classify') {
      that.setData({
        classify: e.detail.value
      })
      that.getInteraction();
    } else if (status == 'interaction') {
      that.setData({
        interaction: e.detail.value
      })
      that.getGroupRank();
    }
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    } else if(status == 'toEditNum'){ 
      console.log("输入群成员数")
      app.util.goUrl(e)
    }
  }, 
  checkOrderType: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    that.setData({
      orderType: status,
      // groupRandData: []
    })
    that.getGroupRank();
  },
  getGroupPeople: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/groupPeople',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        openGId: that.data.opengid
      },
      success: function (res) {
        // console.log("entry/wxapp/groupPeople ==>", res)
        if (!res.data.errno) {
          let tmpData = res.data.data;
          var date = new app.util.date();
          var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);
          
          tmpData.last_time = parseInt(tmpData.last_time);
          console.log( tmpData.last_time," tmpData.last_time")
          if (!tmpData.last_time) {
            tmpData.last_time = ''
            tmpData.last_time_text = '暂无互动';
          } else {
            console.log("11111111111",tmpData.last_time,currentTime,currentTime - tmpData.last_time)
            tmpData.last_time = currentTime - tmpData.last_time;
            console.log("22222222222",tmpData.last_time,currentTime,currentTime - tmpData.last_time)
            var timelineD = parseInt(tmpData.last_time / (24 * 60 * 60));
            var timelineH = parseInt(tmpData.last_time / (60 * 60));
            if (timelineD > 0) {
              tmpData.last_time = timelineD;
              tmpData.last_time_text = '天前互动';
            } else {
              if (timelineH > 0) {
                tmpData.last_time = timelineH;
                tmpData.last_time_text = '小时前互动';
              } else {
                tmpData.last_time = '';
                tmpData.last_time_text = '暂无互动';
              }
            }
          }


          that.setData({
            groupPeople: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  getTurnoverRate: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/turnoverRate',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        openGId: that.data.opengid,
        type: that.data.count * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/turnoverRate ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data; 
          that.setData({
            setFunnelOption: tmpData
          })
          // console.log(that.data.setFunnelOption)
          that.init_funnel();
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  getInteraction: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/interaction',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        openGId: that.data.opengid,
        type: that.data.classify * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/interaction ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var tmpPieOption = {
            legend: [],
            data: [],
          };
          if (wx.getStorageSync("setPieOption")) {
            tmpPieOption = wx.getStorageSync("setPieOption");
            tmpPieOption = {
              legend: [],
              data: [],
            };
          }

          if (tmpData.goods.count != 0) {
            tmpPieOption.legend.push('产品' + tmpData.goods.count + '(' + tmpData.goods.rate + '%)');
            tmpPieOption.data.push({ value: tmpData.goods.rate, name: '产品' + tmpData.goods.count + '(' + tmpData.goods.rate + '%)' });
          }
          if (tmpData.timeline.count != 0) {
            tmpPieOption.legend.push('动态' + tmpData.timeline.count + '(' + tmpData.timeline.rate + '%)');
            tmpPieOption.data.push({ value: tmpData.timeline.rate, name: '动态' + tmpData.timeline.count + '(' + tmpData.timeline.rate + '%)' });
          }
          if (tmpData.card.count != 0) {
            tmpPieOption.legend.push('名片' + tmpData.card.count + '(' + tmpData.card.rate + '%)');
            tmpPieOption.data.push({ value: tmpData.card.rate, name: '名片' + tmpData.card.count + '(' + tmpData.card.rate + '%)' });
          }
          if (tmpData.qr.count != 0) {
            tmpPieOption.legend.push('名片码' + tmpData.qr.count + '(' + tmpData.qr.rate + '%)');
            tmpPieOption.data.push({ value: tmpData.qr.rate, name: '名片码' + tmpData.qr.count + '(' + tmpData.qr.rate + '%)' });
          }
          if (tmpData.custom_qr.count != 0) {
            tmpPieOption.legend.push('自定义码' + tmpData.custom_qr.count + '(' + tmpData.custom_qr.rate + '%)');
            tmpPieOption.data.push({ value: tmpData.custom_qr.rate, name: '自定义码' + tmpData.goods.count + '(' + tmpData.custom_qr.rate + '%)' });
          }

          if (tmpPieOption.legend.length == 0) {
            tmpPieOption.legend.push('暂无互动数据');
            tmpPieOption.data.push({ value: 100, name: '暂无互动数据' });
          }

          that.setData({
            setPieOption: tmpPieOption
          })

          that.init_pie();
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  getGroupRank: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/GroupRank',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        type: that.data.interaction * 1 + 1,
        order: that.data.orderType,
        openGId: that.data.opengid
      },
      success: function (res) {
        // console.log("entry/wxapp/GroupRank ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var date = new app.util.date();
          var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);

          for (let i in tmpData) {
            if (!tmpData[i].update_time) {
              tmpData[i].update_time = ''
            } else {
              tmpData[i].update_time = currentTime - tmpData[i].update_time;
              var extensionD = parseInt(tmpData[i].update_time / (24 * 60 * 60));
              var extensionH = parseInt(tmpData[i].update_time / (60 * 60));
              if (extensionD > 0) {
                tmpData[i].update_time = extensionD + '天前互动'
              } else {
                if (extensionH > 0) {
                  tmpData[i].update_time = extensionH + '小时前互动';
                } else {
                  tmpData[i].update_time = '';
                }
              }
            }
          }
          that.setData({
            groupRandData: tmpData
          })
          that.init_funnel();
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  init_funnel: function () {
    var that = this;
    that.barComponent.init(function (canvas, width, height) {
      const barChart = echarts.init(canvas, null, {
        width: width,
        height: height
      });
      barChart.setOption(that.getFunnelOption());
      return barChart;
    })
  },
  init_pie: function () {
    var that = this;
    that.barComponent2.init(function (canvas, width, height) {
      const barChart = echarts.init(canvas, null, {
        width: width,
        height: height
      });
      barChart.setOption(that.getPieOption());
      return barChart;
    })
  },
  getFunnelOption: function () {
    var that = this;
    return {
      backgroundColor: "#ffffff",
      color: ["#37a2da", "#32c4e9", "#66e0e3", "#91f2de", "#fedb5b"],
      calculable : true,
      series : [
        {
              name: '推广统计',
              type: 'funnel',
              left: '10%',
              top: 20,
              bottom: 40,
              width: '60%',
              height:'80%',
              min: 20,
              max: 100,
              minSize: '20%',
              maxSize: '100%',
              sort: 'descending',
              gap: 2, 
              data:[
                {
                  value:100,
                  name:'群成员数' + that.data.setFunnelOption.number
                },
                {
                  value:80,
                  name:'引流人数' + that.data.setFunnelOption.users
                },
                {
                  value:60,
                  name:'咨询人数' + that.data.setFunnelOption.chats
                },
                {
                  value:40,
                  name:'跟进人数' + that.data.setFunnelOption.follows
                },
                {
                  value:20,
                  name:'成交人数' + that.data.setFunnelOption.deals
                }
              ]  
          }
      ] 
    }
  },
  getPieOption: function () {
    var that = this;
    return {
      legend: {
        orient: 'vertical',
        top: '10%',
        right: '10%',
        data: that.data.setPieOption.legend
      },
      series: [{
        name: '互动分类',
        type: 'pie',
        center: ['30%', '47%'],
        radius: ['55%', '75%'],
        avoidLabelOverlap: false,
        label: {
          normal: {
            show: false,
            position: 'center'
          },
        },
        data: that.data.setPieOption.data
      }]
    }
  }

})
