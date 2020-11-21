/*   time:2019-08-09 13:18:39*/
var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page,
    app = getApp(),
    eatvisit = require("../../resource/js/eatvisit.js");
Page({
    data: {
        curIndex: 0,
        whichone: 2,
        nav: ["待使用", "已使用", "已过期"],
        award: ["特等奖", "一等奖", "二等奖", "三等奖", "四等奖"],
        pages: [1, 1, 1],
        orderlist: []
    },
    onLoad: function(a) {
        var t = eatvisit.eattabname(app, this);
        this.setData({
            eattabname: t
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "#000000",
                    backgroundColor: a.data.color ? a.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    onReady: function() {
        var o = this,
            a = wx.getStorageSync("openid"),
            t = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetOrder",
            data: {
                openid: a,
                uid: t.id,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url,
                        e = a.data.orderlist;
                    o.setData({
                        goodsurl: t,
                        orderlist: e
                    })
                } else o.setData({
                    orderlist: []
                })
            }
        })
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this,
            n = o.data.curIndex,
            a = wx.getStorageSync("openid"),
            t = wx.getStorageSync("users"),
            r = o.data.orderlist,
            s = o.data.pages,
            i = s[n];
        app.util.request({
            url: "entry/wxapp/GetOrder",
            data: {
                openid: a,
                uid: t.id,
                status: n,
                page: i,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url,
                        e = a.data.orderlist;
                    r = r.concat(e), s[n] = i + 1, o.setData({
                        goodsurl: t,
                        orderlist: r,
                        pages: s
                    })
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                })
            }
        })
    },
    changeNav: function(a) {
        var o = this,
            t = a.currentTarget.dataset.index,
            e = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            r = [1, 1, 1];
        app.util.request({
            url: "entry/wxapp/GetOrder",
            data: {
                openid: e,
                uid: n.id,
                status: t,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(a) {
                if (console.log(a.data), 2 != a.data) {
                    var t = a.data.url,
                        e = a.data.orderlist;
                    o.setData({
                        goodsurl: t,
                        orderlist: e,
                        pages: r
                    })
                } else o.setData({
                    orderlist: [],
                    pages: r
                })
            }
        }), this.setData({
            curIndex: t
        })
    },
    toMycouponDet: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/eatvisit/mycoupondet/mycoupondet?id=" + t
        })
    }
});