// yzmdwsc_sun/pages/backstage/coupon/coupon.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    var id=options.id;
  //  id=39;
    var url = wx.getStorageSync('url');
    var openid = wx.getStorageSync('openid');
    var settings = wx.getStorageSync('settings');
    that.setData({
      url: url,
      settings: settings,
      id:id,
    })
    that.getcoupondetail(id);

  },
  //获取优惠券详情
  getcoupondetail(e){
    var that=this;
    app.util.request({
      'url': 'entry/wxapp/getCouponDetail',
      'cachetime': '0',
      data: {
        id: e,
      },
      success(res) {
        that.setData({
          coupondetail: res.data.data
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
  toConfirm(e){
    var that = this;
    var id=e.currentTarget.dataset.id;
    app.util.request({
      'url': 'entry/wxapp/checkUserCoupon',
      'cachetime': '0',
      data: {
        id: id,
        uid:wx.getStorageSync('openid'),
      },
      success(res) {
        if (res.data.errcode == 0) {
          wx: wx.showModal({
            title: '提示',
            content: res.data.errmsg,
            showCancel: false,
            success: function (res) {
              that.getcoupondetail(id);
            } 
          })
        }
       
      }
    })
  },
  toOrderlist(e){
    wx.navigateBack({
    })
  }
})