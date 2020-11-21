var app = getApp();

Page({
    data: {
        navTile: "我的",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        app.editTabBar();
        var a = this;
        a.reload(), wx.setNavigationBarTitle({
            title: a.data.navTile
        }), console.log(t);
        var e = getCurrentPages(), o = e[e.length - 1].route;
        console.log("当前路径为:" + o), a.setData({
            current_url: o
        });
    },
    goTap: function(t) {
        console.log(t);
        var a = this;
        a.setData({
            current: t.currentTarget.dataset.index
        }), 0 == a.data.current && wx.redirectTo({
            url: "../index/index?currentIndex=0"
        }), 1 == a.data.current && wx.redirectTo({
            url: "../shop/shop?currentIndex=1"
        }), 2 == a.data.current && wx.redirectTo({
            url: "../active/active?currentIndex=2"
        }), 3 == a.data.current && wx.redirectTo({
            url: "../carts/carts?currentIndex=3"
        }), 4 == a.data.current && wx.redirectTo({
            url: "../user/user?currentIndex=4"
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("openid"), a = this;
        app.util.request({
            url: "entry/wxapp/is_hx_openid",
            cachetime: "0",
            data: {
                uid: t
            },
            success: function(t) {
                a.setData({
                    hx_openid: t.data
                });
            }
        });
    },
    reload: function(t) {
        var a = this, e = wx.getStorageSync("url");
        "" == e ? app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }) : a.setData({
            url: e
        });
        var o = wx.getStorageSync("settings");
        "" == o ? app.util.request({
            url: "entry/wxapp/Settings",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("settings", t.data), wx.setStorageSync("color", t.data.color), 
                wx.setStorageSync("fontcolor", t.data.fontcolor), wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), a.setData({
                    settings: t.data
                });
            }
        }) : (a.setData({
            settings: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }));
        var n = wx.getStorageSync("tab");
        "" == n ? app.util.request({
            url: "entry/wxapp/getCustomize",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("tab", t.data.tab), a.setData({
                    tab: t.data.tab
                });
            }
        }) : a.setData({
            tab: n
        }), app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                wx.setStorageSync("uid", t.data.id), a.setData({
                    uid: t.data.id,
                    nickname: t.data.name,
                    thumb: t.data.img
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toPivilege: function() {
        wx.navigateTo({
            url: "/yzmdwsc_sun/pages/user/ucenter/ucenter"
        });
    },
    toShopPay: function(t) {
        wx.navigateTo({
            url: "shoppay/shoppay"
        });
    },
    toCoupon: function(t) {
        wx.navigateTo({
            url: "coupon/coupon"
        });
    },
    toMyorder: function(t) {
        var a = t.currentTarget.dataset.index;
        wx.navigateTo({
            url: "myorder/myorder?index=" + a
        });
    },
    toMybook: function(t) {
        wx.navigateTo({
            url: "mybook/mybook"
        });
    },
    toMybargain: function(t) {
        wx.navigateTo({
            url: "mybargain/mybargain"
        });
    },
    toMygroup: function(t) {
        wx.navigateTo({
            url: "mygroup/mygroup"
        });
    },
    toShare: function(t) {
        wx.navigateTo({
            url: "share/share"
        });
    },
    toContact: function(t) {
        wx.navigateTo({
            url: "contact/contact"
        });
    },
    toBackstage: function(t) {
        wx.navigateTo({
            url: "../backstage/index/index"
        });
    },
    toCash: function(t) {
        wx.navigateTo({
            url: "../user/cash/cash"
        });
    },
    toAddress: function() {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                console.log(t), console.log("获取地址成功"), a.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {
                console.log("获取地址失败");
            }
        });
    },
    toTab: function(t) {
        var a = t.currentTarget.dataset.url;
        a = "/" + a, wx.redirectTo({
            url: a
        });
    },
    toRecharge: function(t) {
        wx.navigateTo({
            url: "/yzmdwsc_sun/pages/user/recharge/recharge"
        });
    }
});