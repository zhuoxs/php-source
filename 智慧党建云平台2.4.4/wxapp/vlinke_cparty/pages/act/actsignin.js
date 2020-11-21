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
        var e = this, t = e.data.activity.id, n = e.data.user.id;
        _request2.default.get("actsignin", {
            op: "setsign",
            activityid: t,
            userid: n
        }).then(function(t) {
            e.setData({
                activity: t.activity,
                actenroll: t.actenroll
            }), wx.showModal({
                title: "提示",
                content: "签到成功！",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../home/home"
                    });
                }
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../act/acthome"
                    });
                }
            }), console.log(t);
        });
    },
    onLoad: function(t) {
        var e = this, n = (decodeURIComponent(t.scene), t.scene);
        _request2.default.get("actsignin", {
            activityid: n
        }).then(function(t) {
            e.setData({
                activity: t.activity,
                branch: t.branch,
                actuser: t.actuser,
                param: t.param,
                user: t.user,
                actenroll: t.actenroll
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../home/home"
                    });
                }
            }), console.log(t);
        });
    },
    onReady: function() {},
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