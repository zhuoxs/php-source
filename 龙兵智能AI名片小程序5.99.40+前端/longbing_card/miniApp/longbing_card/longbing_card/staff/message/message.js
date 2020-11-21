
var app = getApp()
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { baseModel } from '../../resource/apis/index.js'
Page({
  data: {
    globalData: {},
    page: 1,
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
    authStatus: true,
    messageTime: '',
    staffInfo: [],
    messageList: [],
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    var that = this; 
    console.log(options,"11111111111")

  },
  onReady: function () {
    // console.log("页面渲染完成")
    var that = this;  
  },
  onShow: function () {
    // 页面显示 
    app.util.showLoading(1);
    var that = this;
    let paramObj = {
      to_uid: wx.getStorageSync("userid")
    } 
    console.log(paramObj,'paramObj')
    baseModel.getClientUnread(paramObj).then((d) => {
      let staff_count = d.data.count.staff_count; 
      app.globalData.badgeNum = staff_count; 
      getApp().setMsgBadge(app.globalData.badgeNum);
    }) 
    wx.hideShareMenu();
    var date = new app.util.date();
    var messageTime = date.dateToLong(new Date);
    that.setData({
      messageTime: (messageTime / 1000).toFixed(0),
      globalData: app.globalData,
      onPullDownRefresh: true
    }) 
    that.getStaffInfo();
    that.getMessageList();
    wx.hideLoading();
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")
    var that = this;
    app.util.showLoading(1);
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    // that.setData({
    //   messageList: [],
    //   page: 1,
    //   more: true,
    //   loading: false,
    //   isEmpty: false,
    //   show: false,
    // })
    that.getMessageList();
    that.setData({
      onPullDownRefresh : true
    })
    setTimeout(() => {
      wx.stopPullDownRefresh();
      wx.hideLoading();
    }, 1000);
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底") 
    // var that = this;
    // that.setData({
    //   show: true
    // })
    // if (that.data.isEmpty == false) {
    //   that.setData({
    //     page: that.data.page + 1
    //   })

    //   console.log(that.data.page,"***********page")
    //   that.getMessageList();
    // }
  }, 
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  }, 
  getStaffInfo: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Staff',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        // console.log("entry/wxapp/Staff ==>", res)
        if (!res.data.errno) {
          that.setData({
            staffInfo: res.data.data
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  getMessageList: function () {
    var that = this;
    // console.log(that.data.page,"*************////////page getMessageList")
    app.util.request({
      'url': 'entry/wxapp/chat',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/chat ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data.list;
          if (tmpData.length == 0) {
            that.setData({
              more: false,
              loading: false,
              isEmpty: true,
              show: true
            })
            return false;
          }
          var tmpListData = that.data.messageList;
          if(that.data.onPullDownRefresh == true){
            tmpListData = []
          }
          for (let i in tmpData) {
            var date = new app.util.date();
            if (tmpData[i].last_time.length < 12) {
              tmpData[i].last_time = date.dateToStr('yyyy/MM/DD HH:mm:ss', date.longToDate(tmpData[i].last_time * 1000));
            }
            tmpListData.push(tmpData[i]);
          }

          that.setData({
            messageList: tmpListData,
            onPullDownRefresh: false,
            loading: true
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var tmpData = that.data.messageList;
    
    if(status == 'toCopyright' || status == 'toJumpUrl'){
      app.util.goUrl(e)
    } 

    var chat_to_uid = tmpData[index].user_id;
    if(chat_to_uid == wx.getStorageSync("userid")){
      chat_to_uid = tmpData[index].target_id
    }
    

    if (status == 'toUserInfo') {
      console.log("跳转至客户详情")
      wx.navigateTo({
        url: '/longbing_card/staff/custom/detail/detail?id=' + chat_to_uid
      })
    } else if (status == 'toChat') {
      console.log("打开会话",tmpData[index].id)
      console.log(chat_to_uid,'messge页面传递的chat_to_uid')
      var contactUserName = tmpData[index].user.nickName;
      if(!contactUserName){ 
        contactUserName = '新客户'
      }
      var toChatAvatarUrl = tmpData[index].user.avatarUrl;
      if(!toChatAvatarUrl){
        toChatAvatarUrl = app.globalData.defaultUserImg
      }
      var clientPhone =  tmpData[index].phone 

      wx.navigateTo({
        url: '/longbing_card/chat/staffChat/staffChat?chat_to_uid=' + chat_to_uid + '&contactUserName=' + contactUserName + '&chatid=' + tmpData[index].id + '&chatAvatarUrl=' + that.data.staffInfo.avatarUrl + '&toChatAvatarUrl=' + toChatAvatarUrl + '&clientPhone=' + clientPhone
      })
    }
    
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId; 
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId); 
    if (status == 'toHome') {
      console.log("返回首页")
      wx.reLaunch({
      // wx.navigateTo({
        url: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard'
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
        console.log("fail ==> ",res)
      }
    })
  }
})