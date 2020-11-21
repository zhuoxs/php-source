// yzmdwsc_sun/pages/index/bookOrder/bookOrder.js
const app = getApp()
var flag=true;
var tool = require('../../../../style/utils/tools.js');  
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '订单确认',
    goodsDet:[
      {
        title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
        price: '399.00',
        src:"http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png"
      }
    ],
    multiArray: [],
    multiIndex: [0, 0],
    orderMoney:"0.01"/***预约定金 */
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
    var gid = options.gid;
    that.setData({
      'gid':gid
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
    //----------获取商品详情----------
    app.util.request({
      'url': 'entry/wxapp/GoodsDetails',
      'cachetime': '0',
      data: {
        id: gid,
      },
      success: function (res) {
        console.log(res)
        that.setData({
          goodinfo: res.data.data
        })
      }
    })


    var time = tool.formatTime(new Date());
    console.log(time)
    this.setData({
      multiArray: time
    });

  },


  //备注预约姓名
  uname: function (e) {
    var uname = e.detail;
    console.log(uname)
    this.setData({
      uname: uname,
    })
  },
  //预约手机号 
  phone: function (e) {
    var phone = e.detail;
    console.log(phone)
    this.setData({
      phone: phone,
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
  /**时间 */
  bindMultiPickerColumnChange: function (e) {   
    var data = {
      multiArray: this.data.multiArray,
      multiIndex: this.data.multiIndex,
    };
    console.log(e)
    data.multiIndex[e.detail.column] = e.detail.value;

    this.setData(data);
    this.setData({
      showtime: true
    });

  },
  formSubmit(e){
    var that=this;
    var uname=e.detail.value.uname;
    var phone = e.detail.value.phone;
    var time=e.detail.value.time;
    var showtime = that.data.showtime; 
    var remark=e.detail.value.remark;
    
    var warn = ""; 
  //  var flag = true;
 //   console.log(showtime)
    if (uname=='') {
      warn = "请输入您的姓名";
    } else if (!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
      warn = "请正确输入手机号码";
    } else if (showtime==null){
      warn = "请选择预约时间";
    } else {
      if(flag==true){
        console.log('---订单提交中---');
      //  flag="false";
        wx.getStorage({
          key: 'openid',
          success: function (res) {
            console.log('---下订单---');
            var openid = res.data; 
            app.util.request({
              'url': 'entry/wxapp/AddBookOrder',
              'cachetime': '0',
              data: {
                'uid':openid,
                'gid':that.data.gid,
                'yuyue_name':uname,
                'yuyue_phone':phone,
                'yuyue_time':time,
                'remark':remark,
              },
              success: function (res) {
                 console.log('获取支付参数');
                 var order_id=res.data;
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
                             mch_id: 0
                           },
                           success: function (res) {*/
                             wx.showToast({
                               title: '支付成功',
                               icon: 'success',
                               duration: 2000,
                               success: function () {

                               },
                               complete: function () {
                                 wx.navigateTo({
                                   url: '../../user/mybook/mybook',
                                 })
                               }, 
                             })

                        /*   }
                         })*/
                       },
                       'fail': function (result) {
                         flag=true;
                       }  
                     });

                   }
                 })
              
              }
            })
          }
        })

      }else{
      /*  wx.showModal({
          title: '提示',
          content: '订单提交中,请勿重新提交',
          showCancel: false
        });*/
      }
      flag = "false";
      /**提交支付 */
    }
    if (flag == true) {
      wx.showModal({
        title: '提示',
        content: warn,
        showCancel: false
      })
    }

  }
})