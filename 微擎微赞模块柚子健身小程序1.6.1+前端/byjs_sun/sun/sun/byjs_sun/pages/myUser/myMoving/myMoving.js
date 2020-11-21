// byjs_sun/pages/myUser/myMoving/myMoving.js
var app =getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0,
    commentimgsrc: '../../../resource/images/find/icon-comment.png',
    status: 0,//0关注1已关注
    lovestatus: 0,//点赞0灰色1红色
    loveimgsrc1: "../../../../byjs_sun/resource/images/find/icon-love.png",//点赞灰色背景路径
    loveimgsrc2: "../../../../byjs_sun/resource/images/find/icon-love-1.png",//点赞红色背景路径
    lovenum: 0,//点赞数字
    lovenumadd1: 1,
    talent: [],
    gowith: [],
    seeall: "全文",
    hideall: "收起",
    page: 1,
    user: {
    
    },
    talent: [
        
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
    })
    // 获取动态
    app.util.request({
      'url':'entry/wxapp/GetMyMoving',
      'data':{
        user_id:wx.getStorageSync('users').id
      },
      'cachetime':0,
      success:function(res){
          that.setData({
            talent:res.data
          })
      }
    }),
    // 获取用户
    app.util.request({
      'url':'entry/wxapp/GetMyInfo',
      'data': {
        user_id: wx.getStorageSync('users').id
      },
      'cachetime': 0,
      success:function(res){
        that.setData({
          user:res.data
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
  // 删除我的动态
  cut:function(e){
    var that = this
    var id = e.currentTarget.dataset.id
    wx.showModal({
      title: '提示',
      content: '确认删除?',
      success: function (res) {
        if (res.confirm) {
          app.util.request({
            'url': 'entry/wxapp/CutMyMoving',
            'data': {
              id: id
            },
            'cachetime': 0,
            success: function (res) {
              that.onLoad()
            }

          })
        } else if (res.cancel) {

        }
      }
    })
   
  },
  //页面跳转（详情）
  gointeractiveInfoone: function (e) {
    var expert_id = e.currentTarget.dataset.id; //获取内容id
    wx.navigateTo({
      url: '../../find/interactive/interactiveInfoone/interactiveInfoone?id=' + expert_id,
    })
  },

})