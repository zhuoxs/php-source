var _data;

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page({
    data: (_data = {
        navTile: "开通会员",
        curIndex: 0,
        nav: [ "开通会员", "激活码", "会员权益" ],
        cards: [],
        jhm: "",
        yqm: "",
        isopenyqm: 0,
        is_modal_Hidden: !0,
        isclick: !1,
        member: [],
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        isshowpay: 0,
        page: 1,
        phoneNum: "",
        welfareList: [],
        hk_userrules: "",
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        totalprice: 0,
        id: 0
    }, _defineProperty(_data, "welfareList", []), _defineProperty(_data, "list", {
        load: !1,
        over: !1,
        page: 1,
        length: 10,
        none: !1,
        data: []
    }), _defineProperty(_data, "sort", [ {
        sort: 0,
        name: "全部"
    } ]), _defineProperty(_data, "type", 0), _defineProperty(_data, "curIndexs", 0), 
    _defineProperty(_data, "modal", 0), _defineProperty(_data, "detail", "发送验证码"), _defineProperty(_data, "lenth", 6), 
    _defineProperty(_data, "isFocus", !0), _defineProperty(_data, "Value", ""), _defineProperty(_data, "sends", !0), 
    _defineProperty(_data, "setInter", ""), _defineProperty(_data, "num", 60), _defineProperty(_data, "name", ""), 
    _defineProperty(_data, "isJH", 0), _defineProperty(_data, "currenttab", 1), _data),
    onLoad: function(e) {
        var d = this;
        d.setData({
            options: e
        }), console.log(e), e.cur && d.navMember(e.cur), wx.setNavigationBarTitle({
            title: d.data.navTile
        });
        var a = app.getSiteUrl();
        d.setData({
            url: a
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var a = d.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                d.setData({
                    vipChoose: e.data,
                    choose: a,
                    hk_userrules: e.data.hk_userrules
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetActiveLog",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), 2 == e.data ? d.setData({
                    member: []
                }) : d.setData({
                    member: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetShareCondition",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), 1 == e.data ? d.setData({
                    isopenyqm: e.data
                }) : d.setData({
                    isopenyqm: 0
                });
            }
        }), console.log(d.data.nav), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 6,
                uid: wx.getStorageSync("users").id
            },
            cachetime: "0",
            success: function(e) {
                if (console.log(e.data), 0 < e.data.isopen - 0) {
                    console.log(11111111), console.log(e);
                    var o = d.data.nav;
                    o[2] = e.data.navname;
                    var s = e.data.pic, r = e.data.user, i = e.data.isname, u = e.data.ismsg;
                    return console.log(o), new Promise(function(a, e) {
                        app.util.request({
                            url: "entry/wxapp/membertype",
                            data: {
                                m: app.globalData.Plugin_member
                            },
                            success: function(e) {
                                a(e.data), console.log(e);
                            }
                        });
                    }).then(function(n) {
                        wx.getLocation({
                            type: "wgs84",
                            success: function(e) {
                                var a = e.latitude, t = e.longitude;
                                app.util.request({
                                    url: "entry/wxapp/memberbrand",
                                    data: {
                                        lat: a,
                                        lon: t,
                                        type: 0,
                                        page: d.data.list.page,
                                        m: app.globalData.Plugin_member
                                    },
                                    success: function(e) {
                                        var a;
                                        console.log(e);
                                        var t = d.data.sort.concat(n);
                                        d.setData((_defineProperty(a = {
                                            sort: t
                                        }, "list.data", e.data), _defineProperty(a, "nav", o), _defineProperty(a, "pics", s), 
                                        _defineProperty(a, "member_open", 1), _defineProperty(a, "users", r), _defineProperty(a, "isnum", r.isnum - 0 == 1), 
                                        _defineProperty(a, "isuname", r.isuname - 0 == 1), _defineProperty(a, "isname", i), 
                                        _defineProperty(a, "ismsg", u), _defineProperty(a, "name", r.uname), a));
                                    }
                                });
                            }
                        });
                    });
                }
                2 == e.data && (console.log(22222222), d.setData({
                    member_open: 0
                }), d.getFree());
            }
        }), d.getVip(), d.getMemberRight(), d.getMembershipExclusive();
    },
    onReady: function() {},
    onShareAppMessage: function(e) {
        return {
            title: "开通会员",
            path: "/mzhk_sun/pages/member/member?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    toIndex: function(e) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var e = a.data.options;
        e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id);
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/VIP",
            data: {
                openid: t
            },
            success: function(e) {
                console.log(e), a.setData({
                    cards: e.data.vip,
                    phoneNum: e.data.telphone
                });
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (2 == this.data.curIndex && 1 == this.data.member_open) this.loadList(); else {
            var t = this, n = t.data.page, o = t.data.welfareList;
            app.util.request({
                url: "entry/wxapp/Free",
                data: {
                    page: n,
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (console.log(e.data), 2 == e.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = e.data;
                        o = o.concat(a), t.setData({
                            welfareList: o,
                            page: n + 1
                        });
                    }
                }
            });
        }
    },
    navMember: function(e) {
        this.setData({
            curIndex: e
        });
    },
    navTap: function(e) {
        var a = parseInt(e.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    bindInput: function(e) {
        var a = parseInt(e.currentTarget.dataset.type);
        1 == a ? this.setData({
            jhm: e.detail.value
        }) : 2 == a ? this.setData({
            phoneNum: e.detail.value
        }) : 3 == a ? this.setData({
            yqm: e.detail.value
        }) : 4 == a && this.setData({
            name: e.detail.value
        });
    },
    submitJH: function(e) {
        var a = this, t = this.data.jhm, n = this.data.yqm, o = a.data.isopenyqm, s = wx.getStorageSync("openid");
        if ("" == t || null == t) return wx.showModal({
            content: "请输入激活码！！！",
            showCancel: !0,
            success: function(e) {}
        }), !1;
        if (1 == o && ("" == n || t == n)) return wx.showModal({
            content: "请输入邀请码！！！",
            showCancel: !0,
            success: function(e) {}
        }), !1;
        var r = a.data.phoneNum;
        if (1 == a.data.member_open) {
            if (!(1 != a.data.isname || a.data.name && a.data.phoneNum && "" != a.data.phoneNum && r && "" != r)) return wx.showToast({
                title: "用户信息填写错误",
                duration: 2e3,
                icon: "none"
            }), !1;
            app.util.request({
                url: "entry/wxapp/recordphone",
                data: {
                    uid: wx.getStorageSync("users").id,
                    phone: a.data.phoneNum,
                    name: a.data.name,
                    m: app.globalData.Plugin_member
                },
                success: function(e) {
                    console.log(e), a.setData({
                        isJH: 1
                    }), 0 == a.data.ismsg ? app.util.request({
                        url: "entry/wxapp/MUMVIP",
                        data: {
                            jhm: t,
                            yqm: n,
                            openid: s,
                            phone: r
                        },
                        success: function(e) {
                            console.log(e), wx.showModal({
                                content: "恭喜你，激活成功啦~",
                                showCancel: !0,
                                success: function(e) {
                                    setTimeout(function() {
                                        wx.navigateBack();
                                    }, 500);
                                }
                            });
                        }
                    }) : 1 == a.data.ismsg && a.setData({
                        modal: 1
                    });
                }
            });
        } else {
            if (!r || "" == r) return wx.showModal({
                title: "提示信息",
                content: "用户信息填写错误",
                success: function(e) {}
            }), !1;
            app.util.request({
                url: "entry/wxapp/MUMVIP",
                data: {
                    jhm: t,
                    yqm: n,
                    openid: s,
                    phone: r
                },
                success: function(e) {
                    console.log(e), wx.showModal({
                        content: "恭喜你，激活成功啦~",
                        showCancel: !0,
                        success: function(e) {
                            setTimeout(function() {
                                wx.navigateBack();
                            }, 500);
                        }
                    });
                }
            });
        }
    },
    radioChange: function(e) {
        var a = e.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    showPay: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止购买",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var t = e.currentTarget.dataset.statu;
        console.log(t);
        var n = 0, o = 0;
        if (1 == t && (n = e.currentTarget.dataset.price, o = e.currentTarget.dataset.id), 
        a.setData({
            totalprice: n,
            id: o
        }), 1 == a.data.member_open) {
            if ("" == a.data.phoneNum || !a.data.phoneNum || 1 == a.data.isname && !a.data.name) return wx.showToast({
                title: "用户信息填写错误",
                duration: 2e3,
                icon: "none"
            }), !1;
            app.util.request({
                url: "entry/wxapp/recordphone",
                data: {
                    uid: wx.getStorageSync("users").id,
                    phone: a.data.phoneNum,
                    name: a.data.name,
                    m: app.globalData.Plugin_member
                },
                success: function(e) {
                    console.log(e), 0 == a.data.ismsg ? 0 < n ? a.setData({
                        isshowpay: 0,
                        payStatus: t
                    }) : a.setData({
                        isshowpay: 1,
                        payStatus: t
                    }) : 1 == a.data.ismsg && a.setData({
                        modal: 1
                    });
                }
            });
        } else 0 < n ? a.setData({
            isshowpay: 0,
            payStatus: t
        }) : a.setData({
            isshowpay: 1,
            payStatus: t
        });
    },
    buyVIP: function(e) {
        var a = this, t = a.data.id, n = a.data.totalprice, o = wx.getStorageSync("openid"), s = a.data.payType;
        0 == n && (s = 2);
        var r = a.data.phoneNum;
        if (!r || "" == r) return wx.showModal({
            title: "提示信息",
            content: "请输入正确的手机号码",
            success: function(e) {}
        }), !1;
        if (a.data.isclick) return console.log("重复点击"), !1;
        a.setData({
            isclick: !0
        });
        var i = {
            payType: s,
            resulttype: 2,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "",
            PayredirectTourl: ""
        };
        i.orderarr = {
            id: t,
            price: n,
            openid: o,
            paytypes: 1
        }, i.PayOrder = {
            id: t,
            price: n,
            openid: o,
            phone: r,
            payType: s
        }, app.func.orderarr(app, a, i);
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    getFree: function() {
        var a = this;
        a.data.nav;
        app.util.request({
            url: "entry/wxapp/Free",
            showLoading: !1,
            data: {
                page: 0,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log("会员优惠券"), console.log(e.data), 0 == a.data.member_open ? a.setData({
                    welfareList: e.data,
                    page: 1,
                    nav: [ "开通会员", "激活码", "会员福利" ]
                }) : a.setData({
                    welfareList: e.data,
                    page: 1,
                    nav: [ "开通会员", "激活码" ]
                });
            }
        });
    },
    toWelfare: function(e) {
        var a = e.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../index/welfare/welfare?id=" + a
        });
    },
    changeSort: function(n) {
        var o = this;
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var a = e.latitude, t = e.longitude;
                app.util.request({
                    url: "entry/wxapp/memberbrand",
                    data: {
                        lat: a,
                        lon: t,
                        type: n.currentTarget.dataset.id,
                        page: 1,
                        m: app.globalData.Plugin_member
                    },
                    success: function(e) {
                        var a;
                        console.log(e), o.setData((_defineProperty(a = {
                            curIndexs: n.currentTarget.dataset.index
                        }, "list.data", e.data), _defineProperty(a, "list.page", 1), _defineProperty(a, "list.over", !1), 
                        _defineProperty(a, "type", n.currentTarget.dataset.index), a));
                    }
                });
            }
        });
    },
    loadList: function() {
        var n = this, o = n.data.list.page;
        if (n.data.list.over) return wx.showToast({
            title: "已经没有新内容了",
            duration: 2e3,
            icon: "none"
        }), !1;
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var a = e.latitude, t = e.longitude;
                app.util.request({
                    url: "entry/wxapp/memberbrand",
                    data: {
                        lat: a,
                        lon: t,
                        type: n.data.type,
                        page: ++o,
                        m: app.globalData.Plugin_member
                    },
                    success: function(e) {
                        var a;
                        if (e.data.length <= 0) return wx.showToast({
                            title: "已经没有新内容了",
                            duration: 2e3,
                            icon: "none"
                        }), n.setData(_defineProperty({}, "list.over", !0)), !1;
                        var t = n.data.list.data.concat(e.data);
                        n.setData((_defineProperty(a = {}, "list.data", t), _defineProperty(a, "list.page", ++n.data.list.page), 
                        a));
                    }
                });
            }
        });
    },
    toDetail: function(e) {
        wx.navigateTo({
            url: "../../plugin2/member/memberDetail/memberDetail?bid=" + e.currentTarget.dataset.bid
        });
    },
    Focus: function(e) {
        console.log(e.detail.value);
        var a = e.detail.value;
        this.setData({
            Value: a
        });
    },
    Tap: function() {
        this.setData({
            isFocus: !0
        });
    },
    toggleAd: function() {
        this.setData({
            modal: 0,
            modals: 1
        });
    },
    send: function() {
        var a = this, t = this;
        app.util.request({
            url: "entry/wxapp/sendsms",
            data: {
                uid: wx.getStorageSync("users").id,
                phone: this.data.phoneNum,
                m: app.globalData.Plugin_member
            },
            success: function(e) {
                console.log(e), a.setData({
                    sends: !1,
                    detail: t.data.num + "s后重试"
                }), t.data.setInter = setInterval(function() {
                    var e = t.data.num - 1;
                    t.setData({
                        num: e,
                        detail: e + "s后重试"
                    }), 0 == e && (clearInterval(t.data.setInter), t.setData({
                        detail: "发送验证码",
                        sends: !0,
                        num: 60
                    }));
                }, 1e3);
            }
        });
    },
    second: function() {
        var a = this;
        0 == a.data.isJH && app.util.request({
            url: "entry/wxapp/smscancel",
            data: {
                num: a.data.Value,
                uid: wx.getStorageSync("users").id,
                m: app.globalData.Plugin_member
            },
            success: function(e) {
                console.log(e), 1 == e.data ? 0 < a.data.totalprice ? a.setData({
                    isshowpay: 0,
                    payStatus: 1,
                    modal: 0
                }) : a.setData({
                    isshowpay: 1,
                    payStatus: 1,
                    modal: 0
                }) : 2 == e.data ? wx.showToast({
                    title: "验证码过期",
                    duration: 2e3,
                    icon: "none"
                }) : wx.showToast({
                    title: "验证码错误",
                    duration: 2e3,
                    icon: "none"
                });
            }
        }), 1 == a.data.isJH && app.util.request({
            url: "entry/wxapp/smscancel",
            data: {
                num: a.data.Value,
                uid: wx.getStorageSync("users").id,
                m: app.globalData.Plugin_member
            },
            success: function(e) {
                console.log(e), 1 == e.data ? app.util.request({
                    url: "entry/wxapp/MUMVIP",
                    data: {
                        jhm: a.data.jhm,
                        yqm: a.data.yqm,
                        openid: wx.getStorageSync("openid"),
                        phone: a.data.phoneNum
                    },
                    success: function(e) {
                        console.log(e), wx.showModal({
                            content: "恭喜你，激活成功啦~",
                            showCancel: !0,
                            success: function(e) {
                                setTimeout(function() {
                                    wx.navigateBack();
                                }, 500);
                            }
                        });
                    }
                }) : 2 == e.data ? wx.showToast({
                    title: "验证码过期",
                    duration: 2e3,
                    icon: "none"
                }) : wx.showToast({
                    title: "验证码错误",
                    duration: 2e3,
                    icon: "none"
                });
            }
        });
    },
    showPays: function(e) {
        this.setData({
            payStatus: e.currentTarget.dataset.statu
        });
    },
    onMemberTab: function(e) {
        if (e) {
            if (this.data.currenttab == e.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: e.currentTarget.dataset.tabid,
                type: e.currentTarget.dataset.tabid
            });
        }
    },
    getVip: function() {
        console.log("-------------------------");
        var a = this, e = wx.getStorageSync("openid");
        console.log(e), app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: e
            },
            success: function(e) {
                console.log("获取vip数据"), console.log(e), a.setData({
                    viptype: e.data
                });
            }
        });
    },
    onOpenImmediately: function() {
        console.log("---------------------"), wx.pageScrollTo({
            scrollTop: 400,
            duration: 300
        });
    },
    getMemberRight: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/benefit",
            success: function(e) {
                console.log("获取vip数据"), console.log(e);
                for (var a = e.data, t = a.length, n = t % 10 == 0 ? t / 10 : Math.floor(t / 10 + 1), o = [], s = 0; s < n; s++) {
                    var r = a.slice(10 * s, 10 * s + 10);
                    o.push(r);
                }
                console.log(o), i.setData({
                    memberRightList: o
                });
            }
        });
    },
    getMembershipExclusive: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/vipgoods",
            success: function(e) {
                console.log("获取vip数据"), console.log(e), 2 == e.data ? a.setData({
                    memberGoodsList: []
                }) : a.setData({
                    memberGoodsList: e.data
                });
            }
        });
    },
    putongbon: function(e) {
        var a = e.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + a
        });
    }
});