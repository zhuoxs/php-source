var app = getApp();

Page({
    data: {
        hasAddress: !1,
        address: "",
        navTile: "提交订单",
        goods: [],
        rebate: [],
        firstmoney: 0,
        sincetype: "0",
        deliveryCar_price: "0",
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
        rid: 0,
        cardprice: 0,
        height: 420
    },
    onLoad: function(a) {
        var t = this;
        console.log(a);
        var e = parseFloat(a.deliveryCar_price).toFixed(2);
        t.setData({
            bid: a.bid,
            deliveryCar_price: e,
            typeid: a.typeid ? a.typeid : 0
        });
        var o = app.getSiteUrl();
        t.setData({
            url: o
        });
        var r = wx.getStorageSync("openid");
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                console.log(a.data);
                var e = t.data.choose;
                if (1 == a.data.isopen_recharge) {
                    e = e.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log("69696969696969"), console.log(e), t.setData({
                    choose: e
                }), wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "",
                    backgroundColor: a.data.color ? a.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
        t.data.rmoney, t.data.firstmoney, t.data.rmoney, r = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: r
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                console.log("vip"), console.log(a.data), t.setData({
                    viptype: a.data.viptype
                });
            }
        });
    },
    toaddlessbtn: function(a) {
        var e = this, t = e.data.goodsnum, o = a.currentTarget.dataset.ty, r = e.data.goods, s = e.data.sincetype, i = 0, n = e.data.price, d = r.limitnum - r.total, l = e.data.rebate, c = e.data.firstmoney, p = e.data.rmoney, u = e.data.deliveryfee;
        if (e.data.continuesubmit) return wx.showModal({
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
        if (i = 2 == s ? parseFloat(n * t) + parseFloat(r.ship_delivery_fee) : 3 == s ? parseFloat(n * t) + parseFloat(r.ship_express_fee) : parseFloat(n * t), 
        1 == l.firstorder_open) {
            if (1 == l.firstorder) i = n * t - (c = n * t * parseFloat(l.firstmoney / 100)) + parseFloat(u); else i = n * t - (c = parseFloat(l.firstmoney)) + parseFloat(u);
            c = c.toFixed(2);
        }
        if ((i = parseFloat(i - p)) < 0) i = 0;
        i = i.toFixed(2);
        var y = parseFloat(e.data.allowmoney);
        parseFloat(i) + parseFloat(p) < y && (i = parseFloat(i) + parseFloat(p), e.setData({
            rmoney: 0
        }));
        var g = parseFloat((r.shopprice - n) * t) + parseFloat(p) + parseFloat(c);
        g = g.toFixed(2), e.setData({
            goodsnum: t,
            totalprice: i,
            cardprice: g,
            firstmoney: c
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, a = wx.getStorageSync("deliveryInfo"), t = a.map(function(a, e) {
            return parseInt(a.gid - 0);
        }), o = a.map(function(a, e) {
            return a.num;
        }), r = "", s = "";
        t.forEach(function(a) {
            r += a + ",";
        }), o.forEach(function(a) {
            s += a + ",";
        }), app.util.request({
            url: "entry/wxapp/Psorder",
            data: {
                id: r.substring(0, r.length - 1),
                goodsnum: s.substring(0, s.length - 1),
                bid: e.data.bid,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a), e.setData({
                    deliveryInfo: a.data.goods,
                    goods: a.data.brand,
                    id: r.substring(0, r.length - 1),
                    goodsnum: s.substring(0, s.length - 1)
                });
            }
        });
    },
    getUrl: function() {
        var a = app.getSiteUrl();
        this.setData({
            url: a
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindTimeChange: function(a) {
        this.setData({
            time: a.detail.value
        });
    },
    chooseType: function(a) {
        var e = a.currentTarget.dataset.type, t = this, o = (t.data.distribution, t.data.goodsnum), r = t.data.rmoney, s = t.data.firstmoney;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var i = t.data.goods, n = 0;
        n = 2 == e ? i.ship_delivery_fee : 3 == e ? i.ship_express_fee : 0;
        var d = parseFloat(n) + parseFloat(t.data.price * o - r - s);
        if (n = 0 == n ? "0.00" : n, d < 0) d = 0;
        var l = parseFloat(t.data.allowmoney);
        parseFloat(d) + parseFloat(r) < l && (d = parseFloat(d) + parseFloat(r), t.setData({
            rmoney: 0
        })), d = d.toFixed(2), t.setData({
            totalprice: d,
            deliveryfee: n,
            sincetype: e
        });
    },
    powerDrawer: function(a) {
        var e = a.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(a) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("550rpx").step(), this.setData({
                animationData: e
            }), "close" == a && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == a && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(a) {
        var e = a.currentTarget.dataset.price, t = this.data.totalprice, o = parseFloat(t) - parseFloat(e);
        console.log(t), o < 0 && (o = 0), this.setData({
            cardprice: e,
            curprice: o
        }), this.util("close");
    },
    showModel: function(a) {
        var e = a.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: e
        });
    },
    showPay: function(a) {
        var i = this, e = (i.data.detailInfo, i.data.sincetype, i.data.deliveryCar_price), t = a.currentTarget.dataset.statu;
        if (!i.data.address) return wx.showToast({
            title: "收货地址不能为空！！！",
            icon: "none",
            duration: 2e3
        }), !1;
        i.setData({
            payStatus: t
        }), 0 < e ? i.setData({
            isshowpay: 0
        }) : i.setData({
            isshowpay: 1
        });
        var o = i.data.rid, r = i.data.open_redpacket, s = i.data.rmoney, n = i.data.totalprice, d = parseFloat(n) + parseFloat(s);
        d = d.toFixed(2), r && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), 111 == a.data && i.setData({
                    rmoney: 0,
                    totalprice: d
                });
            }
        });
        var l = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: l
            },
            success: function(a) {
                if (console.log(a.data), 2 == a.data) {
                    var e = i.data.price, t = i.data.goodsnum, o = i.data.deliveryfee, r = i.data.rmoney, s = parseFloat(e * t) + parseFloat(o) - parseFloat(r);
                    s = s.toFixed(2), i.setData({
                        rebate: [],
                        totalprice: s,
                        firstmoney: 0
                    });
                }
            }
        });
    },
    remark: function(a) {
        var e = a.detail.value;
        this.setData({
            uremark: e,
            showuremark: e
        });
    },
    radioChange: function(a) {
        var e = a.detail.value;
        this.setData({
            payType: e
        });
    },
    formSubmit: function(a) {
        var e = !0, t = "", r = this, s = wx.getStorageSync("openid"), o = r.data.payType, i = r.data.uremark, n = r.data.deliveryCar_price, d = r.data.address.userName, l = r.data.address.telNumber, c = r.data.detailInfo, p = r.data.id, u = r.data.goodsnum, y = r.data.address.provinceName + r.data.address.cityName + r.data.address.countyName + r.data.address.detailInfo, g = (r.data.typeid, 
        a.detail.formId), f = r.data.bid, h = r.data.lat, m = r.data.lng;
        if (0 < n) {
            if ("" == o && (t = "请选择支付方式"), "" == y) t = "请选择收货地址"; else {
                e = !1;
                var w = {
                    price: n,
                    id: p,
                    goodsnum: u,
                    openid: s,
                    bid: f,
                    detailInfo: c,
                    lat: h,
                    lng: m,
                    provinceName: y,
                    uremark: i,
                    name: d,
                    telNumber: l
                };
            }
            if (1 == e) return wx.showModal({
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
            var v = {
                payType: o,
                resulttype: 0,
                orderarr: "",
                SendMessagePay: "",
                PayOrder: "",
                SendSms: "",
                PayOrderurl: "entry/wxapp/PaypsOrder",
                PayredirectTourl: "/mzhk_sun/pages/user/psOrder/psOrder",
                deliveryOrder: 1
            };
            app.util.request({
                url: "entry/wxapp/AddpsOrder",
                data: w,
                success: function(a) {
                    console.log(a);
                    var e = a.data;
                    if (0 < e) {
                        r.setData({
                            order_id: e
                        }), v.orderarr = {
                            price: n,
                            openid: s,
                            order_id: e,
                            ordertype: 14
                        }, v.SendMessagePay = {
                            price: n,
                            order_id: e,
                            openid: s,
                            form_id: g,
                            typeid: 14
                        }, v.PayOrder = {
                            oid: e
                        };
                        var t = wx.getStorageSync("cars"), o = wx.getStorageSync("car_price");
                        delete t[f], delete o[f], console.log(o), wx.setStorageSync("cars", t), wx.setStorageSync("car_price", o), 
                        app.func.orderarr(app, r, v);
                    } else wx.showModal({
                        title: "提示",
                        content: "订单信息提交失败，请重新提交",
                        showCancel: !1,
                        success: function(a) {}
                    }), r.setData({
                        isclickpay: !1
                    });
                },
                fail: function(a) {
                    r.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: a.data.message,
                        showCancel: !1,
                        success: function(a) {}
                    });
                }
            });
        }
    },
    toAddress: function() {
        var t = this;
        t.data.telnum;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), console.log(e);
                var a = {};
                a.address = e.provinceName + e.cityName + e.countyName + e.detailInfo, a.bid = t.data.bid, 
                app.util.request({
                    url: "entry/wxapp/getDistanceFromAddress",
                    data: a,
                    success: function(a) {
                        0 == a.data.num ? wx.showModal({
                            title: "提示",
                            content: "超出商家配送范围"
                        }) : t.setData({
                            lat: a.data.lat,
                            lng: a.data.lng,
                            address: e,
                            telnum: e.telNumber,
                            hasAddress: !0
                        });
                    }
                });
            },
            fail: function(a) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(a) {
                                console.log("openSetting success", a.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    nowtel: function(a) {
        console.log(a);
        var e = a.detail.value;
        this.data.tel;
        this.setData({
            tel: e
        });
    },
    nowname: function(a) {
        console.log(a);
        var e = a.detail.value;
        this.setData({
            name: e
        });
    },
    nowdetailInfo: function(a) {
        console.log(a);
        var e = a.detail.value;
        this.data.tel;
        this.setData({
            detailInfo: e
        });
    },
    toPackageUse: function(a) {
        var e = this, t = a.currentTarget.dataset.id, o = e.data.price, r = e.data.totalprice, s = e.data.goodsnum, i = e.data.deliveryfee, n = e.data.sincetype, d = e.data.firstmoney;
        if (1 == e.data.typeid) var l = 1; else l = 2;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/choicePacket/choicePacket?id=" + t + "&price=" + o + "&totalprice=" + r + "&goodsnum=" + s + "&type=" + l + "&deliveryfee=" + i + "&sincetype=" + n + "&firstmoney=" + d
        });
    }
});