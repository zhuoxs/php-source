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

function count_down(e, t, a) {
    parseInt(a);
    var n = e.data.bargainList, o = t - Date.parse(new Date());
    if (n[a].clock = date_format(o), o <= 0) return n[a].clock = "已经截止", void e.setData({
        bargainList: n
    });
    setTimeout(function() {
        o -= 100, count_down(e, e.data.bargainList[a].endTime, a);
    }, 100), e.setData({
        bargainList: n
    });
}

function date_format(e) {
    var t = Math.floor(e / 1e3), a = Math.floor(t / 3600 / 24), n = Math.floor((t - 60 * a * 60 * 24) / 3600), o = Math.floor(t / 3600), i = fill_zero_prefix(Math.floor((t - 3600 * o) / 60));
    return "距离结束还剩：" + a + "天" + n + "时" + i + "分" + fill_zero_prefix(t - 3600 * o - 60 * i) + "秒";
}

function fill_zero_prefix(e) {
    return e < 10 ? "0" + e : e;
}

Page((_defineProperty(_Page = {
    data: {
        showModalStatus: !1,
        flag: "true",
        order: [],
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        is_modal_Hidden: !0
    },
    onLoad: function(e) {
        wx.setStorageSync("kanjiaid", e.id), wx.setStorageSync("userid", e.openid), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    thumb: e.userInfo.avatarUrl,
                    nickname: e.userInfo.nickName
                });
            }
        });
        var t = this;
        t.wxauthSetting();
        var a = t.data.bargainList;
        console.log(a), a.endTime = [ {
            antime: "1521863868099",
            astime: "2018-03-23 00:00:00",
            content: "321",
            createtime: "1521790326",
            hits: "0",
            id: "45",
            num: "2",
            sort: "3",
            status: "1",
            titl: "时间"
        } ].antime, t.setData({
            id: e.id,
            user: e.user,
            bargainList: a
        });
        var n = wx.getStorageSync("kanjiaid"), o = wx.getStorageSync("userid");
        console.log(o), console.log(n), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/sharkj",
                data: {
                    id: n
                },
                success: function(e) {
                    console.log(e), t.setData({
                        order: e.data.data
                    }), t.getUrl();
                }
            });
        }, 1e3), app.util.request({
            url: "entry/wxapp/bargainMaster",
            cahetime: "0",
            data: {
                openid: o
            },
            success: function(e) {
                console.log(e), t.setData({
                    userInfo: e.data.data
                });
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
    onReady: function() {},
    onShow: function() {
        var a = this, n = wx.getStorageSync("openid"), o = wx.getStorageSync("userid"), e = wx.getStorageSync("kanjiaid");
        console.log(e), console.log(o), console.log(n), app.util.request({
            url: "entry/wxapp/IsHelp",
            cachetime: "0",
            data: {
                openid: n,
                userid: o,
                id: e
            },
            success: function(e) {
                if (console.log(e), 0 == e.data.data.length) if (o == n) var t = 2; else t = 0; else if (o == n) t = 2; else t = 1;
                a.setData({
                    join: t,
                    openid: n,
                    friendsInfo: e.data.data[0]
                });
            }
        }), app.util.request({
            url: "entry/wxapp/friendsInfo",
            cachetime: "0",
            data: {
                openid: n,
                userid: o,
                id: e
            },
            success: function(e) {
                console.log(e), a.setData({
                    friendsInfos: e.data.data
                });
            }
        });
    },
    wxauthSetting: function(e) {
        var i = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), i.setData({
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
                                i.setData({
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
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
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
                                                wx.setStorageSync("uniacid", e.data.uniacid), i.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        }), i.onShow();
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
                                        i.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), i.setData({
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
                        i.setData({
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    order: function(e) {},
    bargain: function(e) {}
}, "onShareAppMessage", function() {}), _defineProperty(_Page, "powerDr", function(e) {
    var t = e.currentTarget.dataset.statu;
    this.util(t), this.onShow();
}), _defineProperty(_Page, "powerDrawer", function(e) {
    var t = this, a = e.currentTarget.dataset.statu, n = wx.getStorageSync("openid"), o = wx.getStorageSync("userid"), i = wx.getStorageSync("kanjiaid"), s = t.data.flag;
    if (t.getUrl(), n == o) wx.showToast({
        title: "您是砍主，砍主不能再砍了哦",
        icon: "none"
    }); else if ("true" == s) {
        t.setData({
            flag: "false"
        });
        var r = new Date().valueOf();
        console.log(r);
        var c = base64.base64_encode(r + "???alsjdlqkwjlke123654!@#!@81903890");
        app.util.request({
            url: "entry/wxapp/littleMoney",
            cachetime: "0",
            data: {
                id: i,
                userid: o
            },
            success: function(e) {
                console.log(e), 1 == e.data ? wx.showToast({
                    title: "已经是最低价啦！不能再砍了！",
                    icon: "none"
                }) : 3 == e.data ? wx.showToast({
                    title: "活动已截止！",
                    icon: "none"
                }) : app.util.request({
                    url: "entry/wxapp/Help",
                    data: {
                        userid: o,
                        id: i,
                        openid: n,
                        timestamp: r,
                        t: c
                    },
                    success: function(e) {
                        console.log(e), t.setData({
                            price: e.data.data
                        }), t.util(a);
                    }
                });
            }
        }), setTimeout(function() {
            t.setData({
                flag: "true"
            });
        }, 2e3);
    } else wx.showToast({
        title: "请勿重复请求！",
        icon: "none",
        duration: 2e3
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
}), _defineProperty(_Page, "powerDrawers", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../detail/detail?id=" + t
    });
}), _defineProperty(_Page, "toIndex", function(e) {
    wx.reLaunch({
        url: "/wnjz_sun/pages/index/index"
    });
}), _Page));