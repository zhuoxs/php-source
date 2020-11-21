var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    user: {
      userImg: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
      userBackImg: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
      userName: 'amorno',
      userSex: '0',
      userAttention: '2',
      userFans: '3',
      movingImg: ['http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png', 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png'],
      userMovingNumber: '2'
    },
    fight: [],
    order_num: '',
    backimg:'',

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
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
    }),
      // 获取商家头像
      app.util.request({
        'url': 'entry/wxapp/GetBusinessUserInfo',
        'cachetime': '0',
        'data': {
          name: wx.getStorageSync('business_name')
        },
        success: function (res) {
          that.setData({
            user: res.data
          })
        },
      })
    //获取商户背景
    app.util.request({
      'url': 'entry/wxapp/GetBusinessImg',
      'cachetime': '0',
    
      success: function (res) {
        that.setData({
          backimg: res.data
        })
      },
    })
    // 获取首页信息
    app.util.request({
      'url': 'entry/wxapp/GetBusinessIndexInfo',
      'cachetime': 0,
      success: function (res) {
        that.setData({
          fight: res.data

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
  //自定义方法
  goOrder: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessOrder/businessOrder',
    })
  },
  //设置
  goSettings: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessSettings/businessSettings',
    })
  },
  //扫码核销
  soso: function () {
    wx.scanCode({
      success: function (e) {
        console.log(e)
        //result这里面是扫码所获得的内容
      }
    })
  },
  // 
  ordernum: function (e) {
    console.log(e)
    var that = this
    that.setData({
      order_num: e.detail.value
    })
  },
  confirm: function () {
    var that = this
    let order_num = that.data.order_num
    app.util.request({
      'url': 'entry/wxapp/OrderConfirm',
      'data': ({
        order_num: order_num
      }),
      success: function (res) {
        wx.showModal({
          title: '成功',
          content: '核销成功',
        })
      }
    })
  },
  loginout: function () {
    wx.removeStorageSync('business_name'),
      wx.showModal({
        title: '',
        content: '你确认退出',
        success: function (res) {
          if (res.confirm) {
            
            wx.redirectTo({
              url: '../../../../byjs_sun/pages/product/index/index',
            })
          }

        }
      })
  },
  //自定义方法
  goOrder: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/business/businessOrder/businessOrder',
    })
  },
})