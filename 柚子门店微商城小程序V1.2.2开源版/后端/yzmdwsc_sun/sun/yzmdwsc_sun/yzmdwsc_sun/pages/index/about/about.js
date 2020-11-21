// yzmdwsc_sun/pages/index/about/about.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '关于我们',
    banner:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031597.png',
    address:'福建省厦门市集美区杏林湾街道',
    phone:'1300000',
    openTime:'09:00-21:00',
    provide:['停车位','wifi','支付宝支付','微信支付'],
    shopDes:'柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品',
    shopDet: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031605.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031605.png']
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var settings = wx.getStorageSync('settings');
    var url=wx.getStorageSync('url');
    console.log(url)
    this.setData({
      settings: settings,
      url:url
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
  toDialog(e){
    wx:wx.makePhoneCall({
      phoneNumber: this.data.settings.tel, 
    })
  },
  /**地图 */
  toMap(e){
     console.log(e);
     var latitude = parseFloat(e.currentTarget.dataset.latitude);
     var longitude =parseFloat(e.currentTarget.dataset.longitude);
     wx.openLocation({
       latitude: latitude,
       longitude: longitude,
      scale: 28
    })

  }
})