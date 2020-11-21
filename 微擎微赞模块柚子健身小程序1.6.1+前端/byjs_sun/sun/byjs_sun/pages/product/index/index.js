// byjs_sun/pages/product/index/index.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    telphone: '',
    is_modal_Hidden: true,
    isLogin: true,
    Immediately:false,   //控制红包开关,true显示，false不显示
    ImmediatelyOpen:false,  //控制红包流程
    total:'',           //红包额度
    // ---------轮播图---------------
    indicatorDots: false,
    autoplay: true,
    interval: 3000,
    duration: 1000,
    bannerList:[],
    nav: [
      {
        img: '../../../../byjs_sun/resource/images/index/myUser.png',
        text: '课程',
        goUrl: '/byjs_sun/pages/product/course/course'
      },
      {
        img: '../../../../byjs_sun/resource/images/index/Fitness.png',
        text: '入会',
        goUrl: '/byjs_sun/pages/product/admission/admission'
      }
    ],
    fight: [
     
    ],
    productRecommend: [
  
    ],
    adBtn:'',
    tabBarList: [
  
    ]
  },
    
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    
      var that = this;

      that.wxauthSetting();

      if(app.globalData.refresh == true){
        // 红包
        app.util.request({
          'url': 'entry/wxapp/Redpacket',
          'cachetime': 30,
          success: function (res) {
            console.log(res.data)
            if (res.data == false) {
              that.setData({
                total: '',
                Immediately: false
              })
            } else {
              that.setData({
                total: res.data,
                Immediately: true
              })
              wx.setStorageSync('total', res.data)
            }

           
          }
        })


        //广告
        app.util.request({
          'url': 'entry/wxapp/GetAd',
          'cachetime': 0,
          success: function (res) {
            if (res.data == 0) {
              that.setData({
                adBtn: false
              })
            } else {
              that.setData({
                adBtn: true,
                logo: res.data.logo
              })
            }
          }
        })
        app.globalData.refresh = false

      }
      // 查看是否授权
  
      // --------------------------获取url-----------------------
      app.util.request({
        'url': 'entry/wxapp/Url',
        'cachetime': '30',
        success: function (res) 
        {
          // ---------------------------------- 异步保存网址前缀----------------------------------
          wx.setStorageSync('url', res.data)
          that.setData({
            url: res.data
          })
        },
      })


      // 获取底部图标
      app.util.request({
        'url': 'entry/wxapp/Tab',
        'cachetime': 30,
        success: function (res) {
          var data1 = [{
            state: true,
            url: 'goIndex',
            publish: false,
            text: res.data.data.index,
            iconPath: res.data.data.indeximg,
            selectedIconPath: res.data.data.indeximgs,
          },
          {

            state: false,
            url: 'goChargeIndex',
            publish: false,
            text: res.data.data.coupon,
            iconPath: res.data.data.couponimg,
            selectedIconPath: res.data.data.couponimgs,
          },
          {
            state: false,
            url: 'goPublishTxt',
            publish: true,
            text: res.data.data.fans,
            iconPath: res.data.data.fansimg,
            selectedIconPath: res.data.data.fansimgs,
          },
          {
            state: false,
            url: 'goFindIndex',
            publish: false,
            text: res.data.data.find,
            iconPath: res.data.data.findimg,
            selectedIconPath: res.data.data.findimgs,
          },
          {
            state: false,
            url: 'goMy',
            publish: false,
            text: res.data.data.mine,
            iconPath: res.data.data.mineimg,
            selectedIconPath: res.data.data.mineimgs,
          },
          ]
          var data2 = [{
            state: false,
            url: 'goIndex',
            publish: false,
            text: res.data.data.index,
            iconPath: res.data.data.indeximg,
            selectedIconPath: res.data.data.indeximgs,
          },
          {

            state: true,
            url: 'goChargeIndex',
            publish: false,
            text: res.data.data.coupon,
            iconPath: res.data.data.couponimg,
            selectedIconPath: res.data.data.couponimgs,
          },
          {
            state: false,
            url: 'goPublishTxt',
            publish: true,
            text: res.data.data.fans,
            iconPath: res.data.data.fansimg,
            selectedIconPath: res.data.data.fansimgs,
          },
          {
            state: false,
            url: 'goFindIndex',
            publish: false,
            text: res.data.data.find,
            iconPath: res.data.data.findimg,
            selectedIconPath: res.data.data.findimgs,
          },
          {
            state: false,
            url: 'goMy',
            publish: false,
            text: res.data.data.mine,
            iconPath: res.data.data.mineimg,
            selectedIconPath: res.data.data.mineimgs,
          },
          ]
          var data3 = [{
            state: false,
            url: 'goIndex',
            publish: false,
            text: res.data.data.index,
            iconPath: res.data.data.indeximg,
            selectedIconPath: res.data.data.indeximgs,
          },
          {

            state: false,
            url: 'goChargeIndex',
            publish: false,
            text: res.data.data.coupon,
            iconPath: res.data.data.couponimg,
            selectedIconPath: res.data.data.couponimgs,
          },
          {
            state: true,
            url: 'goPublishTxt',
            publish: true,
            text: res.data.data.fans,
            iconPath: res.data.data.fansimg,
            selectedIconPath: res.data.data.fansimgs,
          },
          {
            state: false,
            url: 'goFindIndex',
            publish: false,
            text: res.data.data.find,
            iconPath: res.data.data.findimg,
            selectedIconPath: res.data.data.findimgs,
          },
          {
            state: false,
            url: 'goMy',
            publish: false,
            text: res.data.data.mine,
            iconPath: res.data.data.mineimg,
            selectedIconPath: res.data.data.mineimgs,
          },
          ]
          var data4 = [{
            state: false,
            url: 'goIndex',
            publish: false,
            text: res.data.data.index,
            iconPath: res.data.data.indeximg,
            selectedIconPath: res.data.data.indeximgs,
          },
          {

            state: false,
            url: 'goChargeIndex',
            publish: false,
            text: res.data.data.coupon,
            iconPath: res.data.data.couponimg,
            selectedIconPath: res.data.data.couponimgs,
          },
          {
            state: false,
            url: 'goPublishTxt',
            publish: true,
            text: res.data.data.fans,
            iconPath: res.data.data.fansimg,
            selectedIconPath: res.data.data.fansimgs,
          },
          {
            state: true,
            url: 'goFindIndex',
            publish: false,
            text: res.data.data.find,
            iconPath: res.data.data.findimg,
            selectedIconPath: res.data.data.findimgs,
          },
          {
            state: false,
            url: 'goMy',
            publish: false,
            text: res.data.data.mine,
            iconPath: res.data.data.mineimg,
            selectedIconPath: res.data.data.mineimgs,
          },
          ]
          var data5 = [{
            state: false,
            url: 'goIndex',
            publish: false,
            text: res.data.data.index,
            iconPath: res.data.data.indeximg,
            selectedIconPath: res.data.data.indeximgs,
          },
          {

            state: false,
            url: 'goChargeIndex',
            publish: false,
            text: res.data.data.coupon,
            iconPath: res.data.data.couponimg,
            selectedIconPath: res.data.data.couponimgs,
          },
          {
            state: false,
            url: 'goPublishTxt',
            publish: true,
            text: res.data.data.fans,
            iconPath: res.data.data.fansimg,
            selectedIconPath: res.data.data.fansimgs,
          },
          {
            state: false,
            url: 'goFindIndex',
            publish: false,
            text: res.data.data.find,
            iconPath: res.data.data.findimg,
            selectedIconPath: res.data.data.findimgs,
          },
          {
            state: true,
            url: 'goMy',
            publish: false,
            text: res.data.data.mine,
            iconPath: res.data.data.mineimg,
            selectedIconPath: res.data.data.mineimgs,
          },
          ]
          // 是否显示
          app.util.request({

            'url': 'entry/wxapp/SwitchBar',
            'cachetime': 0,
            success: function (res) {
              // console.log(res.data.is_fbopen+'sss')
              let is_fbopen = res.data.is_fbopen
              if (is_fbopen == "0") {
                data1.splice(2, 2)
                data2.splice(2, 2)
                data3.splice(2, 2)
                data4.splice(2, 2)
                data5.splice(2, 2)
                that.setData({
                  tabBarList: data1
                })
              } else {
                that.setData({
                  tabBarList: data1
                })
              }
              app.globalData.tabbar1 = data1
              app.globalData.tabbar2 = data2
              app.globalData.tabbar3 = data3
              app.globalData.tabbar4 = data4
              app.globalData.tabbar5 = data5
              
            }
          })
          
        }
      })
   
      // 轮播图
      app.util.request({
        'url':'entry/wxapp/Banner',
        'cachetime':'30',
        // 成功回调
        success:function(res){
          console.log(res.data)
          that.setData({
            bannerList: res.data.lb_imgs

          })

        },
      })
      //获取首页顶部文字
      app.util.request({
        'url': 'entry/wxapp/system',
        'cachetime': '0',
        success(res) {
          var title = res.data.pt_name; //后台设置的首页顶部标题
          var fontcolor = res.data.fontcolor;  //顶部字体颜色
          var color = res.data.color;     //顶部背景颜色
          wx.setStorageSync('color', color);
          wx.setStorageSync('fontcolor', fontcolor);
          //设置标题为后台设置的值
          wx.setNavigationBarTitle({
            title: title,
          })
        }
      })

      //设置顶部背景色和字体颜色
      wx.setNavigationBarColor({
        frontColor: wx.getStorageSync('fontcolor'),
        backgroundColor: wx.getStorageSync('color'),
        animation: {
          duration: 0,
          timingFunc: 'easeIn'
        }
      })

      // 文章
      app.util.request({
        'url':'entry/wxapp/GoodsArticle',
        'cachetime':'30',
        success:function(res){
          console.log(res.data);
          that.setData({
            productRecommend:res.data
          })
        },
      })
      // 热门推荐
      app.util.request({
        'url':'entry/wxapp/CourseType',
        'cachetime':'30',
        success:function(res){
          console.log(res.data)
          that.setData({
            fight:res.data
          })
        }
      })

      // 电话
      app.util.request({
        'url': 'entry/wxapp/GetPhone',
        'cachetime': 0,
        success: function (res) {
          that.setData({
            telphone: res.data
          })
        }
      })
    // 获取技术支持
    app.util.request({
      'url':'entry/wxapp/GetTeam',
      'cachetime':0,
      success(res){
        that.setData({
          team:res.data
        })
      }
    })

  },
  goIndex: function (e) {
    wx.redirectTo({
      url: '../../product/index/index'
    })
  },
  goChargeIndex: function (e) {
    wx.redirectTo({
      url: '../../charge/chargeIndex/chargeIndex'
    })
  },
  goPublishTxt: function (e) {
    wx.redirectTo({
      url: '../../publishInfo/publish/publishTxt'
    })
  },
  goFindIndex: function (e) {
    wx.redirectTo({
      url: '../../find/findIndex/findIndex'
    })
  },
  goMy: function (e) {
    wx.redirectTo({
      url: '../../myUser/my/my'
    })
  },
  
  goAllcourse: function(e) {
    wx.navigateTo({
      url: '../allcourse/allcourse'
    })
  },
  goAllarticle: function (e) {
    wx.navigateTo({
      url: '../allarticle/allarticle'
    })
  },
  closeAd: function (e) {
    var that = this
    that.setData({
      adBtn: false,
      
    })

  },
