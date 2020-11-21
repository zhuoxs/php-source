// yzkm_sun/pages/seller/seller.js

// 调用tabbar模板
const app = getApp()
var template = require('../template/template.js');

Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentTab: 0,
    currentIndex: 0,
    statusType: ["商家推荐", "最新入驻", "距离最近"],
    listHeight:0,    //动态获得高度
    num: 5,
    light: '',
    kong: '',
    user_id:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('查看是否有商家分类传过来')
    console.log(options)
    wx.setStorageSync('sjfl_id', options.id);
    this.diyWinColor();
    this.getWindowHeight();
    var that = this;
    var openid = wx.getStorageSync('openid');//用户openid
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
    })

    app.util.request({
      url: 'entry/wxapp/User_id',
      data: {
        openid: openid,
      },
      success: function (res) {
        console.log('查看用户id');
        console.log(res);
        that.setData({
          user_id: res.data.id,
        })
      }
    })

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
    })

    app.util.request({
      'url': 'entry/wxapp/Test',
      // 'cachetime':'30',
      'data': { openid: openid },
      success: function (res) {
        console.log('请求方法');
        that.setData({
          list: res.data,
        })
      }
    })
    app.util.request({
      'url': 'entry/wxapp/Custom_photo',
      success: function (res) {
        console.log('自定义数据显示');
        console.log(res.data);
        var url = wx.getStorageSync('url')
        template.tabbar("tabBar",1, that, res,url)//0表示第一个tabbar 
        // that.setData({

        // })
      }
    })
// 商家头部背景自定义图片数据请求  
    app.util.request({
      'url': 'entry/wxapp/Ground_sj',
      success: function (res) {
        console.log('自定顶部图片');
        console.log(res);
        that.setData({
          background: res.data.background
        })
      }
    })
  },
 //商家选项卡下标选择
  statusTap(e) {
    var that = this;
    var currentIndex = e.currentTarget.dataset.index;
    that.setData({
      currentIndex: e.currentTarget.dataset.index
    })
    that.onShow();
  },
  
  // 跳转商家详情页面
  toSellerDeatils(e) {
    console.log(e)
    wx.navigateTo({
      url: '../seller/details/details?id=' + e.currentTarget.dataset.id + '&&store_name=' + e.currentTarget.dataset.store_name,
    })
  },
  
  // 拨打电话
  makePhone(e) {
    console.log('电话的参数');
    console.log(e);
    var that = this;
    var tel = e.currentTarget.dataset.id;//当前点击的商家ID
    app.util.request({
      'url': 'entry/wxapp/Store_tel',
      data: {
        sj_id: tel,
      },
      success: function (res) {
        console.log('商电话请求');
        console.log(res);
        wx.makePhoneCall({
          phoneNumber: res.data[0].phone,
          success: function (e) {
            console.log("-----拨打电话成功-----")
          },
          fail: function (e) {
            console.log("-----拨打电话失败-----")
          }
        })
      }
    })
  },

  // 自定义顶部颜色
  diyWinColor(e) {
    wx.setNavigationBarColor({
      frontColor: '#ffffff',
      backgroundColor: '#ffb62b',
    })
    wx.setNavigationBarTitle({
      title: '商家',
    })
  },

  // 动态获得屏幕高度
  getWindowHeight(){
    var that = this
    // 获取系统信息
    wx.getSystemInfo({
      success: function (res) {
        console.log(res);
        // 可使用窗口宽度、高度
        console.log('height=' + res.windowHeight);
        console.log('width=' + res.windowWidth);
        // 计算主体部分高度,单位为px
        that.setData({
          // second部分高度 = 利用窗口可使用高度 - first部分高度（这里的高度单位为px，所有利用比例将300rpx转换为px）
          listHeight: (res.windowHeight - res.windowWidth / 750 * 300)+45
        })
      }
    })
  },

  // 点击我要入驻
  iWantRz(e){
    var that = this
    var user_id =that.data.user_id;//用户user_id
    console.log(user_id)
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
        } if (res.data.status == 2) {
          wx.showToast({
            title: '已通过审核无需重复申请....',
            icon: 'none',
          })
          return false;
        } else {
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

          wx.navigateTo({
            url: '../sjrz-Page/sjrz-Page',
          })
        }
      }
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

    var ctx = wx.createCanvasContext('myCanvas')


    ctx.setFillStyle('#ffb62b')
    ctx.setFontSize(12)

    // Draw guides
    ctx.beginPath()
    ctx.moveTo(0, 0)
    ctx.stroke()

    // Draw quadratic curve
    ctx.beginPath()
    ctx.moveTo(0, 0)
    ctx.bezierCurveTo(30, 30, 345, 30, 375, 0)
    ctx.setStrokeStyle('#ffb62b')
    ctx.stroke()
    ctx.fill()
    ctx.draw()


  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

    // template.tabbar("tabBar", 1, this)//0表示第一个tabbar 
    var that = this;
    // that.getUserInfo();
    // that.wxauthSetting();
    // template.tabbar("tabBar", 1, that)//0表示第一个tabbar 
    var currentIndex = that.data.currentIndex;
    var sjfl_id = wx.getStorageSync('sjfl_id');//商家分类id   
    console.log(currentIndex)
    console.log(sjfl_id)
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success: function (res) {
        var latitude = res.latitude
        var longitude = res.longitude
        console.log(latitude)
        console.log(longitude)
        app.util.request({
          'url': 'entry/wxapp/Store_xxk',
          data: {
            sjfl_id: sjfl_id,
            latitude: latitude,
            longitude: longitude,
            currentIndex: currentIndex,
          },
          success: function (res) {
            console.log('商家数据请求');
            console.log(res);

            that.setData({
              list1: res.data,
              // light: res.data.light,
              // kong: res.data.kong,
            })
          }
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
  
  }
})