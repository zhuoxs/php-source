// yzmdwsc_sun/pages/index/cards/cards.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '优惠券',
    banner:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541919568.png',
    classify: ['线上优惠券','门店优惠券'],
    curIndex: 0,
    cards: [
      {
        money: '5',
        day: '3',
        remark: "5元无门槛",
        status: "1"
      },
      {
        money: '8',
        day: '3',
        remark: "8元无门槛",
        status: "0"
      }
    ],

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
    var settings = wx.getStorageSync('settings');
    var url = wx.getStorageSync('url');
    this.setData({
      url:url,
      settings: settings,
    })
  
    //获取优惠券
    wx.getStorage({
      key: 'openid',
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/getCoupon',
          'cachetime': '0',
          data: {
            uid: res.data 
          },
          success: function (res) {
            that.setData({
              coupon: res.data.data
            })
          }
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
  /**导航切换 */
  navChange(e) {
    var that = this;
    const index = parseInt(e.currentTarget.dataset.index);
    var signs=index+1;
    that.setData({
      curIndex: index
    })
    //获取优惠券
    wx.getStorage({
      key: 'openid',
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/getCoupon',
          'cachetime': '0',
          data: {
            uid: res.data,
            signs:signs
          },
          success: function (res) {
            that.setData({
              coupon: res.data.data
            })
          }
        })
      }
    })


  },
  /**领取优惠券 */
  receRards(e) {
    var that = this;
    const status = e.currentTarget.dataset.status;
    const index = e.currentTarget.dataset.index;
    const cards = that.data.coupon;
    var gid = e.currentTarget.dataset.gid;
    if (status == '2') {
      wx: wx.showModal({
        title: '提示',
        content: '您已经领取过该优惠券啦~',
        showCancel: false,
      })
    } else if (status == 1) {
      wx: wx.showModal({
        title: '提示',
        content: '优惠券已被抢光啦~下次早点来',
        showCancel: false,
      })
    } else if (status == '0') {
      /**领取优惠券 */
      wx.getStorage({
        key: 'openid',
        success: function (res) {
          app.util.request({
            'url': 'entry/wxapp/receiveCoupon',
            'cachetime': '0',
            data: {
              uid: res.data,
              gid:gid
            },
            success: function (res) {
              var errno=res.data.errno;
              if (errno==0||errno== 3){
                cards[index].status=2;
                wx: wx.showModal({
                  title: '提示',
                  content: '恭喜你，领取成功',
                  showCancel: false,
                  success: function (res) {
                    that.setData({
                      coupon: cards
                    })
                  } 
                })
              }else if (errno == 1 || errno == 2){
                cards[index].status = 1;
              }
              that.setData({
                coupon: cards
              })
            }
          })
        }
        
      })
      return
      wx: wx.showModal({
        title: '提示',
        content: '恭喜你，领取成功',
        showCancel: false,
        success: function (res) {
          that.setData({
            coupon: cards
          })
        }
      })

    }
  }
})