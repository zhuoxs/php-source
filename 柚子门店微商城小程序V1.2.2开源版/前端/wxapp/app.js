App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    onLaunch: function() {
        var t = this, e = wx.getStorageSync("logs") || [];
        e.unshift(Date.now()), wx.setStorageSync("logs", e), wx.login({
            success: function(e) {}
        }), wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        t.globalData.userInfo = e.userInfo, t.userInfoReadyCallback && t.userInfoReadyCallback(e);
                    }
                });
            }
        });
    },
    onShow: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(e) {
                -1 != e.model.search("iPhone X") && (t.globalData.isIpx = !0);
            }
        });
    },
    globalData: {
        userInfo: null,
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/yzmdwsc_sun/pages/index/index",
                text: "首页",
                iconPath: "/style/images/index.png",
                selectedIconPath: "/style/images/indexSele.png",
                selectedColor: "#ff7800",
                active: !0
            }, {
                pagePath: "/yzmdwsc_sun/pages/shop/shop",
                text: "商店",
                iconPath: "/style/images/shop.png",
                selectedIconPath: "/style/images/shopSele.png",
                selectedColor: "#ff7800",
                active: !1
            }, {
                pagePath: "/yzmdwsc_sun/pages/active/active",
                text: "动态",
                iconPath: "/style/images/active.png",
                selectedIconPath: "/style/images/activeSele.png",
                selectedColor: "#ff7800",
                active: !1
            }, {
                pagePath: "/yzmdwsc_sun/pages/carts/carts",
                text: "购物车",
                iconPath: "/style/images/carts.png",
                selectedIconPath: "/style/images/cartSele.png",
                selectedColor: "#ff7800",
                active: !1
            }, {
                pagePath: "/yzmdwsc_sun/pages/user/user",
                text: "我的",
                iconPath: "/style/images/user.png",
                selectedIconPath: "/style/images/userSele.png",
                selectedColor: "#ff7800",
                active: !1
            } ],
            position: "bottom"
        },
        isIpx: !1
    },
    editTabBar: function() {
        var e = getCurrentPages(), t = e[e.length - 1], s = t.__route__;
        0 != s.indexOf("/") && (s = "/" + s);
        for (var a = this.globalData.tabBar, n = 0; n < a.list.length; n++) a.list[n].active = !1, 
        a.list[n].pagePath == s && (a.list[n].active = !0);
        t.setData({
            tabBar: a
        });
    }
});