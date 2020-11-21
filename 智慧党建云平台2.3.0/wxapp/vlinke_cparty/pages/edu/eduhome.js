function t(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var e, a, n = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), i = getApp();

Page({
    data: {
        catelist: [],
        catenav: [],
        slide: [],
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: [],
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(t) {
        e = t.changedTouches[0].clientX;
    },
    touchend: function(t) {
        (a = t.changedTouches[0].clientX) - e > 120 ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : e - a > 0 && this.setData({
            display: "none",
            translate: ""
        });
    },
    showview: function() {
        this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        });
    },
    hideview: function() {
        this.setData({
            display: "none",
            translate: ""
        });
    },
    getMore: function() {
        var t = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = t.data.user.id, a = t.data.pindex, i = t.data.psize;
        n.default.get("eduhome", {
            op: "getmore",
            userid: e,
            pindex: a,
            psize: i
        }).then(function(e) {
            var a = t.data.list;
            1 == t.data.pindex && (a = []);
            var n = e;
            n.length < t.data.psize ? t.setData({
                list: a.concat(n),
                hasMore: !1
            }) : t.setData({
                list: a.concat(n),
                hasMore: !0,
                pindex: t.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(e) {
        var a = this, i = wx.getStorageSync("param"), o = wx.getStorageSync("user");
        a.setData({
            param: i,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        }), n.default.get("eduhome").then(function(e) {
            var n;
            a.setData((n = {
                catelist: e.catelist,
                catenav: e.catenav,
                slide: e.slide,
                edustudy: e.edustudy
            }, t(n, "slide", e.slide), t(n, "edulessontol", e.edulessontol), n)), a.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../edu/eduhome"
                    });
                }
            });
        });
    },
    onReady: function() {
        i.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.data.pindex = 1, this.getMore();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        });
    },
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});