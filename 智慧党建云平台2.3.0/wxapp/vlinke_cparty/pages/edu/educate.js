var t, a, e = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), i = getApp();

Page({
    data: {
        cateid: 0,
        catelist: [],
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
        var a = t.data.user.id, i = t.data.cateid, n = t.data.stustatus, s = t.data.pindex, o = t.data.psize;
        e.default.get("educate", {
            op: "getmore",
            userid: a,
            cateid: i,
            stustatus: n,
            pindex: s,
            psize: o
        }).then(function(a) {
            var e = t.data.list;
            1 == t.data.pindex && (e = []);
            var i = a;
            i.length < t.data.psize ? t.setData({
                list: e.concat(i),
                hasMore: !1
            }) : t.setData({
                list: e.concat(i),
                hasMore: !0,
                pindex: t.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var a = this, i = wx.getStorageSync("param"), n = wx.getStorageSync("user");
        a.setData({
            param: i,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var s = t.cateid, o = t.stustatus;
        a.setData({
            cateid: s
        }), a.setData({
            stustatus: o
        }), a.getMore(), e.default.get("educate").then(function(t) {
            a.setData({
                catelist: t.catelist
            }), a.getMore();
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