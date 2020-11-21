var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), n = getApp();

Page({
    data: {},
    calling: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    onLoad: function(n) {
        var t = this, o = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        t.setData({
            param: o,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        });
        var r = n.id;
        e.default.get("mybranch", {
            op: "buser",
            id: r
        }).then(function(e) {
            t.setData({
                buser: e.buser,
                branch: e.branch,
                leader: e.leader
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../login/login"
                    });
                }
            });
        });
    },
    onReady: function() {
        n.util.footer(this);
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