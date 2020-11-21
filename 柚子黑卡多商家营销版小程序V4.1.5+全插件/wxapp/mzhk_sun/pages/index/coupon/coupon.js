function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        banner: [],
        url: [],
        navTile: "优惠券",
        curIndex: 0,
        nav: [ "进行中", "往期活动" ],
        page: 1,
        coupon: [],
        adflashimg: [],
        couponcate: []
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        });
        var n = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: n.fontcolor ? n.fontcolor : "#000000",
            backgroundColor: n.color ? n.color : "#FFFFFF",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 16
            },
            success: function(t) {
                var a = t.data;
                e.setData({
                    adflashimg: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getCouponCate",
            cachetime: "30",
            success: function(t) {
                var a = t.data;
                2 != a && e.setData({
                    couponcate: a
                });
            }
        }), t.bid && e.setData({
            bid: t.bid
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    onReady: function() {
        var n = this;
        n.data.bid;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    data: {
                        lat: a,
                        lon: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t.data);
                        var a = t.data;
                        2 != a && n.setData({
                            coupon: a
                        });
                    }
                });
            }
        });
    },
    onShow: function() {},
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var n = this, o = n.data.bid, r = n.data.coupon, i = n.data.page, c = n.data.curIndex;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    cachetime: "30",
                    data: {
                        lat: a,
                        lon: e,
                        bid: o,
                        page: i,
                        openid: wx.getStorageSync("openid"),
                        cid: c
                    },
                    success: function(t) {
                        if (console.log("活动数据"), console.log(t.data), 2 != t.data) {
                            var a = t.data;
                            r = r.concat(a), n.setData({
                                coupon: r,
                                page: i + 1
                            });
                        } else wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        });
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {},
    navTap: function(t) {
        var o = this, r = o.data.bid, i = parseInt(t.currentTarget.dataset.index);
        console.log(o.data.curIndex);
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a, e = t.latitude, n = t.longitude;
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    cachetime: "30",
                    data: (a = {
                        lat: e,
                        lon: n,
                        cid: i
                    }, _defineProperty(a, "cid", i), _defineProperty(a, "bid", r), _defineProperty(a, "bid", r), 
                    _defineProperty(a, "page", 0), _defineProperty(a, "openid", wx.getStorageSync("openid")), 
                    a),
                    success: function(t) {
                        console.log("活动数据"), console.log(t.data);
                        var a = t.data;
                        2 == a ? o.setData({
                            coupon: [],
                            page: 0,
                            curIndex: i
                        }) : o.setData({
                            coupon: a,
                            page: 1,
                            curIndex: i
                        });
                    }
                });
            }
        });
    },
    towelfare: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../welfare/welfare?id=" + a
        });
    }
});