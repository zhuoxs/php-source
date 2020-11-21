
var app = getApp()
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { baseModel } from '../../resource/apis/index.js'
Page({
  data: {
    staffInfo: {},
    StaffCard: {},
    globalData: {},
    cardIndexData: {},
    notRead: '',
    noticeNum: '',
    qrImg: '',
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu();
    that.getStaffCard();
    that.getCardIndexData(); 
    that.setData({
      uniacid: app.siteInfo.uniacid,
      globalData: app.globalData
    }) 
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
    var that = this;
    that.getFormIds();
    that.getStaffInfo();
  },
  onHide: function () {
    // console.log("页面隐藏")
  },
  onUnload: function () {
    // console.log("页面关闭")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")
    let that = this;
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    wx.stopPullDownRefresh(); 
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底") 
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")  
    var that = this;
    var tmpData = that.data.cardIndexData;
    if (res.from === 'button') {
      // console.log("来自页面内转发按钮");
    }
    else {
      // console.log("来自右上角转发菜单");
    }


    
    // var tmpCardTitle  =  that.data.cardIndexData.info.myCompany.name;
    // if(that.data.cardIndexData.info.myCompany.short_name){
    //   tmpCardTitle = that.data.cardIndexData.info.myCompany.short_name 
    // } 
    // tmpCardTitle = tmpCardTitle +  '的' + tmpData.info.job + tmpData.info.name 

    let tmp_imageUrl = tmpData.share_img;
    if(tmpData.info.card_type == 'cardType1'){
      tmp_imageUrl == tmpData.info.avatar_2
    }
     
      return { 
      title:  tmpData.info.share_text,
      path: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard',
      imageUrl: tmp_imageUrl,
      success: function (res) {
        console.log("转发成功", res)
        that.toShareRecord();
      },
      fail: function (res) {
        console.log('转发失败');
      }
    };
  },
  getFormIds: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/FormIds',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        // console.log("entry/wxapp/FormIds ==>", res)
        if (!res.data.errno) {
          that.setData({
            noticeNum: res.data.data.count
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
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
          },function(){
            that.getStaffUnread();
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getStaffCard: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/StaffCard',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        // console.log("entry/wxapp/Staff ==>", res)
        if (!res.data.errno) {
          that.setData({
            StaffCard: res.data.data.count
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getStaffUnread: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Unread',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        // console.log("entry/wxapp/Unread ==>", res)
        if (!res.data.errno) {
          that.setData({
            notRead: res.data.data.count
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 名片
  getCardIndexData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/cardV5',
      // 'url': 'entry/wxapp/cardV3',
      // 'url': 'entry/wxapp/card',
      'cachetime': '30',
      // 
      'method': 'POST',
      'data': {
        to_uid: wx.getStorageSync("userid"),
        from_id:  wx.getStorageSync("userid")
      },
      success: function (res) { 
        console.log("entry/wxapp/cardV3 ==>", res)
        if (!res.data.errno) { 
          var tmpDataIndex = res.data.data;
          var tmpDataAddr = tmpDataIndex.info.myCompany.addr;
          var tmpMore = '';
          if (tmpDataAddr.length > 23) {
            tmpMore = '...';
          }
          tmpDataIndex.info.myCompany.addrMore = tmpDataAddr.slice(0, 23) + tmpMore;
        
          var tmp_paramObj = { 
            avatar: tmpDataIndex.info.avatar,
            name: tmpDataIndex.info.name,
            job_name: tmpDataIndex.info.job_name,
            phone: tmpDataIndex.info.phone,
            wechat: tmpDataIndex.info.wechat,
            companyName: tmpDataIndex.info.myCompany.name,
            logo: tmpDataIndex.info.myCompany.logo,
            addrMore: tmpDataIndex.info.myCompany.addrMore,
            qrImg: tmpDataIndex.qr
          } 
          that.setData({
            cardIndexData: tmpDataIndex,
            tmpShareData: tmp_paramObj
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }, 
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
     
    if(status == 'toCopyright' || status == 'toPoster'){
      app.util.goUrl(e)
    } 


    if (status == 'toEdit') {
      console.log("编辑个人信息")
      wx.navigateTo({
        url: '/longbing_card/staff/mine/editInfo/editInfo'
      })
    } else if (status == 'toChat') {
      console.log("私信我的")
      wx.switchTab({
        url: '/longbing_card/staff/message/message'
      })
    } else if (status == 'toEwm') {
      console.log("名片码") 
      wx.navigateTo({
        url: '/longbing_card/pages/card/share/share'
      })
    } else if (status == 'toCourse') {
      console.log("使用教程")
    } else if (status == 'toOpinion') {
      console.log("意见反馈")
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toCardIndex') {
      console.log("名片预览")
      wx.reLaunch({
        url: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard'
      })
    } else if (status == 'toPoster' || status == 'toAddPage' || status == 'toVoucher') { 
      app.util.goUrl(e,true);
    } else if (status == 'toCode') {
      console.log("自定义码")
      wx.navigateTo({
        url: '/longbing_card/staff/spread/news/news?status=code'
      })
    } else if (status == 'toHome') {
      console.log("返回首页")
      wx.reLaunch({
      // wx.navigateTo({
        url: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard'
      }) 
    } else if (status == 'toAddNotice') {
      console.log("添加通知数量")
    } else if (status == 'toNotice' ) {
      console.log("跳转到绑定通知",app.globalData.userid)
      console.log(e.detail.target.dataset.url)
      app.util.goUrl(e,true);
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
          that.getFormIds();
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }
})