var app = getApp() 
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel,userModel } from '../../../resource/apis/index.js'
Page({
  data: { 
    globalData: {}, 
    refresh: false
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(options,"dddddddddddddd  options ***/");
    var that = this; 

    var paramData = {};

    if (options.id) {
      paramData.id = options.id;
    }    
    if (options.type) {
      paramData.type = options.type;
    }    
    if (options.name) {
      paramData.name = options.name;
      wx.setNavigationBarTitle({
        title: options.name
      })
    }    
    if (options.status) {
      paramData.status = options.status;
      // if(options.status == 'toPlayVideo'){
      //   wx.hideShareMenu();
      // }
    }
    if (options.src) {
      paramData.src = options.src;
    }
    if (options.table_name) {
      paramData.table_name = options.table_name;
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
    if(that.data.paramData.status != 'toPlayVideo'){
      util.showLoading();
      that.getModularInfo();
    }
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
    let that = this;
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    that.setData({
      refresh: true
    }, function () {
      wx.showNavigationBarLoading();
      that.getModularInfo();
    }) 
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分_享
    var that = this;
    if (res.from === 'button') {
      console.log("来自页面内转发按钮");
    }
    else {
      console.log("来自右上角转发菜单")
    }
    let tmp_path = '/longbing_card/pages/company/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&id=' + that.data.paramData.id + '&type=' + that.data.paramData.type + '&name=' + that.data.paramData.name + '&table_name=' + that.data.paramData.table_name;

    console.log(tmp_path,"tmp_path")
    if(that.data.paramData.status == 'toPlayVideo'){
      tmp_path = '/longbing_card/pages/company/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&status=toPlayVideo&name=' + that.data.paramData.name + '&src=' + that.data.paramData.src;
    } 
    return {
      title: '',
      path: tmp_path,
      imageUrl: ''
    };
  }, 
  getModularInfo: function () {
    var that = this;
    let refresh = that.data;
    let {id,table_name} = that.data.paramData;
    if(!refresh){
      util.showLoading();
    }
    let paramObj = {
      id: id,
      table_name: table_name
    }
    userModel.getModularInfo(paramObj).then((d) => {
        util.hideAll(); 
        let detailData =d.data;
        let date = new app.util.date();
        detailData.create_time = date.dateToStr('MM月DD日', date.longToDate(detailData.create_time * 1000)); 
        that.setData({
          detailData 
        })
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var content = e.currentTarget.dataset.content;
    
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    }
    if (status == 'toCall') {
      console.log("联系HR")
      if (!content) {
        return false;
      } else {
        wx.makePhoneCall({
          phoneNumber: content
        });
      }
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toHome') {
      console.log("回到首页")
      wx.reLaunch({
        url: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + app.globalData.from_id + '&currentTabBar=toCard'
      })
    }
  },
  toSaveFormIds: function (formId) {
    var that = this;
    let paramObj = {
      formId: formId
    }
    baseModel.getFormId(paramObj).then((d) => {
        util.hideAll();
    }) 
  }
})