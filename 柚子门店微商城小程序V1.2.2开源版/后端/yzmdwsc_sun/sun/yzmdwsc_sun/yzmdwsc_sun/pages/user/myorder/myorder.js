// yzmdwsc_sun/pages/user/myorder/myorder.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的订单',
    curIndex: 0,
    nav: ['全部', '待付款', '待发货', '待收货','待评价'],
    /***前台数据需要做修改~ 借口数据获取后和我说~ */
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
    /**待付款 */
    dfk: [],
    /**待收货 */
    dsh: [],
    /***售后 */
    sh: []
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
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    var url=wx.getStorageSync('url');
    var index=options.index;
    this.setData({
      curIndex:parseInt(index),
      url:url,
    })
    var openid=wx.getStorageSync('openid');
    //获取订单
    app.util.request({
      'url': 'entry/wxapp/getMyorder',
      'cachetime': '0',
      data: {
        uid:openid,
        index:index
      },
      success(res) {
         that.setData({
           order:res.data
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
  bargainTap(e) {
    var that=this;
    const index = parseInt(e.currentTarget.dataset.index);
    this.setData({
      curIndex: index
    })
    var openid = wx.getStorageSync('openid');
    //获取订单
    app.util.request({
      'url': 'entry/wxapp/getMyorder', 
      'cachetime': '0', 
      data: {
        uid: openid,
        index:index
      },
      success(res) {
        that.setData({
          order: res.data
        })
      }
    })



  },
  toCancel(e) {
    var that=this;
    var openid = wx.getStorageSync('openid');
    var order_id=e.currentTarget.dataset.order_id;
    var order=that.data.order;
    var index = e.currentTarget.dataset.index;
    wx.showModal({
      title: '提示',
      content: '确定取消该订单吗？',
      success: function (res) {
        if (res.confirm) {
          app.util.request({
            'url': 'entry/wxapp/cancelOrder',
            'cachetime': '0',
            data: {
              uid: openid,
              order_id: order_id
            },
            success(res) {
              order[index].order_status=7;
              that.setData({
                order:order,
              })
            }
          })

        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },
  toComment(e) {
    wx.navigateTo({
      url: '../comment/comment'
    })
  },
  toDel(e) {
    var that = this;
    var openid = wx.getStorageSync('openid');
    var order_id = e.currentTarget.dataset.order_id;
    var order = that.data.order;
    var index = e.currentTarget.dataset.index;
    wx.showModal({
      title: '提示',
      content: '订单删除后将不再显示',
      success: function (res) {
        if (res.confirm) {
          app.util.request({
            'url': 'entry/wxapp/delOrder',
            'cachetime': '0',
            data: {
              uid: openid,
              order_id:order_id,
            },
            success(res) {
              order.splice(index,1);
              that.setData({
                order: order, 
              })
            }
          })

        } else if (res.cancel) {
          console.log('用户点击删除')
        }
      }
    })
  },
  topay(e){
    wx.showModal({
      title: '提示',
      content: '确定支付',
      success: function (res) {
        if (res.confirm) {
          var openid = wx.getStorageSync('openid');
          var order_id = e.currentTarget.dataset.order_id;
          console.log(order_id)
          app.util.request({
            'url': 'entry/wxapp/getPayParam',
            'cachetime': '0',
            data: {
              order_id: order_id,
            },
            success: function (res) {
              wx.requestPayment({
                'timeStamp': res.data.timeStamp,
                'nonceStr': res.data.nonceStr,
                'package': res.data.package,
                'signType': 'MD5',
                'paySign': res.data.paySign,
                'success': function (result) {
                  app.util.request({
                    'url': 'entry/wxapp/PayOrder',
                    'cachetime': '0',
                    data: {
                      order_id: order_id,
                      mch_id: 0
                    },
                    success: function (res) {
                      wx.showToast({
                        title: '支付成功',
                        icon: 'success',
                        duration: 2000,
                        success: function () {

                        },
                        complete: function () {
                          wx.navigateTo({
                            url: '../../user/myorder/myorder',
                          })
                        },
                      })
                    }
                  })
                },
                'fail': function (result) {
                 /* app.util.request({
                    'url': 'entry/wxapp/PayOrder',
                    'cachetime': '0',
                    data: {
                      order_id: order_id,
                      mch_id: 0
                    },
                    success: function (res) {
                      wx.showToast({
                        title: '支付成功',
                        icon: 'success',
                        duration: 2000,
                        success: function () {

                        },
                        complete: function () {
                          wx.navigateTo({
                            url: '../../user/myorder/myorder',
                          })
                        },
                      })
                    }
                  })
                  return*/
                  wx.navigateTo({
                    url: '../../user/myorder/myorder',
                  })
                }
              });

            }
          })
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })

  },
  toqueren(e){
    var that = this;
    var openid = wx.getStorageSync('openid');
    var order_id = e.currentTarget.dataset.order_id;
    var order = that.data.order;
    var index = e.currentTarget.dataset.index;
    wx.showModal({
      title: '提示',
      content: '确定收货',
      success: function (res) {
        if (res.confirm) {
          app.util.request({
            'url': 'entry/wxapp/querenOrder', 
            'cachetime': '0',
            data: {
              uid: openid,
              order_id: order_id
            },
            success(res) {
              order[index].order_status =3;
              that.setData({
                order: order,
              })
            }
          })
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  }, 
  topingjia(e){
    var order_id = e.currentTarget.dataset.order_id;
    var order_detail_id = e.currentTarget.dataset.order_detail_id;
    wx: wx.navigateTo({
      url: '../comment/comment?order_id=' + order_id+'&order_detail_id='+order_detail_id,
    })
  }, 
  toOrderdet:function(e){
    var id=e.currentTarget.dataset.id;
    wx: wx.navigateTo({
      url: '../orderdet/orderdet?id=' + id,
    })
    
  },
  toIndex(e) {
    wx.redirectTo({
      url: '/yzmdwsc_sun/pages/index/index',
    })
  }

})