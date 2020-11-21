// yzmdwsc_sun/pages/user/share/share.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的分享',
    curIndex: 0,
    nav: ['分享列表', '分享商品', '分享金'],
    distributList:[
      {
        uthumb:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname:"墨纸",
        time:'2018-05-05 10:10:10',
        money:'0.05'
      },
      {
        uthumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname: "墨纸",
        time: '2018-05-05 10:10:10',
        money: '0.05'
      },
      {
        uthumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg',
        uname: "墨纸",
        time: '2018-05-05 10:10:10',
        money: '0.05'
      },
    ],/**分销 */
    newList: [
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
    ],/**分享商品 */
    cash:'3.00',
    
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
    that.setData({
      url: wx.getStorageSync('url'),
    })
    var openid = wx.getStorageSync('openid');
    var settings=wx.getStorageSync("settings");
    that.setData({
        settings:settings,
    })
 /*   wx: wx.showModal({
      title: '提示',
      content: openid,
      showCancel: false,
      success: function (res) {

      }
    })*/
    //获取分销列表
    app.util.request({
      'url': 'entry/wxapp/getShareRecord',
      'cachetime': '0',
      data: {
        uid: openid,
      },
      success(res) {
        that.setData({
          sharerecord: res.data,
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
    var that = this;
    var openid = wx.getStorageSync('openid');
    app.util.request({
      'url': 'entry/wxapp/getUser',
      'cachetime': '0',
      data: {
        openid: openid,
      },
      success: function (res) {
        that.setData({
          user: res.data,
        })
      },
    })
    //分享金抵扣明细
    app.util.request({
      'url': 'entry/wxapp/getUserMoneyRecord',
      'cachetime': '0',
      data: {
        openid: openid,
        'type':2,
      },
      success: function (res) {
        that.setData({
          record: res.data,
        })
      },
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
  onShareAppMessage: function () {
  
  },
  bargainTap(e) {
    var that=this;
    var openid = wx.getStorageSync('openid');
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    if(index==1){
      app.util.request({
        'url': 'entry/wxapp/getShareGoodsRecord',
        'cachetime': '0',
        data: {
          uid: openid,
        },
        success(res) {
          that.setData({
            shareregoodscord: res.data,
          })
        }
      })
    }else if(index==0){
      //获取分销列表
      app.util.request({
        'url': 'entry/wxapp/getShareRecord',
        'cachetime': '0',
        data: {
          uid: openid,
        },
        success(res) {
          that.setData({
            sharerecord: res.data,
          })
        }
      })
    }
 

  },
})