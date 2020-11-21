var app = getApp();
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { baseModel } from '../../resource/apis/index.js'
Page({
  data:{ 
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu();
    that.setData({
      globalData: app.globalData
    },function(){
      that.getUserInfo();
    })
    wx.hideLoading();
  },
  onReady:function(){
    // 页面渲染完成
  },
  onShow:function(){
    // 页面显示
  },
  onHide:function(){
    // 页面隐藏
  },
  onUnload:function(){
    // 页面关闭
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    wx.showNavigationBarLoading();
    that.getUserInfo();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getUserInfo: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/userinfo',
      'cachetime': '30',
      
      'method': 'POST',
      'data': { 
      },
      success: function (res) {
        console.log("entry/wxapp/userinfo ==>", res)
        if (!res.data.errno) { 
          that.setData({
            userData: res.data.data
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopmyorder ==> fail ==> ", res)
      }
    })
  },
  toJump:function(e){
    var that = this;
    var {status} = util.getData(e);
    if(status == 'toJumpUrl'){
      util.goUrl(e)
    }  
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId; 
    let {status, index} = util.getFromData(e);
    if(status == 'toJumpUrl'){
      util.goUrl(e,true)
    }
    that.toSaveFormIds(formId);
  },
  toSaveFormIds: function (formId) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/formid',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        formId: formId
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }
})