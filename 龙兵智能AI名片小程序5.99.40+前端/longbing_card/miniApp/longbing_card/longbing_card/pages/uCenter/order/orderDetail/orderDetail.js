var app = getApp(); 
var timerOverTime;
Page({
  data: { 
    toWxPayStatus: 0,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this);
    var that = this;
    app.util.showLoading(1);
    wx.hideShareMenu(); 
    var paramData = {};
    if(options.id){
      paramData.id = options.id
    }
    if(options.status){
      paramData.status = options.status
    }
    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })
    that.getDetailData();
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
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
    let that = this;
    wx.showNavigationBarLoading();
    that.getDetailData();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getDetailData: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopmyorderdetail',
      'cachetime': '30', 
      'method': 'POST',
      'data': { 
        id: that.data.paramData.id
      },
      success: function (res) {
        console.log("entry/wxapp/shopmyorderdetail ==>", res)
        if (!res.data.errno) { 
          var tmpData = res.data.data;
          var date = new app.util.date(); 
          tmpData.create_time_2 = date.dateToStr('yyyy-MM-DD HH:mm:ss', date.longToDate(tmpData.create_time * 1000));
          if(tmpData.left_time){
            var tmpOverTimes = tmpData.left_time;
            timerOverTime = setInterval(() => {
              tmpData.left_time = tmpData.left_time - 1;
              let day = parseInt(tmpData.left_time / 24 / 60 / 60);
              day = day > 0 ? day + '天' : '';
              tmpOverTimes = day + date.dateToStr('HH小时mm分ss秒', date.longToDate(tmpData.left_time * 1000));
              that.setData({
                tmpOverTimes: tmpOverTimes
              })
            }, 1000);
          }
          that.setData({
            detailData: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopmyorderdetail ==> fail ==> ", res)
      }
    })
  },
  checktoConsult: function (goods_id) {
    var that = this;
    var tmpToUid = that.data.detailData.to_uid;
    var tmpName;
    let tmpData_data = that.data.detailData;
    let tmp_data_id = [];
    if(tmpData_data.own){
      tmp_data_id.push(tmpData_data.own)
    }
    if(tmpData_data.users){
      tmp_data_id.push(tmpData_data.users)
    }
    for(let i in tmp_data_id){
      if(tmpToUid == tmp_data_id[i].id){
        tmpName = tmp_data_id[i].nickName
      }
    }
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
        url: '/longbing_card/chat/userChat/userChat?chat_to_uid=' + tmpToUid + '&contactUserName=' + tmpName + '&goods_id=' + goods_id
      })
    }
  },
  getShopcancelorder: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopcancelorder',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        id: that.data.paramData.id
      },
      success: function (res) {
        console.log("entry/wxapp/shopcancelorder ==>", res)
        if (!res.data.errno) {
          wx.showToast({
            icon: 'success',
            title: '已成功取消订单!',
            duration: 2000,
            success: function () {
              setTimeout(() => { 
                wx.navigateBack();
              }, 1000);
            }
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcancelorder ==> fail ==> ", res)
      }
    })
  },
  getShopdelorder: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopdelorder',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        id: that.data.paramData.id
      },
      success: function (res) {
        console.log("entry/wxapp/shopdelorder ==>", res)
        if (!res.data.errno) {
          let type = that.data.detailData.type;
          let tmp_msg = '已成功删除订单!'
          if(type == 1){
            tmp_msg = '已成功删除拼团!'
          }
          wx.showToast({
            icon: 'success',
            title: tmp_msg,
            duration: 2000,
            success: function () {
              setTimeout(() => { 
                wx.redirectTo({
                  url: '/longbing_card/pages/uCenter/order/orderList/orderList?currentTab=0'
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
  getShopendorder: function () {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/shopendorder',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        id: that.data.paramData.id
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
                that.setData({
                  'detailData.order_status' : 3
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
  getShopAddTrolley: function (paramObj) {
    var that = this; 
    app.util.request({
      'url': 'entry/wxapp/ShopAddTrolley',
      'cachetime': '30',
      
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/ShopAddTrolley ==>", res)
        if (!res.data.errno) { 
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopAddTrolley ==>  fail ==> ", res)
      }
    })
  },
  getWxPay: function () {
    var that = this;
    app.util.showLoading(1);
    var tmpData = that.data.detailData;
    app.util.request({
      'url': 'entry/wxapp/Pay',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        order_id: that.data.paramData.id
      },
      success(res) {
        console.log("entry/wxapp/Pay ==> fail ==>", res)
        if (res.data && res.data.data && !res.data.errno) {
          wx.hideLoading();
          //发起支付
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
                  tmpData.pay_status = 1;
                  that.setData({
                    detailData: tmpData
                  })
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
          content: res.data.data.message ? '支付失败，'+res.data.data.message : '支付失败，请重试',
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
  toJump:function(e){
    var that = this;
    var status = e.currentTarget.dataset.status;
    var id = e.currentTarget.dataset.id;
    var tmpData = that.data.detailData;
    if(status == 'toProductDetail' || status == 'toCopy' || status == 'toCall' || status == 'toMoreList' || status == 'toCollage'){
      console.log("产品详情 || 复制 || 联系物流 || 更多商品 || 拼单详情")
      app.util.goUrl(e);
    } else if(status == 'toConsult'){
      console.log("联系客服")
      that.checktoConsult(tmpData.goods_info[0].id);
    } else if(status == 'toCancel'){
      console.log("取消订单")
      that.getShopcancelorder();
    } else if(status == 'toWxPay'){
      console.log("去支付")
      let toWxPayStatus = that.data.toWxPayStatus;
      if(toWxPayStatus == 0){
        that.setData({
          toWxPayStatus: 1
        },function(){
          that.getWxPay();
        })
      }
    } else if(status == 'toConfirm'){
      console.log("确认收货")
      that.getShopendorder();
    } else if(status == 'toDelete'){
      console.log("删除订单")
      that.getShopdelorder();
    } else if(status == 'toAgain'){
      // app.util.goUrl(e);
      if(that.data.detailData.type == 0){
        console.log("再次购买 商品")
        // for(let i in tmpData.goods_info){
        //   var paramObj =  {
        //     goods_id: tmpData.goods_info[i].id,
        //     spe_price_id: tmpData.goods_info[i].spe_price_id,
        //     number: tmpData.goods_info[i].addNumber
        //   }
        //   that.getShopAddTrolley(paramObj);
        // }
        // setTimeout(() => {
        //   wx.reLaunch({
        //     url: '/longbing_card/pages/shop/car/carIndex/carIndex'
        //   }); 
        // }, 1000);
        
      } else if(that.data.detailData.type == 1){
        console.log("再次购买 拼团")
        wx.reLaunch({
          url : '/longbing_card/pages/shop/detail/detail?id=' + tmpData.goods_info[0].id + '&to_uid=' + app.globalData.to_uid
        })
      }
    }
  }

})