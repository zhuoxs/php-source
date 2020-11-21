var common = require("../common/common.js"), app = getApp();

Page({
    data: {},
    map: function() {
        var a = this;
        wx.openLocation({
            name: a.data.list.map.name,
            latitude: parseFloat(a.data.list.map.latitude),
            longitude: parseFloat(a.data.list.map.longitude),
            scale: 28
        });
    },
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
        var e = this;
        common.config(e), e.setData({
            openid: a.openid
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_apply",
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_apply",
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && e.setData({
                    list: t.data
                });
            }
        });
    },
    onReachBottom: function() {}
});