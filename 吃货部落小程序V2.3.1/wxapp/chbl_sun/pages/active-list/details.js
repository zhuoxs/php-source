var app = getApp(), util = require("../../resource/js/utils/util.js"), md5 = require("../../../we7/js/md5.js"), base64 = require("../../../we7/js/base64.js"), now_date = util.formatTime(new Date());

function count_down(t, e, a) {
    parseInt(a);
    var o = t.data.bargainList, n = e - Date.parse(new Date());
    if (o[a].clock = date_format(n), n <= 0) return o[a].clock = "00 : 00 : 00", void t.setData({
        bargainList: o
    });
    setTimeout(function() {
        n -= 100, count_down(t, t.data.bargainList[a].endTime, a);
    }, 100), t.setData({
        bargainList: o
    });
}

function date_format(t) {
    var e = Math.floor(t / 1e3), a = Math.floor(e / 3600 / 24), o = Math.floor((e - 60 * a * 60 * 24) / 3600), n = Math.floor(e / 3600), i = fill_zero_prefix(Math.floor((e - 3600 * n) / 60));
    fill_zero_prefix(e - 3600 * n - 60 * i);
    return a + " 天 " + o + " 时 " + i + " 分 ";
}

function fill_zero_prefix(t) {
    return t < 10 ? "0" + t : t;
}

