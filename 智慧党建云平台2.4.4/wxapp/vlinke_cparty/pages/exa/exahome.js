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
        var a = this, t = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            param: t,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var r = n.id;
        _request2.default.get("exahome", {
            userid: r
        }).then(function(e) {
            a.setData({
                exaanswer: e.exaanswer,
                exapaperall: e.exapaperall,
                exadayall: e.exadayall,
                slide: e.slide
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../home/home"
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