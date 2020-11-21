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
        show: !1,
        showModalStatus: !1,
        payType: [ {
            name: "微信支付",
            pic: "../../resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../resource/images/local.png"
        } ],
        curPay: 1,
        showCoupon: !1,
        isRequest: 0,
        flag: !1,
        coupon: {
            money: 0,
            id: 0
        },
        phoneGrant: !1,
        protect: !0,
        tabId: "1",
        address: "",
        provinceName: "",
        cityName: "",
        countyName: "",
        userName: "",
        telNumber: "",
        isTrue: "true"
    },
    onLoad: function() {
        var a = this;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(e) {
                a.setData({
                    setting: e.data,
                    tabId: (e.data.delivery_type - 0) % 2 + 1
                }), wx.setStorageSync("appConfig", e.data), a.loadDate();
            }
        });
    },
    onShow: function() {
        var e = this, a = wx.getStorageSync("userInfo"), t = wx.getStorageSync("linkaddress");
        if (t && e.setData({
            linkaddress: t
        }), a) {
            var o = a.id;
            e.setData({
                user_id: o
            }), e.loadDate();
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/classifyorder/classifyorder");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        a.tel || e.setData({
            phoneGrant: !0
        });
    },
    loadDate: function() {
        var e = this, a = getCurrentPages(), t = a[a.length - 2], o = t.data.goodses;
        console.log(o);
        for (var n = 0, s = 0, r = {}, i = 0; i < o.length; i++) {
            console.log(o[i].store_id + "-----------" + o[i].name), o[i].amount = (o[i].price * o[i].num).toFixed(2), 
            n += o[i].price * o[i].num;
            var d = wx.getStorageSync("appConfig");
            0 == d.delivery_fee_merge ? s += o[i].delivery_fee - 0 : (console.log(o[i].delivery_fee), 
            r.hasOwnProperty(o[i].store_id) ? r[o[i].store_id] < o[i].delivery_fee && (r[o[i].store_id] = o[i].delivery_fee) : Object.defineProperty(r, o[i].store_id, {
                writable: !0,
                enumerable: !0,
                configurable: !0,
                value: o[i].delivery_fee
            })), this.setData({
                merge: d.delivery_fee_merge
            });
        }
        console.log(r), Object.keys(r).forEach(function(e) {
            s += r[e] - 0;
        });
        var c = {
            show: !0,
            goodses: o,
            imgroot: t.data.imgroot,
            deliveryFeeArr: r,
            allprice: n.toFixed(2),
            allDeliveryFee: s.toFixed(2),
            delivery_single: o.length ? o[0].delivery_single : 0
        };
        1 == c.delivery_single && 2 != e.data.tabId && (c.tabId = 2), e.setData(c), e.updatePayAmount(), 
        e.getTotalPrice();
    },
    onSelfMention: function(e) {
        var a = this;
        if (e) {
            if (a.data.tabId == e.currentTarget.dataset.tabid) return !1;
            if (a.data.order_id) return wx.showModal({
                title: "提示",
                content: "点击提交之后无法再修改订单信息，如需修改，请退出当前页面，重新下单",
                success: function(e) {
                    e.confirm && wx.navigateBack({});
                }
            }), !1;
            a.setData({
                tabId: e.currentTarget.dataset.tabid
            }), a.updatePayAmount();
        }
    },
    onDelivery: function(e) {
        var a = this;
        if (e) {
            if (a.data.tabId == e.currentTarget.dataset.tabid) return !1;
            if (a.data.order_id) return wx.showModal({
                title: "提示",
                content: "点击提交之后无法再修改订单信息，如需修改，请退出当前页面，重新下单",
                success: function(e) {
                    e.confirm && wx.navigateBack({});
                }
            }), !1;
            a.setData({
                tabId: e.currentTarget.dataset.tabid
            }), a.updatePayAmount();
        }
    },
    onAddr: function() {
        var t = this;
        if (t.data.order_id) return wx.showModal({
            title: "提示",
            content: "点击提交之后无法再修改订单信息，如需修改，请退出当前页面，重新下单",
            success: function(e) {
                e.confirm && wx.navigateBack({});
            }
        }), !1;
        wx.chooseAddress({
            success: function(e) {
                var a;
                t.setData((_defineProperty(a = {
                    userName: e.userName,
                    provinceName: e.provinceName,
                    cityName: e.cityName,
                    countyName: e.countyName
                }, "userName", e.userName), _defineProperty(a, "telNumber", e.telNumber), _defineProperty(a, "address", e.provinceName + e.cityName + e.countyName + e.detailInfo), 
                a)), t.setData({
                    isTrue: !1
                });
            },
            fail: function(e) {
                console.log("用户不允许"), wx.showModal({
                    title: "位置授权确认",
                    content: "定位需要获取位置信息，请去开启位置授权",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), wx.openSetting({
                            success: function(e) {
                                console.log(e);
                            }
                        }));
                    }
                });
            }
        });
    },
    toSgjoin: function(e) {
        this.setData({
            showModalStatus: !this.data.showModalStatus
        });
    },
    changePayType: function(e) {
        this.setData({
            curPay: e.currentTarget.dataset.index
        });
    },
    getTotalPrice: function() {
        var e = this.data.allprice;
        this.setData({
            actualPrice: (e - this.data.coupon.money).toFixed(2)
        }), this.updatePayAmount();
    },
    subOrder: function(e) {
        var t = this, o = t.data.goodses, a = t.data.protect;
        if (console.log(a), a) if (t.setData({
            protect: !1
        }), app.ajax({
            url: "Index|addFormid",
            data: {
                user_id: t.data.user_id,
                form_id: e.detail.formId
            },
            success: function(e) {
                console.log(e);
            }
        }), t.data.order_id) app.ajax({
            url: "Corder|payOrder",
            data: {
                order_id: t.data.order_id
            },
            success: function(e) {
                e.other.paydata && wx.requestPayment({
                    timeStamp: e.other.paydata.timeStamp,
                    nonceStr: e.other.paydata.nonceStr,
                    package: e.other.paydata.package,
                    signType: e.other.paydata.signType,
                    paySign: e.other.paydata.paySign,
                    success: function(e) {
                        t.setData({
                            protect: !0
                        }), app.reTo("/sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess");
                    },
                    fail: function() {
                        t.setData({
                            protect: !0,
                            isRequest: 0
                        });
                    }
                });
            },
            fail: function(e) {
                t.setData({
                    protect: !0
                }), app.tips(e.data.msg);
            }
        }); else {
            var n = t.data.delivery_single ? 2 : t.data.tabId, s = [];
            for (var r in this.data.deliveryFeeArr) {
                var i = {};
                i.store_id = r, i.delivery_fee = this.data.deliveryFeeArr[r], s.push(i);
            }
            var d = {
                user_id: t.data.user_id,
                leader_id: t.data.linkaddress.id,
                amount: t.data.allprice,
                coupon_money: t.data.coupon.money,
                usercoupon_id: t.data.coupon.id,
                pay_amount: t.data.actualPrice,
                goodses: JSON.stringify(o),
                delivery_type: n,
                delivery_fee_arr: JSON.stringify(s)
            };
            if (console.log(d), 2 == d.delivery_type) {
                if (!t.data.address) return app.tips("请选择地址"), void t.setData({
                    protect: !0
                });
                var c = wx.getStorageSync("appConfig");
                d.receive_address = t.data.address, d.receive_name = t.data.userName, d.receive_tel = t.data.telNumber, 
                d.delivery_fee = t.data.allDeliveryFee, d.merge = c.delivery_fee_merge;
            }
            app.ajax({
                url: "Corder|addOrder",
                data: d,
                success: function(e) {
                    t.setData({
                        order_id: e.data
                    });
                    var a = [];
                    o.forEach(function(e) {
                        e.id && a.push(e.id);
                    }), a.length && app.ajax({
                        url: "Ccart|deleteCarts",
                        data: {
                            cart_ids: 0 < a.length ? a.join(",") : a
                        },
                        success: function(e) {
                            console.log(e);
                        }
                    }), e.other.paydata && wx.requestPayment({
                        timeStamp: e.other.paydata.timeStamp,
                        nonceStr: e.other.paydata.nonceStr,
                        package: e.other.paydata.package,
                        signType: e.other.paydata.signType,
                        paySign: e.other.paydata.paySign,
                        success: function(e) {
                            t.setData({
                                protect: !0
                            }), app.reTo("/sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess");
                        },
                        fail: function() {
                            t.setData({
                                protect: !0,
                                isRequest: 0,
                                buttonName: "继续支付"
                            });
                        }
                    });
                },
                fail: function(e) {
                    t.setData({
                        protect: !0
                    }), app.tips(e.data.msg);
                }
            });
        }
    },
    coupons: function() {
        var a = this;
        if (a.data.order_id) return wx.showModal({
            title: "提示",
            content: "点击提交之后无法再修改订单信息，如需修改，请退出当前页面，重新下单",
            success: function(e) {
                e.confirm && wx.navigateBack({});
            }
        }), !1;
        var t = a.data.allprice;
        app.ajax({
            url: "Ccoupon|getMyCoupons",
            data: {
                user_id: a.data.user_id,
                page: 1,
                limit: 100,
                state: 1
            },
            success: function(e) {
                e.data.forEach(function(e, a) {
                    0 <= t - e.use_money && (e.can_use = !0);
                }), e.data.sort(function(e, a) {
                    var t = 1e3 * (e.money - 0 + (e.can_use ? 1e3 : 0)) + (1e3 - e.use_money);
                    return 1e3 * (a.money - 0 + (a.can_use ? 1e3 : 0)) + (1e3 - a.use_money) - t;
                }), a.setData({
                    coupons: e.data,
                    flag: !0
                });
            }
        });
    },
    close: function() {
        this.setData({
            flag: !1
        });
    },
    getCoupons: function(e) {
        var a = e.currentTarget.dataset.index, t = this.data.coupons[a];
        this.setData({
            coupon: t,
            flag: !1
        }), this.getTotalPrice();
    },
    getPhoneNumber: function(t) {
        var o = this, n = wx.getStorageSync("open_id"), e = wx.getStorageSync("session_key");
        app.ajax({
            url: "Cwx|decrypt",
            data: {
                data: t.detail.encryptedData,
                iv: encodeURIComponent(t.detail.iv),
                key: e
            },
            success: function(e) {
                if (e.data || wx.login({
                    success: function(e) {
                        e.code && app.ajax({
                            url: "Cwx|getOpenid",
                            data: {
                                code: e.code
                            },
                            method: "GET",
                            success: function(e) {
                                wx.setStorageSync("session_key", e.data.session_key), wx.setStorageSync("open_id", e.data.openid), 
                                o.getPhoneNumber(t);
                            }
                        });
                    }
                }), e.data.phoneNumber) {
                    o.setData({
                        phoneGrant: !1
                    });
                    var a = {
                        openid: n,
                        tel: e.data.phoneNumber
                    };
                    app.ajax({
                        url: "Cuser|login",
                        data: a,
                        success: function(e) {
                            e.code ? app.tips(e.msg) : (wx.setStorageSync("userInfo", e.data), o.setData({
                                phoneGrant: !1
                            }));
                        }
                    });
                } else app.tips("未检测到微信绑定的手机号，请自己填写"), o.setData({
                    phoneGrant: !1
                }), setTimeout(function() {
                    app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=classfiyorder");
                }, 1500);
            }
        });
    },
    toSetphonenum: function() {
        this.setData({
            phoneGrant: !1
        }), setTimeout(function() {
            app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=classfiyorder");
        }, 300);
    },
    onPhoneTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.linkaddress.tel
        });
    },
    updatePayAmount: function() {
        var e = wx.getStorageSync("appConfig");
        console.log(e.delivery_fee_merge), console.log(this.data.deliveryFeeArr);
        var a = this, t = a.data.actualPrice - 0;
        2 != a.data.tabId && 1 != a.data.delivery_single || (t += a.data.allDeliveryFee - 0), 
        a.setData({
            payAmount: t.toFixed(2)
        });
    }
});