// yzmdwsc_sun/pages/index/shareDet/shareDet.js
const app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    navTile: '商品详情',
    indicatorDots: false,
    autoplay: false,
    interval: 3000,
    duration: 800,
    goods: [
      {
        imgUrls: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png', 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png'
        ],
        title: '发财树绿萝栀子花海棠花卉盆栽',
        shareprice:'0.15',
        detail: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png'
        ],
        visitnum:6
      }
    ],
    isLogin: false,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    that.reload(options);
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
  },
  dealwith:function(options){
    var that=this;
    var gid = options.gid;
    // gid=82;
    that.setData({
      gid: gid,
    })
    var openid = wx.getStorageSync('openid');
    if (!openid) {
      return
    }
    //分享进来 
    var share_openid = options.openid;
    // share_openid ='oC4wb5PsUhWtdXfdj_MV5F5el4BQ_1';
    if (share_openid) { 
      //创建分享相关记录
      app.util.request({
        'url': 'entry/wxapp/setShareRecord',
        'cachetime': '0',
        data: {
          gid: gid,
          openid: openid,
          share_openid: share_openid,
        },
        success: function (res) {
        },
      })
    }

    //----------获取商品详情----------
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        that.setData({
          goodinfo: res.data.data
        })
      }
    })
    //增加访问记录
    app.util.request({
      'url': 'entry/wxapp/setShareAccessRecord',
      'cachetime': '0',
      data: {
        openid: openid,
        gid: gid,
      },
      success: function (res) {
        app.util.request({
          'url': 'entry/wxapp/getShareAccessRecord',
          'cachetime': '0',
          data: {
            gid: gid,
          },
          success: function (res) {
            that.setData({
              record: res.data,
              record_length: res.data.length,
            })
          }
        })
      }
    })


  },


  
  bindGetUserInfo(e) {
    if (e.detail.userInfo == undefined) {
      console.log('没有授权')
    } else {
      wx.setStorageSync('is_login', 1);
      this.setData({
        isLogin: false,
      })
      this.onLoad();
    }

  },
  //相关信息记录操作
  reload: function (e) {
    var that = this
    //获取网址
    var url = wx.getStorageSync('url');
    if(url==''){
      app.util.request({
        'url': 'entry/wxapp/Url',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync('url', res.data)
          that.setData({
            url: res.data
          })
        },
      })
    }else{
      that.setData({
        url: url,
      })
    }
    var settings = wx.getStorageSync('settings');
    if(settings==''){
      app.util.request({
        'url': 'entry/wxapp/Settings',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync("settings", res.data);
          wx.setStorageSync('color', res.data.color)
          wx.setStorageSync('fontcolor', res.data.fontcolor)
          wx.setNavigationBarColor({
            frontColor: wx.getStorageSync('fontcolor'),
            backgroundColor: wx.getStorageSync('color'),
            animation: {
              duration: 0,
              timingFunc: 'easeIn'
            }
          })
          that.setData({
            settings: res.data,
          })
        }
      })
    }else{
      that.setData({
        settings: settings,
      })
      wx.setNavigationBarColor({
        frontColor: wx.getStorageSync('fontcolor'),
        backgroundColor: wx.getStorageSync('color'),
        animation: {
          duration: 0,
          timingFunc: 'easeIn'
        }
      })
    }
    var openid = wx.getStorageSync("openid")
    if(openid==''){
      // ----------------------------------获取用户登录信息----------------------------------
      wx.login({
        success: function (res) {
          var code = res.code;
          app.util.request({
            'url': 'entry/wxapp/openid',
            'cachetime': '0',
            data: { code: code },
            success: function (res) {
              wx.setStorageSync("openid", res.data.openid)
              that.dealwith(e);
              var openid = res.data.openid;
              wx.getSetting({ 
                success: function (res) {
                  if (res.authSetting['scope.userInfo']) {
                    wx.getUserInfo({
                      success: function (res) {
                        wx.setStorageSync("user_info", res.userInfo)
                        var nickName = res.userInfo.nickName
                        var avatarUrl = res.userInfo.avatarUrl 
                        app.util.request({
                          'url': 'entry/wxapp/Login',
                          'cachetime': '0',
                          data: { openid: openid, img: avatarUrl, name: nickName },
                          success: function (res) {
                            wx.setStorageSync('users', res.data)
                            wx.setStorageSync('uniacid', res.data.uniacid)
                          },
                        })
                      },
                    })
                  }
                }
              })

            }
          }) 

        }
      })
    }else{
      that.dealwith(e);
      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.userInfo']) {
            wx.getUserInfo({
              success: function (res) {
                wx.setStorageSync("user_info", res.userInfo)
                var nickName = res.userInfo.nickName
                var avatarUrl = res.userInfo.avatarUrl
                app.util.request({
                  'url': 'entry/wxapp/Login', 
                  'cachetime': '0',
                  data: { openid: openid, img: avatarUrl, name: nickName },
                  success: function (res) {
                    wx.setStorageSync('users', res.data)
                    wx.setStorageSync('uniacid', res.data.uniacid)
                  },
                })
              },
            })
          }
        }
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
    var that=this;
    var gid=that.data.gid;
    //获取访问记录
    var that = this;
    var is_login = wx.getStorageSync('is_login');
    if (!is_login) {
      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.userInfo']) {
            wx.setStorageSync('is_login', 1);
            that.setData({
              isLogin: false,
            })
          } else {
            that.setData({
              isLogin: true,
            })
          }
        }
      })
    }


   
  
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
    var that=this;
    var openid=wx.getStorageSync('openid');
    if (res.from === 'button') {
      console.log(res.target)
    }
    return {
      title: that.data.goodinfo.goods_name, 
      path: 'yzmdwsc_sun/pages/index/shareDet/shareDet?gid='+that.data.gid+'&openid='+openid,
      success: function (res) {
        // 转发成功 
      },
      fail: function (res) {
        // 转发失败
      }
    }
  },
  //去购买
  tobuy:function(e){
    var that = this;
    var gid = e.currentTarget.dataset.gid;
    //获取商品类型
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails', 
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        var lid = res.data.data.lid;
        if (lid == 1 || lid == 2 || lid == 3) {
          wx: wx.navigateTo({
            url: '../goodsDet/goodsDet?gid=' + gid,
          })
        } else if (lid == 4) {
          wx: wx.navigateTo({
            url: '../groupDet/groupDet?gid=' + gid,
          })
        } else if (lid == 5) {
          wx: wx.navigateTo({
            url: '../bardet/bardet?gid=' + gid,
          })
        } else if (lid == 6) {
          wx: wx.navigateTo({
            url: '../limitDet/limitDet?gid=' + gid,
          })
        } else if (lid == 7) {
          wx: wx.navigateTo({
            url: '../shareDet/shareDet?gid=' + gid,
          })
        }

      }
    })
    

  }
})