console.log(now_date), Page({
    data: {
        joinGroup: !0,
        hideShopPopup: !0,
        times: "",
        id: "",
        shareNum: [],
        bargainList: [ {
            endTime: "",
            clock: ""
        } ],
        flag: "true",
        is_modal_Hidden: !0,
        showModalStatus: !1
    },
    onLoad: function(o) {
        var n = this;
        wx.setStorage({
            key: "pid",
            data: o.id
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        }), n.setData({
            aid: o.id
        }), o.type && n.setData({
            comein: 1
        }), setTimeout(function() {
            n.setData({
                hidden: "1"
            });
        }, 1e3), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log(t), wx.setStorageSync("latitude", t.latitude), wx.setStorageSync("longitude", t.longitude);
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetActive",
                    cachetime: "0",
                    data: {
                        id: o.id,
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        console.log(t);
                        var e = n.data.bargainList, a = t.data.data[0].antime;
                        wx.setStorageSync("active", t.data.data[0]), e[0].endTime = a, count_down(n, n.data.bargainList[0].endTime, 0), 
                        n.setData({
                            bargainList: e,
                            active: t.data.data[0]
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        });
    },
    joinGroup: function(t) {
        this.setData({
            joinGroup: !1
        });
    },
    closeWelfare: function(t) {
        this.setData({
            joinGroup: !0
        });
    },
    goBackHome: function(t) {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    closePopupTap: function() {
        this.setData({
            hideShopPopup: !0
        });
    },
    makeCall: function(t) {
        var e = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    goLucky: function(c) {
        console.log(c), this.setData({
            hideShopPopup: !0
        });
        var u = this, t = u.data.flag;
        if (c.detail.formId) {
            r = c.detail.target.dataset.id;
            if (console.log("++++++++++++++++++++++" + r), "00 : 00 : 00" == c.detail.target.dataset.clock) return wx.showToast({
                title: "活动已结束！",
                icon: "none",
                duration: 2e3
            }), !1;
        } else {
            var r = c.currentTarget.dataset.id;
            console.log("---------------" + r);
        }
        "00 : 00 : 00" == c.currentTarget.dataset.clock ? wx.showToast({
            title: "活动已结束！",
            icon: "none",
            duration: 2e3
        }) : "true" == t ? (u.setData({
            flag: "false"
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                var e = t.data, a = u.data.jikaNum;
                if (console.log(a), a <= 0) return u.closePopupTap(), void wx.showToast({
                    title: "次数已使用完！",
                    icon: "none",
                    duration: 2e3
                });
                var o = new Date().valueOf(), n = base64.base64_encode(o + "???alsjdlqkwjlke123654!@#!@81903890"), i = u.data.active, s = wx.getStorageSync("is_vip");
                console.log(s), 1 == i.is_vip ? 1 == s ? (app.util.request({
                    url: "entry/wxapp/GetGift",
                    cachetime: "0",
                    data: {
                        uid: e,
                        pid: r,
                        timestamp: o,
                        t: n
                    },
                    success: function(t) {
                        console.log(t), u.setData({
                            ckapian: t.data.data
                        }), app.util.request({
                            url: "entry/wxapp/isLuck",
                            cachetime: "0",
                            data: {
                                pid: r,
                                openid: wx.getStorageSync("openid")
                            },
                            success: function(t) {
                                console.log(t), 2 == t.data ? app.util.request({
                                    url: "entry/wxapp/comeActiveMessage",
                                    cachetime: "0",
                                    data: {
                                        active_type: 2,
                                        openid: wx.getStorageSync("openid"),
                                        active_id: r,
                                        form_id: c.detail.formId
                                    },
                                    success: function(t) {
                                        console.log(1e39), console.log(t);
                                    }
                                }) : console.log("--------------抽过奖啦-----------------");
                            }
                        }), u.onShow();
                    }
                }), setTimeout(function() {
                    u.setData({
                        hideShopPopup: !1
                    });
                }.bind(this), 500)) : wx.showToast({
                    title: "该活动仅限会员参与！",
                    icon: "none"
                }) : (app.util.request({
                    url: "entry/wxapp/GetGift",
                    cachetime: "0",
                    data: {
                        uid: e,
                        pid: r,
                        timestamp: o,
                        t: n
                    },
                    success: function(t) {
                        console.log(t), u.setData({
                            ckapian: t.data.data
                        }), app.util.request({
                            url: "entry/wxapp/isLuck",
                            cachetime: "0",
                            data: {
                                pid: r,
                                openid: wx.getStorageSync("openid")
                            },
                            success: function(t) {
                                console.log(t), 2 == t.data ? app.util.request({
                                    url: "entry/wxapp/comeActiveMessage",
                                    cachetime: "0",
                                    data: {
                                        active_type: 2,
                                        openid: wx.getStorageSync("openid"),
                                        active_id: r,
                                        form_id: c.detail.formId
                                    },
                                    success: function(t) {}
                                }) : console.log("--------------抽过奖啦-----------------");
                            }
                        }), u.onShow();
                    }
                }), setTimeout(function() {
                    u.setData({
                        hideShopPopup: !1
                    });
                }.bind(this), 500));
            }
        }), setTimeout(function() {
            u.setData({
                flag: "true"
            });
        }, 1e3)) : wx.showToast({
            title: "正在抽奖中...",
            icon: "none",
            duration: 500
        });
    },
    goReceive: function(e) {
        console.log(e);
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/giftOrder",
                    cachetime: "0",
                    data: {
                        id: e.currentTarget.dataset.id,
                        uid: t.data
                    },
                    success: function(t) {
                        (console.log(t), 0 == t.data.data.length) ? a.data.active.active_num <= 0 ? wx.showToast({
                            title: "礼品发放完啦！期待您下次参与！",
                            icon: "none"
                        }) : wx.navigateTo({
                            url: "../jika-success/index?jika=" + e.currentTarget.dataset.id
                        }) : wx.showToast({
                            title: "您已领取！",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    onShareAppMessage: function(t) {
        console.log(t);
        var e = this, a = (t.target.dataset.num, wx.getStorageSync("openid")), o = t.target.dataset.tid;
        return console.log(a), {
            title: t.target.dataset.title,
            path: "chbl_sun/pages/active-list/details?id=" + o + "&type=1",
            success: function(t) {
                console.log("转发成功"), wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/ShareGetNum",
                            cachetime: "0",
                            data: {
                                uid: t.data,
                                id: o
                            },
                            success: function(t) {
                                console.log(t);
                            }
                        }), e.onShow();
                    }
                });
            },
            fail: function(t) {
                console.log("转发失败"), console.log("转发到群聊");
            }
        };
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        a.wxauthSetting(), wx.showShareMenu({
            withShareTicket: !0
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                var e = t.data;
                console.log(e), app.util.request({
                    url: "entry/wxapp/isVip",
                    cachetime: "0",
                    data: {
                        openid: e
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? wx.setStorageSync("is_vip", t.data) : wx.setStorageSync("is_vip", "");
                    }
                }), wx.getStorage({
                    key: "pid",
                    success: function(t) {
                        console.log(t), app.util.request({
                            url: "entry/wxapp/giftData",
                            cachetime: "0",
                            data: {
                                id: t.data,
                                uid: e
                            },
                            success: function(t) {
                                console.log(t), a.setData({
                                    giftData: t.data.data
                                });
                            }
                        }), app.util.request({
                            url: "entry/wxapp/Luck",
                            cachetime: "0",
                            data: {
                                id: t.data,
                                uid: e
                            },
                            success: function(t) {
                                console.log(t), a.setData({
                                    Luck: t.data.data
                                });
                            }
                        });
                    }
                }), console.log(a.data.aid), app.util.request({
                    url: "entry/wxapp/jikaNum",
                    cachetime: "0",
                    data: {
                        uid: e,
                        id: a.data.aid
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            jikaNum: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/system",
                    cachetime: "10",
                    success: function(t) {
                        console.log(t), a.setData({
                            system: t.data
                        });
                    }
                });
            }
        });
    },
    wxauthSetting: function(t) {
        var i = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), i.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), i.setData({
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
                                i.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var a = t.userInfo.nickName, o = t.userInfo.avatarUrl, n = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                                        wx.setStorageSync("openid", t.data.openid);
                                        var e = t.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: o,
                                                name: a,
                                                gender: n
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), i.setData({
                                                    usersinfo: t.data
                                                }), i.onShow();
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
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
                    success: function(t) {
                        i.setData({
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
    },
    createPoster: function(t) {
        var e = "chbl_sun/pages/active-list/details?id=" + wx.getStorageSync("active").id;
        wx.setStorageSync("page", e), console.log(e), wx.navigateTo({
            url: "../poster/poster"
        });
    },
    bindShareTap: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e), console.log(t);
    },
    close: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("250rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    }
});