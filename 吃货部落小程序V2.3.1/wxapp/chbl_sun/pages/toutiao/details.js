var app = getApp();

Page({
    data: {
        lid: ""
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t);
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), wx.setStorageSync("lid", t.lid), e.refresh();
    },
    refresh: function(t) {
        var i = this;
        i.data.id;
        wx.login({
            success: function(t) {
                console.log("这是登录所需要的code"), console.log(t.code);
                var e = t.code;
                wx.setStorageSync("code", e), wx.getUserInfo({
                    success: function(t) {
                        var o = t.userInfo.nickName, c = t.userInfo.avatarUrl;
                        app.util.request({
                            url: "entry/wxapp/openid",
                            cachetime: "0",
                            data: {
                                code: e
                            },
                            success: function(t) {
                                var e = c;
                                console.log(e);
                                var a = o, n = t.data.openid;
                                app.util.request({
                                    url: "entry/wxapp/Login",
                                    cachetime: "0",
                                    data: {
                                        openid: n,
                                        img: e,
                                        name: a
                                    },
                                    success: function(t) {
                                        t.data.id, i.setData({
                                            user_id: t.data.id,
                                            img: e
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/ZxLikeNum",
            cachetime: "0",
            success: function(t) {
                var e = t.data.data.length + 6;
                console.log(t), i.setData({
                    num: e
                });
            }
        });
        var e = wx.getStorageSync("lid");
        app.util.request({
            url: "entry/wxapp/zxinfo",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), i.setData({
                    zxinfo: t.data
                });
            }
        });
    },
    clickZan: function(t) {
        var e = this.data;
        e.hadZan || (e.hadZan = 1), this.setData({
            hadZan: e.hadZan
        });
    },
    Collection: function(t) {
        var e = this;
        console.log(t);
        var a = e.data.zxinfo, n = e.data.user_id;
        app.util.request({
            url: "entry/wxapp/ZxLike",
            cachetime: "0",
            data: {
                zx_id: a.id,
                user_id: n
            },
            success: function(t) {
                console.log(t), 1 == t.data ? (wx.showToast({
                    title: "点赞成功",
                    icon: "",
                    image: "",
                    duration: 2e3,
                    mask: !0,
                    success: function(t) {},
                    fail: function(t) {},
                    complete: function(t) {}
                }), setTimeout(function() {
                    e.refresh();
                }, 2e3)) : wx.showModal({
                    title: "提示",
                    content: t.data,
                    showCancel: !0,
                    cancelText: "取消",
                    cancelColor: "",
                    confirmText: "确定",
                    confirmColor: "",
                    success: function(t) {},
                    fail: function(t) {},
                    complete: function(t) {}
                }), e.setData({
                    Collection: t.data
                });
            }
        }), e.refresh();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});