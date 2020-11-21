var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        articleList: [],
        topBarItems: [ {
            id: "text",
            name: "文章",
            selected: !0
        }, {
            id: "video",
            name: "视频",
            selected: !1
        }, {
            id: "pic",
            name: "图片",
            selected: !1
        }, {
            id: "audio",
            name: "音频",
            selected: !1
        }, {
            id: "pdf",
            name: "PDF",
            selected: !1
        } ],
        tab: "text",
        page: 1,
        noMoreHidden: !0,
        keyword: "",
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(e) {
        var t = this;
        e.shareuid && t.setData({
            shareuid: e.shareuid
        });
        for (var a = "文章列表", i = t.data.topBarItems, s = 0; s < i.length; s++) e.type == i[s].id ? (i[s].selected = !0, 
        a = i[s].name) : i[s].selected = !1;
        t.setData({
            topBarItems: i,
            tab: e.type
        }), wx.setNavigationBarTitle({
            title: a
        }), e.keyword && "" != e.keyword && t.setData({
            keyword: e.keyword
        });
        var n = wx.getStorageSync("userInfo");
        n && 0 != n.memberInfo.uid && "" != n.memberInfo ? (t.setData({
            userId: n.memberInfo.uid
        }), 0 != t.data.shareuid && t.BindDistributionUser()) : wx.getSetting({
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
        }), t.GetList();
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != t.data.shareuid && t.BindDistributionUser();
        }, e.detail);
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
        var e = this, t = e.data.page;
        e.setData({
            page: t + 1
        }), e.GetList();
    },
    bindSearchKeyword: function(e) {
        this.setData({
            keyword: e.detail.value
        });
    },
    GoSearch: function() {
        this.setData({
            page: 1,
            articleList: []
        }), this.GetList();
    },
    onTapTag: function(e) {
        for (var t, a = this, i = e.currentTarget.id, s = a.data.topBarItems, n = 0; n < s.length; n++) i == s[n].id ? (s[n].selected = !0, 
        t = s[n].name) : s[n].selected = !1;
        wx.setNavigationBarTitle({
            title: t
        }), a.setData({
            topBarItems: s,
            tab: i,
            page: 1,
            articleList: [],
            noMoreHidden: !0
        }), a.GetList();
    },
    onShow: function() {},
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    onShareAppMessage: function() {
        return {
            title: "文章列表",
            path: "ypuk_ffyd/pages/list/list?shareuid=" + this.data.userId,
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
    formSubmit: function(e) {
        var t = "../list/list";
        "" != e.detail.value.input ? (t = t + "?keyword=" + e.detail.value.input, wx.redirectTo({
            url: t
        })) : wx.showModal({
            title: "提示",
            content: "请输入搜索内容",
            showCancel: !1
        });
    },
    GetList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/typelist",
            data: {
                page: t.data.page,
                tab: t.data.tab,
                keyword: t.data.keyword,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            cachetime: "0",
            success: function(e) {
                e.data.data && 0 < e.data.data.length ? t.setData({
                    articleList: t.data.articleList.concat(e.data.data)
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