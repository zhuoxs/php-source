var app = getApp() 
var auth = require('../../../templates/auth/auth.js');
var getAppGlobalData = require('../../../templates/copyright/copyright.js');  
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
var timer;
Page({
  data: {
    id: '',
    to_uid: '',
    from_id: '', 
    isStaffAdd: false,
    authStatus: true,
    globalData: {},
    detailData: [],
    staffCard: []
  },
  onLoad: function (options) {

    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    var that = this;
    app.util.showLoading(1);
    wx.showShareMenu({
      withShareTicket: true,
      success: function (res) {
        // 分_享成功
        console.log('shareMenu share success')
        console.log('分_享' + res)
      },
      fail: function (res) {
        // 分_享失败
        console.log(res)
      }
    })


    var paramData = {};

    if (options.id) {
      paramData.id = options.id;
    }
    
    if(options.to_uid){
      paramData.to_uid = options.to_uid; 
      app.globalData.to_uid = options.to_uid;
    }
    if(options.from_id){ 
      paramData.from_id = options.from_id;
      app.globalData.from_id = options.from_id;
    }
    if(options.nickName){  
      app.globalData.nickName = options.nickName;
    }
    if(options.companyName){  
      paramData.companyName = options.companyName;
    }

    that.setData({
      paramData: paramData
    })


    that.getStaffCard();
    that.getDetailData();

   

    if (options.from_id && options.type == 3) {
      if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        if (app.globalData.loginParam.scene == 1044) {
          timer = setInterval(function () {
            // console.log(app.globalData.encryptedData,"app.globalData.encryptedData  1044")
            if (app.globalData.encryptedData) {
              that.toGetShareInfo();
              // clearInterval(timer);
            }
          }, 1000)
        } 
      }
    }
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
    var that = this;
    that.checkAuthStatus();
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
    clearInterval(timer);
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    var that = this;
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    that.checkAuthStatus();
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

    let tmp_Path = '/longbing_card/pages/news/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&id=' + that.data.paramData.id + '&type=3';
    if(that.data.paramData.companyName){
      tmp_Path = tmp_Path + '&companyName=' + that.data.paramData.companyName
    }
    return {
      title: '',
      path: tmp_Path,
      imageUrl: '',
      // success: function (res) {
      //   console.log(res)
      //   if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
      //     that.toForwardRecord();
      //   }
      // },
      // fail: function (res) {
      //   // 分_享失败
      //   console.log(res)
      // }
    };
    
    if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
      that.toForwardRecord();
    }
  }, 
  getStaffCard: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/cardV3',
      // 'url': 'entry/wxapp/card',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        to_uid: that.data.paramData.to_uid,
        from_id: that.data.paramData.from_id
      },
      success: function (res) {
        // console.log("entry/wxapp/index ==>", res)
        if (!res.data.errno) {
          var tmpStaffAdd = false;
          if(res.data.data.info.is_staff == 1){
            tmpStaffAdd = true;
          }
          that.setData({
            staffCard: res.data.data,
            isStaffAdd : tmpStaffAdd
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 检查授权
  checkAuthStatus: function () {
    var that = this;
    auth.checkAuth(that,baseModel,util);
  },
  getUserInfo: function (e) {
    var that = this;
    console.log('获取微信用户信息')
    auth.getUserInfo(e);
  },
  getDetailData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/timelineDetail',
      'cachetime': '30', 
      'method': 'POST',
      'data': {
        id: that.data.paramData.id,
        to_uid: app.globalData.to_uid
      },
      success: function (res) {
        console.log("entry/wxapp/timelineDetail ==>", res)
        if (!res.data.errno) {

          if (res.data.data.cover) {
            for (let i in res.data.data.cover) {
              if (!res.data.data.cover[i]) {
                res.data.data.cover.splice(i, 1)
              }
            }
          } 
          var date = new app.util.date();
          res.data.data.create_time = date.dateToStr('MM月DD日', date.longToDate(res.data.data.create_time * 1000));
          that.setData({
            detailData: res.data.data
          })
          // console.log("dddddddddddd********",that.data.detailData)
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网
  // target_id 转发内容的id 当type=2,3时有效
  toForwardRecord: function () {
    var that = this;
    let paramObj = {
      type: 3,
      to_uid: app.globalData.to_uid,
      target_id: that.data.paramData.id
    }
    console.log("entry/wxapp/Forward ==> paramObj", paramObj)

    app.util.request({
      'url': 'entry/wxapp/Forward',
      'cachetime': '30', 
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        // console.log("entry/wxapp/Forward ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toGetShareInfo: function () {
    var that = this;
    // type 1=>浏览名片 2=>浏览自定义码 3=>浏览商品 4=>浏览动态
    // 当type 为2,3,4时, 需要传浏览对象的id 
    wx.login({
      success: function (res) {
        // console.log('wx.login ==>>', res);

        let tmpData = {
          encryptedData: app.globalData.encryptedData,
          iv: app.globalData.iv,
          type: 4,
          code: res.code,
          to_uid: that.data.paramData.to_uid,
          target_id: that.data.paramData.id,
        }
        app.util.request({
          'url': 'entry/wxapp/getShare',
          'cachetime': '30', 
          'method': 'POST',
          'data': tmpData,
          success: function (res) {
            console.log("entry/wxapp/getShare ==>", res)
            if (!res.data.errno) {
              // console.log(res.data.data)
              clearInterval(timer);
            }
          },
          fail: function (res) {
            // console.log("entry/wxapp/getShare ==> fail ==> ", res)
          }
        })
      },
      fail: function (res) {
        // console.log("entry/wxapp/getShare ==> fail ==> ", res)
      }
    })
  },
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    if(status == 'toCopyright'){
      app.util.goUrl(e)
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toSeeCard') {
      console.log("看名片")
      wx.navigateTo({
        url: '/longbing_card/pages/index/index?to_uid=' + that.data.paramData.to_uid + '&from_id=' + that.data.paramData.from_id + '&currentTabBar=toCard'
      })
    } else if (status == 'toHome') {
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