function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: {
        page: 1,
        whichone: 10
    },
    onLoad: function(a) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = wx.getStorageSync("url");
        this.setData({
            url: t
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        for (var t = this, a = app.globalData.tabBarList, e = 0; e < a.length; e++) a[e].state = !1;
        a[3].state = !0, t.setData({
            tabBarList: a
        });
        var n = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/Getactive",
            cachetime: "0",
            data: {
                openid: n
            },
            success: function(a) {
                console.log(a.data), t.setData({
                    active: a.data,
                    page: 1
                });
            }
        });
    },
    goIndex: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    goDrinks: function() {
        var a = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/drinks/drinks/drinks?bid=" + a
        });
    },
    goMy: function() {
        var a = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/my/my/my?bid=" + a
        });
    },
    goPublish: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/publish/publish/publish"
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading();
        this.onShow(), wx.hideNavigationBarLoading();
    },
    onReachBottom: function() {
        var e = this, a = wx.getStorageSync("userid"), n = e.data.page, i = (e.data.activeIndex, 
        e.data.active);
        wx.showLoading({
            title: "数据加载中"
        }), app.util.request({
            url: "entry/wxapp/Getactive",
            cachetime: "0",
            data: {
                openid: a,
                page: n
            },
            success: function(a) {
                if (2 == a.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var t = a.data;
                    i = i.concat(t), e.setData({
                        page: n + 1,
                        active: i
                    });
                }
            }
        });
    },
    tappraise: function(a) {
        var t = this, e = a.currentTarget.dataset.index, n = a.currentTarget.dataset.id, i = wx.getStorageSync("userid"), o = t.data.active;
        1 == o[e].iszan ? (o[e].iszan = 0, o[e].zanlen = o[e].zanlen - 1) : (o[e].iszan = 1, 
        o[e].zanlen = o[e].zanlen + 1), app.util.request({
            url: "entry/wxapp/clickzan",
            cachetime: "0",
            data: {
                openid: i,
                id: n
            },
            success: function(a) {
                t.setData({
                    active: o
                });
            }
        }), console.log(t.data.active);
    },
    attention: function(a) {
        for (var t = this, e = a.currentTarget.dataset.index, n = t.data.active[e].user_id, i = wx.getStorageSync("openid"), o = t.data.active, r = 0; r < o.length; r++) o[e].user_id == o[r].user_id && (1 == o[r].isfollow ? o[r].isfollow = 0 : o[r].isfollow = 1);
        app.util.request({
            url: "entry/wxapp/Follow",
            cachetime: "0",
            data: {
                openid: n,
                user_id: i
            },
            success: function(a) {
                t.setData({
                    active: o
                });
            }
        });
        var s = "peraonal[" + e + "].attention";
        t.setData(_defineProperty({}, s, o));
    },
    goDiscoverdetaill: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.setStorageSync("id", t), wx.navigateTo({
            url: "../discoverdetaill/discoverdetaill?id=" + a.currentTarget.dataset.id
        });
    }
});