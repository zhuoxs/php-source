var app = getApp();

Page({
    data: {
        list: [],
        navIndex: 0,
        typeNav: []
    },
    onLoad: function(t) {
        var e = this;
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : e.setData({
            isLogin: !0
        });
    },
    bindGetUserInfo: function(t) {
        var a = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var n = t.detail.userInfo.nickName, i = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var e = t.code;
                console.log(e), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var e = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: e,
                                img: i,
                                name: n
                            },
                            success: function(t) {
                                console.log(t), a.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    previewImage: function(t) {
        for (var e = this, a = t.currentTarget.dataset.index, n = t.currentTarget.dataset.idx, i = (e.data.list, 
        []), o = 0; o < e.data.list[a].img.length; o++) i.push(e.data.url + e.data.list[a].img[o]);
        console.log(i), wx.previewImage({
            current: i[n],
            urls: i
        });
    },
    getlove: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, i = wx.getStorageSync("users").openid, o = (e.data.list, 
        e.data.list[a].lovestate);
        e.data.list[a].lovenum;
        1 == o ? wx.showModal({
            title: "提示",
            content: "确定取消点赞吗？",
            success: function(t) {
                0, t.confirm && app.util.request({
                    url: "entry/wxapp/DelParise",
                    data: {
                        openid: i,
                        id: n
                    },
                    success: function(t) {
                        e.onShow();
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/DelParise",
            data: {
                openid: i,
                id: n
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    goCircledetail: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../circledetail/circledetail?id=" + e
        });
    },
    goAddcircle: function() {
        wx.navigateTo({
            url: "../addcircle/addcircle"
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, a = wx.getStorageSync("users").openid;
        wx.getLocation({
            type: "wgs84 ",
            success: function(t) {
                console.log("获取当前用户经纬度"), e.setData({
                    latitude_dq: t.latitude,
                    longitude_dq: t.longitude
                }), app.util.request({
                    url: "entry/wxapp/ShowCircle",
                    data: {
                        openid: a,
                        index: 0,
                        latitude_dq: e.data.latitude_dq,
                        longitude_dq: e.data.longitude_dq
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            list: t.data.res,
                            type: t.data.type
                        }), e.getUrl();
                    }
                });
            },
            fail: function(t) {
                app.util.request({
                    url: "entry/wxapp/ShowCircle",
                    data: {
                        openid: a,
                        index: 0,
                        latitude_dq: e.data.latitude_dq,
                        longitude_dq: e.data.longitude_dq
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            list: t.data.res,
                            type: t.data.type
                        }), e.getUrl();
                    }
                });
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        return "button" === t.from && console.log(t.target), {
            title: this.data.userInfo.nickName + "邀你参与动态发布",
            path: "/yzcj_sun/pages/circle/circleindex/circleindex",
            success: function(t) {},
            fail: function(t) {}
        };
    },
    goIndex: function() {
        wx.reLaunch({
            url: "../../ticket/ticketmiannew/ticketmiannew"
        });
    },
    changtype: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = e.data.navIndex, i = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/ShowCircle",
            data: {
                openid: i,
                index: n,
                type: a,
                latitude_dq: e.data.latitude_dq,
                longitude_dq: e.data.longitude_dq
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    list: t.data.res,
                    type: t.data.type
                }), e.getUrl();
            }
        }), e.setData({
            typeId: a
        });
    },
    changnavIndex: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = wx.getStorageSync("users").openid, i = e.data.typeId;
        app.util.request({
            url: "entry/wxapp/ShowCircle",
            data: {
                openid: n,
                index: a,
                type: i,
                latitude_dq: e.data.latitude_dq,
                longitude_dq: e.data.longitude_dq
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    list: t.data.res,
                    type: t.data.type
                }), e.getUrl();
            }
        }), e.setData({
            navIndex: a
        });
    }
});