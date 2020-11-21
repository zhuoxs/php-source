// yzmdwsc_sun/pages/user/coupon/coupon.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的优惠券',
    curIndex: 0,
    nav: ['线上优惠券', '门店优惠券'],
    cards: [
      {
        price: '30',
        minprice: '398',
        time: '2018.01.12-2018.02.12'
      },
      {
        price: '30',
        minprice: '398',
        time: '2018.01.12-2018.02.12'
      }
    ]
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
    var that=this;
    var index=that.data.curIndex;
    var signs=index+1;
    var openid = wx.getStorageSync('openid');
    //获取自己优惠券
    app.util.request({
      'url': 'entry/wxapp/getMyCoupon',
      'cachetime': '0',
      data: {
        uid: openid,
        signs:signs,
      },
      success(res) {
        console.log(res.data.data)
        that.setData({
          coupon: res.data.data, 
        })
      }
    })
  
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
  bargainTap(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    var that = this;
    var openid = wx.getStorageSync('openid');
    var signs = index + 1;
    //获取自己优惠券
    app.util.request({
      'url': 'entry/wxapp/getMyCoupon',
      'cachetime': '0',
      data: {
        uid: openid,
        signs:signs,
      },
      success(res) {
        that.setData({
          coupon: res.data.data
        })
      }
    })
  },
  toGoods(e){
    wx:wx.redirectTo({
      url: '../../shop/shop?currentIndex=1',
    })
  },
  toCoupondet(e){
    var id=e.currentTarget.dataset.id;
    wx: wx.navigateTo({
      url: '../couponDet/couponDet?id='+id,
    })
  }
})