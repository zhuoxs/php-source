// yzmdwsc_sun/pages/index/shareDet/shareDet.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商品详情',
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
    goods: [
      {
        imgUrls: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png'
        ],
        title: '发财树绿萝栀子花海棠花卉盆栽',
        shareprice:'0.15',
        detail: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'
        ],
        visitnum:6
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
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
    var openid=wx.getStorageSync('openid');
    console.log(openid)
 
   
    if (res.from === 'button') {
      console.log(res.target)
    }
    return {
      title: '商品',
      path: '/page/user?id=123',
      success: function (res) {
        // 转发成功
      },
      fail: function (res) {
        // 转发失败
      }
    }

  }
})