// yzmdwsc_sun/pages/user/couponDet/couponDet.js
const app = getApp()
var wxbarcode = require('../../../../style/utils/index.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '优惠券详情',
    shopname:'柚子鲜花坊',
    price: '30',
    minprice: '398',
    time: '2018.01.12-2018.02.12',
    remark:'本优惠券仅适用于线下门店x消费使用，请到店出示二维码，给店员核销，如有疑问咨询商家客服',
    phone:'0582-0000',
    explain:"这里是使用说明啊啊啊啊啊啊"/**使用说明 */
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
    var id=options.id;
    var url = wx.getStorageSync('url');
    var openid = wx.getStorageSync('openid');
    var settings = wx.getStorageSync('settings');
    that.setData({
      url:url,
      settings:settings,
    })
    //获取优惠券详情
    app.util.request({
      'url': 'entry/wxapp/getCouponDetail',
      'cachetime': '0',
      data: {
        uid: openid,
        id: id,
      },
      success(res) {
        that.setData({
          coupondetail: res.data.data
        })
      }
    })
    

   // wxbarcode.qrcode('qrcode', 'https://www.cnblogs.com/chen-lhx/p/8418321.html', 260, 260);
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
  dialog(e) {
    wx.makePhoneCall({
      phoneNumber: this.data.settings.tel,
    })
  }
})