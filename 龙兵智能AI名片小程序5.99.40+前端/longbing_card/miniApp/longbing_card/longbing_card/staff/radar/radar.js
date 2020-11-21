var app = getApp()
var getAppGlobalData = require('../../templates/copyright/copyright.js');
import util from '../../resource/js/xx_util.js';
import { baseModel } from '../../resource/apis/index.js'
Page({
  data: {
    tabList: [{ status: 'time', name: '时间' }, { status: 'behavior', name: '行为' }],
    currentIndex: 0,
    currentTab: 'time',
    setCount: [{ name: "近7天" }, { name: "近30天" }],
    count: 0,
    currentRadarTime: '',
    windowHeight: '',
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
    authStatus: true,
    radarTime: '',
    timeList: [],
    page: 1,
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
    tmpDDDDDDataLength: 0,
    behaviorInfo: [],
    behaviorList: [],
    globalData: {},
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu();
    if (that.data.currentTab == 'time') {
      console.log("时间")
      that.getRadarByTime();
    } else if (that.data.currentTab == 'behavior') {
      console.log("行为")
      that.getRadarByBehaviorInfo();
      that.getRadarByBehavior();
    }
    that.setData({
      windowHeight: wx.getSystemInfoSync().windowHeight,
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
    // var date = new app.util.date();
    // var radarTime = date.dateToLong(new Date);
    // that.setData({
    //   radarTime: (radarTime / 1000).toFixed(0),
    //   currentTab: 'time',
    // }) 
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

    getAppGlobalData.getAppGlobalData(that, baseModel, util);
    // var date = new app.util.date();
    // var radarTime = date.dateToLong(new Date);
    if (that.data.currentTab == 'time') {

      that.setData({
        onPullDownRefresh: true,
        page: 1,
        more: true,
        loading: false,
        isEmpty: false,
        show: false,
      })


      // that.setData({
      //   radarTime: (radarTime / 1000).toFixed(0),
      //   timeList: [],
      //   tmpDDDDDDataLength: 0
      // })
      that.getRadarByTime();
    } else if (that.data.currentTab == 'behavior') {
      that.setData({
        behaviorInfo: {},
        behaviorList: {}
      })
      that.getRadarByBehaviorInfo();
      that.getRadarByBehavior();
    }
    wx.showNavigationBarLoading();
    wx.stopPullDownRefresh();
    wx.hideLoading();
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底") 
    app.util.showLoading(1);
    var that = this;
    if (that.data.currentTab == 'time') {

      that.setData({
        show: true
      })
      if (that.data.isEmpty == false) {
        that.setData({
          page: that.data.page + 1
        })
        that.getRadarByTime();
      }


      // that.setData({
      //   show: true
      // })
      // if (that.data.isEmpty == false) {
      //   that.setData({
      //     'radarTime': that.data.radarTime - (24 * 60 * 60)
      //   })
      //   that.getRadarByTime();
      // }
    }
    wx.hideLoading();
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
  },
  pickerSelected: function (e) {
    let that = this;
    let status = e.currentTarget.dataset.status;
    if (status == 'count') {
      that.setData({
        count: e.detail.value,
      })
      that.getRadarByBehaviorInfo();
      that.getRadarByBehavior();
    }
  },
  getRadarByTime: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/aiTime',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        uniacid: app.siteInfo.uniacid,
        page: that.data.page
        // date: that.data.radarTime
      },
      success: function (res) {
        console.log("entry/wxapp/aiTime ==>", res)
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
          that.setData({
            loading: true
          })

          var tmpListData = that.data.timeList;
          var currentRadarTime = that.data.currentRadarTime;
          if (that.data.onPullDownRefresh == true) {
            tmpListData = []
          }
          var date = new app.util.date();
          for (let i in tmpData) {
            if (tmpData[i].create_time) {
              tmpData[i].create_time1 = date.dateToStr('YY/MM/DD', date.longToDate(tmpData[i].create_time * 1000));
              tmpData[i].create_time2 = date.dateToStr('HH:mm', date.longToDate(tmpData[i].create_time * 1000));
            }

            if (tmpData[i].sign == 'order') { 
                tmpData[i].countText = '，详情查看订单中心并发货'
            }
            if (tmpData[i].sign == 'praise') {
              if (tmpData[i].type == 2) {
                // console.log("查看名片")
                if (tmpData[i].count == 1) {
                  tmpData[i].countText = '，TA正在了解你'
                }
                if (tmpData[i].count == 2 || tmpData[i].count == 3 || tmpData[i].count == 4) {
                  tmpData[i].countText = '，你成功的吸引了TA'
                }
                if (tmpData[i].count > 4) {
                  tmpData[i].countText = '，高意向客户立刻主动沟通'
                }
              }
            }

            if (tmpData[i].sign == 'view') {
              if (tmpData[i].type == 1) {
                // console.log("查看商城列表"")
                if (tmpData[i].count == 1) {
                  tmpData[i].countText = '，尽快把握商机'
                }
                if (tmpData[i].count == 2) {
                  tmpData[i].countText = '，潜在购买客户'
                }
                if (tmpData[i].count == 3) {
                  tmpData[i].countText = '，高意向客户成交在望'
                }
                if (tmpData[i].count > 3) {
                  tmpData[i].countText = '，购买欲望强烈'
                }
              }
              if (tmpData[i].type == 3 || tmpData[i].type == 6) {
                // console.log("查看动态列表"")
                if (tmpData[i].count == 2) {
                  tmpData[i].countText = '，赶快主动沟通'
                }
                if (tmpData[i].count > 2) {
                  tmpData[i].countText = '，高意向客户成交在望'
                }
              }
              if (tmpData[i].type == 6) {
                // console.log("查看公司官网")
                if (tmpData[i].count == 1) {
                  tmpData[i].countText = '，看来TA对公司感兴趣'
                }
              }
            }

            tmpListData.push(tmpData[i]);
          }


          for (let i in tmpListData) {
            if (!currentRadarTime) {
              currentRadarTime = tmpListData[0].create_time1;
              console.log(currentRadarTime, "currentRadarTime")
            }

            if (currentRadarTime == tmpListData[i].create_time1) {
              tmpListData[i].showTime = 1
            }

            if (i > 0) {
              if (tmpListData[i].create_time1 != tmpListData[i - 1].create_time1) {
                currentRadarTime = tmpListData[i].create_time1;
                tmpListData[i].showTime = 1;
              } else {
                tmpListData[i].showTime = 0;
              }
            }
          }


          that.setData({
            timeList: tmpListData,
            onPullDownRefresh: false,
            currentRadarTime: currentRadarTime
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getRadarByBehaviorInfo: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/aiBehaviorHeader',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        uniacid: app.siteInfo.uniacid,
        type: that.data.count * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/aiBehaviorHeader ==>", res)
        if (!res.data.errno) {
          that.setData({
            behaviorInfo: res.data.data
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getRadarByBehavior: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/aiBehaviorOther',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        type: that.data.count * 1 + 1
      },
      success: function (res) {
        // console.log("entry/wxapp/aiBehaviorOther ==>", res)
        if (!res.data.errno) {
          that.setData({
            behaviorList: res.data.data
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
    var index = e.currentTarget.dataset.index;
    var id = e.currentTarget.dataset.id;
    var tmpData = that.data.timeList;


    if (status == 'toCopyright') {
      app.util.goUrl(e)
    }


    if (status == 'toChat') {
      console.log("去聊天")
      var chat_to_uid = tmpData[index].user_id;
      console.log(chat_to_uid, 'messge页面传递的chat_to_uid')
      var contactUserName = tmpData[index].user.nickName;
      if (!contactUserName) {
        contactUserName = '新客户'
      }

      var chatAvatarUrl = app.globalData.avatarUrl;
      var toChatAvatarUrl = tmpData[index].user.avatarUrl;
      if (!toChatAvatarUrl) {
        toChatAvatarUrl = app.globalData.defaultUserImg
      }

      var clientPhone = tmpData[index].phone

      wx.navigateTo({
        url: '/longbing_card/chat/staffChat/staffChat?chat_to_uid=' + chat_to_uid + '&contactUserName=' + contactUserName + '&chatAvatarUrl=' + chatAvatarUrl + '&toChatAvatarUrl=' + toChatAvatarUrl + '&clientPhone=' + clientPhone
      })
    } else if (status == 'toCustomInfo') {
      console.log("跳转至客户页面")
      wx.navigateTo({
        url: '/longbing_card/staff/custom/detail/detail?id=' + id
      })
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status != 'toHome') {
      that.setData({
        currentIndex: index,
        currentTab: status,
      })
      wx.pageScrollTo({
        duration: 0,
        scrollTop: 0,
      });
    }
    if (status == 'time') {
      console.log("时间")
      // if (that.data.timeList.length == 0) {
      that.setData({
        page: 1,
        onPullDownRefresh: true
      })
      that.getRadarByTime();
      // }
    } else if (status == 'behavior') {
      console.log("行为")
      // if (that.data.behaviorInfo.length == 0) {
      that.getRadarByBehaviorInfo();
      // }
      // if (that.data.behaviorList.length == 0) {
      that.getRadarByBehavior();
      // }
    } else if (status == 'toHome') {
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
        console.log("fail ==> ", res)
      }
    })
  }
})