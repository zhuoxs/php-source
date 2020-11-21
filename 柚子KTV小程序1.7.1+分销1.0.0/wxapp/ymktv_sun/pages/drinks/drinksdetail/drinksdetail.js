var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        jurisDiction: !1,
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        bannerHeight: 0,
        showplay: 0,
        showplay2: 0,
        title: "雪津啤酒+美味水果",
        numvalue: 1,
        value: !1,
        is_modal_Hidden: !0,
        br: [ "../../../../style/images/br.png" ],
        active: ""
    },
    onLoad: function(t) {
        var e = this;
        e.wxauthSetting();
        var a = t.id, n = t.bid;
        n && wx.setStorageSync("bid", t.bid);
        var o = app.func.decodeScene(t);
        o.id && (a = o.id), o.bid && (n = o.bid), e.setData({
            id: a
        }), app.util.request({
            url: "entry/wxapp/JsActiveing",
            cachetime: "0",
            data: {
                id: a,
                bid: n
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? e.setData({
                    active: !0
                }) : wx.setStorageSync("bid", n);
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), e.url();
        var s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/drinkIdData",
            cachetime: "0",
            data: {
                id: a,
                openid: s
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    drinkDetails: t.data
                });
            }
        }), wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    bannerHeight: 36 * t.screenWidth / 75
                });
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
    goGiftorder: function() {
        this.closeplay(), wx.navigateTo({
            url: "../giftorder/giftorder"
        });
    },
    showplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 1
        });
    },
    goindex: function(t) {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    showplay2: function() {
        this.data.showplay2;
        this.setData({
            showplay2: 1
        });
    },
    closeplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 0
        });
    },
    closeplay2: function() {
        this.data.showplay2;
        this.setData({
            showplay2: 0
        });
    },
    addnum: function(t) {
        var e = this.data.numvalue + 1;
        this.setData({
            numvalue: e
        });
    },
    subbnum: function(t) {
        var e = this.data.numvalue;
        1 < this.data.numvalue && (e = this.data.numvalue - 1), this.setData({
            numvalue: e
        });
    },
    wxalert: function(t) {
        var e = t.currentTarget.dataset.id, a = wx.getStorageSync("bid"), n = this.data.numvalue;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/CartData",
                    cachetime: "0",
                    data: {
                        id: e,
                        bid: a,
                        num: n,
                        openid: t.data
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "添加成功",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        }), this.closeplay();
    },
    goImmediately: function(t) {
        var e = wx.getStorageSync("bid");
        this.closeplay2(), wx.navigateTo({
            url: "../immediately/immediately?id=" + t.currentTarget.dataset.id + "&num=" + this.data.numvalue + "&bid=" + e
        });
    },
    goCar: function() {
        this.closeplay2(), wx.navigateTo({
            url: "../car/car"
        });
    },
    onShareAppMessage: function(t) {
        var e = wx.getStorageSync("bid");
        return "button" === t.from && console.log(t.target), {
            title: this.data.Card.title,
            path: "ymktv_sun/pages/drinks/drinksdetail/drinksdetail?id=" + this.data.drinkDetails.id + "&bid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    },
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
        t.data.drinkDetails), s = [];
        s.bname = o.drink_name, s.url = e, s.logo = o.z_imgs, s.goodspicbg = n, s.br = t.data.br[0], 
        s.price = o.drink_price, s.scene = "id=" + this.data.id + "&bid=" + a, app.Func.func.creatPoster2("ymktv_sun/pages/drinks/drinksdetail/drinksdetail", 430, s, 1, "shareImg"), 
        t.setData({
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
    onShow: function() {
        this.Branch();
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