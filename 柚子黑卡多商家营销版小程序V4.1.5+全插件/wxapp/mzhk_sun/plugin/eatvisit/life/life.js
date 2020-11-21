/*   time:2019-08-09 13:18:39*/
var app = getApp(),
    eatvisit = require("../../resource/js/eatvisit.js"),
    Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;
Page({
    data: {
        curIndex: 0,
        nav: ["火热进行中", "已抢完"],
        page: [1, 1],
        is_modal_Hidden: !0,
        whichone: 1,
        open_eatvisit: [],
        goodslist: [],
        eattabname: []
    },
    onLoad: function(t) {
        var o = this;
        t = app.func.decodeScene(t), o.setData({
            options: t
        });
        var a = eatvisit.eattabname(app, o);
        o.setData({
            eattabname: a
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data,
                    e = t.data.navname ? t.data.navname : "吃探";
                wx.setNavigationBarTitle({
                    title: e
                }), 2 != a ? o.setData({
                    eatvisit_set: a
                }) : wx.showModal({
                    title: "提示消息",
                    content: "吃探功能未开启",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/mzhk_sun/pages/inedx/index"
                        })
                    }
                })
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                o.setData({
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : ""
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "#000000",
                    backgroundColor: t.data.color ? t.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting()
    },
    onReady: function() {
        var s = this;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude,
                    e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetGoods",
                    cachetime: "30",
                    data: {
                        lat: a,
                        lon: e,
                        m: app.globalData.Plugin_eatvisit,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        if (console.log(t.data), 2 != t.data) {
                            var a = t.data.url,
                                e = t.data.goodslist,
                                o = t.data.status;
                            s.setData({
                                goodsstatus: o,
                                goodsurl: a,
                                goodslist: e
                            })
                        } else s.setData({
                            goodslist: []
                        })
                    }
                })
            }
        })
    },
    onShow: function() {
        app.func.islogin(app, this);
        var t = this.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id)
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var i = this,
            n = i.data.page,
            d = i.data.curIndex,
            u = n[d],
            r = i.data.goodslist;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude,
                    e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetGoods",
                    data: {
                        lat: a,
                        lon: e,
                        goodstype: d,
                        page: u,
                        m: app.globalData.Plugin_eatvisit,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        if (console.log(t.data), 2 != t.data) {
                            var a = t.data.url,
                                e = t.data.goodslist,
                                o = t.data.status,
                                s = r.concat(e);
                            n[d] = u + 1, i.setData({
                                goodsstatus: o,
                                goodsurl: a,
                                goodslist: s,
                                pages: n
                            })
                        } else wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        })
                    }
                })
            }
        })
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/plugin/eatvisit/life/life?d_user_id=" + wx.getStorageSync("users").id
        }
    },
    navTap: function(t) {
        var s = this,
            o = parseInt(t.currentTarget.dataset.index);
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude,
                    e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetGoods",
                    data: {
                        lat: a,
                        lon: e,
                        goodstype: o,
                        m: app.globalData.Plugin_eatvisit,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        if (console.log(t.data), 2 != t.data) {
                            var a = t.data.url,
                                e = t.data.goodslist,
                                o = t.data.status;
                            s.setData({
                                goodsstatus: o,
                                goodsurl: a,
                                goodslist: e,
                                pages: [1, 1]
                            })
                        } else s.setData({
                            goodslist: [],
                            pages: [1, 1]
                        })
                    }
                })
            }
        }), this.setData({
            curIndex: o
        })
    },
    toLifeDet: function(t) {
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (1 == t.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1
            }
        });
        var a = t.currentTarget.dataset.id,
            e = t.currentTarget.dataset.vip,
            o = wx.getStorageSync("openid");
        1 == e ? app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: o
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                if (0 == t.data.viptype) return wx.showToast({
                    title: "会员商品，请先购买会员",
                    icon: "none",
                    duration: 1e3
                }), !1;
                wx.navigateTo({
                    url: "/mzhk_sun/plugin/eatvisit/lifedet/lifedet?id=" + a
                })
            }
        }) : wx.navigateTo({
            url: "/mzhk_sun/plugin/eatvisit/lifedet/lifedet?id=" + a
        })
    }
});