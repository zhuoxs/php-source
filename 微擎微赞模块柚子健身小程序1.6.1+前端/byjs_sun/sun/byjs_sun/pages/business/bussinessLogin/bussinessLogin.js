var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    user:'',
    pow:'',
 
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      var that = this 
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
  //坑爹的检测input方法
  user: function(e){
    this.setData({
      user: e.detail.value
    })
  },
  pow: function(e){
    this.setData({
      pow:e.detail.value
    })
  },
  //自定方法
  goLogin: function(){
    var that = this
    if(this.data.user === ''){
      wx.showToast({
        title: '用户名不能为空',
        icon: 'error',
        duration: 2000
      }) 
      return false
    }else if(this.data.pow === ''){
      wx.showToast({
        title: '密码不能为空',
        icon: 'error',
        duration: 2000
      }) 
      return false
    }else{
      // 验证密码账号
      app.util.request({
        'url': 'entry/wxapp/BussinessLogin',
        'data': {
          account: that.data.user,
          password: that.data.pow,
          user_id: wx.getStorageSync('users').id
        },
        'cachetime': 0,
        success: function (res) {
          console.log(res)
          if (res.data == 1) {
            wx.setStorage({
              key: 'business_name',
              data: that.data.user,
            })
            wx.navigateTo({
              url: '../../../../byjs_sun/pages/business/businessIndex2/businessIndex',
            })
            //登陆成功
          } else {
            //登录失败
            wx.showModal({
              title: '！',
              content: '登录失败，密码或账号错误，请重新输入',
            })
          }
        }
      })
    }
   
  }
})