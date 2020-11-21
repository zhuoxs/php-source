// byjs_sun/pages/product/courseGoInfo/courseGoInfo.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    fight:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
        var that = this;
        let id = options.id;
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
        }),
        
        // 获取具体内容
        app.util.request({
          'url':'entry/wxapp/CourseInfo',
          'data':{'id':id},
          'cachetime':0,
          success:function(res){
            console.log(res);
            that.setData({
                fight:res.data
            })
          }
        })
        // 获取预约金额
        app.util.request({
          'url':'entry/wxapp/GetYymoney',
          'cachetime':0,
          success(res){
            that.setData({
              money:res.data
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
  //自定义方法
  goCourseInfo: function (e) {
    var that = this
    var id = e.currentTarget.dataset.id
    let price = that.data.fight.course_price
    let money = that.data.money.yy_money
    wx.navigateTo({
      url: '/byjs_sun/pages/product/courseInfo/courseInfo?id=' + id + '&money=' + money + '&price=' + price
    })
  }
})