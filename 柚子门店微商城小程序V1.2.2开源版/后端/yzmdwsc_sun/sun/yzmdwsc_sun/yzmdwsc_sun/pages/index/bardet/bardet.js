// mzhk_sun/pages/index/bargain/bargain.js
var tool = require('../../../../style/utils/countDown.js');  
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商品详情',
    showModalStatus: false, 
    join: 0,
    imgsrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png',
    title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
    price: '100',
    minPrice: '68',
    surplus: '100',
    startTime: '2017-12-12 00:00:00',
    endTime: '2018-06-01 00:00:00',
    imgArr: ['http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'],
    bargainList: [
      {
        endTime: '1527782400000',
        clock: ''
      }
    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    var arr = [{
      antime: "1527782400000",
      astime: "2018-06-01 00:00:00",
      content: "321",
    }];/**传入数组 */
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
    var gid = options.gid;
 //   gid=15;
    that.setData({
      gid: gid,
    })
    wx.setStorageSync('kanjiaid', gid)
    var openid = wx.getStorageSync('openid')
    that.setData({
      url: wx.getStorageSync('url')
    })
    //----------获取商品详情----------
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        that.setData({
          goodinfo: res.data.data,
          openid:openid,
        })
        var clock;
        var cdInterval = setInterval(function () {
          var time = tool.countDown(that,res.data.data.endtime);         
          if (time) {
            clock = '距离结束还剩：' + time[0] + '天' + time[1] + "时" + time[3] + "分" + time[4] + "秒";
          } else {
            clock = '00 : 00 : 00';
          }
           that.setData({
            clock: clock
          })
        }, 1000)

      }
    })

    return 

    /**砍价倒计时 */
    var countDown = that.data.bargainList;/**传入的数组一定要有clock字段 */
    
    var cdInterval = setInterval(function () {
      for (var i = 0; i < countDown.length; i++) {
        var time = tool.countDown(that, countDown[i].endTime);/***第二个参数 结束时间 */
        if (time) {
          countDown[i].clock = '距离结束还剩：' + time[0] + '天' + time[1] + "时" + time[3] + "分" + time[4] + "秒";
        } else {
          countDown[i].clock = '已经截止';
        //  clearInterval(cdInterval);
        }
        that.setData({
          bargainList: countDown
        })
      }
    }, 1000)
    
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
    var id = wx.getStorageSync('kanjiaid');
    var openid = wx.getStorageSync('openid');
    this.getUserInfo();
    var that = this;
    //查询我是否砍过价
    app.util.request({
      'url': 'entry/wxapp/iskanjia',
      'cachetime': '0',
      data: {
        openid: openid,
        id: id
      },
      success: function (res) {
        that.setData({
          iskanjia: res.data.data
        })
      }
    })
    //我的砍价信息
    app.util.request({
      'url': 'entry/wxapp/myBargain',
      'cachetime': '0',
      data: {
        openid: openid,
        id: id
      },
      success: function (res) {
        that.setData({
          mybargain: res.data.data
        })
      }
    })
    //查询已有多少人参与砍价 
  /*  app.util.request({
      'url': 'entry/wxapp/partNum',
      'cachetime': '0',
      data: {
        id: id,
      },
      success: function (res) {
        var partuser = res.data.data;
        that.setData({
          partuser: partuser
        })
      }
    })*/
    //查询帮自己砍价的五位好友头像
    app.util.request({
      'url': 'entry/wxapp/friendsImg',
      'cachetime': '0',
      data: {
        openid: openid,
        id: id
      },
      success: function (res) {
        that.setData({
          Img: res.data.data
        })
      }
    })
  },
  getUserInfo: function () {
    var that = this;
    wx.login({
      success: function () {
        wx.getUserInfo({
          success: function (res) {
            that.setData({
              userInfo: res.userInfo
            });
          }
        })
      }
    })
  },

  /**
 * 生命周期函数--监听页面初次渲染完成
 */
  onReady: function () {
 /*   var that = this;
    var kanjiabtn = 1;
    that.setData({
      kanjiabtn: kanjiabtn
    })*/
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
  onShareAppMessage: function (res) {
    var openid = wx.getStorageSync('openid');
    var id = wx.getStorageSync('kanjiaid');
    console.log(openid)
    console.log(id)
    var that = this;
    var bargaintitle = wx.getStorageSync('settings');
    console.log(bargaintitle)
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res)
    }
    return {
      title: bargaintitle.bargain_title,
      path: 'yzmdwsc_sun/pages/index/help/help?id=' + id + '&openid=' + openid,
      success: function (res) {
        console.log('转发成功')
      },
      fail: function (res) {
        console.log('转发失败')
      }
    }
    
  },
  order(e) {

  },
  bargain(e) {

  },

  powerDrawer1:function(e){
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);
  },
  powerDrawer: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    const join = e.currentTarget.dataset.join;
    this.setData({
      join: join
    }) 
    var that = this;
    var gid = e.currentTarget.dataset.gid;
    var openid = wx.getStorageSync('openid');

    app.util.request({
      'url': 'entry/wxapp/checkGoods',
      'cachetime': '0',
      data: {
        gid: gid,
      },
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/NowBargain',
          'cachetime': '0',
          data: {
            id: gid,
            openid: openid,
          },
          success: function (res) {
            if (res.errno == 1) {

            } else {
              that.util(currentStatu);
              that.setData({
                hideShopPopup: false,
                myprice: res.data,
                iskanjia: true
              })

              //我的砍价信息
              app.util.request({
                'url': 'entry/wxapp/myBargain',
                'cachetime': '0',
                data: {
                  openid: openid,
                  id: gid
                },
                success: function (res) {
                  that.setData({
                    mybargain: res.data.data
                  })
                }
              })

            }
          }
        })
        
      }
    })

    

  },
  util: function (currentStatu) {
    var animation = wx.createAnimation({
      duration: 200,
      timingFunction: "linear",
      delay: 0
    });

    this.animation = animation;
    animation.opacity(0).height(0).step();
    this.setData({
      animationData: animation.export()
    })

    setTimeout(function () {
      animation.opacity(1).height('488rpx').step();
      this.setData({
        animationData: animation
      })
      if (currentStatu == "close") {
        this.setData(
          {
            showModalStatus: false
          }
        );
      }
    }.bind(this), 200)

    // 显示 
    if (currentStatu == "open") {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
  },
  help(e) {
    wx.updateShareMenu({
      withShareTicket: true,
      success() {
      }
    })
  },
  toCforder(e) {
    var gid=e.currentTarget.dataset.gid;
    var that = this;
    var id = wx.getStorageSync('kanjiaid');
    var openid = wx.getStorageSync('openid')
    //查询时间是否到期
    app.util.request({
      'url': 'entry/wxapp/Expire',
      'cachetime': '0',
      data: {
        id: id,
      },
      success: function (res) {
        var Expire = res.data.data
        //查询是否已经购买过
        app.util.request({
          'url': 'entry/wxapp/buyed',
          'cachetime': '0',
          data: {
            id: id,
            openid: openid, 
          },
          success: function (res) {
            if (res.data == 2) {
              if (Expire == 1) {
                app.util.request({
                  'url': 'entry/wxapp/checkGoods',
                  'cachetime': '0',
                  data: {
                    gid: gid,
                  },
                  success: function (res) {
                    wx.navigateTo({
                      url: '../cforder-bargain/cforder-bargain?gid=' + e.currentTarget.dataset.gid,
                    })
                  } 
                })
              /*  var bargain_num = that.data.goodinfo.num;
                if (bargain_num <= 0) {
                  wx.showToast({
                    title: '商品没有库存啦！',
                    icon: 'none',
                  })
                } else {
                  console.log('开始下订单')
                  wx.navigateTo({
                    url: '../cforder-bargain/cforder-bargain?gid=' + e.currentTarget.dataset.gid,
                  })
                }*/
              } else {
                wx.showToast({
                  title: '活动已结束！感谢参与！',
                  icon: 'none',
                })
              }
            } else {
              wx.showToast({
                title: '您已购买该商品，不要贪心哦！',
                icon: 'none',
              })
            }

          }
        })
      }
    })
    return

    wx.navigateTo({
      url: '../cforder/cforder?gid='+gid
    })
  },
  toIndex(e) {
    wx: wx.redirectTo({
      url: '../index',
    })
  }
})