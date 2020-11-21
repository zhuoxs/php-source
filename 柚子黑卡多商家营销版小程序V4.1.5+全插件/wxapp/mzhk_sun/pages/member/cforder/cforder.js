var app = getApp();

Page({
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        rebate: [],
        firstmoney: 0,
        isshowpay: 0,
        showuremark: "20字以内",
        sincetype: "0",
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
        rmoney: 0,
        rid: 0,
        goodsnum: 1
    },
    onLoad: function(e) {
        var t = this;
        if (console.log(e), 1 == e.redtype) {
            var a = e.rmoney, o = e.rid, i = parseFloat(e.totalprice);
            i = i.toFixed(2);
            var r = e.allowmoney, s = e.goodsnum, n = e.deliveryfee, d = e.sincetype;
            t.setData({
                rmoney: a,
                rid: o,
                totalprice: i,
                goodsnum: s,
                allowmoney: r,
                deliveryfee: n,
                sincetype: d
            });
        }
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var c = app.getSiteUrl();
        c ? t.setData({
            url: c
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), c = e.data, t.setData({
                    url: c
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var a = t.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
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
                t.setData({
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
                console.log(e), t.setData({
                    open_lottery: e.data.is_openzx
                });
            }
        }), t.setData({
            id: e.id,
            price: e.price
        });
    },
    onReady: function() {
        var e = wx.getStorageSync("openid"), s = this, n = s.data.rmoney, d = s.data.firstmoney;
        app.util.request({
            url: "entry/wxapp/Cforder",
            method: "GET",
            data: {
                id: s.data.id,
                price: s.data.price,
                openid: e
            },
            success: function(e) {
                console.log(e);
                var a, t = e.data.ship_type[0];
                if (0 < e.data.nowprice ? (console.log("nowprice"), a = e.data.nowprice) : (console.log("price"), 
                a = s.data.price), 2 == t) {
                    r = parseFloat(a) + parseFloat(e.data.ship_delivery_fee);
                    var o = e.data.ship_delivery_fee;
                } else if (3 == t) {
                    r = parseFloat(a) + parseFloat(e.data.ship_express_fee);
                    o = e.data.ship_express_fee;
                } else {
                    r = parseFloat(a);
                    o = "0.00";
                }
                r = (r = parseFloat(r - n)).toFixed(2);
                var i = parseFloat(e.data.shopprice - a) + parseFloat(n) + parseFloat(d);
                if (i = i.toFixed(2), 0 < n) {
                    var r = s.data.totalprice;
                    t = s.data.sincetype, t = s.data.sincetype, o = s.data.deliveryfee;
                }
                if (r < 0) r = 0;
                s.setData({
                    goods: e.data,
                    totalprice: r,
                    price: s.data.price,
                    deliveryfee: o,
                    cardprice: i,
                    sincetype: t,
                    tel: e.data.telnumber ? e.data.telnumber : "",
                    cjid: e.data.cjid,
                    iscj: e.data.iscj,
                    gid: e.data.gid
                }), s.getUrl();
            }
        });
        e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: e
            },
            success: function(e) {
                if (console.log(e.data), 2 != e.data) {
                    var a = s.data.totalprice ? s.data.totalprice : s.data.price;
                    console.log(a);
                    var t = s.data.price;
                    if (1 == e.data.firstorder) a = a - (o = parseFloat(t) * parseFloat(e.data.firstmoney / 100)); else {
                        var o = parseFloat(e.data.firstmoney);
                        a = parseFloat(a - o);
                    }
                    if (console.log(a), a = parseFloat(a - n), 0 < n && (a = parseFloat(s.data.totalprice)), 
                    a = a.toFixed(2), o = o.toFixed(2), console.log(a), a < 0) a = 0;
                    s.setData({
                        rebate: e.data,
                        totalprice: a,
                        firstmoney: o
                    });
                } else s.setData({
                    rebate: []
                });
            }
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
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
    onReachBottom: function() {},
    bindTimeChange: function(e) {
        this.setData({
            time: e.detail.value
        });
    },
    chooseType: function(e) {
        var a = e.currentTarget.dataset.type, t = this, o = (t.data.distribution, t.data.rmoney), i = t.data.firstmoney;
        if (t.data.continuesubmit) return wx.showModal({
            title: "提示",
            content: "点击付款之后无法再修改配送方式；如需修改，请退出该页面重新下单",
            showCancel: !1
        }), !1;
        var r = t.data.goods, s = 0;
        s = 2 == a ? r.ship_delivery_fee : 3 == a ? r.ship_express_fee : 0;
        var n = parseFloat(s) + parseFloat(t.data.price) - parseFloat(o) - parseFloat(i);
        s = 0 == s ? "0.00" : s;
        var d = parseFloat(t.data.allowmoney);
        parseFloat(n) + parseFloat(o) < d && (n = parseFloat(n) + parseFloat(o), t.setData({
            rmoney: 0
        })), n = n.toFixed(2), t.setData({
            totalprice: n,
            deliveryfee: s,
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
        var r = this, a = r.data.tel, t = r.data.telnum;
        if (1 != r.data.sincetype) {
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
        var o = e.currentTarget.dataset.statu, i = r.data.totalprice;
        r.setData({
            payStatus: o
        }), 0 < i ? r.setData({
            isshowpay: 0
        }) : r.setData({
            isshowpay: 1
        });
        var s = r.data.rid, n = r.data.open_redpacket, d = r.data.rmoney, c = r.data.totalprice, l = parseFloat(c) + parseFloat(d);
        l = l.toFixed(2), n && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: s,
                m: app.globalData.Plugin_redpacket
            },
            success: function(e) {
                console.log(e.data), 111 == e.data && r.setData({
                    rmoney: 0,
                    totalprice: l
                });
            }
        });
        var p = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Firstbuy",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: p
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) {
                    var a = r.data.price, t = r.data.deliveryfee, o = r.data.rmoney, i = parseFloat(a) + parseFloat(t) - parseFloat(o);
                    i = i.toFixed(2), r.setData({
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
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(e) {
        var a = !0, t = "", o = this, i = wx.getStorageSync("openid"), r = o.data.sincetype, s = (o.data.distributFee, 
        o.data.deliveryfee), n = o.data.payType, d = o.data.time, c = o.data.uremark, l = o.data.shiptypetitle[r], p = (i = wx.getStorageSync("openid"), 
        e.detail.value.price), u = e.detail.value.id, y = e.detail.value.name, m = e.detail.value.tel, f = e.detail.value.count, g = e.detail.value.city, h = e.detail.value.detai, w = e.detail.value.province, v = e.detail.value.telnum, x = o.data.rid, F = o.data.firstmoney, k = o.data.rmoney, D = o.data.price, _ = e.detail.formId;
        if (0 < p) {
            if ("1" == r) if (m && "" != m) if ("" == n) t = "请选择支付方式"; else {
                a = !1;
                var S = {
                    price: p,
                    id: u,
                    openid: i,
                    uremark: c,
                    time: d,
                    telNumber: m,
                    sincetype: l,
                    payType: n,
                    rid: x,
                    firstmoney: F,
                    rmoney: k,
                    goodsprice: D
                };
            } else t = "请输入正确的消费电话号码"; else if ("" == n && (t = "请选择支付方式"), "" == y) t = "请选择收货地址"; else {
                a = !1;
                S = {
                    price: p,
                    id: u,
                    openid: i,
                    uremark: c,
                    cityName: g,
                    detailInfo: h,
                    telNumber: v,
                    countyName: f,
                    name: y,
                    sincetype: l,
                    provinceName: w,
                    deliveryfee: s,
                    paytype: n,
                    rid: x,
                    firstmoney: F,
                    rmoney: k,
                    goodsprice: D
                };
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
            var T = o.data.continuesubmit, b = o.data.order_id, P = {
                payType: n,
                resulttype: 0,
                orderarr: "",
                SendMessagePay: "",
                PayOrder: "",
                SendSms: "",
                PayOrderurl: "entry/wxapp/PaykjOrder",
                PayredirectTourl: "/mzhk_sun/pages/user/mybargain/mybargain?id=" + u
            };
            T && 0 < b ? (console.log("正在执行继续支付"), P.orderarr = {
                price: p,
                openid: i,
                order_id: b,
                ordertype: 5,
                rid: x
            }, P.SendMessagePay = {
                id: u,
                price: p,
                order_id: b,
                openid: i,
                form_id: _,
                typeid: 5,
                rid: x
            }, P.PayOrder = {
                order_id: b,
                openid: i
            }, app.func.orderarr(app, o, P)) : (console.log("正在执行新支付"), app.util.request({
                url: "entry/wxapp/AddkjOrder",
                data: S,
                success: function(e) {
                    console.log(e);
                    var a = e.data;
                    0 < a ? (o.setData({
                        order_id: a
                    }), P.orderarr = {
                        price: p,
                        openid: i,
                        order_id: a,
                        ordertype: 5,
                        rid: x
                    }, P.SendMessagePay = {
                        id: u,
                        price: p,
                        order_id: a,
                        openid: i,
                        form_id: _,
                        typeid: 5,
                        rid: x
                    }, P.PayOrder = {
                        order_id: a,
                        openid: i
                    }, app.func.orderarr(app, o, P)) : (wx.showModal({
                        title: "提示",
                        content: "订单信息提交失败，请重新提交",
                        showCancel: !1,
                        success: function(e) {}
                    }), o.setData({
                        isclickpay: !1
                    }));
                },
                fail: function(e) {
                    wx.showModal({
                        title: "提示信息",
                        content: e.data.message,
                        showCancel: !1,
                        success: function(e) {}
                    }), o.setData({
                        isclickpay: !1
                    });
                }
            }));
        } else {
            n = 3;
            if ("1" == r) if (m && "" != m) S = {
                price: p,
                id: u,
                openid: i,
                uremark: c,
                time: d,
                rid: x,
                telNumber: m,
                sincetype: l,
                payType: n,
                firstmoney: F,
                rmoney: k,
                goodsprice: D
            }; else t = "请输入正确的消费电话号码"; else if ("" == y) t = "请选择收货地址"; else S = {
                price: p,
                id: u,
                openid: i,
                uremark: c,
                cityName: g,
                detailInfo: h,
                rid: x,
                telNumber: v,
                countyName: f,
                name: y,
                sincetype: l,
                provinceName: w,
                deliveryfee: s,
                paytype: n,
                firstmoney: F,
                rmoney: k,
                goodsprice: D
            };
            app.util.request({
                url: "entry/wxapp/AddKjZeroOrder",
                data: S,
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
        var a = this, t = e.currentTarget.dataset.id, o = a.data.price, i = a.data.totalprice, r = a.data.deliveryfee, s = a.data.sincetype, n = a.data.firstmoney;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/choicePacket/choicePacket?id=" + t + "&price=" + o + "&totalprice=" + i + "&goodsnum=1&type=5&deliveryfee=" + r + "&sincetype=" + s + "&firstmoney=" + n
        });
    }
});