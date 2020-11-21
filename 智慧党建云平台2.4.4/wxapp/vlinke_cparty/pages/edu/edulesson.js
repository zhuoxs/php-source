var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), userlist = [];

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var s = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = s.data.edulesson.id, t = s.data.pindex, a = s.data.psize;
        _request2.default.post("edumessage", {
            op: "getmore",
            lessonid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = s.data.list;
            1 == s.data.pindex && (t = []);
            var a = e;
            a.length < s.data.psize ? s.setData({
                list: t.concat(a),
                hasMore: !1
            }) : s.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: s.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(e) {
        var t = e.target.dataset.messageid, a = e.target.dataset.src;
        wx.previewImage({
            current: a,
            urls: this.data.list[t].picall
        });
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: s
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.id, n = s.id;
        _request2.default.get("edulesson", {
            id: o,
            userid: n
        }).then(function(e) {
            t.setData({
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
        app.util.footer(this);
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
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});