var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    
    
    status: 0,//0关注1已关注
    lovestatus: 0,//点赞0灰色1红色
    loveimg: "../../../../byjs_sun/resource/images/find/icon-love.png",//点赞灰色背景路径
    loveimg1: "../../../../byjs_sun/resource/images/find/icon-love-1.png",//点赞红色背景路径
    lovenum: 0,//点赞数字
  
 
    lovestatus: 0, //为0表示未点赞,1表示已经点赞
    talent: [
      
    ],
    
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    //设置首页背景色和字体颜色
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })

    var that = this;
    var user_id = wx.getStorageSync('users').id;
    var url = wx.getStorageSync('url');
    //获取关注列表
    app.util.request({
      'url': 'entry/wxapp/getAttentionList',
      'cachetime': '0',
      data:{
        user_id: user_id
      },
      success(res){
        that.setData({
          talent: res.data,
          url: url
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
  //页面跳转（详情）
  gointeractiveInfoone: function (e) {
    var expert_id = e.currentTarget.dataset.id; //获取内容id
    wx.navigateTo({
      url: '../../find/interactive/interactiveInfoone/interactiveInfoone?id=' + expert_id,
    })
  },
  //点赞
  lovefun: function(e){
    wx.showToast({
      title: '功能正在努力开发中,敬请期待',
      icon: 'none'
    })
  //   var that = this;
  //   var tag = 0; //后台判断标识,为0表示达人圈内容,为1表示结伴行内容
  //   var id = e.currentTarget.dataset.id;//内容id
  //   var lovestatus = this.data.lovestatus;
  //   app.util.request({
  //     'url': 'entry/wxapp/Lovefun',
  //     'cachetime': '0',
  //     data:{
  //       tag: tag,
  //       id: id
  //     },
  //     success(res){
  //       if (lovestatus == 0){
  //         lovestatus = 1;
  //         //点赞成功
  //       } else if (lovestatus == 1){
  //           lovestatus = 0;
  //           // 取消点赞成功
  //       }
  //      that.setData({
  //        lovestatus: lovestatus
  //      })
  //     }
  //   })
  //   that.onLoad();

  }
})