var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        commentList: [],
        userId: "",
        page: 1,
        noMoreHidden: !0,
        loginModelHidden: !0
    },
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("userInfo");
        n && 0 != n.memberInfo.uid && "" != n.memberInfo ? (t.setData({
            userId: n.memberInfo.uid
        }), t.GetList()) : wx.getSetting({
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
        }), wx.hideShareMenu();
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), t.GetList();
        }, e.detail);
    },
    onPullDownRefresh: function() {
        this.setData({
            commentList: [],
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
    onShareAppMessage: function() {},
    DelCommentConfirm: function(e) {
        var t = this, n = e.currentTarget.id;
        wx.showModal({
            title: "提示",
            content: "删除后将不可恢复，确定要删除此留言吗",
            success: function(e) {
                e.confirm && t.DelCommentPost(n);
            }
        });
    },
    DelCommentPost: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/delcomment",
            data: {
                id: e,
                uid: t.data.userId
            },
            cachetime: "0",
            success: function(e) {
                wx.showToast({
                    title: "删除成功"
                }), t.setData({
                    commentList: []
                }), t.GetList();
            }
        });
    },
    GetList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/usercomment",
            data: {
                page: t.data.page,
                uid: t.data.userId
            },
            cachetime: "0",
            success: function(e) {
                e.data.data && 0 < e.data.data.length ? t.setData({
                    commentList: t.data.commentList.concat(e.data.data)
                }) : t.setData({
                    noMoreHidden: !1
                });
            }
        });
    }
});