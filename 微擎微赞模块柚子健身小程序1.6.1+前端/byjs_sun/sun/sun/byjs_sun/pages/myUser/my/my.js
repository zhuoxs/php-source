var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    user: {
     
    },
    back_img:'',
    myPic:'',
    tabBarList: [
      {
        state: false,
        url: 'goIndex',
        publish: false,
        text: "训练",
        iconPath: "/byjs_sun/resource/images/indexFooter/index.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/index-1.jpg"
      },
      {
        state: false,
        url: 'goChargeIndex',
        publish: false,
        text: "充能量",
        iconPath: "/byjs_sun/resource/images/indexFooter/charge.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/charge-1.jpg"
      },
      {
        state: true,
        url: 'goMy',
        publish: false,
        text: "我的",
        iconPath: "/byjs_sun/resource/images/indexFooter/my.jpg",
        selectedIconPath: "/byjs_sun/resource/images/indexFooter/my-1.jpg"
      }

    ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this 
    app.util.request({
      'url':'entry/wxapp/GetBackImg',
      'cachetime':0,
      success:function(res){
        that.setData({
          back_img:res.data
        })
      }
    })
    var users = wx.getStorageSync('users')
    //---------------------------------- 获取网址----------------------------------
    app.util.request({
      'url': 'entry/wxapp/url',
      'cachetime': '0',
      success: function (res) {
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
              that.setData({
                tabBarList: data1
              })
            } else {
              that.setData({
                tabBarList: data1
              })
            }

          }
        })

      }
    })
    // ----------------获取动态小图--------
    app.util.request({
      'url':'entry/wxapp/GetPic',
      'data':{
        user_id:users.id
      },
      'cachetime':0,
      success:function(res){
        that.setData({
          myPic:res.data
        })
      }
    }),

   
      //获取用户信息
      app.util.request({
        'url': 'entry/wxapp/My',
        'data': {
          user_id: wx.getStorageSync('users').id
        },
        'cachetime': 0,
        success: function (res) {
          console.log(res)
          that.setData({
            user:res.data.user
          })
        }
      })
      // 获取背景
      app.util.request({
        'url':'entry/wxapp/GetBackimg',
        'cachetime':0,
        success(res){
          that.setData({
            backimg:res.data
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
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 我的收货地址
   */
  myAddress: function () {
    var that=this
    wx.chooseAddress({
      success: function (res) {
        that.setData({
          userName:res.userName,
          postalCode: res.postalCode,
          provinceName: res.provinceName,
          cityName: res.cityName,
          countyName: res.countyName,
          detailInfo: res.detailInfo,
          nationalCode: res.nationalCode,
          telNumber: res.telNumber
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
   */
  onShareAppMessage: function () {

  },
  //自定义函数
  goMyOrder: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myOrder/myOrder',
    })
  },
  //我的动态
  myMoving: function () {
    
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myMoving/myMoving',
    })
  },
  //我的粉丝
  myFans: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myFans/myFans',
    })
  },
  //我的关注
  myAttention: function () {
    app.util.request({
      'url':'entry/wxapp/GetlitePic',
      'data':'',
      'cachetime':0,
      success:function(res){

      }
    })
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myAttention/myAttention',
    })
  },
  //我的预约
  myCollect: function () {
   
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myBespoke/myBespoke',
    })
  },
  //我的红包
  myFight: function () {
    wx.navigateTo({
      url: '/byjs_sun/pages/myUser/myRedEnvelope/myRedEnvelope',
    })
  },
  //商家入口
  goBusiness: function(){
    wx.navigateTo({
      url: '/byjs_sun/pages/business/bussinessLogin/bussinessLogin',
    })
  },
  // 拨打电话
  call: function () {
    var that = this
    app.util.request({
      'url':'entry/wxapp/GetPhone',
      'cachetime':0,
      success:function(res){
          that.setData({
            phoneNumber:res.data
          })
      }
    })
    wx.makePhoneCall({
        phoneNumber: that.data.phoneNumber, //此号码并非真实电话号码，仅用于测试  
      success: function () {
        console.log("拨打电话成功！")
      },
      fail: function () {
      
        console.log("拨打电话失败！")
      }
    })
  }  
})