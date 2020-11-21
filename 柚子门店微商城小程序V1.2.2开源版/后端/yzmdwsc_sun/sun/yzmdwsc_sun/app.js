App({
  siteInfo: require('siteinfo.js'),
  util: require('/we7/js/util.js'),
  onLaunch: function () {
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)
    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo
              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })
  },

  globalData: {
    userInfo: null,
    tabBar: {
      "color": "#9E9E9E",
      "selectedColor": "#f00",
      "backgroundColor": "#fff",
      "borderStyle": "#ccc",
      "list": [
        {
          "pagePath": "/yzmdwsc_sun/pages/index/index",
          "text": "首页",
          "iconPath": "/style/images/index.png",
          "selectedIconPath": "/style/images/indexSele.png",
          "selectedColor": "#ff7800",
          "active": true
        },
        {
          "pagePath": "/yzmdwsc_sun/pages/shop/shop",
          "text": "商店",
          "iconPath": "/style/images/shop.png",
          "selectedIconPath": "/style/images/shopSele.png",
          "selectedColor": "#ff7800",
          'active': false
        },
        {
          "pagePath": "/yzmdwsc_sun/pages/active/active",
          "text": "动态",
          "iconPath": "/style/images/active.png",
          "selectedIconPath": "/style/images/activeSele.png",
          "selectedColor": "#ff7800",
          "active": false
        },
        {
          "pagePath": "/yzmdwsc_sun/pages/carts/carts",
          "text": "购物车",
          "iconPath": "/style/images/carts.png",
          "selectedIconPath": "/style/images/cartSele.png",
          "selectedColor": "#ff7800",
          "active": false
        },
        {
          "pagePath": "/yzmdwsc_sun/pages/user/user",
          "text": "我的",
          "iconPath": "/style/images/user.png",
          "selectedIconPath": "/style/images/userSele.png",
          "selectedColor": "#ff7800",
          "active": false
        }
      ],
      "position": "bottom"
    },
  },
  editTabBar: function () {
    var _curPageArr = getCurrentPages();
    var _curPage = _curPageArr[_curPageArr.length - 1];
    var _pagePath = _curPage.__route__;
    if (_pagePath.indexOf('/') != 0) {
      _pagePath = '/' + _pagePath;
    }
    var tabBar = this.globalData.tabBar;
    for (var i = 0; i < tabBar.list.length; i++) {
      tabBar.list[i].active = false;
      if (tabBar.list[i].pagePath == _pagePath) {
        tabBar.list[i].active = true;//根据页面地址设置当前页面状态    
      }
    }
    _curPage.setData({
      tabBar: tabBar
    });
  },
})