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
        totalprice: "0.00",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [],
        showRemark: 0,
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
        order_id: 0,
        g_order_id: 0,
        come_order_id: 0,
        continuesubmit: !1,
        buytype: 0,
        is_modal_Hidden: !0,
        shiptypetitle: [ "无", "到店消费", "送货上门", "快递" ],
        tel: "",
        telnum: "",
        isclickpay: !1,
        rmoney: 0,
        rid: 0,
        goodsnum: 1
    },
    onLoad: function(e) {
        var i, d = this;
        if (console.log(e), 1 == e.redtype) {
            var s = e.rmoney, a = e.rid;
            c = (c = parseFloat(e.totalprice)).toFixed(2);
            var t = e.allowmoney, o = e.goodsnum, r = e.deliveryfee, n = e.sincetype;
            d.setData({
                rmoney: s,
                rid: a,
                totalprice: c,
                goodsnum: o,
                allowmoney: t,
                deliveryfee: r,
                sincetype: n
            });
        }
        wx.setNavigationBarTitle({
            title: d.data.navTile
        });
        var l = app.getSiteUrl();
        if (l ? d.setData({
            url: l
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), l = e.data, d.setData({
                    url: l
                });
            }
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
                console.log("69696969696969"), console.log(a), d.setData({
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
        }), e.order_id) {
            var p = e.order_id;
            d.setData({
                come_order_id: p
            });
        }
        e.buytype && (i = e.buytype, d.setData({
            buytype: i
        })), console.log("options"), console.log(e);
        var c, u = wx.getStorageSync("openid"), y = (s = d.data.rmoney, d.data.firstmoney);
        app.util.request({
            url: "entry/wxapp/PTorder",
            data: {
                id: e.id,
                openid: u
            },
            success: function(e) {
                var a = e.data.ship_type[0];
                if (1 == i && (e.data.ptprice = e.data.shopprice), 2 == a) {
                    r = parseFloat(e.data.ptprice) + parseFloat(e.data.ship_delivery_fee);
                    var t = e.data.ship_delivery_fee;
                } else if (3 == a) {
                    r = parseFloat(e.data.ptprice) + parseFloat(e.data.ship_express_fee);
                    t = e.data.ship_express_fee;
                } else {
                    r = parseFloat(e.data.ptprice);
                    t = "0.00";
                }
                r = (r = parseFloat(r - s)).toFixed(2);
                var o = parseFloat(e.data.shopprice - e.data.ptprice) + parseFloat(s) + parseFloat(y);
                if (o = o.toFixed(2), 0 < s) {
                    var r = d.data.totalprice;
                    a = d.data.sincetype, a = d.data.sincetype, t = d.data.deliveryfee;
                }
                if (r < 0) r = 0;
                console.log("拼团数据"), console.log(e.data), d.setData({
                    goods: e.data,
                    totalprice: r,
                    deliveryfee: t,
                    sincetype: a,
                    cardprice: o,
                    tel: e.data.telnumber ? e.data.telnumber : "",
                    cjid: e.data.cjid,
                    iscj: e.data.iscj,
                    gid: e.data.gid
                });
            }
        });
        s = d.data.rmoney, u = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: u
            },
            success: function(e) {
                if (console.log(e.data), 2 != e.data) {
                    var a = d.data.totalprice ? d.data.totalprice : d.data.ptprice, t = d.data.goods.ptprice;
                    if (1 == e.data.firstorder) a = a - (o = parseFloat(t) * parseFloat(e.data.firstmoney / 100)); else {
                        var o;
                        a = a - (o = parseFloat(e.data.firstmoney));
                    }
                    if (a = parseFloat(a - s), 0 < s && (a = parseFloat(d.data.totalprice)), a = a.toFixed(2), 
                    o = o.toFixed(2), a < 0) a = 0;
                    d.setData({
                        rebate: e.data,
                        totalprice: a,
                        firstmoney: o
                    });
                } else d.setData({
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
                d.setData({
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
                console.log(e), d.setData({
                    open_lottery: e.data.is_openzx
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var a = this, t = app.getSiteUrl();
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
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
        var a = e.currentTarget.dataset.type, t = this, o = (t.data.distribution, t.data.rmoney), r = t.data.firstmoney;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var i = t.data.goods, d = 0;
        d = 2 == a ? i.ship_delivery_fee : 3 == a ? i.ship_express_fee : 0;
        var s = parseFloat(d) + parseFloat(i.ptprice) - parseFloat(o) - parseFloat(r);
        d = 0 == d ? "0.00" : d;
        var n = parseFloat(t.data.allowmoney);
        parseFloat(s) + parseFloat(o) < n && (s = parseFloat(s) + parseFloat(o), t.setData({
            rmoney: 0
        })), s = s.toFixed(2), t.setData({
            totalprice: s,
            deliveryfee: d,
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
        var a = e.currentTarget.dataset.statu, i = this, t = i.data.tel, o = i.data.telnum, r = i.data.sincetype, d = i.data.totalprice;
        if (1 != r) {
            if (!o) return wx.showToast({
                title: "请输入电话号码",
                icon: "none",
                duration: 2e3
            }), !1;
        } else if (!t) return wx.showToast({
            title: "请输入电话号码",
            icon: "none",
            duration: 2e3
        }), !1;
        i.setData({
            payStatus: a
        }), 0 < d ? i.setData({
            isshowpay: 0
        }) : i.setData({
            isshowpay: 1
        });
        var s = i.data.rid, n = i.data.open_redpacket, l = i.data.rmoney, p = (d = i.data.totalprice, 
        parseFloat(d) + parseFloat(l));
        p = p.toFixed(2), n && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: s,
                m: app.globalData.Plugin_redpacket
            },
            success: function(e) {
                console.log(e.data), 111 == e.data && i.setData({
                    rmoney: 0,
                    totalprice: p
                });
            }
        });
        var c = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: c
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) {
                    var a = i.data.goods.ptprice, t = i.data.deliveryfee, o = i.data.rmoney, r = parseFloat(a) + parseFloat(t) - parseFloat(o);
                    r = r.toFixed(2), i.setData({
                        rebate: [],
                        totalprice: r,
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
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(e) {
        var a = !0, t = "", o = this, r = wx.getStorageSync("openid"), i = o.data.sincetype, d = (o.data.distributFee, 
        o.data.payType), s = o.data.time, n = o.data.uremark, l = o.data.shiptypetitle[i], p = e.detail.value.price, c = e.detail.value.id, u = e.detail.value.name, y = e.detail.value.tel, f = e.detail.value.count, g = e.detail.value.city, m = e.detail.value.detai, h = e.detail.value.province, v = e.detail.value.telnum, _ = o.data.deliveryfee, w = o.data.rid, x = o.data.firstmoney, F = o.data.rmoney, D = o.data.goods.ptprice;
        if (o.data.totalprice <= 0) return wx.showModal({
            title: "提示",
            content: "金额不能等于0",
            showCancel: !1
        }), !1;
        var b = o.data.come_order_id;
        if (0 < b) {
            console.log("不是团长");
            var S = 0;
        } else {
            console.log("团长");
            S = 1;
        }
        var P = o.data.buytype;
        if ("1" == i) if (y && "" != y) if ("" == d) t = "请选择支付方式"; else {
            a = !1;
            var k = {
                price: p,
                id: c,
                openid: r,
                uremark: n,
                time: s,
                telNumber: y,
                sincetype: l,
                come_order_id: b,
                buytype: P,
                payType: d,
                rid: w,
                firstmoney: x,
                rmoney: F,
                goodsprice: D
            };
        } else t = "请输入消费电话"; else if ("" == d && (t = "请选择支付方式"), "" == u) t = "请选择收货地址"; else {
            var T;
            a = !1;
            k = (_defineProperty(T = {
                price: p,
                id: c,
                openid: r,
                uremark: n,
                cityName: g,
                detailInfo: m,
                telNumber: v,
                countyName: f,
                name: u,
                sincetype: l
            }, "openid", r), _defineProperty(T, "provinceName", h), _defineProperty(T, "come_order_id", b), 
            _defineProperty(T, "deliveryfee", _), _defineProperty(T, "buytype", P), _defineProperty(T, "payType", d), 
            _defineProperty(T, "rid", w), _defineProperty(T, "firstmoney", x), _defineProperty(T, "rmoney", F), 
            _defineProperty(T, "goodsprice", D), T);
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
        o.setData({
            isclickpay: !0
        });
        var M = e.detail.formId, q = o.data.continuesubmit, C = o.data.order_id, N = o.data.g_order_id, U = {
            payType: d,
            resulttype: 0,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayptOrder",
            PayredirectTourl: "/mzhk_sun/pages/user/mygroup/mygroup?id=" + c
        };
        q && 0 < N && 0 < C ? (console.log("正在执行继续支付"), U.orderarr = {
            price: p,
            openid: r,
            order_id: C,
            g_order_id: N,
            is_lead: S,
            ordertype: 1,
            buytype: P,
            rid: w
        }, U.SendMessagePay = {
            id: c,
            price: p,
            order_id: N,
            openid: r,
            form_id: M,
            typeid: 2,
            rid: w
        }, U.PayOrder = {
            openid: r,
            order_id: C,
            g_order_id: N
        }, app.func.orderarr(app, o, U)) : (console.log("正在执行新支付"), app.util.request({
            url: "entry/wxapp/AddptOrder",
            data: k,
            success: function(e) {
                C = e.data.order_id, N = e.data.g_order_id, 0 < C && 0 < N ? (o.setData({
                    order_id: C,
                    g_order_id: N
                }), U.orderarr = {
                    price: p,
                    openid: r,
                    order_id: C,
                    g_order_id: N,
                    is_lead: S,
                    ordertype: 1,
                    rid: w
                }, U.SendMessagePay = {
                    id: c,
                    price: p,
                    order_id: N,
                    openid: r,
                    form_id: M,
                    typeid: 2,
                    rid: w
                }, U.PayOrder = {
                    openid: r,
                    order_id: C,
                    g_order_id: N
                }, app.func.orderarr(app, o, U)) : (wx.showModal({
                    title: "提示",
                    content: "订单信息提交失败，请重新提交",
                    showCancel: !1,
                    success: function(e) {}
                }), o.setData({
                    isclickpay: !1
                }));
            },
            fail: function(e) {
                console.log("失败00005"), wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                }), o.setData({
                    isclickpay: !1
                });
            }
        }));
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
        var a = this, t = e.currentTarget.dataset.id, o = a.data.goods.ptprice, r = a.data.totalprice, i = a.data.deliveryfee, d = a.data.sincetype, s = a.data.firstmoney;
        if (console.log(o), 1 == a.data.buytype) var n = 3; else n = 4;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/choicePacket/choicePacket?id=" + t + "&price=" + o + "&totalprice=" + r + "&goodsnum=1&type=" + n + "&deliveryfee=" + i + "&sincetype=" + d + "&firstmoney=" + s
        });
    }
});