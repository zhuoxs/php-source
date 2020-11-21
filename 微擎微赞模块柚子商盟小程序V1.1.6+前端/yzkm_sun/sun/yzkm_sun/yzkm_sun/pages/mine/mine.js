// yzkm_sun/pages/mine/mine.js

// 调用tabbar模板
const app = getApp()
var template = require('../template/template.js');


Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentTab: 0,
    hideRuzhu: true, 
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that=this
    app.util.request({
      'url': 'entry/wxapp/Url',
      success: function (res) {
        console.log('页面加载请求')
        console.log(res);
        wx.setStorageSync('url', res.data);
        that.setData({
          url: res.data,
        })
      }
    }),
    app.util.request({
      'url': 'entry/wxapp/system',
      success: function (res) {
        console.log('****************************');
        console.log(res);
        wx.setStorageSync('system', res.data);
        wx.setNavigationBarColor({
          frontColor: res.data.color,
          backgroundColor: res.data.fontcolor,
          animation: {
            // duration: ,
            timingFunc: 'easeIn'
          }
        })
      }
    }),
    app.util.request({
      'url': 'entry/wxapp/Custom_photo',
      success: function (res) {
        console.log('自定义数据显示');
        console.log(res.data);
        var url = wx.getStorageSync('url')
        if (res.data.key == 0) {
          template.tabbar("tabBar", 4, that, res, url)//0表示第一个tabbar 
        } else {
          template.tabbar("tabBar", 2, that, res, url)//0表示第一个tabbar 
        }
        // that.setData({

        // })
      }
    })
  
    var openid = wx.getStorageSync('openid');//用户openid
    app.util.request({
      'url': 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          comment_xqy: res.data,
        })
        wx.setStorageSync('user_id', res.data.id);
      }
    })       
    that.diyWinColor();
  },
  // 管理入口，商家订单核销
  goToSeller(){
    var user_id = wx.getStorageSync('user_id');//用户当前用户id
    app.util.request({
      'url': 'entry/wxapp/Check_sj',
      data:{
        user_id: user_id,
      },
      success: function (res) {
        console.log('显示数据');
        console.log(res.data);
        // if (!res.data){
        //   wx.showToast({
        //     title: '已入驻商家才能进入',
        //     icon: 'none',
        //   })
        // }else{
            wx.navigateTo({
              url: '../manager/manager',
            })
        // }
        // that.setData({

        // })
      }
    })

    // wx.navigateTo({
    //   url: '../manager/manager',
    // })
  },
  // 跳转我的收藏页面
  goCollect(e){
    wx.navigateTo({
      url: './collect/collect',
    })
  },

  // 跳转我的优惠买单页面
  goPreferPay(e){
    wx.navigateTo({
      url: './prefer-pay/prefer-pay',
    })
  },

  // 跳转商家入驻页面
  goRuzhu(e){
    var that=this
    var user_id = wx.getStorageSync('user_id');//用户user_id
    app.util.request({
      // 是否已申请入驻
      url: 'entry/wxapp/Shen_qing',
      data: {
        user_id: user_id,
      },
      success: function (res) {
        console.log('判断入驻状态');
        console.log(res);
        if (res.data.status == 1) {//修改的地方
          wx.showToast({
            title: '正在审核中无需重复添加....',
            icon: 'none',
          })
          return false;
        }if (res.data.status == 2){
          wx.showToast({
            title: '已通过审核无需重复申请....',
            icon: 'none',
          })
          return false;
        }else {
              app.util.request({
                'url': 'entry/wxapp/Notice_rz',
                success: function (res) {
                  console.log('入驻需知');
                  console.log(res.data);
                  that.setData({
                    Notice: res.data.notice
                  })
                }
              })
              that.setData({
                hideRuzhu: false
              })


        }
      }
    })



  },


  // 点击申请入驻
  applyFor(e){
    wx.navigateTo({
      url: '../sjrz-Page/sjrz-Page',
    })  
  },

  // 关闭弹窗
  closePopupTap(e){
    this.setData({
      hideRuzhu: true
    })
  },

  // 跳转我的订单页面
  goMyOrder(e){
    console.log(e)
    wx.navigateTo({
      url: '../myOrder/myOrder?currentTab='+e.currentTarget.dataset.currenttab,
    })
  },

  // 跳转我的发布页面
  goMyFabu(e){
    wx.navigateTo({
      url: '../myFabu/myFabu',
    })
  },

  // 跳转我的收货地址页面
  goShipAddress(e){
    wx.navigateTo({
      url: '../myAddress/myAddress',
    })
  },

  // 跳转关于我们页面
  goAboutUs(e){
    wx.navigateTo({
      url: '../company-show/company-show',
    })
  },

  /*底部tab*/
  bindChange: function (e) {

    var that = this;
    that.setData({ currentTab: e.detail.current });

  },
  swichNav: function (e) {

    var that = this;

    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
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
      title: '我的',
    })
  },
  // 获取用户头像
  onShow: function () {
    this.getUserInfo();
    // template.tabbar("tabBar", 4, this)//0表示第一个tabbar 
  },
  getUserInfo: function () {
    var that = this;
    wx.login({
      success: function () {
        wx.getUserInfo({
          success: function (res) {
            console.log(res);
            that.setData({
              userInfo: res.userInfo
            });
          }
        })
      }
    })
  },
})