// 登录事件
  onLaunch: function () {

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
    // 获取access_token
    app.util.request({
      'url': 'entry/wxapp/AccessToken',
      'cachetime': 30,
      success(res) {
        wx.setStorageSync('access_token',res.data.access_token)
        //console.log(res.data.access_token + '这是获取access_token的值')
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
   */
  onShareAppMessage: function () {
  
  },
  //自定义事件
  ImmediatelyOpen: function(){
    this.setData({
      ImmediatelyOpen:true
    })
  },
  colse: function(){
    this.setData({
      Immediately:false
    })
  },
  // 热门推荐跳转
  goBay: function(e){
    var id = e.currentTarget.dataset.id
    wx.navigateTo({
      url: '/byjs_sun/pages/product/core/core?id='+id,
    })
  },
  // 标题跳转
  toDetail:function(e){
    var url = e.currentTarget.dataset.url
    wx.navigateTo({
      url: url,
    })
  },
  // 查看红包
  see:function(e){
     wx.navigateTo({
       url: '/byjs_sun/pages/myUser/myRedEnvelope/myRedEnvelope',
     })
  },
  goWritings: function(e){
    var id = e.currentTarget.dataset.id;
    var goods_id = e.currentTarget.dataset.goods_id;
    // var url = encodeURIComponent('id='+id +'&? goods_id='+goods_id);
    // var url1 = encodeURIComponent(goods_id);
    // console.log(url);
    wx.navigateTo({     
      url: '/byjs_sun/pages/product/writings/writingsInfo/writingsInfo?id='+id+'&goods_id='+goods_id,
    })
  },
  wxauthSetting(e) {
    var that = this;
    //先判断是否已经缓存用户数据，有就不用在获取授权进行存储
    var openid = wx.getStorageSync('openid');//用户openid
    if (openid) {
      wx.getSetting({
        success: function (res) {
          console.log("进入wx.getSetting 1");
          console.log(res);
          if (res.authSetting['scope.userInfo']) {
            console.log("scope.userInfo已授权 1");
            wx.getUserInfo({
              success: function (res) {
                that.setData({
                  is_modal_Hidden: true,
                  thumb: res.userInfo.avatarUrl,
                  nickname: res.userInfo.nickName
                })
              }
            })
          } else {
            console.log("scope.userInfo没有授权 1");
            wx.showModal({
              title: '获取信息失败',
              content: '请允许授权以便为您提供给服务',
              success: function (res) {
                that.setData({
                  is_modal_Hidden: false
                })
              }
            })
          }
        },
        fail: function (res) {
          console.log("获取权限失败 1");
          that.setData({
            is_modal_Hidden: false
          })
        }
      })
    } else {
      wx.login({
        success: function (res) {
          console.log("进入wx-login");
          var code = res.code
          wx.setStorageSync("code", code)
          wx.getSetting({
            success: function (res) {
              console.log("进入wx.getSetting");
              console.log(res);
              if (res.authSetting['scope.userInfo']) {
                console.log("scope.userInfo已授权");
                wx.getUserInfo({
                  success: function (res) {
                    that.setData({
                      is_modal_Hidden: true,
                      thumb: res.userInfo.avatarUrl,
                      nickname: res.userInfo.nickName
                    })
                    console.log("进入wx-getUserInfo");
                    console.log(res.userInfo);
                    wx.setStorageSync("user_info", res.userInfo)
                    var nickName = res.userInfo.nickName
                    var avatarUrl = res.userInfo.avatarUrl
                    var gender = res.userInfo.gender;
                    app.util.request({
                      'url': 'entry/wxapp/openid',
                      'cachetime': '0',
                      data: { code: code },
                      success: function (res) {
                        console.log("进入获取openid");
                        console.log(res.data)
                        wx.setStorageSync("key", res.data.session_key)
                        // wx.setStorageSync("openid", res.data.openid)
                        var openid = res.data.openid
                        wx.setStorageSync('userid', res.data.openid)
                        wx.setStorage({
                          key: 'openid',
                          data: openid,
                        })
                        // 获取用户数据

                        app.util.request({
                          'url': 'entry/wxapp/Login',
                          'cachetime': '0',
                          data: { openid: openid, img: avatarUrl, name: nickName, gender: gender },
                          success: function (res) {
                            console.log("进入地址login");
                            console.log(res.data)
                            //wx.setStorageSync('viptype', res.data)
                            // console.log(res.data.time+'hhhhhhhhhhhhhhhh')
                            wx.setStorageSync('users', res.data)
                            wx.setStorageSync('uniacid', res.data.uniacid)
                            that.setData({
                              usersinfo: res.data
                            })
                          },
                        })
                      },
                    })
                  },
                  fail: function (res) {
                    console.log("进入 wx-getUserInfo 失败");
                    wx.showModal({
                      title: '获取信息失败',
                      content: '请允许授权以便为您提供给服务!',
                      success: function (res) {
                        that.setData({
                          is_modal_Hidden: false
                        })
                      }
                    })
                  }
                })
              } else {
                console.log("scope.userInfo没有授权");
                // wx.showModal({
                //   title: '获取信息失败',
                //   content: '请允许授权以便为您提供给服务!!',
                //   success: function (res) {
                that.setData({
                  is_modal_Hidden: false
                })
                //   }
                // })
              }
            }
          })
        },
        fail: function () {
          wx.showModal({
            title: '获取信息失败',
            content: '请允许授权以便为您提供给服务!!!',
            success: function (res) {
              that.setData({
                is_modal_Hidden: false
              })
            }
          })
        }
      });
    }
  },
  updateUserInfo(e) {
    console.log("授权操作更新");
    var that = this;
    that.wxauthSetting();
  },
  callTelephone: function (e) {
    var that = this
    var telphone = that.data.telphone
    wx.makePhoneCall({
      phoneNumber: telphone //仅为示例，并非真实的电话号码
    })
  },

 
})