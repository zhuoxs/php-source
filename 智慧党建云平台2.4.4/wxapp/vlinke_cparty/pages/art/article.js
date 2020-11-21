var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var i = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = i.data.article.id, t = i.data.pindex, a = i.data.psize;
        _request2.default.post("artmessage", {
            op: "getmore",
            articleid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = i.data.list;
            1 == i.data.pindex && (t = []);
            var a = e;
            a.length < i.data.psize ? i.setData({
                list: t.concat(a),
                hasMore: !1
            }) : i.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: i.data.pindex + 1
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
        var t = this, a = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: i
        }), 0 == a.openart && null == i && wx.redirectTo({
            url: "../login/login"
        });
        var r = e.id, n = null == i ? 0 : i.id;
        _request2.default.get("article", {
            id: r,
            userid: n
        }).then(function(e) {
            0 != e.article.link.length && wx.redirectTo({
                url: "../webview/webview?weburl=" + e.article.link
            }), t.setData({
                article: e.article,
                artcate: e.artcate,
                branch: e.branch,
                integralhidden: 0 == e.integralid
            }), t.getMore();
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../art/arthome"
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