function t(t, a) {
    t.appId;
    var n = t.timeStamp.toString(), e = t.package, o = t.nonceStr, i = t.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: n,
        nonceStr: o,
        package: e,
        signType: "MD5",
        paySign: i,
        success: function(t) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 2e3);
        },
        fail: function(t) {}
    });
}

var a = getApp(), n = require("../common/common.js");

Page({
    data: {},
    pay: function() {
        var n = this;
        a.util.request({
            url: "entry/wxapp/buyaudio",
            data: {
                id: n.data.id
            },
            success: function(a) {
                var n = a.data;
                "" != n.data && (1 == n.data.status ? (wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    });
                }, 2e3)) : 2 == n.data.status && ("" != n.data.errno && null != n.data.errno ? wx.showModal({
                    title: "错误",
                    content: n.data.message,
                    showCancel: !1
                }) : t(n.data)));
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        n.config(e), n.theme(e), e.setData({
            id: t.id
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio_detail",
                id: e.data.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    list: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        n.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});