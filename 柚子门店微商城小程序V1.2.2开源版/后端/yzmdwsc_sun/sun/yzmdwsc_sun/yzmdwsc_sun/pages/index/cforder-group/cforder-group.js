// yzbld_sun/pages/index/cforder/cforder.js
//var Api = require("../../../../we7/js/utils/util.js"); 
var flag=true;
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '提交订单',
    goods:[],
    usercoupon:[],
    times:'24小时内',
    address:'厦门市集美区杏林湾路',
    contact:'13000000',
    startSince:'09:01',
    endSince:'21:01',
    sincetype :'0',/**选择配送方式 */
    distribution:'0.00',/**配送费 */
    distributFee:'0.00',/**抵扣邮费 */
    totalprice: '0',/**总价 */
    cardprice: '0',/***优惠券 */
    curprice: '0',/***最终支付价格 */
    showModalStatus: false,
    price:0,
    coupon_id:0,
    cards: [
      {
        price: '30',
        minprice: '398',
        time: '2018.01.12-2018.02.12'
      },
      {
        price: '10',
        minprice: '398',
        time: '2018.01.12-2018.02.12'
      }
    ],
    showRemark: 0,
    choose: [
      { name: '微信', value: '微信支付', icon: '../../../../style/images/wx.png' },
      { name: '余额', value: '余额支付', icon: '../../../../style/images/local.png' },
    ],
    uremark:'',/**用户备注 */
    hasAddress:false,
    address:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
     wx.setNavigationBarColor({
      frontColor: wx.getStorageSync('fontcolor'),
      backgroundColor: wx.getStorageSync('color'),
      animation: {
        duration: 0,
        timingFunc: 'easeIn' 
      }
    })
    var settings = wx.getStorageSync('settings');  
    this.setData({
      settings: settings,
    })
    var gid = options.gid;
    var openid = wx.getStorageSync('openid');  
    wx.getStorage({
      key: 'order',
      success: function (res) {
        var num = res.data.num;
        that.setData({
          spec: res.data.spec,
          spect: res.data.spect,
          num: num,
        })  
        app.util.request({
          'url': 'entry/wxapp/GoodsDetails',
          'cachetime': '0',
          data: {
            id: gid,
            openid: openid,
          },
          success: function (o) {
            var goodsDetails = o.data.data 
            var first_price = goodsDetails.pintuan_price * num
            var last_price = parseFloat(first_price) + parseFloat(that.data.settings.distribution);
            that.setData({
              goodsDetails: goodsDetails,
              first_price: first_price,
              price: first_price,
              last_price: last_price,
              distribution: parseFloat(that.data.settings.distribution),
              num: num,
            })   
          }
        })

      }
    })      
    that.urls()
    return
  },
  urls: function () {
    var that = this
    //---------------------------------- 异步保存上传图片需要的网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url2',
      'cachetime': '0',
      success: function (res) {
        wx.setStorageSync('url2', res.data)
      },
    })
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/Url',
      'cachetime': '0',
      success: function (res) {
        // ---------------------------------- 异步保存网址前缀----------------------------------
        wx.setStorageSync('url', res.data)
        that.setData({
          url: res.data
        })
      },
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
  bindTimeChange: function (e) {
    this.setData({
      time: e.detail.value
    })
  },
  /***选择配送方式 */
  chooseType(e){
    var that=this;
    var totalprice = that.data.price;//商品总价
    var cardprice = that.data.cardprice; //优惠券减免金额
    var distribution = that.data.distribution; //运费
    var sincetype = e.currentTarget.dataset.type;
    var that=this;
    if (sincetype =='1'){
      distribution=0;
      that.setData({
        distribution: 0
      })
    }else{
      distribution = that.data.settings.distribution;
      that.setData({
        distribution: that.data.settings.distribution
      })
    }
    var distribution = 0;
    if (sincetype == 0) {
      distribution = that.data.settings.distribution;//运费 
    } else if (sincetype == 1) {
      distribution = 0;
    }
    var curprice = (parseFloat(totalprice) - parseFloat(cardprice) + parseFloat(distribution)).toFixed(2);//最后需要付款金额
    that.setData({
      sincetype: sincetype,
      last_price: curprice
    })
  },
  powerDrawer: function (e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu);

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
      animation.opacity(1).height('550rpx').step();
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
    if (currentStatu == "open") {
      this.setData(
        {
          showModalStatus: true
        }
      );
    }
  },
  coupon(e) {
    var that=this;
    var sincetype=that.data.sincetype;
    const cardprice = e.currentTarget.dataset.price;//优惠券减免金额
    var coupon_id=e.currentTarget.dataset.gid;
    const totalprice = that.data.price;//商品总价
    var distribution=0;
    if (sincetype==0){ 
      distribution =that.data.settings.distribution;//运费 
    }else if(sincetype==1){
      distribution=0;
    }
    var currentStatu = 'close';
    var curprice = (parseFloat(totalprice) - parseFloat(cardprice) + parseFloat(distribution)).toFixed(2);//最后需要付款金额
    if (curprice < 0) {
      curprice = 0;
    }    
    that.setData({
      coupon_id: coupon_id,
      cardprice: cardprice,
      curprice: curprice,
      last_price: curprice
    });
    that.util(currentStatu);
  },  
  toPay:function(e){
    var that=this;
    var cid = that.data.cid;
    var sincetype = that.data.sincetype;
    var address=that.data.address;
    var gid = e.currentTarget.dataset.gid;
    //留言
    if (!that.data.msg) {
      var msg = '';
    } else {
      var msg = that.data.msg.value;
    }
    //自提电话
    if (!that.data.ziti_phone) {
      var ziti_phone = '';
    } else {
      var ziti_phone = that.data.ziti_phone.value;
    }
    if(sincetype==0){
      if (!address.provinceName) {
        wx.showModal({
          title: '温馨提示',
          content: '请选择收货地址',
          showCancel: false
        })
        return
      }
    } else if (sincetype==1){
      if (ziti_phone==''){
        wx.showModal({
          title: '温馨提示',
          content: '请选择填写自提电话',
          showCancel: false
        })
        return
      }

    }

  /*  if (flag == "false") {
        wx.showModal({
          title: '提示',
          content: '订单提交中,请勿重新提交',
          showCancel: false
        });
      return
    }

    if (flag == true) {
      console.log('---订单提交中---');
      flag = "false";
    }
    */
   
    var price = that.data.last_price;//订单金额
    wx.getStorage({
      key: 'openid',
      success: function (res) {
        var openid = res.data;
        app.util.request({
          'url': 'entry/wxapp/Expire',
          'cachetime': '0',
          data: {
            id: gid,
            openid: openid,
          },
          success: function (res) {
            if (res.data.data == 0) {
              wx.showToast({
                title: '活动已结束',
                icon: 'none',
              })
            } else {
                  //下拼团订单
                  app.util.request({
                    'url': 'entry/wxapp/setGroupOrder',
                    'cachetime': '30',
                    data: {
                      uid: openid, 
                      order_amount: price,
                      cid: 0,
                      pin_mch_id:0,
                      gid: e.currentTarget.dataset.gid,
                      pic: e.currentTarget.dataset.pic,
                      good_total_price: that.data.price,
                      good_total_num: that.data.num,
                      sincetype: that.data.sincetype,
                      distribution: that.data.distribution,
                      coupon_id: that.data.coupon_id,
                      coupon_price: that.data.cardprice,
                      spec_value: that.data.spec,
                      spec_value1: that.data.spect,
                      name: address.userName,
                      phone: address.telNumber,
                      province: address.provinceName,
                      city: address.cityName,
                      zip: address.countyName,
                      address: address.detailInfo,
                      postalcode: address.postalCode,
                      ziti_phone: ziti_phone,
                      remark: msg,
                    },
                    success: function (o) {
                      var order_id = o.data;
                      console.log('获取支付参数');
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
                             /* app.util.request({
                                'url': 'entry/wxapp/PayOrder',
                                'cachetime': '0',
                                data: {
                                  order_id: order_id,
                                },
                                success: function (res) { */
                                  wx.showToast({
                                    title: '支付成功',
                                    icon: 'success',
                                    duration: 2000,
                                    success: function () {

                                    },
                                    complete: function () {
                                      wx.navigateTo({
                                        url: '../../user/groupdet/groupdet?order_id=' + order_id,
                                      })
                                    },
                                  })
                                 
                             /*   }
                              })*/
                            },
                            'fail': function (result) {
                              wx.navigateTo({
                                url: '../../index/groupDet/groupDet?gid=' + e.currentTarget.dataset.gid,
                              })
                              return
                               
                            }
                          });

                        }
                      })

                    }
                  })
                
            }
           
          }
        })

    
      }
    })



  },
  //备注信息
  message: function (e) {
    var msg = e.detail;
    console.log(msg)
    this.setData({
      msg: msg,
    })
  },
  //自提电话
  ziti_phone:function(e){
    var ziti_phone = e.detail;
    console.log(ziti_phone)
    this.setData({
      ziti_phone: ziti_phone,
    })
  },
  /**表单提交 */
  formSubmit(e){

    console.log(e.dataset);
    return 
    var flag = true;
    var warn = "确认付款";
    var that = this;
    var sincetype = that.data.sincetype;/**配送方式 */
    var distributFee = that.data.distributFee;
    var time=that.data.time;
    var uremark = that.data.uremark;/**用户备注 */

    if (sincetype=='0'){
      /**送货上门 */
      flag = "false";
      console.log('送货上门')
    } else if (sincetype == '1'){
      /**自提 */
      console.log('自提')
      flag = "false";/**提交支付 */
      
    }

    if (flag == true) {
      wx.showModal({
        title: '提示',
        content: warn,
        showCancel: false
      })
    }
  },
  toAddress() {
    var that = this;
    wx.chooseAddress({
      success: function (res) {
        console.log(res)
        console.log('获取地址成功')
        that.setData({
          address: res,
          hasAddress: true
        })
      },
      fail: function (res) {
        console.log('获取地址失败')
      },
    })
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