var app = getApp()
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
Page({
  data: {
    type: '',
    dataList: [],
    globalData: {},
    tmpMore: [],
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
    wx.hideShareMenu();
    if (options.type) {
      that.setData({
        type: options.type
      })
      // 1=>产品推广 2=>动态推广 3=>名片推广
      if (options.type == 1) {
        wx.setNavigationBarTitle({
          title: '产品推广'
        })
      } else if (options.type == 2) {
        wx.setNavigationBarTitle({
          title: '动态推广'
        })
      } else if (options.type == 3) {
        wx.setNavigationBarTitle({
          title: '名片推广'
        })
        that.getCardIndexData();
      }
    }
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
      dataList: [],
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
  },
  // 名片
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
          var tmpDataIndex = res.data.data;
          var tmpDataAddr = tmpDataIndex.info.myCompany.addr;
          var tmpMore = '';
          if (tmpDataAddr.length > 23) {
            tmpMore = '...';
          }
          tmpDataIndex.info.myCompany.addrMore = tmpDataAddr.slice(0, 23) + tmpMore;

          var paramObj = {
            avatar: tmpDataIndex.info.avatar,
            name: tmpDataIndex.info.name,
            job_name: tmpDataIndex.info.job_name,
            phone: tmpDataIndex.info.phone,
            wechat: tmpDataIndex.info.wechat,
            companyName: tmpDataIndex.info.myCompany.name,
            logo: tmpDataIndex.info.myCompany.logo,
            addrMore: tmpDataIndex.info.myCompany.addrMore,
            qrImg: tmpDataIndex.qr,
          }
          that.setData({
            cardIndexData: tmpDataIndex,
            tmpShareData: paramObj
          })
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getListData: function () {
    var that = this;
    // 1=>产品推广 2=>动态推广 3=>名片推广
    app.util.request({
      'url': 'entry/wxapp/extensionDetailV2',
      // 'url': 'entry/wxapp/extensionDetail',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        page: that.data.page,
        type: that.data.type
      },
      success: function (res) {
        console.log("entry/wxapp/extensionDetailV2 ==>", res)
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

          var tmpListData = that.data.dataList;
          // for (let i in tmpData) {
          //   tmpListData.push(tmpData[i]);
          // }
          var date = new app.util.date();
          var currentTime = (date.dateToLong(new Date) / 1000).toFixed(0);
          for (let i in tmpData) {
            for (let k in tmpData[i].cover) {
              if (!tmpData[i].cover[k]) {
                tmpData[i].cover.splice(k, 1)
              }
            }

            for (let j in tmpData[i].groups) {
              // console.log(tmpData[i].groups[j].update_time, "tmpData[i].groups[j].update_time")
              tmpData[i].groups[j].update_time = parseInt(tmpData[i].groups[j].update_time);
              if (!tmpData[i].groups[j].update_time) {
                tmpData[i].groups[j].update_time = ''
              } else {
                tmpData[i].groups[j].update_time = currentTime - tmpData[i].groups[j].update_time;
                var timeD = parseInt(tmpData[i].groups[j].update_time / (24 * 60 * 60));
                var timeH = parseInt(tmpData[i].groups[j].update_time / (60 * 60));
                if (timeD > 0) {
                  tmpData[i].groups[j].update_time = timeD + '天前互动';
                } else {
                  if (timeH > 0) {
                    tmpData[i].groups[j].update_time = timeH + '小时前互动';
                  } else {
                    tmpData[i].groups[j].update_time = '';
                  }
                }
              }
            }

            tmpListData.push(tmpData[i]);
          }

          that.setData({
            dataList: tmpListData
          })

          let tmpMoreList = that.data.dataList;
          let more = [];
          for (let i in tmpMoreList) {
            more.push('0')
          }

          that.setData({
            tmpMore: more
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
    var id = e.currentTarget.dataset.id;
    var opengid = e.currentTarget.dataset.opengid;
    if (status == 'toCopyright') {
      app.util.goUrl(e)
    }

    if (status == 'toShopDetail') {
      console.log("跳转至产品详情")
      wx.navigateTo({
        url: '/longbing_card/pages/shop/detail/detail?id=' + id
      })
    } else if (status == 'toNewsDetail') {
      console.log("跳转至动态详情")
      wx.navigateTo({
        url: '/longbing_card/pages/news/detail/detail?id=' + id + '&to_uid=' + wx.getStorageSync("userid") + '&from_id=' + wx.getStorageSync("userid")
      })
    } else if (status == 'toCodeDetail') {
      console.log("跳转至自定义码 名片码详情")
      if (id == 0) {
        console.log("名片码")
        wx.navigateTo({
          url: '/longbing_card/pages/card/share/share'
        })
      } else {
        console.log("自定义码")
        wx.navigateTo({
          url: '/longbing_card/staff/spread/code/code?id=' + id + '&name=' + that.data.cardIndexData.info.name + '&avatar=' + that.data.cardIndexData.info.avatar
        })
      }
    } else if (status == 'toSpreadDetail') {
      console.log("跳转至群详情")
      wx.navigateTo({
        url: '/longbing_card/staff/spread/detail/detail?id=' + id + '&opengid=' + opengid
      })
    }
  }
})