// yzmdwsc_sun/pages/user/bookDet/bookDet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '预约详情',
    status:1,/**1 成功 0失败 */
    uname:"墨纸",
    uphone:'1300000',
    utime:'周二 02-12 10:30',
    remark:'这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的',
    shopaddr:'厦门市集美区'
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })

    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var settings = wx.getStorageSync('settings');
    that.setData({
      settings: settings,
      url: wx.getStorageSync('url'),
    })
    var uid = wx.getStorageSync('openid');
    var order_id=options.order_id;
   // order_id=60;
    //获取订单信息
    app.util.request({
      'url': 'entry/wxapp/getSingleOrder',
      'cachetime': '0',
      data: {
        id: order_id,
        uid: uid,
      },
      success(res) {
        that.setData({
          order: res.data.data
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
  toMap(e){
    var latitude = parseFloat(e.currentTarget.dataset.latitude);
    var longitude = parseFloat(e.currentTarget.dataset.longitude);
    wx.openLocation({
      latitude: latitude,
      longitude: longitude,
      scale: 28
    })
  },
  /**取消预约 */
  toCancel(e){
    var that=this;
    that.setData({
      wx:wx.showModal({
        title: '提示',
        content: '确定取消本次预约吗',
        success:function(res){
          if(res.confirm){
            that.setData({
              status:0
            })
          }
        }
      })
    })
  },
  toBook(e){
    wx:wx.navigateTo({
      url: '../../index/book/book',
      success: function(res) {},
      fail: function(res) {},
      complete: function(res) {},
    })
  }
})