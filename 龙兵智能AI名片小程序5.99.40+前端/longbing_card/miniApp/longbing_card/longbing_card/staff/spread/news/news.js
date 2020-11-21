
var app = getApp()
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    status: '',
    name: '',
    avatar: '',
    globalData: {},
    dataList: [],
    page: 1,
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    app.util.showLoading(1);
    if (options.status) {
      that.setData({
        status: options.status
      })
      if (options.status == 'news') {
        wx.setNavigationBarTitle({
          title: '动态推广'
        })

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

      } else if (options.status == 'code') {
        wx.setNavigationBarTitle({
          title: '自定义码推广'
        })
        that.getCardIndexData();
      }
    }
    wx.hideShareMenu();
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
    app.util.showLoading(1);
    var that = this;
    that.setData({
      page: 1,
      dataList: []
    })
    if (that.data.status == 'news') {
      that.getNewsListData();
    } else if (that.data.status == 'code') {
      that.getCodeListData();
    }
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
    app.util.showLoading(1);
    var that = this;
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that, baseModel, util);
    that.setData({
      dataList: [],
      page: 1,
      more: true,
      loading: false,
      isEmpty: false,
      show: false,
    })
    if (that.data.status == 'news') {
      that.getNewsListData();
    } else if (that.data.status == 'code') {
      that.getCodeListData();
    }
    wx.stopPullDownRefresh();
    wx.hideLoading();
  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底") 
    app.util.showLoading(1);
    var that = this;
    that.setData({
      show: true
    })
    if (that.data.isEmpty == false) {
      that.setData({
        page: that.data.page + 1
      })
      if (that.data.status == 'news') {
        that.getNewsListData();
      } else if (that.data.status == 'code') {
        that.getCodeListData();
      }
    }
    wx.hideLoading();
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
    var that = this;

    if (res.from === 'button') {
      // console.log("来自页面内转发按钮");
      if (that.data.status == 'news') {
        var index = res.target.dataset.index;
        var id = res.target.dataset.id;
        var tmpData = that.data.dataList;
        console.log(tmpData[index].title, tmpData[index].cover[0])
        return {
          title: tmpData[index].title,
          path: '/longbing_card/pages/news/detail/detail?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&id=' + id + '&type=3',
          imageUrl: tmpData[index].cover[0],
          // success: function (res) {
          //   console.log("转发成功", res)
          // },
          // fail: function (res) {
          //   console.log('转发失败');
          // }
        };
      }
    }
    else {
      // console.log("来自右上角转发菜单");
    }
  },
  getNewsListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/myTimeline',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/myTimeline ==>", res)
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

          var tmpListData = that.data.dataList;
          var date = new app.util.date();
          for (let i in tmpData) {
            if (tmpData[i].create_time.length < 12) {
              tmpData[i].create_time = (date.dateToStr('yyyy/MM/DD', date.longToDate(tmpData[i].create_time * 1000)));
            }
            for (let j in tmpData[i].cover) {
              if (!tmpData[i].cover[j]) {
                console.log("null      ****", j)
                tmpData[i].cover.splice(j, 1)
              }
            }
            tmpListData.push(tmpData[i]);
          }

          that.setData({
            dataList: tmpListData,
            loading: true
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getCodeListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/releaseQrList',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/releaseQrList ==>", res)
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

          var tmpListData = that.data.dataList;

          var date = new app.util.date();
          for (let i in tmpData) {
            if (tmpData[i].create_time.length < 12) {
              tmpData[i].create_time = (date.dateToStr('yyyy/MM/DD', date.longToDate(tmpData[i].create_time * 1000)));
            }
            tmpListData.push(tmpData[i]);
          }

          that.setData({
            dataList: tmpListData,
            loading: true
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getCardIndexData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/cardV3',
      // 'url': 'entry/wxapp/card',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        to_uid: wx.getStorageSync("userid"),
        from_id: wx.getStorageSync("userid")
      },
      success: function (res) {
        console.log("entry/wxapp/cardV3 ==>", res)
        if (!res.data.errno) {
          that.setData({
            name: res.data.data.info.name,
            avatar: res.data.data.info.avatar
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toDeleteQr: function (index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/DeleteQr',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        id: tmpData[index].id
      },
      success: function (res) {
        // console.log("entry/wxapp/DeleteQr ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '自定义码删除成功！',
            duration: 1000
          })
          tmpData.splice(index, 1);
          that.setData({
            dataList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toDeleteTimeline: function (index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/DeleteTimeline',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        id: tmpData[index].id
      },
      success: function (res) {
        // console.log("entry/wxapp/DeleteTimeline ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'none',
            title: '动态删除成功！',
            duration: 1000
          })
          tmpData.splice(index, 1);
          that.setData({
            dataList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toShare') {
      console.log("转发")
    } else if (status == 'toDelete') {
      console.log("删除")
      wx.showModal({
        title: '',
        content: '是否确认删除此数据？',
        success: res => {
          if (res.confirm) {
            if (that.data.status == 'news') {
              that.toDeleteTimeline(index);
            } else if (that.data.status == 'code') {
              that.toDeleteQr(index);
            }
          }
        }
      })
    } else if (status == 'toCodeDetial') {
      console.log("跳转至详情")
      wx.navigateTo({
        url: '/longbing_card/staff/spread/code/code?id=' + that.data.dataList[index].id + '&name=' + that.data.name + '&avatar=' + that.data.avatar
      })
    } else if (status == 'toAddNews') {
      console.log("新建动态 || 新建自定义码")
      wx.navigateTo({
        url: '/longbing_card/staff/spread/news/addNews/addNews?status=' + that.data.status
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
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var id = e.currentTarget.dataset.id;
    if (status == 'toCopyright') {
      app.util.goUrl(e)
    }
    if (status == 'toNewsDetail') {
      console.log("跳转至详情")
      if (that.data.status == 'news') {
        wx.navigateTo({
          url: '/longbing_card/pages/news/detail/detail?id=' + id + '&to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid")
        })
      } else if (that.data.status == 'code') {
        wx.navigateTo({
          url: '/longbing_card/staff/spread/code/code?id=' + id
        })
      }
    }
  }
})