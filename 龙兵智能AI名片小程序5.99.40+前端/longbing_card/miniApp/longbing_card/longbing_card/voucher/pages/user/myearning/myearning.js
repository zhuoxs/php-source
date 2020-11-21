var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel, userModel } from '../../../../resource/apis/index.js'
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: {
    dataList:{},
    refresh: false,
    loading: true
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this; 
    wx.hideShareMenu();
    that.toGetMyEarning();
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
    that.setData({
      refresh: true,
      // 'paramType.user_info': 1,
    }, function () {
      wx.showNavigationBarLoading()
      // that.getPosterType();
    })
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  }, 
  toGetMyEarning: function () {
    var that = this;
    let { refresh } = that.data;
    if (!refresh) {
      util.showLoading();
    }
    userModel.getMyEarning().then((d) => {
      util.hideAll();
      let dataList = d.data; 
      that.setData({
        dataList,
        refresh: false
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