var app = getApp()
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    globalData: {},
    companyData: {
      list: {}
    },
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    app.util.showLoading(1);
    var that = this;

    var paramData = {};

    if (options.type) {
      paramData.type = options.type;
    }
    if (options.name) {
      paramData.name = options.name;
      wx.setNavigationBarTitle({
        title: options.name
      })
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
    
    that.getContactData();
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
    var that = this;
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
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
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
      console.log("来自右上角转发菜单", that.data.paramData.name)
    }
    return {
      title: '',
      path: '/longbing_card/pages/company/contact/contact?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&type=' + that.data.paramData.type + '&name=' + that.data.paramData.name + '&identification=' + that.data.paramData.identification,
      imageUrl: ''
    };
  }, 
  getContactData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/modular',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        to_uid: app.globalData.to_uid
      },
      success: function (res) {
        console.log("entry/wxapp/modular ==>", res)
        if (!res.data.errno) {

          let tmpData = res.data.data;
          // let tmpData = res.data.data.company_modular;
          for (let i in tmpData) {
            if (tmpData[i].id == that.data.paramData.identification && tmpData[i].type == that.data.paramData.type) {

              var tmpDDDD = [];
              tmpDDDD.push(tmpData[i]);

              tmpData[i].info.markers = [{
                iconPath: "http://retail.xiaochengxucms.com/images/12/2018/11/A33zQycihMM33y337LH23myTqTl3tl.png",
                id: 1,
                callout: {
                  content: tmpData[i].info.address,
                  fontSize: 14,
                  bgColor: '#ffffff',
                  padding: 4,
                  display: 'ALWAYS',
                  textAlign: 'center',
                  borderRadius: 2,
                },
                latitude: tmpData[i].info.latitude,
                longitude: tmpData[i].info.longitude,
                width: 28,
                height: 28
              }]

              that.setData({
                companyData: tmpDDDD
              })

            }
          }
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // regionchange(e) {
  //   console.log(e.type)
  // },
  // markertap(e) {
  //   console.log(e.markerId)
  // },
  // controltap(e) {
  //   console.log(e.controlId)
  // },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var content = e.currentTarget.dataset.content;
    
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    } else if (status == 'toCall') {
      if (!content || content == '暂未填写') {
        return false;
      }
      wx.makePhoneCall({
        phoneNumber: content,
        success: function (res) {
          // console.log('拨打电话成功 ==>>', res.data);
          if (app.globalData.to_uid != wx.getStorageSync("userid")) {
            that.toCopyRecord(type);
          }
        }
      });
    } else if (status == 'toCompanyMap') {
      console.log("toCompanyMap")
      var latitude = e.currentTarget.dataset.latitude;
      var longitude = e.currentTarget.dataset.longitude;
      wx.openLocation({
        latitude: parseFloat(latitude),
        longitude: parseFloat(longitude),
        name: content,
        scale: 28,
        success: function (res) {
          // console.log("查看定位成功 ==> ", res) 
        }
      })
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