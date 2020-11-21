var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), t = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var t = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = t.data.edulesson.id, o = t.data.pindex, n = t.data.psize;
        e.default.post("edumessage", {
            op: "getmore",
            lessonid: a,
            pindex: o,
            psize: n
        }).then(function(e) {
            var a = t.data.list;
            1 == t.data.pindex && (a = []);
            var o = e;
            o.length < t.data.psize ? t.setData({
                list: a.concat(o),
                hasMore: !1
            }) : t.setData({
                list: a.concat(o),
                hasMore: !0,
                pindex: t.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(e) {
        var t = this, a = e.target.dataset.messageid, o = e.target.dataset.src;
        wx.previewImage({
            current: o,
            urls: t.data.list[a].picall
        });
    },
    onLoad: function(t) {
        var a = this, o = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            param: o,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var s = t.id, i = n.id;
        e.default.get("edulesson", {
            id: s,
            userid: i
        }).then(function(e) {
            a.setData({
                edulesson: e.edulesson,
                educate: e.educate,
                edustudy: e.edustudy,
                edustudytol: e.edustudytol,
                educhapterall: e.educhapterall
            }), console.log(e.edustudy);
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
        t.util.footer(this);
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
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});