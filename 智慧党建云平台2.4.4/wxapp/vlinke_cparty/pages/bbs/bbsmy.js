var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: [],
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(t) {
        start_clientX = t.changedTouches[0].clientX;
    },
    touchend: function(t) {
        120 < (end_clientX = t.changedTouches[0].clientX) - start_clientX ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : 0 < start_clientX - end_clientX && this.setData({
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
        var n = this, t = n.data.op, e = n.data.user.id, a = n.data.pindex, i = n.data.psize;
        _request2.default.get("bbsmy", {
            op: t,
            userid: e,
            pindex: a,
            psize: i
        }).then(function(t) {
            var e = n.data.list;
            1 == n.data.pindex && (e = []);
            var a = t;
            a.length < n.data.psize ? n.setData({
                list: e.concat(a),
                hasMore: !1
            }) : n.setData({
                list: e.concat(a),
                hasMore: !0,
                pindex: n.data.pindex + 1
            });
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var i = t.op;
        e.setData({
            op: i
        }), e.getMore();
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