var app = getApp();
var timerOverTime;
Page({
  data: {
    tabList: [
      { name: "全部", status: 'toOrder' }, { name: "待付款", status: 'toOrder' }, { name: "待发货", status: 'toOrder' }, { name: "待收货", status: 'toOrder' }, { name: "已完成", status: 'toOrder' }],
    currentIndex: 0,
    dataList: [],
    globalData: {},
    page: 1,
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
    toWxPayStatus: 0,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    var that = this;
    wx.hideShareMenu();
    if (options.currentTab) {
      that.setData({
        currentIndex: options.currentTab,
        globalData: app.globalData
      })
    }
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
    app.util.showLoading(1);
    var that = this;
    that.setData({
      dataList: [],
      page: 1,
      more: true,
      loading: false,
      isEmpty: false,
      show: false,
    })
    that.getListData();
    wx.hideLoading();
  },
  onHide: function () {
    // 页面隐藏
    clearInterval(timerOverTime);
  },
  onUnload: function () {
    // 页面关闭
    clearInterval(timerOverTime);
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    app.util.showLoading(1);
    var that = this;
    that.setData({
      dataList: [],
      page: 1,
      more: true,
      loading: false,
      isEmpty: false,
      show: false,
    })
    that.getListData();
    wx.showNavigationBarLoading();
    wx.stopPullDownRefresh();
    wx.hideLoading();
  },
  onReachBottom: function () {
    // 页面上拉触底
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
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopmyorder',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        type: that.data.currentIndex,
        page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/shopmyorder ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data.list;
          if (tmpData.length == 0 || that.data.page > res.data.data.total_page) {
            that.setData({
              more: false,
              loading: false,
              isEmpty: true,
              show: true
            })
            return false;
          }

          var tmpListData = that.data.dataList;
          for (let i in tmpData) {
            var date = new app.util.date();
            let day = parseInt(tmpData[i].left_time / 24 / 60 / 60);
            day = day > 0 ? day + '天' : '';
            tmpData[i].left_time = day + date.dateToStr('HH', date.longToDate(tmpData[i].left_time * 1000)) + '小时';


            if (tmpData[i].goods_info) {
              tmpData[i].total_count_number = 0;
              for (let j in tmpData[i].goods_info) {
                tmpData[i].total_count_number += parseInt(tmpData[i].goods_info[j].number)
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
        console.log("entry/wxapp/shopmyorder ==> fail ==> ", res)
      }
    })
  },
  getShopcancelorder: function (order_id, index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/shopcancelorder',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        id: order_id
      },
      success: function (res) {
        console.log("entry/wxapp/shopcancelorder ==>", res)
        if (!res.data.errno) {
          let currentIndex = that.data.currentIndex;
          if(currentIndex == 0){
            wx.showToast({
              icon: 'success',
              title: '已成功取消订单!',
              duration: 2000,
              success: function () {
                setTimeout(() => {
                  tmpData[index].order_status = 1;
                  that.setData({
                    dataList: tmpData
                  })
                }, 1000);
              }
            })
          }

          if(currentIndex == 1){
            wx.showToast({
              icon: 'success',
              title: '已成功取消订单!',
              duration: 2000,
              success: function () {
                setTimeout(() => {
                  tmpData.splice(index,1); 
                  that.setData({
                    dataList: tmpData
                  })
                }, 1000);
              }
            }) 
          }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcancelorder ==> fail ==> ", res)
      }
    })
  },
  getShopendorder: function (order_id, index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/shopendorder',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        id: order_id
      },
      success: function (res) {
        console.log("entry/wxapp/shopendorder ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'success',
            title: '已成功确认收货!',
            duration: 2000,
            success: function () {
              setTimeout(() => {
                tmpData.splice(index, 1);
                that.setData({
                  dataList: tmpData
                })
              }, 1000);
            }
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopendorder ==> fail ==> ", res)
      }
    })
  },
  getRefund: function (order_id, index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/Refund',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        order_id: order_id
      },
      success: function (res) {
        console.log("entry/wxapp/Refund ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'success',
            title: '已成功申请退款!',
            duration: 2000,
            success: function () {
              setTimeout(() => {
                tmpData[index].pay_status = 2;
                that.setData({
                  dataList: tmpData
                })
              }, 1000);
            }
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/Refund ==> fail ==> ", res)
      }
    })
  },
  getWxPay: function (order_id, index) {
    var that = this;
    app.util.showLoading(1);
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/Pay',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        order_id: order_id
      },
      success(res) {
        console.log("entry/wxapp/Pay ==> fail ==>", res)
        if (res.data && res.data.data && !res.data.errno) {
          //发起支付
          wx.hideLoading();
          wx.requestPayment({
            'timeStamp': res.data.data.timeStamp,
            'nonceStr': res.data.data.nonceStr,
            'package': res.data.data.package,
            'signType': 'MD5',
            'paySign': res.data.data.paySign,
            'success': function (res) {
              //执行支付成功提示
              wx.showToast({
                icon: 'success',
                image: '/longbing_card/resource/images/alert.png',
                title: '支付成功',
                duration: 2000,
                success: function () {
                  setTimeout(() => {
                    wx.navigateTo({
                      url: '/longbing_card/pages/uCenter/order/orderDetail/orderDetail?id=' + tmpData[index].order_info.id
                    })
                  }, 1000);
                }
              })
            },
            'fail': function (res) {
              wx.showToast({
                icon: 'fail',
                image: '/longbing_card/resource/images/error.png',
                title: '支付失败',
                duration: 2000
              })
            },
            'complete':function(res){
              that.data.toWxPayStatus = 0;
            }
          })
        }
      },
      fail(res) {
        console.log("entry/wxapp/Pay ==> fail ==>", res)
        wx.hideLoading();
        wx.showModal({
          title: '系统提示',
          content: res.data.data.message ? '支付失败，' + res.data.data.message : '支付失败，请重试',
          showCancel: false,
          success: function (res) {
            if (res.confirm) {
              // backApp()
            }
          }
        })
      } 
    }) 
  },
  checktoConsult: function (goods_id,tmpToUid) {
    var that = this;
    console.log(app.globalData.to_uid, wx.getStorageSync("userid"), app.globalData.nickName, "checktoConsult *********  showModal")
    if (tmpToUid == 0) {
      wx.showModal({
        title: '',
        content: '不能与默认客服进行对话哦！',
        confirmText: '知道啦',
        showCancel: false,
        success: res => {
          if (res.confirm) {
          } else {
          }
        }
      });
    } else if (tmpToUid == wx.getStorageSync("userid")) {
      wx.showModal({
        title: '',
        content: '不能和自己进行对话哦！',
        confirmText: '知道啦',
        showCancel: false,
        success: res => {
          if (res.confirm) {
          } else {
          }
        }
      });
    } else {
      wx.navigateTo({
        url: '/longbing_card/chat/userChat/userChat?chat_to_uid=' + tmpToUid + '&contactUserName=' + app.globalData.nickName + '&goods_id=' + goods_id
      })
    }
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var tmpData = that.data.dataList;
    if (status == 'toProductDetail' || status == 'toOrderDetail') {
      app.util.goUrl(e)
    } else if (status == 'toConsult') {
      console.log("咨询")
      that.checktoConsult(tmpData[index].goods_info[0].id,tmpData[index].to_uid);
    } else if (status == 'toCancel') {
      console.log("取消订单")
      that.getShopcancelorder(tmpData[index].id, index);
    } else if (status == 'toRefund') {
      console.log("申请退款")
      that.getRefund(tmpData[index].id, index);
    } else if (status == 'toWxPay') {
      console.log("确认付款")
      let toWxPayStatus = that.data.toWxPayStatus;
      if(toWxPayStatus == 0){
        that.setData({
          toWxPayStatus: 1
        },function(){
          that.getWxPay(tmpData[index].id, index);
        })
      }
    } else if (status == 'toConfirm') {
      console.log("确认收货")
      that.getShopendorder(tmpData[index].id, index);
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toOrder') {
      that.setData({
        currentIndex: index,
        page: 1,
        isEmpty: false,
        dataList: []
      })
      that.getListData();
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