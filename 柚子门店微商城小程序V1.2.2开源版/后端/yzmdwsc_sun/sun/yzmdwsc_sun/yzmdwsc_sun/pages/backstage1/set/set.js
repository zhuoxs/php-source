// sxzs_sun/pages/backstage/set/set.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    sets: [
      { sets: 'shop', 'status': true },
      { sets: 'order', 'status': true },
    ]
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
  switchChange(e) {
    const status = e.detail.value;
    const index = e.currentTarget.dataset.index;
    let sets = this.data.sets;
    sets[index].status = !status;
    this.setData({
      sets: sets
    })

  },
  toIndex(e) {
    wx.redirectTo({
      url: '../index/index'
    })
  },
  toMessage(e) {
    wx.redirectTo({
      url: '../publish/publish'
    })
  }
})