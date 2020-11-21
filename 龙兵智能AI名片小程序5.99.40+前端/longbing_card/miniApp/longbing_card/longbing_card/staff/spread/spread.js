
var app = getApp()
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { baseModel } from '../../resource/apis/index.js'
Page({
  data: {
    setCount: [{ name: "今日" }, { name: "近7天" }, { name: "近30天" }, { name: "本月" }],
    count: 2,
    countList: {},
    globalData: {},
    staffInfo: {},
    staffCard: {}, 
    qrImg: '',
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    app.util.showLoading(1);
    var that = this;
    wx.hideShareMenu(); 
    that.getStaffInfo();
    that.getCardIndexData(); 
    wx.hideLoading();
    that.setData({
      globalData: app.globalData
    })
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
    var that = this;
    that.toGetCount();
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
    that.getStaffInfo();
    that.getCardIndexData(); 
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
      var title = [];
    
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
        title: tmpData.info.share_text, 
        path: '/longbing_card/pages/index/index?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard',
        imageUrl: tmp_imageUrl,
        // success: function (res) {
        //   console.log("转发成功", res)
        //   that.toShareRecord();
        // },
        // fail: function (res) {
        //   console.log('转发失败');
        // }
      }; 
    }
    else {
      // console.log("来自右上角转发菜单");
    }
  },
  pickerSelected: function (e) {
    let that = this;
    let status = e.currentTarget.dataset.status;
    if (status == 'count') {
      that.setData({
        count: e.detail.value
      })
      that.setData({
        countList: {}
      })
      that.toGetCount();
    }
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
            that.getStaffCard();
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
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
        // console.log("entry/wxapp/StaffCard ==>", res)
        if (!res.data.errno) {
          that.setData({
            StaffCard: res.data.data.count
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
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
  toGetCount: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/extensionStatistics',
      'cachetime': '30', 
      'method': 'POST',
      'data': {
        type: that.data.count * 1 + 1
      },
      success: function (res) {
        console.log("entry/wxapp/extensionStatistics ==>", res)
        if (!res.data.errno) {

          let tmpData = res.data.data;
          var date = new app.util.date();
          var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);

          console.log(currentTime,"currentTime")

          if (!tmpData.extension.count) {
            tmpData.extension.count = 0
          }
          if (!tmpData.timeline.count) {
            tmpData.timeline.count = 0
          }
          if (!tmpData.card.count) {
            tmpData.card.count = 0
          }
 
          tmpData.extension.last_time = parseInt(tmpData.extension.last_time)
          if (!tmpData.extension.last_time) {
            tmpData.extension.last_time = ''
          } else {
            tmpData.extension.last_time = currentTime - tmpData.extension.last_time;
            var extensionD = parseInt(tmpData.extension.last_time / (24 * 60 * 60));
            var extensionH = parseInt(tmpData.extension.last_time / (60 * 60));
            if (extensionD > 0) {
              tmpData.extension.last_time = extensionD + '天前互动'
            } else {
              if (extensionH > 0) {
                tmpData.extension.last_time = extensionH + '小时前互动';
              } else {
                tmpData.extension.last_time = '';
              }
            }
          }

          tmpData.timeline.last_time = parseInt(tmpData.timeline.last_time)
          if (!tmpData.timeline.last_time) {
            tmpData.timeline.last_time = ''
          } else {
            tmpData.timeline.last_time = currentTime - tmpData.timeline.last_time;
            var timelineD = parseInt(tmpData.timeline.last_time / (24 * 60 * 60));
            var timelineH = parseInt(tmpData.timeline.last_time / (60 * 60));
            if (timelineD > 0) {
              tmpData.timeline.last_time = timelineD + '天前互动'
            } else {
              if (timelineH > 0) {
                tmpData.timeline.last_time = timelineH + '小时前互动';
              } else {
                tmpData.timeline.last_time = '';
              }
            }
          }

          tmpData.card.last_time = parseInt(tmpData.card.last_time)
          if (!tmpData.card.last_time) {
            tmpData.card.last_time = ''
          } else {
            tmpData.card.last_time = currentTime - tmpData.card.last_time;
            var cardD = parseInt(tmpData.card.last_time / (24 * 60 * 60));
            var cardH = parseInt(tmpData.card.last_time / (60 * 60));
            if (cardD > 0) {
              tmpData.card.last_time = cardD + '天前互动'
            } else {
              if (cardH > 0) {
                tmpData.card.last_time = cardH + '小时前互动';
              } else {
                tmpData.card.last_time = '';
              }
            }
          }
          that.setData({
            countList: tmpData
          })

          console.log(res.data.data,tmpData,"ddddddd",that.data.countList)
        }
      },
      fail: function (res) {
        console.log("fail ==> ",res)
      }
    })
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    var index = e.detail.target.dataset.index;
    var type = e.detail.target.dataset.type;
    that.toSaveFormIds(formId);
    if (status == 'toSpread') {
      console.log("我要推广")
      if (type == 'toProduct') {
        console.log("产品")
        wx.navigateTo({
          url: '/longbing_card/staff/spread/product/product'
        })
      } else if (type == 'toNews') {
        console.log("动态")
        wx.navigateTo({
          url: '/longbing_card/staff/spread/news/news?status=news'
        })
      } else if (type == 'toCard') {
        console.log("名片")
      } else if (type == 'toEwm') {
        console.log("名片码")
        wx.navigateTo({
          url: '/longbing_card/pages/card/share/share'
        }) 
      } else if (type == 'toCode') {
        console.log("自定义码")
        wx.navigateTo({
          url: '/longbing_card/staff/spread/news/news?status=code'
        })
      }
    }  else if (status == 'toHome') {
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
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var type = e.currentTarget.dataset.type; 
      if(status == 'toCopyright'){
        app.util.goUrl(e)
      } 
    // 1=>产品推广 2=>动态推广 3=>名片推广
    if (status = "toSprdadDetail") {
      console.log("跳转至详情")
      if(type != 3){
        wx.navigateTo({
          url: '/longbing_card/staff/spread/spread/spread?type=' + type
        })
      }
    }
  }
})