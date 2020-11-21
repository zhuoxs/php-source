function t(t) {
    var t = t, n = new Object();
    if (-1 != t.indexOf("?")) for (var e = t.substr(1).split("&"), a = 0; a < e.length; a++) n[e[a].split("=")[0]] = unescape(e[a].split("=")[1]);
    return n;
}

var n = getApp(), e = require("../../../wxParse/wxParse.js"), a = require("../common/common.js");

Page({
    data: {},
    onLoad: function(o) {
        var i = this;
        a.config(i, n), a.theme(i, n);
        var s = t(unescape(o.url));
        "" != s.id && null != s.id && n.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "article",
                id: s.id
            },
            success: function(t) {
                var n = t.data;
                if ("" != n.data && (i.setData({
                    list: n.data,
                    url: unescape(o.url)
                }), 2 == n.data.link_type)) {
                    var a = n.data.content;
                    e.wxParse("content", "html", a, i, 5);
                }
            }
        });
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
        var t = this, n = "/xc_train/pages/about/link?&url=" + escape(t.data.url);
        return n = escape(n), {
            title: t.data.list.title + "-" + t.data.config.title,
            path: "/xc_train/pages/base/base?&share=" + n,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});