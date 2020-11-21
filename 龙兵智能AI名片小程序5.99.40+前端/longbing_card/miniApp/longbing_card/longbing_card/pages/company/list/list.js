var app = getApp()
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    dataList: [],
    globalData: {},
    page: 1,
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu();

    var paramData = {};

    if (options.type) {
      paramData.type = options.type;
      if (options.type == 1) {
        wx.showShareMenu();
      }
    }
    if (options.name) {
      paramData.name = options.name;
      wx.setNavigationBarTitle({
        title: options.name
      })
    }
    if (options.table_name) {
      paramData.table_name = options.table_name;
    }
    if (options.identification) {
      paramData.identification = options.identification;
    }
    
    if(options.to_uid){
      paramData.to_uid = options.to_uid; 
      app.globalData.to_uid = options.to_uid;
    }
    if(options.from_id){ 
      paramData.from_id = options.from_id;
      app.globalData.from_id = options.from_id;
    }

    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })

    that.getListData();
    wx.hideLoading();
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
    var that = this;
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    that.setData({
      dataList: [],
      page: 1,
      more: true,
      loading: false,
      isEmpty: false,
      show: false,
    })
    that.getListData();
    setTimeout(() => {
      wx.showNavigationBarLoading();
      wx.stopPullDownRefresh();
    }, 1000);
  },
  onReachBottom: function () {
    // 页面上拉触底
    var that = this;
    that.setData({
      show: true
    })
    if (that.data.isEmpty == false) {
      that.setData({
        page: that.data.page + 1
      })
      that.getListData();
    }
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分_享
    var that = this;
    if (that.data.paramData.type == 1) {
      if (res.from === 'button') {
        console.log("来自页面内转发按钮");
      }
      else {
        console.log("来自右上角转发菜单", that.data.paramData.name)
      }
      return {
        title: '',
        path: '/longbing_card/pages/company/list/list?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&type=' + that.data.paramData.type + '&name=' + that.data.paramData.name + '&table_name=' + that.data.paramData.table_name + '&identification=' + that.data.paramData.identification,
        imageUrl: ''
      };
    }
  },
  getListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/modularList',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page,
        identification: that.data.paramData.identification
      },
      success: function (res) {
        console.log("entry/wxapp/modularList ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data.list;
          if (tmpData.length == 0) {
            that.setData({
              more: false,
              loading: false,
              isEmpty: true,
              show:true
            })
            return false;
          }

          var tmpListData = that.data.dataList;
          for (let i in tmpData) {
            var date = new app.util.date();
            if (tmpData[i].create_time.length < 12) {
              tmpData[i].create_time = date.dateToStr('yyyy-MM-DD', date.longToDate(tmpData[i].create_time * 1000));
            }
            tmpListData.push(tmpData[i]);
          }

          that.setData({
            dataList: tmpListData,
            loading: true
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var id = e.currentTarget.dataset.id;
    var status = e.currentTarget.dataset.status;
    var content = e.currentTarget.dataset.content;
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    }
 
    if (that.data.paramData.type == 5) {
      return false; 
    } else  if (that.data.paramData.type == 7) {
      wx.navigateTo({
        url: content
      })
    } else {
      wx.navigateTo({
        url: '/longbing_card/pages/company/detail/detail?table_name=' + that.data.paramData.table_name + '&type=' + that.data.paramData.type + '&id=' + id + '&name=' + that.data.paramData.name
      })
    }
  } 
})