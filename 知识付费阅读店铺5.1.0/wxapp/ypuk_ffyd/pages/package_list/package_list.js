var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js");

Page({
    data: {
        packageList: [],
        page: 1,
        noMoreHidden: !0,
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(e) {
        var t = this;
        e.shareuid && t.setData({
            shareuid: e.shareuid
        });
        var a = wx.getStorageSync("userInfo");
        a && 0 != a.memberInfo.uid && "" != a.memberInfo ? (t.setData({
            userId: a.memberInfo.uid
        }), 0 != t.data.shareuid && t.BindDistributionUser(), t.GetHelpExamineSetting()) : wx.getSetting({
            success: function(e) {
                0 == e.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
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
        });
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != t.data.shareuid && t.BindDistributionUser(), t.GetHelpExamineSetting();
        }, e.detail);
    },
    onPullDownRefresh: function() {
        this.setData({
            packageList: [],
            page: 1
        }), this.GetList(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {
        var e = this, t = e.data.page;
        e.setData({
            page: t + 1
        }), e.GetList();
    },
    onShow: function() {},
    onShareAppMessage: function() {
        return {
            title: "专栏列表",
            path: "ypuk_ffyd/pages/package_list/package_list?shareuid=" + this.data.userId,
            success: function(e) {
                wx.showToast({
                    title: "转发成功",
                    icon: "success",
                    duration: 1e3,
                    mask: !0
                });
            }
        };
    },
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    GetHelpExamineSetting: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetHelpExamineSetting",
            cachetime: "0",
            data: {
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(e) {
                t.setData({
                    helpExamine: e.data.data
                }), WxParse.wxParse("HelpExaminePackage", "html", e.data.data.help_examine_package, t, 20), 
                1 != e.data.data.help_examine_open && t.GetList();
            }
        });
    },
    GetList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/packageList",
            data: {
                page: t.data.page,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            cachetime: "0",
            success: function(e) {
                e.data.data && 0 < e.data.data.length ? t.setData({
                    packageList: t.data.packageList.concat(e.data.data)
                }) : t.setData({
                    noMoreHidden: !1
                });
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