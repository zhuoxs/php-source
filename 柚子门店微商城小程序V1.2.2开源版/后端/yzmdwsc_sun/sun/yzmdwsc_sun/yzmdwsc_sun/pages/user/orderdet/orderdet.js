// yzmdwsc_sun/pages/user/orderdet/orderdet.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '订单详情',
    addr:['墨纸','1300000000','厦门市集美区杏林湾运营中心'] ,
    shopname:"柚子鲜花店",
    goods:[
      {
        title:'发财树绿萝栀子花海棠花卉盆栽',
        goodsThumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        price: '2.50',
        specConn:'s',
        num: '1',
      },
      {
        title: '发财树绿萝栀子花海棠花卉盆栽',
        goodsThumb: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png',
        price: '2.50',
        specConn:'套餐1',
        num: '1',
      },
    ],
    distribution: '0.00',/**运费*/
    totalprice: '2.50',
    discount:'30.00',
    orderNnum:'1234567897',
    time:'2018-05-01 10:10:10',
    status:1/**订单状态 */
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
    var id=options.id;

   // id=81;
    var openid = wx.getStorageSync('openid');
    var url = wx.getStorageSync('url');
    var settings = wx.getStorageSync('settings');
    that.setData({
      url:url,
      settings: settings,
      order_id:id,
    }) 
    //获取订单信息
    app.util.request({
      'url': 'entry/wxapp/getOrderDetail', 
      'cachetime': '0',
      data: {
        id: id,
        uid:openid,
      },
      success(res) {
        console.log(res.data.data)
        that.setData({
          order:res.data.data
        })
      }
    })

  },
  topay(e) {
    wx.showModal({
      title: '提示',
      content: '确定支付',
      success: function (res) {
        if (res.confirm) {
          var openid = wx.getStorageSync('openid');
          var order_id = e.currentTarget.dataset.order_id;
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
  toCancel(e) {
    var that = this;
    var openid = wx.getStorageSync('openid');
    var order_id = e.currentTarget.dataset.order_id;
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
              wx.navigateTo({
                url: '../../user/myorder/myorder',
              })
            }
          })

        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },
  toqueren(e) {
    var that = this;
    var openid = wx.getStorageSync('openid');
    var order_id = e.currentTarget.dataset.order_id;
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
              wx.navigateTo({
                url: '../../user/myorder/myorder',
              })
            }
          })
        } else if (res.cancel) {
          console.log('用户点击确认')
        }
      }
    })
  }, 
  toDel(e) {
    var that = this;
    var openid = wx.getStorageSync('openid');
    var order_id = e.currentTarget.dataset.order_id;
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
              order_id: order_id,
            },
            success(res) {
              wx.navigateTo({
                url: '../../user/myorder/myorder',
              })
            }
          })

        } else if (res.cancel) {
          console.log('用户点击删除')
        }
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
  deletes(e){
    wx.showModal({
      title: '提示',
      content: '订单删除后不再显示!',
      success(res){
        if(res.confirm){
          console.log('确定')
        }else if(res.cancel){
          return;
        }
      }
    })
  },
  cancel(e){
    wx.showModal({
      title: '提示',
      content: '确定取消订单',
      success(res) {
        if (res.confirm) {
          console.log('确定')
        } else if (res.cancel) {
          return;
        }
      }
    })
  },
  /***立即支付 */
  subPay(e){
    
  },
  toMap(e) {
    var latitude = parseFloat(e.currentTarget.dataset.latitude);
    var longitude = parseFloat(e.currentTarget.dataset.longitude);
    wx.openLocation({
      latitude: latitude,
      longitude: longitude,
      scale: 28
    })
  }
})