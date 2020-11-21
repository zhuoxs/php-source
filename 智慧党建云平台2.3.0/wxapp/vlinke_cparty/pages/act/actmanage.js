var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {},
    setSign: function() {
        var e = this, a = e.data.activity.id;
        t.default.get("actmanage", {
            op: "setsign",
            activityid: a
        }).then(function(t) {
            e.setData({
                signtext: 0 == t.issign ? "签到已关闭" : "签到已开启"
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../act/acthome"
                    });
                }
            }), console.log(t);
        });
    },
    refurbishQrcode: function() {
        var e = this, a = e.data.activity.id;
        t.default.get("actmanage", {
            op: "refurbishqrcode",
            activityid: a
        }).then(function(t) {
            e.setData({
                wxappqrcode: t.wxappqrcode
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../act/acthome"
                    });
                }
            }), console.log(t);
        });
    },
    onLoad: function(e) {
        var a = this, n = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        a.setData({
            param: n,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        });
        var i = e.activityid, c = o.id;
        t.default.get("actmanage", {
            activityid: i,
            userid: c
        }).then(function(t) {
            a.setData({
                activity: t.activity,
                wxappqrcode: t.wxappqrcode,
                actuser: t.actuser,
                branch: t.branch,
                utype1: t.utype1,
                utype2: t.utype2,
                actenrolltol: t.actenrolltol,
                signtext: 0 == t.activity.issign ? "签到已关闭" : "签到已开启"
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../act/acthome"
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