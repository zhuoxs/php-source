var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js");

Page({
    data: {
        packageInfo: [],
        articleList: [],
        userId: "",
        Pid: "",
        articleHidden: !0,
        contentHidden: !1,
        page: 1,
        noMoreHidden: !0,
        loadHidden: !0,
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(t) {
        var e, a = this;
        t.shareuid && a.setData({
            shareuid: t.shareuid
        }), e = t.scene ? decodeURIComponent(t.scene) : t.pid, a.setData({
            Pid: e
        });
        var i = wx.getStorageSync("userInfo");
        i && 0 != i.memberInfo.uid && "" != i.memberInfo ? (a.setData({
            userId: i.memberInfo.uid
        }), 0 != a.data.shareuid && a.BindDistributionUser(), a.GetDetail()) : wx.getSetting({
            success: function(t) {
                0 == t.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                1 == t.authSetting["scope.userInfo"] && (a.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), a.setData({
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
            }), 0 != e.data.shareuid && e.BindDistributionUser(), e.GetDetail();
        }, t.detail);
    },
    onPullDownRefresh: function() {
        this.setData({
            articleList: [],
            page: 1
        }), this.GetDetail(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {
        var t = this, e = t.data.page;
        t.setData({
            page: e + 1
        }), t.GetArticleList();
    },
    showContent: function() {
        this.setData({
            articleHidden: !0,
            contentHidden: !1
        });
    },
    showArticle: function() {
        this.setData({
            articleHidden: !1,
            contentHidden: !0
        });
    },
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.packageInfo.title,
            path: "ypuk_ffyd/pages/package_detail/package_detail?pid=" + t.data.Pid + "?shareuid=" + t.data.userId,
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
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    GetArticleList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getpackagebind",
            cachetime: "0",
            data: {
                page: e.data.page,
                pid: e.data.Pid,
                uid: e.data.userId,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(t) {
                t.data.data && 0 < t.data.data.length && e.setData({
                    articleList: e.data.articleList.concat(t.data.data)
                });
            }
        });
    },
    GetDetail: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getpackagedetail",
            cachetime: "0",
            data: {
                uid: e.data.userId,
                pid: e.data.Pid,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(t) {
                WxParse.wxParse("Content", "html", t.data.data.content, e, 10), e.setData({
                    articleList: [],
                    page: 1,
                    packageInfo: t.data.data
                }), e.GetArticleList();
            }
        });
    },
    SubmitBuyPackage: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/pay",
            data: {
                pid: e.data.Pid,
                mod: "package",
                uid: e.data.userId
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
                        }), e.GetDetail();
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