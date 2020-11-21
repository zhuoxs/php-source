var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {},
    setSign: function() {
        var e = this, t = e.data.activity.id;
        _request2.default.get("actmanage", {
            op: "setsign",
            activityid: t
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
        var e = this, t = e.data.activity.id;
        _request2.default.get("actmanage", {
            op: "refurbishqrcode",
            activityid: t
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
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var i = t.activityid, o = n.id;
        _request2.default.get("actmanage", {
            activityid: i,
            userid: o
        }).then(function(t) {
            e.setData({
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