// byjs_sun/pages/myUser/myFans/myFans.js
var app =getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
   
    date: [
     
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    var user_id = wx.getStorageSync('users').id
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    // -----------------获取粉丝列表--------------------
    app.util.request({ 
      'url':'entry/wxapp/GetFansList',
      'data': {
        user_id: user_id
      },
      'cachetime':0,
      success:function(res){
        that.setData({
          date:res.data
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
  //关注按钮
  attention: function (e) {
    var that = this
    let index_ = e.currentTarget.dataset.index
    var attentionednow = that.data.date[index_].status
    if (attentionednow == 0) {
      attentionednow = 1
    } else {
      attentionednow = 0
    }
    var newstatus = 'date[' + index_ + '].status'
    that.setData({
      [newstatus]: attentionednow
    }); 
  }
})