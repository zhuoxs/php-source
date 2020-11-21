var app = getApp();

Page({
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        sincetype: "0",
        cardprice: "0",
        curprice: "0",
        price: 0,
        showModalStatus: !1,
        cards: [],
        showRemark: 0,
        choose: [ {
            name: "微信",
            value: "1",
            icon: "../../../../style/images/wx.png",
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
        shiptypetitle: [ "", "到店消费", "送货上门", "快递" ],
        tel: "",
        isclickpay: !1
    },
    onLoad: function(s) {
        var d = this;
        wx.setNavigationBarTitle({
            title: d.data.navTile
        });
        var a = app.getSiteUrl();
        a ? d.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, d.setData({
                    url: a
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
                d.setData({
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
        });
        d.setData({
            id: s.id,
            price: 0
        });
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Cforder",
            data: {
                id: s.id,
                openid: e
            },
            success: function(e) {
                var a, t, r = e.data.ship_type[0];
                if (a = d.data.price, 2 == r) {
                    t = parseFloat(a) + parseFloat(e.data.ship_delivery_fee);
                    var i = e.data.ship_delivery_fee;
                } else if (3 == r) {
                    t = parseFloat(a) + parseFloat(e.data.ship_express_fee);
                    i = e.data.ship_express_fee;
                } else {
                    t = parseFloat(a);
                    i = "0.00";
                }
                var o = (e.data.shopprice - a).toFixed(2);
                d.setData({
                    goods: e.data,
                    totalprice: t,
                    price: s.price,
                    deliveryfee: i,
                    cardprice: o,
                    sincetype: r,
                    tel: e.data.telnumber ? e.data.telnumber : ""
                });
            }
        }), d.setData({
            id: s.id
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
        var a = e.currentTarget.dataset.type, t = this;
        t.data.distribution;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var r = t.data.goods, i = 0;
        i = 2 == a ? r.ship_delivery_fee : 3 == a ? r.ship_express_fee : 0;
        var o = parseFloat(i) + parseFloat(t.data.price);
        i = 0 == i ? "0.00" : i, t.setData({
            totalprice: o,
            deliveryfee: i,
            sincetype: a
        });
    },
    coupon: function(e) {
        var a = this, t = e.currentTarget.dataset.price, r = a.data.totalprice, i = parseFloat(r) - parseFloat(t);
        console.log(r), i < 0 && (i = 0), a.setData({
            cardprice: t,
            curprice: i
        }), a.util("close");
    },
    showModel: function(e) {
        var a = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: a
        });
    },
    showPay: function(e) {
        var a = e.currentTarget.dataset.statu, t = this.data.hasAddress;
        if (1 != this.data.sincetype && !t) return wx.showToast({
            title: "收货地址不能为空！！！",
            icon: "none",
            duration: 2e3
        }), !1;
        this.setData({
            payStatus: a
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
        var a = !0, t = "", r = this, i = wx.getStorageSync("openid"), o = r.data.sincetype, s = r.data.deliveryfee, d = r.data.payType, n = r.data.time, c = r.data.uremark, p = r.data.shiptypetitle[o], l = (i = wx.getStorageSync("openid"), 
        r.data.totalprice), u = e.detail.value.id, y = e.detail.value.name, f = e.detail.value.tel, h = e.detail.value.count, g = e.detail.value.city, m = e.detail.value.detai, v = e.detail.value.province, w = e.detail.value.telnum, S = e.detail.formId;
        if ("1" == o) if (f && "" != f) if ("" == d) t = "请选择支付方式"; else {
            a = !1;
            var _ = {
                price: l,
                id: u,
                openid: i,
                uremark: c,
                time: n,
                telNumber: f,
                sincetype: p,
                paytype: d
            };
        } else t = "请输入正确的消费电话号码"; else if ("" == d && (t = "请选择支付方式"), "" == y) t = "请选择收货地址"; else {
            a = !1;
            _ = {
                price: l,
                id: u,
                openid: i,
                uremark: c,
                cityName: g,
                detailInfo: m,
                telNumber: w,
                countyName: h,
                name: y,
                sincetype: p,
                provinceName: v,
                deliveryfee: s,
                paytype: d
            };
        }
        if (1 == a) return wx.showModal({
            title: "提示",
            content: t,
            showCancel: !1
        }), !1;
        if (r.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        r.setData({
            isclickpay: !0
        });
        var x = r.data.continuesubmit, D = r.data.order_id, k = (S = e.detail.formId, {
            payType: d,
            resulttype: 1,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "",
            PayredirectTourl: ""
        });
        x && 0 < D ? (console.log("正在执行继续支付"), 0 < l ? (k.orderarr = {
            price: l,
            openid: i,
            order_id: D,
            ordertype: 3
        }, k.SendMessagePay = {
            id: u,
            price: l,
            order_id: D,
            openid: i,
            form_id: S,
            typeid: 3
        }, k.SendSms = {
            order_id: D,
            ordertype: 3
        }, app.func.orderarr(app, r, k)) : (k.orderarr = {
            price: l,
            openid: i,
            order_id: D,
            ordertype: 3
        }, k.SendMessagePay = {
            id: u,
            price: l,
            order_id: D,
            openid: i,
            form_id: S,
            typeid: 3
        }, k.SendSms = {
            order_id: D,
            ordertype: 3
        }, app.func.payresultsms(app, r, k))) : (console.log("正在执行新支付"), app.util.request({
            url: "entry/wxapp/AddjkOrder",
            data: _,
            success: function(e) {
                console.log(e);
                var a = e.data;
                r.setData({
                    order_id: a
                }), 0 < l ? (k.orderarr = {
                    price: l,
                    openid: i,
                    order_id: a,
                    ordertype: 3
                }, k.SendMessagePay = {
                    id: u,
                    price: l,
                    order_id: a,
                    openid: i,
                    form_id: S,
                    typeid: 3
                }, k.SendSms = {
                    order_id: a,
                    ordertype: 3
                }, app.func.orderarr(app, r, k)) : (k.orderarr = {
                    price: l,
                    openid: i,
                    order_id: a,
                    ordertype: 3
                }, k.SendMessagePay = {
                    id: u,
                    price: l,
                    order_id: a,
                    openid: i,
                    form_id: S,
                    typeid: 3
                }, k.SendSms = {
                    order_id: a,
                    ordertype: 3
                }, app.func.payresultsms(app, r, k));
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {}
                }), r.setData({
                    isclickpay: !1
                });
            }
        }));
    },
    toAddress: function() {
        var a = this;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), a.setData({
                    address: e,
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
    }
});