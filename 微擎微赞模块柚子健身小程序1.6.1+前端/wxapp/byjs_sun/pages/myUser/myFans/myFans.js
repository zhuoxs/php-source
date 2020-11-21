var app = getApp();

Page({
    data: {
        date: []
    },
    onLoad: function(t) {
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
    attention: function(t) {
        var a = this, e = wx.getStorageSync("users").id, n = t.currentTarget.dataset.fansid, s = t.currentTarget.dataset.is_attention;
        0 == s ? app.util.request({
            url: "entry/wxapp/ChangeFans",
            data: {
                user_id: e,
                fansid: n,
                is_attention: s
            },
            cachetime: 0,
            success: function(t) {
                a.onShow();
            }
        }) : app.util.request({
            url: "entry/wxapp/ChangeFans",
            data: {
                user_id: e,
                fansid: n,
                is_attention: s
            },
            cachetime: 0,
            success: function(t) {
                a.onShow();
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/GetFansList",
            data: {
                user_id: t
            },
            cachetime: 0,
            success: function(t) {
                a.setData({
                    date: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});