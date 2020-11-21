var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var n = this, o = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        n.setData({
            param: o,
            user: a
        });
        var i = e.id;
        t.default.get("notice", {
            id: i,
            op: "details"
        }).then(function(t) {
            n.setData({
                notice: t.notice,
                branch: t.branch
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../notice/notice"
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