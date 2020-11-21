var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {
        var n = this, t = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/MySponsor",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), n.setData({
                    sponsor: t.data
                }), n.getUrl();
            }
        });
    },
    getUrl: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    renewal: function(t) {
        var n = t.currentTarget.dataset.id, e = this;
        app.util.request({
            url: "entry/wxapp/renewal",
            data: {
                sid: n
            },
            success: function(t) {
                console.log(t), 1 == t.data ? (wx.showToast({
                    title: "申请成功，等待联系！",
                    icon: "success",
                    duration: 2e3
                }), e.onShow()) : wx.showToast({
                    title: "申请失败，重新尝试！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});