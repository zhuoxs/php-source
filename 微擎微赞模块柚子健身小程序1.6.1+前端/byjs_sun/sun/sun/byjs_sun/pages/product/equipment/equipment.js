// byjs_sun/pages/charge/equipment/equipment.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    bannerList:[
      'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg',
      'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg',
      'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg'
    ],
    list:[
     
    ]
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
      // 轮播图
      app.util.request({
        'url': 'entry/wxapp/Banner',
        'cachetime': '30',
        // 成功回调
        success: function (res) {
          // console.log(res.data)
          that.setData({
            bannerList: res.data.lb_imgs

          })

        },
      })

      var course_type = options.course_type
      console.log(options)
      app.util.request({
        'url':'entry/wxapp/TypeCourse',
        'data':{
          course_type:course_type
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
// 跳转事件
  see:function(e){
    var id = e.currentTarget.dataset.id
    wx.navigateTo({
      url: '../courseGoInfo/courseGoInfo?id='+id,
    })
  }
})