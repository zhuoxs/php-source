// zhls_sun/pages/manager/center/center.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    hideRuzhu: true,
    balance_sj:'',//可提现余额
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log(options)
    var that=this;
    var userid = options.userid;
    // var userid = 4;
    var url = wx.getStorageSync('url')
    that.setData({
      // id: id,
      url: url,
    })
    
    var openid = wx.getStorageSync('openid');//用户openid
    app.util.request({
      'url': 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        wx.setStorageSync('user_id', res.data.id);
      }
    }) 

    setTimeout(function () {
        var user_id = wx.getStorageSync('user_id');//用户user_id
        app.util.request({
          'url': 'entry/wxapp/Data_sj',
          data: {
            user_id: user_id,
          },
          success: function (res) {
            console.log('查看商家数据');
            console.log(res);
            that.setData({
              balance_sj: res.data.balance
            })
          }
        })  
     }, 500)   
    
  },
  
  //查询订单号
  checkOrderNum(e) {
    console.log(e.detail.value)
    this.setData({
      orderNum: e.detail.value
    })
  },

  withDrawalTap(e){
    console.log(e);
    wx.navigateTo({
      url: '../withDrawal/withDrawal?balance_sj=' + e.currentTarget.dataset.balance_sj,
    })
  },

  deterBtn(e) {
    var that = this;
    var orderNum = that.data.orderNum;
    var id = wx.getStorageSync('user_id');
    var url = wx.getStorageSync('url');
    console.log(id);
    app.util.request({
      'url':'entry/wxapp/WriteOrder',
      data:{
        orderNum: orderNum,
        user_id:id,
      },
      success:function(res){
        console.log(res)
        that.setData({
          info:res.data,
          hideRuzhu: false,
          url: url,
        })
     
      }
    })

  },
  applyFor: function (e) {
    console.log(e.currentTarget.dataset.id)
    var that = this;
    var id = e.currentTarget.dataset.id;
    // var userid = that.data.userid;
    app.util.request({
      'url': 'entry/wxapp/DoWriteOrder',
      'cachetime': '30',
      data: {
        id: id,
        // userid: userid,
      },
      success: function (res) {
        console.log(res)
        if (res.data == 1) {
          wx.showToast({
            title: '核销成功！',
          })
         
        }
      }
    })
    that.setData({
      hideRuzhu: true,
      orderNum: ''
    })
    that.onShow();
  },
  // 调用扫码方法
  saomaCode(e) {
    wx.scanCode({
      success: (res) => {
        console.log(res)
      }
    })
  },

  // 语音播报
  settingTap(e) {
    wx.navigateTo({
      url: '../audio/audio',
    })
  },

  
  // 回到首页
  backIndex() {
    wx.redirectTo({
      url: '../index/index',
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },



  onShow: function () {
    this.getUserInfo();
  },
  getUserInfo: function () {
    var that = this;
    wx.login({
      success: function () {
        wx.getUserInfo({
          success: function (res) {
            console.log(res);
            that.setData({
              userInfo: res.userInfo
            });
          }
        })
      }
    })
  },

  closePopupTap(e) {
    this.setData({
      hideRuzhu: true
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

  }
})