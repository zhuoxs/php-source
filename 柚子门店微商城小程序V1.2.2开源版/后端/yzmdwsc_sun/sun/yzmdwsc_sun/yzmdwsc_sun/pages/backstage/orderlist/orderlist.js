// yzmdwsc_sun/pages/backstage/orderlist/orderlist.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    all: [
      {
        ordernum: '2018032015479354825174',
        status: '1',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png',
        title: '可口可乐可口可乐可口可乐可口可乐可口可乐可口可乐',
        price: '2.50',
        num: '1'
      },
      {
        ordernum: '2018032015479354825176',
        status: '0',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png',
        title: '可口可乐',
        price: '2.50',
        num: '1'
      },
      {
        ordernum: '2018032015479354825176',
        status: '2',
        img: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png',
        title: '可口可乐',
        price: '2.50',
        num: '1'
      }
    ],
    showModel:false,
    express: ['中通', '顺丰', '圆通', '申通', '韵达', 'EMS', '邮政', '德邦', '天天', '宅急送', '优速', '汇通', '速尔', '全峰'],
    index:0,
    code:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn'
      }
    })
    that.setData({
      url: wx.getStorageSync('url'),
    })
    //获取待发货订单
    app.util.request({
      'url': 'entry/wxapp/getOrder',
      'cachetime': '0',
      data: {
        index: 1
      },
      success(res) {
        that.setData({
          order: res.data
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
/*  onShareAppMessage: function () {
  
  },*/
  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index: e.detail.value
    })
  },
  showModel(e) {
    console.log(e)
    this.setData({
      showModel: !this.data.showModel,
      id:e.currentTarget.dataset.id,
      index: e.currentTarget.dataset.index,
    })
    
  },
  getCode(e) {
    this.setData({
      code: e.detail.value
    })
  },
  formSubmit(e) {
    var that = this;
    var id =that.data.id;
    var index=that.data.index;
    var express_delivery=e.detail.value.shipname;
    var express_orderformid=e.detail.value.shipnum;
    if (express_orderformid == '') {
      wx.showToast({
        title: '请输入快递单号',
        icon: 'none'
      })
      return 
    }
    //发货
    var order=that.data.order;
    app.util.request({
      'url': 'entry/wxapp/setOrderFahuo',
      'cachetime': '0',
      data: {
        id: id,
        express_delivery: express_delivery,
        express_orderformid: express_orderformid,
      },
      success(res) {
         if(res.data.errcode==0){
           order[parseInt(index)].order_status=2;  
           wx.showToast({
             title: res.data.errmsg,
             icon: 'success',
             duration: 2000,
             success: function () {

             },
             complete: function () {
               that.setData({
                 order: order,
                 showModel:false,
               })
             },
           })

         }
      }
    })

  },
  toOrderdet(e){
    wx.navigateTo({
      url: '../orderdet/orderdet?order_id='+e.currentTarget.dataset.id+'&uid='+e.currentTarget.dataset.uid,
    })
  }
})