var common = require("../common/common.js"), app = getApp();

Page({
    data: {},
    call: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.list.mobile
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.list.imgs[t],
            urls: this.data.list.imgs
        });
    },
    onLoad: function(a) {
        var n = this;
        common.config(n), n.setData({
            openid: a.openid
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_apply2",
                openid: n.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && n.setData({
                    list: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_apply2",
                openid: n.data.openid
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && n.setData({
                    list: t.data
                });
            }
        });
    },
    onReachBottom: function() {}
});