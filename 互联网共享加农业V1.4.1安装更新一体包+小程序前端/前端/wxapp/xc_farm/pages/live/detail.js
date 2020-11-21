var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(t) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "live_detail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                if ("" != a.data && (e.setData({
                    list: a.data
                }), "" != a.data.content && null != a.data.content)) WxParse.wxParse("article", "html", a.data.content, e, 0);
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
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "live_detail",
                id: e.data.list.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                "" != a.data && e.setData({
                    list: a.data
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.config.webname + "-" + this.data.list.name,
            path: "/xc_farm/pages/live/detail?&id=" + this.data.list.id,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});