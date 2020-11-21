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
        var e = i.data.user.id, t = i.data.pindex, a = i.data.psize;
        _request2.default.get("integral", {
            op: "getmore",
            userid: e,
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
    onLoad: function(e) {
        var t = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        this.setData({
            param: t,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        }), this.getMore();
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