var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        WaitPro: [],
        OverPro: []
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/AllPro",
            data: {
                openid: t,
                status: 2
            },
            success: function(t) {
                console.log(t);
                t.data.WaitPro;
                a.setData({
                    WaitPro: t.data.WaitPro,
                    OverPro: t.data.OverPro
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
    goTicketresults: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.oid;
        wx.setStorageSync("oid", e), wx.navigateTo({
            url: "../ticketresults/ticketresults?gid=" + a
        });
    }
});