var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navIndex: 0,
        resAutomatic: []
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("cj_logo"), e = wx.getStorageSync("manu"), n = wx.getStorageSync("auto");
        "" == e || null == e ? this.setData({
            manu: "手动"
        }) : this.setData({
            manu: e
        }), "" == n ? this.setData({
            auto: "自动"
        }) : this.setData({
            auto: n
        }), this.setData({
            cj_logo: a,
            is_tel: t.is_tel
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("users").openid;
        this.setData({
            adBtn: app.globalData.adBtn
        }), app.util.request({
            url: "entry/wxapp/LuckyProject",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    resAutomatic: t.data.resAutomatic,
                    resManual: t.data.resManual,
                    resScene: t.data.resScene,
                    sponsor: t.data.sponsor,
                    cjzt: t.data.cjzt
                }), a.getUrl();
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
    goTicketmiandetail: function(t) {
        var a = t.currentTarget.dataset.item;
        wx.navigateTo({
            url: "../ticketmiandetail/ticketmiandetail?gid=" + a
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    changeindex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            navIndex: a
        });
    },
    goTicketadd: function(t) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
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
    goTicketmy: function(t) {
        wx.reLaunch({
            url: "../ticketmy/ticketmy"
        });
    },
    goTicketmain: function(t) {
        wx.reLaunch({
            url: "../ticketmiannew/ticketmiannew"
        });
    }
});