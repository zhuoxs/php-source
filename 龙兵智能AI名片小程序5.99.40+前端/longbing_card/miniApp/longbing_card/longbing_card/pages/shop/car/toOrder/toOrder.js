var app = getApp();
import util from '../../../../resource/js/xx_util.js';
import { userModel } from '../../../../resource/apis/index.js'
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
    if (options.status) {
      paramData.status = options.status;
      var tmpTitle;
      var tmpOrderData = wx.getStorageSync("storageToOrder");
      if (options.status == 'toOrder' || options.status == 'toCarOrder') {
        tmpTitle = '去结算';
        paramData.tmpFailUrl =  '/longbing_card/pages/uCenter/order/orderList/orderList?currentTab=1'
        paramData.tmpSuccessUrl =  '/longbing_card/pages/uCenter/order/orderList/orderList?currentTab=2'
      }
      if (options.status == 'toCollage') {
        tmpTitle = '发布拼团';
        paramData.tmpFailUrl =  '/longbing_card/pages/uCenter/order/collageList/collageList?currentTab=0'
        paramData.tmpSuccessUrl =  '/longbing_card/pages/shop/releaseCollage/releaseCollage?id=' + tmpOrderData.dataList[0].goods_id + '&status=toShare&to_uid=' + app.globalData.to_uid + '&collage_id='
      }
      if (options.status == 'toJoinCollage') {
        tmpTitle = '参加拼团';
        paramData.tmpFailUrl =  '/longbing_card/pages/uCenter/order/collageList/collageList?currentTab=0'
        paramData.tmpSuccessUrl =  '/longbing_card/pages/shop/releaseCollage/releaseCollage?id=' + tmpOrderData.tmp_trolley_ids + '&status=toShare&to_uid=' + app.globalData.to_uid + '&collage_id='
      }
      wx.setNavigationBarTitle({
        title: tmpTitle
      })
    }

    if(options.sharestatus){
      paramData.sharestatus = options.sharestatus
    }

    if (wx.getStorageSync("storageToOrder")) {
      paramData.orderData = wx.getStorageSync("storageToOrder");
    }
    var tmpGoodsId;
    var tmpFreightPrice = 0;
    var tmpListData = paramData.orderData.dataList;
    for (let i in tmpListData) {
      if (!tmpGoodsId) {
        tmpGoodsId = tmpListData[0].goods_id;
      }

      if (tmpGoodsId == tmpListData[i].goods_id) {
        tmpListData[i].toCountFreightPrice = 1
      }

      if (i > 0) {
        if (tmpListData[i].goods_id != tmpListData[i - 1].goods_id) {
          tmpGoodsId = tmpListData[i].goods_id;
          tmpListData[i].toCountFreightPrice = 1;
        } else {
          tmpListData[i].toCountFreightPrice = 0;
        }
      }

      if (tmpListData[i].toCountFreightPrice == 1) { 
        tmpFreightPrice += (tmpListData[i].freight*1)
      }
    }

    paramData.orderData.freight_price = tmpFreightPrice;
    paramData.orderData.countPayMoney = (paramData.orderData.count_price*1 +tmpFreightPrice*1); 
    paramData.orderData.countPayMoney2 = paramData.orderData.countPayMoney; 
    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })
    that.getAddressList();
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
    var that = this;
    var tmpGlobalData = app.globalData;
    var checkAddress_cur = {};
    if(tmpGlobalData.checkAddress_cur){
      checkAddress_cur = tmpGlobalData.checkAddress_cur;
      that.setData({
        checkAddress_cur,
      })
    }  
    let { paramData } = that.data;
    if(tmpGlobalData.checkvoucher){
      paramData.orderData.countPayMoney2 = paramData.orderData.countPayMoney - tmpGlobalData.checkvoucher.reduce;
    }
    that.setData({
      globalData: tmpGlobalData,
      paramData
    })
  },
  onHide: function () {
    // 页面隐藏
    app.globalData.checkvoucher = false;
    wx.removeStorageSync("storageToOrder");
  },
  onUnload: function () {
    // 页面关闭
    app.globalData.checkvoucher = false;
    wx.removeStorageSync("storageToOrder");
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    wx.showNavigationBarLoading();
    that.getAddressList();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getAddressList: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopmyaddress',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        console.log("entry/wxapp/shopmyaddress ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          for (let i in tmpData) {
            if (tmpData[i].is_default == 1) {
              app.globalData.checkAddress = tmpData[i];
            }
          }
          if(app.globalData.checkAddress){
            that.setData({
              checkAddress_cur: app.globalData.checkAddress
            })
          }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopmyaddress ==> fail ==> ", res)
      }
    })
  },
  getProductOrder: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopplaceorder',
      'cachetime': '30',
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopplaceorder ==>", res)
        if (!res.data.errno) { 
          var tmpData = that.data.paramData.orderData.dataList;
          for (let i in tmpData) {
            that.toShopDelTrolley(tmpData[i].id)
          } 
          that.getWxPay(res.data.data.order_id);
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopplaceorder ==> fail ==> ", res)
      }
    })
  },
  getOnlyOrder: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopplaceorder2',
      'cachetime': '30',
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopplaceorder2 ==>", res)
        if (!res.data.errno) {
          that.getWxPay(res.data.data.order_id);
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopplaceorder2 ==> fail ==> ", res)
      }
    })
  },
  getCollageOrder: function (paramObj) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopstartcollage',
      'cachetime': '30',
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopstartcollage ==>", res)
        if (!res.data.errno) {
          that.getWxPay(res.data.data.order_id);
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopstartcollage ==> fail ==> ", res)
      }
    })
  },
  getJoinCollageOrder: function (paramObj) {
    var that = this;  
    app.util.request({
      'url': 'entry/wxapp/shopjoincollage',
      'cachetime': '30',
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        console.log("entry/wxapp/shopjoincollage ==>", res)
        if (!res.data.errno) {


          that.getWxPay(res.data.data.order_id);
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopjoincollage ==> fail ==> ", res)
        wx.showModal({
          title: '',
          content: res.data.message,
          showCancel: false,
          confirmText: '知道啦',
          success: res => {
            if (res.confirm) {
              wx.navigateBack();
            }
          }
        })
      }
    })
  },
  toShopDelTrolley: function (carid) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/ShopDelTrolley',
      'cachetime': '30',
      
      'method': 'POST',
      'data': {
        id: carid
      },
      success: function (res) {
        console.log("entry/wxapp/ShopDelTrolley ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopDelTrolley ==> fail ==> ", res)
      }
    })
  },
  getWxPay: function (order_id) {
    var that = this;
    app.util.showLoading(1);
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
          if(res.data.data.collage_id){
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
                icon:'none',
                image: '/longbing_card/resource/images/alert.png',
                title:'支付成功',
                duration: 2000
              })
              setTimeout(() => {
                var tmpURl = that.data.paramData.tmpSuccessUrl;
                if(that.data.paramData.status == 'toCollage' || that.data.paramData.status == 'toJoinCollage'){
                  tmpURl = tmpURl + that.data.pay_collage_id
                }
                console.log(tmpURl,"tmpURL")
                if(that.data.paramData.sharestatus == 'fromshare'){
                  tmpURl = tmpURl + '&sharestatus=fromshare'
                  wx.reLaunch({
                    url: tmpURl
                  }) 
                } else {
                  wx.redirectTo({
                    url: tmpURl
                  })
                }
                
              }, 1000);
            },
            'fail': function (res) {
              wx.showToast({
                icon:'none',
                image: '/longbing_card/resource/images/error.png',
                title:'支付失败',
                duration: 2000
              })
              setTimeout(() => { 
                wx.redirectTo({
                  url: that.data.paramData.tmpFailUrl
                })
              }, 1000);
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
              setTimeout(() => { 
                wx.redirectTo({
                  url: that.data.paramData.tmpFailUrl
                })
              }, 1000);
            }
          }
        })
      }
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var tmpAddressID = that.data.checkAddress_cur.id;
    if (status == 'toCheckAddress' || status == 'toProductDetail' || status == 'toJumpUrl') {
      console.log("选择地址 || 跳转至产品详情")
      if(status == 'toJumpUrl'){
      
        if (!tmpAddressID) {
          wx.showToast({
            icon: 'none',
            title: '请选择收货地址！',
            duration: 2000
          })
          return false;
        }
  
        app.util.goUrl(e);
      } else {
        app.util.goUrl(e);
      }
    } else if (status == 'toWxPay') {
      
      if (!tmpAddressID) {
        wx.showToast({
          icon: 'none',
          title: '请选择收货地址！',
          duration: 2000
        })
        return false;
      }

      
      let toWxPayStatus = that.data.toWxPayStatus;
      if(toWxPayStatus == 0){
        that.setData({
          toWxPayStatus: 1
        },function(){
            let paramObj = {
              address_id: tmpAddressID,
              to_uid: app.globalData.to_uid,
            }

            let { checkvoucher } = that.data.globalData;
            if (that.data.paramData.status == 'toOrder') {
              var tmpParamOrder = that.data.paramData.orderData.dataList;
              paramObj.number = tmpParamOrder[0].number;
              paramObj.goods_id = tmpParamOrder[0].goods_id;
              paramObj.spe_price_id = tmpParamOrder[0].spe_price_id;
              if(checkvoucher.id){
                paramObj.record_id = checkvoucher.id
              } 
              that.getOnlyOrder(paramObj);
            }
            if (that.data.paramData.status == 'toCarOrder') {
              paramObj.trolley_ids = that.data.paramData.orderData.tmp_trolley_ids;
              if(checkvoucher.id){
                paramObj.record_id = checkvoucher.id
              }  
              that.getProductOrder(paramObj);
            }
            if (that.data.paramData.status == 'toCollage' || that.data.paramData.status == 'toJoinCollage') {
              var tmpGoods = that.data.paramData.orderData.dataList;
              paramObj.collage_id = tmpGoods[0].collage_id;
              paramObj.number = tmpGoods[0].number;
              
              if(that.data.paramData.status == 'toCollage'){ 
                paramObj.goods_id = tmpGoods[0].goods_id;
                that.getCollageOrder(paramObj);
              }
              if(that.data.paramData.status == 'toJoinCollage'){ 
                paramObj.goods_id = that.data.paramData.orderData.tmp_trolley_ids;
                that.getJoinCollageOrder(paramObj);
              }
            }
        })
      }
    }
  }
})