var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js");

Page({
    data: {
        articleList: [],
        RecommendList: [],
        catLength: 0,
        topBarItems: [],
        order: "new",
        typeList: [ {
            id: "1",
            name: "文章",
            icon: "../../resource/images/typeIcon_text.png",
            url: "../../pages/list/list?type=text"
        }, {
            id: "2",
            name: "视频",
            icon: "../../resource/images/typeIcon_video.png",
            url: "../../pages/list/list?type=video"
        }, {
            id: "3",
            name: "图片",
            icon: "../../resource/images/typeIcon_pic.png",
            url: "../../pages/list/list?type=pic"
        }, {
            id: "4",
            name: "音频",
            icon: "../../resource/images/typeIcon_audio.png",
            url: "../../pages/list/list?type=audio"
        }, {
            id: "5",
            name: "PDF",
            icon: "../../resource/images/typeIcon_text.png",
            url: "../../pages/list/list?type=pdf"
        } ],
        stypeArr: [ {
            id: "text",
            name: "文章"
        }, {
            id: "video",
            name: "视频"
        }, {
            id: "pic",
            name: "图片"
        }, {
            id: "audio",
            name: "音频"
        } ],
        stypeIndex: 0,
        page: 1,
        noMoreHidden: !0,
        keyword: "",
        navsetting: 0,
        scstyle: "",
        catList: [],
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
    onReachBottom: function() {
        var e = this, t = e.data.page;
        e.setData({
            page: t + 1
        }), e.GetList();
    },
    onShow: function() {},
    onTapTag: function(e) {
        for (var t = this, a = e.currentTarget.id, i = t.data.topBarItems, n = 0; n < i.length; n++) a == i[n].id ? i[n].selected = !0 : i[n].selected = !1;
        t.setData({
            topBarItems: i,
            order: a,
            page: 1,
            articleList: [],
            noMoreHidden: !0
        }), t.GetList();
    },
    bindStypeChange: function(e) {
        this.setData({
            stypeIndex: e.detail.value
        });
    },
    onShareAppMessage: function() {
        return {
            title: app.siteInfo.name,
            path: "ypuk_ffyd/pages/index/index?shareuid=" + this.data.userId,
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
                }), WxParse.wxParse("HelpExamineIndex", "html", e.data.data.help_examine_index, t, 20), 
                1 != e.data.data.help_examine_open && (t.GetList(), t.GetRecommendList(), t.GetIndexSetting());
            }
        });
    },
    GetIndexSetting: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetIndexMoreSetting",
            cachetime: "0",
            success: function(e) {
                2 == e.data.data.navtype && t.GetNavCat(), t.setData({
                    navsetting: e.data.data.navtype,
                    scstyle: e.data.data.scstyle,
                    swiperList: e.data.data.swiper,
                    topBarItems: e.data.data.topBarItems
                });
            }
        });
    },
    GetNavCat: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/navcategory",
            cachetime: "0",
            success: function(e) {
                t.setData({
                    catList: e.data.data
                });
            }
        });
    },
    GetRecommendList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/recommendlist",
            cachetime: "0",
            data: {
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(e) {
                e.data.data && 0 < e.data.data.length && t.setData({
                    RecommendList: t.data.RecommendList.concat(e.data.data)
                });
            }
        });
    },
    GetList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/list",
            data: {
                page: t.data.page,
                order: t.data.order,
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
    bindSearchKeyword: function(e) {
        this.setData({
            keyword: e.detail.value
        });
    },
    GoSearch: function() {
        wx.navigateTo({
            url: "../../pages/list/list?keyword=" + this.data.keyword + "&type=" + this.data.stypeArr[this.data.stypeIndex].id
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