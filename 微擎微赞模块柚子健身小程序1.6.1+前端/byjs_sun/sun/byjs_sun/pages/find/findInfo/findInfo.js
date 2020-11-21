// byjs_sun/pages/find/findInfo/findInfo.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    attentioned: false,
    talent:
    {
      userImg: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
      userName: '卡若不弃',
      userTime: '12月10日 距离2.6km',
      userSex: 0,  //0男，1女
      userId: '123',
      talentImg: ['http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png'],
      talentText: '世纪东方看水电费上课的飞机上课的房间上课的房间开始的九分裤世纪东方开始的减肥上课京东方',
      talentLove: 0,
      talentComment: 0
    }

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },
  attention:function(e){
      var that=this
      console.log(!that.data.attentioned)
     var attentionednow = ! that.data.attentioned
      that.setData({
        attentioned:attentionednow
      });

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
  
  }
})