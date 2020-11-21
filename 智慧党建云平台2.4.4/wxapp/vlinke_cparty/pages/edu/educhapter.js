var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var funtime, app = getApp(), userlist = [];

Page({
    data: {
        needtime: "剩余 0 秒"
    },
    funTime: function() {
        var a = this, n = a.data.educhapter.needtime, u = a.data.edulog.stutime, r = 0;
        funtime = setInterval(function() {
            if (u = parseInt(u) + 1, r = n - u, a.setData({
                needtime: "剩余 " + r + " 秒"
            }), u % 10 == 0 || r <= 0) {
                var e = a.data.educhapter.id, t = a.data.edulog.id;
                _request2.default.get("educhapter", {
                    op: "stutime",
                    chapterid: e,
                    logid: t,
                    needtime: n,
                    stutime: u
                });
            }
            r <= 0 && (clearInterval(funtime), a.setData({
                needtime: "已完成"
            }));
        }, 1e3);
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var u = e.id, r = n.id;
        _request2.default.get("educhapter", {
            id: u,
            userid: r
        }).then(function(e) {
            t.setData({
                educhapter: e.educhapter,
                edulesson: e.edulesson,
                educate: e.educate,
                edulog: e.edulog,
                educhapterall: e.educhapterall,
                prev: e.prev,
                next: e.next
            }), 0 != e.educhapter.link.length && wx.redirectTo({
                url: "../webview/webview?weburl=" + e.educhapter.link
            }), parseInt(e.educhapter.needtime) - parseInt(e.edulog.stutime) <= 0 ? t.setData({
                needtime: "已完成"
            }) : t.funTime(), console.log(e);
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
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});