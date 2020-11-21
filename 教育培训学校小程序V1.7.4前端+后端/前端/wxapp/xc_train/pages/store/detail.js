var a = getApp(), t = require("../common/common.js");

Page({
    data: {},
    call: function(a) {
        var t = this;
        wx.makePhoneCall({
            phoneNumber: t.data.list.mobile
        });
    },
    map: function(a) {
        var t = this;
        wx.openLocation({
            latitude: parseFloat(t.data.list.latitude),
            longitude: parseFloat(t.data.list.longitude),
            name: t.data.list.address,
            address: t.data.list.address,
            scale: 28
        });
    },
    qie: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    onLoad: function(n) {
        var e = this;
        t.config(e), t.theme(e), a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "school_detail",
                id: n.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
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
            url: "entry/wxapp/index",
            data: {
                op: "school_detail",
                id: t.data.list.id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var n = a.data;
                "" != n.data && t.setData({
                    list: n.data
                });
            }
        });
    },
    onReachBottom: function() {}
});