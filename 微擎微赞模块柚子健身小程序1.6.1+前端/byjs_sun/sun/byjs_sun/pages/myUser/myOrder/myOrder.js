// byjs_sun/pages/myUser/myOrder/myOrder.js
var app =getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    order:[],
   
    goId: 1
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that =this 
    // --------------------------获取url-----------------------
    app.util.request({
      'url': 'entry/wxapp/Url',
      'cachetime': '30',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    let goId = 1
    let user_id = wx.getStorageSync('users').id
    app.util.request({
      'url': 'entry/wxapp/OrderMy',
      'data': {
        goId: goId,
        user_id: user_id
      },
      'cachetime': 0,
      success: function (res) {
        console.log(res)
        that.setData({
          order: res.data,
          total: res.data.money
        })
      },
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
  //自定义方法
  orderTab: function (e) {
    let that = this 
    console.log(e);
    let goId = Number(e.currentTarget.dataset.id)
    let user_id = wx.getStorageSync('users').id
    app.util.request({
      'url':'entry/wxapp/OrderMy',
      'data':{
        goId:goId,
        user_id:user_id
      },
      'cachetime':0,
      success:function(res){
        that.setData({
          order : res.data,
          total : res.data.money
        })
      }, 
    })
    // for (var i = 0; i < that.data.total.length; ++i) {
    //   var total = 0+total[i]
    //   if (i >= 1) break;
    // }
    that.setData({
      goId: goId
    })
  },
  
  goPay: function (e) {
    //自定义方法  
    var that = this
    var id = e.currentTarget.dataset.id
    var money = e.currentTarget.dataset.money
    var name = e.currentTarget.dataset.name
    var user_name = wx.getStorageSync('users').user_name
    var user_tel = wx.getStorageSync('users').user_tel
    //-----------付款---------------
    wx.getStorage({
      key: 'openid',
      success: function (res) {

        var openid = res.data;
        console.log(openid)
        app.util.request({
          'url': 'entry/wxapp/Orderarr',
          'cachetime': '30',
          data: {
            price: money,
            openid: openid,
          },
          success: function (res) {
            var user_id = wx.getStorageSync('users').id
            console.log('-----直接购买=------')

            var order_id = id;
            console.log(order_id)
            wx.requestPayment({
              'timeStamp': res.data.timeStamp,
              'nonceStr': res.data.nonceStr,
              'package': res.data.package,
              'signType': 'MD5',
              'paySign': res.data.paySign,
              'success': function (result) {
                wx.showToast({
                  title: '支付成功',
                  icon: 'success',
                  duration: 2000
                })
                app.util.request({
                  'url': 'entry/wxapp/PayOrder',
                  'cachetime': '0',
                  data: {
                    order_id: order_id,
                  },
                  success: function (res) {

                  }
                })
                wx.navigateTO({
                  url: '../../product/index/index',
                })

              },
              'fail': function (result) {
                console.log(result + 'ssssss')
              }
            });



          }
        })
      },
    })




  },
    // 催
  goToCall:function(e){
    wx.showLoading({
      title: '商家收到提醒',
    })

    setTimeout(function () {
      wx.hideLoading()
    }, 2000)
  },
  goToPay:function(e){
     var that = this 
     var id = e.currentTarget.dataset.id
     app.util.request({
        'url':'entry/wxapp/ConfirmR',
        'data':{id:id},
        'cachetime':0,
        success(res){
         wx.redirectTo({
           url: '../my/my',
         })
        }
     })
  }
  
})