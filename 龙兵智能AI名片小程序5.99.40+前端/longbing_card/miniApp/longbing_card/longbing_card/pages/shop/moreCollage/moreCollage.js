var app = getApp(); 
import util from '../../../resource/js/xx_util.js';
import { userModel } from '../../../resource/apis/index.js'
var timerLeftTime;
Page({
  data:{
    globalData: {},
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu();
    var paramData = {};
    if(options.id){
      paramData.detailID = options.id;
    }
    if(options.to_uid){
      paramData.to_uid = options.to_uid;
    }
    if(wx.getStorageSync("moreCollageData")){
      paramData.data = wx.getStorageSync("moreCollageData")
    }
    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })
    that.getCollageList();
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
    clearInterval(timerLeftTime);
  },
  onUnload:function(){
    // 页面关闭
    clearInterval(timerLeftTime);
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    wx.showNavigationBarLoading();
    that.getCollageList();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getCollageList: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopcollagelist',
      'cachetime': '30', 
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID
      },
      success: function (res) {
        console.log("entry/wxapp/shopcollagelist ==>", res)
        if (!res.data.errno) {
          var tmpResData = res.data.data;
          var dateUtil = new app.util.date();
          var tmpTimes = [];
          var tmpData = [];
          for (let i in tmpResData) {
            if(tmpResData[i].left_number > 0){
              tmpData.push(tmpResData[i])
            } 
          }
          for(let i in tmpData){ 
            var tmpTime = tmpData[i].left_time;
            // timerLeftTime = setInterval(() => { 
            //   tmpTime = tmpTime - 1; 
              let day = parseInt(tmpTime / 24 / 60 / 60);
              day = day > 0 ? day + '天 ' : '';
              tmpTimes[i] = day +  dateUtil.dateToStr('HH:mm', dateUtil.longToDate(tmpTime * 1000));
              if (tmpTime == 0) {
                tmpData.splice(i, 1);
                tmpTimes.splice(i, 1);
              }
              that.setData({
                tmpTimes: tmpTimes
              });
            // }, 1000);
          }
          that.setData({
            collageList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcollagelist ==> fail ==> ", res)
      }
    })
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    } else if(status == 'toReleaseCollage'){
      console.log("去拼单")
      app.util.goUrl(e)
    }
  }
})