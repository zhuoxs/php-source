// byjs_sun/pages/charge/chargeSportswear/chargeSportswear.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    fight1: [
      {
        img: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
        address: '马来西亚',
        picer: '1990'
      },
      {
        img: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
        address: '马来西亚',
        picer: '1990'
      },
      {
        img: 'http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png',
        address: '马来西亚',
        picer: '1990'
      },
    ],
    screenNumber:0, //销量
    screenPicer:0   //价格
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
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
  //销量
  screenNumber: function(){
    let thisStatus = Number(JSON.parse(JSON.stringify(this.data.screenNumber))) + 1
    if(thisStatus > 2){
      this.setData({
        screenNumber: 0
      })
    }else{
      this.setData({
        screenNumber: thisStatus
      })
    }
  },
  //价格
  screenPicer: function(){
    let thisStatus = Number(JSON.parse(JSON.stringify(this.data.screenPicer))) + 1
    if (thisStatus > 2) {
      this.setData({
        screenPicer: 0
      })
    } else {
      this.setData({
        screenPicer: thisStatus
      })
    }
  }
})