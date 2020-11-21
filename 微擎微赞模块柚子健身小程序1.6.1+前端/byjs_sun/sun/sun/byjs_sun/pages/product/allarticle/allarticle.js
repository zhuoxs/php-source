// byjs_sun/pages/product/allarticle/allarticle.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    allarticle: [
      {
        imgSrc: 'http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png',
        name: '增肌增重课程',
      },

    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    var that = this

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

    // 文章
    app.util.request({
      'url': 'entry/wxapp/GoodsArticle',
      'cachetime': '0',
      success: function (res) {
        console.log(res.data);
        that.setData({
          allarticle: res.data
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
  goWritings: function (e) {
    var id = e.currentTarget.dataset.id;
    var goods_id = e.currentTarget.dataset.goods_id;
    // var url = encodeURIComponent('id='+id +'&? goods_id='+goods_id);
    // var url1 = encodeURIComponent(goods_id);
    // console.log(url);
    wx.navigateTo({
      url: '/byjs_sun/pages/product/writings/writingsInfo/writingsInfo?id=' + id + '&goods_id=' + goods_id,
    })
  },
})