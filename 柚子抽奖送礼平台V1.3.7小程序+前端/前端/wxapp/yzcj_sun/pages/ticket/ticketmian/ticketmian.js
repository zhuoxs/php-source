var app = getApp();

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
        var a = this;
        app.util.request({
            url: "entry/wxapp/SetTimeout",
            success: function(t) {
                console.log(t);
            }
        });
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        a.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : a.setData({
            isLogin: !0
        });
    },
    changeindex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            navIndex: a
        });
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../psDetails/psDetails"
        });
    },
    goNewawardindex: function(t) {
        wx.navigateTo({
            url: "../newawardindex/newawardindex"
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
    goCircleindex: function(t) {
        var a = this;
        console.log(a.data.is_openzx), 1 == a.data.is_openzx || 0 == a.data.is_openzx ? wx.navigateTo({
            url: "../../circle/circleindex/circleindex"
        }) : wx.showToast({
            title: "功能未开启！！！",
            icon: "none",
            duration: 1e3
        });
    },
    closeAd: function() {
        console.log(111), app.globalData.adBtn = !0, this.onShow();
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
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
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
                var a = t.data.title.version ? t.data.title.version : "99999";
                if (console.log(app.siteInfo.version), a == app.siteInfo.version) var e = t.data.title.sj_audit; else if ("99999" == a) e = t.data.title.sj_audit; else e = 1;
                o.setData({
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
                wx.setStorageSync("auto_logo", t.data.title.auto_logo), wx.setStorageSync("auto_logo1", t.data.title.auto_logo1), 
                wx.setStorageSync("manu_logo", t.data.title.manu_logo), wx.setStorageSync("manu_logo1", t.data.title.manu_logo1), 
                t.data.title.pt_name && wx.setNavigationBarTitle({
                    title: t.data.title.pt_name
                }), o.getUrl();
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goSponsor: function(t) {
        wx.navigateTo({
            url: "../sponsor/sponsor"
        });
    },
    goTicketmiandetail: function(t) {
        var a = t.currentTarget.dataset.item;
        wx.navigateTo({
            url: "../ticketmiandetail/ticketmiandetail?gid=" + a
        });
    },
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
    onShareAppMessage: function(t) {
        if ("button" === t.from && console.log(t.target), "" == this.data.support[0].name) var a = "柚子抽奖"; else a = this.data.support[0].name;
        return {
            title: this.data.userInfo.nickName + "邀你参与[" + a + "]抽奖",
            path: "/yzcj_sun/pages/ticket/ticketmian/ticketmian?id=123",
            success: function(t) {},
            fail: function(t) {}
        };
    },
    goRecordall: function(t) {
        wx.navigateTo({
            url: "../recordall/recordall"
        });
    }
});