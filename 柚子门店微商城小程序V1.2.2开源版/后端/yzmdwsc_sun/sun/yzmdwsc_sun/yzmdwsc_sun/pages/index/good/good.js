// yzmdwsc_sun/pages/index/good/good.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '好物',
    classify: ['综合', '最新', '推荐','专栏'],
    curIndex: 0,
    goodsList: [
      {
        title: "蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗蝴蝶兰花苗",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png",
        desc:'发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽'
      },
      {
        title: "蝴蝶兰花苗",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842319.png",
        desc: '发财花卉盆栽花卉盆栽发财树绿萝栀子花海棠花卉盆栽'
      },
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

    //获取好物商品
    app.util.request({
      'url': 'entry/wxapp/getHaowuGoods',
      'cachetime': '0',
      success: function (res) {
        that.setData({
          goodList: res.data
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
  navChange(e) {
    var that = this;
    const index = parseInt(e.currentTarget.dataset.index);
    that.setData({
      show: 0,
      curIndex: index,
      priceFlag: true
    }) 
    //获取好物信息
    app.util.request({
      'url': 'entry/wxapp/getHaowuGoods',
      'cachetime': '0',
      data: {
        index: index,
      },
      success: function (res) {
        that.setData({
          goodList: res.data 
        })
      }
    })
  },
  toGooddet(e){
    var gid = parseInt(e.currentTarget.dataset.id);
    wx: wx.navigateTo({
      url: '../goodDet/goodDet?gid=' + gid,
    })
  }
})