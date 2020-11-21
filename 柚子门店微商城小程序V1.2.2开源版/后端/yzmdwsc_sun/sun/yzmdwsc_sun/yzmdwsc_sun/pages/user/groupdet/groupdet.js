// yzmdwsc_sun/pages/user/groupdet/groupdet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goods:{
      img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
      title: '发财树绿萝栀子花海棠花卉盆栽',
      price: '2.50',
      oldprice: '3.00',
      num: '3',/**当前参与 */
      userNum: 5,
      status:2,
    },
    guarantee: [
      '正品保障', '超时赔付', '7天无忧退货'
    ],
    user: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg']
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    var order_id=options.order_id;
    //order_id=48;
    that.setData({
      order_id:order_id,
    })
    console.log('获取拼单详情')
    app.util.request({
      'url': 'entry/wxapp/getGroupsDetail',
      'cachetime': '0',
      data: {
        order_id: order_id,
      },
      success: function (res) {
        console.log(res.data.data.goodsdetail)
        that.setData({
          groupsdetail:res.data.data
        })
      }
    })
    that.urls()
    return
    let goods = that.data.goods,
        user=that.data.user;
    for (var i = 0; i < (goods.userNum - goods.num) ;i++){
      user.push('../../../../style/images/nouser.png')
    }
    that.setData({
      user: user
    })

  },

  urls: function () {
    var that = this
    //---------------------------------- 异步保存上传图片需要的网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url2',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('url2', res.data)
      },
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
    var order_id = this.data.order_id;

    var title = this.data.groupsdetail.goodsdetail.goods_name
    if (res.from === 'button') {
      console.log(res.target)
    }
    return {
      title: title,
      path: 'yzmdwsc_sun/pages/index/groupjoin/groupjoin?order_id=' + order_id,
      success: function (res) { 
        // 转发成功
      }, 
      fail: function (res) {
        // 转发失败
      }
    }
   
  },
  toGrouppro(e){
    wx.navigateTo({
      url: '../../index/groupPro/groupPro',
    })
  },
  toIndex(e) {
    wx.redirectTo({
      url: '/yzmdwsc_sun/pages/index/index',
    })
  }

})