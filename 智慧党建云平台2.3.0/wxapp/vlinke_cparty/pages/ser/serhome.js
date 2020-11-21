var t, e, a = function(t) {
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
    touchstart: function(e) {
        t = e.changedTouches[0].clientX;
    },
    touchend: function(a) {
        (e = a.changedTouches[0].clientX) - t > 120 ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : t - e > 0 && this.setData({
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
        var e = t.data.user.branchid, n = t.data.pindex, i = t.data.psize;
        a.default.get("serhome", {
            op: "getmore",
            branchid: e,
            pindex: n,
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
    onLoad: function(t) {
        var e = this, n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        e.setData({
            param: n,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        }), a.default.get("serhome").then(function(t) {
            e.setData({
                catelist: t.catelist,
                catenav: t.catenav,
                slide: t.slide
            }), e.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../ser/serhome"
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