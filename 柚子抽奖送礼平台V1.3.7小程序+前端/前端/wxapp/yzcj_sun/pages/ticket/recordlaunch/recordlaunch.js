var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navIndex: 0
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/IniPro",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    WaitPro: t.data.WaitPro,
                    cjzt: t.data.cjzt,
                    OverPro: t.data.OverPro,
                    FailPro: t.data.FailPro,
                    WaitPro1: t.data.WaitPro1,
                    OverPro1: t.data.OverPro1,
                    FailPro1: t.data.FailPro1
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
    goTicketresult: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketresult/ticketresult?gid=" + a
        });
    },
    goTicketresults: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketresults/ticketresults?gid=" + a
        });
    },
    goScene: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.uid, r = t.currentTarget.dataset.sid;
        wx.setStorageSync("gid", a), wx.setStorageSync("uid", e), wx.setStorageSync("sid", r), 
        wx.navigateTo({
            url: "../kaijiangbefore/kaijiangbefore"
        });
    },
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            navIndex: a
        });
    }
});