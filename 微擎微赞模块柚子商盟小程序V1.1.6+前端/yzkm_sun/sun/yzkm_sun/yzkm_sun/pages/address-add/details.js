// chbl_sun/pages/address-add/details.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    addressData:[
      {
        name: "余文乐",
        phone: 12345678901,
        address:"福建省 厦门市 集美区 杏林街道 我昂林湾营运中心1230号"
      },
      {
        name: "段奕宏",
        phone: 12345678901,
        address: "福建省 厦门市 集美区 杏林街道 我昂林湾营运中心1230号"
      },
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    this.diyWinColor();
  },
  goAdd:function(){
    wx.navigateTo({
      url: '../address-add/index',
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
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '添加收货地址',
    })
  },
})