var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        lettershow: !1,
        product: [],
        codePath: ""
    },
    onLoad: function(t) {
        var e = this;
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : e.setData({
            isLogin: !0
        });
        e = this;
        var a = t.gid;
        e.setData({
            gid: a
        }), setTimeout(function() {
            e.setData({
                txt: !0
            });
        }, 1e3);
    },
    onReady: function() {},
    onShow: function() {
        var c = this, t = c.data.gid, e = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/LuckyTicket",
            data: {
                openid: e,
                gid: t
            },
            success: function(t) {
                console.log(t), 2 == t.data.status2 ? c.setData({
                    lettershow: !0
                }) : c.setData({
                    lettershow: !1
                }), console.log(c.data.lettershow);
                for (var e = t.data, a = t.data.nickName, n = [], o = [], i = [], s = 0; s < a.length; s++) 1 == a[s].one ? n.push(a[s]) : 2 == a[s].one ? o.push(a[s]) : 3 == a[s].one && i.push(a[s]);
                c.setData({
                    product: e,
                    cjzt: e.cjzt,
                    ones: n,
                    twos: o,
                    three: i
                }), c.getUrl();
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url1", t.data), e.setData({
                    url1: t.data
                });
            }
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../ticketmiannew/ticketmiannew"
        });
    },
    goDiscount: function(t) {
        var e = this, a = t.currentTarget.dataset.oid, n = e.data.product.discount;
        wx.showModal({
            title: "提示",
            content: "是否将礼物折现成余额？折现金额为 " + n + " * 礼物价钱",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Discount",
                    cachetime: "0",
                    data: {
                        oid: a,
                        discount: n
                    },
                    success: function(t) {
                        e.onShow();
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    bindGetUserInfo: function(t) {
        var a = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var n = t.detail.userInfo.nickName, o = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var e = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var e = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: e,
                                img: o,
                                name: n
                            },
                            success: function(t) {
                                a.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goAddress: function(t) {
        var e = this.data.gid;
        wx.navigateTo({
            url: "../address/address?gid=" + e
        });
    },
    goEdAddress: function(t) {
        var e = this;
        console.log(t);
        var a = t.currentTarget.dataset.oid;
        app.util.request({
            url: "entry/wxapp/sure",
            cachetime: "0",
            data: {
                oid: a
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    goBalance: function(t) {
        wx.navigateTo({
            url: "../balance/balance"
        });
    },
    goTicketadd: function(t) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
        });
    },
    goTicketnum: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketnum/ticketnum?gid=" + e
        });
    },
    goTicketmy: function(t) {
        wx.navigateTo({
            url: "../ticketmy/ticketmy"
        });
    },
    goShishi: function(t) {
        wx.navigateTo({
            url: "../shishi/shishi"
        });
    },
    onShareAppMessage: function(t) {
        var e = this, a = (wx.getStorageSync("users").openid, e.data.gid), n = e.data.product.oid, o = e.data.product.pic ? e.data.url + "/" + e.data.product.pic : "../../../resource/images/banner.jpg";
        if ("button" === t.from) return console.log(t.target), {
            title: e.data.userInfo.nickName + "赠送您礼物 [" + e.data.product.gname + "]一份",
            path: "/yzcj_sun/pages/gift/giftorder/giftorder?gid=" + a + "&oid= " + n,
            imageUrl: o,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    goTicketmian: function(t) {
        wx.reLaunch({
            url: "../ticketmiannew/ticketmiannew"
        });
    },
    closeletter: function(t) {
        this.setData({
            lettershow: !1
        });
    },
    verification: function(t) {
        var e = this;
        console.log(e.data.product.orderNum), app.util.request({
            url: "entry/wxapp/cancelgoods",
            data: {
                ordernum: e.data.product.orderNum
            },
            success: function(t) {
                console.log(t), e.setData({
                    codePath: t.data
                });
            }
        });
    },
    hide: function(t) {
        this.setData({
            codePath: ""
        });
    }
});