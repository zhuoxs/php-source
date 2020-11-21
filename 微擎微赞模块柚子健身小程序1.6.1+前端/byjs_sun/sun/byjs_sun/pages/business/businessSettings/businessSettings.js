Page({

  /**
   * 页面的初始数据
   */
  data: {
    switchShow:true
  },
  shangeSwich: function () {
    var that = this
    var switchShow = that.data.switchShow
    switchShow = !switchShow
    that.setData({
      switchShow: switchShow
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    
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
  goIndex: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessIndex2/businessIndex',
    })
  },
  //首页
  goOrder: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessOrder/businessOrder',
    })
  }
})