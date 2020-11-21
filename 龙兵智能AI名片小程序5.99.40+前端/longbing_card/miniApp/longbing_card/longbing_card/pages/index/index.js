var app = getApp()
var auth = require('../../templates/auth/auth.js')
var voucher = require('../../templates/voucher/voucher.js')
import util from '../../resource/js/xx_util.js';
import { userModel, baseModel } from '../../resource/apis/index.js'


var Fly = require("../../resource/js/wx.js") //wx.js为您下载的源码文件
var fly = new Fly; //创建fly实例

var timer;
var timerCoupon;
var timerClientUnread;
const innerAudioContext = wx.createInnerAudioContext();

Page({
  data: {
    // 通用   
    voucherStatus:{
      show: true,
      status: 'unreceive',
    },  
    tmp_coupon_i:0,
    coupon_record:false,
    coupon_nickName:'',
    coupon_reduce:'',
    
    globalData: {},
    userid: '',
    authStatus: 400,
    showTabBar: false,
    currentTabBarInd: '',
    currentTabBar: 'cardList',
    toLeavingMessage: '',
    qrImg: '',
    //员工信息
    avatarUrl: '',
    avatarName: '',
    // 名片列表
    cardToAddStatus: false,
    customID: '',
    collectStatus: '-1',
    collectionList: {
      page: 1,
      total_page: '',
      list: []
    },
    paramCardList: {
      page: 1
    },
    refreshCardList: false,
    loadingCardList: true,
    // 名片
    paramCardIndex: {
      from_id: '',
      to_uid: ''
    },
    moreStatus: 1,
    playPushStatus: 1,
    showShareStatus: 0,
    cardZanType: '',
    cardIndexData: {},
    refreshCardIndex: false,
    // 商城
    activeIndex: 100000101,
    paramShop: {
      page: 1,
      type_id: 0
    },
    refreshShop: false,
    loadingShop: true,
    shop_all: {
      page: 1,
      total_page: '',
      list: []
    },
    categoryid:0,
    scrollNav:'scrollNavAll',
    // 动态
    paramNews: {
      page: 1,
      to_uid: ''
    },
    refreshShop: false,
    loadingShop: true,
    newsList: {
      page: 1,
      total_page: '',
      list: []
    },
    newsIndex: [],
    evaStatus: false,
    currentNewsIndex: '',
    evaContent: '',
    ThumbsId: '',
    evaId: '',
    // 公司官网
    swiperStatus: {
      indicatorDots: false,
      autoplay: true
    },
    swiperIndexCur: 0,
    refreshCompany: false,
    icon_voice_png: 'http://retail.xiaochengxucms.com/images/12/2018/11/IgvvwVNUIVn6UMh4Dmh4m6nM4Widug.png',
    icon_voice_gif: 'http://retail.xiaochengxucms.com/images/12/2018/11/CRFPPPTKf6f45J6H3N44BNCrjbFZxH.gif',
  },
  onLoad: function (options) {
    var that = this;
    app.util.showLoading(1);
    // 页面初始化 options为页面跳转所带来的参数 
    /*来自分_享*/
    console.log("options  index1111111111111************", options)
 
    var tmp_ShowTabBar = false; 
    var tmpCurrentTabBar = 'cardList';
    wx.hideShareMenu();
    if (options.currentTabBar) {
      tmp_ShowTabBar = true;
      if(options.currentTabBar == 'cardList'){
        tmp_ShowTabBar = false;
      }
      tmpCurrentTabBar = options.currentTabBar;
      if (options.currentTabBar == 'toCard') {
        wx.setNavigationBarTitle({
          title: '名片',
        })
        wx.showShareMenu({
          withShareTicket: true,
          success: function (res) {
            // 分_享成功
            console.log('shareMenu share success')
            console.log('分_享' + res)
          },
          fail: function (res) {
            // 分_享失败
            console.log(res)
          }
        })


      } else if (options.currentTabBar == 'toShop') {
        wx.showShareMenu();
        wx.setNavigationBarTitle({
          title: '商城',
        })
      } else if (options.currentTabBar == 'toNews') {
        wx.showShareMenu();
        wx.setNavigationBarTitle({
          title: '动态'
        })
      } else if (options.currentTabBar == 'toCompany') {
        wx.showShareMenu();
        wx.setNavigationBarTitle({
          title: '官网'
        })
      }
    }

    if (wx.getStorageSync("user")) {
      let user = wx.getStorageSync("user");
      if (user.phone) {
        app.globalData.hasClientPhone = true;
        that.setData({
          'globalData.hasClientPhone': true
        })
      }
    }

    var paramData = {};
    var { paramNews, paramCardIndex } = that.data;

    if (options.to_uid) {
      paramData.to_uid = options.to_uid;
      paramNews.to_uid = options.to_uid;
      paramCardIndex.to_uid = options.to_uid;
      app.globalData.to_uid = options.to_uid;
    }
    if (options.from_id) {
      paramData.from_id = options.from_id;
      paramCardIndex.from_id = options.from_id;
      app.globalData.from_id = options.from_id;
    }



    var nowPage = getCurrentPages();
    if (nowPage.length) {
      nowPage = nowPage[getCurrentPages().length - 1];
      if (nowPage && nowPage.__route__) {
        paramData.pageMUrl = '&m=' + nowPage.__route__.split('/')[0];
      }
    }

    if (options.custom) {
      var customID = options.custom;
      that.getCustomQrRecordInsert(customID);
    }
    
    // if (that.data.currentTabBar != 'cardList') {

      getApp().getConfigInfo(true,true).then(() => {
        that.setData({
          showTabBar: tmp_ShowTabBar,
          currentTabBar: tmpCurrentTabBar,
          paramData: paramData,
          paramNews: paramNews,
          paramCardIndex: paramCardIndex,
          globalData: app.globalData
        }, function () { 
          setTimeout(() => { 
            if (that.data.currentTabBar != 'cardList') {
              that.getCardIndexData();
            } 
            
            if (that.data.currentTabBar == 'cardList') {
              that.setData({
                collectionList: {
                  page: 1,
                  total_page: '',
                  list: []
                },
              },function(){
                that.getCollectionList();
              })
            } else if (that.data.currentTabBar == 'toCard') {
              // that.getCardIndexData();
              if (app.globalData.loginParam.scene == 1044) {
                timer = setInterval(function () {
                  // console.log(app.globalData.encryptedData,"app.globalData.encryptedData  1044")
                  if (app.globalData.encryptedData) {
                    that.toGetShareInfo();
                    // clearInterval(timer);
                  }
                }, 1000)
              }
            } else if (that.data.currentTabBar == 'toShop') {
              that.getShopTypes();
            } else if (that.data.currentTabBar == 'toNews') {
              that.getNewsList();
            } else if (that.data.currentTabBar == 'toCompany') {
              that.getModular();
            }
          }, 300);
        })
      })

    // } 



    timerClientUnread = setInterval(function () {
      let tmp_clientUnread = that.data.clientUnread;
      // console.log('tmp_clientUnread ddddddddd',tmp_clientUnread,app.globalData.clientUnread)
      if(tmp_clientUnread < app.globalData.clientUnread){
        app.globalData.clientUnreadImg = true;
        that.setData({
          'globalData.clientUnreadImg': true,
          clientUnread: app.globalData.clientUnread
        })
        setTimeout(function () { 
          app.globalData.clientUnreadImg = false;
          that.setData({
            'globalData.clientUnreadImg': false, 
          })
        }, 5000)
      } 
      // console.log("timerClientUnread = setInterval",that.data.clientUnread,app.globalData.clientUnread)
    }, 10000)

    let { cardToAddStatus } = that.data;
    if(cardToAddStatus == false){
     setTimeout(() => {
        that.setData({
          cardToAddStatus: true
        },setTimeout(() => {
          that.setData({
            cardToAddStatus: false
          },setTimeout(() => {
            that.setData({
              nofont: true
            })
          }, 600))
        }, 10000))
     }, 3000);
    }

  },
  onReady: function () {
    // console.log("页面渲染完成")
  },
  onShow: function () {
    // 页面显示
    var that = this;
    var tmpCurrentTabBar = that.data.currentTabBar;
    var tmpGD = that.data.globalData.tabBarList;
    for (let i in tmpGD) {
      if (tmpCurrentTabBar == tmpGD[i].type) {
        that.setData({
          currentTabBarInd: i
        })
      }
    }
    
    console.log("onshow   carlist ",tmpCurrentTabBar)

    if(that.data.onshowStatus == 'createCard'){ 
        app.globalData.configInfo = false;
        getApp().getConfigInfo(true,true).then(() => {
          that.setData({
            showTabBar: false,
            shop_all: {
              page: 1,
              total_page: '',
              list: []
            },
            company_company:{},
            company_modular:[],
            globalData: app.globalData,
            collectionList:{
              page:1,
              total_page: '',
              list:[]
            },
            onshowStatus:''
          }, function () {
            that.getCollectionList();
          })
        })
    } 

    // if(tmpCurrentTabBar != 'cardList'){
      // console.log('getClientUnread       chongzhi  onshow2222222222222222222222222')
      let paramObj = {
        to_uid: app.globalData.to_uid,
      }
      baseModel.getClientUnread(paramObj).then((d) => {
        let {staff_count,user_count} = d.data.count;
        // console.log(user_count,"user_count  chongzhi111111111111")
        that.setData({
          clientUnread: user_count,
          'globalData.clientUnread':user_count,
        },function(){
          app.globalData.badgeNum = staff_count; 
          app.globalData.clientUnread = user_count;
          if (app.globalData.clientUnread < user_count) {
            app.globalData.clientUnreadImg =  true; 
              setTimeout(function () { 
                app.globalData.clientUnreadImg = false;
              }, 5000)
          }
        })
      })
      // console.log('getClientUnread       chongzhi  onshow3333333333333333333')
    // }
    that.checkAuthStatus();
  },
  onHide: function () {
    // console.log("页面隐藏")
    clearInterval(timer);
    clearInterval(timerCoupon);
    clearInterval(timerClientUnread);
    console.log("onHide ==> timer timerClientUnread")
  },
  onUnload: function () {
    // console.log("页面关闭")
    clearInterval(timer);
    clearInterval(timerCoupon);
    clearInterval(timerClientUnread);
    console.log("onUnload ==> timer timerClientUnread")
  },
  onPullDownRefresh: function () {
    // console.log("监听用户下拉动作")
    var that = this;
    // that.getIndexData2();
    if (!wx.getStorageSync("user")) {
      that.checkAuthStatus();
    }
    let tmpShowTabBar = false;
    if (that.data.currentTabBar != 'cardList') {
      tmpShowTabBar = true;
    }

    app.globalData.configInfo = false;
    getApp().getConfigInfo(true,true).then(() => {
      that.setData({
        showTabBar: tmpShowTabBar,
        globalData: app.globalData
      }, function () {
        wx.showNavigationBarLoading();
        if (that.data.currentTabBar == 'cardList') {
          // console.log("名片列表 =========================onPullDownRefresh==")
          that.setData({
            refreshCardList: true
          }, function () {
            that.getCollectionList();
          })
        } else if (that.data.currentTabBar == 'toCard') {
          // console.log("名片 =========================onPullDownRefresh==")
          that.setData({
            refreshCardIndex: true
          }, function () {
            that.getCardIndexData();
          })
        } else if (that.data.currentTabBar == 'toShop') {
          // console.log("商城 =========================onPullDownRefresh==")
          that.setData({
            refreshShop: true
          }, function () {
            let { categoryid } = that.data;
            if(categoryid == 0){
              that.getShopTypes();
            } else {
              that.getShopList();
            }
          })
        } else if (that.data.currentTabBar == 'toNews') {
          // console.log("动态 =========================onPullDownRefresh==")
          that.setData({
            refreshNews: true
          }, function () {
            that.getNewsList();
          })
        } else if (that.data.currentTabBar == 'toCompany') {
          // console.log("公司官网 =========================onPullDownRefresh==")
          that.setData({
            refreshCompany: true
          }, function () {
            that.getModular();
          })
        }
      })

    })

  },
  onReachBottom: function () {
    // console.log("监听页面上拉触底")
    var that = this;
    let tmpShowTabBar = false;
    if (that.data.currentTabBar != 'cardList') {
      tmpShowTabBar = true;
    }
    that.setData({
      showTabBar: tmpShowTabBar,
      loadingShop: false,
      loadingNews: false,
    }, function () {
      if (that.data.currentTabBar == 'cardList') {
        // console.log("名片列表 =========================onReachBottom==")      
        let { loadingCardList } = that.data;
        let { page, total_page } = that.data.collectionList;
        if (page != total_page && !loadingCardList) {
          that.setData({
            'paramCardList.page': parseInt(page) + 1,
            loadingCardList: true
          })
          that.getCollectionList();
        }
      } else if (that.data.currentTabBar == 'toShop') {
        // console.log("商城 =========================onReachBottom==")      
        let { loadingShop } = that.data;
        let { page, total_page } = that.data.shop_all;
        if (page != total_page && !loadingShop) {
          that.setData({
            'paramShop.page': parseInt(page) + 1,
            loadingShop: true
          })
          that.getShopList();
        }
      } else if (that.data.currentTabBar == 'toNews') {
        // console.log("动态 =========================onReachBottom==")      
        let { loadingNews } = that.data;
        let { page, total_page } = that.data.newsList;
        if (page != total_page && !loadingNews) {
          that.setData({
            'paramNews.page': parseInt(page) + 1,
            loadingNews: true
          })
          that.getNewsList();
        }
      }
    })

  },
  onPageScroll: function (e) {
    // console.log("监听页面滚动", e);
    var that = this;
    let tmpA = that.data.newsIndex;
    for (let i in tmpA) {
      if (tmpA[i] = 1) {
        tmpA[i] = 0
      }
    }
    that.setData({
      evaStatus: false,
      newsIndex: tmpA
    })
    if (that.data.currentTabBar != 'cardList') {
      that.setData({
        showTabBar: true
      })
    }
    if (that.data.currentTabBar == 'toShop') {
      if (that.data.shop_all.list.length > 2) {
        var toShopScrollTop;
        // console.log(e.scrollTop,"e.scrollTop")
        if (e.scrollTop > 200) {
          toShopScrollTop = true
        } 
        if (e.scrollTop < 200) {
          toShopScrollTop = false
        } 
        that.setData({
          toShopScrollTop: toShopScrollTop
        })
      }
    }
  },
  onShareAppMessage: function (res) {
    // console.log("用户点击右上角分_享")
    var that = this;

    if (that.data.currentTabBar == 'toCard') {
      var tmpData = that.data.cardIndexData;
      if (res.from === 'button') {
        // console.log("来自页面内转发按钮");
      }
      else {
        // console.log("来自右上角转发菜单");
      }

      // var tmpCardTitle = tmpData.info.myCompany.name;
      // if (tmpData.info.myCompany.short_name) {
      //   tmpCardTitle = tmpData.info.myCompany.short_name
      // }

      // tmpCardTitle = tmpCardTitle + '的' + tmpData.info.job_name + tmpData.info.name

      console.log("card分享事件1  that.getShareRecord();")
      that.getShareRecord();
      if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        that.getForwardRecord(1, 0);
      }
      console.log("card分享事件2 that.getShareRecord();")

      let tmp_imageUrl = tmpData.share_img;
      if(tmpData.info.card_type == 'cardType1'){
        tmp_imageUrl == tmpData.info.avatar_2
      }
      return {
        title: tmpData.info.share_text,
        path: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCard',
        // imageUrl: '',
        imageUrl: tmp_imageUrl,
        // success: function (res) {
        //   console.log("转发成功", res)
        //   that.getShareRecord();
        //   console.log("card分享事件1  that.getShareRecord();")
        //   if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        //     that.getForwardRecord(1, 0);
        //   }
        // },
        // fail: function (res) {
        //   console.log('转发失败');
        // }
      };


    } else if (that.data.currentTabBar == 'toShop') {
      if (res.from === 'button') {
        // console.log("来自页面内转发按钮");
      }
      else {
        // console.log("来自右上角转发菜单")
      }
      return {
        title: '',
        path: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toShop',
        imageUrl: '',
        // success: function (res) {
        //   console.log("转发成功", res)
        // },
        // fail: function (res) {
        //   console.log('转发失败');
        // }
      };
    } else if (that.data.currentTabBar == 'toNews') {
      // console.log(res, "****//////////////////***************")
      if (res.from === 'button') {
        var index = res.target.dataset.index;
        var status = res.target.dataset.status;
        var id = res.target.dataset.id;
        var tmpData = that.data.newsList.list;
        if (tmpData[index].type == 1) {
          tmpPath = '/longbing_card/pages/company/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&status=toPlayVideo&name=' + tmpData[index].title + '&src=' + tmpData[index].content
        } else {
          var tmpPath = '/longbing_card/pages/news/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&id=' + id;
          if (tmpData[index].user_info) {
            tmpPath = tmpPath + '&isStaff=true'
          }
        }
        return {
          title: tmpData[index].title,
          path: tmpPath,
          imageUrl: tmpData[index].cover[0],
          // success: function (res) {
          //   console.log("转发成功", res)
          //   if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
          //     that.getForwardRecord(3, id);
          //   }
          // },
          // fail: function (res) {
          //   console.log('转发失败');
          // }
        };

        if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
          that.getForwardRecord(3, id);
        }
      }
      else {
        return {
          title: '',
          path: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toNews',
          imageUrl: ''
        };
      }
    } else if (that.data.currentTabBar == 'toCompany') {
      if (res.from === 'button') {
        // console.log("来自页面内转发按钮");
      }
      else {
        // console.log("来自右上角转发菜单")
      }
      return {
        title: '',
        path: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toCompany',
        imageUrl: '',
        // success: function (res) {
        //   console.log('转发成功');
        //   if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        //     that.getForwardRecord(4, 0);
        //   }
        // },
        // fail: function (res) {
        //   console.log('转发失败');
        // }
      };
      if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        that.getForwardRecord(4, 0);
      }
    }
  },
  // getIndexData2: function () {
  //   let that = this;
  //   let paramCardList = that.data;
  //   let paramObj2 = {
  //     to_uid: 1,
  //     from_id: 1,
  //   }
  //   fly.all([userModel.getUser1(paramCardList), userModel.getUser2(paramObj2)])
  //     .then(fly.spread(function (cards, cardV3) {
  //       //两个请求都完成
  //       console.log(cards.data, cardV3.data, "111111111111")
  //     }))
  //     .catch(function (error) {
  //       console.log(error)
  //       util.networkError({ msg: error });
  //     })
  // },
  ddd: function () {
    var that = this;
    if (app.globalData.to_uid == 0) {
      wx.showModal({
        title: '',
        content: '不能与默认客服进行对话哦！',
        confirmText: '知道啦',
        showCancel: false,
        success: res => {
          if (res.confirm) {
          } else {
          }
        }
      });
    } else if (app.globalData.to_uid == wx.getStorageSync("userid")) {
      wx.showModal({
        title: '',
        content: '不能和自己进行对话哦！',
        confirmText: '知道啦',
        showCancel: false,
        success: res => {
          if (res.confirm) {
          } else {
          }
        }
      });
    } else {
      wx.navigateTo({
        url: '/longbing_card/chat/userChat/userChat?chat_to_uid=' + app.globalData.to_uid + '&contactUserName=' + app.globalData.nickName + '&staffPhone=' + that.data.cardIndexData.info.phone + '&staffWechat=' + that.data.cardIndexData.info.wechat
      })
    }
  },
  getShowClientUnread: function () {
    var that = this;
    console.log(that.data.globalData.clientUnread, "that.data.globalData.clientUnread 1")
    if (that.data.globalData.clientUnread) {
      console.log(that.data.globalData.clientUnread, "that.data.globalData.clientUnread 2")
      app.globalData.clientUnreadImg = true;
      that.setData({
        'globalData.clientUnreadImg': true,
        clientUnread: app.globalData.clientUnread
      })
      setTimeout(function () {
        app.globalData.clientUnread = 0;
        app.globalData.clientUnreadImg = false;
        that.setData({
          'globalData.clientUnreadImg': false,
          // clientUnread: 0
        })
      }, 5000)
    }
  },
  getCustomQrRecordInsert: function (customID) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/customQrRecordInsert',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        to_uid: that.data.paramData.to_uid,
        qr_id: customID
      },
      success: function (res) {
        // console.log("entry/wxapp/customQrRecordInsert ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 名片列表 
  toSearchCardBlur: function(){
    let that = this;
    that.setData({
      // cardSearchKey: '',
      toSearchCard: false
    })
  },
  toSearchCard: function(e){
    let that = this;
    let cardSearchKey = e.detail.value;
    that.setData({
      cardSearchKey
    })
  },
  toSearchCardConfirm: function(){
    let that = this;
    console.log("toSearchCardConfirm",that.data.cardSearchKey)
    that.setData({
      refreshCardList: true
    },function(){
      that.getCollectionList();
    })
  },
  getCollectionList: function () {
    var that = this;
    // let paramCardList = that.data;
    // fly.all([getApp().getConfigInfo(),userModel.getCollectionList(paramCardList)]).then((d)=>{
    //   console.log(d,getApp())
    //   util.hideAll();
    //   let configInfo=d[0];
    //   let collectionList=d[1].data;
    //   if (configInfo){
    //     that.setData({
    //       'globalData.configInfo': configInfo,
    //       collectionList
    //     })
    //   }else{
    //     that.setData({
    //       collectionList
    //     })
    //   }
    // })
    let { refreshCardList, paramCardList, collectionList, cardSearchKey} = that.data;
    console.log("toSearchCardConfirm getCollectionList",cardSearchKey)
    if (!refreshCardList) {
      util.showLoading();
    }
    if(cardSearchKey){
      paramCardList.keyword = cardSearchKey
    }
    
    userModel.getCollectionList(paramCardList).then((d) => {
      let oldlist = collectionList;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refreshCardList) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      let collectStatus = '-1';
      if (newlist.list.length == 0) {
        collectStatus = false
      }
      that.setData({
        collectionList: newlist,
        collectStatus: collectStatus,
        loadingCardList: false,
        refreshCardList: false,
      })
    })
  }, 
  toGetShareimg: function () {
    var that = this; 
    baseModel.getShareimg().then((d) => {
      util.hideAll();
      let getShareImg = d.data.path; 
      that.setData({
        getShareImg
      })
    })
  }, 
  // 名片
  getCardIndexData: function () {
    var that = this;
    let { refreshCardIndex } = that.data;
    let { to_uid, from_id } = that.data.paramData;
    if (!refreshCardIndex) {
      util.showLoading();
    }
    let paramObj = {
      to_uid: to_uid,
      from_id: from_id
    }
    if(wx.getStorageSync("loginParamObj")){ 
      let {is_qr,is_group,type,target_id,from_id} = wx.getStorageSync("loginParamObj"); 
      paramObj.is_qr = is_qr;
      paramObj.is_group = is_group;
      paramObj.type = type;
      paramObj.target_id = target_id;
      paramObj.from_id = from_id;
    }
    if(app.globalData.openGId_2){ 
      paramObj.openGId = app.globalData.openGId_2;
    }
    userModel.getCardIndexData(paramObj).then((d) => {
      util.hideAll();
      console.log("getCardIndexData ==>",d.data)
      let cardIndexData = d.data;
      let { to_uid, from_id, is_boss, is_staff ,peoplesInfo, coupon_last_record} = cardIndexData;

      for(let i in peoplesInfo){
        if(wx.getStorageSync("userid") == peoplesInfo[i].id){
          peoplesInfo.splice(i,1)
        }
      }

      if(coupon_last_record.length > 0){
        for(let i in coupon_last_record){ 
          // console.log(cardIndexData.user_id,cardIndexData.to_uid,coupon_last_record[i].user_id)
          if(cardIndexData.user_id == cardIndexData.to_uid || cardIndexData.user_id == coupon_last_record[i].user_id){ 
            that.setData({
              'voucherStatus.status' : 0,
            })
          }
        }
      } else { 
        if(cardIndexData.user_id == cardIndexData.to_uid){ 
          that.setData({
            'voucherStatus.status' : 0,
          })
        }
      }
      if(coupon_last_record.length > 0 && that.data.voucherStatus.status){
        timerCoupon = setInterval(function(){
          let tmp_coupon_i = that.data.tmp_coupon_i;
          that.setData({
            coupon_nickName: coupon_last_record[tmp_coupon_i].user_info.nickName, 
            coupon_reduce: coupon_last_record[tmp_coupon_i].reduce, 
            coupon_record: true,
          },function(){
            setTimeout(() => { 
              tmp_coupon_i++;
              if(tmp_coupon_i == coupon_last_record.length){ 
                tmp_coupon_i = 0; 
              } 
              that.setData({
                coupon_record: false,
                tmp_coupon_i
              })
            }, 5000);
          })
        },10000)
      }

      let tmp_logo = cardIndexData.info.myCompany.logo;
      let tmp_avatar = cardIndexData.info.avatar;
      let tmp_avatar_2 = cardIndexData.info.avatar_2;
      let tmp_name = cardIndexData.info.name;
      let tmp_job_name = cardIndexData.info.job_name;
      let tmp_phone = cardIndexData.info.phone;
      var tmpCardData = {
        logo: tmp_logo,
        company_name: cardIndexData.info.myCompany.name,
        company_short_name: cardIndexData.info.myCompany.short_name,
        company_addr: cardIndexData.info.myCompany.addr,
        avatar: tmp_avatar_2,
        default: app.globalData.defaultUserImg,
        defaultLogo: app.globalData.logoImg,
        name: tmp_name,
        phone: tmp_phone,
        email: cardIndexData.info.email,
        job_name: tmp_job_name,
      };
      
      var paramShareObj = {
        avatar: tmp_avatar,
        name: tmp_name,
        job_name: tmp_job_name,
        phone: tmp_phone,
        wechat: cardIndexData.info.wechat,
        companyName: cardIndexData.info.myCompany.name,
        logo: tmp_logo,
        addrMore: cardIndexData.info.myCompany.addrMore,
        qrImg: cardIndexData.qr,
      }

      app.globalData.to_uid = to_uid;
      app.globalData.from_id = from_id;
      app.globalData.nickName = cardIndexData.info.name;
      app.globalData.avatarUrl = cardIndexData.info.avatar;
      app.globalData.job_name = cardIndexData.info.job_name;

      let tmpIsStaff = false;
      let tmpIsBoss = false;

      cardIndexData.thumbs_up2 = cardIndexData.thumbs_up + cardIndexData.info.t_number*1;
      cardIndexData.peoples2 = cardIndexData.peoples + cardIndexData.info.view_number*1;

      if (to_uid == wx.getStorageSync("userid")) {
        if (is_boss == 1) {
          tmpIsBoss = true;
        }
        if (is_staff == 1) {
          tmpIsStaff = true;
        }
      }
      app.globalData.isStaff = tmpIsStaff;
      app.globalData.isBoss = tmpIsBoss;

      that.setData({
        cardIndexData: cardIndexData, 
        tmpShareData: paramShareObj,
        tmpCardData: tmpCardData,
        refreshCardIndex: false,
        showTabBar: true,
        'paramData.to_uid': to_uid,
        'paramData.from_id': from_id,
        'globalData.isStaff': tmpIsStaff,
        'globalData.isBoss': tmpIsBoss,
      }) 
    })
  },
  getEditPraiseStatus: function () {
    var that = this;
    let paramObj = {
      to_uid: app.globalData.to_uid,
      type: that.data.cardZanType
    }
    userModel.getEditPraiseStatus(paramObj).then((d) => {
      util.hideAll();
      console.log(d.data)
      var tmpData = that.data.cardIndexData;
      var zanToast = '';
      if (that.data.cardZanType == 3) {
        if (tmpData.isThumbs == 1) {
          tmpData.thumbs_up2 = tmpData.thumbs_up2 * 1 - 1;
          tmpData.isThumbs = 0;
          zanToast = '取消靠谱！';
        } else if (tmpData.isThumbs == 0) {
          tmpData.thumbs_up2 = tmpData.thumbs_up2 * 1 + 1;
          tmpData.isThumbs = 1;
          zanToast = '认为靠谱！';
        }
      } else if (that.data.cardZanType == 1) {
        var zanToast = '';
        if (tmpData.voiceThumbs == 1) {
          tmpData.voiceThumbs = 0;
          zanToast = '取消点赞！';
        } else if (tmpData.voiceThumbs == 0) {
          tmpData.voiceThumbs = 1;
          zanToast = '点赞成功！';
        }
      }
      wx.showToast({
        icon: 'none',
        title: zanToast,
        duration: 2000
      })
      that.setData({
        cardIndexData: tmpData
      })
    })
  },
  toGetShareInfo: function () {
    var that = this;
    // type 1=>浏览名片 2=>浏览自定义码 3=>浏览商品 4=>浏览动态
    // 当type 为2,3,4时, 需要传浏览对象的id 
    wx.login({
      success: function (res) {
        // console.log('wx.login ==>>', res);
        let paramObj = {
          encryptedData: app.globalData.encryptedData,
          iv: app.globalData.iv,
          type: 1,
          code: res.code,
          to_uid: that.data.paramData.to_uid
        }
        userModel.getShareInfo(paramObj).then((d) => {
          util.hideAll();
          clearInterval(timer);
        })
      }
    })
  },
  // 商城
  getShopTypes: function () {
    var that = this;
    util.showLoading();
    let paramObj = {
      type: that.data.currentIndex,
      to_uid: that.data.paramData.to_uid
    }
    userModel.getShopTypes(paramObj).then((d) => {
      util.hideAll();
      let { shop_all, shop_type, shop_company } = d.data;
      that.setData({
        shop_all,
        shop_type,
        shop_company,
        showTabBar: true,
      })
    })
  },
  getShopList: function () {
    var that = this;
    let { refreshShop, paramShop, shop_all } = that.data;
    if (!refreshShop) {
      util.showLoading();
    }
    userModel.getShopList(paramShop).then((d) => {
      let oldlist = shop_all;
      let newlist = d.data;
      //如果刷新,则不加载老数据
      if (!refreshShop) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      that.setData({
        shop_all: newlist,
        loadingShop: false,
        refreshShop: false,
        showTabBar: true,
      })
    })
  },
  // 动态
  getNewsList: function () {
    var that = this;
    let { refreshNews, paramNews, newsList } = that.data;
    if (!refreshNews) {
      util.showLoading();
    }
    userModel.getNewsList(paramNews).then((d) => {
      util.hideAll();
      console.log(d.data)
      let oldlist = newsList;
      let newlist = d.data;
      let tmpData = newlist.list;
      let tmpNewsIndex = that.data.newsIndex;
      for (let i in tmpData) {
        tmpNewsIndex.push(0)
        if(tmpData[i].type == 2 && tmpData[i].url_type == 3){
          tmpData[i].content = 'tel:' + tmpData[i].content;
        }
        for (let j in tmpData[i].thumbs) {
          if (tmpData[i].thumbs[j].user == false || !tmpData[i].thumbs[j].user.nickName) {
            tmpData[i].thumbs.splice(j, 1)
          }
        }
        for (let k in tmpData[i].comments) {
          if (tmpData[i].comments[k].user == false || !tmpData[i].comments[k].user.nickName) {
            tmpData[i].comments.splice(k, 1)
          }
        }
        for (let l in tmpData[i].cover) {
          if (tmpData[i].type != 1 && !tmpData[i].cover[l]) {
            tmpData[i].cover.splice(l, 1)
          }
        }
      }
      //如果刷新,则不加载老数据
      if (!refreshNews) {
        newlist.list = [...oldlist.list, ...newlist.list];
      }
      that.setData({
        newsList: newlist,
        newsIndex: tmpNewsIndex,
        loadingNews: false,
        refreshNews: false,
      })

    })
  },
  addEva: function (e) {
    var that = this;
    var content = e.detail.value;
    that.setData({
      evaContent: content
    })
  },
  getThumbs: function (index) {
    var that = this;
    let paramObj = {
      id: that.data.ThumbsId,
      to_uid: app.globalData.to_uid
    }
    userModel.getThumbs(paramObj).then((d) => {
      util.hideAll();
      let tmpData = that.data.newsList;
      if (tmpData.list[index].is_thumbs == 1) {
        tmpData.list[index].is_thumbs = 0
      } else {
        tmpData.list[index].is_thumbs = 1
      }
      that.setData({
        newsList: tmpData,
        evaStatus: false,
        showTabBar: true, 
      }, function () {
        that.getNewThumbsComment(that.data.ThumbsId);
      })
    })
  },
  getComment: function () {
    var that = this;
    let paramObj = {
      id: that.data.evaId,
      to_uid: app.globalData.to_uid,
      content: that.data.evaContent
    }
    userModel.getComment(paramObj).then((d) => {
      util.hideAll();
      that.setData({
        evaStatus: false,
        showTabBar: true,
      }, function () {
        that.getNewThumbsComment(that.data.evaId);
      })
    })
  },
  getNewThumbsComment: function (id) {
    var that = this;
    let paramObj = {
      id: id,
      to_uid: app.globalData.to_uid
    }
    userModel.getNewThumbsComment(paramObj).then((d) => {
      util.hideAll();
      var tmpData = that.data.newsList;
      var index = that.data.currentNewsIndex;
      tmpData.list[index].thumbs = d.data.thumbs;
      tmpData.list[index].comments = d.data.comments;
      for (let i in tmpData.list) {
        for (let j in tmpData.list[i].thumbs) {
          if (tmpData.list[i].thumbs[j].user == false || !tmpData.list[i].thumbs[j].user.nickName) {
            tmpData.list[i].thumbs.splice(j, 1)
          }
        }
        for (let k in tmpData.list[i].comments) {
          if (tmpData.list[i].comments[k].user == false || !tmpData.list[i].comments[k].user.nickName) {
            tmpData.list[i].comments.splice(k, 1)
          }
        }
      }
      that.setData({
        newsList: tmpData,
        evaStatus: false,
        showTabBar: true,
        evaContent: '',
        ThumbsId: '',
        evaId: '',
        index: ''
      })
    })
  },
  // 官网
  getModular: function () {
    var that = this;
    let refreshCompany = that.data;
    if (!refreshCompany) {
      util.showLoading();
    }
    let paramObj = {
      to_uid: that.data.paramData.to_uid
    }
    userModel.getModular(paramObj).then((d) => {
      util.hideAll();
      let { company_company, company_modular } = d.data;
      refreshCompany = false;
      // 1=>文章列表, 2=>图文详情, 3=>招聘信息, 4=>联系我们, 5=>员工展示, 6=>打电话
      for (let i in company_modular) {
        if (company_modular[i].type == 4) {
          company_modular[i].info.markers = [{
            iconPath: "http://retail.xiaochengxucms.com/images/12/2018/11/A33zQycihMM33y337LH23myTqTl3tl.png",
            id: 1,
            callout: {
              content: company_modular[i].info.address,
              fontSize: 14,
              bgColor: '#ffffff',
              padding: 4,
              display: 'ALWAYS',
              textAlign: 'center',
              borderRadius: 2,
            },
            latitude: company_modular[i].info.latitude,
            longitude: company_modular[i].info.longitude,
            width: 28,
            height: 28
          }]
        }
      }
      that.setData({
        company_company,
        company_modular,
        refreshCompany,
        showTabBar: true,
      })
    })
  },
  swiperChange: function (e) {
    let that = this;
    let cur = e.detail.current;
    that.setData({
      swiperIndexCur: cur
    });
  },
  // 1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网
  // target_id 转发内容的id 当type=2,3时有效
  getForwardRecord: function (type, targetid) {
    var that = this;
    let paramObj = {
      type: type,
      to_uid: app.globalData.to_uid
    }
    if (type == 2 || type == 3) {
      paramObj.target_id = targetid
    }
    userModel.getForwardRecord(paramObj).then((d) => {
      util.hideAll();
    })
  },
  // 记录复制文本 拨打电话 查看地址 分_享等情况
  getCopyRecord: function (type) {
    var that = this;
    let paramObj = {
      type: type,
      to_uid: app.globalData.to_uid
    }
    userModel.getCopyRecord(paramObj).then((d) => {
      util.hideAll();
    })
  },
  getShareRecord: function () {
    var that = this;
    let paramObj = {
      to_uid: app.globalData.to_uid
    }
    userModel.getShareRecord(paramObj).then((d) => {
      util.hideAll();
    })
  },
  getPhoneNumber: function (e) {
    var that = this;
    if (e.detail.errMsg == 'getPhoneNumber:ok') {
      console.log("同意授权获取电话号码")
      var encryptedData = e.detail.encryptedData;
      var iv = e.detail.iv;
      console.log(encryptedData, iv)
      that.setPhoneInfo(encryptedData, iv);
    } else if (e.detail.errMsg == 'getPhoneNumber:fail user deny') {
      console.log("拒绝授权获取电话号码")
    }
    that.ddd();
  },
  setPhoneInfo: function (encryptedData, iv) {
    var that = this;
    console.log(app.globalData.to_uid)
    wx.login({
      success: function (res) {
        console.log('wx.login ==>>', res);
        let paramObj = {
          encryptedData: encryptedData,
          iv: iv,
          code: res.code,
          to_uid: app.globalData.to_uid
        }
        userModel.getPhone(paramObj).then((d) => {
          util.hideAll();
          app.globalData.hasClientPhone = true;
          that.setData({
            'globalData.hasClientPhone': true
          },function(){
            if(d.data.phone){
              let sync_userid = wx.getStorageSync("userid");
              let sync_user = wx.getStorageSync("user");
              sync_user.phone = d.data.phone;
              wx.setStorageSync("userid",sync_userid);
              wx.setStorageSync("user",sync_user);
            }
          })
        })
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  //领取福包
  getVoucher:function(e){
    let that = this; 
    voucher.getVoucher(that, userModel, util, e);
  },
  getDismantling:function(e){
    let that = this; 
    voucher.toGetCoupon(that, userModel, util);
  },
  toBigVoucher:function(){
    let that = this;
    voucher.toBigVoucher(that);
  },
  toCloseVoucher:function(){
    let that = this;
    voucher.toCloseVoucher(that);
  },
  // 检查授权
  checkAuthStatus: function () {
    var that = this;
    auth.checkAuth(that, baseModel, util);
  },
  getUserInfo: function (e) {
    var that = this; 
    auth.getUserInfo(e);
  },
  addEvaBtn: function (e) {
    var that = this;
    console.log("点击键盘确定键，发表评论", that.data.evaContent)
    if (!that.data.evaContent) {
      wx.showToast({
        icon: 'none',
        title: '请输入评论内容！',
        duration: 2000
      })
      return false;
    }
    that.getComment();
  },
  // 点击事件
  toJump: function (e) {
    var that = this;

    var status = e.currentTarget.dataset.status;
    var index = e.currentTarget.dataset.index;
    var id = e.currentTarget.dataset.id;
    var content = e.currentTarget.dataset.content;
    var type = e.currentTarget.dataset.type;
    // console.log("名片列表===========================================")
    if (status == 'toSearchCardFocus') {
      that.setData({
        toSearchCard: true
      })
    }
    if (status == 'toCopyright') {
      if (that.data.globalData.configInfo.config.logo_phone) {
        app.util.goUrl(e)
      }
    }
    // console.log("名片列表===========================================")
    if (status == 'toJumpUrl' || status == 'toImgJump' || status == 'toStaff' || status == 'toShowMore' || status == 'toMoreDetail' || status == 'toCarIndex' || status == 'toMine') {
      app.util.goUrl(e)
    }

    if (status == 'toSearchCard') {
      // that.setData({
      //   toSearchCard: true
      // })
    } else if (status == 'toAddCard') {
      console.log("创建智能名片")
      that.setData({
        onshowStatus: 'createCard'
      },function(){
        wx.navigateTo({
          url: '/longbing_card/staff/mine/editInfo/editInfo?status=createCard'
        })
      })
    } else if (status == 'toCardIndex') {
      // console.log("名片详情")
      app.util.showLoading(1);

      var sync_userid = wx.getStorageSync("userid");
      var sync_user = wx.getStorageSync("user");
      wx.clearStorageSync();
      wx.setStorageSync("userid", sync_userid);
      wx.setStorageSync("user", sync_user);


      let tmpCollList = that.data.collectionList.list;
      let tmp_to_uid = tmpCollList[index].userInfo.fans_id;
      let tmp_nickName = tmpCollList[index].userInfo.name;
      app.globalData.to_uid = tmp_to_uid;
      app.globalData.nickName = tmp_nickName;

      wx.showShareMenu({
        withShareTicket: true,
        success: function (res) {
          // 分_享成功
          console.log('shareMenu share success')
          console.log('分_享' + res)
        },
        fail: function (res) {
          // 分_享失败
          console.log(res)
        }
      })

      that.setData({
        'paramData.to_uid': tmp_to_uid,
        currentTabBarInd: 0,
        currentTabBar: 'toCard',
        showTabBar: true,
        globalData: app.globalData,
        refreshCardIndex: false,
        cardIndexData:{}
      })
      wx.setNavigationBarTitle({
        title: app.globalData.configInfo.config.mini_app_name,
      })
      that.getCardIndexData();
      if (that.data.currentTabBar != 'cardList') {
        if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
          if(app.globalData.clientUnread == 0 && that.data.clientUnread == 0 || app.globalData.clientUnread == 0 && that.data.clientUnread == 1){
            app.globalData.clientUnread = 1;
          }
          that.getShowClientUnread();
        }
      }


      // if (that.data.cardIndexData == '') {
      // that.getCardIndexData();
      // }

      wx.pageScrollTo({
        duration: 0,
        scrollTop: 0,
      });
      wx.hideLoading();
    }
    // console.log("名片===========================================")
    if (status == 'toCardZan') {
      // console.log("1语音 || 3靠谱")
      that.setData({
        toLeavingMessage: false,
        cardZanType: type
      })
      that.getEditPraiseStatus();

    } else if (status == 'toVoice') {
      innerAudioContext.autoplay = true;
      innerAudioContext.src = that.data.cardIndexData.info.voice; 
      if (type == 1) {
        innerAudioContext.play(() => {
          console.log('开始播放')
        })
        that.setData({
          playPushStatus: 2
        });
        if (app.globalData.to_uid != wx.getStorageSync("userid")) {
          that.getCopyRecord(9);
        }
      }
      if (type == 2) {
        console.log("语音播放 pauseBackgroundAudio", type)
        that.setData({
          playPushStatus: 1
        });
        innerAudioContext.pause(() => {
          console.log('暂停播放')
        })
      }
      innerAudioContext.onEnded(() => {
        console.log('音频自然播放结束事件') 
        that.setData({
          playPushStatus: 1
        });
      })
    } else if (status == 'toCardList') {
      // console.log("名片列表")  
      app.util.showLoading(1);
      clearInterval(timerCoupon);
      that.setData({
        showTabBar: false,
        currentTabBar: 'cardList',
        show: false,
        collectionList: {
          page: 1,
          total_page: '',
          list: []
        },
        voucherStatus:{
          show: true,
          status: 'unreceive',
        },  
      })
      wx.setNavigationBarTitle({
        title: '名片列表'
      })
      wx.hideShareMenu();
      // if (that.data.collectionList.length == 0) {

      that.getCollectionList();
      // }
      wx.pageScrollTo({
        duration: 0,
        scrollTop: 0,
      });
      wx.hideLoading();

    } else if (status == 'toBoss') {
      console.log("BOSS端入口")
      app.util.goUrl(e);
    } else if (status == 'toConsult') {
      console.log("聊天")
      that.setData({
        toLeavingMessage: true
      })
      if (app.globalData.to_uid != wx.getStorageSync("userid")) {
        that.getCopyRecord(8);
      }
      if (that.data.globalData.hasClientPhone == true) {
        console.log("用户已授权手机号码")
      }
      that.ddd();
    } else if (status == 'toShareCard') {
      console.log("关闭弹出层")
      // if (type == 3) {
      that.setData({
        showShareStatus: 0
      })
      // }
    }


    wx.onBackgroundAudioStop(function () {
      that.setData({
        playPushStatus: 1
      });
    })

    // console.log("商城 ===========================================")
    if (status == 'toShopDetail') {
      // console.log("产品详情")
      let tmpData = '';
      if (that.data.currentTabBar == 'toCard') {
        tmpData = that.data.cardIndexData.goods;
      } else if (that.data.currentTabBar == 'toShop') {
        tmpData = that.data.shop_all.list;
      }
      wx.navigateTo({
        // url: '/longbing_card/pages/shop/detail/detail?id=' + tmpData[index].id
        url: '/longbing_card/pages/shop/detail/detail?id=' + tmpData[index].id + '&to_uid=' + app.globalData.to_uid + '&from_id=' + app.globalData.from_id
      })
    } else if (status == 'toTabClickMore' || status == 'toTabClick') {
      console.log("全部 || 类别选择")
      var categoryid = e.currentTarget.dataset.categoryid;
      var tmpIndex = index;
      var tmpCategoryid = categoryid;
      if (status == 'toTabClickMore') {
        tmpIndex = '100000101';
        tmpCategoryid = 'All';
      }
      wx.pageScrollTo({
        duration: 0,
        scrollTop: 0,
      });
      that.setData({
        toShopScrollTop:false,
        activeIndex: tmpIndex,
        categoryid: categoryid,
        scrollNav: 'scrollNav' + tmpCategoryid,
        'paramShop.list': [],
        'paramShop.page': 1,
        'paramShop.type_id': categoryid,
        refreshShop: true
      })
      that.getShopList();
    }

    // console.log("动态 ===========================================")
    if (status == 'toNewsShow') {
      // console.log("显示评论面板")
      let tmpA = that.data.newsIndex;
      if (type == 0) {
        tmpA[index] = 1;
      } else if (type == 1) {
        tmpA[index] = 0;
      }
      that.setData({
        newsIndex: tmpA,
        currentNewsIndex: index
      })

    } else if (status == 'toNewsZan') {
      // console.log("点赞")
      console.log(index, "toNewsZan")

      let tmpA = that.data.newsIndex;
      for (let i in tmpA) {
        if (tmpA[i] = 1) {
          tmpA[i] = 0
        }
      }
      that.setData({
        newsIndex: tmpA,
        toLeavingMessage: false,
        ThumbsId: id
      })
      that.getThumbs(index);
    } else if (status == 'toEva') {
      console.log("评论", that.data.evaStatus)

      let tmpA = that.data.newsIndex;
      for (let i in tmpA) {
        if (tmpA[i] = 1) {
          tmpA[i] = 0
        }
      }
      that.setData({
        newsIndex: tmpA,
        toLeavingMessage: false,
        evaId: id,
        evaStatus: true,
        showTabBar: false,
      })
      console.log(that.data.evaStatus);
    } else if (status == 'toAddEvaBtn') {
      console.log("点击发表按钮，发表评论", that.data.evaContent)
      if (!that.data.evaContent) {
        wx.showToast({
          icon: 'none',
          title: '请输入评论内容！',
          duration: 2000
        })
        return false;
      }
      that.getComment();
    } else if (status == 'toNewsDetail') {
      // console.log("跳转至详情", id)

      var tmpData = that.data.newsList.list;
      if (tmpData[index].type == 1) {
        var tmpVideoUrl = "/longbing_card/pages/company/detail/detail?status=toPlayVideo&name="
        wx.navigateTo({
          url: tmpVideoUrl + tmpData[index].title + '&src=' + tmpData[index].content
        })
      } else if (tmpData[index].type == 2) {
        app.util.goUrl(e);
      } else if (tmpData[index].type == 0) {
        var tmpUrl = '/longbing_card/pages/news/detail/detail?id=' + id
        if (tmpData[index].user_info.id) {
          console.log("员工发布动态")
          tmpUrl = tmpUrl + '&isStaff=true'
        }
        if (!tmpData[index].user_info.id) {
          console.log("公司发布动态")
          tmpUrl = tmpUrl + '&companyName=' + that.data.newsList.timeline_company.name
        }
        wx.navigateTo({
          url: tmpUrl
        })
      }
    }
    // console.log("官网 ===========================================")
    if (status == "toDetail") {
      // console.log("列表跳转至详情")
      let tmpData = that.data.company_modular;
      // console.log("index", index, tmpData[index].name)
      if (tmpData[index].type == 5) {
        return false;
      } else {
        wx.navigateTo({
          url: '/longbing_card/pages/company/detail/detail?table_name=' + tmpData[index].table_name + '&type=' + tmpData[index].type + '&id=' + id + '&name=' + tmpData[index].name
        })
      }
    } else if (status == 'toCall') {
      if (!content || content == '暂未填写') {
        return false;
      }
      wx.makePhoneCall({
        phoneNumber: content,
        success: function (res) {
          // console.log('拨打电话成功 ==>>', res.data);
          if (app.globalData.to_uid != wx.getStorageSync("userid")) {
            that.getCopyRecord(type);
          }
        }
      });
    } else if (status == 'toPlayVideo') {
      console.log("播放视频")
      wx.navigateTo({
        url: content
      })
    } else if (status == 'toCompanyMap') {
      console.log("toCompanyMap")
      var latitude = e.currentTarget.dataset.latitude;
      var longitude = e.currentTarget.dataset.longitude;
      wx.openLocation({
        latitude: parseFloat(latitude),
        longitude: parseFloat(longitude),
        name: content,
        scale: 28,
        success: function (res) {
          // console.log("查看定位成功 ==> ", res) 
        }
      })
    }



  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    var index = e.detail.target.dataset.index;
    var type = e.detail.target.dataset.type;
    var text = e.detail.target.dataset.text;
    var content = e.detail.target.dataset.content;
    that.setData({
      toCardStatus: '',
    })

    // console.log("********/////////////////////********************formId",formId)
    if (status == 'toTabBar') {
      that.setData({
        currentTabBarInd: index,
        toCardStatus: 'tabBar',
      },function(){
        wx.getSetting({
          success: function (res) {
            if (res.authSetting['scope.userInfo']) {
              console.log("有res.authSetting['scope.userInfo']")
              that.setData({
                authStatus: true
              })
            } else {
              console.log("没有res.authSetting['scope.userInfo']")
              that.setData({
                authStatus: false
              })
            }
          },
          fail: function (res) {
            console.log("wx.getSetting ==>> fail")
            that.setData({
              authStatus: false
            })
          }
        });
      })

      if (type == 'toCard') {
        wx.setNavigationBarTitle({
          title: app.globalData.configInfo.config.mini_app_name
        })
        that.setData({
          currentTabBar: type,
        })
        wx.showShareMenu({
          withShareTicket: true,
          success: function (res) {
            // 分_享成功
            console.log('shareMenu share success')
            console.log('分_享' + res)
          },
          fail: function (res) {
            // 分_享失败
            console.log(res)
          }
        })
      } else {
        var tmpGD = that.data.globalData.tabBarList;
        if (tmpGD[index].jump == 'toPageUrl') {
          wx.setNavigationBarTitle({
            title: text
          })
          that.setData({
            currentTabBar: type,
          })
          wx.showShareMenu();
        } else {
          app.util.goUrl(e, true)
        }
      }


      wx.pageScrollTo({
        duration: 0,
        scrollTop: 0,
      });

      if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        if(app.globalData.clientUnread == 0 && that.data.clientUnread == 0 || app.globalData.clientUnread == 0 && that.data.clientUnread == 1){
          app.globalData.clientUnread = 1;
        }
        that.getShowClientUnread();
      }


    } else if (status == 'toCardMore') {
      let tmp_content = 1;
      if (content == 1) {
        // console.log("展开全部名片信息")
        tmp_content = 2;
      }
      that.setData({
        moreStatus: tmp_content
      })
    } else if (status == 'toCall') {
      // console.log("拨打电话")
      if (!content || content == '暂未填写') {
        return false;
      }
      wx.makePhoneCall({
        phoneNumber: content,
        success: function (res) {
          // console.log('拨打电话成功 ==>>', res.data);
          if (app.globalData.to_uid != wx.getStorageSync("userid")) {
            that.getCopyRecord(type);
          }
        }
      });
    } else if (status == 'toCopy') {
      // console.log("复制文本")
      if (!content || content == '暂未填写') {
        return false;
      }
      wx.setClipboardData({
        data: content,
        success: function (res) {
          wx.getClipboardData({
            success: function (res) {
              // console.log('复制文本成功 ==>>', res.data);
              if (app.globalData.to_uid != wx.getStorageSync("userid")) {
                that.getCopyRecord(type);
              }
            }
          });
        }
      });
    } else if (status == 'toMap') {
      // console.log("地图定位") 
      wx.openLocation({
        latitude: parseFloat(that.data.cardIndexData.info.myCompany.latitude),
        longitude: parseFloat(that.data.cardIndexData.info.myCompany.longitude),
        name: content,
        scale: 28,
        success: function (res) {
          // console.log("查看定位成功 ==> ", res)
          if (app.globalData.to_uid != wx.getStorageSync("userid")) {
            that.getCopyRecord(type);
          }
        }
      })
    } else if (status == 'toShowShare') {
      // console.log("显示 分_享名片")
      that.setData({
        showShareStatus: 1
      })
    } else if (status == 'toAddPhone') {
      // console.log("同步到通讯录 || 手机 座机 微信 邮箱 公司 地址")
      wx.addPhoneContact({
        photoFilePath: that.data.cardIndexData.info.avatar,
        firstName: that.data.cardIndexData.info.name,
        mobilePhoneNumber: that.data.cardIndexData.info.phone,
        hostNumber: that.data.cardIndexData.info.telephone,
        weChatNumber: that.data.cardIndexData.info.wechat,
        email: that.data.cardIndexData.info.email,
        organization: that.data.cardIndexData.info.myCompany.name,
        workAddressCity: that.data.cardIndexData.info.myCompany.addr,
        success: function (res) {
          // console.log("同步到通讯录成功 ==> ", res)
          if (app.globalData.to_uid != wx.getStorageSync("userid")) {
            that.getCopyRecord(type);
          }
        }
      })
    } else if (status == 'toShareCard') {
      // console.log("1微信好友 || 2名片码 || 3取消")
      if (type == 2) { 
          wx.navigateTo({
            url: '/longbing_card/pages/card/share/share'
          }) 
      }
      that.setData({
        showShareStatus: 0
      })
    } else if (status == "toNav") {
      // 1=>文章列表, 2=>图文详情, 3=>招聘信息, 4=>联系我们, 5=>员工展示, 6=>打电话 
      app.util.goUrl(e, true)
    }

    
    getApp().getConfigInfo().then(() => {
      that.setData({ 
        globalData: app.globalData
      }, function () {
        if (that.data.currentTabBar == 'toCard') {
          // console.log("名片 =========================onShow==") 
          that.setData({
            refreshCardIndex: false
          }, function () {
            if (that.data.toCardStatus == 'tabBar') {
              if (!that.data.cardIndexData.to_uid) {
                that.getCardIndexData();
              }
            }
          })
    
        } else if (that.data.currentTabBar == 'toShop') {
          // console.log("商城 =========================onShow==")  
          that.setData({
            refreshShop: false,
          }, function () {
            if (that.data.shop_all.list.length == 0) {
              util.showLoading();
              that.getShopTypes();
            }
          })
        } else if (that.data.currentTabBar == 'toNews') {
          // console.log("动态 =========================onShow==") 
          that.setData({
            'paramNews.to_uid': that.data.paramData.to_uid,
            refreshNews: false
          }, function () {
            if (that.data.newsList.list.length == 0) {
              that.getNewsList();
            }
          })
        } else if (that.data.currentTabBar == 'toCompany') {
          // console.log("公司官网 =========================onShow==")
          that.setData({
            refreshCompany: false
          }, function () {
            if (!that.data.company_modular || that.data.company_modular.length < 1) {
              that.getModular();
            }
          })
        }
        that.toSaveFormIds(formId);
      })
  })

  
  },
  toSaveFormIds: function (formId) {
    var that = this;
    let paramObj = {
      formId: formId
    }
    baseModel.getFormId(paramObj).then((d) => {
      // util.hideAll();
    })
  }
})