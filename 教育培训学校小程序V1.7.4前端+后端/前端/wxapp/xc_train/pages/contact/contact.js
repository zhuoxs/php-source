var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../contact/contact"
    },
    call: function() {
        var a = this.data.map;
        wx.makePhoneCall({
            phoneNumber: a.content.mobile
        });
    },
    map: function() {
        var a = this.data.map;
        wx.openLocation({
            latitude: parseFloat(a.content.latitude),
            longitude: parseFloat(a.content.longitude),
            name: a.content.address,
            address: a.content.address,
            scale: 28
        });
    },
    onLoad: function(n) {
        var o = this;
        t.config(o), t.theme(o), a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "map"
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                "" != t.data && o.setData({
                    map: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "map"
            },
            showLoading: !1,
            success: function(a) {
                var n = a.data;
                "" != n.data && (wx.stopPullDownRefresh(), t.setData({
                    map: n.data
                }));
            }
        });
    },
    onReachBottom: function() {}
});