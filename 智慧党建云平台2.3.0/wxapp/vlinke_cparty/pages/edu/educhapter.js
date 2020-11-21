var e, t = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), a = getApp();

Page({
    data: {
        needtime: "剩余 0 秒"
    },
    funTime: function() {
        var a = this, n = a.data.educhapter.needtime, u = a.data.edulog.stutime, r = 0;
        e = setInterval(function() {
            if (u = parseInt(u) + 1, r = n - u, a.setData({
                needtime: "剩余 " + r + " 秒"
            }), u % 10 == 0 || r <= 0) {
                var i = a.data.educhapter.id, o = a.data.edulog.id;
                t.default.get("educhapter", {
                    op: "stutime",
                    chapterid: i,
                    logid: o,
                    needtime: n,
                    stutime: u
                });
            }
            r <= 0 && (clearInterval(e), a.setData({
                needtime: "已完成"
            }));
        }, 1e3);
    },
    onLoad: function(e) {
        var a = this, n = wx.getStorageSync("param") || null, u = wx.getStorageSync("user") || null;
        a.setData({
            param: n,
            user: u
        }), null == u && wx.redirectTo({
            url: "../login/login"
        });
        var r = e.id, i = u.id;
        t.default.get("educhapter", {
            id: r,
            userid: i
        }).then(function(e) {
            a.setData({
                educhapter: e.educhapter,
                edulesson: e.edulesson,
                educate: e.educate,
                edulog: e.edulog,
                educhapterall: e.educhapterall,
                prev: e.prev,
                next: e.next
            }), 0 != e.educhapter.link.length && wx.redirectTo({
                url: "../webview/webview?weburl=" + e.educhapter.link
            }), parseInt(e.educhapter.needtime) - parseInt(e.edulog.stutime) <= 0 ? a.setData({
                needtime: "已完成"
            }) : a.funTime(), console.log(e);
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../edu/eduhome"
                    });
                }
            }), console.log(e);
        });
    },
    onReady: function() {
        a.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});