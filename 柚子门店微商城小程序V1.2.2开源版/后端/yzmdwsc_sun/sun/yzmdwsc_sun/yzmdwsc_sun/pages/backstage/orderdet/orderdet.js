// yzmdwsc_sun/pages/backstage/orderdet/orderdet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '订单详情',
    order: {
      uname: '李星和',
      phone: 130000000,
      remark: '留言',
      ordernum: '123215678469463',
      times: '2018-06-06 10:10:10',
      status: 2
    },
    address: '厦门市集美区',
    shopPhone: 1300000000,
    goods: [
      {
        title: '发财树绿萝栀子花海棠花卉盆栽',
        goodsThumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        price: '2.50',
        specConn: 's',
        num: '1',
      },
      {
        title: '发财树绿萝栀子花海棠花卉盆栽',
        goodsThumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        price: '2.50',
        specConn: '套餐1',
        num: '1',
      },
    ],
    showModel: false,
    express: ['中通', '顺丰', '圆通'],
    index: 0,
    code: '',
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
   
    var order_id=options.order_id;
    that.setData({
      id: order_id,
    })
   // order_id=273;
    var uid = options.uid;
   // uid ='ojKX54szR1RQxjAVcKm_8jbDBzxk';
    //获取订单信息
    app.util.request({
      'url': 'entry/wxapp/getOrderDetail',
      'cachetime': '0',
      data: {
        id: order_id,
        uid: uid,
      },
      success(res) {
        console.log(res.data.data)
        if (res.data.data.order_status == 3) {
         
        }
        that.setData({
          order: res.data.data,
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
 /* onShareAppMessage: function () {
  
  },*/
  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index: e.detail.value
    })
  },
  showModel(e) {
    this.setData({
      showModel: !this.data.showModel
    })
  },
  getCode(e) {
    this.setData({
      code: e.detail.value
    })
  },
  formSubmit(e) {
    var that = this;
    var id = that.data.id;
    var express_delivery = e.detail.value.shipname;
    var express_orderformid = e.detail.value.shipnum;
    if (express_orderformid == '') {
      wx.showToast({
        title: '请输入快递单号',
        icon: 'none'
      })
      return
    }
    //发货
    app.util.request({
      'url': 'entry/wxapp/setOrderFahuo',
      'cachetime': '0',
      data: {
        id: id,
        express_delivery: express_delivery,
        express_orderformid: express_orderformid,
      },
      success(res) {
        if (res.data.errcode == 0) {
          wx.showToast({
            title: res.data.errmsg,
            icon: 'success',
            duration: 2000,
            success: function () {

            },
            complete: function () {
              var order=that.data.order;
              order.order_status=2;
              that.setData({
                showModel: false,
                order:order,
              })
            },
          })

        }
      }
    })
    
  },
  Dialog(e){
    wx.makePhoneCall({
      phoneNumber: e.currentTarget.dataset.phone,
    })
  },
 
})