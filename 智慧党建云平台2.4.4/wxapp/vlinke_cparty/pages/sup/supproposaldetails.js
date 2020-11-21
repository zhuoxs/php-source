var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var t = this, o = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        null == a && wx.redirectTo({
            url: "../login/login"
        }), t.setData({
            param: o,
            user: a
        });
        var n = e.id, r = t.data.user.id;
        _request2.default.get("supproposal", {
            id: n,
            op: "details",
            userid: r
        }).then(function(e) {
            t.setData({
                supproposal: e.supproposal
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../sup/supproposal"
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
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});