var t = getApp(), e = require("../../3421FA616A7AF98C524792666BF19D70.js");

Page({
    data: {
        navbar: [],
        img: [],
        swiper: [ "/images/bar-1.png", "/images/bar-1.png" ],
        currentTab: 0,
        isStart: !0,
        location: "",
        nclass: 0,
        identity: "",
        logintag: "",
        my: "",
        status: "",
        latitude: "",
        longitude: "",
        ntype: "",
        nid: "0",
        info: [],
        advertising: "",
        flag: "",
        p: 1,
        namer: "",
        tz: ""
    },
    onLoad: function(t) {
        var e = this;
        console.log(t), void 0 == t || (t.id ? (console.log("有nid"), e.setData({
            nid: t.id,
            ntype: t.ntype
        })) : (console.log("没有nid"), e.setData({
            nid: 0
        })));
        var a = [];
        a = [ [ a = "/images/home.png", "首页" ], [ a = "/images/issue.png", "发布" ], [ a = "/images/my.png", "我的" ] ], 
        e.setData({
            img: a
        }), e.call();
        try {
            (o = wx.getStorageSync("nclass")) && (console.log("nclass:", o), e.setData({
                nclass: o,
                status: o
            }));
        } catch (t) {}
        try {
            (o = wx.getStorageSync("session")) && (console.log("logintag:", o), e.setData({
                logintag: o
            }));
        } catch (t) {}
        try {
            var o = wx.getStorageSync("location");
            o && (console.log("location:", o), e.setData({
                location: o
            }));
        } catch (t) {}
        wx.getSystemInfo({
            success: function(t) {
                console.log("**************************************************"), console.log(t), 
                console.log("**************************************************");
            }
        });
    },
    ononl: function(t) {
        wx.makePhoneCall({
            phoneNumber: "110",
            success: function(t) {
                console.log(t);
            }
        });
    },
    call: function(t) {
        this.login();
    },
    login: function() {
        console.log("index.js => login调用了");
        var e = this;
        wx.login({
            success: function(a) {
                if (console.log("wx.login => 获取code"), console.log(a), a.code) {
                    wx.setStorage({
                        key: "code",
                        data: a.code
                    });
                    var o = a.code, n = e.data.nid, s = e.data.ntype;
                    console.log("index.js => login:" + n), console.log("index.js => login:" + s), wx.request({
                        url: t.data.url + "memberlogin",
                        data: {
                            code: o,
                            nid: n,
                            ntype: s
                        },
                        success: function(t) {
                            console.log("2222222memberlogin => 获取登录信息"), console.log(t), wx.setStorage({
                                key: "session",
                                data: t.data.logintag
                            }), wx.setStorage({
                                key: "nclass",
                                data: t.data.nclass
                            }), e.setData({
                                logintag: t.data.logintag
                            }), t.data.wx_headimg ? e.member_isexist_mobile() : e.getinfo(), "0000" == t.data.retCode && (e.setData({
                                logintag: t.data.logintag
                            }), e.home(), e.my());
                        }
                    });
                } else console.log("获取用户登录态失败！" + a.errMsg);
            }
        });
    },
    getinfo: function() {
        console.log("没有获取微信 => 跳转"), wx.redirectTo({
            url: "/pages/index/getinfo/getinfo"
        });
    },
    tts: function(t) {
        wx.showToast({
            title: "身份相同，不可以点击",
            icon: "none",
            duration: 1e3
        });
    },
    location: function(t) {
        console.log("index.js => location调用了");
        var a = this, o = a.data.location, n = new e({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        });
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, s = t.longitude, i = a.data.nclass;
                console.log("yval:", e), console.log("xval:", s), n.reverseGeocoder({
                    location: {
                        latitude: e,
                        longitude: s
                    },
                    success: function(t) {
                        console.log("index.js => location结果数据"), console.log(t.result.address_component.city);
                        var n = t.result.address_component.city;
                        o ? a.setData({
                            location: o,
                            latitude: e,
                            longitude: s
                        }) : (a.setData({
                            location: n,
                            latitude: e,
                            longitude: s
                        }), wx.setStorage({
                            key: "location",
                            data: n
                        })), 1 == i || 0 == i ? a.passenger_enter_home_task() : a.car_owner_enter_home_task();
                    },
                    fail: function(t) {
                        console.log(t);
                    },
                    complete: function(t) {
                        console.log(t);
                    }
                });
            }
        });
    },
    home: function(e) {
        var a = this, o = a.data.logintag;
        wx.request({
            url: t.data.url + "passenger_search_ad_show",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("home => 获取首页轮播图数据信息"), console.log(t), "0000" == t.data.retCode) {
                    try {
                        var e = wx.getStorageSync("nclass");
                        e && a.setData({
                            nclass: e,
                            status: e
                        });
                    } catch (t) {}
                    var o = t.data.info;
                    if (2 == t.data.nclass) n = ""; else var n = "tzban";
                    a.setData({
                        swiper: o,
                        tz: n
                    }), a.location(), a.bidding_list();
                }
            }
        });
    },
    bidding_list: function(e) {
        var a = this, o = a.data.logintag;
        wx.request({
            url: t.data.url + "bidding_list",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("bidding_list => 获取首页广告数据信息"), console.log(t), "0000" == t.data.retCode) {
                    var e = t.data.info;
                    a.setData({
                        advertising: e
                    });
                } else "没有记录" == t.data.retDesc && a.setData({
                    advertising: []
                });
            }
        });
    },
    passenger_enter_home_task: function(e) {
        var a = this, o = a.data.logintag, n = a.data.location, s = a.data.latitude, i = a.data.longitude;
        console.log("logintag: " + o + " ; location: " + n + " ; latitude: " + s + " ; longitude: " + i), 
        wx.request({
            url: t.data.url + "passenger_enter_home_task",
            data: {
                logintag: o,
                area_name: n,
                yval: s,
                xval: i
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("passenger_enter_home_task => 获取首页乘客查看订单数据信息"), console.log(t), 
                "0000" == t.data.retCode) {
                    var e = t.data.info;
                    a.setData({
                        info: e,
                        namer: "passenger_enter_home_task"
                    });
                } else 2 == t.data.ntype && a.setData({
                    info: []
                });
            }
        });
    },
    car_owner_enter_home_task: function(e) {
        var a = this, o = a.data.logintag, n = a.data.location, s = a.data.latitude, i = a.data.longitude;
        console.log("logintag: " + o + " ; location: " + n), wx.request({
            url: t.data.url + "car_owner_enter_home_task",
            data: {
                logintag: o,
                area_name: n,
                yval: s,
                xval: i
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("car_owner_enter_home_task => 获取首页车主查看订单数据信息"), console.log(t), 
                "0000" == t.data.retCode) {
                    var e = t.data.info;
                    a.setData({
                        info: e,
                        namer: "car_owner_enter_home_task"
                    });
                } else 2 == t.data.ntype && a.setData({
                    info: []
                });
            }
        });
    },
    nclass: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        console.log(a), 1 == a || 0 == a ? (e.setData({
            nclass: "2",
            p: 1,
            namer: "car_owner_enter_home_task"
        }), e.car_owner_enter_home_task()) : (e.setData({
            nclass: "1",
            p: 1,
            namer: "passenger_enter_home_task"
        }), e.passenger_enter_home_task());
    },
    my: function(e) {
        var a = this, o = a.data.logintag;
        wx.request({
            url: t.data.url + "enter_my_center",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("enter_my_center => 获取个人中心数据信息"), console.log(t), "0000" == t.data.retCode) {
                    var e = t.data.info, o = t.data.flag;
                    a.setData({
                        my: e,
                        flag: o
                    });
                }
            }
        });
    },
    sasa: function(t) {
        console.log(t);
    },
    navbarTap: function(t) {
        var e = this, a = e.data.status;
        if (console.log(t.currentTarget.dataset.idx), 1 == t.currentTarget.dataset.idx) console.log("底部导航栏切换 => 跳转发布页面"), 
        console.log(a), 0 == a ? wx.navigateTo({
            url: "/pages/index/issue/identity/identity"
        }) : (console.log(1 == a), 1 == a ? wx.navigateTo({
            url: "issue/issue"
        }) : e.hint()); else {
            if (2 == t.currentTarget.dataset.idx) wx.setNavigationBarTitle({
                title: "我的"
            }), e.my(); else {
                wx.setNavigationBarTitle({
                    title: "顺风车"
                });
                try {
                    var o = wx.getStorageSync("nclass");
                    o && (console.log("nclass:", o), e.setData({
                        nclass: o,
                        status: o
                    }), 1 == o || 0 == o ? (e.passenger_enter_home_task(), console.log("调用了----------passenger_enter_home_task")) : (e.car_owner_enter_home_task(), 
                    console.log("调用了-车主---------car_owner_enter_home_task")), e.bidding_list());
                } catch (t) {}
            }
            this.setData({
                currentTab: t.currentTarget.dataset.idx,
                p: 1
            });
        }
    },
    tzban: function(t) {
        console.log(t.currentTarget.dataset.xcx_path);
        var e = t.currentTarget.dataset.xcx_path;
        e && wx.navigateTo({
            url: e
        });
    },
    hint: function(t) {
        var e = this.data.my.is_audit;
        console.log("车主发布任务，需要认证身份。"), console.log(e), 0 == e ? wx.showModal({
            title: "提示",
            content: "车主发布任务，需要认证身份。",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "/pages/index/authentication/authentication"
                }) : console.log("弹框后点取消");
            }
        }) : 1 == e ? wx.showModal({
            title: "提示",
            content: "认证身份审核中... ",
            success: function(t) {
                t.confirm || console.log("弹框后点取消");
            }
        }) : 3 == e ? wx.showModal({
            title: "提示",
            content: "认证身份被拒绝，请重新申请。 ",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "/pages/index/authentication/authentication"
                }) : console.log("弹框后点取消");
            }
        }) : wx.navigateTo({
            url: "issue/issue"
        });
    },
    search: function(t) {
        wx.navigateTo({
            url: "search/search"
        });
    },
    Advertising: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "Advertising/Advertising?id=" + e
        });
    },
    issue: function(t) {
        var e = this, a = e.data.status;
        0 == a ? wx.navigateTo({
            url: "/pages/index/issue/identity/identity"
        }) : 1 == a ? wx.navigateTo({
            url: "issue/issue"
        }) : e.hint();
    },
    About: function(t) {
        wx.navigateTo({
            url: "About/About"
        });
    },
    award: function(t) {
        wx.navigateTo({
            url: "award/award"
        });
    },
    invitation: function(t) {
        wx.navigateTo({
            url: "invitation/invitation"
        });
    },
    authentication: function(t) {
        wx.navigateTo({
            url: "authentication/authentication"
        });
    },
    wallet: function(t) {
        wx.navigateTo({
            url: "wallet/wallet"
        });
    },
    issuea: function(t) {
        wx.navigateTo({
            url: "issueaa/issueaa"
        });
    },
    personal: function(t) {
        wx.navigateTo({
            url: "personal/personal"
        });
    },
    journey: function(t) {
        wx.navigateTo({
            url: "journey/journey"
        });
    },
    bidding: function(t) {
        wx.navigateTo({
            url: "bidding/bidding"
        });
    },
    phone: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e,
            success: function(t) {
                console.log(t);
            }
        });
    },
    details: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/pages/index/search/information/route/route?nid=" + e
        });
    },
    inform: function(t) {
        wx.navigateTo({
            url: "/pages/index/inform/inform"
        });
    },
    locat: function(t) {
        wx.navigateTo({
            url: "/pages/locat/locat"
        });
    },
    status: function(e) {
        var a = this, o = a.data.logintag, n = a.data.status;
        console.log(n), 2 == n ? wx.setStorage({
            key: "nclass",
            data: "1"
        }) : wx.setStorage({
            key: "nclass",
            data: "2"
        }), wx.request({
            url: t.data.url + "Identity_swap",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("身分互换操作"), console.log(t), "0000" == t.data.retCode ? (wx.showToast({
                    title: "互换成功",
                    icon: "success",
                    duration: 1e3
                }), a.home()) : (wx.showToast({
                    title: t.data.retDesc,
                    icon: "loading",
                    duration: 1e3
                }), "账号已冻结" == t.data.retDesc && wx.navigateTo({
                    url: "/pages/index/index"
                }));
            }
        });
    },
    onReady: function() {},
    onShow: function(e) {
        console.log("生命周期函数--监1213213113212113");
        var a = this;
        try {
            var o = wx.getStorageSync("nclass");
            o && (console.log("nclass:", o), a.setData({
                nclass: o,
                status: o
            }), t.data.QD && (1 == o || 0 == o ? (a.passenger_enter_home_task(), console.log("调用了----------passenger_enter_home_task")) : (a.car_owner_enter_home_task(), 
            console.log("调用了-车主---------car_owner_enter_home_task"))));
        } catch (e) {}
        var n = a.data.currentTab;
        2 !== n ? (console.log("currentTab:", n), a.onLoad()) : a.my();
    },
    member_isexist_mobile: function() {
        var e = this.data.logintag;
        wx.request({
            url: t.data.url + "member_isexist_mobile",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("member_isexist_mobile => 判断有无手机号码"), console.log(t), "0000" == t.data.retCode || "不存在" == t.data.retDesc && wx.showModal({
                    title: "提示",
                    content: "完善个人信息",
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/pages/index/personal/personal"
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, a = e.data.logintag, o = e.data.location, n = e.data.latitude, s = e.data.longitude, i = e.data.namer, l = e.data.currentTab;
        console.log("logintag: " + a + " ; location: " + o + " ; latitude: " + n + " ; longitude: " + s);
        var c = (c = e.data.p) + 1;
        e.setData({
            p: c
        }), console.log(c), console.log(i), 0 == l && i && wx.request({
            url: t.data.url + i,
            data: {
                p: c,
                logintag: a,
                area_name: o,
                yval: n,
                xval: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            method: "GET",
            success: function(t) {
                console.log(t);
                var a = t.data.info, o = e.data.info;
                if ("0000" == t.data.retCode) if ("0" == a.length) ; else {
                    wx.showToast({
                        title: "加载中...",
                        icon: "loading",
                        duration: 1e3,
                        mask: !0
                    }), console.log(a);
                    for (var n = 0; n < a.length; n++) o.push(a[n]);
                    console.log("拼接数据:", o), e.setData({
                        info: o
                    });
                } else if ("账号已冻结" == t.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    onShareAppMessage: function(t) {
        try {
            var e = wx.getStorageSync("ac_nid");
            if (e) {
                console.log("ac_nid:", e);
                var a = e;
                return console.log("分享：", a), console.log("ntype", 1), {
                    title: "拼车",
                    desc: "拼车!",
                    imageUrl: "/images/eqweqw.jpg",
                    path: "/pages/index/index?id=" + a + "&ntype=1"
                };
            }
            return {
                title: "拼车",
                desc: "拼车!",
                imageUrl: "/images/eqweqw.jpg",
                path: "/pages/index/index"
            };
        } catch (t) {}
    }
});