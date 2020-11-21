var app = getApp();
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { userModel } from '../../../resource/apis/index.js'
Page({
  data:{
    globalData: {},
    activeIndex: 0,
    showMoreStatus: 0,
    shopTypes:{}
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    wx.hideShareMenu();
    util.showLoading(); 
    that.setData({
      to_uid: options.to_uid,
      globalData: app.globalData
    },function(){
      that.getShopTypes(); 
    })
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
    that.getShopTypes();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getShopTypes: function () {
    var that = this;
    util.showLoading();
    let paramObj = {
      type: that.data.currentIndex,
      to_uid: that.data.to_uid
    }
    userModel.getShopTypes(paramObj).then((d) => {
      util.hideAll();
      console.log(d.data)
      let shop_type = d.data.shop_type;
      that.setData({
        shop_type
      })
    })
  },  
  scroll: function(e) {
    // console.log(e) 
    var that = this;
    that.setData({
      // toLeftView: 'scrollLeft1',
      toRightView: 'scrollRight1',
    })
  },
  toTabClickJump:function(categoryid){
    var that = this;
    console.log('toTabClickJump ==>')
    that.setData({
      toRightView: 'scrollRight' + categoryid
    })
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    var type = e.currentTarget.dataset.type;
    var id = e.currentTarget.dataset.id;
    var index = e.currentTarget.dataset.index;
    var categoryid = e.currentTarget.dataset.categoryid;
    var tmpData = that.data.shop_type;
    
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    } 

    if(status == 'toShowMore'){
      var showMoreStatus = that.data.showMoreStatus;
      if(type == 0 ){
        console.log("显示更多")
        showMoreStatus = 1;
      } else if(type == 1 ){
        console.log("隐藏显示更多")
        showMoreStatus = 0;
      }
      that.setData({
        showMoreStatus : showMoreStatus
      })
    } else if(status == 'toSearch' || status == 'toMore' || status == 'toNavProduct'){
      console.log("搜索 || 查看更多 || 产品分类")
      if(status == 'toMore' || status == 'toNavProduct'){
        console.log("查看更多 || 产品分类")
        var tmpNavTypes = tmpData[index];
        wx.setStorageSync("navTypes",tmpNavTypes)
      }
      app.util.goUrl(e)
    } else if(status == 'toTabClick'){
      console.log("类别选择")
      that.setData({
        activeIndex : index,
        toLeftView: 'scrollLeft' + categoryid
      })
      that.toTabClickJump(categoryid);
    }
  }
})