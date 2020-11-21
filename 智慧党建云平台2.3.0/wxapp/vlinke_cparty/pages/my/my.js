var n = function(n) {
    return n && n.__esModule ? n : {
        default: n
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {},
    calling: function(n) {
        wx.makePhoneCall({
            phoneNumber: n.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    onLoad: function(e) {
        var t = this;
        n.default.get("my").then(function(n) {
            t.setData({
                param: n.param,
                telarr: n.telarr,
                user: n.user,
                brancharr: n.brancharr,
                notice: n.notice
            });
        }, function(n) {
            wx.showModal({
                title: "提示信息",
                content: n,
                showCancel: !1,
                success: function(n) {
                    n.confirm && wx.redirectTo({
                        url: "../login/login"
                    });
                }
            });
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
        var n = this;
        return {
            title: n.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: n.data.param.wxappshareimageurl
        };
    }
});