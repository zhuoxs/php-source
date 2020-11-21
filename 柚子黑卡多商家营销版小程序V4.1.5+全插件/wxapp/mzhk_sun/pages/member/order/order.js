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
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        rebate: [],
        firstmoney: 0,
        sincetype: "0",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [],
        showRemark: 0,
        isshowpay: 0,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        uremark: "",
        showuremark: "20字以内",
        orderNum: "1111111111111",
        orderTime: "2018-02-02 10:30",
        deliveryfee: 0,
        is_modal_Hidden: !0,
        typeid: 0,
        order_id: 0,
        continuesubmit: !1,
        shiptypetitle: [ "", "到店消费", "送货上门", "快递" ],
        tel: "",
        telnum: "",
        isclickpay: !1,
        goodsnum: 1,
        rmoney: 0,
        rid: 0
    },
    onLoad: function(s) {
        var n = this;
        if (console.log(s), 1 == s.redtype) {
            var d = s.rmoney, e = s.rid;
            i = (i = parseFloat(s.totalprice)).toFixed(2);
            var a = s.allowmoney, t = s.goodsnum, o = s.deliveryfee, r = s.sincetype;
            if (console.log(t), i < 0) var i = 0;
            n.setData({
                rmoney: d,
                rid: e,
                totalprice: i,
                goodsnum: t,
                allowmoney: a,
                deliveryfee: o,
                sincetype: r
            });
        }
        wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var l = app.getSiteUrl();
        n.setData({
            url: l
        });
        var p = wx.getStorageSync("openid");
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var a = n.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log("69696969696969"), console.log(a), n.setData({
                    choose: a
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        }), n.setData({
            id: s.id,
            price: s.price,
            typeid: s.typeid ? s.typeid : 0
        });
        p = wx.getStorageSync("openid"), d = n.data.rmoney;
        var c = n.data.firstmoney;
        app.util.request({
            url: "entry/wxapp/Cforder",
            data: {
                id: s.id,
                openid: p
            },
            success: function(e) {
                console.log("yueyue"), console.log(e.data);
                var a, t = e.data.ship_type[0];
                if (a = n.data.price, 2 == t) {
                    i = parseFloat(a) + parseFloat(e.data.ship_delivery_fee);
                    var o = e.data.ship_delivery_fee;
                } else if (3 == t) {
                    i = parseFloat(a) + parseFloat(e.data.ship_express_fee);
                    o = e.data.ship_express_fee;
                } else {
                    i = parseFloat(a);
                    o = "0.00";
                }
                i = (i = parseFloat(i - d)).toFixed(2);
                var r = parseFloat(e.data.shopprice - a) + parseFloat(d) + parseFloat(c);
                if (r = r.toFixed(2), 0 < d) {
                    var i = n.data.totalprice;
                    t = n.data.sincetype, t = n.data.sincetype, o = n.data.deliveryfee;
                }
                if (i < 0) i = 0;
                n.setData({
                    goods: e.data,
                    totalprice: i,
                    price: s.price,
                    deliveryfee: o,
                    cardprice: r,
                    sincetype: t,
                    tel: e.data.telnumber ? e.data.telnumber : "",
                    cjid: e.data.cjid,
                    iscj: e.data.iscj,
                    gid: e.data.gid
                }), n.getUrl();
            }
        });
        d = n.data.rmoney, p = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: p
            },
            success: function(e) {
                if (console.log(e.data), 2 != e.data) {
                    var a = n.data.totalprice ? n.data.totalprice : n.data.price * n.data.goodsnum, t = n.data.price, o = n.data.goodsnum;
                    if (1 == e.data.firstorder) a = t * o - (r = t * o * parseFloat(e.data.firstmoney / 100)); else {
                        var r;
                        a = a - (r = parseFloat(e.data.firstmoney));
                    }
                    if (a = parseFloat(a - d), 0 < d && (a = parseFloat(n.data.totalprice)), a = a.toFixed(2), 
                    r = r.toFixed(2), a < 0) a = 0;
                    n.setData({
                        rebate: e.data,
                        totalprice: a,
                        firstmoney: r
                    });
                } else n.setData({
                    rebate: []
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(e) {
                2 != e.data && e.data;
                n.setData({
                    open_redpacket: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 9
            },
            showLoading: !1,
            success: function(e) {
                console.log(e), n.setData({
                    open_lottery: e.data.is_openzx
                });
            }
        });
    },
    toaddlessbtn: function(e) {
        var a = this, t = a.data.goodsnum, o = e.currentTarget.dataset.ty, r = a.data.goods, i = a.data.sincetype, s = 0, n = a.data.price, d = r.limitnum - r.total, l = a.data.rebate, p = a.data.firstmoney, c = a.data.rmoney, u = a.data.deliveryfee;
        if (a.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改数量；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        if (1 == o) if (0 < r.limitnum) {
            if (!(t < d)) return wx.showModal({
                title: "提示信息",
                content: "该商品你最多还能购买" + d + "个",
                showCancel: !1
            }), !1;
            t = parseInt(t) + 1;
        } else t = parseInt(t) + 1; else 1 < t && (t = parseInt(t) - 1);
        if (s = 2 == i ? parseFloat(n * t) + parseFloat(r.ship_delivery_fee) : 3 == i ? parseFloat(n * t) + parseFloat(r.ship_express_fee) : parseFloat(n * t), 
        1 == l.firstorder_open) {
            if (1 == l.firstorder) s = n * t - (p = n * t * parseFloat(l.firstmoney / 100)) + parseFloat(u); else s = n * t - (p = parseFloat(l.firstmoney)) + parseFloat(u);
            p = p.toFixed(2);
        }
        if ((s = parseFloat(s - c)) < 0) s = 0;
        s = s.toFixed(2);
        var y = parseFloat(a.data.allowmoney);
        parseFloat(s) + parseFloat(c) < y && (s = parseFloat(s) + parseFloat(c), a.setData({
            rmoney: 0
        }));
        var f = parseFloat((r.shopprice - n) * t) + parseFloat(c) + parseFloat(p);
        f = f.toFixed(2), a.setData({
            goodsnum: t,
            totalprice: s,
            cardprice: f,
            firstmoney: p
        });
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var e = app.getSiteUrl();
        this.setData({
            url: e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindTimeChange: function(e) {
        this.setData({
            time: e.detail.value
        });
    },
    chooseType: function(e) {
        var a = e.currentTarget.dataset.type, t = this, o = (t.data.distribution, t.data.goodsnum), r = t.data.rmoney, i = t.data.firstmoney;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var s = t.data.goods, n = 0;
        n = 2 == a ? s.ship_delivery_fee : 3 == a ? s.ship_express_fee : 0;
        var d = parseFloat(n) + parseFloat(t.data.price * o - r - i);
        if (n = 0 == n ? "0.00" : n, d < 0) d = 0;
        var l = parseFloat(t.data.allowmoney);
        parseFloat(d) + parseFloat(r) < l && (d = parseFloat(d) + parseFloat(r), t.setData({
            rmoney: 0
        })), d = d.toFixed(2), t.setData({
            totalprice: d,
            deliveryfee: n,
            sincetype: a
        });
    },
    powerDrawer: function(e) {
        var a = e.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(e) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("550rpx").step(), this.setData({
                animationData: a
            }), "close" == e && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == e && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(e) {
        var a = e.currentTarget.dataset.price, t = this.data.totalprice, o = parseFloat(t) - parseFloat(a);
        console.log(t), o < 0 && (o = 0), this.setData({
            cardprice: a,
            curprice: o
        }), this.util("close");
    },
    showModel: function(e) {
        var a = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: a
        });
    },
    showPay: function(e) {
        var s = this, a = s.data.tel, t = s.data.telnum, o = s.data.sincetype;
        if (1 != o) {
            if (!t) return wx.showToast({
                title: "请输入电话号码",
                icon: "none",
                duration: 2e3
            }), !1;
        } else if (!a) return wx.showToast({
            title: "请输入电话号码",
            icon: "none",
            duration: 2e3
        }), !1;
        var r = s.data.totalprice, i = e.currentTarget.dataset.statu, n = s.data.hasAddress;
        if (1 != o && !n) return wx.showToast({
            title: "收货地址不能为空！！！",
            icon: "none",
            duration: 2e3
        }), !1;
        s.setData({
            payStatus: i
        }), 0 < r ? s.setData({
            isshowpay: 0
        }) : s.setData({
            isshowpay: 1
        });
        var d = s.data.rid, l = s.data.open_redpacket, p = s.data.rmoney, c = s.data.totalprice, u = parseFloat(c) + parseFloat(p);
        u = u.toFixed(2), l && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: d,
                m: app.globalData.Plugin_redpacket
            },
            success: function(e) {
                console.log(e.data), 111 == e.data && s.setData({
                    rmoney: 0,
                    totalprice: u
                });
            }
        });
        var y = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: y
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) {
                    var a = s.data.price, t = s.data.goodsnum, o = s.data.deliveryfee, r = s.data.rmoney, i = parseFloat(a * t) + parseFloat(o) - parseFloat(r);
                    i = i.toFixed(2), s.setData({
                        rebate: [],
                        totalprice: i,
                        firstmoney: 0
                    });
                }
            }
        });
    },
    remark: function(e) {
        var a = e.detail.value;
        this.setData({
            uremark: a,
            showuremark: a
        });
    },
    radioChange: function(e) {
        var a = e.detail.value;
        this.setData({
            payType: a
        });
    },
    formSubmit: function(e) {
        var a = !0, t = "", o = this, r = wx.getStorageSync("openid"), i = o.data.sincetype, s = o.data.deliveryfee, n = o.data.payType, d = o.data.time, l = o.data.uremark, p = o.data.shiptypetitle[i], c = (r = wx.getStorageSync("openid"), 
        o.data.totalprice), u = e.detail.value.id, y = e.detail.value.name, f = e.detail.value.tel, m = e.detail.value.count, g = e.detail.value.city, h = e.detail.value.detai, w = e.detail.value.province, v = e.detail.value.telnum, _ = o.data.goodsnum, F = o.data.price, x = o.data.rid, P = o.data.firstmoney, k = o.data.rmoney;
        if (1 == (A = o.data.typeid) && 0 == c) n = 2;
        if (0 < c || 1 == A && 0 == c) {
            if ("1" == i) if (f && "" != f) if ("" == n) t = "请选择支付方式"; else {
                a = !1;
                var D = {
                    price: c,
                    id: u,
                    openid: r,
                    uremark: l,
                    time: d,
                    telNumber: f,
                    sincetype: p,
                    goodsnum: _,
                    goodsprice: F,
                    rid: x,
                    typeid: A,
                    payType: n,
                    firstmoney: P,
                    rmoney: k
                };
            } else t = "请输入正确的消费电话号码"; else if ("" == n && (t = "请选择支付方式"), "" == y) t = "请选择收货地址"; else {
                var S;
                a = !1;
                D = (_defineProperty(S = {
                    price: c,
                    id: u,
                    openid: r,
                    uremark: l,
                    cityName: g,
                    detailInfo: h,
                    telNumber: v,
                    countyName: m,
                    name: y,
                    sincetype: p
                }, "openid", r), _defineProperty(S, "provinceName", w), _defineProperty(S, "deliveryfee", s), 
                _defineProperty(S, "goodsnum", _), _defineProperty(S, "goodsprice", F), _defineProperty(S, "rid", x), 
                _defineProperty(S, "typeid", A), _defineProperty(S, "payType", n), _defineProperty(S, "firstmoney", P), 
                _defineProperty(S, "rmoney", k), S);
            }
            if (1 == a) return wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1
            }), !1;
            if (o.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
                title: "请稍后...",
                icon: "none",
                duration: 2e3
            }), !1;
            if (o.setData({
                isclickpay: !0
            }), 1 == A) var T = 4, b = 4; else T = 0, b = 1;
            var M = e.detail.formId, N = {
                payType: n,
                resulttype: 0,
                orderarr: "",
                SendMessagePay: "",
                PayOrder: "",
                SendSms: "",
                PayOrderurl: "entry/wxapp/PayqgOrder",
                PayredirectTourl: "/mzhk_sun/pages/user/myorder/myorder?id=" + u
            }, C = o.data.continuesubmit, q = o.data.order_id;
            C && 0 < q ? (console.log("正在执行继续支付"), N.orderarr = {
                price: c,
                openid: r,
                order_id: q,
                ordertype: T
            }, N.SendMessagePay = {
                id: u,
                price: c,
                order_id: q,
                openid: r,
                form_id: M,
                typeid: b
            }, N.PayOrder = {
                order_id: q,
                typeid: A
            }, 1 == A && (N.PayredirectTourl = "/mzhk_sun/pages/user/order/order?id=" + u), 
            app.func.orderarr(app, o, N)) : (console.log("正在执行新支付"), app.util.request({
                url: "entry/wxapp/AddqgOrder",
                data: D,
                success: function(e) {
                    console.log(e);
                    var a = e.data;
                    0 < a ? (o.setData({
                        order_id: a
                    }), N.orderarr = {
                        price: c,
                        openid: r,
                        order_id: a,
                        ordertype: T
                    }, N.SendMessagePay = {
                        id: u,
                        price: c,
                        order_id: a,
                        openid: r,
                        form_id: M,
                        typeid: b
                    }, N.PayOrder = {
                        order_id: a,
                        typeid: A
                    }, 1 == A && (N.PayredirectTourl = "/mzhk_sun/pages/user/order/order?id=" + u), 
                    app.func.orderarr(app, o, N)) : (wx.showModal({
                        title: "提示",
                        content: "订单信息提交失败，请重新提交",
                        showCancel: !1,
                        success: function(e) {}
                    }), o.setData({
                        isclickpay: !1
                    }));
                },
                fail: function(e) {
                    o.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: e.data.message,
                        showCancel: !1,
                        success: function(e) {}
                    });
                }
            }));
        } else {
            n = 3;
            var A = 4;
            if ("1" == i) if (f && "" != f) D = {
                price: c,
                id: u,
                openid: r,
                uremark: l,
                time: d,
                rid: x,
                telNumber: f,
                sincetype: p,
                goodsnum: _,
                goodsprice: F,
                typeid: A,
                payType: n,
                rmoney: k,
                firstmoney: P
            }; else t = "请输入正确的消费电话号码"; else if ("" == y) t = "请选择收货地址"; else {
                var z;
                D = (_defineProperty(z = {
                    price: c,
                    id: u,
                    openid: r,
                    uremark: l,
                    cityName: g,
                    detailInfo: h,
                    rid: x,
                    telNumber: v,
                    countyName: m,
                    name: y,
                    sincetype: p
                }, "openid", r), _defineProperty(z, "provinceName", w), _defineProperty(z, "deliveryfee", s), 
                _defineProperty(z, "goodsnum", _), _defineProperty(z, "goodsprice", F), _defineProperty(z, "typeid", A), 
                _defineProperty(z, "payType", n), _defineProperty(z, "rmoney", k), _defineProperty(z, "firstmoney", P), 
                z);
            }
            app.util.request({
                url: "entry/wxapp/AddZeroOrder",
                data: D,
                success: function(e) {
                    console.log(e), wx.showToast({
                        title: "购买成功",
                        icon: "success",
                        duration: 2e3
                    }), o.data.iscj - 0 == 1 && o.data.open_lottery ? wx.showModal({
                        title: "提示",
                        content: "购买成功,获得抽奖资格,是否参与抽奖",
                        success: function(e) {
                            e.confirm ? wx.redirectTo({
                                url: "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?ggid=" + o.data.gid + "&gid=" + o.data.cjid
                            }) : e.cancel && wx.redirectTo({
                                url: "/mzhk_sun/pages/user/myorder/myorder"
                            });
                        }
                    }) : wx.redirectTo({
                        url: "/mzhk_sun/pages/user/myorder/myorder"
                    });
                },
                fail: function(e) {
                    wx.showModal({
                        title: "提示",
                        content: e.data.message,
                        showCancel: !1,
                        success: function(e) {}
                    });
                }
            });
        }
    },
    toAddress: function() {
        var a = this;
        a.data.telnum;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), a.setData({
                    address: e,
                    telnum: e.telNumber,
                    hasAddress: !0
                });
            },
            fail: function(e) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    nowtel: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.data.tel;
        this.setData({
            tel: a
        });
    },
    toPackageUse: function(e) {
        var a = this, t = e.currentTarget.dataset.id, o = a.data.price, r = a.data.totalprice, i = a.data.goodsnum, s = a.data.deliveryfee, n = a.data.sincetype, d = a.data.firstmoney;
        if (1 == a.data.typeid) var l = 1; else l = 2;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/choicePacket/choicePacket?id=" + t + "&price=" + o + "&totalprice=" + r + "&goodsnum=" + i + "&type=" + l + "&deliveryfee=" + s + "&sincetype=" + n + "&firstmoney=" + d
        });
    }
});