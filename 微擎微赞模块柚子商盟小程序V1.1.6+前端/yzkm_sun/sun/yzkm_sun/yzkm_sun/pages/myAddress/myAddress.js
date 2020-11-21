// yzkm_sun/pages/myAddress/myAddress.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    addressData: [
      {
        name: "余文乐",
        phone: 12345678901,
        address: "福建省 厦门市 集美区 杏林街道 我昂林湾营运中心1230号"
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
    var that=this;
    var openid = wx.getStorageSync('openid');//用户openid
    // 获取用户id
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          comment_xqy: res.data,
        })
        wx.setStorageSync('id', res.data.id);
      }
    })    
    var id = wx.getStorageSync('id');//用户id
    app.util.request({
      url: 'entry/wxapp/Address_myfabu',
      data: {
        id: id,
      },
      success: function (res) {
        console.log('查看用户地址信息');
        console.log(res);
        that.setData({
          list: res.data,
        })
      }
    })    
    this.diyWinColor();
  },

  // 点击新增收货地址
  goAdd(e){
    wx.navigateTo({
      url: '../address-add/index',
    })
  },
  // 设置默认地址
  selAddress(e){
    console.log('1111111111111111111')
    console.log(e)
    var del_id = e.currentTarget.dataset.id;//地址id
    var yh_id = wx.getStorageSync('id');//用户id
    app.util.request({
      url: 'entry/wxapp/Address_del',
      data: {
        del_id: del_id,
        yh_id: yh_id,
      },
      success: function (res) {
        console.log('是否设置成功');
        console.log(res);
        wx.showModal({
          title: '提示',
          content: '设置成功',
          showCancel:false
        })
        // //  延迟两秒跳转
        // setTimeout(function () {
        //   wx.navigateTo({
        //     url: '../myAddress/myAddress',
        //   })
        // }, 2000)
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

  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '我的收货地址',
    })
  },
})