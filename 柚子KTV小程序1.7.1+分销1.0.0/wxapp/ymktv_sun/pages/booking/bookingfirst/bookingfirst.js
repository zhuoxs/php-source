var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        jurisDiction: !1,
        imgUrls: [ "../../../../ymktv_sun/resource/images/card/banner.jpg", "https://p1.meituan.net/movie/dc1f94811793e9c653170cba7b05bf3e484939.jpg", "../../../../ymktv_sun/resource/images/card/banner.jpg" ],
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        showplay: 0,
        money: "66-168",
        bookinglongindex: 0,
        is_modal_Hidden: !0,
        br: [ "../../../../style/images/br.png" ],
        active: ""
    },
    onLoad: function(e) {
        console.log(e);
        var t = this;
        t.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = e.id, a = e.bid, n = e.pic, s = app.func.decodeScene(e);
        s.id && (o = s.id), s.bid && (a = s.bid), t.setData({
            id: o,
            pic: n
        }), app.util.request({
            url: "entry/wxapp/Activeing",
            cachetime: "0",
            data: {
                id: o,
                bid: a
            },
            success: function(e) {
                console.log(e.data), 1 == e.data ? t.setData({
                    active: !0
                }) : wx.setStorageSync("bid", a);
            }
        }), t.url();
        var i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/RoomDetails",
            cachetime: "10",
            data: {
                id: o,
                openid: i
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    details: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "10",
            success: function(e) {
                console.log(e.data), t.setData({
                    phone: e.data.jie_tel
                });
            }
        }), wx.getSystemInfo({
            success: function(e) {
                t.setData({
                    bannerHeight: 36 * e.screenWidth / 75
                });
            }
        }), 0 != e.bid && app.util.request({
            url: "entry/wxapp/buildDetail",
            cahcetime: "0",
            data: {
                id: e.bid
            },
            success: function(e) {
                t.setData({
                    build_name: e.data.b_name,
                    tel: e.data.tel
                });
            }
        });
    },
    url: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    goBookingsecond: function(e) {
        var t = wx.getStorageSync("bid");
        this.closeplay(), console.log(e), wx.navigateTo({
            url: "../bookingsecond/bookingsecond?gid=" + e.currentTarget.dataset.gid + "&spec=" + e.currentTarget.dataset.spec + "&bid=" + t
        });
    },
    showplay: function() {
        var e = this;
        e.data.showplay;
        console.log(e.data.details);
        var t = e.data.details.shichang[0];
        e.setData({
            showplay: 1,
            spec: t,
            gid: e.data.details.id
        });
    },
    closeplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 0
        });
    },
    chosetime: function(e) {
        var t = e.currentTarget.dataset.index, o = e.currentTarget.dataset.id, a = this.data.bookinglongindex, n = e.currentTarget.dataset.spec;
        a = t, this.setData({
            bookinglongindex: a,
            spec: n,
            gid: o
        });
    },
    onShareAppMessage: function() {
        var t = this, e = t.data.details.id, o = wx.getStorageSync("bid");
        return "button" === res.from && console.log(res.target), {
            title: t.data.details.goods_name,
            path: "ymktv_sun/pages/booking/bargaindetail/bargaindetail?id=" + e + "&bid=" + o,
            success: function(e) {
                t.closeplay();
            },
            fail: function(e) {
                t.closeplay();
            }
        };
    },
    goindex: function(e) {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    getPrompt: function() {
        this.setData({
            value: !0
        });
    },
    shareCanvas: function() {
        var e = this;
        setTimeout(function() {
            e.getPrompt();
        }, 2800);
        var t = wx.getStorageSync("url"), o = wx.getStorageSync("bid"), a = wx.getStorageSync("goodspicbg"), n = (wx.getStorageSync("users"), 
        e.data.details), s = [];
        s.bname = n.goods_name, s.url = t, s.logo = this.data.pic, s.goodspicbg = a, s.price = n.goods_price, 
        s.br = e.data.br[0], s.scene = "id=" + this.data.id + "&bid=" + o, app.Func.func.creatPoster2("ymktv_sun/pages/booking/bookingfirst/bookingfirst", 430, s, 1, "shareImg"), 
        console.log("你的价格呢"), console.log(s.price), e.setData({
            shareMask: !1
        });
    },
    hidden: function(e) {
        this.setData({
            hidden: !0,
            value: !1
        });
    },
    save: function() {
        var t = this;
        wx.saveImageToPhotosAlbum({
            filePath: t.data.prurl,
            success: function(e) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            hidden: !0,
                            value: !1
                        }));
                    }
                });
            },
            fail: function(e) {
                console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
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
    wxauthSetting: function(e) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
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
                                var o = e.userInfo.nickName, a = e.userInfo.avatarUrl, n = e.userInfo.gender;
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
                                        wx.setStorageSync("userid", t), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: a,
                                                name: o,
                                                gender: n
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        }), s.onShow();
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
    Branch: function() {
        var e = this, a = wx.getStorageSync("openid"), n = wx.getStorageSync("isSwitch");
        if (1 == n) var s = 1; else s = 2;
        wx.setStorageSync("Switch", s), a && wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var t = e.latitude, o = e.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: a,
                        latitude: t,
                        longitude: o,
                        Switch: s,
                        isSwitch: n
                    },
                    success: function(e) {}
                });
            },
            fail: function() {
                e.setData({
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
            success: function(e) {
                console.log(e.authSetting), e.authSetting = {
                    "scope.userInfo": !0,
                    "scope.userLocation": !0
                };
            }
        });
    },
    callphone: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    }
});