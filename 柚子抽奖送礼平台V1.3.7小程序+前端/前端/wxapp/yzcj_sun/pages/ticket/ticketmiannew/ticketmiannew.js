var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        addnews: "",
        resAutomatic: [],
        resManual: [],
        resScene: [],
        imgUrls: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        url: [],
        notice: []
    },
    onLoad: function(t) {
        wx.showLoading({
            title: "加载中"
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/SetTimeout",
            success: function(t) {
                if (console.log(t), 0 < t.data.length) for (var a = 0; a < t.data.length; a++) {
                    var e = t.data[a];
                    console.log(e + "这是gid"), o.AutoMessage(e);
                }
            }
        });
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        o.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : o.setData({
            isLogin: !0
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, t = wx.getStorageSync("users").openid;
        this.setData({
            adBtn: app.globalData.adBtn
        }), app.util.request({
            url: "entry/wxapp/Project",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data.addnews);
                var a = t.data.title.version ? t.data.title.version : "99999";
                if (console.log(app.siteInfo.version), a == app.siteInfo.version) var e = t.data.title.sj_audit; else if ("99999" == a) e = t.data.title.sj_audit; else e = 1;
                console.log(t), o.setData({
                    res: t.data.res,
                    support: t.data.support,
                    addnews: t.data.addnews.state,
                    msgList: t.data.resNews,
                    ad: t.data.ad,
                    popup: t.data.popup,
                    sponsor: t.data.sponsor,
                    imgUrls: t.data.imgUrls,
                    audit: e,
                    is_tel: t.data.title.is_tel,
                    cjzt: t.data.title.cjzt,
                    is_openzx: t.data.title.is_openzx,
                    bq_name: t.data.title.bq_name,
                    support_font: t.data.title.support_font,
                    support_logo: t.data.title.support_logo,
                    support_tel: t.data.title.support_tel,
                    cj: t.data.title.bargain_title,
                    sl: t.data.title.bargain_price,
                    auto_logo: t.data.title.auto_logo,
                    manu_logo: t.data.title.manu_logo,
                    gift_logo: t.data.title.gift_logo,
                    cj_logo: t.data.title.cj_logo,
                    cj_name: t.data.title.cj_name,
                    dt_logo: t.data.title.dt_logo,
                    dt_name: t.data.title.dt_name
                }), wx.setStorageSync("is_tel", t.data.title.is_tel), wx.setStorageSync("is_openzx", t.data.title.is_openzx), 
                wx.setStorageSync("auto", t.data.title.bq_name), wx.setStorageSync("manu", t.data.title.bargain_title), 
                wx.setStorageSync("cj_logo", t.data.title.cj_logo), t.data.title.pt_name && wx.setNavigationBarTitle({
                    title: t.data.title.pt_name
                }), o.getUrl();
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goTicketadd: function(t) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
        });
    },
    goTicketmy: function(t) {
        wx.reLaunch({
            url: "../ticketmy/ticketmy"
        });
    },
    goSponsor: function(t) {
        var a = this.data.sponsor;
        console.log(a), a ? wx.showToast({
            title: "用户已经是赞助商了",
            icon: "none",
            duration: 2e3
        }) : wx.navigateTo({
            url: "../sponsor/sponsor"
        });
    },
    goNewawardindex: function(t) {
        wx.reLaunch({
            url: "../newawardindex/newawardindex?is_tel=" + this.data.is_tel
        });
    },
    goRecordall: function(t) {
        wx.navigateTo({
            url: "../recordall/recordall"
        });
    },
    goGiftindex: function(t) {
        var a = this;
        console.log(a.data.is_tel), 1 == a.data.is_tel || 0 == a.data.is_tel ? wx.navigateTo({
            url: "../../gift/giftindex/giftindex"
        }) : wx.showToast({
            title: "送礼未开启！！！",
            icon: "none",
            duration: 1e3
        });
    },
    goTicketmiandetail: function(t) {
        var a = t.currentTarget.dataset.item;
        wx.navigateTo({
            url: "../ticketmiandetail/ticketmiandetail?gid=" + a
        });
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../psDetails/psDetails"
        });
    },
    AutoMessage: function(t) {
        var e = t;
        app.util.request({
            url: "entry/wxapp/AccessToken",
            cachetime: "0",
            success: function(t) {
                var a = t.data.access_token;
                app.util.request({
                    url: "entry/wxapp/AutoMessage",
                    cachetime: "0",
                    data: {
                        gid: e,
                        page: "yzcj_sun/pages/ticket/ticketresults/ticketresults?gid=" + e,
                        access_token: a
                    },
                    success: function(t) {
                        console.log("模板消息发送");
                    }
                });
            }
        });
    },
    bindGetUserInfo: function(t) {
        var e = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var o = t.detail.userInfo.nickName, n = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var a = t.code;
                console.log(a), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: a
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var a = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: a,
                                img: n,
                                name: o
                            },
                            success: function(t) {
                                console.log(t), e.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid), 
                                e.onShow();
                            }
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goCall: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.phone,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    goXcx: function(t) {
        var a = t.currentTarget.dataset.appid;
        if (null != t.currentTarget.dataset.url) var e = t.currentTarget.dataset.url; else e = "";
        console.log(e), wx.navigateToMiniProgram({
            appId: a,
            path: e,
            extraData: {
                foo: "bar"
            },
            envVersion: "develop",
            success: function(t) {
                console.log(t);
            }
        });
    },
    closeAd: function() {
        console.log(111), app.globalData.adBtn = !0, this.onShow();
    }
});