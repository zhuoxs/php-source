var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var host, videoPage, app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js"), part_urls = {}, pageArr = new Array();

Page({
    data: {
        articleInfo: [],
        RecommendList: [],
        userId: "",
        articleId: "",
        PreviewHidden: !0,
        AllHidden: !0,
        PreviewBgHidden: !0,
        VideoPicHidden: !1,
        commentBarHidden: !0,
        comment: "",
        commentInputFocus: !1,
        page: 1,
        noMoreHidden: !0,
        loadHidden: !0,
        commentList: [],
        loginModelHidden: !0,
        videoUrls: "",
        token: "",
        shareuid: 0
    },
    onLoad: function(e) {
        var t, a = this;
        e.shareuid && a.setData({
            shareuid: e.shareuid
        }), t = e.scene ? decodeURIComponent(e.scene) : e.articleid, a.setData({
            articleId: t
        });
        var i = wx.getStorageSync("userInfo");
        i && 0 != i.memberInfo.uid && "" != i.memberInfo ? (a.setData({
            userId: i.memberInfo.uid
        }), 0 != a.data.shareuid && a.BindDistributionUser(), a.GetDetail()) : wx.getSetting({
            success: function(e) {
                0 == e.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.openSetting({
                            success: function(e) {
                                1 == e.authSetting["scope.userInfo"] && (a.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), a.setData({
                    loginModelHidden: !1
                }));
            }
        }), a.videoContext = wx.createVideoContext("myVideo"), a.GetRecommendList();
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), 0 != t.data.shareuid && t.BindDistributionUser(), t.GetDetail();
        }, e.detail);
    },
    onShow: function() {},
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.articleInfo.title,
            path: "ypuk_ffyd/pages/video_detail/video_detail?articleid=" + e.data.articleId + "&shareuid=" + e.data.userId,
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
    playPreviewVideo: function() {
        var e = this;
        e.setData({
            PreviewHidden: !1,
            VideoPicHidden: !0
        }), setTimeout(function() {
            e.videoContext.play();
        }, 100);
    },
    playAllVideo: function() {
        this.setData({
            AllHidden: !1,
            VideoPicHidden: !0
        }), this.videoContext.play();
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
    PreviewNow: function(e) {
        var t = this;
        e.detail.currentTime >= t.data.articleInfo.preview_time && (t.videoContext.pause(), 
        t.setData({
            PreviewBgHidden: !1,
            PreviewHidden: !0
        }));
    },
    noPreviewVideo: function() {
        wx.showModal({
            title: "提示",
            content: "本文章暂无预览视频，请购买后查看完整版",
            showCancel: !1
        });
    },
    GetDetail: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getvideodetail",
            cachetime: "0",
            data: {
                uid: t.data.userId,
                articleid: t.data.articleId,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(e) {
                t.setData({
                    articleInfo: e.data.data
                }), "nopic" == e.data.data.videopic && (t.setData({
                    VideoPicHidden: !0
                }), "all" == e.data.data.showmod ? t.setData({
                    AllHidden: !1
                }) : t.setData({
                    PreviewHidden: !1
                })), 1 == e.data.data.videotype && t.getVideoInfo(e.data.data.video), t.GetArticleComment();
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
            success: function(e) {
                t.setData({
                    "articleInfo.favstatus": e.data.data
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
    bindComment: function(e) {
        this.setData({
            comment: e.detail.value
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
            success: function(e) {
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
        var e = this.data.page;
        this.setData({
            page: e + 1
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
            success: function(e) {
                e.data.data && 0 < e.data.data.length ? t.setData({
                    commentList: t.data.commentList.concat(e.data.data),
                    loadHidden: !1
                }) : t.setData({
                    noMoreHidden: !1,
                    loadHidden: !0
                });
            }
        });
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
            success: function(e) {
                e.data && e.data.data && wx.requestPayment({
                    timeStamp: e.data.data.timeStamp,
                    nonceStr: e.data.data.nonceStr,
                    package: e.data.data.package,
                    signType: "MD5",
                    paySign: e.data.data.paySign,
                    success: function(e) {
                        wx.showToast({
                            title: "支付成功"
                        }), t.GetDetail();
                    },
                    fail: function(e) {}
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    getVideoInfo: function(e) {
        var d = this, t = "https://vv.video.qq.com/getinfo?otype=json&platform=101001&charge=0&vid=" + e;
        wx.request({
            url: t,
            success: function(e) {
                var t = (e.data.replace(/QZOutputJson=/, "") + "qwe").replace(/;qwe/, ""), a = JSON.parse(t), i = a.vl.vi[0].ul.ui[0].url + a.vl.vi[0].fn + "?vkey=" + a.vl.vi[0].fvkey, n = d.data.articleInfo;
                n.video = i, d.setData({
                    articleInfo: n
                });
            }
        });
    },
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    CopyText: function() {
        wx.setClipboardData({
            data: this.data.articleInfo.copytext,
            success: function(e) {
                wx.getClipboardData({
                    success: function(e) {
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