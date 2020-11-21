function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page({
    data: {
        releaseFocus: !1,
        list: [],
        conmment: [],
        searchinput: ""
    },
    onLoad: function(e) {
        var t = this, a = e.id;
        wx.setStorageSync("id", a);
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        t.setData({
                            isLogin: !1,
                            userInfo: e.userInfo
                        });
                    }
                });
            }
        }) : t.setData({
            isLogin: !0
        });
    },
    bindGetUserInfo: function(e) {
        var a = this;
        wx.setStorageSync("user_info", e.detail.userInfo);
        var n = e.detail.userInfo.nickName, i = e.detail.userInfo.avatarUrl;
        wx.login({
            success: function(e) {
                var t = e.code;
                console.log(t), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: t
                    },
                    success: function(e) {
                        console.log(e), wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                        var t = e.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: t,
                                img: i,
                                name: n
                            },
                            success: function(e) {
                                console.log(e), a.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", e.data), wx.setStorageSync("uniacid", e.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    previewImage: function(e) {
        for (var t = this, a = (e.currentTarget.dataset.index, e.currentTarget.dataset.idx), n = (t.data.list, 
        []), i = 0; i < t.data.list.img.length; i++) n.push(t.data.url + t.data.list.img[i]);
        wx.previewImage({
            current: n[a],
            urls: n
        });
    },
    getlove: function(e) {
        var a = this, t = e.currentTarget.dataset.id, n = wx.getStorageSync("users").openid, i = (a.data.list, 
        a.data.list.lovestate), o = a.data.list.lovenum, s = "list.lovestate", r = "list.lovenum";
        1 == i ? wx.showModal({
            title: "提示",
            content: "确定取消点赞吗？",
            success: function(e) {
                o--, e.confirm && app.util.request({
                    url: "entry/wxapp/DelParise",
                    data: {
                        openid: n,
                        id: t
                    },
                    success: function(e) {
                        var t;
                        a.setData((_defineProperty(t = {}, s, !1), _defineProperty(t, r, o), t));
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/DelParise",
            data: {
                openid: n,
                id: t
            },
            success: function(e) {
                var t;
                o++, a.setData((_defineProperty(t = {}, s, !0), _defineProperty(t, r, o), t));
            }
        });
    },
    bindReply: function(e) {
        this.setData({
            releaseFocus: !0
        });
    },
    bindReplyclose: function(e) {
        var t = this, a = t.data.value, n = e.currentTarget.dataset.id, i = wx.getStorageSync("users").openid;
        console.log(t.data.length), t.data.length < 1 || null == t.data.length ? wx.showToast({
            title: "内容不得为空！",
            icon: "loading",
            duration: 1e3,
            mask: !0
        }) : wx.showModal({
            title: "提示",
            content: "确定发送吗？",
            success: function(e) {
                e.confirm && app.util.request({
                    url: "entry/wxapp/PutContent",
                    data: {
                        openid: i,
                        id: n,
                        content: a
                    },
                    success: function(e) {
                        t.setData({
                            releaseFocus: !1,
                            searchinput: ""
                        }), t.onShow();
                    }
                });
            }
        });
    },
    bindKeyInput: function(e) {
        this.setData({
            length: e.detail.value.length,
            value: e.detail.value
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("users").openid, a = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/CircleDetail",
            data: {
                openid: e,
                id: a
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    list: e.data.res,
                    conmment: e.data.res1
                }), t.getUrl();
            }
        });
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goIndex: function() {
        wx.reLaunch({
            url: "../../ticket/ticketmiannew/ticketmiannew"
        });
    },
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("id");
        return "button" === e.from && console.log(e.target), {
            title: this.data.userInfo.nickName + "邀你参与动态发布",
            path: "/yzcj_sun/pages/circle/circledetail/circledetail?id=" + t,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    calltell: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    }
});