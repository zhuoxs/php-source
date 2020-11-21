var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js");

Page({
    data: {
        articleInfo: [],
        RecommendList: [],
        userId: "",
        articleId: "",
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
    onLoad: function(t) {
        var e, a = this;
        t.shareuid && a.setData({
            shareuid: t.shareuid
        }), e = t.scene ? decodeURIComponent(t.scene) : t.articleid, a.setData({
            articleId: e
        });
        var n = wx.getStorageSync("userInfo");
        n && 0 != n.memberInfo.uid && "" != n.memberInfo ? (a.setData({
            userId: n.memberInfo.uid
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
        }), a.GetRecommendList();
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
    onShow: function() {},
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.articleInfo.title,
            path: "ypuk_ffyd/pages/text_detail/text_detail?articleid=" + t.data.articleId + "&shareuid=" + t.data.userId,
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
    GetRecommendList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/recommendlist",
            cachetime: "0",
            data: {
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(t) {
                t.data.data && 0 < t.data.data.length && e.setData({
                    RecommendList: e.data.RecommendList.concat(t.data.data)
                });
            }
        });
    },
    GetDetail: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getpdfdetail",
            cachetime: "0",
            data: {
                uid: e.data.userId,
                articleid: e.data.articleId,
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(t) {
                e.setData({
                    articleInfo: t.data.data
                }), e.GetArticleComment();
            }
        });
    },
    DownloadPdf: function() {
        wx.downloadFile({
            url: this.data.articleInfo.pdffile,
            success: function(t) {
                console.log(t);
                var e = t.tempFilePath;
                wx.openDocument({
                    filePath: e,
                    success: function(t) {
                        console.log("打开文档成功");
                    }
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    AddFav: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/addfav",
            data: {
                uid: e.data.userId,
                articleid: e.data.articleId
            },
            success: function(t) {
                e.setData({
                    "articleInfo.favstatus": t.data.data
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
    bindComment: function(t) {
        this.setData({
            comment: t.detail.value
        });
    },
    submitComment: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/addcomment",
            data: {
                content: e.data.comment,
                uid: e.data.userId,
                articleid: e.data.articleId
            },
            success: function(t) {
                e.setData({
                    comment: "",
                    commentBarHidden: !0,
                    commentInputFocus: !1,
                    noMoreHidden: !0,
                    loadHidden: !0,
                    page: 1,
                    commentList: [],
                    "articleInfo.commentnum": Number(e.data.articleInfo.commentnum) + 1
                }), e.GetArticleComment();
            }
        });
    },
    loadComment: function() {
        var t = this.data.page;
        this.setData({
            page: t + 1
        }), this.GetArticleComment();
    },
    GetArticleComment: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getcomment",
            cachetime: "0",
            data: {
                articleid: e.data.articleId,
                page: e.data.page
            },
            success: function(t) {
                t.data.data && 0 < t.data.data.length ? e.setData({
                    commentList: e.data.commentList.concat(t.data.data),
                    loadHidden: !1
                }) : e.setData({
                    noMoreHidden: !1,
                    loadHidden: !0
                });
            }
        });
    },
    toHome: function() {
        wx.switchTab({
            url: "../../pages/index/index"
        });
    },
    SubmitBuyArticle: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/pay",
            data: {
                articleid: e.data.articleId,
                mod: "article",
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
    CopyText: function() {
        wx.setClipboardData({
            data: this.data.articleInfo.copytext,
            success: function(t) {
                wx.getClipboardData({
                    success: function(t) {
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