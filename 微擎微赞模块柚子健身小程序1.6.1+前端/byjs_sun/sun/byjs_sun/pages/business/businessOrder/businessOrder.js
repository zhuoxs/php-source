var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {

    goId:1,
    yy_money:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
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
    
    app.util.request({
      'url': 'entry/wxapp/OrderBusiness',
      'data': {
        goId: goId,
    
      },
      'cachetime': 0,
      success: function (res) {
        // 获取预约金额
        app.util.request({
          'url': 'entry/wxapp/GetYymoney',
          'cachetime': 0,
          success(res) {
            that.setData({
              yy_money: res.data
            })
          }
        })
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
  goIndex: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessIndex2/businessIndex',
    })
  },
  //设置
  goSettings: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessSettings/businessSettings',
    })
  },
  //自定义方法
  orderTab: function (e) {
    let that = this
    console.log(e);
    let goId = Number(e.currentTarget.dataset.id||4)
   
    app.util.request({
      'url': 'entry/wxapp/OrderBusiness',
      'data': {
        goId: goId,
      },
      'cachetime': 0,
      success: function (res) {
        that.setData({
          order: res.data,
          total: res.data.money
        })
      },
    })
   
    that.setData({
      goId: goId
    })
  },
  // 确认
  goToConfirm:function(e){
    var that = this 
    let id = e.currentTarget.dataset.id
    app.util.request({
      'url': 'entry/wxapp/OrderBusinessConfirm',
      'data': {
        id: id,
      },
      'cachetime': 0,
      success: function (res) {
       
        that.orderTab(e);
        that.setData({
          goId: 4
        })
      },
    })
    
  }

})