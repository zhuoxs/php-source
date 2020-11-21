var t, a, e = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), n = getApp();

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
    touchstart: function(a) {
        t = a.changedTouches[0].clientX;
    },
    touchend: function(e) {
        (a = e.changedTouches[0].clientX) - t > 120 ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : t - a > 0 && this.setData({
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
        var a = t.data.pindex, n = t.data.psize;
        e.default.get("arthome", {
            op: "getmore",
            pindex: a,
            psize: n
        }).then(function(a) {
            var e = t.data.list;
            1 == t.data.pindex && (e = []);
            var n = a;
            n.length < t.data.psize ? t.setData({
                list: e.concat(n),
                hasMore: !1
            }) : t.setData({
                list: e.concat(n),
                hasMore: !0,
                pindex: t.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var a = this, n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        a.setData({
            param: n,
            user: i
        }), 0 == n.openart && null == i && wx.redirectTo({
            url: "../login/login"
        }), e.default.get("arthome").then(function(t) {
            a.setData({
                catelist: t.catelist,
                catenav: t.catenav,
                slide: t.slide
            }), a.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../art/arthome"
                    });
                }
            });
        });
    },
    onReady: function() {
        n.util.footer(this);
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