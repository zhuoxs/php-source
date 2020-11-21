// yzmdwsc_sun/pages/user/shoppay/shoppay.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '到店支付',
    uthumb:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
    shopname:'柚子鲜花坊',
    price:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var url = wx.getStorageSync('url');
    var settings = wx.getStorageSync('settings');
    this.setData({
      url:url,
      settings: settings,
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  },
  bindPrice(e){
    this.setData({
      price: e.detail.value
    })
  },
  /***提交支付 */
  toPay(e){
    var that=this;
    var price=that.data.price || 0;
    var openid = wx.getStorageSync('openid');
    if (price<=0){
      wx:wx.showToast({
        title: '金额不得小于0',
      })
    }else{
      //创建店铺订单
      app.util.request({
        'url': 'entry/wxapp/setShopOrder',
        'cachetime': '0',
        data: {
          openid:openid,
          price:price,
        },
        success(res) {
          if(res.data.errno==0){
            var order_id=res.data.data;
            app.util.request({
              'url': 'entry/wxapp/getPayParam',
              'cachetime': '0',
              data: {
                order_id: order_id,
              },
              success: function (res) {
                wx.requestPayment({
                  'timeStamp': res.data.timeStamp,
                  'nonceStr': res.data.nonceStr,
                  'package': res.data.package,
                  'signType': 'MD5',
                  'paySign': res.data.paySign,
                  'success': function (result) {
                    app.util.request({
                      'url': 'entry/wxapp/PayOrder',
                      'cachetime': '0',
                      data: {
                        order_id: order_id,
                      },
                      success: function (res) {
                        wx.showToast({
                          title: '支付成功',
                          icon: 'success',
                          duration: 2000
                        })
                      }
                    })
                  },
                  'fail': function (result) {
                  }
                });
              }
            })

          }

        }
      })
    }

  }
})