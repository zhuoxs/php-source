// yzmdwsc_sun/pages/backstage/goodslist/goodslist.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goods:[
      {
        src:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
        name:'这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊'
      },
      {
        src: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
        name: '这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊'
      },
      {
        src: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
        name: '这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊'
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
    var url = wx.getStorageSync('url');
    this.setData({
      url: url,
    })

    //获取商品信息
    app.util.request({
      'url': 'entry/wxapp/getGoodsList',
      'cachetime': '0',
      success: function (res) {
        console.log(res.data)
        that.setData({
          goodslist:res.data,
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
  goodsChoose(e){
    var gid=e.currentTarget.dataset.gid;
    var gname=e.currentTarget.dataset.gname;
    wx.setStorageSync('goodsChoose_gid',gid);
    wx.setStorageSync('goodsChoose_gname',gname );
    wx.navigateBack({
    })
 /*   wx.redirectTo({
      url: '../publish/publish'
    })*/
  }
})