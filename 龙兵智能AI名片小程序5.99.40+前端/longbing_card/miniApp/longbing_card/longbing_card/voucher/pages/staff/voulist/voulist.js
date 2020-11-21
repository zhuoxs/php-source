var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel, staffModel } from '../../../../resource/apis/index.js'
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: { 
    dataList: {
      page: 1,
      total_page: '',
      list: [],
      refresh: false,
      loading: true,
    },
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        that.toGetStaffCouponList();
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
    app.globalData.configInfo = false;
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData
      }, function () {
        that.setData({
          'dataList.page':1,
          'dataList.refresh':true,
        }, function () {
          wx.showNavigationBarLoading();
          that.toGetStaffCouponList();
        })
      })
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
    let that = this;
    let { dataList } = that.data;
    if (dataList.page != dataList.total_page && !dataList.loading) {
      that.setData({
        'dataList.page': parseInt(dataList.page) + 1,
        'dataList.loading': false
      }, function () {
        that.toGetStaffCouponList();
      })
    }
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  }, 
  toGetStaffCouponList: function () {
    var that = this;
    let { dataList } = that.data;
    let paramObj = {
      page: parseInt(dataList.page)
    } 
    if (!dataList.refresh) {
      util.showLoading();
    }
    staffModel.getStaffCouponList(paramObj).then((d) => {
      util.hideAll();
      let oldlist = dataList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!dataList.refresh) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      newlist.refresh = false;
      newlist.loading = false;
      that.setData({
        dataList: newlist
      })
    })
  }, 
  toJump: function (e) {
    var that = this;
    let {status} = util.getData(e);
    if(status == 'toJumpUrl'){
      util.goUrl(e);
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    let {index, status} = util.getFromData(e); 
    if(status == 'toSetTab'){
      that.setData({
        currentIndex: index
      })
    }
    that.toSaveFormIds(formId); 
    // app.util.goUrl(e, true) 
  },
  toSaveFormIds: function (formId) {
    var that = this;
    let paramObj = {
      formId: formId
    }
    baseModel.getFormId(paramObj).then((d) => {
      // util.hideAll();
    })
  }
}) 