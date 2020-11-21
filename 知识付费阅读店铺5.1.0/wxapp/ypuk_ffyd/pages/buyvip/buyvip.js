var _ypuk_util = require("../../resource/js/ypuk_util.js"), _ypuk_util2 = _interopRequireDefault(_ypuk_util), _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        userId: "",
        VipGroupId: 0,
        UserVip: [],
        VipGroupList: [],
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(t) {
        var e = this;
        t.shareuid && e.setData({
            shareuid: t.shareuid
        });
        var a = wx.getStorageSync("userInfo");
        a && 0 != a.memberInfo.uid && "" != a.memberInfo ? (e.setData({
            userId: a.memberInfo.uid
        }), 0 != e.data.shareuid && e.BindDistributionUser(), e.GetUserVip(), e.GetVipGroup()) : wx.getSetting({
            success: function(t) {
                0 == t.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                1 == t.authSetting["scope.userInfo"] && (e.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), e.setData({
                    loginModelHidden: !1
                }));
            }
        });
    },
    updateUserInfo: function(t) {
        var e = this;
        app.util.getUserInfo(function(t) {
            t = wx.getStorageSync("userInfo");
            e.setData({
                userId: t.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != e.data.shareuid && e.BindDistributionUser(), e.GetUserVip(), e.GetVipGroup();
        }, t.detail);
    },
    onShareAppMessage: function() {
        return {
            title: "会员服务",
            path: "ypuk_ffyd/pages/buyvip/buyvip?shareuid=" + this.data.userId,
            success: function(t) {
                wx.showToast({
                    title: "转发成功",
                    icon: "success",
                    duration: 1e3,
                    mask: !0
                });
            }
        };
    },
    GetVipGroup: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getvipgroup",
            data: {
                uid: e.data.userId
            },
            cachetime: "0",
            success: function(t) {
                e.setData({
                    VipGroupList: t.data.data
                });
            }
        });
    },
    GetUserVip: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getuservip",
            data: {
                uid: e.data.userId
            },
            cachetime: "0",
            success: function(t) {
                t.data.data && "" != t.data.data && e.setData({
                    UserVip: t.data.data
                });
            }
        });
    },
    VipGroupChange: function(t) {
        this.setData({
            VipGroupId: t.detail.value
        });
    },
    SubmitBuyVip: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/pay",
            data: {
                vipgid: e.data.VipGroupId,
                uid: e.data.userId,
                mod: "vip"
            },
            cachetime: "0",
            success: function(t) {
                t.data && t.data.data && wx.requestPayment({
                    timeStamp: t.data.data.timeStamp,
                    nonceStr: t.data.data.nonceStr,
                    package: t.data.data.package,
                    signType: "MD5",
                    paySign: t.data.data.paySign,
                    success: function(t) {
                        wx.showToast({
                            title: "支付成功"
                        }), e.GetUserVip();
                    },
                    fail: function(t) {}
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    BindDistributionUser: function() {
        app.util.request({
            url: "entry/wxapp/BindDistributionUser",
            cachetime: "0",
            data: {
                uid: this.data.userId,
                shareuid: this.data.shareuid
            }
        });
    }
});