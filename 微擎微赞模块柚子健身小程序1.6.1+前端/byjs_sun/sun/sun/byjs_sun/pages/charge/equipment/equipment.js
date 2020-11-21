// byjs_sun/pages/charge/equipment/equipment.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list:[
      {
        imgSrc:'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg',
        name:'动感单车静音磁控健身',
        price:'68',
      },
    
    ]
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
    let id = options.id
    app.util.request({
      'url':'entry/wxapp/GetGoods',
      'cachetime':0,
      'data':{
        id:id
      },
      success:function(res){
        that.setData({
          list:res.data
        })
      }
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
  goUrl:function(e){
    var that = this
    let id = e.currentTarget.dataset.id
    wx: wx.navigateTo({
      url: '/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=' + id,
    })
  }
})