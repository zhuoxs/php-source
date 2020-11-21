var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        goId: 0,
        tabBarList: [ {
            state: !1,
            url: "goIndex",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !0,
            url: "goDrinks",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goPublish",
            publish: !1,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goDiscover",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goMy",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        } ],
        whichone: 8
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("bid");
        e || (e = t.bid, wx.setStorageSync("bid", e)), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = wx.getStorageSync("url");
        a.setData({
            url: n
        }), app.util.request({
            url: "entry/wxapp/drinktype",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    drinktype: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Banner",
            cachetime: "10",
            data: {
                location: 2
            },
            success: function(t) {
                a.setData({
                    drinks: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/DrinkMo",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(t) {
                a.setData({
                    drinkData: t.data
                });
            }
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                console.log(t.data);
                var a = e.data.tabBarList;
                a[0].text = t.data.index, a[0].iconPath = t.data.indeximg, a[0].selectedIconPath = t.data.indeximgs, 
                a[1].text = t.data.coupon, a[1].iconPath = t.data.couponimg, a[1].selectedIconPath = t.data.couponimgs, 
                a[2].text = t.data.fans, a[2].iconPath = t.data.fansimg, a[2].selectedIconPath = t.data.fansimgs, 
                a[3].text = t.data.find, a[3].iconPath = t.data.findimg, a[3].selectedIconPath = t.data.findimgs, 
                a[4].text = t.data.mine, a[4].iconPath = t.data.mineimg, a[4].selectedIconPath = t.data.mineimgs, 
                0 == t.data.is_fbopen ? a.splice(2, 2) : a = a, app.globalData.tabBarList = a, wx.setStorageSync("tab", t.data), 
                e.setData({
                    tabBarList: a,
                    tab: t.data
                });
            }
        });
    },
    goIndex: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    goPublish: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/publish/publish/publish"
        });
    },
    goDiscover: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/discover/discover/discover"
        });
    },
    goMy: function() {
        var t = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/my/my/my?bid=" + t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = wx.getStorageSync("bid");
        return "button" === res.from && console.log(res.target), {
            title: this.data.Card.title,
            path: "ymktv_sun/pages/drinks/drinks/drinks?bid=" + t,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    orderTab: function(t) {
        var a = this, e = Number(t.currentTarget.dataset.index), n = t.currentTarget.dataset.dtid, i = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/DrinkTypeData",
            cachetime: "0",
            data: {
                dtid: n,
                bid: i
            },
            success: function(t) {
                a.setData({
                    drinkData: t.data
                });
            }
        }), a.setData({
            goId: e
        });
    },
    goDrinksdetail: function(t) {
        var a = wx.getStorageSync("bid");
        wx.navigateTo({
            url: "../drinksdetail/drinksdetail?id=" + t.currentTarget.dataset.id + "&bid=" + a
        });
    },
    addGwc: function(t) {
        console.log("okokokokokokokkokoko");
        var a = t.currentTarget.dataset.id, e = wx.getStorageSync("bid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/CartData",
                    cachetime: "0",
                    data: {
                        id: a,
                        bid: e,
                        num: 1,
                        openid: t.data
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "成功加入购物车",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    goCar: function() {
        wx.navigateTo({
            url: "../car/car"
        });
    },
    wxalert: function(t) {
        var a = t.currentTarget.dataset.id, e = wx.getStorageSync("bid"), n = this.data.numvalue;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/CartData",
                    cachetime: "0",
                    data: {
                        id: a,
                        bid: e,
                        num: n,
                        openid: t.data
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "添加成功",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        }), this.closeplay();
    }
});