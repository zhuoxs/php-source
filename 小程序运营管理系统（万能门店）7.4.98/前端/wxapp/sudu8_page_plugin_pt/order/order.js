var _Page;

function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        title: "订单提交",
        yhq_hidden: 0,
        yhq: [ "不使用优惠券", "满100减10", "满200减30", "满500减100" ],
        yhq_i: 0,
        yhq_tishi: 1,
        yhq_u: 0,
        nav: 1,
        jqdjg: "请选择",
        jifen_u: 0,
        yhqid: 0,
        yhdq: 0,
        sfje: 0,
        szmoney: 0,
        dkmoney: 0,
        dkscore: 0,
        mjly: "",
        px: 0,
        yunfei: 0,
        yunfei2: 0,
        yfjian: 0,
        ischecked: !1,
        kuaidi: "",
        again: 0,
        sj_price: 0,
        pro_city: "",
        gmnum: 0,
        free_package: 0,
        pagedata: [],
        formdescs: "",
        newSessionKey: "",
        formImgs: [],
        wannID: "0",
        formId: "",
        formSetId: "",
        chooseAdd: 0,
        yf_get: 0
    },
    onShow: function() {
        1 == this.data.switchs && this.qxyh();
        var a = wx.getStorageSync("chooseAdd");
        a && (this.ptorder(), this.setData({
            chooseAdd: a
        }));
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this, t = a.shareid;
        t || (t = 0), e.setData({
            shareid: t
        });
        var n = a.id;
        null != n && e.setData({
            id: n
        }), a.again && e.setData({
            again: 1
        }), wx.setNavigationBarTitle({
            title: e.data.title
        }), wx.getSystemInfo({
            success: function(a) {
                e.setData({
                    h: a.windowHeight
                });
            }
        });
        var d = a.addressid;
        e.setData({
            addressid: d
        }), e.refreshSessionkey();
        var i = 0;
        a.fxsid && (i = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        var s = app.util.url("entry/wxapp/checkFreePackage", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                e.setData({
                    free_package: a.data.data
                });
            }
        });
        s = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        });
        var r = a.orderid;
        e.setData({
            orderid: r
        }), e.ptorder(), app.util.getUserInfo(e.getinfos, i);
    },
    ptorder: function() {
        var r = this, o = r.data.orderid, u = r.data.gmnum, p = r.data.shareid;
        if (o && "undefined" != o && null != o) {
            var a = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/getorderinfo",
                data: {
                    orderid: o,
                    openid: a
                },
                success: function(a) {
                    for (var e = a.data.data.jsondata, t = 0, n = 0, d = 0; d < e.length; d++) {
                        var i = e[d].num;
                        if (0 == u && (u = 1 * u + 1 * i), 1 == (n = e[d].gmorpt)) var s = e[d].proinfo.price; else s = e[d].proinfo.dprice;
                        t = 1 * t + 1 * s * (1 * i);
                    }
                    r.data.jsdata = a.data.data.jsondata, r.setData({
                        jsdata: a.data.data.jsondata,
                        jsprice: Math.round(100 * t) / 100,
                        sfje: t,
                        px: 1,
                        orderid: o,
                        nav: o && "2" == a.data.data.nav ? 2 : 1,
                        gwc: n
                    }), r.tuanzyh();
                }
            });
        } else wx.getStorage({
            key: "jsdata",
            success: function(a) {
                for (var e = a.data, t = 0, n = 0, d = 0; d < e.length; d++) {
                    var i = e[d].num;
                    if (0 == u && (u = 1 * u + 1 * i), 1 == (n = e[d].gmorpt)) var s = e[d].proinfo.price; else s = e[d].proinfo.dprice;
                    0 == n && 0 != p && r.setData({
                        shareid: 0
                    }), t = 1 * t + 1 * s * (1 * i);
                }
                r.data.jsdata = a.data, r.setData({
                    gmnum: u,
                    jsdata: a.data,
                    jsprice: Math.round(100 * t) / 100,
                    sfje: t,
                    px: 0,
                    gwc: n
                }), r.tuanzyh();
            }
        });
    }
}, "onPullDownRefresh", function() {
    this.refreshSessionkey(), wx.stopPullDownRefresh();
}), _defineProperty(_Page, "refreshSessionkey", function() {
    var e = this, t = app.util.url("entry/wxapp/getNewSessionkey", {
        m: "sudu8_page"
    });
    wx.login({
        success: function(a) {
            wx.request({
                url: t,
                data: {
                    code: a.code
                },
                success: function(a) {
                    e.data.newSessionKey = a.data.data;
                }
            });
        }
    });
}), _defineProperty(_Page, "redirectto", function(a) {
    var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
    app.util.redirectto(e, t);
}), _defineProperty(_Page, "getkuaidi", function() {
    var e = this, a = e.data.jsdata[0].pvid;
    app.util.request({
        url: "entry/wxapp/getkuaidi",
        data: {
            id: a
        },
        success: function(a) {
            e.setData({
                kuaidi: a.data.data
            }), e.nav();
        }
    });
}), _defineProperty(_Page, "nav", function(a) {
    var e = this, t = "", n = e.data.again, d = e.data.nav;
    0 == e.data.kuaidi ? t = 1 : 1 == e.data.kuaidi ? t = 2 : 2 == e.data.kuaidi && (t = a ? parseInt(a.detail.value) : 1);
    e.data.jsdata[0].pvid;
    if (0 == n) if (1 == t) {
        var i = e.data.yunfei2, s = e.data.sfje, r = Math.round(100 * (1 * s + 1 * i)) / 100, o = e.data.money >= r ? r : Math.round(100 * (r - e.data.money)) / 100;
        e.setData({
            nav: 1,
            yunfei: i,
            newsfje: o,
            sj_price: s,
            zg_type: e.data.money >= r ? 0 : 1
        });
        var u = e.data.couponlist;
        e.setMaxCoupon(u), e.payments();
    } else {
        i = 0, s = e.data.sfje, r = Math.round(100 * (1 * s + 1 * i)) / 100, o = e.data.money >= s ? s : Math.round(100 * (s - e.data.money)) / 100;
        e.setData({
            nav: 2,
            yunfei: 0,
            newsfje: o,
            sj_price: s,
            zg_type: e.data.money >= s ? 0 : 1
        });
        u = e.data.couponlist;
        e.setMaxCoupon(u), e.payments();
    } else if (1 == d) {
        i = e.data.yunfei2, s = e.data.sfje, r = Math.round(100 * (1 * s + 1 * i)) / 100, 
        o = e.data.money >= r ? r : Math.round(100 * (r - e.data.money)) / 100;
        e.setData({
            nav: 1,
            yunfei: i,
            newsfje: o,
            sj_price: s,
            zg_type: e.data.money >= r ? 0 : 1
        });
        u = e.data.couponlist;
        e.setMaxCoupon(u), e.payments();
    } else if (2 == d) {
        i = 0, s = e.data.sfje, r = Math.round(100 * (1 * s + 1 * i)) / 100, o = e.data.money >= s ? s : Math.round(100 * (s - e.data.money)) / 100;
        e.setData({
            nav: 2,
            yunfei: 0,
            newsfje: o,
            sj_price: s,
            zg_type: e.data.money >= s ? 0 : 1
        });
        u = e.data.couponlist;
        e.setMaxCoupon(u), e.payments();
    }
}), _defineProperty(_Page, "payments", function() {
    var a = this.data.newsfje, e = this.data.money;
    if (0 == this.data.zg_type) var t = a, n = 0; else t = e, n = a;
    this.setData({
        yue_price: t,
        wx_price: n
    });
}), _defineProperty(_Page, "getinfos", function() {
    var e = this;
    wx.getStorage({
        key: "openid",
        success: function(a) {
            e.setData({
                openid: a.data
            });
        }
    });
}), _defineProperty(_Page, "switchChange", function(a) {
    for (var s = this, e = a.detail.value, t = wx.getStorageSync("openid"), n = s.data.jsdata, r = s.data.sfje, o = s.data.yunfei, u = 0, d = [], i = 0; i < n.length; i++) {
        var p = {};
        p.num = n[i].num, p.pvid = n[i].pvid, d.push(p);
    }
    if (1 == e) app.util.request({
        url: "entry/wxapp/setgwcscore",
        data: {
            jsdata: JSON.stringify(d),
            openid: t
        },
        header: {
            "content-type": "application/json"
        },
        success: function(a) {
            var e = a.data.data;
            u = e.moneycl;
            var t = e.gzmoney, n = e.gzscore;
            r < u && (u = parseInt(r));
            var d = u * n / t;
            if (r = Math.round(100 * (r - u)) / 100, 1 == s.data.nav) {
                var i = s.data.money >= Math.round(100 * (1 * r + 1 * o)) / 100 ? 0 : 1;
                r = 1 * r + 1 * o;
            } else i = s.data.money >= r ? 0 : 1;
            s.setData({
                newsfje: s.data.money >= r ? r : Math.round(100 * (r - s.data.money)) / 100,
                zg_type: i,
                sfje: r,
                szmoney: u,
                dkmoney: u,
                dkscore: d,
                jifen_u: 1,
                switchs: !0
            }), s.payments();
        }
    }); else {
        u = s.data.szmoney;
        r = Math.round(100 * (r + u)) / 100;
        var c = s.data.money >= r ? 0 : 1;
        s.setData({
            newsfje: s.data.money >= r ? r : Math.round(100 * (r - s.data.money)) / 100,
            zg_type: c,
            szmoney: 0,
            dkmoney: 0,
            dkscore: 0,
            jifen_u: 0,
            switchs: !1
        }), r = 1 * r - 1 * o, s.setData({
            sfje: r
        }), s.payments();
    }
}), _defineProperty(_Page, "add_address", function() {
    wx.navigateTo({
        url: "/sudu8_page/address/address?shareid=" + this.data.shareid + "&pid=" + this.data.id + "&addressid=" + this.data.addressid
    });
}), _defineProperty(_Page, "yhq_sub", function() {
    var a = this.data.yhq_i;
    this.setData({
        yhq_r: a,
        yhq_hidden: 0,
        yhq_tishi: 0
    });
}), _defineProperty(_Page, "yhq_block", function() {
    this.setData({
        yhq_hidden: 1
    });
}), _defineProperty(_Page, "yhq_choose", function(a) {
    var e = a.currentTarget.dataset.i;
    this.setData({
        yhq_i: e
    });
}), _defineProperty(_Page, "showModal", function() {
    var a = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = a).translateY(300).step(), this.setData({
        animationData: a.export(),
        showModalStatus: !0
    }), setTimeout(function() {
        a.translateY(0).step(), this.setData({
            animationData: a.export()
        });
    }.bind(this), 200);
}), _defineProperty(_Page, "hideModal", function() {
    var a = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = a).translateY(300).step(), this.setData({
        animationData: a.export()
    }), setTimeout(function() {
        a.translateY(0).step(), this.setData({
            animationData: a.export(),
            showModalStatus: !1
        });
    }.bind(this), 200);
}), _defineProperty(_Page, "getmraddress", function() {
    var t = this, a = wx.getStorageSync("openid"), e = app.util.url("entry/wxapp/getmraddress", {
        m: "sudu8_page"
    });
    wx.request({
        url: e,
        data: {
            openid: a
        },
        success: function(a) {
            var e = a.data.data;
            "" != e ? t.setData({
                mraddress: e,
                pro_city: e.pro_city
            }) : t.setData({
                mraddress: ""
            }), t.getmyinfo();
        }
    });
}), _defineProperty(_Page, "getmraddresszd", function(a) {
    var t = this, e = wx.getStorageSync("openid"), n = app.util.url("entry/wxapp/getmraddresszd", {
        m: "sudu8_page"
    });
    wx.request({
        url: n,
        data: {
            openid: e,
            id: a
        },
        success: function(a) {
            var e = a.data.data;
            "" != e ? t.setData({
                mraddress: e,
                pro_city: e.pro_city
            }) : t.setData({
                mraddress: ""
            }), t.getmyinfo();
        }
    });
}), _defineProperty(_Page, "getmyinfo", function() {
    var i = this, s = wx.getStorageSync("openid"), a = (i.data.jsdata, i.data.sfje, 
    app.util.url("entry/wxapp/base", {
        m: "sudu8_page"
    }));
    wx.request({
        url: a,
        success: function(a) {
            i.setData({
                baseinfo: a.data.data
            }), wx.setNavigationBarColor({
                frontColor: i.data.baseinfo.base_tcolor,
                backgroundColor: i.data.baseinfo.base_color
            });
        },
        fail: function(a) {}
    });
    var e = app.util.url("entry/wxapp/mymoney", {
        m: "sudu8_page"
    });
    wx.request({
        url: e,
        data: {
            openid: s
        },
        header: {
            "content-type": "application/json"
        },
        success: function(a) {
            i.setData({
                money: parseFloat(a.data.data.money),
                score: parseFloat(a.data.data.score)
            });
            var e = app.util.url("entry/wxapp/mycoupon", {
                m: "sudu8_page"
            });
            wx.request({
                url: e,
                data: {
                    openid: s
                },
                success: function(a) {
                    i.setData({
                        couponlist: a.data.data
                    });
                }
            });
            var t = i.data.pro_city, n = i.data.free_package;
            if ("" != t && 0 == n) {
                var d = app.util.url("entry/wxapp/yunfeigetnew", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: d,
                    data: {
                        id: i.data.id,
                        type: "pt",
                        hjjg: i.data.jsprice,
                        num: i.data.gmnum,
                        pro_city: t
                    },
                    success: function(a) {
                        var e = a.data.data, t = i.data.sfje, n = 0;
                        n = "" != e.byou && t >= 1 * e.byou ? 0 : e.yfei, i.setData({
                            yunfei2: n
                        }), i.getkuaidi();
                    }
                });
            } else i.setData({
                yunfei2: 0
            }), i.getkuaidi();
        }
    });
}), _defineProperty(_Page, "setMaxCoupon", function(a) {
    for (var e = a, t = new Array(), n = "", d = 0; d < e.length; d++) parseFloat(e[d].coupon.pay_money) <= parseFloat(this.data.jsprice) && t.push(e[d]);
    if ("" != t) for (var i = parseFloat(t[0].coupon.price), s = 0; s < t.length; s++) parseFloat(t[s].coupon.price) >= i && (n = t[s]);
    if ("" != n) {
        var r = {}, o = {
            dataset: r
        }, u = {
            currentTarget: o
        };
        o.id = n.coupon.price, r.index = n, this.getmoney(u);
    }
}), _defineProperty(_Page, "qxyh", function() {
    var a = this;
    a.setData({
        ischecked: !1
    }), a.switchChange({
        detail: {
            value: !1
        }
    });
    var e = a.data.jqdjg, t = a.data.yhdq;
    "请选择" == e && (e = 0);
    var n = a.data.sj_price;
    if (n - t < 0) i = n; else var d = a.data.sfje, i = Math.round(100 * (1 * d + 1 * e)) / 100;
    var s = a.data.yunfei, r = a.data.money >= i ? i : Math.round(100 * (i - a.data.money)) / 100;
    r = 1 == a.data.nav ? Math.round(100 * (1 * r + 1 * s)) / 100 : r, a.hideModal(), 
    a.setData({
        yhqid: 0,
        sfje: i,
        newsfje: r,
        zg_type: a.data.money >= i ? 0 : 1,
        jqdjg: "请选择",
        yhdq: 0
    }), a.payments();
}), _defineProperty(_Page, "getmoney", function(a) {
    var e = this;
    this.setData({
        ischecked: !1,
        jifen_u: 0
    });
    var t = a.currentTarget.id, n = a.currentTarget.dataset.index, d = n.coupon.pay_money, i = e.data.sj_price, s = (e.data.yhdq, 
    e.data.yhqid);
    if (0 == s || n.id != s) {
        if (1 * i < 1 * d) wx.showModal({
            title: "提示",
            content: "价格未满" + d + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var r = Math.round(100 * (1 * i - 1 * t)) / 100;
            r < 0 && (r = 0);
            var o = e.data.yunfei, u = e.data.money >= r ? r : Math.round(100 * (r - e.data.money)) / 100;
            u = 1 == e.data.nav ? Math.round(100 * (1 * u + 1 * o)) / 100 : u, e.setData({
                jqdjg: t,
                yhqid: n.id,
                sfje: r,
                zg_type: e.data.money >= r ? 0 : 1,
                newsfje: u,
                oldsfje: i,
                yhdq: t
            }), e.hideModal();
        }
        e.payments();
    }
    n.id;
}), _defineProperty(_Page, "submitOrder", function() {
    for (var t = this, a = wx.getStorageSync("openid"), e = t.data.jsdata, n = e[0].pvid, d = [], i = 0; i < e.length; i++) {
        var s = {};
        s.baseinfo = e[i].baseinfo2.id, s.proinfo = e[i].proinfo.id, s.num = e[i].num, s.pvid = e[i].pvid, 
        s.one_bili = e[i].one_bili, s.two_bili = e[i].two_bili, s.three_bili = e[i].three_bili, 
        s.id = e[i].id, s.proval_ggz = e[i].proinfo.ggz, s.proval_price = e[i].proinfo.price, 
        s.proval_dprice = e[i].proinfo.dprice, d.push(s);
    }
    a = wx.getStorageSync("openid");
    var r = t.data.yhqid, o = t.data.newsfje, u = (t.data.money, t.data.nav), p = t.data.yunfei, c = t.data.yfjian;
    p = p || 0;
    var f = t.data.shareid, l = t.data.dkscore, g = (t.data.dkmoney, t.data.gwc);
    p -= c;
    var y = t.data.mraddress, h = t.data.mjly;
    if ((null == y || 0 == y) && 1 == u) return wx.showModal({
        title: "提醒",
        content: "请先选择/设置地址！",
        showCancel: !0,
        success: function(a) {
            if (!a.confirm) return !1;
            wx.navigateTo({
                url: "/sudu8_page/address/address?shareid=" + t.data.shareid + "&pid=" + t.data.id
            });
        }
    }), !1;
    if (null != y && 0 != y || 2 != u) m = y.id; else var m = 0;
    if (0 == t.data.px) {
        var _ = app.util.url("entry/wxapp/duosetorder", {
            m: "sudu8_page_plugin_pt"
        });
        wx.request({
            url: _,
            header: {
                "content-type": "application/json"
            },
            data: {
                openid: a,
                jsdata: d,
                couponid: r,
                price: o,
                dkscore: l,
                address: m,
                mjly: h,
                nav: u,
                gwc: g,
                shareid: f,
                pvid: n,
                formid: t.data.formSetId
            },
            success: function(a) {
                if (2 == a.data.data) wx.showModal({
                    title: "提醒",
                    content: "你是拼团发起人，不能参团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }); else if (3 == a.data.data) wx.showModal({
                    title: "提醒",
                    content: "你已参团，不能再次参团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }); else if (5 == a.data.data) wx.showModal({
                    title: "提醒",
                    content: "此商品您有拼团订单未成功，无法再次开团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }); else if (4 == a.data.data) wx.showModal({
                    title: "提醒",
                    content: "该团已满，无法参团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }); else if (6 == a.data.data) wx.showModal({
                    title: "提醒",
                    content: "商品已经下架",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page_plugin_pt/index/index"
                        });
                    }
                }); else {
                    var e = a.data.data;
                    t.setData({
                        orderid: e
                    }), 0 == t.data.zg_type ? t.pay1(e) : t.pay2(e);
                }
            }
        });
    } else {
        var w = t.data.orderid;
        g = t.data.gwc, a = wx.getStorageSync("openid"), _ = app.util.url("entry/wxapp/duoorderchangegg", {
            m: "sudu8_page_plugin_pt"
        });
        app.util.request({
            url: _,
            header: {
                "content-type": "application/json"
            },
            data: {
                orderid: w,
                shareid: f,
                couponid: r,
                price: o,
                dkscore: l,
                address: y.id,
                mjly: h,
                nav: u,
                gwc: g,
                openid: a,
                pvid: n,
                formid: t.data.formSetId
            },
            success: function(a) {
                5 == a.data.data ? wx.showModal({
                    title: "提醒",
                    content: "此商品您有拼团订单未成功，无法再次开团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }) : 6 == a.data.data ? wx.showModal({
                    title: "提醒",
                    content: "您已参加此团，无法再次参团",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }) : 0 == t.data.zg_type ? t.pay1(w) : t.pay2(w);
            }
        });
    }
}), _defineProperty(_Page, "pay1", function(a) {
    var e = this, t = a;
    wx.showModal({
        title: "请注意",
        content: "您将使用余额支付" + e.data.newsfje + "元",
        success: function(a) {
            a.confirm ? (e.payover_do(t), wx.showLoading({
                title: "下单中...",
                mask: !0
            })) : wx.redirectTo({
                url: "/sudu8_page_plugin_pt/orderlist/orderlist"
            });
        }
    });
}), _defineProperty(_Page, "pay2", function(a) {
    var e = this, t = wx.getStorageSync("openid"), n = e.data.newsfje, d = a;
    app.util.request({
        url: "entry/wxapp/weixinpay",
        data: {
            openid: t,
            price: n,
            order_id: d
        },
        header: {
            "content-type": "application/json"
        },
        success: function(a) {
            "success" == a.data.message && wx.requestPayment({
                timeStamp: a.data.data.timeStamp,
                nonceStr: a.data.data.nonceStr,
                package: a.data.data.package,
                signType: "MD5",
                paySign: a.data.data.paySign,
                success: function(a) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        mask: !0,
                        duration: 3e3,
                        success: function(a) {
                            e.payover_do(d);
                        }
                    });
                },
                fail: function(a) {
                    wx.redirectTo({
                        url: "/sudu8_page_plugin_pt/orderlist/orderlist"
                    });
                },
                complete: function(a) {}
            }), "error" == a.data.message && wx.showModal({
                title: "提醒",
                content: a.data.data.message,
                showCancel: !1
            });
        }
    });
}), _defineProperty(_Page, "payover_do", function(e) {
    var t = this, a = (t.data.comment, wx.getStorageSync("openid")), n = t.data.yhqid, d = (t.data.orderid, 
    t.data.shareid), i = t.data.dkscore, s = t.data.zg_type, r = t.data.money, o = t.data.sfje, u = t.data.yue_price, p = t.data.wx_price;
    if (0 == s) var c = o;
    if (1 == s) c = r;
    app.util.request({
        url: "entry/wxapp/duoorderchange",
        data: {
            order_id: e,
            openid: a,
            true_price: c,
            dkscore: i,
            couponid: n,
            shareid: d,
            formid: t.data.formSetId,
            yue_price: u,
            wx_price: p
        },
        success: function(a) {
            t.sendMail_order(e), wx.navigateBack({
                delta: 1
            }), 0 == a.data.data ? wx.redirectTo({
                url: "/sudu8_page_plugin_pt/orderlist/orderlist"
            }) : wx.redirectTo({
                url: "/sudu8_page_plugin_pt/pt/pt?shareid=" + a.data.data
            });
        }
    });
}), _defineProperty(_Page, "sendMail_order", function(a) {
    var e = app.util.url("entry/wxapp/sendMail_order", {
        m: "sudu8_page"
    });
    app.util.request({
        url: e,
        data: {
            order_id: a
        },
        success: function(a) {},
        fail: function(a) {}
    });
}), _defineProperty(_Page, "mjly", function(a) {
    var e = a.detail.value;
    this.setData({
        mjly: e
    });
}), _defineProperty(_Page, "mend", function() {}), _defineProperty(_Page, "makePhoneCallC", function(a) {
    var e = a.currentTarget.dataset.tel;
    wx.makePhoneCall({
        phoneNumber: e
    });
}), _defineProperty(_Page, "tuanzyh", function() {
    var u = this, a = u.data.jsdata[0].pvid;
    app.util.request({
        url: "entry/wxapp/pttuanzyh",
        header: {
            "content-type": "application/json"
        },
        data: {
            id: a
        },
        success: function(a) {
            var e = a.data.data.tz_yh, t = u.data.gwc, n = u.data.sfje, d = u.data.shareid, i = n, s = 0, r = (u.data.chooseAdd, 
            u.data.yf_get);
            1 == t && 0 == d && 0 == r && (n = (n * e / 10).toFixed(2), s = Math.round(100 * (1 * i - 1 * n)) / 100, 
            u.setData({
                tz_bl: e,
                sfje: n,
                youhl: s,
                yf_get: 1
            }));
            var o = u.data.addressid;
            o ? u.getmraddresszd(o) : u.getmraddress();
        }
    }), u.getForm(a);
}), _defineProperty(_Page, "getForm", function(a) {
    var e = this;
    app.util.request({
        url: "entry/wxapp/getFormSet",
        header: {
            "content-type": "application/json"
        },
        data: {
            id: a
        },
        success: function(a) {
            if ("0" == a.data.data.formId || !a.data.data.formId) return !1;
            e.data.pagedata = a.data.data.forms, e.data.formdescs = a.data.data.formdescs, e.data.wannID = a.data.data.formId, 
            e.setData({
                pagedata: e.data.pagedata,
                formdescs: e.data.formdescs
            });
        }
    });
}), _defineProperty(_Page, "getPhoneNumber1", function(a) {
    var e = this, t = a.detail.iv, n = a.detail.encryptedData;
    if ("getPhoneNumber:ok" == a.detail.errMsg) {
        var d = app.util.url("entry/wxapp/jiemiNew", {
            m: "sudu8_page"
        });
        wx.checkSession({
            success: function() {
                wx.request({
                    url: d,
                    data: {
                        newSessionKey: e.data.newSessionKey,
                        iv: t,
                        encryptedData: n
                    },
                    success: function(a) {
                        a.data.data ? e.setData({
                            wxmobile: a.data.data
                        }) : wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(a) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        });
    } else wx.showModal({
        title: "提示",
        content: "请先授权获取您的手机号！",
        showCancel: !1
    });
}), _defineProperty(_Page, "weixinadd", function() {
    var d = this;
    wx.chooseAddress({
        success: function(a) {
            var e = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, t = a.userName, n = a.telNumber;
            d.setData({
                myname: t,
                mymobile: n,
                myaddress: e
            });
        },
        fail: function(a) {
            wx.getSetting({
                success: function(a) {
                    a.authSetting["scope.address"] || wx.openSetting({
                        success: function(a) {}
                    });
                }
            });
        }
    });
}), _defineProperty(_Page, "formSubmit", function(a) {
    var e = this;
    if (e.data.formId = a.detail.formId, "0" != e.data.wannID && e.data.wannID) {
        for (var t = e.data.pagedata, n = a.detail.value, d = 0; d < t.length; d++) "5" == t[d].type && (n[d] = e.data.formImgs);
        for (d = 0; d < t.length; d++) {
            if ("1" == t[d].ismust && !n[d]) return wx.showModal({
                title: "提醒",
                content: t[d].name + "为必填项！",
                showCancel: !1
            }), !1;
            if ("2" == t[d].type || "4" == t[d].type) {
                var i = n[d];
                t[d].val = t[d].tp_text[i];
            } else "3" == t[d].type ? (t[d].val = [], t[d].val = n[d]) : "5" == t[d].type ? t[d].z_val = e.data.formImgs : t[d].val = n[d];
        }
        var s = app.util.url("entry/wxapp/Formval", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            data: {
                id: e.data.id,
                pagedata: JSON.stringify(t),
                types: "showProDan",
                fid: e.data.wannID,
                openid: wx.getStorageSync("openid")
            },
            cachetime: "30",
            success: function(a) {
                e.data.formSetId = a.data.data.id, e.submitOrder();
            }
        });
    } else e.submitOrder();
}), _defineProperty(_Page, "choiceimg1111", function(a) {
    var i = this, s = i.data.zhixin, e = a.currentTarget.dataset.index, t = i.data.pagedata[e].tp_text[0], r = i.data.formImgs, n = t - r.length;
    if (n < 1) return wx.showToast({
        title: "只能上传" + t + "张图片",
        icon: "none"
    }), !1;
    var o = app.util.url("entry/wxapp/wxupimg", {
        m: "sudu8_page"
    });
    wx.chooseImage({
        count: n,
        sizeType: [ "original", "compressed" ],
        sourceType: [ "album", "camera" ],
        success: function(a) {
            s = !0, i.setData({
                zhixin: s
            }), wx.showLoading({
                title: "图片上传中"
            });
            var e = a.tempFilePaths, n = 0, d = e.length;
            !function t() {
                wx.uploadFile({
                    url: o,
                    filePath: e[n],
                    name: "file",
                    success: function(a) {
                        var e = JSON.parse(a.data);
                        r.push(e), i.setData({
                            formImgs: r
                        }), i.data.formImgs = r, ++n < d ? t() : (s = !1, i.setData({
                            zhixin: s
                        }), wx.hideLoading());
                    }
                });
            }();
        }
    });
}), _defineProperty(_Page, "delimg", function(a) {
    a.currentTarget.dataset.index;
    var e = a.currentTarget.dataset.id;
    this.data.formImgs;
    this.data.formImgs.splice(e, 1), this.setData({
        formImgs: this.data.formImgs
    });
}), _defineProperty(_Page, "onPreviewImage", function(a) {
    app.util.showImage(a);
}), _defineProperty(_Page, "bindPickerChange", function(a) {
    var e = a.detail.value, t = a.currentTarget.dataset.index, n = this.data.pagedata, d = n[t].tp_text[e];
    n[t].val = d, this.setData({
        pagedata: n
    });
}), _defineProperty(_Page, "bindDateChange", function(a) {
    var e = a.detail.value, t = a.currentTarget.dataset.index, n = this.data.pagedata;
    n[t].val = e, this.setData({
        pagedata: n
    });
}), _defineProperty(_Page, "bindTimeChange", function(a) {
    var e = a.detail.value, t = a.currentTarget.dataset.index, n = this.data.pagedata;
    n[t].val = e, this.setData({
        pagedata: n
    });
}), _Page));