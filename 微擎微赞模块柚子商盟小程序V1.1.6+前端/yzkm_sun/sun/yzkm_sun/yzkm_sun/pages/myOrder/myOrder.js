// chbl_sun/pages/myOrder-list/index.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    statusType: ["全部", "待支付", "进行中", " 已完成"],
    currentType: 0,
    tabClass: ["", "", "", "", ""],
    orderListStatus: ["待支付", "进行中", "已完成"],
    orderList: true,
    yh_id:'',//用户id
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this
    console.log('初始下标')
    console.log(options)
    that.setData({
      currentType: options.currentTab
    })
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.getStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    })
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
        // wx.setStorageSync('yh_id', res.data.id);
      }
    })
  

    that.diyWinColor();
  },
  statusTap: function (e) {
    var that = this;
    console.log('订单页选项卡5');
    console.log(e);
    var curType = e.currentTarget.dataset.index;
    // that.data.currentType = curType;
    that.setData({
      currentType: curType
    });

    app.util.request({
      url: 'entry/wxapp/Order_mine',
      data: {
        yh_id: that.data.yh_id,
        currentType: curType,
      },
      success: function (res) {
        console.log('返回订单数据');
        console.log(res.data);
        that.setData({
          list: res.data,
        })
      }
    })

    that.onShow();
  },
  goDetails: function (e) {
    wx.navigateTo({
      url: '../myOrder-list/details',
    })
  },

  calOrder(e){
      var id = e.currentTarget.dataset.id
      var that = this;
      app.util.request({
        'url':'entry/wxapp/calOrder',
        'cachetime':'0',
        data:{
          id:id,
        },
        success:function(res){
          console.log(res)
          if(res.data==1){
              wx.showToast({
                title: '取消成功！',
                icon:'success',
              })
             
          } 
          setTimeout(function(){
            that.onShow();
          },1000)
        
        }
      })
  },
  //支付
  toPay(e){
    var price = e.currentTarget.dataset.price;
    var id = e.currentTarget.dataset.id;
    var openid = wx.getStorageSync('openid');
    var that = this;
    app.util.request({
      'url':'entry/wxapp/Orderarr',
      'cachetime':'0',
      data:{
        price:price,
        openid:openid,
      },
      success:function(res){
        console.log(res)
        wx.requestPayment({
          'timeStamp': res.data.timeStamp,
          'nonceStr': res.data.nonceStr,
          'package': res.data.package,
          'signType': 'MD5',
          'paySign': res.data.paySign,
          success: function (res) {
            console.log('支付数据')
            console.log(res)
            wx.showToast({
              title: '支付成功',
              icon: 'success',
              duration: 2000
            })
            app.util.request({
              'url':'entry/wxapp/changeOrder',
              'cachetime':'0',
              data:{
                order_id:id,
              },
              success:function(res){
                that.onShow();
              }
            })
          }
        })
      }
    })
  },
  // 确认收货
  comOrder(e){
    console.log(e);
    var id = e.currentTarget.dataset.id; 
    var money = e.currentTarget.dataset.money;   
    var goodsid = e.currentTarget.dataset.goodsid;   
    var that = this;
    app.util.request({
      'url':'entry/wxapp/comfirmOrder',
      'cachetime':'0',
      data:{
        id: id,//订单id
        money: money,//订单money
        goodsid:goodsid,//订单goodsid
      },
      success:function(res){
        console.log(res)
        if(res.data==1){
          wx.showToast({
            title: '确认成功！',
          })
          setTimeout(function () {
            that.onShow();
          }, 1000)
        }
      }
    })
  },
  //删除订单
  delOrder(e){
    var id = e.currentTarget.dataset.id;
    var that = this;
    wx.showModal({
      title: '提示',
      content: '确认删除该订单吗？',
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定');
          app.util.request({
            'url':'entry/wxapp/DelOrder',
            'cachetime':'0',
            data:{
              id:id,
            },
            success:function(res){
              console.log(res)
              if (res.data == 1) {
                wx.showToast({
                  title: '确认成功！',
                })
                setTimeout(function () {
                  that.onShow();
                }, 1000)
            }
            }
          })
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },
  checkOrder(e){
    var id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../myOrderDetail/myOrderDetail?id='+id,
    })
  },
  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this;
    // var yh_id = wx.getStorageSync('yh_id');//用户id
    setTimeout(function () { 
    var yh_id = that.data.yh_id;
    console.log('444444444444444444444444444444444444444444444')
    console. log(yh_id)
    console. log(that.data.currentType)
    app.util.request({
      url: 'entry/wxapp/Order_mine',
      data: {
        currentType: that.data.currentType,
        yh_id: yh_id,
      },
      success: function (res) {
        console.log('查看订单数据');
        console.log(res.data);
        that.setData({
          list: res.data,
        })
      }
    })
    }, 1000)
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
      title: '我的订单',
    })
  },
})