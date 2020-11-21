var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        t.setData({
            param: n,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        }), _request2.default.get("suphome").then(function(e) {
            t.setData({
                slide: e.slide
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../sup/suphome"
                    });
                }
            });
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