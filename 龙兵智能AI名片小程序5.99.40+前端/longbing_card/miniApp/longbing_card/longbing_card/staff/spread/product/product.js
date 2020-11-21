
var app = getApp()
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
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
    app.util.showLoading(1);
    var that = this;
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
    that.getListData();
    wx.hideLoading();
  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示 
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
      onPullDownRefresh: true,
      page: 1,
      more: true,
      loading: false,
      isEmpty: false,
      show: false,
    })
    that.getListData();
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
      that.getListData();
    }
    wx.hideLoading();
  },
  onPageScroll: function (e) {
    //console.log("监听页面滚动", e);
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享") 
    if (res.from === 'button') {
      var that = this;
      var index = res.target.dataset.index;
      var tmpData = that.data.dataList;
      return {
        title: tmpData[index].name,
        path: '/longbing_card/pages/shop/detail/detail?to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid") + '&id=' + tmpData[index].id + '&type=2&nickName=' + app.globalData.nickName,
        imageUrl: tmpData[index].cover,
        // success: function (res) {
        //   console.log("转发成功", res)
        // },
        // fail: function (res) {
        //   console.log('转发失败');
        // }
      };
    }
  },
  getListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/extensions',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/extensions ==>", res)
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
          // that.setData({
          //   loading: true
          // })

          var tmpListData = that.data.dataList;
          if (that.data.onPullDownRefresh == true) {
            tmpListData = []
          }
          for (let i in tmpData) {
            tmpListData.push(tmpData[i]);
          }

          that.setData({
            dataList: tmpListData,
            onPullDownRefresh: false,
            loading: true
          })

        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toSetExtension: function (index) {
    var that = this;
    let tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/extension',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        goods_id: tmpData[index].id
      },
      success: function (res) {
        // console.log("entry/wxapp/extension ==>", res)
        if (!res.data.errno) {
          if (tmpData[index].is_extension == 0) {
            tmpData[index].is_extension = 1
          } else if (tmpData[index].is_extension == 1) {
            tmpData[index].is_extension = 0
          }
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
    var status = e.detail.target.dataset.status;
    var index = e.detail.target.dataset.index;
    that.toSaveFormIds(formId);
    if (status == 'toPush') {
      console.log("设为主推")
      that.toSetExtension(index);
    } else if (status == 'toShare') {
      console.log("转发")
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
    if (status == 'toShopDetail') {
      console.log("跳转至详情")
      wx.navigateTo({
        url: '/longbing_card/pages/shop/detail/detail?id=' + id
      })
    }
  }
})