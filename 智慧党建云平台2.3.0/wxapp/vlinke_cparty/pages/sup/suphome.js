var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), t = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var n = this, o = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        n.setData({
            param: o,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        }), e.default.get("suphome").then(function(e) {
            n.setData({
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
        t.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});