var n = function(n) {
    return n && n.__esModule ? n : {
        default: n
    };
}(require("../../util/request.js")), a = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("param") || null, r = wx.getStorageSync("user") || null;
        t.setData({
            param: e,
            user: r
        }), null == r && wx.redirectTo({
            url: "../login/login"
        });
        var o = r.branchid;
        n.default.get("mybranch", {
            branchid: o
        }).then(function(n) {
            t.setData({
                brancharr: n.brancharr,
                userall: n.userall,
                branch: n.branch
            });
        }, function(n) {
            wx.showModal({
                title: "提示信息",
                content: n,
                showCancel: !1,
                success: function(n) {
                    n.confirm && wx.redirectTo({
                        url: "../my/my"
                    });
                }
            });
        });
    },
    onReady: function() {
        a.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var n = this;
        return {
            title: n.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: n.data.param.wxappshareimageurl
        };
    }
});