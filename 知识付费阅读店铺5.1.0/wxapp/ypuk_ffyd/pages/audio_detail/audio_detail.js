var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js"), backgroundAudioManager = wx.getBackgroundAudioManager();

Page({
    data: {
        articleInfo: [],
        RecommendList: [],
        userId: "",
        articleId: "",
        AudioProgress: 0,
        PreviewHidden: !0,
        ThumbAnimation: !1,
        onEnded: !1,
        AudioPlayHidden: !1,
        AudioStarttime: "0:0",
        AudioDuration: "0:00",
        commentBarHidden: !0,
        comment: "",
        commentInputFocus: !1,
        page: 1,
        noMoreHidden: !0,
        loadHidden: !0,
        commentList: [],
        loginModelHidden: !0,
        shareuid: 0
    },
    onLoad: function(a) {
        var t, e = this;
        a.shareuid && e.setData({
            shareuid: a.shareuid
        }), t = a.scene ? decodeURIComponent(a.scene) : a.articleid, e.setData({
            articleId: t
        });
        var n = wx.getStorageSync("userInfo");
        n && 0 != n.memberInfo.uid && "" != n.memberInfo ? (e.setData({
            userId: n.memberInfo.uid
        }), 0 != e.data.shareuid && e.BindDistributionUser(), e.GetDetail()) : wx.getSetting({
            success: function(a) {
                0 == a.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && wx.openSetting({
                            success: function(a) {
                                1 == a.authSetting["scope.userInfo"] && (e.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), e.setData({
                    loginModelHidden: !1
                }));
            }
        }), e.audioCtx = wx.createAudioContext("myAudio"), e.GetRecommendList();
    },
    updateUserInfo: function(a) {
        var t = this;
        app.util.getUserInfo(function(a) {
            a = wx.getStorageSync("userInfo");
            t.setData({
                userId: a.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != t.data.shareuid && t.BindDistributionUser(), t.GetDetail();
        }, a.detail);
    },
    onShow: function() {},
    onShareAppMessage: function() {
        var a = this;
        return {
            title: a.data.articleInfo.title,
            path: "ypuk_ffyd/pages/audio_detail/audio_detail?articleid=" + a.data.articleId + "&shareuid=" + a.data.userId,
            success: function(a) {
                wx.showToast({
                    title: "转发成功",
                    icon: "success",
                    duration: 1e3,
                    mask: !0
                });
            }
        };
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
            success: function(a) {
                a.data.data && 0 < a.data.data.length && t.setData({
                    RecommendList: t.data.RecommendList.concat(a.data.data)
                });
            }
        });
    },
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    audioPlay: function() {
        var a = this;
        "0:00" == a.data.AudioDuration || 1 == a.data.onEnded ? a.onloadAudioManager() : backgroundAudioManager.play(), 
        a.backgroundAudioFunction(), a.setData({
            AudioPlayHidden: !0,
            ThumbAnimation: !0
        }), app.globalData.BackgroundAudioPlay = !0;
    },
    audioPause: function() {
        backgroundAudioManager.pause(), wx.setNavigationBarTitle({
            title: "文章详情"
        }), this.setData({
            AudioPlayHidden: !1,
            ThumbAnimation: !1
        }), app.globalData.BackgroundAudioPlay = !1;
    },
    backgroundAudioFunction: function() {
        var u = this;
        backgroundAudioManager.onTimeUpdate(function(a) {
            var t = backgroundAudioManager.currentTime, e = parseInt(backgroundAudioManager.currentTime), n = parseInt(e / 60), i = parseInt(backgroundAudioManager.duration), o = n + ":" + e % 60, d = backgroundAudioManager.duration;
            t = parseInt(100 * t / d);
            0 < e && wx.setNavigationBarTitle({
                title: "文章详情"
            }), u.setData({
                AudioDuration: (d / 60).toFixed(2),
                AudioOffset: e,
                AudioStarttime: o,
                AudioMax: i
            });
        }), backgroundAudioManager.onEnded(function(a) {
            u.setData({
                AudioPlayHidden: !1,
                ThumbAnimation: !1,
                onEnded: !0
            }), app.globalData.BackgroundAudioPlay = "", app.globalData.BackgroundAudioId = "";
        });
    },
    sliderchange: function(a) {
        var t = parseInt(a.detail.value);
        backgroundAudioManager.seek(t);
    },
    onloadAudioManager: function() {
        var a = this;
        "" != a.data.articleInfo.preview_audio && "preview" == a.data.articleInfo.showmod ? (backgroundAudioManager.src = a.data.articleInfo.preview_audio, 
        backgroundAudioManager.title = "【试听】" + a.data.articleInfo.title) : (backgroundAudioManager.src = a.data.articleInfo.audio, 
        backgroundAudioManager.title = a.data.articleInfo.title), wx.setNavigationBarTitle({
            title: "音频加载中···"
        }), app.globalData.BackgroundAudioId = a.data.articleInfo.id, backgroundAudioManager.coverImgUrl = a.data.articleInfo.thumb, 
        backgroundAudioManager.epname = a.data.articleInfo.title, backgroundAudioManager.singer = a.data.articleInfo.author;
    },
    updataAudio: function() {
        var a = this;
        "0:00" == a.data.AudioDuration || 1 == a.data.onEnded ? a.onloadAudioManager() : backgroundAudioManager.play(), 
        a.backgroundAudioFunction(), a.setData({
            AudioPlayHidden: !0,
            ThumbAnimation: !0
        }), backgroundAudioManager.startTime = backgroundAudioManager.currentTime;
    },
    GetDetail: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getaudiodetail",
            cachetime: "0",
            data: {
                uid: t.data.userId,
                articleid: t.data.articleId,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(a) {
                t.setData({
                    articleInfo: a.data.data
                }), WxParse.wxParse("Text", "html", a.data.data.text, t, 20), app.globalData.BackgroundAudioId == t.data.articleId && t.updataAudio(), 
                t.GetArticleComment();
            }
        });
    },
    AddFav: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/addfav",
            data: {
                uid: t.data.userId,
                articleid: t.data.articleId
            },
            success: function(a) {
                t.setData({
                    "articleInfo.favstatus": a.data.data
                });
            }
        });
    },
    AddComment: function() {
        this.setData({
            commentBarHidden: !1,
            commentInputFocus: !0
        });
    },
    closeComment: function() {
        this.setData({
            commentBarHidden: !0,
            commentInputFocus: !1
        });
    },
    bindComment: function(a) {
        this.setData({
            comment: a.detail.value
        });
    },
    submitComment: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/addcomment",
            data: {
                content: t.data.comment,
                uid: t.data.userId,
                articleid: t.data.articleId
            },
            success: function(a) {
                t.setData({
                    comment: "",
                    commentBarHidden: !0,
                    commentInputFocus: !1,
                    noMoreHidden: !0,
                    loadHidden: !0,
                    page: 1,
                    commentList: [],
                    "articleInfo.commentnum": Number(t.data.articleInfo.commentnum) + 1
                }), t.GetArticleComment();
            }
        });
    },
    loadComment: function() {
        var a = this.data.page;
        this.setData({
            page: a + 1
        }), this.GetArticleComment();
    },
    GetArticleComment: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getcomment",
            cachetime: "0",
            data: {
                articleid: t.data.articleId,
                page: t.data.page
            },
            success: function(a) {
                a.data.data && 0 < a.data.data.length ? t.setData({
                    commentList: t.data.commentList.concat(a.data.data),
                    loadHidden: !1
                }) : t.setData({
                    noMoreHidden: !1,
                    loadHidden: !0
                });
            }
        });
    },
    onHide: function() {
        0 == app.globalData.BackgroundAudioPlay && backgroundAudioManager.stop();
    },
    SubmitBuyArticle: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/pay",
            data: {
                articleid: t.data.articleId,
                mod: "article",
                uid: t.data.userId
            },
            cachetime: "0",
            success: function(a) {
                a.data && a.data.data && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功"
                        }), t.GetDetail();
                    },
                    fail: function(a) {}
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    CopyText: function() {
        wx.setClipboardData({
            data: this.data.articleInfo.copytext,
            success: function(a) {
                wx.getClipboardData({
                    success: function(a) {
                        wx.showToast({
                            title: "复制成功"
                        });
                    }
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