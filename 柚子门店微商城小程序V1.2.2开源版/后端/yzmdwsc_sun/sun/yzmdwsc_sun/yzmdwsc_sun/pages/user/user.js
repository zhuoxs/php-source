// yzmdwsc_sun/pages/user/user.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    navTile: '我的',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    app.editTabBar();  /**渲染tab */
    var that = this;
    that.reload();
    wx.setNavigationBarTitle({
      title: that.data.navTile
    });
    //获取当前路径
    var pages = getCurrentPages() //获取加载的页面
    var currentPage = pages[pages.length - 1] //获取当前页面的对象
    var current_url = currentPage.route;
    console.log('当前路径为:' + current_url);
    that.setData({
      current_url: current_url,
    })
    this.setData({
      current: options.currentIndex,
    })
    
    wx.getUserInfo({
      success: function (res) {
        that.setData({
          thumb: res.userInfo.avatarUrl,
          nickname: res.userInfo.nickName
        })
      }
    })
  },
  //底部链接
  goTap: function (e) {
    console.log(e);
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
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var openid = wx.getStorageSync('openid');
    var that=this;
    app.util.request({
      'url': 'entry/wxapp/is_hx_openid',
      'cachetime': '0',
      data: {
        uid: openid,
      },
      success(res) {
        that.setData({
          hx_openid:res.data,
        })
      }
    })
  },
  
  //相关信息记录操作
  reload: function (e) {
    var that = this
    //获取网址
    var url = wx.getStorageSync('url');
    if (url == '') {
      app.util.request({
        'url': 'entry/wxapp/Url',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync('url', res.data)
          that.setData({
            url: res.data
          })
        },
      })
    } else {
      that.setData({
        url: url,
      })
    }
    var settings = wx.getStorageSync('settings');
    if (settings == '') {
      app.util.request({
        'url': 'entry/wxapp/Settings',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync("settings", res.data);
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
          that.setData({
            settings: res.data,
          })
        }
      })
    } else {
      that.setData({
        settings: settings,
      })
      wx.setNavigationBarColor({
        frontColor: wx.getStorageSync('fontcolor'),
        backgroundColor: wx.getStorageSync('color'),
        animation: {
          duration: 0,
          timingFunc: 'easeIn'
        }
      })
    }
    //获取自定义图标
    var tab = wx.getStorageSync('tab');
    if (tab == '') {
      app.util.request({
        'url': 'entry/wxapp/getCustomize',
        'cachetime': '0',
        success: function (res) {
          wx.setStorageSync('tab', res.data.tab)
          that.setData({
            tab: res.data.tab,
          })
        }
      })
    } else {
      that.setData({
        tab: tab,
      })
    }




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
  toShopPay(e){
    wx:wx.navigateTo({
      url: 'shoppay/shoppay',
    })
  },
  toCoupon(e){
    wx: wx.navigateTo({
      url: 'coupon/coupon',
    })
  },
  toMyorder(e){
    var index=e.currentTarget.dataset.index;
    wx:wx.navigateTo({
      url: 'myorder/myorder?index='+index,
    })
  },
  toMybook(e) {
    wx: wx.navigateTo({
      url: 'mybook/mybook',
    })
  },
  toMybargain(e) {
    wx: wx.navigateTo({
      url: 'mybargain/mybargain',
    })
  },
  toMygroup(e) {
    wx: wx.navigateTo({
      url: 'mygroup/mygroup',
    })
  },
  toShare(e) {
    wx: wx.navigateTo({
      url: 'share/share',
    })
  },
  toContact(e) {
    wx: wx.navigateTo({
      url: 'contact/contact',
    })
  },
  toBackstage(e){
    wx: wx.navigateTo({
      url: '../backstage/index/index',
    })
  },
  toCash(e){
    wx: wx.navigateTo({
      url: '../user/cash/cash',
    })
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
  toTab(e) {
    var url = e.currentTarget.dataset.url;
    url = '/' + url;
    wx.redirectTo({
      url: url,
    })
  },
})