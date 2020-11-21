var md5 = require("../../../we7/js/md5.js"), base64 = require("../../../we7/js/base64.js");

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

var app = getApp();

Page({
    data: {
        hideShopPopup: !0,
        hideNewFooter: !0,
        savedMoney: 10,
        totalSave: 11.6,
        showModalStatus: !1,
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152178548159.png",
        title: "日式精细擦窗",
        price: "100",
        minPrice: "68",
        surplus: "100",
        flag: "true",
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        barmoney: 12,
        is_modal_Hidden: !0
    },
    onLoad: function(e) {
        var t = this;
        wx.setStorageSync("kanjiaid", e.id), wx.setStorageSync("userid", e.openid), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), console.log(e);
        var a = wx.getStorageSync("kanjiaid"), n = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/helpBargain",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(e) {
                wx.setNavigationBarTitle({
                    title: e.data.data.gname
                }), t.setData({
                    helpbargain: e.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/kanzhu",
            cahetime: "0",
            data: {
                openid: n
            },
            success: function(e) {
                console.log(e), t.setData({
                    userInfo: e.data.data
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
                })) : (console.log("scope.userInfo没有授权 1"), i.setData({
                    is_modal_Hidden: !1
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
                                        app.util.request({
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
                                                wx.setStorageSync("uniacid", e.data.uniacid), i.onShow(), i.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), i.setData({
                                    is_modal_Hidden: !1
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
    onReady: function() {},
    onShow: function() {
        var e = wx.getStorageSync("kanjiaid"), t = wx.getStorageSync("userid"), a = wx.getStorageSync("openid"), n = this;
        n.wxauthSetting();
        var o = wx.getStorageSync("helpPrice");
        n.setData({
            helpPrice: o
        }), app.util.request({
            url: "entry/wxapp/partNum",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(e) {
                var t = e.data.data.length;
                n.setData({
                    partuser: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Friends",
            cachetime: "0",
            data: {
                openid: t,
                id: e
            },
            success: function(e) {
                n.setData({
                    friends: e.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/IsHelp",
            cachetime: "0",
            data: {
                openid: a,
                userid: t,
                id: e
            },
            success: function(e) {
                if (1 == e.data.data) var t = 0; else t = 1;
                n.setData({
                    join: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/MyBrangeInfo",
            cachetime: "0",
            data: {
                openid: a,
                userid: t,
                id: e
            },
            success: function(e) {
                console.log(e), n.setData({
                    helpPrice: e.data.data.kanjias
                });
            }
        });
    },
    Iwant: function(e) {
        wx.navigateTo({
            url: "../kanjia-list/details?id=" + e.currentTarget.dataset.id
        });
    },
    goBackHome: function(e) {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    order: function(e) {},
    bargain: function(e) {},
    onShareAppMessage: function(e) {
        if ("button" === e.from) {
            var t = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid"), n = this.data.helpbargain;
            app.util.request({
                url: "entry/wxapp/system",
                cachetime: "0",
                success: function(e) {
                    wx.setStorageSync("system", e.data);
                }
            });
            wx.getStorageSync("system");
        }
        return {
            title: n.share_title,
            path: "chbl_sun/pages/help/help?id=" + a + "&openid=" + t,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    powerDrawer: function(e) {
        e.currentTarget.dataset.statu;
        var n = e.currentTarget.dataset.id, o = wx.getStorageSync("openid"), i = wx.getStorageSync("userid"), s = this, t = s.data.flag;
        console.log(t), "true" == t ? (console.log("进入请求"), s.setData({
            flag: "false"
        }), app.util.request({
            url: "entry/wxapp/Expire",
            cachetime: "0",
            data: {
                id: n
            },
            success: function(e) {
                0 == e.data.data || "0" == e.data.data ? wx.showToast({
                    title: "活动已到期！感谢参与！",
                    icon: "none"
                }) : o == i ? wx.showToast({
                    title: "不能为自己砍价哦，快去求助好友吧！",
                    icon: "none"
                }) : app.util.request({
                    url: "entry/wxapp/zuidijia",
                    cachetime: "0",
                    data: {
                        id: n,
                        openid: i
                    },
                    success: function(e) {
                        if ("1" == e.data || 1 == e.data) wx.showToast({
                            title: "已经很低啦，不能再砍了！",
                            icon: "none"
                        }); else {
                            var t = new Date().valueOf();
                            console.log(t);
                            var a = base64.base64_encode(t + "???alsjdlqkwjlke123654!@#!@81903890");
                            app.util.request({
                                url: "entry/wxapp/DoHelpBargain",
                                cachetime: "0",
                                data: {
                                    id: n,
                                    openid: o,
                                    userid: i,
                                    timestamp: t,
                                    t: a
                                },
                                success: function(e) {
                                    console.log(e);
                                    var t = e.data.data;
                                    wx.setStorageSync("helpPrice", t), s.onShow(), s.setData({
                                        helpPrice: t,
                                        hideShopPopup: !1
                                    });
                                }
                            });
                        }
                    }
                });
            }
        }), setTimeout(function() {
            s.setData({
                flag: "true"
            }), console.log(s.data.flag);
        }, 2e3)) : (console.log("请勿重复请求"), wx.showToast({
            title: "请勿重复请求！",
            icon: "none",
            duration: 2e3
        }));
    },
    closePopupTap: function() {
        this.setData({
            hideShopPopup: !0,
            hideNewFooter: !1
        }), this.onShow();
    },
    util: function(e) {
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
    },
    help: function(e) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    }
});