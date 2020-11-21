// byjs_sun/pages/product/allcourse/allcourse.js
var app =getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    allcourse:[
      {
        imgSrc:'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png',
        name:'增肌增重课程',
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
    // 获取课程分类
    app.util.request({
      'url': 'entry/wxapp/CourseType',
      'cachetime': '30',
      success: function (res) {
        console.log(res.data)
        that.setData({
          allcourse: res.data
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
  // 跳转
  goBay: function (e) {
    var id = e.currentTarget.dataset.id
    wx.navigateTo({
      url: '/byjs_sun/pages/product/core/core?id=' + id,
    })
  },
})