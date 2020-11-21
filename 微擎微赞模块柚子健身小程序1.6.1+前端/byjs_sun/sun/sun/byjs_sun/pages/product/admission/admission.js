// byjs_sun/pages/product/admission/admission.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    pade:[
        
    ],
    logo:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
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
    // 获取会员卡类型
    app.util.request({
      'url':'entry/wxapp/Vipcard',
      success:function(res){
    
        that.setData({
          pade:res.data
        })
      }
    })
    // 获取大LOGO
    // app.util.request({
    //   'url':'entry/wxapp/Logo',
    //   'cachetime':'30',
    //   success:function(res){
    //     that.setData({
    //       logo:res.data
    //     })
    //   }
    // })
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
  thisIndexStatus: function(e){
    let thisIndex = e.currentTarget.dataset.index
    let yData = JSON.parse(JSON.stringify(this.data.pade))
    if(yData[thisIndex].status === false){
      yData = this.forDataSet(yData)
      yData[thisIndex].status = true
    }else{
      yData = this.forDataSet(yData)
      yData[thisIndex].status = false
    }
    this.setData({
      pade: yData
    })
  },
  //重置
  forDataSet: function(data){
    for(let i in data){
      data[i].status = false
    }
    return data
  },
  // 填写
  write:function(e){
      var that =this
       that.setData({
         name: e.detail.value,

       })
  },
  write1: function (e) {
    var that = this
    that.setData({
      tel: e.detail.value,

    })
  },
  write2: function (e) {
    var that = this
    that.setData({
      g: e.detail.value,

    })
  },
 
  radiochange: function(e) {
    var that = this
    that.setData({
      id: e.detail.value,

    })
  },
 
  
  // 用户提交
  goSubmit:function(e){
      var that  =this 
       // 会员卡价格获取
       app.util.request({
         'url':'entry/wxapp/GetCardPrice',
         'data':{
           id:that.data.id
         },
         success:function(res){
           that.setData({
             price:res.data
           })
         }
       })
      if (that.data.name == null){
          wx.showModal({
            title: '',
            content: '请填写用户名',
          })
      }else{
        //-----------付款---------------
        wx.getStorage({
          key: 'openid',
          success: function (res) {
            var openid = res.data;
            var price = that.data.price.card_price
            app.util.request({
              'url': 'entry/wxapp/Orderarr',
              'cachetime': '30',
              data: {
                price: price,
                openid: openid,
              },
              success: function (res) {
                var goods = wx.getStorageSync('new')
                var user_id = wx.getStorageSync('users').id
                console.log('-----直接购买=------')
                app.util.request({
                  'url': 'entry/wxapp/Order',
                  'cachetime': '0',
                  data: {
                    'user_id': user_id,
                    'money': that.data.price.card_price,
                    'user_name': that.data.name,
                    'tel': that.data.tel,
                    'good_name': '会员卡',                
                    'good_money': that.data.price.card_price,

                  },
                  success: function (o) {
                    console.log(o.data)
                    var order_id = o.data;
                    console.log(res)
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
                        wx.redirectTo({
                         
                          url: '../index/index',
                        })

                      },
                      'fail': function (result) {
                        wx.redirectTo({

                          url: '../index/index',
                        })
                      }
                    });
                  }
                })

              }
            })
          },
        })
      
  }
  }
})