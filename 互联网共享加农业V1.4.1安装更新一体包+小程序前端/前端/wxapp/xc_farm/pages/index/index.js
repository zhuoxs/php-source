var common = require("../common/common.js"), app = getApp();

function toEscape(a) {
    for (var n = 0; n < a.length; n++) "" != a[n].link && null != a[n].link && (-1 != a[n].link.indexOf("../") || (-1 != a[n].link.indexOf("http") ? a[n].link = "../link/link?&url=" + escape(a[n].link) : a[n].link = a[n].link.split(",")));
    return a;
}

Page({
    data: {
        navHref: "../index/index",
        ad_show: !0
    },
    error: function(a) {
        this.setData({
            ad_show: !1
        });
    },
    adLoad: function(a) {
        this.setData({
            ad_show: !0
        });
    },
    link: function(a) {
        var n = a.currentTarget.dataset.index;
        if ("" != n && null != n) {
            var t = escape(n);
            wx.navigateTo({
                url: "../link/link?&url=" + t
            });
        }
    },
    join: function() {
        common.is_bind(function() {
            wx.navigateTo({
                url: "../jointwork/jointwork"
            });
        });
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            version: app.globalData.version
        }), common.config(t), "" != a.fen_openid && null != a.fen_openid && t.setData({
            fen_openid: a.fen_openid
        }), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "index"
            },
            success: function(a) {
                var n = a.data;
                "" != n.data && ("" != n.data.banner && null != n.data.banner && (n.data.banner = toEscape(n.data.banner)), 
                "" != n.data.cube && null != n.data.cube && (n.data.cube = toEscape(n.data.cube)), 
                t.setData({
                    xc: n.data
                }));
            }
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "index"
            },
            success: function(a) {
                var n = a.data;
                wx.stopPullDownRefresh(), "" != n.data && ("" != n.data.banner && null != n.data.banner && (n.data.banner = toEscape(n.data.banner)), 
                "" != n.data.cube && null != n.data.cube && (n.data.cube = toEscape(n.data.cube)), 
                t.setData({
                    xc: n.data
                }));
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, n = app.config.webname, t = "";
        return "" != a.data.config.share_title && null != a.data.config.share_title && (n = a.data.config.share_title), 
        "" != a.data.config.share_img && null != a.data.config.share_img && (t = a.data.config.share_img), 
        {
            title: n,
            imageUrl: t,
            path: "/xc_farm/pages/index/index",
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    },
    share: function() {
        wx.showToast({
            title: "分享成功"
        });
    },
    submit: function() {
        this.setData({
            success: !0
        });
    },
    submit_no: function() {
        this.setData({
            success: !1
        });
    }
});