var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        articleList: [],
        pcategoryList: [],
        pcatIndex: 0,
        scategoryList: [ {
            id: 0,
            parentid: 0,
            name: "全部"
        } ],
        scatIndex: 0,
        nowCatid: 0,
        page: 1,
        noMoreHidden: !0,
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(t) {
        var a = this;
        t.shareuid && a.setData({
            shareuid: t.shareuid
        }), a.setData({
            nowCatid: t.catid
        });
        var e = wx.getStorageSync("userInfo");
        e && 0 != e.memberInfo.uid && "" != e.memberInfo ? (a.setData({
            userId: e.memberInfo.uid
        }), 0 != a.data.shareuid && a.BindDistributionUser()) : wx.getSetting({
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
        }), a.GetCategory();
    },
    updateUserInfo: function(t) {
        var a = this;
        app.util.getUserInfo(function(t) {
            t = wx.getStorageSync("userInfo");
            a.setData({
                userId: t.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != a.data.shareuid && a.BindDistributionUser();
        }, t.detail);
    },
    onPullDownRefresh: function() {
        this.setData({
            articleList: [],
            page: 1
        }), this.GetList(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {
        var t = this, a = t.data.page;
        t.setData({
            page: a + 1
        }), t.GetList();
    },
    bindPCategoryChange: function(t) {
        var a = this;
        a.setData({
            pcatIndex: t.detail.value,
            scatIndex: 0,
            scategoryList: [ {
                id: 0,
                parentid: 0,
                name: "全部"
            } ].concat(a.data.pcategoryList[t.detail.value].subcat),
            articleList: []
        }), a.GetList();
    },
    bindSCategoryChange: function(t) {
        this.setData({
            scatIndex: t.detail.value,
            articleList: []
        }), this.GetList();
    },
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    GetCategory: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/categorylist",
            cachetime: "0",
            success: function(t) {
                for (var a = 0; a < t.data.data.length; a++) t.data.data[a].id == e.data.nowCatid && e.setData({
                    pcatIndex: a,
                    scategoryList: e.data.scategoryList.concat(t.data.data[a].subcat)
                });
                e.setData({
                    pcategoryList: t.data.data
                }), e.GetList();
            }
        });
    },
    onShow: function() {},
    onShareAppMessage: function() {
        return {
            title: "文章列表",
            path: "ypuk_ffyd/pages/catlist/catlist?shareuid=" + this.data.userId,
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
    GetList: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/catarticlelist",
            data: {
                page: a.data.page,
                pcatid: a.data.pcategoryList[a.data.pcatIndex].id,
                scatid: a.data.scategoryList[a.data.scatIndex].id,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            cachetime: "0",
            success: function(t) {
                t.data.data && 0 < t.data.data.length ? a.setData({
                    articleList: a.data.articleList.concat(t.data.data)
                }) : a.setData({
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