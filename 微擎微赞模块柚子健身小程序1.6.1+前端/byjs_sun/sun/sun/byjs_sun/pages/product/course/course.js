var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    id:1,
    productRecommend: [
      {
        recommendImg: 'http://img.zcool.cn/community/03879005798abdc0000018c1b07f124.jpg',
        recommendTitle: '怎鸡肉课程',
        recommendPic: '858',
        instructor:'小名',
        type:'私教课',
        time:'1月8日 19：00-20：00'
      },
      {
        recommendImg: 'http://img.zcool.cn/community/03879005798abdc0000018c1b07f124.jpg',
        recommendTitle: '怎鸡肉课程',
        recommendPic: '',
        instructor: '大民',
        type:'公开课',
        time:'1月9日 19：00-20：00'
      },
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
        var that = this;
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

        app.util.request({
          'url':'entry/wxapp/Course',
           success:function(res){
             console.log(res)
             that.setData({
               productRecommend:res.data
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
  goCourseInfo: function(e){
      let id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '/byjs_sun/pages/product/courseGoInfo/courseGoInfo?id='+id,
    })
  }
})