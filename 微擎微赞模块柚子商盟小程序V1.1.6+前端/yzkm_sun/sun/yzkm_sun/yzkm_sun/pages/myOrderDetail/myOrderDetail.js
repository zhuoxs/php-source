// yzkm_sun/pages/myOrderDetail/myOrderDetail.js
const app = getApp();
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
    var that = this
    console.log('初始下标')
    console.log(options)
    var dd_id=options.id//订单id
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.getStorageSync('url', res.data);
        that.setData({
          url: res.data,
          dd_id: dd_id,
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Order_details',
      data:{
        dd_id: dd_id,
      },
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        that.setData({
          list: res.data,
        })
      }
    })
  },
  // 跳转商品详情页
  details_goods(e){
      var that  =  this;
      var gid = that.data.list.goodsId;
      wx.navigateTo({
        url: '../goodsDetails/goodsDetails?id='+gid,
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
  
  }
})