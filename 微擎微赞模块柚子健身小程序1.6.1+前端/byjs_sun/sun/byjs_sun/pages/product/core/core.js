// byjs_sun/pages/product/core/core.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
     types:[

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


        var id = options.id;
        app.util.request({
          'url':'entry/wxapp/CourseTypeDetail',
          'data': {
            'id':id
          }, 
           success:function(res){
             that.setData({
                  types:res.data
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
  /**表单提交 */
  see:function(e){

    var course_type = e.currentTarget.dataset.id
    wx.navigateTo({
      url: '../equipment/equipment?course_type=' + course_type,
    })
  }
})

