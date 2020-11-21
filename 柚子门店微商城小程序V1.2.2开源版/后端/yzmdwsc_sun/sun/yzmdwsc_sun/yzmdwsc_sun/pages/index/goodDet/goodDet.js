// yzmdwsc_sun/pages/index/goodDet/goodDet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '',
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
    goods: [
      {
        banner: '', /**http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png */
        videoSrc:"http://wxsnsdy.tc.qq.com/105/20210/snsdyvideodownload?filekey=30280201010421301f0201690402534804102ca905ce620b1241b726bc41dcff44e00204012882540400&bizid=1023&hy=SH&fileparam=302c020101042530230204136ffd93020457e3c4ff02024ef202031e8d7f02030f42400204045a320a0201000400",
        title: '蝴蝶兰花苗',
        shareprice: '0.15',
        detail: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'
        ],
        visitnum: 6,
        cont:"这边有文字的这边有文字的这边有文字的这边有文字的这边有文字的这边有文字的这边有文字的"
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
    var navTile = that.data.goods[0].title
    wx.setNavigationBarTitle({
      title: navTile
    });
    var gid = options.gid;
   // gid=13;
    that.setData({
      gid: gid
    })
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    //----------获取商品详情----------
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        console.log(res)
        that.setData({
          goodinfo: res.data.data
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
  onShareAppMessage: function (res) {
    var that = this;
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res)
    }
    return {
      title: that.data.goodinfo.goods_name,
      path: 'yzmdwsc_sun/pages/index/goodDet/goodDet?gid=' + that.data.gid
    }

  },
  toIndex(e) {
    wx: wx.redirectTo({
      url: '../index',
    })
  },
  toShop(e) {
    var that = this;
    var gid = e.currentTarget.dataset.gid;
    //获取商品类型
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        var lid = res.data.data.lid;
        if (lid == 1 || lid == 2 || lid == 3) {
          wx: wx.navigateTo({
            url: '../goodsDet/goodsDet?gid=' + gid,
          })
        } else if (lid == 4) {
          wx: wx.navigateTo({
            url: '../groupDet/groupDet?gid=' + gid,
          })
        } else if (lid == 5) {
          wx: wx.navigateTo({
            url: '../bardet/bardet?gid=' + gid,
          })
        } else if (lid == 6) {
          wx: wx.navigateTo({
            url: '../limitDet/limitDet?gid=' + gid,  
          })
        } else if (lid == 7) {
          wx: wx.navigateTo({
            url: '../shareDet/shareDet?gid=' + gid,
          })
        }

      }
    })
  
  }
})