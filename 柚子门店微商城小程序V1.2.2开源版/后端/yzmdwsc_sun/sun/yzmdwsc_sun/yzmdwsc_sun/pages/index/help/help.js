// wnjz_sun/pages/bargain/detail/detail.js
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    showModalStatus: false,

    order: [],
    ig: [],
    img: [],
    isHelp:false,
    flag:true,
    isLogin: true,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this;
    that.reload();
    var id=options.id;
  //  id=44;
    var openid=options.openid;
  //  openid ='ojKX54hZfUNIyrz75JzF3NV5R-yU';
    wx.setStorageSync('kanjiaid', id);
    wx.setStorageSync('userid', openid)
    //---------------------------------- 获取网址----------------------------------
  
    var id = wx.getStorageSync('kanjiaid');
    var userid = wx.getStorageSync('userid');
    app.util.request({
      'url': 'entry/wxapp/helpBargain',
      'cachetime': '0',
      data: {
        id: id, 
        openid:openid,
      },
      success: function (res) {
        that.setData({
          helpbargain: res.data.data
        })
      }
    })
    //----------查询砍主-------------
    app.util.request({
      'url': 'entry/wxapp/kanzhu',
      'cahetime': '0',
      data: {
        openid: userid
      },
      success: function (res) {
        that.setData({
          userInfo: res.data.data
        })
      }
    })
 
  },

  login: function () {
    var that = this
    // ----------------------------------获取用户登录信息----------------------------------
    wx.login({
      success: function (res) {
        var code = res.code
        wx.setStorageSync("code", code)
        wx.getUserInfo({
          success: function (res) {
            wx.setStorageSync("user_info", res.userInfo)
            var nickName = res.userInfo.nickName
            var avatarUrl = res.userInfo.avatarUrl
            app.util.request({
              'url': 'entry/wxapp/openid',
              'cachetime': '0',
              data: { code: code },
              success: function (res) {
                wx.setStorageSync("key", res.data.session_key)
                wx.setStorageSync("openid", res.data.openid)
                var openid = res.data.openid
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
            that.setData({
              avatarUrl: avatarUrl
            })
          },
          fail: function (res) {
            wx.getSetting({
              success: (res) => {
                var authSetting = res.authSetting
                if (authSetting['scope.userInfo'] == false) {
                  wx.openSetting({
                    success: function success(res) {
                    }
                  });
                }
              }
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
    var id = wx.getStorageSync('kanjiaid');
    var openid = wx.getStorageSync('userid');//砍主的OPENID
    var userid = wx.getStorageSync('openid');//进入当前页面的openid
    var that = this; 
    //查询帮砍主砍价的人
    app.util.request({
      'url': "entry/wxapp/Friends",
      'cachetime': '0',
      data: {
        openid: openid,
        id: id,
      },
      success: function (res) {
        console.log(res)
        that.setData({
          friends: res.data.data
        })
      }
    })
    //查询用户是否已经帮忙砍价过
    app.util.request({
      'url': 'entry/wxapp/IsHelp',
      'cachetime': '0',
      data: {
        openid: userid,//进入当前页面的openid
        userid: openid,//砍主的openid
        id: id,//商品ID
      },
      success: function (res) { 
        if (res.data.data.length == 0) {
          var join = 0
        } else {
          that.setData({
            helpPrice: res.data.data[0].kanjias,
          })
          var join = 1
        }
        that.setData({
          join: join
        })
      }
    })

  
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
   
  onShareAppMessage: function () {

  },*/
  order(e) {

  },
  bargain(e) {

  },
  onShareAppMessage: function () {

  },
  powerDrawer1: function(e){
    var that=this;
    var currentStatu = e.currentTarget.dataset.statu;
    that.util(currentStatu);
  
  },
  powerDrawer: function (e) {
    var that = this;
    var currentStatu = e.currentTarget.dataset.statu;
    var id = e.currentTarget.dataset.id;
    var openid = wx.getStorageSync('openid');//进入当前页年的openID
    var userid = wx.getStorageSync('userid');//砍主的openID
    var flag=that.data.flag;
  /*  if(flag==false){
      return
    }   
    that.setData({
      flag:false,
    })*/
    
    //查询时间是否到期
    app.util.request({
      'url': 'entry/wxapp/Expire', 
      'cachetime': '0',
      data: {
        id: id,
      },
      success: function (res) {
        if (openid == userid) {
          wx.showToast({
            title: '不能为自己砍价哦，快去求助好友吧！',
            icon: 'none',
          })
          return;
        } else if (res.data.data == 0 || res.data.data == '0') {
          wx.showToast({
            title: '活动已到期！感谢参与！',
            icon: 'none',
          })
          return;
        } else {
          //获取是否已经是最低价
          app.util.request({
            'url': 'entry/wxapp/zuidijia',
            'cachetime': '0',
            data: {
              id: id,
              openid: userid,
            },
            success: function (res) {
              console.log(res)
              if (res.data == '222' || res.data == 222) {
                app.util.request({
                  'url': 'entry/wxapp/DoHelpBargain',
                  'cachetime': '0',
                  data: { 
                    id: id,
                    openid: openid,//进入当前页面的openID
                    userid: userid,//砍主的openID
                  },
                  success: function (res) {
                    that.util(currentStatu);
                    that.setData({
                      isHelp: true
                    })
                    var helpPrice = res.data.data;
                  //  helpPrice = helpPrice.toFixed(2);四舍五入
                    console.log(helpPrice) 
                    that.setData({
                      helpPrice: helpPrice,
                      hideShopPopup: false
                    })
                   
                    var kanjiaid = wx.getStorageSync('kanjiaid');
                    var userid = wx.getStorageSync('userid');
                    app.util.request({
                      'url': 'entry/wxapp/helpBargain',
                      'cachetime': '0',
                      data: {
                        id: kanjiaid,
                        openid: userid,
                      },
                      success: function (res) {
                        that.setData({
                          helpbargain: res.data.data
                        })
                        
                        var id = wx.getStorageSync('kanjiaid');
                        var openid = wx.getStorageSync('userid');//砍主的OPENID
                        //查询帮砍主砍价的人
                        app.util.request({
                          'url': "entry/wxapp/Friends",
                          'cachetime': '0',
                          data: {
                            openid: openid,
                            id: id,
                          },
                          success: function (res) {
                            console.log(res)
                            that.setData({
                              friends: res.data.data
                            })
                          }
                        })



                        
                      }
                    })

                  }
                })
                that.onShow();
              } else {
                wx.showToast({
                  title: '已经很低啦，不能再砍了！',
                  icon: 'none',
                })
              }
            }
          })



        }
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
      animation.opacity(1).height('468rpx').step();
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
  toDetail(e) {
    var id = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: '../bardet/bardet?gid=' + id,
    }) 
  },
  toIndex(e) {
    wx.redirectTo({
      url: '/yzmdwsc_sun/pages/index/index',
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
    if (url == '') {
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
    } else {
      that.setData({
        url: url,
      })
    }
    var settings = wx.getStorageSync('settings');
    if (settings == '') {
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
    } else {
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
    if (openid == '') {
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
    } else {
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

})