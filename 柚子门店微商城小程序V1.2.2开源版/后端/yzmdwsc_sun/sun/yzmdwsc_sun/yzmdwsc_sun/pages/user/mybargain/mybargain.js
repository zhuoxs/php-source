// yzmdwsc_sun/pages/user/mybargain/mybargain.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我发起的砍价',
    curIndex: 0,
    nav: ['正在砍价中', '已完成'],
    /**正在砍价 */
    curBargain:[
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice:'3.00',
        num: '1'
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1'
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1'
      }
    ],
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
    var url = wx.getStorageSync('url');
    this.setData({
      url: url,
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
    var that=this;
    var openid = wx.getStorageSync('openid');
    //获取砍价信息
    app.util.request({
      'url': 'entry/wxapp/getUserBargain',
      'cachetime': '0',
      data: {
        openid: openid,
        index:that.data.curIndex
      },
      success(res) {
        that.setData({
          bargain: res.data
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
  onShareAppMessage: function (res) {
    if (res.from === 'button') {
      // 来自页面内转发按钮 
      var gid = res.target.dataset.gid;
      var gname=res.target.dataset.gname;
      var openid = wx.getStorageSync('openid');
      return {
        title: gname,
        path: 'yzmdwsc_sun/pages/index/help/help?id=' + gid + '&openid=' + openid,
        success: function (res) {
          console.log('转发成功')
        },
        fail: function (res) {
          console.log('转发失败')
        }
      }
    }
  },
  bargainTap(e) {
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    var that = this;
    var openid = wx.getStorageSync('openid');
    //获取砍价信息
    app.util.request({
      'url': 'entry/wxapp/getUserBargain',
      'cachetime': '0',
      data: {
        openid: openid,
        index: that.data.curIndex
      },
      success(res) {
        that.setData({
          bargain: res.data
        })
      }
    })




  },
  toBuy(e){
    /**支付 */
    var gid=e.currentTarget.dataset.gid;
    wx.navigateTo({
      url: '../../index/bardet/bardet?gid=' + gid,
    })
  },
  /**删除订单 */
  toCancel(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var curBargain = that.data.curBargain;
    wx: wx.showModal({
      title: '提示',
      content: '订单删除后将不再显示',
      success: function (res) {
        if (res.confirm) {
          curBargain.splice(index, 1);
          that.setData({
            curBargain: curBargain
          })
        }
      }
    })
  }
})