var app = getApp();

Page({
    data: {
        inputShowed: !1,
        comment: "",
        is_modal_Hidden: !0,
        isLogin: !0,
        banner: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
        active: {
            title: "标题啊啊",
            address: "地址啊啊啊地址啊啊啊",
            user: "墨纸",
            time: "2018-01-01",
            good: 99,
            watch: 111,
            comment: 3,
            isGood: !1
        },
        commentList: [ {
            pic: "http://ww1.sinaimg.cn/small/005ysW6ajw8eqcgo07piij30dc0dcmxp.jpg",
            uname: "墨纸",
            time: "2018-01-02",
            content: "这是内容啊啊啊这是内容啊啊啊这是内容啊啊啊这是内容啊啊啊这是内容啊啊啊这是内容啊啊啊这是内容啊啊啊"
        }, {
            pic: "http://ww1.sinaimg.cn/small/005ysW6ajw8eqcgo07piij30dc0dcmxp.jpg",
            uname: "墨纸",
            time: "2018-01-02",
            content: "这是内容啊啊啊"
        }, {
            pic: "http://ww1.sinaimg.cn/small/005ysW6ajw8eqcgo07piij30dc0dcmxp.jpg",
            uname: "墨纸",
            time: "2018-01-02",
            content: "这是内容啊啊啊"
        } ]
    },
    onLoad: function(t) {
        var e = this, n = t.aid;
        e.setData({
            aid: n
        }), e.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = e.data.aid, n = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/activity",
            cachetime: "0",
            data: {
                aid: t,
                uid: n
            },
            success: function(t) {
                console.log(t), wx.setStorageSync("active", t.data), e.setData({
                    active: t.data,
                    commentList: t.data.content1
                }), 4 == t.data.add && wx.setNavigationBarTitle({
                    title: "详情"
                });
            }
        });
    },
    addShou: function(t) {
        var e = this, n = e.data.aid, a = wx.getStorageSync("users").id, o = t.currentTarget.dataset.shou;
        app.util.request({
            url: "entry/wxapp/activityShou",
            cachetime: "0",
            data: {
                aid: n,
                uid: a,
                shou: o
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    clickGood: function(t) {
        var e = this, n = e.data.aid, a = wx.getStorageSync("users").id, o = t.currentTarget.dataset.zan;
        console.log(o), app.util.request({
            url: "entry/wxapp/activityZan",
            cachetime: "0",
            data: {
                aid: n,
                uid: a,
                zan: o
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    toMsg: function(t) {
        this.setData({
            inputShowed: !0
        });
    },
    loseFocus: function(t) {
        this.data.comment;
        this.setData({
            inputShowed: !1
        });
    },
    comment: function(t) {
        this.setData({
            comment: t.detail.value
        });
    },
    send: function(t) {
        var e = this, n = e.data.aid, a = wx.getStorageSync("users").id, o = e.data.comment;
        console.log(o), app.util.request({
            url: "entry/wxapp/activityPing",
            cachetime: "0",
            data: {
                aid: n,
                uid: a,
                content: o
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        wx.getStorageSync("users").name;
        return "button" === t.from && console.log(t.target), {
            title: "[" + this.data.active.name + "]",
            path: "/byjs_sun/pages/product/activeDet/activeDet?aid=" + this.data.aid,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    toActiveJoin: function(t) {
        var e = t.currentTarget.dataset.aid, n = t.currentTarget.dataset.price, a = t.currentTarget.dataset.is_open;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/activeJoin/activeJoin?aid= " + e + "&price= " + n + "&is_open=" + a
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
    toActive: function(t) {
        wx.navigateTo({
            url: "/byjs_sun/pages/product/active/active"
        });
    },
    wxauthSetting: function(t) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var e = t.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var n = t.userInfo.nickName, a = t.userInfo.avatarUrl, o = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key);
                                        var e = t.data.openid;
                                        wx.setStorageSync("userid", t.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: a,
                                                name: n,
                                                gender: o
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(t) {
                                        s.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});