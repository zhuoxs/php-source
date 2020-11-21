var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        actenroll: [],
        slide: [],
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var n = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = n.data.user.branchid, t = n.data.pindex, a = n.data.psize;
        _request2.default.get("acthome", {
            op: "getmore",
            branchid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = n.data.list;
            1 == n.data.pindex && (t = []);
            var a = e;
            a.length < n.data.psize ? n.setData({
                list: t.concat(a),
                hasMore: !1
            }) : n.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: n.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: n
        }), null != n ? _request2.default.get("acthome").then(function(e) {
            t.setData({
                actenroll: e.actenroll,
                slide: e.slide
            }), t.getMore();
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../act/acthome"
                    });
                }
            });
        }) : wx.redirectTo({
            url: "../login/login"
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