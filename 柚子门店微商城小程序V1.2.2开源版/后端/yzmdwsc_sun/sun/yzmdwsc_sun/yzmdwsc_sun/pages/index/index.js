//index.js
//获取应用实例
var app = getApp()
var tool = require('../../../style/utils/countDown.js');  
Page({
  data: {
    navTile: '首页',
    imgUrls: [
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png',
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842319.png',
      'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842327.png'
    ],
    indicatorDots: false,
    autoplay: false,
    interval: 3000,  
    duration: 800, 
    current:0,
    notName:'公告',
    notice: '本周凡是进店，送菇凉一枚',/**公告 */
    operation:[
      {
        name:'预约',
        src:'../../../style/images/nav8.png',
        bindname:"toBook"
      },
      {
        name: '好物',
        src: '../../../style/images/nav2.png',
        bindname:'toGood'
      },
      {
        name: '优惠券',
        src: '../../../style/images/nav7.png',
        bindname:'toCards'
      },
      {
        name: '关于我们',
        src: '../../../style/images/nav4.png',
        bindname:"toAbout"
      },
      {
        name: '拼团',
        src: '../../../style/images/nav5.png',
        bindname:'toGroup'
      },
      {
        name: '砍价',
        src: '../../../style/images/nav3.png',
        bindname: 'toBargain'
      },
      {
        name: '限时购',
        src: '../../../style/images/nav6.png',
        bindname:"toLimit"
      },
      {
        name: '分享',
        src: '../../../style/images/nav1.png',
        bindname:'toShare'
      },
    ],
    shopUserImg:'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295622.png',/** */
    shopMsg:'欢迎光临本店',
    shopMsg2:'有问题点击右边按钮进行客服咨询',
    shopPhone:'13000000',/***电话 */
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
    /**砍价 */
    bargainList: [
      {
        title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162021.png',
        price: '600',
        minPrice: '300.00',
        usernum: '99',
        uthumb: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311829.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311834.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311837.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15221231184.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311843.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314013.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314019.png'
        ],
        endTime: '1529799965000',/**1529799965000 */
        clock: ''
      },
      {
        title: '发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162003.png',
        price: '600',
        minPrice: '398.00',
        usernum: '109',
        uthumb: [
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311829.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311834.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311837.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15221231184.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212311843.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314013.png',
          'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152212314019.png'
        ],
        endTime: '1554519898765',/**1521519898765 */
        clock: ''
      }
    ],
    newList: [
      {
        title:"发财树绿萝栀子花海棠花卉盆栽",
        src:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
        price:'399.00'
      },
      {
        title: "发财树绿萝栀子花海棠花卉盆栽",
        src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
        price: '399.00'
      },
    ],
    /**拼团 */
    group:[
      {
        title: '发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽',
        bgSrc: 'http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531162003.png',
        price: '600',
        minPrice: '398.00',
        usernum: '109',
        group:'多人拼，更省',
        groupUser:'2人团',
        num:'99'
      }
    ],
    isLogin:false,
    showAd: false,
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    var settings=wx.getStorageSync("settings");
    if(settings!=''){
      wx.setNavigationBarTitle({
        title: settings.index_title,
      });
    }
    var that = this;
    //获取当前路径
    var pages = getCurrentPages() //获取加载的页面
    var currentPage = pages[pages.length - 1] //获取当前页面的对象
    var current_url = currentPage.route;
    console.log('当前路径为:' + current_url);
    that.setData({
      current_url:current_url,
    })
    app.editTabBar();  /**渲染tab */
  //请求退款 测试退款 entry/wxapp/applyrefund 
  //检查
    app.util.request({
      'url': 'entry/wxapp/checkGroups',
      'cachetime': '0',
      success: function (res) {
       
      },  
    })
 
  //  ---------------------------------- 异步保存网址前缀----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url1', 
      'cachetime': '30',
      success: function (res) {
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
        that.reload(); 
        that.getSomething();
      }, 
    })
    /*
    var countDown = that.data.bargainList;
    var cdInterval = setInterval(function () {
      for (var i = 0; i < countDown.length; i++) {
        var time = tool.countDown(that, countDown[i].endTime);
        if (time) {
          countDown[i].clock = '距离结束还剩：' + time[0] + '天' + time[1] + "时" + time[3] + "分" + time[4] + "秒";
        } else {
          countDown[i].clock = '已经截止';
           clearInterval(cdInterval);
        }
        that.setData({
          bargainList: countDown
        })
      }
    }, 1000)*/
  },

  getCoupon: function (openid) {
    var that = this
    //优惠券
    app.util.request({
      'url': 'entry/wxapp/getCoupon',
      'cachetime': '0',
      data: {
        uid: openid,
        show_index: 1,
      },
      success: function (res) {
        that.setData({
          coupon: res.data.data
        })
      }
    })
  },

  getSomething: function () {
    var that = this
    //---------获取轮播图----------
  /*  app.util.request({
      'url': 'entry/wxapp/Banner',
      'cachetime': '5',
      success: function (res) {
        that.setData({
          swiper: res.data
        })
      }
    })*/
    //获取自定义图标
    app.util.request({
      'url': 'entry/wxapp/getCustomize',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('tab', res.data.tab)
        that.setData({
            customize:res.data,
        })
      }
    }) 


    
    //---------获取基础信息-首页公告-欢迎语 问题咨询----------
    app.util.request({
      'url': 'entry/wxapp/Settings',
      'cachetime': '20', 
      success: function (res) {
       wx.setStorageSync("settings",res.data);
       that.setData({
         settings: res.data,
         navTile: res.data.index_title,
       })
      
       //广告
       var is_adv1 = res.data.is_adv;
       var is_adv2 = wx.getStorageSync('is_adv');
       if (is_adv1 == 1 && is_adv2==''){
         that.setData({
           showAd:true,
         })
       } 
       
      }
    }) 

    //-------首页营销活动图标----------
    app.util.request({
      'url': 'entry/wxapp/icons',
      'cachetime': '10',
      success: function (res) { 
        that.setData({
          icons: res.data.data,
       //   system: res.data.system
        })
      }
    }) 
  },
  //获取用户信息和底部标识
  reload: function (e) {
    var that = this
    // ----------------------------------获取用户登录信息----------------------------------
    wx.login({ 
      success: function (res) {
        var code = res.code; 
        wx.setStorageSync("code", code)
        app.util.request({
          'url': 'entry/wxapp/openid',
          'cachetime': '0',
          data: { code: code },
          success: function (res) {
            wx.setStorageSync("key", res.data.session_key)
            wx.setStorageSync("openid", res.data.openid)
            var openid = res.data.openid;
            that.getCoupon(openid);
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
                            that.setData({
                              avatarUrl: avatarUrl
                            })
                      },
                    /*  fail: function (res) {
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
                      }*/
                    })   
                }
              }
            })
          }
        })
      }
    })
    //获取底部自定义图标
  /*  app.util.request({
      'url': 'entry/wxapp/tab',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('tab', res.data.data)
        that.setData({
          tab: res.data.data,
        })
      }
    })*/
  },

  /**
     * 生命周期函数--监听页面显示
     */ 
  onShow: function () { 
    var that = this;
    var is_login = wx.getStorageSync('is_login');
    if(!is_login){
      wx.getSetting({
        success: function (res) {
          if (res.authSetting['scope.userInfo']){
                wx.setStorageSync('is_login', 1);
                that.setData({
                  isLogin:false,
                })
          }else{
            that.setData({
              isLogin: true,
            })
          }
        }
      })
    }
 
    app.util.request({
      'url': 'entry/wxapp/system',
      'cachetime': '20',
      success: function (res) {
        wx.setStorageSync('system', res.data)
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
      }
    })

   
  /*  //获取优惠券
    wx.getStorage({
      key: 'openid',
      success: function (res) {*/       
     /* }
    })*/

    //获取砍价商品
    app.util.request({
      'url': 'entry/wxapp/getBargainGoods',
      'cachetime': '0',
      data: {
        index: 8,
      },
      success: function (res) {
        var countDown = res.data;
        var cdInterval = setInterval(function () {
          for (var i = 0; i < countDown.length; i++) {
            var time = tool.countDown(that, countDown[i].endtime);/***第二个参数 结束时间 */
            /*if (time) {
              countDown[i].clock = time[2] + " : " + time[3] + " : " + time[4];
            } else {
              countDown[i].clock = '00 : 00 : 00';
            }*/
            if (time) {
              countDown[i].clock = '距离结束还剩：' + time[0] + '天' + time[1] + "时" + time[3] + "分" + time[4] + "秒";
            } else {
              countDown[i].clock = '已经截止';
            }
          }
          that.setData({
            bargainrecommend: countDown
          })
        }, 1000)
      }
    })
    //获取新品推荐
    app.util.request({
      'url': 'entry/wxapp/TypeGoodList',
      'cachetime': '0',
      data: {
        show_index:1,
      },
      success: function (res) {
        console.log(res)
        that.setData({
          goodsrecommend: res.data
        })
      }
    }) 

    //获取拼团商品
    app.util.request({
      'url': 'entry/wxapp/getGroupGoods',
      'cachetime': '0',
      data: {
        index: 8,
      }, 
      success: function (res) {
        var countDown = res.data;
        that.setData({
          groupsrecommend: countDown
        })
      }
    })

    //获取预约商品
    app.util.request({
      'url': 'entry/wxapp/getYuyueGoods',
      'cachetime': '0',
      data: {
        index: 8,
      }, 
      success: function (res) {
        var countDown = res.data;
        that.setData({
          yuyuerecommend: countDown
        })
      }
    })

    //获取好物商品
    app.util.request({
      'url': 'entry/wxapp/getHaowuGoods',
      'cachetime': '0',
      data: {
        index: 8,
      },
      success: function (res) {
        var countDown = res.data;
        that.setData({
          haowurecommend: countDown
        })
      }
    })

    //获取限时购商品
    app.util.request({
      'url': 'entry/wxapp/getLimitGoods',
      'cachetime': '0',
      data: {
        index: 8,
      },
      success: function (res) {
        var countDown = res.data;
         setInterval(function () {
          for (var i = 0; i < countDown.length; i++) {
            var time = tool.countDown(that, countDown[i].endtime);
            if (time) {
              countDown[i].clock = time[2] + " : " + time[3] + " : " + time[4];
            } else {
              countDown[i].clock = '00 : 00 : 00';
            }
          }
          that.setData({
            limitrecommend: countDown
          })
        }, 1000)
      }
    })

    //获取分享商品
    app.util.request({
      'url': 'entry/wxapp/getShareGoods',
      'cachetime': '0',
      data: {
        index: 8,
      },
      success: function (res) {
        var countDown = res.data;
        that.setData({
          sharerecommend: countDown
        })
      }
    })

    //首页推荐排序
    app.util.request({
      'url': 'entry/wxapp/getRecommendSort',
      'cachetime': '10',
      success: function (res) {
         that.setData({
           RecommendSort:res.data,
         })
      }
    })
    
  }, 
  //底部链接
  goTap: function (e) {
   // console.log(e);
     var that = this;
    that.setData({
      current: e.currentTarget.dataset.index
    })
    if (that.data.current == 0) {
      wx.redirectTo({
        url: '../index/index?currentIndex=' + 0,
      })
    }; 
    if (that.data.current == 1) {
      wx.redirectTo({
        url: '../shop/shop?currentIndex=' + 1,
      })
    }; 
    if (that.data.current == 2) {
      wx.redirectTo({
        url: '../active/active?currentIndex=' + 2,
      })
    }; 
    if (that.data.current == 3) {
      wx.redirectTo({
        url: '../carts/carts?currentIndex=' + 3,
      })
    }; 
    if (that.data.current == 4) {
      wx.redirectTo({
        url: '../user/user?currentIndex=' + 4,
      })
    }; 
  },


  /**拨打电话 */
  toDialog(e){
    wx.makePhoneCall({
      phoneNumber: this.data.settings.tel,
    })
  },
  callphone(e){
    wx.makePhoneCall({
      phoneNumber: this.data.settings.hz_tel,
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
          console.log('openid为')
          console.log(res.data)
          app.util.request({
            'url': 'entry/wxapp/receiveCoupon',
            'cachetime': '0',
            data: {
              uid: res.data,
              gid: gid
            },
            success: function (res) {
              var errno = res.data.errno;
              if (errno == 0 || errno == 3) {
                cards[index].status = 2;
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
              } else if (errno == 1 || errno == 2) {
                cards[index].status = 1;
              }
              that.setData({
                coupon: cards
              })
            }
          })
        }
      })
    } 

  },
  toBook(e) {
    wx: wx.navigateTo({
      url: 'book/book',
    })
  },
  toCards(e) {
    wx: wx.navigateTo({
      url: 'cards/cards',
    })
  },
  toAbout(e) {
    wx: wx.navigateTo({
      url: 'about/about',
    })
  },
  toGroup(e) {
    wx: wx.navigateTo({
      url: 'group/group',
    })
  },
  toBargain(e) {
    wx: wx.navigateTo({
      url: 'bargain/bargain',
    })
  },
  toLimit(e) {
    wx: wx.navigateTo({
      url: 'limit/limit',
    })
  },
  toShare(e) {
    wx: wx.navigateTo({
      url: 'share/share',
    })
  },
  toGood(e) {
    wx: wx.navigateTo({
      url: 'good/good',
    })
  },
  toBardet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'bardet/bardet?gid='+gid,
    })
  },
  toGoodsdet(e) {
    var gid=e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'goodsDet/goodsDet?gid='+gid,
    })
  },
  toGroupdet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'groupDet/groupDet?gid='+gid,
    })
  },
  isLogin(e){
    this.setData({
      isLogin: !this.data.isLogin
    }) 
  },
  bindGetUserInfo(e){
   console.log(e)
   console.log(e.detail.userInfo)
   if(e.detail.userInfo==undefined){ 
      console.log('没有授权')
   }else{
      wx.setStorageSync('is_login',1);
      this.setData({
        isLogin: false,
      })
   } 
    
  },
  onShareAppMessage: function () {
  },
  toSharedet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'shareDet/shareDet?gid='+gid,
    })
  },
  toGooddet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'goodDet/goodDet?gid='+gid,
    })
  },
  toBookdet(e) {
    var gid = e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'bookDet/bookDet?gid='+gid,
    })  
  },
  toLimitdet(e) {
    var gid=e.currentTarget.dataset.gid;
    wx: wx.navigateTo({
      url: 'limitDet/limitDet?gid='+gid,
    })
  },
  toggleAd(e) {   
    wx.setStorageSync('is_adv',1);
    this.setData({
      showAd: false,
    })
  },
  toBanner(e){
    var url=e.currentTarget.dataset.url;
    url='/'+url;
    wx: wx.navigateTo({
      url: url,
    })
  },
  toIcons(e){
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    wx: wx.navigateTo({
      url: url,
    })
  },
  toTab(e) {
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    // wx: wx.navigateTo({
    //   url: url,
    // })
    wx.redirectTo({
      url: url,
    })
  },
  

})
