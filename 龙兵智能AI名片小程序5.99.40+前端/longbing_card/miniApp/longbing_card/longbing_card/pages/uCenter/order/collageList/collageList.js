var app = getApp();
Page({
  data: {
    tabList: [
      { dotNum: "0", name: "全部拼团", status: 'toCollage' }, { dotNum: "0", name: "拼团中", status: 'toCollage' }, { dotNum: "0", name: "拼团成功", status: 'toCollage' }, { dotNum: "0", name: "拼团失败", status: 'toCollage' }
    ],
    currentIndex: 0,
    globalData: {},
    more: true,
    loading: false,
    isEmpty: false,
    show: false,
    toWxPayStatus: 0,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
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
  },
  onUnload: function () {
    // 页面关闭
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
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getShopcollagenumber: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopcollagenumber',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        console.log("entry/wxapp/shopcollagenumber ==>", res)
        if (!res.data.errno) {
          var tmpData = that.data.tabList;
          tmpData[0].dotNum = 0;
          tmpData[1].dotNum = res.data.data.going;
          tmpData[2].dotNum = res.data.data.suc;
          tmpData[3].dotNum = res.data.data.fail;
          that.setData({
            tabList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcollagenumber ==> fail ==> ", res)
      }
    })
  },
  getListData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopmycollage',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        type: that.data.currentIndex,
        // page: that.data.page
      },
      success: function (res) {
        console.log("entry/wxapp/shopmycollage ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          if (tmpData.length == 0) {
            that.setData({
              more: false,
              loading: false,
              isEmpty: true,
              show: true
            })
          }
          for (let i in tmpData) {
            for (let j in tmpData[i].order_info) {
              if (tmpData[i].user_id == tmpData[i].order_info[j].user_id) {
                tmpData[i].order_info_2 = tmpData[i].order_info[j];
              }
            }
            tmpData[i].collage_info.number_2 = ((tmpData[i].order_info_2.total_price - tmpData[i].order_info_2.freight) / tmpData[i].collage_info.price)
          }
          that.setData({
            dataList: tmpData
          })
          that.getShopcollagenumber();
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopmycollage ==> fail ==> ", res)
      }
    })
  },
  getShopcancelorder: function (order_id, index) {
    var that = this;
    console.log(order_id,"order_id")
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
                  tmpData.splice(index, 1);
                  that.setData({
                    dataList: tmpData
                  })
                }, 1000);
              }
            })
          }

          if(currentIndex == 1){
            tmpData.splice(index,1); 
            that.setData({
              dataList: tmpData
            })
          }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcancelorder ==> fail ==> ", res)
      }
    })
  },
  getShopdelorder: function (order_id, index) {
    var that = this;
    var tmpData = that.data.dataList;
    app.util.request({
      'url': 'entry/wxapp/shopdelorder',
      'cachetime': '30',

      'method': 'POST',
      'data': {
        id: order_id
      },
      success: function (res) {
        console.log("entry/wxapp/shopdelorder ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'success',
            title: '已成功删除拼团!',
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
        console.log("entry/wxapp/shopdelorder ==> fail ==> ", res)
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
                tmpData[index].order_info_2.pay_status = 2;
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
        console.log("entry/wxapp/Pay ==>", res)
        if (res.data && res.data.data && !res.data.errno) {
          //发起支付
          if (res.data.data.collage_id) {
            that.setData({
              pay_collage_id: res.data.data.collage_id
            })
          }
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
                      url: '/longbing_card/pages/shop/releaseCollage/releaseCollage?id=' + tmpData[index].collage_info.goods_id + '&status=toShare&to_uid=' + tmpData[index].order_info.to_uid + '&collage_id=' + that.data.pay_collage_id
                    })
                    // wx.navigateTo({
                    //   url: '/longbing_card/pages/uCenter/order/orderDetail/orderDetail?id=' + tmpData[index].order_info.id
                    // })
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
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var tmpData = that.data.dataList;
    if (status == 'toProductDetail' || status == 'toOrderDetail' || status == 'toAgain') {
      app.util.goUrl(e)
    } else if (status == 'toCancel') {
      console.log("取消订单")
      that.getShopcancelorder(tmpData[index].order_info_2.id, index);
    } else if (status == 'toWxPay') {
      console.log("确认付款")
      let toWxPayStatus = that.data.toWxPayStatus;
      if(toWxPayStatus == 0){
        that.setData({
          toWxPayStatus: 1
        },function(){
          that.getWxPay(tmpData[index].order_info_2.id, index);
        })
      }
    } else if (status == 'toRefund') {
      console.log("申请退款")
      that.getRefund(tmpData[index].order_info_2.id, index);
    }  else if (status == 'toDelete') {
      console.log("删除拼团")
      that.getShopdelorder(tmpData[index].order_info_2.id, index);
    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var index = e.detail.target.dataset.index;
    var status = e.detail.target.dataset.status;
    that.toSaveFormIds(formId);
    if (status == 'toCollage') {
      that.setData({
        currentIndex: index,
        currentTab: status,
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