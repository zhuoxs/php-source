var _util = require("../../../../style/utils/util.js"), app = getApp();

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 0,
            observer: function(e, t) {}
        }
    },
    data: {
        tabBar: [ {
            pagePath: "/yzcyk_sun/pages/index/index",
            text: "首页",
            iconPath: "/style/images/index.png",
            selectedIconPath: "/style/images/indexSele.png",
            selectedColor: "#ff5e5e",
            active: !0
        }, {
            pagePath: "/yzcyk_sun/pages/punch/punch",
            text: "打卡",
            iconPath: "/style/images/punch.png",
            selectedIconPath: "/style/images/punchSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/member/member",
            text: "亲子卡",
            iconPath: "/style/images/qzk.png",
            selectedIconPath: "/style/images/qzk.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/shop/shop",
            text: "好店",
            iconPath: "/style/images/shop.png",
            selectedIconPath: "/style/images/shopSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/user/user",
            text: "我的",
            iconPath: "/style/images/user.png",
            selectedIconPath: "/style/images/userSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        } ]
    },
    attached: function() {
        this.getTab(), app.globalData.isIpx && this.setData({
            isIpx: app.globalData.isIpx
        });
    },
    methods: {
        getTab: function() {
            var t = this, e = (t.data.tabBar, wx.getStorageSync("tab")), a = getCurrentPages(), s = a[a.length - 1].route;
            t.setData({
                url: "/" + s
            }), "" == e || null == e ? app.util.request({
                url: "entry/wxapp/getCustomize",
                cachetime: "0",
                success: function(e) {
                    wx.setStorageSync("tab", e.data.tab), t.setData({
                        tabBar: e.data.tab
                    });
                }
            }) : t.setData({
                tabBar: e
            });
        },
        tabChange: function(e) {
            var t = e.currentTarget.dataset.index, a = this.data.tabBar[t].url;
            "/yzcyk_sun/pages/index/index" == a || "/yzcyk_sun/pages/shop/shop" == a || "/yzcyk_sun/pages/punch/punch" == a || "/yzcyk_sun/pages/user/user" == a || "/yzcyk_sun/pages/active/active" == a ? wx.reLaunch({
                url: a
            }) : wx.navigateTo({
                url: a
            });
        }
    }
});