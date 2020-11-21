var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/shoppay/shoppay",
        baseinfo: [],
        userInfo: "",
        searchtitle: "",
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico,
            mf: 0
        },
        scopes: !1,
        money: 0,
        yue: 0,
        guiz: "",
        weixpay: 0,
        paymoney: 0,
        jifen_u: 0,
        jfscore: 0,
        jfmoney: 0,
        jqdjg: "请选择",
        yhq_hidden: 0,
        yhqmoney: 0,
        yhq_id: 0,
        sid: 0
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        wx.setNavigationBarTitle({
            title: "店内支付"
        });
        var e = this;
        e.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var t = 0;
        a.fxsid && (t = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        a.sid && (a.sid, e.setData({
            sid: a.sid
        })), wx.getSystemInfo({
            success: function(a) {
                e.setData({
                    h: a.windowHeight
                });
            }
        }), e.getBase(), app.util.getUserInfo(e.getinfos, t);
    },
    redirectto: function(a) {
        var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
        app.util.redirectto(e, t);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                }), e.getGuiz();
            }
        });
    },
    getBase: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                }), 0 < e.data.sid && e.getshopsbase();
            },
            fail: function(a) {}
        });
    },
    getGuiz: function() {
        var e = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Guiz",
            data: {
                openid: a
            },
            success: function(a) {
                e.setData({
                    scroeconf: a.data.data.conf,
                    yhq: a.data.data.coupon,
                    guiz: a.data.data,
                    yue: a.data.data.user.money,
                    score: a.data.data.user.score,
                    score_shoppay: a.data.data.conf.score_shoppay
                });
            },
            fail: function(a) {}
        });
    },
    makePhoneCall: function(a) {
        var e = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    makePhoneCallB: function(a) {
        var e = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    openMap: function(a) {
        var e = this;
        wx.openLocation({
            latitude: parseFloat(e.data.baseinfo.latitude),
            longitude: parseFloat(e.data.baseinfo.longitude),
            name: e.data.baseinfo.name,
            address: e.data.baseinfo.address,
            scale: 22
        });
    },
    chongz: function() {
        wx.navigateTo({
            url: "/sudu8_page/recharge/recharge"
        });
    },
    switchChange: function(a) {
        var e = this, t = a.detail.value, o = (1e3 * e.data.paymoney - 1e3 * e.data.yhqmoney) / 1e3;
        if (1 == t) {
            e.data.money;
            var n = e.data.weixpay, s = e.data.yue, i = e.data.score_shoppay, d = e.data.score, r = e.data.scroeconf;
            if (parseInt(i) >= parseInt(r.scroe) && parseInt(d) >= parseInt(r.scroe)) {
                if (parseInt(d) >= parseInt(i)) var p = parseInt(i * r.money) / parseInt(r.scroe); else p = parseInt(d * r.money) / parseInt(r.scroe);
                if (o <= p) e.setData({
                    weixpay: 0,
                    money: 0,
                    jfmoney: o,
                    jfscore: o * r.scroe,
                    jifen_u: 1,
                    mf: 1
                }); else {
                    var c = p * (r.scroe / r.money);
                    n = (n = (1e3 * o - 1e3 * s - 1e3 * p) / 1e3) < 0 ? 0 : n, e.setData({
                        money: (1e3 * o - 1e3 * n - 1e3 * p) / 1e3,
                        weixpay: n,
                        jfmoney: p,
                        jfscore: c,
                        jifen_u: 1,
                        mf: 1
                    });
                }
            } else {
                n = (n = (1e3 * o - 1e3 * s) / 1e3) < 0 ? 0 : n, e.setData({
                    money: (1e3 * o - 1e3 * n) / 1e3,
                    weixpay: n,
                    jfmoney: 0,
                    jfscore: 0,
                    jifen_u: 1,
                    mf: 1
                });
            }
        } else {
            n = (n = (1e3 * o - 1e3 * (s = e.data.yue)) / 1e3) < 0 ? 0 : n, e.setData({
                money: (1e3 * o - 1e3 * n) / 1e3,
                weixpay: n,
                jfscore: 0,
                jfmoney: 0,
                jifen_u: 0,
                mf: 0
            });
        }
    },
    setsubmit: function() {
        var e = this, a = wx.getStorageSync("openid"), t = e.data.paymoney, o = e.data.weixpay, n = e.data.money, s = e.data.jfscore, i = (e.data.yhqmoney, 
        e.data.yhq_id), d = e.data.jfmoney;
        if (!t && 0 == d || t <= 0 && 0 == d) return wx.showModal({
            title: "提醒",
            content: "请输入正确的消费金额！",
            showCancel: !1
        }), !1;
        0 == o ? app.util.request({
            url: "entry/wxapp/Shoppay_duo",
            data: {
                openid: a,
                ordermoeny: t,
                yuemoney: n,
                money: 0,
                order_id: "",
                jfscore: s,
                yhq_id: i,
                sid: e.data.sid
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 3e3,
                    success: function() {
                        setTimeout(function() {
                            wx.redirectTo({
                                url: "/sudu8_page/shoppay/shoppay?sid=" + e.data.sid
                            });
                        }, 3e3);
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Balance",
            data: {
                openid: a,
                ordermoeny: t,
                yuemoney: n,
                money: o
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                e.setData({
                    order_id: a.data.data.order_id
                }), "success" == a.data.message && wx.requestPayment({
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
                                e.dosetmoney(e.data.order_id, n, o);
                            }
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                }), "error" == a.data.message && wx.showModal({
                    title: "提醒",
                    content: a.data.data.message,
                    showCancel: !1
                });
            }
        });
    },
    dosetmoney: function(a, e, t) {
        var o = this, n = wx.getStorageSync("openid"), s = o.data.jfscore, i = o.data.yhq_id;
        app.util.request({
            url: "entry/wxapp/dosetmoney",
            data: {
                openid: n,
                orderid: 1001,
                yemoney: e,
                wxmoney: t,
                jfscore: s,
                yhq_id: i,
                sid: o.data.sid
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                wx.redirectTo({
                    url: "/sudu8_page/shoppay/shoppay?sid=" + o.data.sid
                });
            }
        });
    },
    setmoney: function(a) {
        var e = a.detail.value, t = a.detail.value;
        if ("" == e) return this.setData({
            money: 0,
            weixpay: 0,
            jfmoney: 0,
            jfscore: 0,
            paymoney: 0,
            jifen_u: 0,
            yhq_id: 0,
            yhqmoney: 0,
            yhqid: 0,
            jqdjg: "请选择"
        }), !1;
        var o = this.data.yue, n = this.data.jfmoney, s = (1e3 * e - 1e3 * o - 1e3 * n) / 1e3;
        s = s < 0 ? 0 : s, this.setData({
            money: (1e3 * e - 1e3 * s - 1e3 * n) / 1e3,
            weixpay: s,
            paymoney: t
        });
    },
    getmoney: function(a) {
        var e = this, t = e.data.paymoney, o = e.data.jfmoney, n = (a.currentTarget.id, 
        a.currentTarget.dataset.index), s = (1e3 * t - 1e3 * o) / 1e3, i = n.pay_money, d = n.ids;
        if (s < i) return wx.showModal({
            title: "提示",
            content: "价格未满" + i + "元，不可使用该优惠券！",
            showCancel: !1
        }), !1;
        var r = n.price, p = (1e3 * s - 1e3 * e.data.yue - 1e3 * r) / 1e3;
        p = p < 0 ? 0 : p, e.hideModal(), e.setData({
            money: (1e3 * s - 1e3 * p - 1e3 * r) / 1e3,
            weixpay: p,
            yhq_id: d,
            yhqmoney: r,
            jqdjg: n.title
        });
    },
    qxyh: function() {
        var a = this, e = (1e3 * a.data.paymoney - 1e3 * a.data.jfmoney) / 1e3, t = (1e3 * e - 1e3 * a.data.yue) / 1e3;
        t = t < 0 ? 0 : t, a.hideModal(), a.setData({
            money: (1e3 * e - 1e3 * t) / 1e3,
            weixpay: t,
            yhq_id: 0,
            yhqmoney: 0,
            jqdjg: "请选择"
        });
    },
    showModal: function() {
        if (0 == this.data.paymoney) return wx.showModal({
            title: "提醒",
            content: "请先输入消费金额"
        }), !1;
        this.setData({
            ischecked: !1
        }), this.switchChange({
            detail: {
                value: !1
            }
        });
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
    getshopsbase: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getshopsbase",
            data: {
                sid: e.data.sid
            },
            success: function(a) {
                e.setData({
                    shopsbase: a.data.data
                });
            }
        });
    }
});