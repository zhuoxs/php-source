var app = getApp(), eatvisit = require("../eatvisit.js");

Page({
    data: {
        curIndex: 0,
        whichone: 2,
        nav: [ "待使用", "已使用", "已过期" ],
        award: [ "特等奖", "一等奖", "二等奖", "三等奖", "四等奖" ],
        pages: [ 1, 1, 1 ],
        orderlist: []
    },
    onLoad: function(a) {
        var t = this, e = eatvisit.eattabname(app, t);
        t.setData({
            eattabname: e
        }), app.util.request({
            url: "entry/wxapp/GetPlatformInfo",
            data: {
                m: "yzhyk_sun"
            },
            success: function(a) {
                console.log(a), t.setData({
                    setting: a.data
                }), wx.setNavigationBarColor({
                    frontColor: 1 == a.data.app_fcolor ? "#000000" : "#ffffff",
                    backgroundColor: a.data.app_bcolor ? a.data.app_bcolor : "#ffffff"
                });
            }
        });
    },
    onReady: function() {
        var o = this;
        app.get_user_info().then(function(a) {
            var t = a.openid, e = a;
            app.util.request({
                url: "entry/wxapp/GetOrder",
                data: {
                    openid: t,
                    uid: e.id,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(a) {
                    if (console.log(a.data), 2 != a.data) {
                        var t = a.data.url, e = a.data.orderlist;
                        o.setData({
                            goodsurl: t,
                            orderlist: e
                        });
                    } else o.setData({
                        orderlist: []
                    });
                }
            });
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var s = this;
        app.get_user_info().then(function(a) {
            var o = s.data.curIndex, t = a.openid, e = a, n = s.data.orderlist, i = s.data.pages, r = i[o];
            app.util.request({
                url: "entry/wxapp/GetOrder",
                data: {
                    openid: t,
                    uid: e.id,
                    status: o,
                    page: r,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(a) {
                    if (console.log(a.data), 2 != a.data) {
                        var t = a.data.url, e = a.data.orderlist;
                        n = n.concat(e), i[o] = r + 1, s.setData({
                            goodsurl: t,
                            orderlist: n,
                            pages: i
                        });
                    } else wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    });
                }
            });
        });
    },
    changeNav: function(i) {
        var r = this;
        app.get_user_info().then(function(a) {
            var t = i.currentTarget.dataset.index, e = a.openid, o = a, n = [ 1, 1, 1 ];
            app.util.request({
                url: "entry/wxapp/GetOrder",
                data: {
                    openid: e,
                    uid: o.id,
                    status: t,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(a) {
                    if (console.log(a.data), 2 != a.data) {
                        var t = a.data.url, e = a.data.orderlist;
                        r.setData({
                            goodsurl: t,
                            orderlist: e,
                            pages: n
                        });
                    } else r.setData({
                        orderlist: [],
                        pages: n
                    });
                }
            }), r.setData({
                curIndex: t
            });
        });
    },
    toMycouponDet: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/pages/plugin/eatvisit/mycoupondet/mycoupondet?id=" + t
        });
    }
});