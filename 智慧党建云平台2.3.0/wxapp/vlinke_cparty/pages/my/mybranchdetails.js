var a = function(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}(require("../../util/request.js")), n = getApp();

Page({
    data: {},
    calling: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    maping: function(a) {
        var n = this;
        wx.openLocation({
            latitude: parseFloat(n.data.branch.lat),
            longitude: parseFloat(n.data.branch.lng),
            scale: 18,
            name: n.data.branch.name,
            address: n.data.branch.address
        });
    },
    onLoad: function(n) {
        var t = this, e = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        t.setData({
            param: e,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        });
        var r = n.id;
        a.default.get("mybranch", {
            id: r,
            op: "details"
        }).then(function(a) {
            t.setData({
                branch: a.branch
            });
        }, function(a) {
            wx.showModal({
                title: "提示信息",
                content: a,
                showCancel: !1,
                success: function(a) {
                    a.confirm && wx.redirectTo({
                        url: "../my/my"
                    });
                }
            }), console.log(a);
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
        var a = this;
        return {
            title: a.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: a.data.param.wxappshareimageurl
        };
    }
});