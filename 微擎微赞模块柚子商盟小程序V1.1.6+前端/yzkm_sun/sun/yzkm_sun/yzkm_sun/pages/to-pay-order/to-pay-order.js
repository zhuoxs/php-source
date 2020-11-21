// chbl_sun/pages/to-pay-order/index.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    shopprice:'',//商品价格
    template_order:'',
    postData: ["快递", "到店取货"],
    addressData: [
      // {
      //   name:"余文乐",
      //   phone:12345678901
      // },
      // {
      //   name: "段奕宏",
      //   phone: 12345678901
      // },
    ],
    guige: 0,//规格
    buyNumbe:0,//购买数量
    consignee:'',//收货人
    ContactNum:'',//联系电话
    money:'',//优惠价
    youhui:'',//会员状态
    addNew: [],
    buy_message:''//买家留言

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var buyNumber = wx.getStorageSync('buyNumber');
    console.log('11111111111111111111111111111111111111');
    console.log(buyNumber);
    var that=this;
    console.log('订单页面数据加载');
    console.log(options);
    var gid = options.iid;
    that.diyWinColor();
        app.util.request({
          'url': 'entry/wxapp/Url',
          success: function (res) {
            console.log('页面加载请求')
            console.log(res);
            wx.getStorageSync('url', res.data);
            that.setData({
              gid:gid,
              url: res.data,
              buyNumber: buyNumber,//购买数量
            })
          }
        })

      // 订单数据请求
        app.util.request({
          'url': 'entry/wxapp/Doods_details',
          'data': { 
            iid: options.iid,//商品id
            openid: options.openid,//openid
           },
          success: function (res) {
            console.log('订单数据请求');
            console.log(res);  
            that.setData({
              list: res.data, 
              guige: options.guige,//规格
              shopprice: options.shopprice,//价格

            })

                app.util.request({
                  'url': 'entry/wxapp/Card_hy',
                  'data': {
                    openid: options.openid,//openid
                  },
                  success: function (res1) {
                    console.log('会员查询');
                    console.log(res1);
                    if (res1.data==false) {
                      that.setData({
                        youhui: '办会员卡可以有优惠',
                        money: that.data.shopprice * buyNumber,//普通价格
                      })
                    } else {
                          app.util.request({
                            'url': 'entry/wxapp/Menber_yh',
                            success: function (res2) {
                              console.log('查询优惠价格')
                              console.log(res2.data);
                              var discount = parseInt(res2.data.discount)
                              console.log(that.data.shopprice)
                              console.log(buyNumber)
                              console.log(res2.data.discount)
                              if (that.data.shopprice<=0.01){
                                that.setData({
                                  youhui:  '金额小于等于0.01不享受优惠',
                                  money: (that.data.shopprice * buyNumber ).toFixed(2),//优惠价格
                                })
                                }else{
                                // var moneys = (that.data.shopprice * buyNumber - that.data.shopprice * buyNumber * res2.data.discount).toFixed(2);
                                var moneys = ( that.data.shopprice * buyNumber * res2.data.discount).toFixed(2);

                                console.log('moneys' + that.data.shopprice * buyNumber);
                                console.log('moneys' + that.data.shopprice * buyNumber * res2.data.discount );
                                console.log('moneys' + res2.data.discount);
                                console.log('moneys' + moneys);
                                    that.setData({
                                      youhui: res2.data.discount*10 + '折',
                                      money: moneys
                                    })
                                }
                            }
                          })
                    }

                  }
                })



          }
        })


        var openid = wx.getStorageSync('openid');//用户openid
        that.diyWinColor();
        app.util.request({
          url: 'entry/wxapp/User_id',
          data: {
            openid: openid,
          },
          success: function (res) {
            console.log('查看用户id');
            console.log(res);
            // that.setData({
            //   comment_xqy: res.data,
            // })
            wx.setStorageSync('user_id', res.data.id);
          }
        })

        app.util.request({
          url: 'entry/wxapp/Mob_message',
          success: function (res) {
            console.log('模板消息数据');
            console.log(res);
            that.setData({
              template_order: res.data.template_order,
            })
          }
        })
      
  },
  
  // 收货人
  consignee:function(e){
    console.log('收货人');
    console.log(e);
    this.setData({
      consignee: e.detail.value,
    })
  }, 
  // 联系电话
  ContactNum: function (e) {
    console.log('联系电话');
    console.log(e);
    this.setData({
      ContactNum: e.detail.value,
    })
  },
  // 买家留言
  buy_message: function (e) {
    console.log('买家留言');
    console.log(e);
    this.setData({
      buy_message: e.detail.value,
    })
  },
  selectPost: function (e) {
    console.log(e);
    var that = this;
    var currentIndex = e.currentTarget.dataset.index;
   
     if (currentIndex==0){
            wx.chooseAddress({
              success: function (res) {
                var userName = res.userName;
                var postalCode = res.postalCode;
                var provinceName = res.provinceName;
                var cityName = res.cityName;
                var countyName = res.countyName;
                var detailInfo = res.detailInfo;
                var nationalCode = res.nationalCode;
                var telNumber = res.telNumber;
                that.setData({
                  currentSelect: currentIndex,
                  address: provinceName + cityName + countyName + detailInfo,
                  userName: userName,
                  tel: telNumber
                })
              }
            })
          
    } else if(currentIndex==1){
      //  that.setData({
         
      // })
    }
     that.setData({
       currentSelect: currentIndex,
     })
     console.log(that.data.currentSelect)
    // var currentSelect=e.currentTarget.dataset.index;

    // if (e.currentTarget.dataset.index == 0) {
    //   if (this.data.addressData.length == 0) {
    //     wx.navigateTo({
    //       url: '../address-add/index',
    //     })
    //   } else {
    //     wx.navigateTo({
    //       url: '../address-add/details',
    //     })
    //   }
    // }
  },
  // 提交订单
  payments(e){
    var formid = e.detail.formId
    var that = this
    console.log('订单金额')
    console.log(e)
    var address = that.data.address;
    var openid = wx.getStorageSync('openid');//用户openid
    // var price = e.target.dataset.money;//存价格    
    var user_id = wx.getStorageSync('user_id');//用户id
    var currentSelect = that.data.currentSelect;
    var userName = that.data.userName;
    var tel = that.data.tel;
    var consignee = that.data.consignee;
    var ContactNum = that.data.ContactNum;

    if (currentSelect==0 ){
     if (!userName || !tel || !address){
        wx.showToast({
          title: '请填写收货人或者联系方式！',
          icon:'none',
        })
        return;
     }

   }
    if (currentSelect==1){
     if (!ContactNum || !consignee){
       wx.showToast({
         title: '请填写收货人或者联系电话',
         icon:'none',
       })
       return;
     }
   }
    if (currentSelect == 'undefined' || currentSelect == undefined){
     wx.showToast({
       title: '请选择收货方式',
       icon:"none"
     })
     return;
   }
    console.log(e.detail.target.dataset.money)
    app.util.request({
      url: 'entry/wxapp/Orderarr',
      'cachetime': '30',
      data: { 
        openid: openid,
        price: e.detail.target.dataset.money
         },
      success: function (res) {
        console.log(res)
        wx.setStorageSync('prepay_id', res.data.prepay_id);
        // 订单支付成功后添加数据
        app.util.request({ 
          url: 'entry/wxapp/Order_zf',
          data: {
            user_id: user_id,//用户id
            // money: that.data.money,//金额
            guige: that.data.guige,//规格
            buyNumber: that.data.buyNumber,//数量
            price: e.detail.target.dataset.money,//实付金额
            consignee: that.data.consignee,//收货人
            ContactNum: that.data.ContactNum,//电话
            address: address,//地址
            currentSelect: currentSelect,//收货方式
            userName: userName,
            gid: that.data.gid,//商品id
            tel: tel,//买家电话
            message: that.data.buy_message,//买家留言

          },
          success: function (o) {
            console.log('添加成功')
            console.log(o)
            var order_id = o.data;
            // wx.redirectTo({
            // url: '../ticketdetail/ticketdetail'
            // })
            console.log(res)

            wx.requestPayment({
              'timeStamp': res.data.timeStamp,
              'nonceStr': res.data.nonceStr,
              'package': res.data.package,
              'signType': 'MD5',
              'paySign': res.data.paySign,
              success: function (res) {
                console.log('支付数据')
                console.log(res)
                wx.showToast({
                  title: '支付成功',
                  icon: 'success',
                  duration: 2000
                })

                var prepay_id = wx.getStorageSync('prepay_id');//用户prepay_id
                console.log(prepay_id)
                // 发送模板消息
                app.util.request({
                  'url': 'entry/wxapp/AccessToken',
                  'cachetime': '0',
                  success: function (res1) {
                    
                    console.log(res1.data)
                    console.log(that.data.gid)
                        app.util.request({
                          'url': 'entry/wxapp/Send',
                          'cachetime': '0',                    
                          data:{
                            access_token: res1.data.access_token,//这是支付成功之后获取的参数  
                            // template_id: 'lfWgwvyr7v18AOhAafjQ4FPME3KbMDhP6R9Xqh5Liws',
                            template_id: that.data.template_order,
                            page: "yzkm_sun/pages/goodsDetails/goodsDetails?id=" + that.data.gid,
                            openid: openid,
                            gid: that.data.gid,
                            form_id: formid,
                            money: that.data.money,
                          },
                          success: function (res2) {
                            console.log(res2.data)
                                    // 修改数据库状态
                                    app.util.request({
                                      'url':'entry/wxapp/changeOrder',
                                      'cachetime':'0',
                                      data:{
                                        order_id: order_id,
                                        gid: that.data.gid,
                                        money: that.data.money,
                                      },
                                      success:function(res3){
                                        console.log(res3)
                                        if(res3.data !=''){
                                          // wx.navigateTo({
                                          //   url: '../myOrder/myOrder',
                                          // })
                                        }
                                      }
                                    })
                          }
                        })
                  }
                })
                wx.navigateTo({
                  url: '../myOrder/myOrder',
                })
              }
            })
          }
        })


      }
    })   
  },
  // 跳转地址页面
  goAddress(e){
    if(e.currentTarget.dataset.statu=="no"){
      wx.navigateTo({
        url: '../address-add/index',
      })
    }else{
      wx.navigateTo({
        url: '../myAddress/myAddress',
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
    var that = this
    wx.getStorage({
      key: 'addNew',
      success: function (res) {
        console.log(res)
        that.setData({
          addNew: [res.data]
        })
        console.log(that.data)
      },
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
  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '提交订单',
    })
  },

})