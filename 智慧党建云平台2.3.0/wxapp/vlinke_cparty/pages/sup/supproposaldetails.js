var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var o = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        null == n && wx.redirectTo({
            url: "../login/login"
        }), o.setData({
            param: a,
            user: n
        });
        var r = e.id, u = o.data.user.id;
        t.default.get("supproposal", {
            id: r,
            op: "details",
            userid: u
        }).then(function(t) {
            o.setData({
                supproposal: t.supproposal
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../sup/supproposal"
                    });
                }
            }), console.log(t);
        });
    },
    onReady: function() {
        e.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});