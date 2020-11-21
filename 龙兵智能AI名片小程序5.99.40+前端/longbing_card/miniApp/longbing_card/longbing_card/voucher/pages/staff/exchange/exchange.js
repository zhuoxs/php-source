var app = getApp(); 
import util from '../../../../resource/js/xx_util.js';
import { baseModel, staffModel } from '../../../../resource/apis/index.js'
var voucher = require('../../../../templates/voucher/voucher.js')
Page({
  data: { 
    voucherStatus:{
      show: true,
      status: 0,
    },
    dataList: {},
    refresh: false,
    loading: true,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    let that = this;
    wx.hideShareMenu();
    let paramObj = {};
    if(options.id){
      paramObj.coupon_id = options.id
    }
    getApp().getConfigInfo(false,false).then(() => {
      that.setData({
        globalData: app.globalData,
        paramObj
      }, function () {
        that.toGetCouponUserList();
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
          refresh: true,
        }, function () {
          wx.showNavigationBarLoading();
          that.toGetCouponUserList();
        })
      })
    })
  },
  onReachBottom: function () {
    // 页面上拉触底 
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  }, 
  toGetCouponUserList: function () {
    var that = this;
    let { paramObj, refresh } = that.data; 
    if (!refresh) {
      util.showLoading();
    }
    staffModel.getCouponUserList(paramObj).then((d) => {
      util.hideAll();  
      let dataList = d.data;
      that.setData({
        dataList,
        refresh: false
      })
    })
  },
  toCloseVoucher:function(){
    let that = this; 
    voucher.toCloseVoucher(that);
  },
  toJump: function (e) {
    var that = this;
    let {status} = util.getData(e);
    if(status == 'toExchangeBtn'){
      wx.scanCode({
        success (res) {
          let paramObj = JSON.parse(res.result);
          console.log(res,paramObj,"toExchangeBtn  wx.scanCode")
          wx.showModal({
            title: '',
            content: '是否要核销此优惠券(满'+ paramObj.full +'元减'+ paramObj.reduce +'元)？',
            success: function(res) {
              if(res.confirm){ 
                staffModel.getCouponClean(paramObj).then((d) => {
                  util.hideAll(); 
                  let tmp_message = d.message;
                  wx.showModal({
                    title: '',
                    content: tmp_message,
                    showCancel:false,
                    success: function(res) {
                      if(res.confirm){
                      }
                    }
                  })
                })
              }
            }
          })
        }
      })
    } else if(status == 'toUseVoucher'){
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