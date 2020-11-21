var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navIndex: 0,
        WaitPro: [],
        OverPro: [],
        FailPro: []
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/AllPro",
            data: {
                openid: t,
                status: 1
            },
            success: function(t) {
                console.log(t);
                t.data.WaitPro;
                a.setData({
                    WaitPro: t.data.WaitPro,
                    OverPro: t.data.OverPro,
                    FailPro: t.data.FailPro,
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
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            navIndex: a
        });
    },
    goTicketmiandetail: function(t) {
        var a = t.currentTarget.dataset.gid;
        t.currentTarget.dataset.oid;
        wx.navigateTo({
            url: "../ticketmiandetail/ticketmiandetail?gid=" + a
        });
    },
    goTicketresults: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketresults/ticketresults?gid=" + a
        });
    }
});