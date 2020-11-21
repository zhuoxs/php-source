var app = getApp(); 
Page({
  data: {
    globalData: {},
    activeIndex: 100000101,
    showMoreStatus: 0,
    keyword: ''
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数 
    var that = this;
    wx.hideShareMenu(); 
    that.setData({
      globalData: app.globalData
    })
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
    var that = this;
    app.util.showLoading(1);
    that.getShopSearchRecord();
    wx.hideLoading();
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    let that = this;
    wx.showNavigationBarLoading();
    that.getShopSearchRecord();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function () {
    // 用户点击右上角分享
  },
  getShopSearchRecord: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/ShopSearchRecord',
      'cachetime': '30',
      'method': 'POST',
      'data': {
      },
      success: function (res) {
        console.log("entry/wxapp/ShopSearchRecord ==>", res)
        if (!res.data.errno) {
          that.setData({
            Record: res.data.data
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopSearchRecord ==> fail ==> ", res)
      }
    })
  },
  bindinput: function (e) {
    var that = this;
    that.setData({
      keyword: e.detail.value
    })
  }, 
  toSearchBtn: function () {
    var that = this;
    if(!that.data.keyword){
      wx.showToast({
        icon:'none',
        title:'请输入关键词！',
        duration: 2000
      })
      return false
    }
    wx.navigateTo({
      url: '/longbing_card/pages/shop/list/list?keyword=' + that.data.keyword
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status; 
    if(status == 'toSearchKeyWord'){
      if(!that.data.keyword){
        wx.showToast({
          icon:'none',
          title:'请输入关键词！',
          duration: 2000
        })
        return false
      }
      app.util.goUrl(e)
    } else if(status == 'toSearch'){ 
      app.util.goUrl(e)
    }
  }
})