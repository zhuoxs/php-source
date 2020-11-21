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
        var t = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        null == n && wx.redirectTo({
            url: "../login/login"
        }), t.setData({
            param: a,
            user: n
        });
        var o = e.id, u = t.data.user.id;
        _request2.default.get("supmailbox", {
            id: o,
            op: "details",
            userid: u
        }).then(function(e) {
            t.setData({
                supmailbox: e.supmailbox,
                luser: e.luser
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../sup/supmailbox"
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