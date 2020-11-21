var tool = require("../../../../we7/js/utils/countDown.js"), base64 = require("../../../../we7/js/utils/base64.js"), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

Page({
    data: {
        jurisDiction: !1,
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        countDownDay: 0,
        countDownHour: 0,
        countDownMinute: 0,
        countDownSecond: 0,
        mydata: "2018-4-14 10:03:45",
        cardheight: 0,
        luckdrawnum: 10,
        showplay: 0,
        is_modal_Hidden: !0,
        br: [ "../../../../style/images/br.png" ],
        active: ""
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            success: function(t) {
                console.log("你的背景图片是多少"), console.log(t.data.jithumb);
                var e = t.data.jithumb;
                a.setData({
                    jithumb: e
                });
            }
        }), a.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = t.id, n = t.pic, o = t.bid;
        o && wx.setStorageSync("bid", t.bid);
        var s = app.func.decodeScene(t);
        s.id && (e = s.id), s.bid && (o = s.bid), a.setData({
            id: e,
            pic: n
        }), app.util.request({
            url: "entry/wxapp/jkActiveing",
            cachetime: "0",
            data: {
                id: e,
                bid: o
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? a.setData({
                    active: !0
                }) : 2 == t.data ? wx.showModal({
                    title: "提示",
                    content: "活动未开始",
                    showCancel: !1
                }) : wx.setStorageSync("bid", o);
            }
        }), wx.setStorageSync("id", e);
        var i = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/CardIdData",
            cachetime: "0",
            data: {
                id: e,
                openid: i
            },
            success: function(e) {
                console.log(e.data), t && (clearInterval(t), t = 0);
                var t = setInterval(function() {
                    var t = tool.countDown(a, e.data[0].antime);
                    e.data[0].clock = t ? t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : "已经截止", 
                    a.setData({
                        Card: e.data[0]
                    });
                }, 1e3);
            }
        }), wx.getSystemInfo({
            success: function(t) {
                a.setData({
                    cardheight: 495 * t.screenWidth / 750
                });
            }
        }), a.url();
    },
    url: function(t) {
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
        });
    },
    goindex: function(t) {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
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
                                var a = t.userInfo.nickName, n = t.userInfo.avatarUrl, o = t.userInfo.gender;
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
                                        wx.setStorageSync("userid", e), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: a,
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
    },
    luckdraw: function(t) {
        var e = this, a = wx.getStorageSync("bid"), n = this.data.showplay, o = e.data.Card;
        if (console.log(o), 0 < o.num) {
            n = 1, o.num--;
            var s = new Date().valueOf(), i = base64.base64_encode(s + "???alsjdlqkwjlke123654!@#!@81903890"), c = wx.getStorageSync("userid"), r = t.currentTarget.dataset.id;
            app.util.request({
                url: "entry/wxapp/GetCard",
                cachetime: "0",
                data: {
                    pid: r,
                    openid: c,
                    t: i,
                    timestamp: s,
                    bid: a
                },
                success: function(t) {
                    e.setData({
                        kp_img: t.data.img,
                        cardData: t.data.giftData,
                        ling: t.data.ling
                    });
                }
            });
        } else wx.showToast({
            title: "抽奖次数已用完",
            icon: "none",
            duration: 2e3
        });
        e.setData({
            showplay: n,
            Card: o
        });
    },
    luckdraws: function(t) {
        var e = this, a = wx.getStorageSync("bid"), n = this.data.showplay, o = e.data.Card;
        if (0 < o.num) {
            n = 1, o.num--;
            var s = new Date().valueOf(), i = base64.base64_encode(s + "???alsjdlqkwjlke123654!@#!@81903890"), c = wx.getStorageSync("userid"), r = t.currentTarget.dataset.id;
            app.util.request({
                url: "entry/wxapp/GetCard",
                cachetime: "0",
                data: {
                    pid: r,
                    openid: c,
                    t: i,
                    timestamp: s,
                    bid: a
                },
                success: function(t) {
                    console.log(t.data), e.setData({
                        kp_img: t.data.img,
                        cardData: t.data.giftData,
                        ling: t.data.ling
                    });
                }
            });
        } else wx.showToast({
            title: "抽奖次数已用完",
            icon: "none",
            duration: 2e3
        });
        e.setData({
            showplay: n,
            Card: o
        });
    },
    lingjiang: function(e) {
        var t = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/UserIsgift",
            cachetime: "0",
            data: {
                openid: t,
                id: e.currentTarget.dataset.id
            },
            success: function(t) {
                0 == t.data ? wx.showToast({
                    title: "您已领取过该奖品",
                    icon: "none",
                    duration: 2e3
                }) : wx.navigateTo({
                    url: "../prize/prize?id=" + e.currentTarget.dataset.id
                });
            }
        });
    },
    closeplay: function() {
        var t = this.data.showplay;
        t = !t, this.setData({
            showplay: t
        });
    },
    onShareAppMessage: function(t) {
        var a = this, e = wx.getStorageSync("userid"), n = wx.getStorageSync("bid");
        return "button" === t.from && console.log(t.target), app.util.request({
            url: "entry/wxapp/Forwardnum",
            cachetime: "0",
            data: {
                id: a.data.Card.id,
                openid: e
            },
            success: function(t) {
                if (0 < t.data.sharenum) {
                    var e = a.data.Card;
                    e.num = parseInt(e.num) + parseInt(t.data.share_plus), console.log(t.data), console.log(e), 
                    console.log(e.num), console.log(t.data.share_plus), a.setData({
                        Card: e
                    });
                } else wx.showToast({
                    title: "今日分享次数已上限，继续分享无法获得抽奖次数！",
                    icon: "none",
                    duration: 2e3
                });
            }
        }), {
            title: a.data.Card.title,
            path: "ymktv_sun/pages/booking/card/card?id=" + a.data.Card.id + "&bid=" + n,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        o.Branch();
        var t = wx.getStorageSync("id"), e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CardData",
            cachetime: "0",
            data: {
                id: t,
                openid: e
            },
            success: function(t) {
                console.log(t.data);
                for (var e = [], a = 0; a < t.data.length; a++) 0 != t.data[a].num && e.push(t.data[a]);
                if (t.data.length == e.length) var n = 1; else n = 0;
                o.setData({
                    cardData: t.data,
                    ling: n
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getPrompt: function() {
        this.setData({
            value: !0
        });
    },
    shareCanvas: function() {
        var t = this;
        setTimeout(function() {
            t.getPrompt();
        }, 2800);
        var e = wx.getStorageSync("url"), a = wx.getStorageSync("bid"), n = wx.getStorageSync("goodspicbg"), o = (wx.getStorageSync("users"), 
        t.data.Card), s = [];
        s.bname = o.title, s.url = e, s.logo = this.data.pic, s.br = t.data.br[0], s.goodspicbg = n, 
        s.price = o.drink_price, s.scene = "id=" + this.data.id + "&bid=" + a, app.Func.func.creatPoster2("ymktv_sun/pages/booking/card/card", 430, s, 1, "shareImg"), 
        console.log("你的价格呢"), console.log(s.price), t.setData({
            shareMask: !1
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0,
            value: !1
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    unshare: function() {
        this.setData({
            shareMask: !1
        });
    },
    tapShare: function() {
        this.setData({
            shareMask: !0
        });
    },
    Branch: function() {
        var t = this, n = wx.getStorageSync("openid"), o = wx.getStorageSync("isSwitch");
        if (1 == o) var s = 1; else s = 2;
        wx.setStorageSync("Switch", s), n && wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: n,
                        latitude: e,
                        longitude: a,
                        Switch: s,
                        isSwitch: o
                    },
                    success: function(t) {}
                });
            },
            fail: function() {
                t.setData({
                    jurisDiction: !0
                });
            }
        });
    },
    goHome: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    get: function() {
        this.setData({
            jurisDiction: !1
        }), wx.openSetting({
            success: function(t) {
                console.log(t.authSetting), t.authSetting = {
                    "scope.userInfo": !0,
                    "scope.userLocation": !0
                };
            }
        });
    }
});