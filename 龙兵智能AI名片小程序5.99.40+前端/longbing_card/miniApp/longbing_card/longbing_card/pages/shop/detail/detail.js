var app = getApp()
var auth = require('../../../templates/auth/auth.js'); 
var getAppGlobalData = require('../../../templates/copyright/copyright.js');
import util from '../../../resource/js/xx_util.js';
import { baseModel } from '../../../resource/apis/index.js'
var timer;
var timerLeftTime;
Page({
  data: {
    swiperIndexCur: 1,
    swiperStatus: {
      indicatorDots: false,
      autoplay: true
    },
    isStaff: '',
    detailData: {},
    globalData: {},
    authStatus: true,
    bgStatus: false,
    chooseStatus: false,
    chooseNumStatus: false,
    addNumber: 1,
    addPrice: 0,
    countPrice: 0,
    rulesIndex: 0,
    checkSpeList: [],
    collageList: [],
    tmpTimes: [],
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(this, options, "show detail.js 1111111111111111111111111111111111111111111111111111111111111111");
    var that = this;
    app.util.showLoading(1); 
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

    var paramData = {};

    if (options.id) {
      paramData.detailID = options.id;
    }
    if (options.to_uid) {
      paramData.to_uid = options.to_uid;
      app.globalData.to_uid = options.to_uid;
    }
    if (options.from_id) {
      paramData.from_id = options.from_id;
      app.globalData.from_id = options.from_id;
    }
    if (options.nickName) {
      app.globalData.nickName = options.nickName;
    }

    that.setData({
      paramData: paramData,
      globalData: app.globalData
    })

    if (wx.getStorageSync("user")) {
      let user = wx.getStorageSync("user");
      if (user.phone) {
        app.globalData.hasClientPhone = true;
        that.setData({
          'globalData.hasClientPhone': true
        })
      }
    }
 
    // that.getCollageList(1);
    that.getProductDetail();

    if (options.from_id && options.type == 2) {
      if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
        if (app.globalData.loginParam.scene == 1044) {
          timer = setInterval(function () {
            // console.log(app.globalData.encryptedData,"app.globalData.encryptedData  1044")
            if (app.globalData.encryptedData) {
              that.toGetShareInfo();
              // clearInterval(timer);
            }
          }, 1000)
        }  
      }
    }
    wx.hideLoading();
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function (res) {
    // 页面显示 
    var that = this;
    that.checkAuthStatus();
    that.getCollageList();
    // that.getCollageList(2);
    console.log("show detail.js    onshow that.checkAuthStatus ==> authStatus ", that.data.authStatus)
  },
  onHide: function () {
    // 页面隐藏 
    clearInterval(timer);
    clearInterval(timerLeftTime);
  },
  onUnload: function () {
    // 页面关闭 
    clearInterval(timer);
    clearInterval(timerLeftTime);
  },
  onPullDownRefresh: function () {
    // 监听用户下拉动作
    var that = this;
    wx.showNavigationBarLoading();
    getAppGlobalData.getAppGlobalData(that,baseModel,util);
    that.checkAuthStatus();
  },
  onReachBottom: function () {
    // 页面上拉触底
  },
  onShareAppMessage: function (res) {
    // 用户点击右上角分_享
    var that = this;
    // if (res.from === 'button') {
    //   console.log("来自页面内转发按钮");
    // }
    // else {
    //   console.log("来自右上角转发菜单")
    // }
    return {
      title: that.data.detailData.name,
      path: '/longbing_card/pages/shop/detail/detail?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&id=' + that.data.paramData.detailID + '&type=2&nickName=' + app.globalData.nickName,
      imageUrl: that.data.detailData.cover_true,
      // success: function (res) {
      //   console.log(res)
      //   if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
      //     that.toForwardRecord();
      //   }
      // },
      // fail: function (res) {
      //   // 分_享失败
      //   console.log(res)
      // }
    };
    if (that.data.paramData.to_uid != wx.getStorageSync("userid")) {
      that.toForwardRecord();
    }
  }, 
  getProductDetail: function () {
    var that = this;
    console.log(app.globalData.to_uid, "app.globalData.to_uid")
    app.util.request({
      'url': 'entry/wxapp/ShopGoodsDetail',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID,
        to_uid: app.globalData.to_uid
      },
      success: function (res) {
        console.log("entry/wxapp/goodsDetail ==>", res)
        if (!res.data.errno) {
          var tmpData = res.data.data;
          var tmpSpcList = that.data.checkSpeList;
          var tmpID = [];
          for (let i in tmpData.spe_list) {
            if (tmpData.spe_list.length > 1) {
              if (tmpData.spe_list[i].title == '默认' && tmpData.spe_list[i].sec.length == 1 && tmpData.spe_list[i].sec[0].title == '默认') {
                tmpData.spe_list.splice(i, 1)
              }
            }
            tmpSpcList.push(0)
            if (tmpData.spe_list.length > 0) {
              tmpID.push(tmpData.spe_list[i].sec[0].id)
            }
          }

          if (tmpData.collage.length > 0) {
            that.setData({
              tmpShowCheckCollageID: tmpData.collage[0].id,
              tmpShowCheckNumber: tmpData.collage[0].number,
            })
          }

          
          let {name,price,sale_count,cover2,qr} = tmpData;
          var tmp_shareParamObj = {name,price,sale_count,cover2,qr};
          that.setData({
            shareParamObj: tmp_shareParamObj,
            detailData: tmpData,
            addPrice: tmpData.price,
            checkSpeList: tmpSpcList,
            checkIDs: tmpID,
          })
          that.getCurrentCheckIdAndPrice();
        } 
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  getCollageList: function () {
  // getCollageList: function (type) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/shopcollagelist',
      'cachetime': '30',
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID
      },
      success: function (res) {
        console.log("entry/wxapp/shopcollagelist ==>", res)
        if (!res.data.errno) {
          var tmpResData = res.data.data;
          // if (type == 1) {
            var dateUtil = new app.util.date();
            var tmpTimes = that.data.tmpTimes;
            tmpTimes = [];
            var tmpData = [];
            for (let i in tmpResData) {
              if (tmpResData[i].left_number > 0) {
                tmpData.push(tmpResData[i])
              }
            }
            for (let i in tmpData) {
              var tmpTime = tmpData[i].left_time;
              // timerLeftTime = setInterval(() => {
                // tmpTime = tmpTime - 1;
                // console.log(tmpTime, "tmpTime -- *************")
                let day = parseInt(tmpTime / 24 / 60 / 60);
                day = day > 0 ? day + '天 ' : '';
                tmpTimes[i] = day + dateUtil.dateToStr('HH:mm', dateUtil.longToDate(tmpTime * 1000));
                if (tmpTime == 0) {
                  tmpData.splice(i, 1);
                  tmpTimes.splice(i, 1);
                }
                that.setData({
                  tmpTimes: tmpTimes
                });
              // }, 1000);
            }
          // }
          that.setData({
            collageList: tmpData
          })
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/shopcollagelist ==> fail ==> ", res)
      }
    })
  },
  getShopAddTrolley: function (type) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/ShopAddTrolley',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        goods_id: that.data.paramData.detailID,
        spe_price_id: that.data.spe_price_id,
        number: that.data.addNumber
      },
      success: function (res) {
        console.log("entry/wxapp/ShopAddTrolley ==>", res)
        if (!res.data.errno) {
          if (type == 1) {
            wx.showModal({
              title: '',
              content: '已成功加入购物车，快去看看吧',
              cancelText: '继续选购',
              confirmText: '查看已选',
              success: function (res) {
                if (res.confirm) {
                  that.toHideChoose();
                  wx.navigateTo({
                    url: '/longbing_card/pages/shop/car/carIndex/carIndex'
                  });
                } else if (res.cancel) {
                }
              }
            });
          }
          if (type == 2) {
            that.setData({
              trolley_ids: res.data.data.id
            })
            that.getToJumpUrl();
          }
        }
      },
      fail: function (res) {
        console.log("entry/wxapp/ShopAddTrolley ==>  fail ==> ", res)
      }
    })
  }, 
  swiperChange: function (e) {
    var that = this;
    var cur = e.detail.current;
    that.setData({
      swiperIndexCur: cur * 1 + 1
    })
  },
  // 1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网
  // target_id 转发内容的id 当type=2,3时有效
  toForwardRecord: function () {
    var that = this;
    let paramObj = {
      type: 2,
      to_uid: app.globalData.to_uid,
      target_id: that.data.paramData.detailID
    }
    console.log("entry/wxapp/Forward ==> paramObj", paramObj)

    app.util.request({
      'url': 'entry/wxapp/Forward',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': paramObj,
      success: function (res) {
        // console.log("entry/wxapp/Forward ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 记录复制文本 拨打电话 查看地址 分_享等情况
  toCopyRecord: function (type) {
    var that = this;
    console.log(app.globalData, "app*********************")
    app.util.request({
      'url': 'entry/wxapp/copyRecord',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        type: type,
        to_uid: app.globalData.to_uid
      },
      success: function (res) {
        // console.log("entry/wxapp/copyRecord ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  toGetShareInfo: function () {
    var that = this;
    // type 1=>浏览名片 2=>浏览自定义码 3=>浏览商品 4=>浏览动态
    // 当type 为2,3,4时, 需要传浏览对象的id 
    wx.login({
      success: function (res) {
        // console.log('toGetShareInfo wx.login ==>>', res);
        let tmpData = {
          encryptedData: app.globalData.encryptedData,
          iv: app.globalData.iv,
          type: 3,
          code: res.code,
          to_uid: that.data.paramData.to_uid,
          target_id: that.data.paramData.detailID,
        }
        // console.log("wx.login == > tmpData ", tmpData)
        app.util.request({
          'url': 'entry/wxapp/getShare',
          'cachetime': '30',
          'showLoading': false,
          'method': 'POST',
          'data': tmpData,
          success: function (res) {
            console.log("entry/wxapp/getShare ==>", res)
            if (!res.data.errno) {
              clearInterval(timer);
            }
          },
          fail: function (res) {
            // console.log("entry/wxapp/getShare ==> fail ==> ", res)
          }
        })
      },
      fail: function (res) {
        // console.log("entry/wxapp/getShare ==> fail ==> ", res)
      }
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
    that.checktoConsult();
  },
  setPhoneInfo: function (encryptedData, iv) {
    var that = this;
    console.log(app.globalData.to_uid)
    wx.login({
      success: function (res) {
        console.log('wx.login ==>>', res);
        let tmpData = {
          encryptedData: encryptedData,
          iv: iv,
          code: res.code,
          to_uid: app.globalData.to_uid
        }

        app.util.request({
          'url': 'entry/wxapp/phone',
          'cachetime': '30',
          'method': 'POST',
          'showLoading': false,
          'data': tmpData,
          success: function (res) {
            // console.log("entry/wxapp/update ==>", res)
            if (!res.data.errno) {
              app.globalData.hasClientPhone = true
              that.setData({
                globalData: app.globalData
              },function(){
                if(res.data.data.phone){
                  let sync_userid = wx.getStorageSync("userid");
                  let sync_user = wx.getStorageSync("user");
                  sync_user.phone = d.data.phone;
                  wx.setStorageSync("userid",sync_userid);
                  wx.setStorageSync("user",sync_user);
                }
              })
            }
          },
          fail: function (res) {
            console.log("fail ==> ", res)
          }
        })
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  },
  // 检查授权
  checkAuthStatus: function () {
    var that = this;
    auth.checkAuth(that,baseModel,util);
  },
  getUserInfo: function (e) {
    var that = this;
    console.log('获取微信用户信息')
    auth.getUserInfo(e);
  },
  checktoConsult: function () {
    var that = this;
    console.log(app.globalData.to_uid, wx.getStorageSync("userid"), app.globalData.nickName, "checktoConsult *********  showModal")
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
        url: '/longbing_card/chat/userChat/userChat?chat_to_uid=' + app.globalData.to_uid + '&contactUserName=' + app.globalData.nickName + '&goods_id=' + that.data.paramData.detailID
      })
    }
  },
  toShowChoose: function () {
    var that = this;
    that.setData({
      bgStatus: true,
      chooseNumStatus: true,
    });
  },
  toHideChoose: function () {
    var that = this;
    that.setData({
      bgStatus: false,
      chooseStatus: false,
      chooseNumStatus: false,
    });
  },
  RemoveAddNum: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var number = that.data.addNumber;
    var tmpStock = that.data.detailData.stock;
    var tmpStockCollage;
    if (that.data.toOrderStatus == 'toCollagePay') {
      tmpStockCollage = that.data.tmpShowCheckNumber;
    }

    console.log(tmpStock, that.data.tmpShowCheckNumber, "////////////***tmpStock")

    if (status == 'remove') {
      console.log('购物车-1', number,tmpStockCollage*1 + 1,that.data.toOrderStatus);
      if (that.data.toOrderStatus == 'toCollagePay') {
        if (number < tmpStockCollage*1 + 1) {
          wx.showModal({
            title: '',
            content: '选择数量不能少于该拼团组合数量',
            confirmText: '知道啦',
            showCancel: false,
            success: function (res) {
              if (res.confirm) {
              }
            }
          })
          return false;
        } else {
          if (number < tmpStock*1 + 1) {
            number = number * 1 - 1;
          }
        }
      } else {
        if (number == 1) {
          wx.showModal({
            title: '',
            content: '不能再少了',
            confirmText: '知道啦',
            showCancel: false,
            success: function (res) {
              if (res.confirm) {
              }
            }
          })
          return false;
        } else {
          if (number < tmpStock*1 + 1) {
            number = number * 1 - 1;
          }
        }
      }


    }


    if (status == 'add') {
      console.log('购物车+1', number,tmpStock);
      number = number * 1 + 1;
      if (number > tmpStock*1) {
        wx.showModal({
          title: '',
          content: '库存不足，不能再添加了',
          confirmText: '知道啦',
          showCancel: false,
          success: function (res) {
            if (res.confirm) {
            }
          }
        })
        return false;
      }
    }

    that.setData({
      addNumber: number
    });
    that.toCountAddPrice();
  },
  toCountAddPrice: function () {
    var that = this;
    var tmpPrice = that.data.addPrice;
    if (that.data.addNumber > parseInt(that.data.detailData.stock)) {
      that.setData({
        addNumber: parseInt(that.data.detailData.stock)
      })
    }

    if (that.data.toOrderStatus == 'toCollagePay') {
      tmpPrice = that.data.collageAddPrice;
    }

    that.setData({
      countPrice: ((that.data.addNumber * 1) * (tmpPrice * 1)).toFixed(2)
    })
  },
  getCurrentCheckIdAndPrice: function () {
    var that = this;
    var tmpID = that.data.checkIDs;
    var tmpCheckIds = '';
    for (let i in tmpID) {
      tmpCheckIds += (tmpID[i] + '-')
    }
    tmpCheckIds = tmpCheckIds.slice(0, -1);

    var tmpCheckSpeList = that.data.checkSpeList;
    var tmpSpeList = that.data.detailData.spe_list;
    var tmpCheckSpe = '';
    if (tmpSpeList.length > 0) {
      for (let i in tmpCheckSpeList) {
        tmpCheckSpe += (tmpSpeList[i].sec[tmpCheckSpeList[i]].title + '-')
      }
      tmpCheckSpe = tmpCheckSpe.slice(0, -1);
    }

    var tmpPrice = that.data.detailData.spe_price;
    var tmpCurCheckID;
    var tmpCurStock;
    var tmpCurPrice;
    var tmpShowCheckID;
    for (let i in tmpPrice) {
      if (tmpCheckIds == tmpPrice[i].spe_id_1) {
        tmpCurCheckID = tmpPrice[i].id;
        tmpCurStock = tmpPrice[i].stock;
      }
    }

    if (that.data.toOrderStatus == 'toCollagePay') {
      var tmpCollList = that.data.detailData.collage;
      var tmpRulesIndex = that.data.rulesIndex;
      tmpShowCheckID = 1;
      tmpCurPrice = tmpCollList[tmpRulesIndex].price;

      that.setData({
        collageAddPrice: tmpCurPrice,
        addNumber: that.data.tmpShowCheckNumber
      })
    } else {
      tmpShowCheckID = 0;
      for (let i in tmpPrice) {
        if (tmpCheckIds == tmpPrice[i].spe_id_1) {
          tmpCurPrice = (tmpPrice[i].price)
        }
      }
      that.setData({
        addPrice: tmpCurPrice,
      })
    }
    that.setData({
      tmpCheckIds: tmpCheckIds,
      'detailData.stock': tmpCurStock,
      spe_price_id: tmpCurCheckID,
      tmpShowCheckID: tmpShowCheckID,
      spe_text: tmpCheckSpe
    });
    that.toCountAddPrice();
  },
  getToJumpUrl: function () {
    var that = this;
    console.log(that.data.trolley_ids, "trolley_ids")
    var tmpStatus = that.data.toOrderStatus;
    var orderpaystatus = 'toOrder';
    var tmpData = that.data.detailData;
    var tmpCarList = {
      count_price: that.data.countPrice,
      tmp_trolley_ids: that.data.trolley_ids,
      dataList: [
        {
          name: tmpData.name,
          number: that.data.addNumber,
          goods_id: tmpData.id,
          cover_true: tmpData.cover_true,
          freight: tmpData.freight,
          spe: that.data.spe_text,
          price2: that.data.addPrice,
          stock: tmpData.stock,
        }
      ],
    };
    if (tmpStatus == 'toCollagePay') {
      console.log("发布拼团")
      orderpaystatus = 'toCollage';
      tmpCarList.dataList[0].collage_id = that.data.tmpShowCheckCollageID;
      tmpCarList.dataList[0].price2 = that.data.collageAddPrice;
    }
    wx.setStorageSync("storageToOrder", tmpCarList);
    that.toHideChoose();
    wx.navigateTo({
      url: '/longbing_card/pages/shop/car/toOrder/toOrder?status=' + orderpaystatus
    })
  },
  toJump: function (e) {
    var that = this;
    var status = e.currentTarget.dataset.status;
    var id = e.currentTarget.dataset.id;
    var index = e.currentTarget.dataset.index;
    var index1 = e.currentTarget.dataset.index1;
    var paystatus = e.currentTarget.dataset.paystatus;
    if (status == 'toDetailJumpUrl') {
      app.util.goUrl(e);
    } else if (status == 'toCopyright' || status == 'moreCollage' || status == 'toReleaseCollage') {
      if (status == 'moreCollage') {
        var tmpData = that.data.detailData;
        var moreCollageData = {
          name: tmpData.name,
          cover_true: tmpData.cover_true,
          collage_count: tmpData.collage_count,
          people: tmpData.collage[that.data.rulesIndex].people,
          number: tmpData.collage[that.data.rulesIndex].number,
          price: tmpData.collage[that.data.rulesIndex].price,
          oldPrice: tmpData.price,
        }
        wx.setStorageSync("moreCollageData", moreCollageData)
      }
      app.util.goUrl(e)
    } else if (status == 'toShop') {
      console.log("商城首页")
      console.log('/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toShop')
      wx.reLaunch({
        url: '/longbing_card/pages/index/index?to_uid=' + app.globalData.to_uid + '&from_id=' + wx.getStorageSync("userid") + '&currentTabBar=toShop'
      })
    } else if (status == 'toConsult') {
      console.log("去咨询")
      if (app.globalData.to_uid != wx.getStorageSync("userid")) {
        that.toCopyRecord(8);
      }
      if (that.data.globalData.hasClientPhone == true) {
        console.log("用户已授权手机号码")
        that.checktoConsult();
      }
    } else if (status == 'toAddCar' || status == 'toProductPay' || status == 'toCollagePay' || status == 'toOnlyPay') {
      that.setData({
        toOrderStatus: status
      })
      that.toShowChoose();
      that.getCurrentCheckIdAndPrice();
    } else if (status == 'toPay') {
      var tmpStatus = that.data.toOrderStatus;
      var orderpaystatus = 'toOrder';
      if (tmpStatus == 'toAddCar' || paystatus == 'toAddCar') {
        console.log("加入购物车")
        that.getShopAddTrolley(1);
      } else {

        var tmpStatus = that.data.toOrderStatus;
        var orderpaystatus = 'toOrder';
        var tmpData = that.data.detailData;
        var tmpCarList = {
          count_price: that.data.countPrice,
          tmp_trolley_ids: that.data.trolley_ids,
          dataList: [
            {
              name: tmpData.name,
              number: that.data.addNumber,
              goods_id: tmpData.id,
              cover_true: tmpData.cover_true,
              freight: tmpData.freight,
              spe: that.data.spe_text,
              price2: that.data.addPrice,
              stock: tmpData.stock,
            }
          ],
        };
        
        if (tmpStatus == 'toProductPay' || paystatus == 'toOnlyPay') {
          console.log("立即购买")
          tmpCarList.dataList[0].spe_price_id = that.data.spe_price_id; 
        }
        if (tmpStatus == 'toCollagePay') {
          console.log("发布拼团")
          orderpaystatus = 'toCollage';
          tmpCarList.dataList[0].collage_id = that.data.tmpShowCheckCollageID;
          tmpCarList.dataList[0].price2 = that.data.collageAddPrice;
        }

        wx.setStorageSync("storageToOrder", tmpCarList);
        that.toHideChoose();
        wx.navigateTo({
          url: '/longbing_card/pages/shop/car/toOrder/toOrder?status=' + orderpaystatus
        })




        // if (tmpStatus == 'toProductPay' || paystatus == 'toOnlyPay') {
        //   // that.getShopAddTrolley(2);
        //   // console.log(that.data.trolley_ids, "trolley_ids111111111111111111")
        // } else {
        //   that.getToJumpUrl();
        // }



      }
    } else if (status == 'chooseCollage') {
      console.log("选择条件")
      that.setData({
        bgStatus: true,
        chooseStatus: true,
      });
    } else if (status == 'setrules') {
      console.log('选择规则');
      var tmpData = that.data.detailData.collage;
      var tmpCheckIds = tmpData[index].spe_id_1;
      var tmpCheck = tmpCheckIds.split('-');
      var checkIDs = [];
      console.log('tmpCheckIds', tmpCheckIds)
      for (let i in tmpCheck) {
        checkIDs.push(tmpCheck[i])
      }

      var tmpSpeList = that.data.detailData.spe_list;
      var checkSpeList = [];
      for (let i in tmpSpeList) {
        for (let j in tmpSpeList[i].sec) {
          if (checkIDs[i] == tmpSpeList[i].sec[j].id) {
            checkSpeList.push(j)
          }
        }
      }
      that.setData({
        rulesIndex: index,
        toOrderStatus: 'toCollagePay',
        tmpShowCheckID: 1,
        collageAddPrice: tmpData[index].price,
        // addPrice: tmpData[index].price,
        addNumber: tmpData[index].number,
        tmpShowCheckCollageID: tmpData[index].id,
        tmpShowCheckNumber: tmpData[index].number,
        checkIDs: checkIDs,
        checkSpeList: checkSpeList,
        tmpCheckIds: tmpCheckIds,
      })
      // that.getCurrentCheckIdAndPrice();
      that.toCountAddPrice();
    } else if (status == 'toCheckCur') {
      console.log("规格属性选择")


      var tmpSpeList = that.data.checkSpeList;
      var tmpID = that.data.checkIDs;

      tmpID[index] = id;

      tmpSpeList[index] = index1;

      that.getCurrentCheckIdAndPrice();
      that.setData({
        checkSpeList: tmpSpeList
      });


      if (that.data.toOrderStatus == 'toCollagePay') {
        if (that.data.tmpShowCheckID == 1) {
          that.setData({
            addNumber: that.data.tmpShowCheckNumber
          })
        }
        if (that.data.tmpShowCheckID == 0) {
          wx.showToast({
            icon: 'none',
            title: '该组合没有参加拼团，请另选其他组合！',
            duration: 2000
          })
          return false;
        }
      }

    }
  },
  formSubmit: function (e) {
    var that = this;
    var formId = e.detail.formId;
    var status = e.detail.target.dataset.status;
    var type = e.detail.target.dataset.type;
    that.toSaveFormIds(formId);
    if (status == 'toCollection') {
      console.log("收藏")
      // that.getProductCollection();
    } else if (status == 'toShowShare') {
      // console.log("显示 分_享名片")
      that.setData({
        showShareStatus: 1
      })
    } else if (status == 'toCarIndex') {
      console.log("购物车")
      wx.navigateTo({
        url: '/longbing_card/pages/shop/car/carIndex/carIndex'
      })
    } else if (status == 'toMine') {
      console.log("我的个人中心")
      wx.navigateTo({
        url: '/longbing_card/pages/uCenter/index'
      })
    } else if (status == 'toShareCard') {
      // console.log("1微信好友 || 2名片码 || 3取消")
      that.setData({
        showShareStatus: 0
      })
      if (type == 2) { 
        wx.navigateTo({
          url: '/longbing_card/pages/shop/share/share'
        })
      }
    }
  },
  toSaveFormIds: function (formId) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/formid',
      'cachetime': '30',
      'showLoading': false,
      'method': 'POST',
      'data': {
        formId: formId
      },
      success: function (res) {
        // console.log("entry/wxapp/formid ==>", res)
        if (!res.data.errno) {
        }
      },
      fail: function (res) {
        console.log("fail ==> ", res)
      }
    })
  }
})