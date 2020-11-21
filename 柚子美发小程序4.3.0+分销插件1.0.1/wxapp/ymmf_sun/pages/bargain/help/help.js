var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), md5 = require("../../../../we7/js/md5.js"), base64 = require("../../../../we7/js/base64.js");

Page((_defineProperty(_Page = {
    data: {
        showModalStatus: !1,
        order: [],
        ig: [],
        img: [],
        flag: "true",
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ]
    },
    onLoad: function(e) {
        wx.setStorageSync("kanjiaid", e.id), wx.setStorageSync("userid", e.openid);
        var t = this;
        t.getUrl(), t.wxauthSetting();
        var a = wx.getStorageSync("kanjiaid");
        console.log(a);
        var n = wx.getStorageSync("userid"), o = wx.getStorageSync("openid");
        console.log(o), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    thumb: e.userInfo.avatarUrl,
                    nickname: e.userInfo.nickName
                });
            }
        }), app.util.request({
            url: "entry/wxapp/KJshar",
            data: {
                id: a,
                userid: n
            },
            success: function(e) {
                t.setData({
                    bargain_details: e.data
                }), console.log("你的姓名是什么哦"), console.log(e), console.log("你的小明是什么");
            }
        });
    },
    wxauthSetting: function(e) {
        var s = this, t = wx.getStorageSync("openid");
        console.log(t), t ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var a = e.userInfo.nickName, n = e.userInfo.avatarUrl, o = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
                                        console.log("进入获取openid"), console.log(e.data);
                                        t = e.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
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
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    onReady: function() {},
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
    onShow: function() {
        var a = this, n = wx.getStorageSync("openid"), o = wx.getStorageSync("userid"), e = wx.getStorageSync("kanjiaid");
        app.util.request({
            url: "entry/wxapp/IsHelp",
            cachetime: "0",
            data: {
                openid: n,
                userid: o,
                id: e
            },
            success: function(e) {
                if (console.log(e), 0 == e.data.data.length) var t = 0; else t = 1;
                if (n == o) t = 2;
                a.setData({
                    join: t,
                    friendsInfo: e.data.data[0]
                });
            }
        }), app.util.request({
            url: "entry/wxapp/MyGoodsFriends",
            cachetime: "0",
            data: {
                id: e,
                userid: o
            },
            success: function(e) {
                console.log(e), a.setData({
                    MyGoodsFriends: e.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    order: function(e) {},
    bargain: function(e) {}
}, "onShareAppMessage", function() {}), _defineProperty(_Page, "powerDrr", function(e) {
    var t = e.currentTarget.dataset.statu;
    this.util(t), this.onShow();
}), _defineProperty(_Page, "powerDrawer", function(e) {
    var n = this, o = e.currentTarget.dataset.statu, s = wx.getStorageSync("userid"), i = wx.getStorageSync("openid"), r = (n.data.showstatu, 
    e.currentTarget.dataset.id), t = n.data.flag;
    n.getUrl(), null != i && "" != i ? i == s ? wx.showToast({
        title: "您是砍主，砍主不能再砍了哦",
        icon: "none"
    }) : "true" == t ? (n.setData({
        flag: "false"
    }), app.util.request({
        url: "entry/wxapp/littleMoney",
        cachetime: "0",
        data: {
            id: r,
            userid: s
        },
        success: function(e) {
            if (console.log(e), 1 == e.data) wx.showToast({
                title: "已经是最低价啦！不能再砍了！",
                icon: "none"
            }); else {
                var t = new Date().valueOf();
                console.log(t);
                var a = base64.base64_encode(t + "???alsjdlqkwjlke123654!@#!@81903890");
                console.log(a), app.util.request({
                    url: "entry/wxapp/Help",
                    data: {
                        id: r,
                        openid: i,
                        userid: s,
                        timestamp: t,
                        t: a
                    },
                    success: function(e) {
                        console.log(e), n.setData({
                            price: e.data
                        });
                    }
                }), n.util(o);
            }
        }
    }), setTimeout(function() {
        n.setData({
            flag: "true"
        });
    }, 2e3)) : wx.showToast({
        title: "请勿重复请求！",
        icon: "none",
        duration: 2e3
    }) : wx.showToast({
        title: "请稍等!!",
        icon: "none"
    });
}), _defineProperty(_Page, "util", function(e) {
    var t = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = t).opacity(0).height(0).step(), this.setData({
        animationData: t.export()
    }), setTimeout(function() {
        t.opacity(1).height("468rpx").step(), this.setData({
            animationData: t
        }), "close" == e && this.setData({
            showModalStatus: !1
        });
    }.bind(this), 200), "open" == e && this.setData({
        showModalStatus: !0
    });
}), _defineProperty(_Page, "help", function(e) {
    wx.updateShareMenu({
        withShareTicket: !0,
        success: function() {}
    });
}), _defineProperty(_Page, "toDetail", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../detail/detail?id=" + t
    });
}), _defineProperty(_Page, "goGooddetails", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../detail/detail?id=" + t
    });
}), _defineProperty(_Page, "toIndex", function(e) {
    wx.reLaunch({
        url: "../../index/index"
    });
}), _Page));