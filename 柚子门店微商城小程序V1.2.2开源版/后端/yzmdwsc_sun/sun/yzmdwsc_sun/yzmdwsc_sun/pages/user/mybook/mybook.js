// yzmdwsc_sun/pages/user/mybook/mybook.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的预约',
    curIndex: 0,
    nav: ['进行中', '已完成'],
    /**正在砍价 */
    curBargain: [
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        booktime:'周二 02-12 10:30'
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        booktime: '周二 02-12 10:30'
      },
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        title: '发财树绿萝栀子花海棠花卉盆栽',
        price: '2.50',
        oldprice: '3.00',
        num: '1',
        booktime: '周二 02-12 10:30'
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
      curIndex: 0,
      url: url,
    })
    var openid = wx.getStorageSync('openid');
    //获取订单
    app.util.request({
      'url': 'entry/wxapp/getBookOrder',
      'cachetime': '0',
      data: {
        uid: openid,
      },
      success(res) {
        that.setData({
          order: res.data
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
  bargainTap(e) {
    var that=this;
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    var openid = wx.getStorageSync('openid');
    //获取订单
    app.util.request({
      'url': 'entry/wxapp/getBookOrder',
      'cachetime': '0',
      data: {
        uid: openid,
        index:index,
      },
      success(res) {
        console.log(res.data);
        that.setData({
          order: res.data
        })
      }
    })
  },
  toBuy(e) {
    /**支付 */
  },
  /**取消订单 */
  toCancel(e) {
    var that = this;
    var index = e.currentTarget.dataset.index;
    var curBargain = that.data.curBargain;
    var order_id=e.currentTarget.dataset.order_id;
    var order = that.data.order;
    var index = e.currentTarget.dataset.index;
    var openid = wx.getStorageSync('openid');
    console.log(order_id)
    wx: wx.showModal({
      title: '提示',
      content: '订单取消后将不再显示',
      success: function (res) {
        if (res.confirm) {
       /*   curBargain.splice(index, 1);
          that.setData({
            curBargain: curBargain
          })*/
          app.util.request({
            'url': 'entry/wxapp/cancelOrder',
            'cachetime': '0',
            data: {
              uid: openid,
              order_id: order_id
            },
            success(res) {
              order[index].order_status = 7;
              that.setData({
                order: order,
              })
            }
          })
        }
      }
    })
  },
  /***删除订单 */
  toDelete(e) {
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
  },
  ToBookdet(e){
    var id=e.currentTarget.dataset.id;
    wx: wx.navigateTo({
      url: '../bookDet/bookDet?order_id='+id,
    })
  }, 
  toIndex(e) {
    wx.redirectTo({
      url: '/yzmdwsc_sun/pages/index/index',
    })
  }
})