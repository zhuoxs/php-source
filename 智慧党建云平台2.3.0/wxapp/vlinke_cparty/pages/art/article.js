var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.article.id, i = e.data.pindex, n = e.data.psize;
        t.default.post("artmessage", {
            op: "getmore",
            articleid: a,
            pindex: i,
            psize: n
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var i = t;
            i.length < e.data.psize ? e.setData({
                list: a.concat(i),
                hasMore: !1
            }) : e.setData({
                list: a.concat(i),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(t) {
        var e = this, a = t.target.dataset.messageid, i = t.target.dataset.src;
        wx.previewImage({
            current: i,
            urls: e.data.list[a].picall
        });
    },
    onLoad: function(e) {
        var a = this, i = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            param: i,
            user: n
        }), 0 == i.openart && null == n && wx.redirectTo({
            url: "../login/login"
        });
        var r = e.id, o = null == n ? 0 : n.id;
        t.default.get("article", {
            id: r,
            userid: o
        }).then(function(t) {
            0 != t.article.link.length && wx.redirectTo({
                url: "../webview/webview?weburl=" + t.article.link
            }), a.setData({
                article: t.article,
                artcate: t.artcate,
                branch: t.branch,
                integralhidden: 0 == t.integralid
            }), a.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../art/arthome"
                    });
                }
            }), console.log(t);
        });
    },
    onReady: function() {
        e.util.footer(this);
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