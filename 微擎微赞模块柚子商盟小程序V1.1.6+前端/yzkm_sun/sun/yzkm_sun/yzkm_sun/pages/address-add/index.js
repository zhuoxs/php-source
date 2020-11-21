// chbl_sun/pages/address-add/index.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    region:'',
    customItem: '全部',
    address: [], 
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this
    // 用户openid转id   
    var openid = wx.getStorageSync('openid');//用户openid
    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res.data);
        that.setData({
          yh_id: res.data.id,
        })
        wx.setStorageSync('user_id', res.data.id);
      }
    })
    that.diyWinColor();
  },
  // 改变地址选择
  bindRegionChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      region: e.detail.value
    })
  },
  bindCancel: function () {
    wx.navigateBack({})
  },
  bindSave: function (e) {
    console.log('表单数据')
    console.log(e.detail.value);
    var that = this;
    var region = that.data.region;
    console.log(region)
    var addrData = e.detail.value;
    if (addrData.linkMan == '') {
      wx.showModal({
        title: '提示',
        content: '请输入收货人！',
        showCancel: false
      })
      return;
    }
    if (addrData.mobile == '') {
      wx.showModal({
        title: '提示',
        content: '请输入收货人手机号码！',
        showCancel: false
      })
      return;
    }
    if (addrData.stree == '') {
      wx.showModal({
        title: '提示',
        content: '请输入详细地址！',
        showCancel: false
      })
      return;
    } else {
      var region = that.data.region;
      wx.getStorage({
        key: 'key',
        success: function (res) {
          console.log('这是什么歌')
          console.log(res)
          var user_id = wx.getStorageSync('user_id')//用户ID
          app.util.request({
            'url': 'entry/wxapp/Address_mine',
            'cachetime': '0',
            data: {
              user_id: user_id,//用户id
              linkMan: addrData.linkMan,
              mobile: addrData.mobile,
              stree: addrData.stree,
              region: region,
            },
            success: function (res) {
              console.log('地址添加数据查看')
              console.log(res)
              wx.navigateBack({

              })
            }
          })
        },
      })
      console.log(e);
      wx.setStorage({
        key: "addNew",
        data: {
          name: e.detail.value.linkMan,
          mobile: e.detail.value.mobile,
          stree: e.detail.value.stree
        }
      })
      wx.navigateBack({
        
      })
    }
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