var tool = require("../../../../we7/js/utils/countDown.js"), app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        jurisDiction: !1,
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        is_modal_Hidden: !0,
        br: [ "../../../../style/images/br.png" ],
        active: !1
    },
    onLoad: function(t) {
        var o = this;
        console.log(t), o.wxauthSetting();
        var e = t.id, n = t.bid;
        n && wx.setStorageSync("bid", t.bid);
        var a = t.pic, i = app.func.decodeScene(t);
        i.id && (e = i.id), i.bid && (n = i.bid), o.setData({
            id: e,
            pic: a
        }), app.util.request({
            url: "entry/wxapp/kjActiveStatus2",
            cachetime: "0",
            data: {
                id: e,
                bid: n
            },
            success: function(t) {
                console.log(t.data), 2 == t.data ? o.setData({
                    active: !0
                }) : 0 == t.data ? wx.showModal({
                    title: "提示",
                    content: "活动未开始",
                    showCancel: !1
                }) : wx.setStorageSync("bid", n);
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), o.url(), app.util.request({
            url: "entry/wxapp/Nowkangood",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(e) {
                console.log(e.data), t && (clearInterval(t), t = 0);
                var t = setInterval(function() {
                    var t = tool.countDown(o, e.data[0].endtime);
                    e.data[0].clock = t ? t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : "已经截止", 
                    o.setData({
                        Nowgood: e.data[0]
                    });
                }, 1e3);
            }
        });
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
    gobargaindetail: function(e) {
        console.log(e);
        var o = e.currentTarget.dataset.id, n = wx.getStorageSync("bid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/findkan",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        id: o
                    },
                    success: function(t) {
                        2 == t.data ? wx.getStorage({
                            key: "openid",
                            success: function(t) {
                                app.util.request({
                                    url: "entry/wxapp/kanstart",
                                    cachetime: "0",
                                    data: {
                                        openid: t.data,
                                        id: o
                                    },
                                    success: function(t) {
                                        wx.navigateTo({
                                            url: "../bargaindetail/bargaindetail?id=" + e.currentTarget.dataset.id + "&price=" + t.data + "&bid=" + n
                                        });
                                    }
                                });
                            }
                        }) : 1 == t.data ? wx.navigateTo({
                            url: "../bargaindetail/bargaindetail?id=" + e.currentTarget.dataset.id + "&bid=" + n
                        }) : 4 == t.data ? wx.showModal({
                            title: "提示",
                            content: "您已参与过该活动！",
                            showCancel: !1
                        }) : wx.showModal({
                            title: "提示",
                            content: "活动已结束",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    },
    onShareAppMessage: function(t) {
        var e = wx.getStorageSync("bid"), o = this.data.Nowgood.id;
        return "button" === t.from && console.log(t.target), {
            title: this.data.Nowgood.gname,
            path: "ymktv_sun/pages/booking/bargain/bargain?id=" + o + "&bid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    onShow: function() {},
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
        var e = wx.getStorageSync("bid"), o = wx.getStorageSync("url"), n = t.data.pic;
        console.log("有图片地址吗"), console.log(n);
        var a = wx.getStorageSync("goodspicbg"), i = (wx.getStorageSync("users"), t.data.Nowgood), s = t.data.Nowgood.gname, c = [];
        c.bname = s, c.url = o, c.logo = this.data.pic, c.br = t.data.br[0], c.goodspicbg = a, 
        c.price = i.shopprice, c.scene = "id=" + this.data.id + "&bid=" + e, app.Func.func.creatPoster2("ymktv_sun/pages/booking/bargain/bargain", 430, c, 2, "shareImg"), 
        console.log("你的价格呢"), console.log(c.price), t.setData({
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
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
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
                                var o = t.userInfo.nickName, n = t.userInfo.avatarUrl, a = t.userInfo.gender;
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
                                                name: o,
                                                gender: a
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), i.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        }), i.onShow();
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(t) {
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
    Branch: function() {
        var t = this, n = wx.getStorageSync("openid"), a = wx.getStorageSync("isSwitch");
        if (1 == a) var i = 1; else i = 2;
        wx.setStorageSync("Switch", i), n && wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, o = t.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: n,
                        latitude: e,
                        longitude: o,
                        Switch: i,
                        isSwitch: a
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