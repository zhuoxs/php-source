var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: {
        navTile: "提交订单",
        times: "24小时内",
        takeaddress: "厦门市集美区杏林湾路",
        contact: "13000000",
        startSince: "09:01",
        endSince: "21:01",
        sincetype: "0",
        distribution: "0.00",
        distributFee: "0.00",
        totalprice: "0",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [ {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        }, {
            price: "10",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        } ],
        showRemark: 0,
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: 0,
        payType: "",
        uremark: "",
        curremark: "",
        hasAddress: !1,
        multiArray: [],
        multiIndex: [ 0, 0 ],
        oldMultiIndex: [ 0, 0 ],
        address: {},
        isPay: 0,
        discount: 10,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var i = this;
        wx.setNavigationBarTitle({
            title: i.data.navTile
        });
        var a = tool.formatTime(new Date());
        this.setData({
            multiArray: a,
            time: a[0][0] + " " + a[1][0],
            isgroup: t.group || 0,
            iscut: t.iscut || 0,
            group_id: t.group_id,
            cut_id: t.cut_id
        }), app.get_imgroot().then(function(t) {
            i.setData({
                imgroot: t
            }), app.get_store_info().then(function(e) {
                app.get_user_info().then(function(t) {
                    i.setData({
                        store: e
                    });
                    var a = app.group_cart_get();
                    i.setData({
                        tel: t.tel,
                        cart: a,
                        takeaddress: e.address
                    }), i.totalPrice();
                });
            });
        }), app.get_card_info().then(function(t) {
            i.setData({
                discount: t && t.discount ? t.discount : 10
            });
        }), app.get_setting().then(function(t) {
            i.setData({
                setting: t
            });
        }), app.get_user_info().then(function(t) {
            i.setData({
                user: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = app.group_cart_get(), s = this;
        app.get_user_coupons().then(function(t) {
            var a = t, e = [];
            for (var i in a) parseFloat(a[i].use_amount) <= parseFloat(o.amount) && e.push(a[i]);
            s.setData({
                cards: e
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getAddress: function(t) {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetDistributionFee",
                    cachetime: "0",
                    data: {
                        store_id: a.data.store.id,
                        province: t.provinceName,
                        city: t.cityName,
                        county: t.countyName
                    },
                    success: function(t) {
                        a.setData({
                            distribution: t.data,
                            distributFee: t.data
                        }), a.totalPrice();
                    }
                }), a.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {}
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        a.multiIndex[t.detail.column] = t.detail.value, a.time = this.data.multiArray[0][this.data.multiIndex[0]] + " " + this.data.multiArray[1][this.data.multiIndex[1]], 
        this.setData(a);
    },
    dataChange: function(t) {
        var a = this.data.multiIndex;
        this.setData({
            oldMultiIndex: a
        });
    },
    dataCancel: function(t) {
        this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    },
    chooseType: function(t) {
        var a = t.currentTarget.dataset.type, e = this, i = e.data.distribution;
        "1" == a ? e.setData({
            distributFee: 0
        }) : e.setData({
            distributFee: i
        }), e.totalPrice(), e.setData({
            sincetype: a
        });
    },
    showModel: function(t) {
        var a = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.confirm, i = this, o = i.data.uremark, s = i.data.curremark;
        console.log(s, o), "true" == e ? i.setData({
            uremark: o,
            curremark: o
        }) : i.setData({
            uremark: s
        }), i.setData({
            showRemark: a
        });
    },
    showPay: function(t) {
        var a = !0, e = "", i = (n = this).data.sincetype, o = (n.data.distributFee, n.data.payType, 
        n.data.time, n.data.address), s = n.data.tel;
        n.data.uremark;
        if ("1" == i ? /^\d{9,}$/.test(s) ? a = "false" : e = "请输入自提电话" : null == o.userName ? e = "请选择收货地址" : a = "false", 
        1 != a) {
            var n, r = t.currentTarget.dataset.statu;
            (n = this).setData({
                payStatus: r
            });
        } else wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    remark: function(t) {
        var a = t.detail.value;
        if (20 < a.length) return a = a.substr(0, 20), void wx.showModal({
            title: "提示",
            content: "不得超过20字",
            showCancel: !0
        });
        this.setData({
            uremark: a
        });
    },
    tel: function(t) {
        var a = t.detail.value;
        this.setData({
            tel: a
        });
    },
    payChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(t) {
        console.log(t.detail);
        var a = !0, e = "", i = this, o = i.data.sincetype, s = i.data.distributFee, n = i.data.payType, r = i.data.time, d = i.data.tel, u = i.data.cart, c = i.data.uremark, p = i.data.curprice, l = i.data.address, m = i.data.takeaddress, y = t.detail.formId, f = i.data.isgroup, _ = i.data.iscut;
        "the formId is a mock one" != y && app.getFormid(y), "" == n ? e = "请选择支付方式" : a = !1, 
        1 != a ? app.get_user_info().then(function(t) {
            i.setData({
                isPay: ++i.data.isPay
            }), 1 == i.data.isPay ? 1 == f ? app.util.request({
                url: "entry/wxapp/AddGroupOrder",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    store_id: i.data.store.id,
                    amount: u.amount,
                    pay_amount: p,
                    pay_type: n,
                    goodses: u.goodses,
                    distribution_type: o,
                    province: l.provinceName,
                    city: l.cityName,
                    county: l.countyName,
                    address: l.detailInfo,
                    distribution_fee: s,
                    take_time: r,
                    take_tel: d,
                    memo: c,
                    take_address: m,
                    coupon_id: i.data.coupon_id,
                    group_id: i.data.group_id
                },
                success: function(t) {
                    if (console.log(t.data), 0 == t.data.code) {
                        var a = t.data.id;
                        for (var e in i.setData({
                            isPay: !0
                        }), u.goodses) {
                            u.goodses[e].id;
                            break;
                        }
                        app.pay(p, n).then(function() {
                            t.data.group_id;
                            i.paysuccess_group({
                                id: a,
                                pay_type: n,
                                pay_amount: p
                            });
                        }), app.cart_clear();
                    } else wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        showCancel: !1
                    });
                    i.setData({
                        isPay: --i.data.isPay
                    });
                }
            }) : 1 == _ ? (i.setData({
                isPay: !0
            }), app.util.request({
                url: "entry/wxapp/AddCutOrder",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    store_id: i.data.store.id,
                    amount: u.amount,
                    pay_amount: p,
                    pay_type: n,
                    goodses: u.goodses,
                    distribution_type: o,
                    province: l.provinceName,
                    city: l.cityName,
                    county: l.countyName,
                    address: l.detailInfo,
                    distribution_fee: s,
                    take_time: r,
                    take_tel: d,
                    memo: c,
                    take_address: m,
                    coupon_id: i.data.coupon_id,
                    cut_id: i.data.cut_id
                },
                success: function(t) {
                    if (console.log(t), 0 == t.data.code) {
                        t.data.id;
                        var a = function() {
                            console.log(0x605f9f6dd18bc8000), wx.showModal({
                                title: "提示",
                                content: "支付成功",
                                cancelText: "回首页",
                                confirmText: "查看订单",
                                confirmColor: "#ff640f",
                                success: function(t) {
                                    t.confirm ? wx.redirectTo({
                                        url: "/yzhyk_sun/pages/user/mybargain/mybargain?index=1"
                                    }) : wx.reLaunch({
                                        url: "/yzhyk_sun/pages/index/index"
                                    });
                                }
                            }), app.get_user_info(!1), app.get_user_coupons(!1), app.cart_clear();
                        };
                        console.log(n), "微信" == n ? (console.log(t.data.paydata), app.wx_requestPayment(t.data.paydata).then(function(t) {
                            a();
                        })) : a();
                    } else console.log(0xf6b75ab3263dd80), wx.showModal({
                        title: "提示",
                        content: "余额不足",
                        showCancel: !1
                    });
                    i.setData({
                        isPay: !1
                    });
                }
            })) : (i.setData({
                isPay: !0
            }), app.util.request({
                url: "entry/wxapp/AddOrder",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    store_id: i.data.store.id,
                    amount: u.amount,
                    pay_amount: p,
                    pay_type: n,
                    goodses: u.goodses,
                    distribution_type: o,
                    province: l.provinceName,
                    city: l.cityName,
                    county: l.countyName,
                    address: l.detailInfo,
                    distribution_fee: s,
                    take_time: r,
                    take_tel: d,
                    memo: c,
                    take_address: m,
                    coupon_id: i.data.coupon_id
                },
                success: function(t) {
                    if (console.log(t.data), 0 == t.data.code) {
                        t.data.id;
                        var a = function() {
                            wx.showModal({
                                title: "提示",
                                content: "支付成功",
                                cancelText: "回首页",
                                confirmText: "查看订单",
                                confirmColor: "#ff640f",
                                success: function(t) {
                                    t.confirm ? wx.redirectTo({
                                        url: "/yzhyk_sun/pages/user/myorder/myorder"
                                    }) : wx.reLaunch({
                                        url: "/yzhyk_sun/pages/index/index"
                                    });
                                }
                            }), app.get_user_info(!1), app.get_user_coupons(!1), app.cart_clear();
                        };
                        "微信" == n ? app.wx_requestPayment(t.data.paydata).then(function(t) {
                            a();
                        }) : a();
                    } else wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        showCancel: !1
                    });
                    i.setData({
                        isPay: !1
                    });
                }
            })) : wx.showToast({
                title: "正在支付中...",
                icon: "none"
            });
        }) : wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    totalPrice: function(t) {
        var a = this, e = a.data.cardprice, i = a.data.distributFee, o = a.data.discount, s = a.data.discountType || 0, n = parseFloat(a.data.cart.amount), r = n;
        r = 1 == s ? n - parseFloat(e) + parseFloat(i) : 2 == s ? n * parseFloat(o) / 10 + parseFloat(i) : n + parseFloat(i), 
        (r = parseFloat(r).toFixed(2)) <= 0 && (r = 0), r = parseFloat(r).toFixed(2), a.setData({
            curprice: r
        });
    },
    paysuccess_group: function(a) {
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/PayGroupOrder",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    id: a.id,
                    pay_type: a.pay_type,
                    pay_amount: a.pay_amount
                },
                success: function(t) {
                    if (0 == t.data.code) {
                        var a = t.data.group_id;
                        wx.showModal({
                            title: "提示",
                            content: "支付成功",
                            cancelText: "拼团详情",
                            confirmText: "查看订单",
                            confirmColor: "#ff640f",
                            success: function(t) {
                                t.confirm ? wx.redirectTo({
                                    url: "/yzhyk_sun/pages/user/mygroup/mygroup"
                                }) : wx.reLaunch({
                                    url: "../groupjoin/groupjoin?id=" + a
                                });
                            }
                        }), app.get_user_info(!1);
                    } else wx.showModal({
                        title: "提示",
                        content: t.data.msg
                    });
                }
            });
        });
    },
    toMember: function(t) {
        wx.redirectTo({
            url: "/yzhyk_sun/pages/index/member/member"
        });
    }
});