var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../user/user"
    },
    call: function() {
        var a = this.data.map;
        wx.makePhoneCall({
            phoneNumber: a.mobile
        });
    },
    map: function() {
        var a = this.data.map;
        wx.openLocation({
            latitude: parseFloat(a.latitude),
            longitude: parseFloat(a.longitude),
            name: a.address,
            address: a.address,
            scale: 28
        });
    },
    onLoad: function(a) {
        var e = this;
        t.config(e), t.theme(e), e.getData();
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData();
    },
    onReachBottom: function() {},
    getData: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "user"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                "" != e.data && ("" != e.data.map && null != e.data.map && t.setData({
                    map: e.data.map
                }), "" != e.data.user && null != e.data.user && t.setData({
                    user: e.data.user
                }), "" != e.data.share && null != e.data.share && t.setData({
                    share: e.data.share
                }));
            }
        });
    }
});