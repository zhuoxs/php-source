var app = getApp(), common = require("../common/common.js"), WxParse = require("../../../wxParse/wxParse.js");

function GetRequest(e) {
    e = e;
    var t = new Object();
    if (-1 != e.indexOf("?")) for (var n = e.substr(1).split("&"), a = 0; a < n.length; a++) t[n[a].split("=")[0]] = unescape(n[a].split("=")[1]);
    return t;
}

Page({
    data: {},
    onLoad: function(e) {
        var n = this;
        if (common.config(n), "" != e.url && null != e.url) {
            var t = unescape(e.url);
            console.log(t);
            var a = GetRequest(unescape(e.url));
            if (n.setData({
                url: t
            }), "" != a.id && null != a.id) app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: {
                    op: "article",
                    id: a.id
                },
                success: function(e) {
                    var t = e.data;
                    if ("" != t.data) {
                        if ("" != t.data.content && null != t.data.content && 2 == t.data.type) WxParse.wxParse("article", "html", t.data.content, n, 0);
                        n.setData({
                            list: t.data
                        });
                    }
                }
            }); else {
                n.setData({
                    list: {
                        type: 1
                    }
                });
            }
        }
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.config.webname,
            path: "/xc_farm/pages/link/link?&url=" + escape(this.data.url),
            success: function(e) {
                console.log(e);
            },
            fail: function(e) {
                console.log(e);
            }
        };
    }
});