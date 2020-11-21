var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        distributionInfo: "",
        userId: "",
        loginModelHidden: !0,
        shareMenuHidden: !0
    },
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("userInfo");
        n && 0 != n.memberInfo.uid && "" != n.memberInfo ? (t.setData({
            userId: n.memberInfo.uid
        }), t.getDistributionInfo()) : wx.getSetting({
            success: function(e) {
                0 == e.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可参与砍价哦",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.openSetting({
                            success: function(e) {
                                1 == e.authSetting["scope.userInfo"] && (t.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), t.setData({
                    loginModelHidden: !1
                }));
            }
        }), wx.hideShareMenu();
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), t.getDistributionInfo();
        }, e.detail);
    },
    getDistributionInfo: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getdistributioninfo",
            data: {
                uid: t.data.userId
            },
            cachetime: "0",
            success: function(e) {
                t.setData({
                    distributionInfo: e.data.data
                });
            }
        });
    }
});