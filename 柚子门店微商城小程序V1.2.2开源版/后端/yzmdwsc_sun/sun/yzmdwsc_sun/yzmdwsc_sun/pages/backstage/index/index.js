// sxzs_sun/pages/backstage/index/index.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: { 
    list: [
      { title: '今日总访客数', detail: '0' },
      { title: '今日总成交额', detail: '0' },
      { title: '今日订单数', detail: '0' },
      { title: '待接单', detail: '0' },
      { title: '代配送', detail: '0' },
      { title: '退款订单', detail: '0' },
    ],
    finance: [
      { title: '今日收益', detail: '0' },
      { title: '昨日收益', detail: '0' },
      { title: '总计收益', detail: '0' }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var self = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    wx.getUserInfo({
      success: function (res) {
        self.setData({
          thumb: res.userInfo.avatarUrl,
          nickname: res.userInfo.nickName
        })
      }
    })
    console.log(wx.getStorageSync('settings'))
    var openid = wx.getStorageSync('openid');
    self.setData({
      uid: openid,
      settings:wx.getStorageSync('settings')
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
    //获取相关统计信息
    app.util.request({
      'url': 'entry/wxapp/gettongji',
      'cachetime': '0',
      success(res) {
        console.log(res.data)
          that.setData({
              data:res.data,
          })
      }
    })
    //判断用户
    var openid=wx.getStorageSync('openid');
    app.util.request({
      'url': 'entry/wxapp/isHxstaff',
      'cachetime': '0',
      data:{
         uid:openid,
      },
      success(res) {
        that.setData({
          isHxstaff:res.data,
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
  
  onShareAppMessage: function () {
  
  }, */
  toMessage(e) {
    wx.redirectTo({
      url: '../publish/publish'
    })
  },
  toSet(e) {
    wx.redirectTo({
      url: '../set/set'
    })
  },
  scanCode(e) {
    var openid = wx.getStorageSync('openid')
    wx.scanCode({
      success: (res) => {
        var result = res.result;
        app.util.request({
          'url': 'entry/wxapp/setCheckCoupon',
          'cachetime': '0',
          data: {
            uid: openid,
            result: result, 
          },
          success(res) {
            if(res.data.errcode==1){
              var url = "/yzmdwsc_sun/pages/backstage/coupon/coupon?id=" + res.data.user_coupon_id;
              wx.navigateTo({
                url: url
              })
            }else if(res.data.errcode==2){
              var url ="/yzmdwsc_sun/pages/backstage/writeoff/writeoff?orderid="+res.data.orderid+"&uid="+res.data.uid;
              wx.navigateTo({
                url: url 
              })
            }
          } 
        })
     
     /*   wx: wx.showModal({ 
          title: '提示',
          content: result,
          showCancel: false,
          success: function (res) {
            
          }
        })*/
        /*
        wx.navigateTo({
          url: url
        })*/
      }
    })
  },
  toOrderlist(e){
    var that=this;
    var index=e.currentTarget.dataset.index;
    if(index==4){
      wx.navigateTo({
        url: '../orderlist/orderlist',
      })
    }
  },
  toManager(e){
    wx.navigateTo({
      url: '../manager/manager',
    })
  }
})