function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
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
        yfjian: 0,
        zf_type: null,
        fid: 0,
        isview: 0,
        again: 0,
        mraddress: "",
        kuaidi: "",
        sid: 0,
        pro_city: "",
        gmnum: 0,
        v: 1,
        free_package: 2,
        full_free: 0,
        sw: !1,
        chooseA: 0,
        gwcto: 0,
        discount_all_price: 0
    },
    onShow: function(a) {
        1 == this.data.switchs && this.qxyh(), wx.getStorageSync("chooseAdd") && (this.setData({
            chooseA: 1
        }), this.getinfos());
    },
    onPullDownRefresh: function() {
        this.refreshSessionkey(), this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.refreshSessionkey(), wx.setNavigationBarTitle({
            title: t.data.title
        }), wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    h: a.windowHeight
                });
            }
        });
        var e = a.addressid, d = a.orderid;
        t.setData({
            addressid: e,
            orderid: d
        });
        a.discounts && t.setData({
            discounts: a.discounts
        }), a.gwcto && t.setData({
            gwcto: a.gwcto
        });
        var i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), a.again && t.setData({
            again: 1
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), app.util.getUserInfo(t.getinfos, i);
    },
    makePhoneCallC: function(a) {
        var t = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var l = this, p = 0;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data, o = l.data.orderid;
                l.setData({
                    openid: t
                }), app.util.request({
                    url: "entry/wxapp/checkFreePackage",
                    data: {
                        openid: t
                    },
                    success: function(a) {
                        l.setData({
                            free_package: a.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetFormInfo",
                    data: {},
                    success: function(a) {
                        a.data.data && l.setData({
                            pagedata: a.data.data.forms,
                            formdescs: a.data.data.formdescs,
                            fid: a.data.data.formset
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        var t = a.data.data;
                        t.nickname && t.avatar || l.setData({
                            isview: 1
                        }), l.setData({
                            globaluser: a.data.data
                        });
                    }
                });
                var c = l.data.gwcto;
                null != o && "undefined" != o ? app.util.request({
                    url: "entry/wxapp/duoorderinfo",
                    data: {
                        orderid: o
                    },
                    success: function(a) {
                        for (var t = a.data.data.jsondata, e = 0, d = 0; d < t.length; d++) {
                            var i = t[d].num;
                            p = 1 * p + 1 * i;
                            var s = t[d].proinfo.price;
                            e += Math.round(1 * s * (1 * i) * 100) / 100, "" != l.data.kuaidi ? 2 == t[d].kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 1 == t[d].kuaidi ? 0 == l.data.kuaidi || 2 == l.data.kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 1 == l.data.kuaidi && l.setData({
                                kuaidi: 1
                            }) : 0 == t[d].kuaidi && (1 == l.data.kuaidi || 2 == l.data.kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 0 == l.data.kuaidi && l.setData({
                                kuaidi: 0
                            })) : l.setData({
                                kuaidi: t[d].kuaidi
                            });
                        }
                        var n = 0;
                        0 < a.data.data.discounts_price && (e -= n = a.data.data.discounts_price), l.setData({
                            gmnum: p,
                            jsdata: a.data.data.jsondata,
                            jsprice: e.toFixed(2),
                            sfje: e.toFixed(2),
                            px: 1,
                            orderid: o,
                            nav: "2" == a.data.data.nav ? 2 : 1,
                            order_info: a.data.data,
                            sid: 1 * a.data.data.sid,
                            discount_all_price: n.toFixed(2)
                        }), l.getmoneyoff();
                    }
                }) : wx.getStorage({
                    key: "jsdata",
                    success: function(a) {
                        for (var t = a.data, e = 0, d = 0, i = 0; i < t.length; i++) {
                            var s = t[i].num;
                            p = 1 * p + 1 * s;
                            var n = t[i].proinfo.price;
                            if (1 == c) {
                                var o = t[i].baseinfo.discounts, r = Math.round(1 * n * (1 * s) * 100) / 100;
                                if (0 < o) var u = r * o * .1; else u = r;
                                d += r - u, e += u;
                            } else e += Math.round(1 * n * (1 * s) * 100) / 100;
                            "" != l.data.kuaidi ? 2 == t[i].kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 1 == t[i].kuaidi ? 0 == l.data.kuaidi || 2 == l.data.kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 1 == l.data.kuaidi && l.setData({
                                kuaidi: 1
                            }) : 0 == t[i].kuaidi && (1 == l.data.kuaidi || 2 == l.data.kuaidi ? l.setData({
                                kuaidi: 2
                            }) : 0 == l.data.kuaidi && l.setData({
                                kuaidi: 0
                            })) : l.setData({
                                kuaidi: t[i].kuaidi
                            });
                        }
                        0 == l.data.kuaidi ? l.setData({
                            nav: 1
                        }) : 1 == l.data.kuaidi ? l.setData({
                            nav: 2
                        }) : 2 == l.data.kuaidi && l.setData({
                            nav: 1
                        }), l.setData({
                            gmnum: p,
                            jsdata: a.data,
                            jsprice: e.toFixed(2),
                            sfje: e,
                            px: 0,
                            discount_all_price: d.toFixed(2)
                        }), l.getmoneyoff();
                    }
                });
            }
        });
    },
    getmoneyoff: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/getmoneyoff",
            success: function(a) {
                for (var t = a.data.data.moneyoff, e = "", d = 0; d < t.length; d++) d == t.length - 1 ? e += "满" + t[d].reach + "减" + t[d].del : e += "满" + t[d].reach + "减" + t[d].del + "，";
                if (s.setData({
                    moneyoff: t,
                    moneyoffstr: t ? e : ""
                }), 0 == s.data.kuaidi || 2 == s.data.kuaidi) {
                    var i = s.data.addressid;
                    i ? s.getmraddresszd(i) : s.getmraddress();
                } else s.getmyinfo();
            }
        });
    },
    getmyinfo: function() {
        var s = this, n = wx.getStorageSync("openid"), o = (s.data.jsdata, s.data.sfje), a = s.data.discounts, t = s.data.v, e = s.data.chooseA;
        0 < a && 0 < o && (1 == t || 1 == e) && (o = (o = o * a * .1) < .01 ? .01 : o.toFixed(2), 
        t = 2, s.setData({
            v: t
        }));
        var r = s.data.moneyoff;
        app.util.request({
            url: "entry/wxapp/mymoney",
            data: {
                openid: n
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                if (s.setData({
                    money: parseFloat(a.data.data.money),
                    score: parseFloat(a.data.data.score)
                }), app.util.request({
                    url: "entry/wxapp/mycoupon",
                    data: {
                        openid: n
                    },
                    success: function(a) {
                        s.setData({
                            couponlist: a.data.data
                        });
                    }
                }), r) for (var t = r.length - 1; 0 <= t; t--) if (o >= parseFloat(r[t].reach)) {
                    o -= parseFloat(r[t].del);
                    break;
                }
                var e = s.data.pro_city, d = s.data.free_package;
                if ("" != e && 0 == d) app.util.request({
                    url: "entry/wxapp/yunfeigetnew",
                    data: {
                        id: 0,
                        type: "duo",
                        hjjg: s.data.jsprice,
                        num: s.data.gmnum,
                        pro_city: e
                    },
                    success: function(a) {
                        var t = a.data.data, e = 0, d = 0;
                        parseFloat(o) >= parseFloat(t.byou) && "" != t.byou ? (e = 0, d = 1) : e = t.yfei, 
                        2 == s.data.nav ? (o = Math.round(1 * o * 100) / 100, s.setData({
                            yunfei: 0
                        })) : (o = Math.round(100 * (1 * o + 1 * e)) / 100, s.setData({
                            yunfei: e
                        })), s.setData({
                            full_free: d,
                            datas: t,
                            sfje: o,
                            zf_type: s.data.money >= o ? 0 : 1,
                            zf_money: s.data.money >= o ? o : Math.round(100 * (o - s.data.money)) / 100
                        });
                    }
                }); else {
                    var i = new Array();
                    i.formset = 0, s.setData({
                        datas: i,
                        sfje: o,
                        zf_type: s.data.money >= o ? 0 : 1,
                        zf_money: s.data.money >= o ? o : Math.round(100 * (o - s.data.money)) / 100
                    });
                }
            }
        });
    },
    switchChange: function(a) {
        for (var s = this, t = a.detail.value, e = wx.getStorageSync("openid"), d = s.data.jsdata, n = s.data.sfje, o = 0, i = [], r = 0; r < d.length; r++) {
            var u = {};
            u.num = d[r].num, u.pvid = d[r].pvid, i.push(u);
        }
        var c = s.data.sw;
        if (1 == t && 0 == c) app.util.request({
            url: "entry/wxapp/setgwcscore",
            data: {
                jsdata: JSON.stringify(i),
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data;
                o = t.moneycl;
                var e = t.gzmoney, d = t.gzscore;
                n < o && (o = parseInt(n));
                var i = o * d / e;
                n = Math.round(100 * (n - o)) / 100, s.setData({
                    sw: !0,
                    sfje: n,
                    szmoney: o,
                    dkmoney: o,
                    dkscore: i,
                    zf_type: s.data.money >= n ? 0 : 1,
                    zf_money: s.data.money >= n ? n : Math.round(100 * (n - s.data.money)) / 100,
                    jifen_u: 1
                });
            }
        }); else {
            o = s.data.szmoney;
            n += o, s.setData({
                sw: !1,
                sfje: n,
                zf_type: s.data.money >= n ? 0 : 1,
                zf_money: s.data.money >= n ? n : Math.round(100 * (n - s.data.money)) / 100,
                szmoney: 0,
                dkmoney: 0,
                dkscore: 0,
                jifen_u: 0
            });
        }
    },
    nav: function(a) {
        var t = this, e = parseInt(a.detail.value), d = 0, i = t.data.yunfei;
        1 == e ? d -= i : d = i;
        var s = Math.round(100 * (t.data.sfje - d)) / 100;
        t.setData({
            nav: e,
            yfjian: 1 == e ? 0 : i,
            sfje: s,
            zf_type: t.data.money >= s ? 0 : 1,
            zf_money: t.data.money >= s ? s : Math.round(100 * (s - t.data.money)) / 100
        });
    },
    add_address: function() {
        wx.navigateTo({
            url: "/sudu8_page/address/address?shareid=" + this.data.shareid + "&pid=" + this.data.id + "&orderid=" + this.data.orderid + "&discounts=" + this.data.discounts + "&addressid=" + this.data.addressid
        });
    },
    yhq_sub: function() {
        var a = this.data.yhq_i;
        this.setData({
            yhq_r: a,
            yhq_hidden: 0,
            yhq_tishi: 0
        });
    },
    yhq_block: function() {
        this.setData({
            yhq_hidden: 1
        });
    },
    yhq_choose: function(a) {
        var t = a.currentTarget.dataset.i;
        this.setData({
            yhq_i: t
        });
    },
    showModal: function() {
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
    },
    hideModal: function() {
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
    },
    getmraddress: function() {
        var e = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddress",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                "" != t ? e.setData({
                    mraddress: t,
                    pro_city: t.pro_city,
                    addressid: t.id
                }) : e.setData({
                    mraddress: ""
                }), e.getmyinfo();
            }
        });
    },
    getmraddresszd: function(a) {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddresszd",
            data: {
                openid: t,
                id: a
            },
            success: function(a) {
                var t = a.data.data;
                "" != t ? e.setData({
                    mraddress: t,
                    pro_city: t.pro_city
                }) : e.setData({
                    mraddress: ""
                }), e.getmyinfo();
            }
        });
    },
    qxyh: function() {
        var a, t = this;
        t.setData({
            ischecked: !1
        }), t.switchChange({
            detail: {
                value: !1
            }
        });
        var e = t.data.jqdjg;
        t.data.yhdq;
        "请选择" == e && (e = 0);
        var d = (100 * t.data.sfje + 100 * e) / 100;
        t.hideModal(), t.setData((_defineProperty(a = {
            jqdjg: 0,
            yhqid: 0,
            sfje: d,
            zf_type: t.data.money >= d ? 0 : 1,
            zf_money: t.data.money >= d ? d : Math.round(100 * (d - t.data.money)) / 100
        }, "jqdjg", "请选择"), _defineProperty(a, "yhdq", 0), a));
    },
    getmoney: function(a) {
        var t = this;
        t.setData({
            ischecked: !1
        }), t.switchChange({
            detail: {
                value: !1
            }
        });
        var e = a.currentTarget.id, d = a.currentTarget.dataset.index, i = d.coupon.pay_money, s = t.data.sfje;
        s = 1 * s + 1 * t.data.yhdq;
        var n = t.data.yhqid;
        if (0 == n || d.id != n) if (1 * s - parseFloat(t.data.yunfei) + parseFloat(t.data.yfjian) < 1 * i) wx.showModal({
            title: "提示",
            content: "价格未满" + i + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var o = Math.floor(100 * (1 * s - 1 * e)) / 100;
            o < 0 && (o = 0), t.setData({
                jqdjg: e,
                yhqid: d.id,
                sfje: o,
                zf_type: t.data.money >= o ? 0 : 1,
                zf_money: t.data.money >= o ? o : Math.round(100 * (o - t.data.money)) / 100,
                oldsfje: s,
                yhdq: e
            }), t.hideModal();
        }
    },
    submit: function(a) {
        var t = this, e = a.detail.formId;
        t.setData({
            formId: e
        });
        t.data.datas;
        var d = t.data.mraddress;
        if (0 < t.data.fid) {
            if (1 == t.data.nav && (null == d || !d)) return wx.showModal({
                title: "提示",
                content: "请先选择/设置收货地址！",
                showCancel: !0,
                success: function(a) {
                    if (a.confirm) wx.navigateTo({
                        url: "/sudu8_page/address/address?shareid=" + t.data.shareid + "&pid=" + t.data.id + "&orderid=" + t.data.orderid + "&discounts=" + t.data.discounts
                    }); else if (a.cancel) return !1;
                }
            }), !1;
            t.formSubmit();
        } else {
            if (1 == t.data.nav && (null == d || !d)) return wx.showModal({
                title: "提示",
                content: "请先选择/设置收货地址！",
                showCancel: !0,
                success: function(a) {
                    if (a.confirm) wx.navigateTo({
                        url: "/sudu8_page/address/address?shareid=" + t.data.shareid + "&pid=" + t.data.id + "&orderid=" + t.data.orderid + "&discounts=" + t.data.discounts
                    }); else if (a.cancel) return !1;
                }
            }), !1;
            t.doshend();
        }
    },
    doshend: function(a) {
        for (var e = this, t = e.data.jsdata, d = [], i = 0; i < t.length; i++) {
            var s = {};
            s.baseinfo = t[i].baseinfo.id, s.proinfo = t[i].proinfo.id, s.num = t[i].num, s.pvid = t[i].pvid, 
            s.one_bili = t[i].one_bili, s.two_bili = t[i].two_bili, s.three_bili = t[i].three_bili, 
            t[i].buy_type ? s.id = 0 : s.id = t[i].id, d.push(s);
        }
        var n = wx.getStorageSync("openid"), o = e.data.yhqid, r = e.data.sfje, u = e.data.nav, c = e.data.yunfei, l = e.data.yfjian, p = e.data.dkscore, f = (e.data.dkmoney, 
        e.data.mraddress), h = e.data.mjly;
        if (c -= l, !(1 != u || null != f && f)) return wx.showModal({
            title: "提示",
            content: "请先选择/设置收货地址！",
            showCancel: !0,
            success: function(a) {
                if (a.confirm) wx.navigateTo({
                    url: "/sudu8_page/address/address?shareid=" + e.data.shareid + "&pid=" + e.data.id + "&orderid=" + e.data.orderid + "&discounts=" + e.data.discounts
                }); else if (a.cancel) return !1;
            }
        }), !1;
        if (2 == u) ; else f.id;
        if (0 == e.data.px) app.util.request({
            url: "entry/wxapp/createorder",
            header: {
                "content-type": "application/json"
            },
            data: {
                types: "duo",
                openid: n,
                jsdata: JSON.stringify(d),
                couponid: o,
                price: r,
                dkscore: p,
                address: f.id,
                mjly: h,
                nav: u,
                formid: a,
                yunfei: c,
                discounts: e.data.discounts,
                discount_all_price: e.data.discount_all_price
            },
            success: function(a) {
                if ("1" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "请重新下单",
                    showCancel: !1
                }); else if ("2" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: a.data.data.title + "还剩:" + a.data.data.kc
                }); else if ("3" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "商品已经下架",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }); else if ("0" == a.data.errno) {
                    var t = a.data.data;
                    e.setData({
                        orderid: t
                    }), r <= e.data.money ? e.pay1(t) : e.pay2(t);
                }
            }
        }); else {
            var y = e.data.orderid;
            0 != e.data.sid && (r = e.data.order_info.price), app.util.request({
                url: "entry/wxapp/duoorderchangegg",
                header: {
                    "content-type": "application/json"
                },
                data: {
                    orderid: y,
                    couponid: o,
                    price: r,
                    dkscore: p,
                    openid: n,
                    address: f.id,
                    mjly: h,
                    nav: u,
                    formid: a
                },
                success: function(a) {
                    r <= e.data.money ? e.pay1(y) : e.pay2(y);
                }
            });
        }
    },
    mjly: function(a) {
        var t = a.detail.value;
        this.setData({
            mjly: t
        });
    },
    bindInputChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata, i = d[e].tp_text[t];
        d[e].val = i, this.setData({
            pagedata: d
        });
    },
    bindDateChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    bindTimeChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    checkboxChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    radioChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    formSubmit: function(a) {
        for (var e = this, t = (e.data.datas, !0), d = e.data.pagedata, i = 0; i < d.length; i++) if (1 == d[i].ismust) if (5 == d[i].type) {
            if ("" == d[i].z_val) return t = !1, wx.showModal({
                title: "提醒",
                content: d[i].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == d[i].val) return t = !1, wx.showModal({
            title: "提醒",
            content: d[i].name + "为必填项！",
            showCancel: !1
        }), !1;
        t && app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: 0,
                pagedata: JSON.stringify(d),
                types: "showOrder",
                openid: wx.getStorageSync("openid"),
                fid: e.data.fid
            },
            cachetime: "30",
            success: function(a) {
                var t = a.data.data.id;
                wx.showModal({
                    title: "提示",
                    content: a.data.data.con,
                    showCancel: !1,
                    success: function(a) {
                        e.sendMail_form(0, t), e.doshend(t);
                    }
                });
            }
        });
    },
    sendMail_form: function(a, t) {
        app.util.request({
            url: "entry/wxapp/sendMail_form",
            data: {
                id: a,
                cid: t
            },
            success: function(a) {
                return !0;
            },
            fail: function(a) {}
        });
    },
    choiceimg1111: function(a) {
        var s = this, t = 0, n = s.data.zhixin, o = a.currentTarget.dataset.index, r = s.data.pagedata, e = r[o].val, d = r[o].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var i = d - t, u = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), c = r[o].z_val ? r[o].z_val : [];
        wx.chooseImage({
            count: i,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                n = !0, s.setData({
                    zhixin: n
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, d = 0, i = t.length;
                !function e() {
                    wx.uploadFile({
                        url: u,
                        filePath: t[d],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            c.push(t), r[o].z_val = c, s.setData({
                                pagedata: r
                            }), ++d < i ? e() : (n = !1, s.setData({
                                zhixin: n
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.id, d = this.data.pagedata, i = d[t].z_val;
        i.splice(e, 1), 0 == i.length && (i = ""), d[t].z_val = i, this.setData({
            pagedata: d
        });
    },
    onPreviewImage: function(a) {
        app.util.showImage(a);
    },
    namexz: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.pagedata[t], d = [], i = 0; i < e.tp_text.length; i++) {
            var s = {};
            s.keys = e.tp_text[i], s.val = 1, d.push(s);
        }
        this.setData({
            ttcxs: 1,
            formindex: t,
            xx: d,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var a = new Date(), t = new Date(a.getTime()), e = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate(), d = this.data.xx, i = 0; i < d.length; i++) d[i].val = 1;
        this.setData({
            xx: d
        }), this.gettoday(e);
        var s = [], n = [], o = new Date();
        for (i = 0; i < 5; i++) {
            var r = new Date(o.getTime() + 24 * i * 3600 * 1e3), u = r.getFullYear(), c = r.getMonth() + 1, l = r.getDate(), p = c + "月" + l + "日", f = u + "-" + c + "-" + l;
            s.push(p), n.push(f);
        }
        this.setData({
            arrs: s,
            fallarrs: n,
            today: e
        });
    },
    xuanzd: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.fallarrs[t], d = this.data.xx, i = 0; i < d.length; i++) d[i].val = 1;
        this.setData({
            xuanz: t,
            today: e,
            lixuanz: -1,
            xx: d
        }), this.gettoday(e);
    },
    goux: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lixuanz: t
        });
    },
    gettoday: function(a) {
        var i = this, t = i.data.id, e = i.data.formindex, s = i.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: t,
                types: "showArt",
                days: a,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) s[t[e]].val = 2;
                var d = 0;
                t.length == s.length && (d = 1), i.setData({
                    xx: s,
                    isover: d
                });
            }
        });
    },
    save: function() {
        var a = this, t = a.data.today, e = a.data.xx, d = a.data.lixuanz;
        if (-1 == d) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var i = "已选择" + t + "，" + e[d].keys, s = a.data.pagedata, n = a.data.formindex;
        s[n].val = i, s[n].days = t, s[n].indexkey = n, s[n].xuanx = d, a.setData({
            ttcxs: 0,
            pagedata: s
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    refreshSessionkey: function() {
        var t = this;
        wx.login({
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        t.setData({
                            newSessionKey: a.data.data
                        });
                    }
                });
            }
        });
    },
    getPhoneNumber1: function(a) {
        var d = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: d.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = d.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0] && (t[e].val = a.data.data);
                            d.setData({
                                wxmobile: a.data.data,
                                pagedata: t
                            });
                        } else wx.showModal({
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
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    weixinadd: function() {
        var n = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, d = a.telNumber, i = n.data.pagedata, s = 0; s < i.length; s++) 0 == i[s].type && 2 == i[s].tp_text[0] && (i[s].val = e), 
                0 == i[s].type && 3 == i[s].tp_text[0] && (i[s].val = d), 0 == i[s].type && 4 == i[s].tp_text[0] && (i[s].val = t);
                n.setData({
                    myname: e,
                    mymobile: d,
                    myaddress: t,
                    pagedata: i
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
    },
    pay1: function(t) {
        var e = this;
        wx.showModal({
            title: "请注意",
            content: "您将使用余额支付" + e.data.sfje + "元",
            success: function(a) {
                a.confirm ? (e.payover_do(t), e.payover_fxs(t), wx.showLoading({
                    title: "下单中...",
                    mask: !0
                })) : (wx.navigateBack({
                    delta: 9
                }), wx.redirectTo({
                    url: "/sudu8_page/order_more_list/order_more_list"
                }));
            }
        });
    },
    pay2: function(t) {
        var e = this, a = wx.getStorageSync("openid");
        if (0 == e.data.sid) var d = e.data.sfje; else d = e.data.order_info.price;
        app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: a,
                price: d,
                order_id: t,
                types: "duo",
                formId: e.data.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                1 == a.data.data.errs && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.return_msg,
                    showCancel: !1
                });
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                }), 0 == a.data.data.err && (app.util.request({
                    url: "entry/wxapp/savePrepayid",
                    data: {
                        types: "duo",
                        order_id: t,
                        prepayid: a.data.data.package
                    },
                    success: function(a) {}
                }), wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function(a) {
                                e.payover_fxs(t), wx.showToast({
                                    title: "购买成功！",
                                    icon: "success",
                                    mask: !0,
                                    success: function() {
                                        setTimeout(function() {
                                            wx.redirectTo({
                                                url: "/sudu8_page/order_more_list/order_more_list"
                                            });
                                        }, 1500);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        wx.navigateBack({
                            delta: 9
                        }), wx.redirectTo({
                            url: "/sudu8_page/order_more_list/order_more_list"
                        });
                    },
                    complete: function(a) {}
                }));
            }
        });
    },
    payover_fxs: function(a) {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("fxsid");
        app.util.request({
            url: "entry/wxapp/payoverFxs",
            data: {
                openid: t,
                order_id: a,
                fxsid: e,
                types: "duo"
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    payover_do: function(a) {
        var t = wx.getStorageSync("openid"), e = this.data.sfje;
        app.util.request({
            url: "entry/wxapp/paynotify",
            data: {
                out_trade_no: a,
                openid: t,
                payprice: e,
                types: "duo",
                flag: 0,
                fxsid: this.data.fxsid,
                formId: this.data.formId
            },
            success: function(a) {
                "失败" == a.data.data.message ? wx.showToast({
                    title: "付款失败, 请刷新后重新付款！",
                    icon: "none",
                    mask: !0,
                    success: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 9
                            }), wx.redirectTo({
                                url: "/sudu8_page/order_more_list/order_more_list"
                            });
                        }, 1500);
                    }
                }) : wx.showToast({
                    title: "购买成功！",
                    icon: "success",
                    mask: !0,
                    success: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 9
                            }), wx.redirectTo({
                                url: "/sudu8_page/order_more_list/order_more_list"
                            });
                        }, 1500);
                    }
                });
            }
        });
    },
    huoqusq: function(a) {
        var t = this, e = wx.getStorageSync("openid");
        if (a.detail.userInfo) {
            var d = a.detail.userInfo, i = d.nickName, s = d.avatarUrl, n = d.gender, o = d.province, r = d.city, u = d.country;
            app.util.request({
                url: "entry/wxapp/Useupdate",
                data: {
                    openid: e,
                    nickname: i,
                    avatarUrl: s,
                    gender: n,
                    province: o,
                    city: r,
                    country: u
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(a) {
                    wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                    t.setData({
                        isview: 0,
                        globaluser: a.data.data
                    }), t.getinfos();
                }
            });
        } else wx.showModal({
            title: "获取失败",
            content: "请您允许授权",
            showCancel: !1,
            success: function(a) {
                a.confirm && wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.userInfo"] || wx.openSetting({
                            success: function(a) {
                                wx.reLaunch({
                                    url: "/sudu8_page/usercenter/usercenter"
                                });
                            }
                        });
                    }
                });
            }
        });
    }
});