var cdInterval_kj, cdInterval_jk, tool = require("../../../../we7/js/utils/countDown.js"), originalData = require("../../../../we7/js/utils/data.js"), app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        jurisDiction: !1,
        hidden: !0,
        navList: [ {
            herf: "goGiftindex",
            imgSrc: "../../../resource/images/new/indexnav1.png",
            txt: "兑换"
        }, {
            herf: "goVipindex",
            imgSrc: "../../../resource/images/new/indexnav2.png",
            txt: "会员"
        }, {
            herf: "goWineindex",
            imgSrc: "../../../resource/images/new/indexnav3.png",
            txt: "存酒"
        }, {
            herf: "goInn",
            imgSrc: "../../../resource/images/new/indexnav4.png",
            txt: "门店"
        } ],
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        countDownDay: 0,
        countDownHour: 0,
        countDownMinute: 0,
        countDownSecond: 0,
        activeIndex: 0,
        sliderOffset: 0,
        sliderLeft: 0,
        shop: [],
        jszc: {
            js_tel: "",
            js_font: "",
            js_logo: ""
        },
        jicard: "",
        is_modal_Hidden: !0,
        showdefaultnav: !1,
        tabBarList: [ {
            state: !0,
            url: "goIndex",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goDrinks",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goPublish",
            publish: !1,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goDiscover",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        }, {
            state: !1,
            url: "goMy",
            publish: !0,
            text: "",
            iconPath: "",
            selectedIconPath: ""
        } ],
        whichone: 1
    },
    onLoad: function(t) {
        var a = this;
        t = app.func.decodeScene(t), a.setData({
            options: t
        }), a.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
        var e = wx.getStorageSync("url");
        console.log(e), a.setData({
            url: e
        }), a.shop(), app.util.request({
            url: "entry/wxapp/Roomcate",
            cachetime: "0",
            success: function(e) {
                a.setData({
                    tabs: e.data
                }), wx.getSystemInfo({
                    success: function(t) {
                        a.setData({
                            sliderLeft: t.windowWidth / e.data.length / 2,
                            sliderOffset: t.windowWidth / e.data.length * a.data.activeIndex
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Banner",
            cachetime: "10",
            data: {
                location: 1
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    banner: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/poster",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    poster: t.data
                }), wx.setStorageSync("goodspicbg", t.data.poster_imgs);
            }
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    gotoUrl: function(t) {
        var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.gotype;
        app.func.gotoUrl(app, this, e, a, []);
    },
    shareCanvas: function() {
        var t = this, e = "ymktv_sun/pages/booking/index/index?d_user_id=" + wx.getStorageSync("users").id, a = (t.data.product, 
        []);
        a.bname = t.data.Branch.b_name, a.font = t.data.poster.poster_font, a.logo = t.data.poster.poster_imgs, 
        a.url = t.data.url, console.log(a), app.func.creatPoster(app, e, 430, a, 1, "shareImg");
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
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
    Branch: function(t) {
        var n = this, o = wx.getStorageSync("openid"), i = wx.getStorageSync("isSwitch");
        if (1 == i) var s = 1; else s = 2;
        wx.setStorageSync("Switch", s), o && wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: o,
                        latitude: e,
                        longitude: a,
                        Switch: s,
                        isSwitch: i
                    },
                    success: function(t) {
                        console.log(t.data), n.setData({
                            Branch: t.data
                        }), wx.setStorageSync("bid", t.data.id), n.Moroom();
                        var e = t.data.id;
                        app.util.request({
                            url: "entry/wxapp/indexCard",
                            cachetime: "0",
                            data: {
                                bid: e
                            },
                            success: function(e) {
                                console.log(e.data[0]), "" != e.data[0] && (cdInterval_jk && (clearInterval(cdInterval_jk), 
                                cdInterval_jk = 0), cdInterval_jk = setInterval(function() {
                                    var t = tool.countDown(n, e.data[0].antime);
                                    e.data[0].clock = t ? t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : "已经截止", 
                                    console.log("jk"), n.setData({
                                        jicard: e.data[0]
                                    });
                                }, 1e3));
                            }
                        }), app.util.request({
                            url: "entry/wxapp/indexbargain",
                            cachetime: "0",
                            data: {
                                bid: e
                            },
                            success: function(e) {
                                console.log(e.data), "" != e.data[0] && (cdInterval_kj && (clearInterval(cdInterval_kj), 
                                cdInterval_kj = 0), cdInterval_kj = setInterval(function() {
                                    var t = tool.countDown(n, e.data[0].endtime);
                                    e.data[0].clock = t ? t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : "已经截止", 
                                    n.setData({
                                        kanbargain: e.data[0]
                                    });
                                }, 1e3));
                            }
                        });
                    }
                });
            },
            fail: function() {
                console.log("你有打印出来吗"), n.setData({
                    jurisDiction: !0
                });
            }
        });
    },
    Moroom: function(t) {
        var e = this, a = wx.getStorageSync("bid"), n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/MoRoom",
            cachetime: "0",
            data: {
                bid: a,
                openid: n
            },
            success: function(t) {
                e.setData({
                    RoomData: t.data
                });
            }
        });
    },
    closeAd: function(t) {
        app.globalData.adBtn = !0, this.onShow();
    },
    goUrl: function(t) {
        var e = this.data.indexTan;
        wx.navigateTo({
            url: "/" + e.path1
        });
    },
    shop: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), wx.setStorageSync("color", t.data.color), wx.setStorageSync("fontcolor", t.data.fontcolor), 
                wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), wx.setNavigationBarTitle({
                    title: t.data.pt_name
                }), "" != t.data.js_tel && null != t.data.js_tel && (e.data.jszc.js_tel = t.data.js_tel), 
                "" != t.data.js_font && null != t.data.js_font && (e.data.jszc.js_font = t.data.js_font), 
                "" != t.data.js_logo && null != t.data.js_logo && (e.data.jszc.js_logo = t.data.js_logo), 
                console.log(e.data.jszc), e.setData({
                    shop: t.data,
                    jszc: e.data.jszc
                });
            }
        });
    },
    dianhua: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.Branch.tel,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    dianbo: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.js_tel,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    godaohang: function(t) {
        wx.openLocation({
            latitude: this.data.Branch.lat,
            longitude: this.data.Branch.lng,
            scale: 28
        });
    },
    tabClick: function(t) {
        var e = this, a = wx.getStorageSync("bid"), n = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/RoomData",
            cachetime: "10",
            data: {
                id: n,
                bid: a,
                openid: o
            },
            success: function(t) {
                e.setData({
                    RoomData: t.data
                });
            }
        }), e.setData({
            sliderOffset: t.currentTarget.offsetLeft,
            activeIndex: t.currentTarget.id
        });
    },
    goCollectlist: function(t) {
        1 == this.data.shop.is_jkopen ? wx.navigateTo({
            url: "/ymktv_sun/pages/booking/collectlist/collectlist"
        }) : wx.showToast({
            title: "该活动尚未开启！",
            icon: "none",
            duration: 2e3
        });
    },
    goBargainlist: function(t) {
        1 == this.data.shop.is_bargainopen ? wx.navigateTo({
            url: "/ymktv_sun/pages/booking/bargainlist/bargainlist"
        }) : wx.showToast({
            title: "该活动尚未开启！",
            icon: "none",
            duration: 2e3
        });
    },
    goCard: function(e) {
        var a = wx.getStorageSync("bid"), n = e.currentTarget.dataset.pic;
        app.util.request({
            url: "entry/wxapp/jkActiveStatus",
            cachetime: "0",
            data: {
                id: e.currentTarget.dataset.id
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? wx.navigateTo({
                    url: "/ymktv_sun/pages/booking/card/card?id=" + e.currentTarget.dataset.id + "&bid=" + a + "&pic=" + n
                }) : 0 == t.data ? wx.showToast({
                    title: "活动尚未开始！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "活动已结束！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    goBargain: function(e) {
        var a = wx.getStorageSync("bid"), n = e.currentTarget.dataset.pic;
        app.util.request({
            url: "entry/wxapp/kjActiveStatus",
            cachetime: "0",
            data: {
                id: e.currentTarget.dataset.id
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? wx.navigateTo({
                    url: "/ymktv_sun/pages/booking/bargain/bargain?id=" + e.currentTarget.dataset.id + "&bid=" + a + "&pic=" + n
                }) : 0 == t.data ? wx.showToast({
                    title: "活动尚未开始！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "活动已结束！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    goBookingfirst: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.pic, n = wx.getStorageSync("bid");
        this.setData({
            activeIndex: 0
        }), wx.navigateTo({
            url: "/ymktv_sun/pages/booking/bookingfirst/bookingfirst?id=" + e + "&bid=" + n + "&pic=" + a
        });
    },
    goDrinks: function() {
        var t = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/drinks/drinks/drinks?bid=" + t
        });
    },
    goPublish: function() {
        1 == this.data.tab.is_fbopen ? wx.reLaunch({
            url: "/ymktv_sun/pages/publish/publish/publish"
        }) : wx.reLaunch({
            url: ""
        });
    },
    goDiscover: function() {
        1 == this.data.tab.is_fbopen ? wx.reLaunch({
            url: "/ymktv_sun/pages/discover/discover/discover"
        }) : wx.reLaunch({
            url: ""
        });
    },
    goMy: function() {
        var t = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/my/my/my?bid=" + t
        });
    },
    goGiftindex: function() {
        wx.navigateTo({
            url: "../../my/giftindex/giftindex"
        });
    },
    goVipindex: function() {
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/shopIsvipopen",
            cachetime: "0",
            success: function(t) {
                1 == t.data ? app.util.request({
                    url: "entry/wxapp/UserIsVip",
                    cachetime: "0",
                    data: {
                        openid: e
                    },
                    success: function(t) {
                        wx.navigateTo({
                            url: "../vipsuper/vipsuper"
                        });
                    }
                }) : wx.showToast({
                    title: "暂未开启该功能！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    goWineindex: function() {
        wx.navigateTo({
            url: "../wineindex/wineindex"
        });
    },
    goInn: function() {
        wx.navigateTo({
            url: "../inn/inn"
        });
    },
    goTurntable: function() {
        wx.navigateTo({
            url: "../turntable/turntable"
        });
    },
    goHot: function() {
        wx.navigateTo({
            url: "../hot/hot"
        });
    },
    goHotdetail: function() {
        wx.navigateTo({
            url: "../hotdetail/hotdetail"
        });
    },
    onShow: function() {
        var a = this, t = a.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), a.Branch(), 
        a.setData({
            adBtn: app.globalData.adBtn
        }), app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                console.log(t.data);
                var e = a.data.tabBarList;
                e[0].text = t.data.index, e[0].iconPath = t.data.indeximg, e[0].selectedIconPath = t.data.indeximgs, 
                e[1].text = t.data.coupon, e[1].iconPath = t.data.couponimg, e[1].selectedIconPath = t.data.couponimgs, 
                e[2].text = t.data.fans, e[2].iconPath = t.data.fansimg, e[2].selectedIconPath = t.data.fansimgs, 
                e[3].text = t.data.find, e[3].iconPath = t.data.findimg, e[3].selectedIconPath = t.data.findimgs, 
                e[4].text = t.data.mine, e[4].iconPath = t.data.mineimg, e[4].selectedIconPath = t.data.mineimgs, 
                0 == t.data.is_fbopen ? e.splice(2, 2) : e = e, app.globalData.tabBarList = e, wx.setStorageSync("tab", t.data), 
                a.setData({
                    tabBarList: e,
                    tab: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/indexTan",
            cachetime: "10",
            success: function(t) {
                console.log(t.data), a.setData({
                    indexTan: t.data
                });
            }
        });
        var e = wx.getStorageSync("openid");
        e && app.util.request({
            url: "entry/wxapp/RefreshCard",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t.data);
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
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo), 
                                wx.setStorageSync("userInfo", t.userInfo);
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
                                        console.log(e), wx.setStorageSync("userid", t.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), console.log(a), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), i.onShow(), wx.setStorageSync("users", t.data), 
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
    onHide: function() {
        clearInterval(cdInterval_jk), clearInterval(cdInterval_kj);
    },
    onUnload: function() {
        clearInterval(cdInterval_jk), clearInterval(cdInterval_kj);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        return {
            path: "/ymktv_sun/pages/booking/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
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