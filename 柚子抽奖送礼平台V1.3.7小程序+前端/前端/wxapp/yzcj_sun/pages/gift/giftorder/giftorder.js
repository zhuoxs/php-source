var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navIndex: 0,
        giftList: []
    },
    onLoad: function(t) {
        var e = this, a = t.gid;
        t.oid;
        console.log(t.oid), e.setData({
            gid: a,
            soid: t.oid
        }), console.log(e.data.soid);
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
        }), e.getUrl();
    },
    bindGetUserInfo: function(t) {
        var a = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var n = t.detail.userInfo.nickName, o = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var e = t.code;
                console.log(e), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
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
                                console.log(t), a.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid), 
                                a.onShow();
                            }
                        });
                    }
                });
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
        });
    },
    goTicketmiandetail: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../ticket/ticketmiandetail/ticketmiandetail?gid=" + e
        });
    },
    goTicketresult: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../ticket/ticketresult/ticketresult?gid=" + e
        });
    },
    goTicketresults: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../ticket/ticketresults/ticketresults?gid=" + e
        });
    },
    goConfirm: function(t) {
        var e = this, a = t.currentTarget.dataset.oid;
        wx.showModal({
            title: "提示",
            content: "是否确认收货？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Confirm",
                    data: {
                        oid: a
                    },
                    success: function(t) {
                        e.onShow();
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, a = wx.getStorageSync("users").openid, t = e.data.gid, n = e.data.soid;
        console.log(t), console.log(n), null != t ? app.util.request({
            url: "entry/wxapp/AddOrder",
            data: {
                openid: a,
                gid: t,
                oid: n
            },
            success: function(t) {
                2 == t.data ? (wx.showToast({
                    title: "接收成功！",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    app.util.request({
                        url: "entry/wxapp/MyGift",
                        data: {
                            openid: a
                        },
                        success: function(t) {
                            console.log(t), e.setData({
                                giftList: t.data.res,
                                WaitPro: t.data.WaitPro,
                                LuckyPro: t.data.LuckyPro
                            });
                        }
                    });
                }, 2e3)) : 1 == t.data && (wx.showToast({
                    title: "接收失败！",
                    icon: "none",
                    duration: 2e3
                }), setTimeout(function() {
                    app.util.request({
                        url: "entry/wxapp/MyGift",
                        data: {
                            openid: a
                        },
                        success: function(t) {
                            console.log(t), e.setData({
                                giftList: t.data.res,
                                WaitPro: t.data.WaitPro,
                                LuckyPro: t.data.LuckyPro
                            });
                        }
                    });
                }, 2e3));
            }
        }) : app.util.request({
            url: "entry/wxapp/MyGift",
            data: {
                openid: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    giftList: t.data.res,
                    WaitPro: t.data.WaitPro,
                    LuckyPro: t.data.LuckyPro
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    changeIndex: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            navIndex: e
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../../ticket/ticketmiannew/ticketmiannew"
        });
    }
});