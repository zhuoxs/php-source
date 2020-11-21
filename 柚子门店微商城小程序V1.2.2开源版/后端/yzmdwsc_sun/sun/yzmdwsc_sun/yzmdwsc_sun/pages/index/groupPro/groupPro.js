// yzmdwsc_sun/pages/index/groupPro/groupPro.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '拼团流程',
    process: "开团方式：选择你喜欢的商品支付开团成功后可分享商品给好友，或通过参团码参团；参团方式：进入到朋友分享的页面，点击“立即参团”的按钮，付款后即可成功，也可以通过参团人分享的参团码来进行拼团；"
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
    var settings = wx.getStorageSync('settings');
    this.setData({
      settings: settings,
    })

    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
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
  
  }
})