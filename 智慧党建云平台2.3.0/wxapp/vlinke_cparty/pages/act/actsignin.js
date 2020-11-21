var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), n = getApp();

Page({
    data: {},
    setSign: function() {
        var n = this, e = n.data.activity.id, a = n.data.user.id;
        t.default.get("actsignin", {
            op: "setsign",
            activityid: e,
            userid: a
        }).then(function(t) {
            n.setData({
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
    onLoad: function(n) {
        var e = this, a = (decodeURIComponent(n.scene), n.scene);
        t.default.get("actsignin", {
            activityid: a
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
    onReady: function() {
        n.util.footer(this);
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