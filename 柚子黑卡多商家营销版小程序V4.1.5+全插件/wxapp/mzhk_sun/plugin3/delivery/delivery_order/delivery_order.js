/*   time:2019-08-09 13:18:48*/
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
        choose: [{
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        }],
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
        shiptypetitle: ["", "到店消费", "送货上门", "快递"],
        tel: "",
        telnum: "",
        isclickpay: !1,
        goodsnum: 1,
        rmoney: 0,
        rid: 0,
        cardprice: 0,
        height: 420,
        price_show: !1
    },
    onLoad: function(e) {
        var t = this;
        console.log(e);
        var a = parseFloat(e.deliveryCar_price).toFixed(2);
        t.setData({
            bid: e.bid,
            deliveryCar_price: a,
            typeid: e.typeid ? e.typeid : 0,
            base_price: a
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
            success: function(e) {
                console.log(e.data);
                var a = t.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([{
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    }])
                }
                console.log("69696969696969"), console.log(a), t.setData({
                    choose: a
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
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
            success: function(e) {
                console.log("vip"), console.log(e.data), t.setData({
                    viptype: e.data.viptype
                })
            }
        })
    },
    toaddlessbtn: function(e) {
        var a = this,
            t = a.data.goodsnum,
            o = e.currentTarget.dataset.ty,
            r = a.data.goods,
            s = a.data.sincetype,
            i = 0,
            n = a.data.price,
            d = r.limitnum - r.total,
            c = a.data.rebate,
            l = a.data.firstmoney,
            p = a.data.rmoney,
            u = a.data.deliveryfee;
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
            t = parseInt(t) + 1
        } else t = parseInt(t) + 1;
        else 1 < t && (t = parseInt(t) - 1);
        if (i = 2 == s ? parseFloat(n * t) + parseFloat(r.ship_delivery_fee) : 3 == s ? parseFloat(n * t) + parseFloat(r.ship_express_fee) : parseFloat(n * t), 1 == c.firstorder_open) {
            if (1 == c.firstorder) i = n * t - (l = n * t * parseFloat(c.firstmoney / 100)) + parseFloat(u);
            else i = n * t - (l = parseFloat(c.firstmoney)) + parseFloat(u);
            l = l.toFixed(2)
        }
        if ((i = parseFloat(i - p)) < 0) i = 0;
        i = i.toFixed(2);
        var y = parseFloat(a.data.allowmoney);
        parseFloat(i) + parseFloat(p) < y && (i = parseFloat(i) + parseFloat(p), a.setData({
            rmoney: 0
        }));
        var g = parseFloat((r.shopprice - n) * t) + parseFloat(p) + parseFloat(l);
        g = g.toFixed(2), a.setData({
            goodsnum: t,
            totalprice: i,
            cardprice: g,
            firstmoney: l
        })
    },
    onReady: function() {},
    onShow: function() {
        var a = this,
            e = wx.getStorageSync("deliveryInfo"),
            t = e.map(function(e, a) {
                return parseInt(e.gid - 0)
            }),
            o = e.map(function(e, a) {
                return e.num
            }),
            r = "",
            s = "";
        t.forEach(function(e) {
            r += e + ","
        }), o.forEach(function(e) {
            s += e + ","
        }), app.util.request({
            url: "entry/wxapp/Psorder",
            data: {
                id: r.substring(0, r.length - 1),
                goodsnum: s.substring(0, s.length - 1),
                bid: a.data.bid,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log(e), a.setData({
                    deliveryInfo: e.data.goods,
                    goods: e.data.brand,
                    id: r.substring(0, r.length - 1),
                    goodsnum: s.substring(0, s.length - 1)
                })
            }
        })
    },
    getUrl: function() {
        var e = app.getSiteUrl();
        this.setData({
            url: e
        })
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindTimeChange: function(e) {
        this.setData({
            time: e.detail.value
        })
    },
    chooseType: function(e) {
        var a = e.currentTarget.dataset.type,
            t = this,
            o = (t.data.distribution, t.data.goodsnum),
            r = t.data.rmoney,
            s = t.data.firstmoney;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var i = t.data.goods,
            n = 0;
        n = 2 == a ? i.ship_delivery_fee : 3 == a ? i.ship_express_fee : 0;
        var d = parseFloat(n) + parseFloat(t.data.price * o - r - s);
        if (n = 0 == n ? "0.00" : n, d < 0) d = 0;
        var c = parseFloat(t.data.allowmoney);
        parseFloat(d) + parseFloat(r) < c && (d = parseFloat(d) + parseFloat(r), t.setData({
            rmoney: 0
        })), d = d.toFixed(2), t.setData({
            totalprice: d,
            deliveryfee: n,
            sincetype: a
        })
    },
    powerDrawer: function(e) {
        var a = e.currentTarget.dataset.statu;
        this.util(a)
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
            })
        }.bind(this), 200), "open" == e && this.setData({
            showModalStatus: !0
        })
    },
    coupon: function(e) {
        var a = e.currentTarget.dataset.price,
            t = this.data.totalprice,
            o = parseFloat(t) - parseFloat(a);
        console.log(t), o < 0 && (o = 0), this.setData({
            cardprice: a,
            curprice: o
        }), this.util("close")
    },
    showModel: function(e) {
        var a = e.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: a
        })
    },
    showPay: function(e) {
        var i = this,
            a = (i.data.detailInfo, i.data.sincetype, i.data.deliveryCar_price),
            t = e.currentTarget.dataset.statu;
        if (!i.data.address) return wx.showToast({
            title: "收货地址不能为空！！！",
            icon: "none",
            duration: 2e3
        }), !1;
        i.setData({
            payStatus: t
        }), 0 < a ? i.setData({
            isshowpay: 0
        }) : i.setData({
            isshowpay: 1
        });
        var o = i.data.rid,
            r = i.data.open_redpacket,
            s = i.data.rmoney,
            n = i.data.totalprice,
            d = parseFloat(n) + parseFloat(s);
        d = d.toFixed(2), r && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(e) {
                console.log(e.data), 111 == e.data && i.setData({
                    rmoney: 0,
                    totalprice: d
                })
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
                    var a = i.data.price,
                        t = i.data.goodsnum,
                        o = i.data.deliveryfee,
                        r = i.data.rmoney,
                        s = parseFloat(a * t) + parseFloat(o) - parseFloat(r);
                    s = s.toFixed(2), i.setData({
                        rebate: [],
                        totalprice: s,
                        firstmoney: 0
                    })
                }
            }
        })
    },
    remark: function(e) {
        var a = e.detail.value;
        this.setData({
            uremark: a,
            showuremark: a
        })
    },
    radioChange: function(e) {
        var a = e.detail.value;
        this.setData({
            payType: a
        })
    },
    formSubmit: function(e) {
        var a = !0,
            t = "",
            r = this,
            s = wx.getStorageSync("openid"),
            o = r.data.payType,
            i = r.data.uremark,
            n = r.data.deliveryCar_price,
            d = r.data.address.userName,
            c = r.data.address.telNumber,
            l = r.data.detailInfo,
            p = r.data.id,
            u = r.data.goodsnum,
            y = r.data.address.provinceName + r.data.address.cityName + r.data.address.countyName + r.data.address.detailInfo,
            g = (r.data.typeid, e.detail.formId),
            f = r.data.bid,
            h = r.data.ps_price.lat,
            m = r.data.ps_price.lng;
        if (0 < n) {
            if ("" == o && (t = "请选择支付方式"), "" == y) t = "请选择收货地址";
            else {
                a = !1;
                var w = {
                    price: n,
                    id: p,
                    goodsnum: u,
                    openid: s,
                    bid: f,
                    detailInfo: l,
                    lat: h,
                    lng: m,
                    provinceName: y,
                    uremark: i,
                    name: d,
                    telNumber: c
                }
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
            var v = {
                payType: o,
                resulttype: 0,
                orderarr: "",
                SendMessagePay: "",
                PayOrder: "",
                SendSms: "",
                PayOrderurl: "entry/wxapp/PaypsOrder",
                PayredirectTourl: "/mzhk_sun/plugin3/delivery/psOrder/psOrder",
                deliveryOrder: 1
            };
            app.util.request({
                url: "entry/wxapp/AddpsOrder",
                data: w,
                success: function(e) {
                    console.log(e);
                    var a = e.data;
                    if (0 < a) {
                        r.setData({
                            order_id: a
                        }), v.orderarr = {
                            price: n,
                            openid: s,
                            order_id: a,
                            ordertype: 14
                        }, v.SendMessagePay = {
                            price: n,
                            order_id: a,
                            openid: s,
                            form_id: g,
                            typeid: 14
                        }, v.PayOrder = {
                            oid: a
                        };
                        var t = wx.getStorageSync("cars"),
                            o = wx.getStorageSync("car_price");
                        delete t[f], delete o[f], console.log(o), wx.setStorageSync("cars", t), wx.setStorageSync("car_price", o), app.func.orderarr(app, r, v)
                    } else wx.showModal({
                        title: "提示",
                        content: "订单信息提交失败，请重新提交",
                        showCancel: !1,
                        success: function(e) {}
                    }), r.setData({
                        isclickpay: !1
                    })
                },
                fail: function(e) {
                    r.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: e.data.message,
                        showCancel: !1,
                        success: function(e) {}
                    })
                }
            })
        }
    },
    toAddress: function() {
        var o = this;
        o.data.telnum;
        wx.chooseAddress({
            success: function(t) {
                console.log("获取地址成功"), console.log(t);
                var e = {};
                e.address = t.provinceName + t.cityName + t.countyName + t.detailInfo, e.bid = o.data.bid, app.util.request({
                    url: "entry/wxapp/getDistanceFromAddress",
                    data: e,
                    success: function(e) {
                        if (0 == e.data.num) wx.showModal({
                            title: "提示",
                            content: "超出商家配送范围"
                        }), o.setData({
                            juli: e.data.juli
                        }), setTimeout(function() {
                            o.setData({
                                price_show: !0
                            })
                        }, 2e3);
                        else {
                            var a = parseFloat(o.data.base_price).toFixed(2);
                            a - 0 < e.data.delivery_start - 0 ? (wx.showToast({
                                title: "购物车价格未达到起配价",
                                icon: "none",
                                duration: 2e3
                            }), o.setData({
                                juli: e.data.juli
                            }), setTimeout(function() {
                                o.setData({
                                    price_show: !0
                                })
                            }, 2e3)) : (a - 0 < e.data.delivery_free - 0 && (console.log(111), a = parseFloat(e.data.delivery_price - 0 + (a - 0)).toFixed(2)), console.log(a), o.setData({
                                ps_price: e.data,
                                address: t,
                                telnum: t.telNumber,
                                hasAddress: !0,
                                deliveryCar_price: a
                            }))
                        }
                    }
                })
            },
            fail: function(e) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting)
                            }
                        }))
                    }
                })
            }
        })
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting()
    },
    nowtel: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.data.tel;
        this.setData({
            tel: a
        })
    },
    nowname: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.setData({
            name: a
        })
    },
    nowdetailInfo: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.data.tel;
        this.setData({
            detailInfo: a
        })
    },
    toPackageUse: function(e) {
        var a = this,
            t = e.currentTarget.dataset.id,
            o = a.data.price,
            r = a.data.totalprice,
            s = a.data.goodsnum,
            i = a.data.deliveryfee,
            n = a.data.sincetype,
            d = a.data.firstmoney;
        if (1 == a.data.typeid) var c = 1;
        else c = 2;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/choicePacket/choicePacket?id=" + t + "&price=" + o + "&totalprice=" + r + "&goodsnum=" + s + "&type=" + c + "&deliveryfee=" + i + "&sincetype=" + n + "&firstmoney=" + d
        })
    },
    closeGroup: function() {
        this.setData({
            price_show: !1,
            juli: ""
        })
    },
    openGroup: function() {
        this.setData({
            price_show: !0,
            juli: ""
        })
    }
});