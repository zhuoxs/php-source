// yzmdwsc_sun/pages/index/bookDet/bookDet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商品详情',
    imgArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png'],
    goodsDet: [
      {
        title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
        price: '399.00',
        freight: '免运费',
        detail: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'
        ],
      }
    ],
    guarantee: [
      '正品保障', '超时赔付', '7天无忧退货'
    ],
    swiperIndex:1
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
    var gid = options.gid;  
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
    var that=this;
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res)
    }
    return {
      title: that.data.goodinfo.goods_name,
      path: 'yzmdwsc_sun/pages/index/bookDet/bookDet?gid='+that.data.gid
    }

  },
  toIndex(e) {
    wx: wx.redirectTo({
      url: '../index',
    })
  },
  toBookorder(e){
    var that=this; 
    //限制条件 检测商品
    app.util.request({
      'url': 'entry/wxapp/checkGoods',
      'cachetime': '0',
      data: {
        gid: that.data.gid,
      },
      success: function (res) {
        wx: wx.navigateTo({
          url: '../bookOrder/bookOrder?gid=' + that.data.gid,
        })  
      }
    })

    
  },
  swiperChange(e) {
    this.setData({
      swiperIndex: e.detail.current + 1
    })
  }

})