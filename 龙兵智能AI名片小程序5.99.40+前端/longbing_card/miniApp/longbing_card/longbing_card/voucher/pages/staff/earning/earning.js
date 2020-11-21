var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel } from '../../../../resource/apis/index.js'
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: { 
    tabList: [{status:'toSetTab',name:'总收排序'},{status:'toSetTab',name:'客户人数'}],
    currentIndex: 0,
    useStatus:{
      show: true,
      status: 'unreceive',
    }
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    that.setData({
      globalData: app.globalData
    })
    wx.hideShareMenu();
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
  toCloseVoucher:function(){
    let that = this; 
    voucher.toCloseVoucher(that);
  },
  toJump: function (e) {
    var that = this;
    let {status} = util.getData(e);
    if(status == 'toUseVoucher'){
      that.setData({
        'useStatus.show': true,
        'useStatus.status': 'receive',
      })
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