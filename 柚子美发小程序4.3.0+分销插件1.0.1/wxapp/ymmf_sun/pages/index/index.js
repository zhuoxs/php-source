var _data;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: (_data = {
        isIpx: app.globalData.isIpx,
        shopname: "没名堂",
        userInfo: {},
        hasUserInfo: !1,
        imgsrc: "../../../style/images/scissors.png",
        hairUser: [],
        is_modal_Hidden: !0,
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        address: "厦门市集美区",
        jszc: {
            js_name: "",
            js_logo: "",
            js_tel: ""
        },
        notice: [ "通知1", "通知2", "通知3" ]
    }, _defineProperty(_data, "isIpx", app.globalData.isIpx), _defineProperty(_data, "jurisDiction", !1), 
    _defineProperty(_data, "showdefaultnav", !1), _defineProperty(_data, "whichone", 1), 
    _defineProperty(_data, "shopData", {
        isdefault: 1,
        zhoubian: "/style/images/book.png",
        zhou_font: "我要预约",
        guonei: "/style/images/check.png",
        guo_font: "我要买单",
        chujing: "/style/images/card.png",
        chu_font: "卡券中心",
        qianzheng: "/style/images/branch.png",
        qian_font: "更多分店"
    }), _data),
    onLoad: function(t) {
        var a = this;
        a.wxauthSetting(), a.Branch(), t = app.func.decodeScene(t), a.setData({
            options: t
        }), a.setData({
            showAd: !1
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    dongliang: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Indexnew",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    indexnew: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            success: function(t) {
                "" != t.data.data.js_tel && null != t.data.data.js_tel && (a.data.jszc.js_tel = t.data.data.js_tel), 
                "" != t.data.data.js_font && null != t.data.data.js_font && (a.data.jszc.js_font = t.data.data.js_font), 
                "" != t.data.data.js_logo && null != t.data.data.js_logo && (a.data.jszc.js_logo = t.data.data.js_logo), 
                wx.setNavigationBarTitle({
                    title: t.data.data.pt_name
                }), a.setData({
                    shopData: t.data.data,
                    jszc: a.data.jszc
                });
            }
        });
    },
    indexTan: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/IndexTan",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    indexTan: t.data
                });
            }
        });
    },
    Branch: function(t) {
        var n = this, a = wx.getStorageSync("isSwitch"), o = wx.getStorageSync("openid");
        if (1 != a) var s = 2; else s = 1;
        wx.setStorageSync("Switch", s), o && (wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: o,
                        latitude: a,
                        longitude: e,
                        Switch: s
                    },
                    success: function(t) {
                        console.log("你的门店位置是什么哦"), console.log(t.data), n.setData({
                            Branch: t.data
                        }), wx.setStorageSync("build_id", t.data.id);
                        var a = t.data.id;
                        wx.getStorage({
                            key: "openid",
                            success: function(t) {
                                app.util.request({
                                    url: "entry/wxapp/CounpIndex",
                                    cachetime: "0",
                                    data: {
                                        uid: t.data,
                                        build_id: a
                                    },
                                    success: function(t) {
                                        console.log(t.data.data), n.setData({
                                            CounpIndex: t.data.data
                                        });
                                    }
                                });
                            }
                        }), app.util.request({
                            url: "entry/wxapp/Hairers",
                            cachetime: "0",
                            data: {
                                build_id: a
                            },
                            success: function(t) {
                                console.log(t.data), n.setData({
                                    hairers: t.data.data
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {
                console.log(t), console.log("你有打印出来吗"), n.setData({
                    jurisDiction: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/AmountSaveVip",
            cachetime: "0",
            data: {
                openid: o
            }
        }));
    },
    indexTap: function(t) {
        var a = this.data.indexTan.path1;
        console.log(a), wx.navigateTo({
            url: "/" + a
        });
    },
    closeAd: function(t) {
        wx.setStorageSync("showAd", !0), this.setData({
            showAd: !0
        });
    },
    urls: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Banner",
            cachetime: "10",
            success: function(t) {
                console.log(t.data.data), a.setData({
                    banner: t.data.data
                });
            }
        });
    },
    dialogYZ: function(t) {
        var a = this;
        null == a.data.jszc.js_tel || "" == a.data.jszc.js_tel ? wx.makePhoneCall({
            phoneNumber: "0592-666666"
        }) : wx.makePhoneCall({
            phoneNumber: a.data.jszc.js_tel
        });
    },
    goAddress: function(t) {
        wx.openLocation({
            latitude: this.data.Branch.lat,
            longitude: this.data.Branch.lng,
            scale: 28
        });
    },
    onShow: function() {
        var t = this, a = t.data.options;
        console.log("989898999"), console.log(a), a.d_user_id && app.distribution.distribution_parsent(app, a.d_user_id), 
        app.editTabBar();
        wx.getStorageSync("build_id");
        var e = wx.getStorageSync("showAd");
        e && t.setData({
            showAd: e
        }), t.Branch(), t.urls(), t.dongliang(), t.youhui(), t.indexTan(), t.tab(), t.wxauthSetting();
    },
    tab: function() {
        var a = this, e = app.globalData.tabBar, n = e.list, o = wx.getStorageSync("url");
        app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), n[0].text = t.data.index, n[0].iconPath = o + t.data.indeximg, 
                n[0].selectedIconPath = o + t.data.indeximgs, n[1].text = t.data.coupon, n[1].iconPath = o + t.data.couponimg, 
                n[1].selectedIconPath = o + t.data.couponimgs, n[2].text = t.data.fans, n[2].iconPath = o + t.data.fansimg, 
                n[2].selectedIconPath = o + t.data.fansimgs, n[3].text = t.data.mine, n[3].iconPath = o + t.data.mineimg, 
                n[3].selectedIconPath = o + t.data.mineimgs, e.list = n, a.setData({
                    tabBar: e
                });
            }
        });
    },
    wxauthSetting: function(t) {
        var s = this, a = wx.getStorageSync("openid");
        if (a) {
            var e = wx.getStorageSync("user_info"), n = e.nickName, o = e.avatarUrl, i = e.gender;
            app.util.request({
                url: "entry/wxapp/Login",
                cachetime: "0",
                data: {
                    openid: a,
                    img: o,
                    name: n,
                    gender: i
                },
                success: function(t) {
                    s.setData({
                        usersinfo: t.data
                    });
                }
            }), wx.getSetting({
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
                        content: "请允许授权以便为您提供给服务123123",
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
            });
        } else wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var a = t.code;
                wx.setStorageSync("code", a), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var e = t.userInfo.nickName, n = t.userInfo.avatarUrl, o = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: a
                                    },
                                    success: function(t) {
                                        wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                                        var a = t.data.openid;
                                        console.log("进入获取openid"), console.log(t.data.openid), console.log(t.data);
                                        a = t.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: a
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: a,
                                                img: n,
                                                name: e,
                                                gender: o
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), console.log("ceshi-------------------------------"), 
                                                s.onShow(), console.log("ceshi-------------------------------"), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        }), s.onShow();
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
    godetails: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.banner;
        0 == a ? e.bname && wx.navigateTo({
            url: "/" + e.bname
        }) : 1 == a ? e.bname1 && wx.navigateTo({
            url: "/" + e.bname1
        }) : 2 == a ? e.bname2 && wx.navigateTo({
            url: "/" + e.bname2
        }) : e.bname3 && wx.navigateTo({
            url: "/" + e.bname3
        });
    },
    youhui: function() {
        app.util.request({
            url: "entry/wxapp/Counpkaq",
            cachetime: "0",
            success: function(t) {}
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Oldcoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {}
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/deloldcoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {}
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t), wx.setStorageSync("system", t.data), wx.setStorageSync("color", t.data.color), 
                wx.setStorageSync("fontcolor", t.data.fontcolor), wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
    },
    onReady: function() {
        app.getNavList(""), setTimeout(function() {
            wx.hideLoading();
        }, 1e3);
    },
    gotoUrl: function(t) {
        var a = t.currentTarget.dataset.url, e = t.currentTarget.dataset.gotype;
        app.func.gotoUrl(app, this, a, e, []);
    },
    getUserInfo: function(t) {
        app.globalData.userInfo = t.detail.userInfo, this.setData({
            userInfo: t.detail.userInfo,
            hasUserInfo: !0
        });
    },
    dialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.phone
        });
    },
    coupon: function(t) {
        var a = this, e = t.currentTarget.dataset.status, n = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id, s = a.data.CounpIndex;
        if ("1" == e) s[n].status = 2, a.setData({
            CounpIndex: s
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/lingCounp",
                    cachetime: "0",
                    data: {
                        id: o,
                        uid: t.data,
                        status: e
                    },
                    success: function(t) {
                        console.log(t), t.data.data && wx.showToast({
                            title: "领取成功！"
                        });
                    }
                }), a.onShow();
            }
        }); else {
            if ("2" != e) return !1;
            wx.showModal({
                content: "您已经领取过优惠券啦~",
                showCancel: !1,
                success: function(t) {}
            });
        }
    },
    order: function(t) {
        wx.navigateTo({
            url: "hairs/hairs"
        });
    },
    pay: function(t) {
        wx.navigateTo({
            url: "pay/pay"
        });
    },
    cards: function(t) {
        wx.navigateTo({
            url: "card/card"
        });
    },
    more: function(t) {
        wx.navigateTo({
            url: "shop/shop"
        });
    },
    styorder: function(t) {
        wx.navigateTo({
            url: "order/order?id=" + t.currentTarget.dataset.id
        });
    },
    stylist: function(t) {
        wx.navigateTo({
            url: "stylist/stylist?id=" + t.currentTarget.dataset.id
        });
    },
    onShareAppMessage: function(t) {
        return {
            path: "/ymmf_sun/pages/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    get: function() {
        this.setData({
            jurisDiction: !1
        }), console.log("你没有授权吗"), wx.openSetting({
            success: function(t) {
                console.log(t.authSetting), t.authSetting = {
                    "scope.userInfo": !0,
                    "scope.userLocation": !0
                };
            }
        });
    }
});